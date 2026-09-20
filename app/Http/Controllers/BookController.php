<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
   public function index()
{
    $books = [
        [
            'title' => 'Pemrograman PHP',
            'author' => 'Budi Santoso',
            'year' => 2022
        ],
        [
            'title' => 'Laravel untuk Pemula',
            'author' => 'Andi Wijaya',
            'year' => 2023
        ],
        [
            'title' => 'Basis Data',
            'author' => 'Citra Lestari',
            'year' => 2021
        ],
        [
            'title' => 'Algoritma dan Pemrograman',
            'author' => 'Dewi Anggraini',
            'year' => 2024
        ],
        [
            'title' => 'Sistem Informasi',
            'author' => 'Eko Pratama',
            'year' => 2023
        ]
    ];

    $stock = 5;

    return view('books.index', compact('books', 'stock'));
}
    public function show($id)
    {
        return 'Detail Buku - ID Buku: ' . $id;
    }
}

