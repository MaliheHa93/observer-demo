<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    // ذخیره اطلاعات کاربر
    public function store(Request $request)
    {
        // اعتبارسنجی اطلاعات ورودی
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        // ایجاد کاربر جدید
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('users.create')->with('success', 'User created successfully!');
    }

    public function deleteUser($id)
    {
        // Find and delete a user (trigger 'deleting' event)
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return 'User Deleted';
        }

        return 'User not found';
    }
}
