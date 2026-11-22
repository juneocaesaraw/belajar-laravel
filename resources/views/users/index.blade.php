@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Kelola Pengguna</h2>
        <p class="text-sm text-slate-500 mt-1">
            Kelola akun Admin dan Petugas Library System.
        </p>
    </div>

    <a href="{{ route('users.create') }}"
       class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
        + Tambah Pengguna
    </a>
</div>

@if (session('success'))
    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

<div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="rounded-xl border border-slate-200 p-4">
        <p class="text-sm text-slate-500">Total Pengguna</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">
            {{ $users->count() }}
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 p-4">
        <p class="text-sm text-slate-500">Admin</p>
        <p class="text-2xl font-bold text-blue-700 mt-1">
            {{ $users->where('role', 'admin')->count() }}
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 p-4">
        <p class="text-sm text-slate-500">Petugas</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">
            {{ $users->where('role', 'petugas')->count() }}
        </p>
    </div>
</div>

<div class="overflow-x-auto border border-slate-200 rounded-xl">
    <table class="w-full text-sm text-left">
        <thead class="bg-slate-100 text-slate-600">
            <tr>
                <th class="px-5 py-3 font-semibold">No.</th>
                <th class="px-5 py-3 font-semibold">Nama Pengguna</th>
                <th class="px-5 py-3 font-semibold">Email</th>
                <th class="px-5 py-3 font-semibold">Role</th>
                <th class="px-5 py-3 font-semibold">Tanggal Dibuat</th>
                <th class="px-5 py-3 font-semibold text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
            @if ($users->count() > 0)
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">{{ $loop->iteration }}</td>

                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $user->name }}

                            @if ($user->id === auth()->id())
                                <span class="ml-1 text-xs text-blue-600">(Anda)</span>
                            @endif
                        </td>

                        <td class="px-5 py-4">{{ $user->email }}</td>

                        <td class="px-5 py-4">
                            @if ($user->role === 'admin')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    Admin
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    Petugas
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            {{ $user->created_at->format('d-m-Y') }}
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="font-semibold text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>

                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="font-semibold text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                        Belum ada data pengguna.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
