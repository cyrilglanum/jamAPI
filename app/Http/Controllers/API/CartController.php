<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Route;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::query()->paginate(10);

        return CartResource::collection($cart);
    }

//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(UserStoreRequest $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return new CartResource($cart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json();
    }
}
