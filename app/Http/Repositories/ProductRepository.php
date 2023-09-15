<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductInterface
{
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::query()
            ->with('category:id,nom')
            ->with('properties')
            ->paginate(10);
    }

    public function getProduct(string $name): Model
    {
        return Product::query()
            ->with('categories')
            ->where('name', $name)
            ->first();
    }

    public function getProductsByCriterion(string $name, array $price, array $type, string $orderBy): LengthAwarePaginator
    {
        // TODO controler que le prix n'est pas égal à null et mettre par défaut un tableau initialisé
        if (!empty($price)) {
            $priceMin = $price[0];
            $priceMax = $price[1];
        }

        $tabType = [];

        if (!empty($type)) {
            foreach ($type as $key => $item) {
                $tabType[] = $item;
            }
        }

        $query = Product::query()->with('categories');

        if (isset($name) && (int)$name && !is_null($name)) {
            $query = $query->where('name', $name);
        }
        if (isset($priceMin) && $priceMin && !is_null($priceMin)) {
            $query = $query->where('price', '>', $priceMin);
        }
        if (isset($priceMax) && $priceMax && !is_null($priceMax)) {
            $query = $query->where('price', '<', $priceMax);
        }
        if (isset($orderBy) && (int)$orderBy && !is_null($orderBy)) {
            $query = $query->where('name', $orderBy);
        }

        $finalTab = [];

        //Récupération des produits s'ils sont du type coché.
        if (isset($tabType) && $tabType && !empty($tabType)) {
            foreach ($query->get() as $product) {
                foreach ($product->categories as $category) {
                    if (in_array($category->id, $tabType)) {
                        $finalTab[] = $product;
                    }
                }
            }
        }

        if(!empty($finalTab)){
            return new LengthAwarePaginator(collect($finalTab), 100, 10);
        }

        return $query->paginate(10);
    }
}
