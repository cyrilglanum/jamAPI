<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->with('orders')->paginate(10);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {
        if(!Auth::user()->isAdmin()){
            Route::fallback(function(){
                return response()->json([
                    'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
            });
        }

        try {
            $this->validate($request, [
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4'
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json($user->name ." have been updated");

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json();
    }
}
