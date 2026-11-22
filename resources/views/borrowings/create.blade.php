
@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="mb-6">
    <a href="{{ route('borrowings.index') }}"
       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
        &larr; Kembali ke Data Peminjaman
    </a>

    <h2 class="text-2xl font-bold text-slate-900 mt-3">Tambah Peminjaman</h2>
    <p class="text-sm text-slate-500 mt-1">Masukkan data anggota dan buku yang akan dipinjam.</p>
</div>

@if ($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <p class="font-semibold mb-2">Terdapat kesalahan pada input:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6">
    @csrf

    <div>
        <label for="member_id" class="block text-sm font-semibold text-slate-700 mb-2">
            Anggota
        </label>

        <select name="member_id" id="member_id" required
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            <option value="">-- Pilih Anggota --</option>

            @foreach ($members as $member)
                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
            <div>
                <h3 class="font-semibold text-slate-800">Buku yang Dipinjam</h3>
                <p class="text-xs text-slate-500 mt-1">Pilih buku dan masukkan jumlah yang dipinjam.</p>
            </div>

            <button type="button" id="add-book"
                    class="px-4 py-2 rounded-lg border border-blue-200 text-blue-700 text-sm font-semibold hover:bg-blue-50 transition">
                + Tambah Buku
            </button>
        </div>

        <div id="book-list" class="space-y-3">
            <div class="book-row grid grid-cols-1 sm:grid-cols-[1fr_140px_auto] gap-3 items-end">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Buku</label>
                    <select name="book_ids[]" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}">
                                {{ $book->title }} (Stok: {{ $book->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kuantitas</label>
                    <input type="number" name="quantities[]" min="1" value="1" required
                           class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                <button type="button"
                        class="remove-book hidden px-3 py-3 rounded-lg border border-red-200 text-red-600 hover:bg-red-50"
                        aria-label="Hapus buku">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="rounded-lg bg-blue-50 border border-blue-100 p-4 text-sm text-blue-800">
        <p class="font-semibold">Informasi Peminjaman</p>
        <p class="mt-1">Tanggal peminjaman dicatat otomatis oleh sistem. Batas pengembalian ditetapkan 7 hari setelah tanggal peminjaman.</p>
    </div>

    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
        <a href="{{ route('borrowings.index') }}"
           class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 text-sm font-semibold text-center hover:bg-slate-50">
            Batal
        </a>

        <button type="submit"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
            Simpan Peminjaman
        </button>
    </div>
</form>

<script>
    const bookList = document.getElementById('book-list');
    const addBookButton = document.getElementById('add-book');

    addBookButton.addEventListener('click', function () {
        const firstRow = bookList.querySelector('.book-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelector('select').selectedIndex = 0;
        newRow.querySelector('input').value = 1;
        newRow.querySelector('.remove-book').classList.remove('hidden');

        bookList.appendChild(newRow);
    });

    bookList.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-book')) {
            event.target.closest('.book-row').remove();
        }
    });
</script>
@endsection
