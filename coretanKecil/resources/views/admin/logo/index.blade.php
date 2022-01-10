@extends('sb-admin/app')
@section('title', 'Coretan Kecil - Logo') 
@section('logo', 'active') 
@section('pengaturan', 'show') 
@section('pengaturan-active', 'active') 

@section('content') 

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Logo</h1>


    <a href="/logo/{{ $logo->id }}/edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit   Logo</a>

    <div class="card mt-4" style="width: 18rem;">
        <img src="/upload/logo/{{ $logo->gambar }}" class="card-img-top" alt="...">
    </div>

    @endsection