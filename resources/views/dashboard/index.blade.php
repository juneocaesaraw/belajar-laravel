@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

 <h2>{{ $title }}</h2>
 <p>{{ $description }}</p>
 <h3>Informasi Perpustakaan</h3>


    <ul>
        
        <li>Jumlah Buku: {{ $books }}</li>
        <li>Jumlah Anggota: {{ $members }}</li>
        <li>Jumlah Kategori: {{ $categories }}</li>
        
    </ul>
@endsection