<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\ProductInterface;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductCriterionController extends Controller
{

    public function __construct(protected ProductInterface $productInterface)
    {}
    /**
     * Display the specified resource.
     */
    public function searchProduct(string $name): JsonResponse|AnonymousResourceCollection
    {
        try{
            return ProductResource::collection($this->productInterface->getProductsSearched($name));
        } catch (Exception $e) {
            report($e);
            return response()->json([], 503);
        }
    }

    public function ProductsByCriterion($name, $price, $type, $orderBy): JsonResponse|AnonymousResourceCollection
    {
        $tabPrice = explode('-', $price);
        $tabType = explode('-', $type);

        try{
            return ProductResource::collection($this->productInterface->getProductsByCriterion($name, $tabPrice, $tabType, $orderBy));
        } catch (Exception $e) {
            report($e);
            return response()->json([], 503);
        }
    }

}
