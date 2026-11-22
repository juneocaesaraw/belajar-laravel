<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowingDetail extends Model
{
    protected $fillable = [
        'borrowing_id',
        'book_id',
        'quantity',
    ];

    // Relasi ke transaksi peminjaman
    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    // Relasi ke buku yang dipinjam
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
