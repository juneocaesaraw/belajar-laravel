<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan seluruh pengguna
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('users.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'petugas'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Menampilkan form edit pengguna
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    // Memperbarui data pengguna
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'petugas'])],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        // Password hanya diubah jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Mencegah admin menghapus akunnya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // Mencegah penghapusan admin terakhir
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
