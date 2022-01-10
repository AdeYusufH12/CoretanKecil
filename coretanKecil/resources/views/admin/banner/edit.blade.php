@extends('sb-admin/app')
@section('title', 'Coretan Kecil - Edit Banner') 
@section('banner', 'active') 
@section('main', 'show')
@section('main-active', 'active')  

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Banner</h1>

    <form action="/banner/{{ $banner->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-2">
                <img src="/upload/banner/{{ $banner->sampul }}" width="600px" height="250px" alt="">
            </div>
            <div class="col-md-12">
                <div class="form-group mt-4">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') ? old('judul') : $banner->judul }}">
                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sampul">Sampul</label>
                    <input type="file" class="form-control" id="sampul" name="sampul">
                    @error('sampul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="editor">Konten</label>
            <textarea class="form-control" id="editor" rows="10" name="konten">{{ old('konten')  ? old('konten') : $banner->konten }}</textarea>
            @error('konten')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
        <a href="/banner" class="btn btn-secondary btn-sm">Kembali</a>
      </form>

@endsection

@section('ck-editor')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
    
@endsection