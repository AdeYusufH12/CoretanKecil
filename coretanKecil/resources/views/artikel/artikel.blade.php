@extends('artikel/template/app')
@section('title','Coretan Kecil')
    
@section('content')
    <div class="card">
        <div class="card-header">
            <p class="card-text"><small class="text-muted">Kategori :
                <a style="text-decoration:none" href="/artikel-kategori/{{ $artikel->kategori->slug }}">{{ $artikel->kategori->nama }} </a>
                - Terakhir di upload {{ $artikel->created_at->diffforHumans() }} 
                - Tag : @foreach ( $artikel->tag as $row)
                @if ($loop->last)
                    {{ $row->nama }}
                @else
                    {{ $row->nama }},
                @endif
                @endforeach
                </small>
            </p>
        </div>
        <img class="card-img-top" src="/upload/post/{{ $artikel->sampul }}" height="550px" alt="Card image cap">
        <div class="card-body">
            <h3 class="card-title">{{ $artikel->judul }}</h3>
            <small>Pengarang : <span class="text-muted"><a href="/artikel-author/{{$artikel->user->id}}">{{$artikel->user->name}}</a></span></small>
            <hr>
            <p class="card-text">{!! $artikel->konten !!}</p>
            <a href="/" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
@endsection