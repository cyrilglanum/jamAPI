<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Route;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        $users = User::query()->count();
        $carts = Cart::query()->count();
        $orders = Order::query()->count();
        $categories = Category::query()->count();
        $products = Product::query()->count();

        $array = ['users' => $users, 'carts' => $carts, 'orders' => $orders,'categories' => $categories, 'products' => $products];

        return response()->json($array);
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
    public function show(Model $model)
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        return null;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        $user->delete();

        return response()->json();
    }
}
