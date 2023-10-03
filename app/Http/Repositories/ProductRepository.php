<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
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

    public function getProductsSearched(string $name): LengthAwarePaginator
    {
        if ($name === "") {
            return Product::query()
                ->with('categories')
                ->paginate(10);
        }

        return Product::query()
            ->with('categories')
            ->where('name', "LIKE", '%' . $name . '%')
            ->paginate(10);
    }

    public function getProductsByCriterion(string $name, array $price, array $type, string $orderBy): LengthAwarePaginator
    {
        if (!empty($price) && (int)$price[0] != false) {
            $priceMin = (int)$price[0];
            $priceMax = (int)$price[1];
        }

        $tabType = [];

        if (!empty($type)) {
            foreach ($type as $key => $item) {
                if($item === "on")
                $tabType[] = $key + 1;
            }
        }

        $query = Product::query()->with('categories');

        if (isset($name) && $name !== "" && $name !== "false") {
            $query = $query->where('name', "LIKE", '%' . $name . '%');
        }

        if (isset($priceMin) && $priceMin) {
            $query = $query->where('price', '>', $priceMin);
        }

        if (isset($priceMax) && $priceMax) {
            $query = $query->where('price', '<', $priceMax);
        }

        $query->get();

        if ($orderBy !== "false") {
            if(str_starts_with($orderBy, "prix")){
                $column = 'price';
            }else{
                $column = 'name';
            }
            $direction = substr($orderBy, 4 ,4);
            $query = $query->orderBy($column, $direction);
        }

        $finalTab = [];

        //Récupération des produits s'ils sont du type coché.
        if (!empty($tabType)) {
            foreach ($query->get() as $product) {
                foreach ($product->categories as $category) {
                    if (in_array($category->id, $tabType)) {
                        $finalTab[] = $product;
                    }
                }
            }
        }

        if (!empty($finalTab)) {
            return new LengthAwarePaginator(collect($finalTab), 100, 10);
        }

        return $query->paginate(10);
    }
}
