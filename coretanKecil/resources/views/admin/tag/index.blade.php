@extends('sb-admin/app')
@section('title', 'Coretan Kecil - Tag') 
@section('tag', 'active') 
@section('main', 'show') 
@section('main-active', 'active') 

@section('content') 

    {{-- flashdata --}}
    {!! session('success') !!}

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tag</h1>


    <a href="/tag/create" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Tag</a>

    @if ($tag[0])
        {{-- Tabel --}}
    <div class="table-responsive">    
        <table class="table mt-4 table-hover table-bordered">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Slug</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tag as $row)
                <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->slug }}</td>
                <td width="20%">
                    <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/tag/{{ $row->id }}/edit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i> Edit</a>
                    <a href="/tag/{{ $row->id }}/konfirmasi" class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i> Hapus</a>
                    </div>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>    

        {{ $tag->links() }}
    @else 
        @if (session('search'))
            {!! session('search') !!}
        @else
            <div class="alert alert-info mt-4" role="alert">
                Data Tag Belom Tersedia
            </div>
        @endif
    @endif
@endsection

@section('search-url', '/tag/search') 

@section('search')
    @include('sb-admin/search')
@endsection

@section('search-responsive')
    @include('sb-admin/search-responsive')
@endsection

@section('javascript')
    @include('admin/navbar-mobile')
@endsection