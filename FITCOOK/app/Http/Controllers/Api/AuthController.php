<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Create and save the new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    /**
     * Login the user and generate a token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        // User authenticated successfully, generate and return the token
        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Logout the user (revoke the token).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }
}
