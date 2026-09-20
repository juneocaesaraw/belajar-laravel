<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
      public function index()
    {
        $categories = [
            'Pemrograman',
            'Basis Data',
            'Jaringan Komputer',
            'Sistem Informasi',
            'Algoritma'
        ];
        return view('categories.index', compact('categories'));
    }

        public function show($id)
    {
        return 'ID Category: ' . $id;
    }
}
