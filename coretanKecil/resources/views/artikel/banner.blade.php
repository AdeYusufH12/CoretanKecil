@extends('artikel/template/app')
@section('title','Coretan Kecil | Banner')
    
@section('content')
     <div class="card">
        <div class="card-header">
            <p class="card-text"><small class="text-muted">
                Terakhir di upload {{ $banner->created_at->diffforHumans() }} 
                </small>
            </p>
        </div>
        <img class="card-img-top" src="/upload/banner/{{ $banner->sampul }}" height="550px" alt="Card image cap">
        <div class="card-body">
            <h3 class="card-title">{{ $banner->judul }}</h3>
            <hr>
            <p class="card-text">{!! $banner->konten !!}</p>
        </div>
    </div>
@endsection