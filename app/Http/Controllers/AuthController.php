<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, ['table' => 'customers'])) {
            $user = Customer::where('email', $credentials['email'])->first();
            return response()->json(['token' => $user->token], 200);
        }

        if (Auth::attempt($credentials, ['table' => 'users'])) {
            $user = User::where('email', $credentials['email'])->first();
            return response()->json(['token' => $user->token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
