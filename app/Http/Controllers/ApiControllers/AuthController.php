<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class AuthController extends Controller
{
    /**
     * User registration method
     */
    public function register(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'firstname' => 'required|string|max:255|unique:users',
            'lastname' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);
        if ($validate->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Please provide correct details',
                    'errors' => $validate->errors()
                ],
                400
            );
        }
        User::create([
	            'firstname' => $request->input('firstname'),
	            'lastname' => $request->input('lastname'),
	            'email' => $request->input('email'),
	            'phone' => $request->input('phone'),
	            'password' => bcrypt($request->input('password')),
	        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully registered'
        ]);
    }

    /**
     * Authenticate user and issue an access token
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $validate = \Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);
        if ($validate->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Please provide correct details',
                    'errors' => $validate->errors()
                ],
                400
            );
        }
        $auth = Auth::attempt($credentials);
        if (!$auth) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid email or password'
                ],
                401
            );
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken($request->headers->get('user-agent'), []);
        $userDetails = $user->get(['firstname', 'lastname', 'email'])->first()->toArray();
        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully logged in',
            'user' => $userDetails,
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at
        ]);
    }

    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        $allTokens = $request->user()->tokens;
        foreach ($allTokens as $token) {
            $token->revoke();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully logged out'
        ]);
    }
}
