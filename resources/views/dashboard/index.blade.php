
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <p class="text-sm text-slate-500 mb-2">Library System / Dashboard</p>
        <h2 class="text-3xl font-bold text-slate-900">{{ $title }}</h2>
        <p class="text-slate-500 mt-2">{{ $description }}</p>
    </div>

    <h3 class="text-xl font-semibold text-slate-800 mb-5">
        Informasi Perpustakaan
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm">
            <span class="stat-label block text-sm font-medium text-slate-500">
                Jumlah Buku
            </span>
            <span class="stat-value block text-3xl font-bold text-blue-600 mt-3">
                {{ $books }}
            </span>
        </div>

        <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm">
            <span class="stat-label block text-sm font-medium text-slate-500">
                Total Stok Buku
            </span>
            <span class="stat-value block text-3xl font-bold text-blue-600 mt-3">
                {{ $totalStock }}
            </span>
        </div>

        <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm">
            <span class="stat-label block text-sm font-medium text-slate-500">
                Jumlah Anggota
            </span>
            <span class="stat-value block text-3xl font-bold text-blue-600 mt-3">
                {{ $members }}
            </span>
        </div>

        <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm">
            <span class="stat-label block text-sm font-medium text-slate-500">
                Jumlah Kategori
            </span>
            <span class="stat-value block text-3xl font-bold text-blue-600 mt-3">
                {{ $categories }}
            </span>
        </div>
    </div>

    <!-- Statistik Peminjaman -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold text-slate-800 mb-5">
            Statistik Peminjaman
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            <div class="rounded-xl border border-blue-100 bg-white p-6 shadow-sm">
                <span class="block text-sm font-medium text-slate-500">
                    Peminjaman Aktif
                </span>
                <span class="block text-3xl font-bold text-blue-600 mt-3">
                    {{ $activeBorrowings }}
                </span>
            </div>

            <div class="rounded-xl border border-red-100 bg-white p-6 shadow-sm">
                <span class="block text-sm font-medium text-slate-500">
                    Peminjaman Terlambat
                </span>
                <span class="block text-3xl font-bold text-red-600 mt-3">
                    {{ $overdueBorrowings }}
                </span>
            </div>

            <div class="rounded-xl border border-amber-100 bg-white p-6 shadow-sm">
                <span class="block text-sm font-medium text-slate-500">
                    Peminjaman Hari Ini
                </span>
                <span class="block text-3xl font-bold text-amber-600 mt-3">
                    {{ $todayBorrowings }}
                </span>
            </div>

            <div class="rounded-xl border border-green-100 bg-white p-6 shadow-sm">
                <span class="block text-sm font-medium text-slate-500">
                    Pengembalian Hari Ini
                </span>
                <span class="block text-3xl font-bold text-green-600 mt-3">
                    {{ $todayReturns }}
                </span>
            </div>

        </div>
    </div>

    <!-- Buku yang Sedang Dipinjam -->
    <div class="mt-10">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h3 class="text-xl font-semibold text-slate-800">
                    Buku yang Sedang Dipinjam
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi buku yang belum dikembalikan oleh anggota.
                </p>
            </div>

            <a href="{{ route('borrowings.index') }}"
               class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                Lihat Semua Peminjaman &rarr;
            </a>
        </div>

        <div class="overflow-x-auto border border-slate-200 rounded-xl">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-5 py-3 font-semibold">No.</th>
                        <th class="px-5 py-3 font-semibold">Nama Anggota</th>
                        <th class="px-5 py-3 font-semibold">Buku</th>
                        <th class="px-5 py-3 font-semibold">Petugas</th>
                        <th class="px-5 py-3 font-semibold">Tanggal Pinjam</th>
                        <th class="px-5 py-3 font-semibold">Batas Pengembalian</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                    @if ($borrowings->count() > 0)

                        @foreach ($borrowings as $borrowing)
                            <tr class="hover:bg-slate-50 align-top">

                                <td class="px-5 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $borrowing->member->name }}
                                </td>

                                <td class="px-5 py-4">
                                    @foreach ($borrowing->details as $detail)
                                        <div class="mb-2 last:mb-0">
                                            <p class="font-medium text-slate-800">
                                                {{ $detail->book->title }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                Jumlah: {{ $detail->quantity }}
                                            </p>
                                        </div>
                                    @endforeach
                                </td>

                                <td class="px-5 py-4">
                                    {{ $borrowing->user->name }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    {{ $borrowing->borrowing_date->format('d-m-Y') }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    {{ $borrowing->due_date->format('d-m-Y') }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if ($borrowing->due_date->isPast() && !$borrowing->due_date->isToday())
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    @else

                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center">
                                <p class="text-slate-500 font-medium">
                                    Belum ada buku yang sedang dipinjam.
                                </p>
                                <p class="text-xs text-slate-400 mt-1">
                                    Transaksi peminjaman aktif akan ditampilkan di sini.
                                </p>
                            </td>
                        </tr>

                    @endif

                </tbody>
            </table>
        </div>

    </div>
@endsection
