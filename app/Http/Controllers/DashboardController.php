<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Library System Dashboard';
        $description = 'Selamat datang di Sistem Informasi Perpustakaan.';

        $books = 8;
        $members = 5;
        $categories = 5;

        return view('dashboard.index', compact(
            'title',
            'description',
            'books',
            'members',
            'categories'
        ));
    }
}