<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class TokenController extends Controller
{
    /**
 * Get the authenticated user's details along with their roles.
 *
 * @param \Illuminate\Http\Request $request The incoming request.
 *
 * @return \Illuminate\Http\JsonResponse The response containing the user details and roles.
 */
    public function user(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
        
        return response()->json([
            "success" => true,
            "user"    => $request->user(),
            // "roles"   => $user->getRoleNames(),
        ]);
    }

    /**
 * Authenticate a user based on email and password and generate an access token for them.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing the user's email and password.
 *
 * @return \Illuminate\Http\JsonResponse The response containing the authentication token or an error message.
 */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Get user
            $user = User::where([
                ["email", "=", $credentials["email"]]
            ])->firstOrFail();
            // Revoke all old tokens
            $user->tokens()->delete();
            // Generate new token
            $token = $user->createToken("authToken")->plainTextToken;
            // Token response
            return response()->json([
                "success"   => true,
                "authToken" => $token,
                "tokenType" => "Bearer"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }
    }

    /**
 * Create a new user account and generate an access token for them.
 *
 * @param \Illuminate\Http\Request $request The incoming request containing the user's name, email, and password.
 *
 * @return \Illuminate\Http\JsonResponse The response containing the authentication token or an error message.
 */

    public function register(Request $request)
    {

        $credentials = $request->validate([
            'name'  => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
  
        ]);

        // $user->assignRole('author');

        // Generate new token
        $token = $user->createToken("authToken")->plainTextToken;
        // Token response
        return response()->json([
            "success"   => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);

    }

    /**
 * Revoke the current user's access token to log them out.
 *
 * @param \Illuminate\Http\Request $request The incoming request.
 *
 * @return \Illuminate\Http\JsonResponse The response indicating a successful logout.
 */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            "success"   => true,
            "message" => "Log out correctly",

        ]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}