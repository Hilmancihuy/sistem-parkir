<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
{
    $users = User::role('petugas')->get();
    // Karena file ada di resources/views/admin/users.blade.php
    return view('admin.users', compact('users')); 
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('petugas');

        return back()->with('success', 'Petugas berhasil didaftarkan.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Akun petugas berhasil dihapus.');
    }
}
