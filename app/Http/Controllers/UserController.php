<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function __construct()
    {
        // Functions inside the authentication controller can not be accessed without having the valid token.
        $this->middleware('jwt');
    }

    public function index()
    {
        $categories = User::all();

        if (!$categories) {
            return response()->json([
                'error' => 'Categories not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return response with message and data
        return response()->json([
            'categories' => $categories
        ], Response::HTTP_OK);
    }

    public function show($uuid)
    {
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return response()->json([
                'error' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function update(UserRequest $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return response()->json([
                'error' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //validate data
        $data = $request->validated();

        // Update the user data
        $user->update($data);

        //Return response with message and data
        return response()->json([
            'success' => 'User updated successfully!'
        ], Response::HTTP_OK);
    }

    public function destroy($uuid)
    {
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return response()->json([
                'error' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        //  Delete the user
        $user->delete();

        // Return response with message
        return response()->json([
            'success' => 'Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}
