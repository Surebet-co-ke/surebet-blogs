<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    // Login a user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken; // Generate a token for the user
            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        // If authentication fails
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Get the authenticated user's profile
    public function getProfile()
    {
        $user = Auth::user(); // Get the authenticated user
        return response()->json($user);
    }

    // Update the authenticated user's profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'password' => 'sometimes|string|min:6',
        ]);

        // Update the user's details
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user);
    }

    // Get all users (admin only)
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Get a user by ID (admin only)
    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update a user by ID (admin only)
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'password' => 'sometimes|string|min:4',
            'role' => 'sometimes|in:admin,user',
        ]);

        // Update the user's details
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }

        $user->save();

        return response()->json($user);
    }

    // Delete a user by ID (admin only)
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}