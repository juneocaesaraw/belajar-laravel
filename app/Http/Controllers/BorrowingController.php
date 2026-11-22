<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // Menampilkan seluruh transaksi peminjaman
    public function index()
    {
        $borrowings = Borrowing::with([
            'user',
            'member',
            'details.book'
        ])->latest()->get();

        return view('borrowings.index', compact('borrowings'));
    }

    // Menampilkan form peminjaman
    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        return view('borrowings.create', compact(
            'members',
            'books'
        ));
    }

    // Menyimpan transaksi peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'required|distinct|exists:books,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        if (count($validated['book_ids']) !== count($validated['quantities'])) {
            throw ValidationException::withMessages([
                'quantities' => 'Jumlah buku dan kuantitas tidak sesuai.',
            ]);
        }

        DB::transaction(function () use ($validated) {

            // Membuat transaksi peminjaman
            $borrowing = Borrowing::create([
                'user_id' => Auth::id(),
                'member_id' => $validated['member_id'],
                'borrowing_date' => now()->toDateString(),
                'due_date' => now()->addDays(7)->toDateString(),
                'status' => 'borrowed',
            ]);

            // Memproses setiap buku yang dipinjam
            foreach ($validated['book_ids'] as $index => $bookId) {

                $quantity = $validated['quantities'][$index];

                // Mengunci data buku selama transaksi
                $book = Book::whereKey($bookId)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Memeriksa ketersediaan stok
                if ($book->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'quantities' => "Stok buku {$book->title} tidak mencukupi.",
                    ]);
                }

                // Menyimpan detail peminjaman
                $borrowing->details()->create([
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                ]);

                // Mengurangi stok buku
                $book->decrement('stock', $quantity);
            }
        });

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Peminjaman buku berhasil disimpan.');
    }

    // Menampilkan detail transaksi
    public function show(Borrowing $borrowing)
    {
        $borrowing->load([
            'user',
            'member',
            'details.book'
        ]);

        return view('borrowings.show', compact('borrowing'));
    }

    // Memproses pengembalian buku
    public function returnBook(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {

            $borrowing = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->with('details')
                ->firstOrFail();

            // Mencegah pengembalian berulang
            if ($borrowing->status !== 'borrowed') {
                throw ValidationException::withMessages([
                    'status' => 'Transaksi ini sudah dikembalikan.',
                ]);
            }

            // Mengembalikan stok seluruh buku
            foreach ($borrowing->details as $detail) {

                $book = Book::whereKey($detail->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $book->increment('stock', $detail->quantity);
            }

            // Memperbarui status transaksi
            $borrowing->update([
                'return_date' => now()->toDateString(),
                'status' => 'returned',
            ]);
        });

        return redirect()
            ->route('borrowings.show', $borrowing->id)
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
