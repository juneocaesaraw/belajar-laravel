
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Data Peminjaman</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola transaksi peminjaman dan pengembalian buku.</p>
    </div>

    <a href="{{ route('borrowings.create') }}"
       class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
        + Tambah Peminjaman
    </a>
</div>

@if (session('success'))
    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto border border-slate-200 rounded-xl">
    <table class="w-full text-sm text-left">
        <thead class="bg-slate-100 text-slate-600">
            <tr>
                <th class="px-5 py-3 font-semibold">No.</th>
                <th class="px-5 py-3 font-semibold">Anggota</th>
                <th class="px-5 py-3 font-semibold">Tanggal Pinjam</th>
                <th class="px-5 py-3 font-semibold">Batas Pengembalian</th>
                <th class="px-5 py-3 font-semibold">Jumlah Jenis Buku</th>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 font-semibold text-center">Aksi</th>
                <th class="px-5 py-3 font-semibold">Anggota</th>
                <th class="px-5 py-3 font-semibold">Petugas</th>
                <th class="px-5 py-3 font-semibold">Tanggal Pinjam</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-200">
            @if ($borrowings->count() > 0)
                @foreach ($borrowings as $borrowing)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $borrowing->member->name }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $borrowing->borrowing_date->format('d-m-Y') }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $borrowing->due_date->format('d-m-Y') }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $borrowing->details->count() }} jenis buku
                        </td>
                        <td class="px-5 py-4">
                            @if ($borrowing->status === 'borrowed')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    Dipinjam
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('borrowings.show', $borrowing->id) }}"
                               class="text-blue-600 font-semibold hover:text-blue-800">
                                Detail
                            </a>
                        </td>

                        <td class="px-5 py-4 font-medium text-slate-800">
                            {{ $borrowing->member->name }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $borrowing->user->name }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $borrowing->borrowing_date->format('d-m-Y') }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                        Belum ada transaksi peminjaman.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
