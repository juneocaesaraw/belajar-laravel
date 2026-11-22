<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'member_id',
        'borrowing_date',
        'due_date',
        'return_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'borrowing_date' => 'date',
            'due_date' => 'date',
            'return_date' => 'date',
        ];
    }

    // Relasi ke pengguna yang mencatat transaksi
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke anggota yang meminjam
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    // Relasi ke detail buku yang dipinjam
    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}
