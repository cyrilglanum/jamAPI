<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Route;

class AdminOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        $orders = Cart::query()->paginate(10);

        return OrderResource::collection($orders);
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
    public function show(Order $orders): JsonResponse|OrderResource
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        return new OrderResource($orders);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $orders)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $orders)
    {
        if($this->isNotAdmin()){
            return response()->json([
                'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
        }

        $orders->delete();

        return response()->json();
    }
}
