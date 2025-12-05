<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create User (POST /api/users)
     */
    public function store(Request $request)
    {
        // VALIDATION (API SAFE)
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|unique:users,phone',
            'password' => 'required|min:6',
            'image'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        // UPLOAD IMAGE
        $imagePath = $request->file('image')->store('users', 'public');

        // CREATE USER
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'image'    => $imagePath,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status'   => true,
            'message'  => 'User created successfully',
            'user'     => $user,
            'redirect' => '/users'
        ], 201);
    }



    /**
     * Get all users (GET /api/users)
     */
    public function index()
    {
        $users = User::latest()->get();

        return response()->json([
            'status' => true,
            'users'  => $users
        ]);
    }



    /**
     * Get single user (GET /api/users/{id})
     */
    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'user'   => $user
        ]);
    }



    /**
     * Update User (PUT /api/users/{id})
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        // VALIDATION (API SAFE)
        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|string|max:255',
            'phone' => 'nullable|unique:users,phone,' . $user->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        // UPDATE IMAGE IF NEW UPLOADED
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
            $user->image = $imagePath;
        }

        if ($request->name)  $user->name = $request->name;
        if ($request->phone) $user->phone = $request->phone;

        $user->save();

        return response()->json([
            'status'   => true,
            'message'  => 'User updated successfully',
            'user'     => $user,
            'redirect' => '/users'
        ]);
    }



    /**
     * Delete User (DELETE /api/users/{id})
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
