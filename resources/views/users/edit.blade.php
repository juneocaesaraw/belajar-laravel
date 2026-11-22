
@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="mb-6">
    <a href="{{ route('users.index') }}"
       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
        &larr; Kembali ke Kelola Pengguna
    </a>

    <h2 class="text-2xl font-bold text-slate-900 mt-3">Edit Pengguna</h2>
    <p class="text-sm text-slate-500 mt-1">Perbarui informasi akun pengguna.</p>
</div>

@if ($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST" class="max-w-2xl space-y-5">
    @csrf
    @method('PUT')

    <div>
        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
            Nama Lengkap
        </label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $user->name) }}" required
               class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
    </div>

    <div>
        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
            Email
        </label>
        <input type="email" name="email" id="email"
               value="{{ old('email', $user->email) }}" required
               class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
    </div>

    <div>
        <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">
            Role Pengguna
        </label>
        <select name="role" id="role" required
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
        </select>
    </div>

    <div class="border-t border-slate-200 pt-5">
        <h3 class="font-semibold text-slate-800">Ubah Password</h3>
        <p class="text-xs text-slate-500 mt-1">
            Kosongkan jika tidak ingin mengubah password.
        </p>
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
            Password Baru
        </label>
        <input type="password" name="password" id="password"
               class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
            Konfirmasi Password Baru
        </label>
        <input type="password" name="password_confirmation"
               id="password_confirmation"
               class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
    </div>

    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-3">
        <a href="{{ route('users.index') }}"
           class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 text-sm font-semibold text-center hover:bg-slate-50">
            Batal
        </a>

        <button type="submit"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
