<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessTokenFactory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        $user = User::where('email', $credentials['username'])
                    ->orWhere('username', $credentials['username'])
                    ->first();
    
        if ($user && Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            $token = $this->createAccessToken($user);
            return response()->json(['token' => $token], 200);
        }
    
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    

    private function createAccessToken($user)
    {
        $tokenName = 'Personal Access Token';

        return $user->createToken($tokenName)->plainTextToken;
    }

}
