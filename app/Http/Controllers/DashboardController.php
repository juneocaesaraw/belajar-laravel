<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Category;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Library System Dashboard';
        $description = 'Selamat datang di Sistem Informasi Perpustakaan.';

        // Menghitung informasi perpustakaan
        $books = Book::count();
        $members = Member::count();
        $categories = Category::count();
        $totalStock = Book::sum('stock');

          // Aktivitas Peminjaman
        $activeBorrowings = Borrowing::where('status', 'borrowed')->count();

        $overdueBorrowings = Borrowing::where('status', 'borrowed')
            ->whereDate('due_date', '<', today())
            ->count();

        $todayBorrowings = Borrowing::whereDate('borrowing_date', today())
            ->count();

        $todayReturns = Borrowing::whereDate('return_date', today())
            ->count();

        // Mengambil transaksi buku yang sedang dipinjam
        $borrowings = Borrowing::with([
            'member',
            'user',
            'details.book'
        ])
        ->where('status', 'borrowed')
        ->latest()
        ->get();

      



        // Mengirim seluruh data ke dashboard
        return view('dashboard.index', compact(
            'title',
            'description',
            'books',
            'members',
            'categories',
            'borrowings',
            'totalStock',
            'activeBorrowings',
            'overdueBorrowings',
            'todayBorrowings',
            'todayReturns'
        ));
    }
}
