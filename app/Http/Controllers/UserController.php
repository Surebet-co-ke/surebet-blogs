<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regenerate session to prevent fixation attacks
            return redirect()->route('home'); // Redirect to home page after login
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Debug the request data
        \Log::info('Registration Request Data:', $request->all());
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Debug after validation
        \Log::info('Validation Passed. Creating User...');
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Debug after user creation
        \Log::info('User Created:', $user->toArray());
    
        // Log in the user after registration
        Auth::login($user);
    
        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    // Show the user profile
    public function profile()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('users.profile', compact('user'));
    }

    // Update the user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        // Update the user's details
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    // Show the user management page (admin only)
    public function manageUsers()
    {
        $users = User::all(); // Fetch all users
        return view('users.manage', compact('users'));
    }

   // Show the edit user form (admin only)
    public function editUser($id)
    {
        $user = User::findOrFail($id); // Fetch the user by ID
        return view('users.edit', compact('user'));
    }

    // Update a user (admin only)
    public function updateUser(Request $request, $id)
    {
        // Debug the request data
        \Log::info('Update User Request Data:', $request->all());

        $user = User::findOrFail($id); // Fetch the user by ID

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|in:admin,user',
        ]);

        // Debug after validation
        \Log::info('Validation Passed. Updating User...');

        // Update the user's details
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }

        $user->save();

        // Debug after saving
        \Log::info('User Updated:', $user->toArray());

        return redirect()->route('users.manage')->with('success', 'User updated successfully!');
    }
    
    // Delete a user (admin only)
    public function deleteUser($id)
    {
        $user = User::findOrFail($id); // Fetch the user by ID
        $user->delete();
        return redirect()->route('users.manage')->with('success', 'User deleted successfully!');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect()->route('home'); // Redirect to home page after logout
    }
}