<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//@todo pagination
        return response()->json(['data' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! $user = app(\App\Services\UserService::class)
                ->create($request->all())
        ) {
            throw new \Exception('Failed to create user.');
        }

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        if (! app(\App\Services\UserService::class)
                 ->update($user, $request->all(), $request->method())
        ) {
            throw new \Exception('Failed to update user '.$user->id);
        }

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (! $user->delete()) {
            throw new \Exception("Unable to delete user");
        }

        return response('', 204);
    }
}
