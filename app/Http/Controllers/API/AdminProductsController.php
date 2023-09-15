<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Route;

class AdminProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse|AnonymousResourceCollection
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        $products = Product::query()->with('categories')->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse|ProductResource
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): JsonResponse|string
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        try {
            $this->validate($request, [
                'name' => 'required|max:100',
                'description' => 'nullable',
                'image' => 'nullable',
                'price' => 'required|int'
            ]);

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'price' => $request->price
            ]);

            return response()->json($product->name ." have been updated");

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        $product->delete();

        return response()->json();
    }
}
