<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // $validated = $request->validate([
        //     'email'    => 'required|email',
        //     'password' => 'required',
        // ]);

          // if (!Auth::attempt($validated)) {
          //     return response()->json([
          //         'message' => 'Login Invalid'
          //     ]);
          // }

          // $user = User::where('email', $validated['email'])->first();

          // return response()->json([
          //     'message'      => 'Login Successfuly',
          //     'access_token' => $user->createToken('API_token')->plainTextToken
          // ]);

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email/password' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'message'      => 'Login Successfuly',
            'access_token' => $user->createToken('API_token')->plainTextToken
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:5',
        ]);

        $user = User::create($validated);

        return response()->json([
            'data'         => $user,
            'message'      => 'Register Successfuly',
            'access_token' => $user->createToken('API_token')->plainTextToken
        ], 201);
    }
}
