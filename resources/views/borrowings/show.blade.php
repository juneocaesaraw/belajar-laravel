
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="mb-6">
    <a href="{{ route('borrowings.index') }}"
       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
        &larr; Kembali ke Data Peminjaman
    </a>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-3">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Detail Peminjaman</h2>
            <p class="text-sm text-slate-500 mt-1">
                Informasi lengkap transaksi peminjaman buku.
            </p>
        </div>

        @if ($borrowing->status === 'borrowed')
            <span class="w-fit px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                Sedang Dipinjam
            </span>
        @else
            <span class="w-fit px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                Sudah Dikembalikan
            </span>
        @endif
    </div>
</div>

@if (session('success'))
    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <div class="rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold text-slate-900 mb-4">Informasi Anggota</h3>

        <div class="space-y-3 text-sm">
            <div>
                <p class="text-slate-500">Nama Anggota</p>
                <p class="font-medium text-slate-800">{{ $borrowing->member->name }}</p>
            </div>

            <div>
                <p class="text-slate-500">Petugas</p>
                <p class="font-medium text-slate-800">{{ $borrowing->user->name }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold text-slate-900 mb-4">Informasi Transaksi</h3>

        <div class="space-y-3 text-sm">
            <div>
                <p class="text-slate-500">Tanggal Peminjaman</p>
                <p class="font-medium text-slate-800">
                    {{ $borrowing->borrowing_date->format('d-m-Y') }}
                </p>
            </div>

            <div>
                <p class="text-slate-500">Batas Pengembalian</p>
                <p class="font-medium text-slate-800">
                    {{ $borrowing->due_date->format('d-m-Y') }}
                </p>
            </div>

            <div>
                <p class="text-slate-500">Tanggal Dikembalikan</p>
                <p class="font-medium text-slate-800">
                    {{ $borrowing->return_date ? $borrowing->return_date->format('d-m-Y') : '-' }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-4">Daftar Buku</h3>

    <div class="overflow-x-auto border border-slate-200 rounded-xl">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-5 py-3 font-semibold">No.</th>
                    <th class="px-5 py-3 font-semibold">Judul Buku</th>
                    <th class="px-5 py-3 font-semibold">Penulis</th>
                    <th class="px-5 py-3 font-semibold text-center">Kuantitas</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @foreach ($borrowing->details as $detail)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $detail->book->title }}
                        </td>
                        <td class="px-5 py-4">{{ $detail->book->author }}</td>
                        <td class="px-5 py-4 text-center">{{ $detail->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($borrowing->status === 'borrowed')
    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
        <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST"
              onsubmit="return confirm('Apakah buku pada transaksi ini sudah dikembalikan?')">
            @csrf

            <button type="submit"
                    class="w-full px-5 py-2.5 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition">
                Proses Pengembalian
            </button>
        </form>
    </div>
@endif
@endsection
