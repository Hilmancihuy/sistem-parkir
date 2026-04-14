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


    // app/Http/Controllers/UserController.php

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8', // Password opsional saat edit
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    // Jika password diisi, maka update passwordnya
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Data petugas berhasil diperbarui.');
}



    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Akun petugas berhasil dihapus.');
    }
}
