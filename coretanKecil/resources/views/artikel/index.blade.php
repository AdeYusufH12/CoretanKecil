@extends('artikel/template/app')

@isset($kategori_pilih)
    @section('title')
        Coretan Kecil | {{ $kategori_pilih->nama }}
    @endsection
    @section('kategori','active')
@endisset 

@isset($author_pilih)
    @section('title')
        Coretan Kecil | {{ $author_pilih->name }}
    @endsection
    @section('author','active')
@endisset 

@isset($home)
    @section('title','Coretan Kecil')  
    @section('home','active')
@endisset

@section('content')
    @isset($banner)
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banner as $row)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ ($loop->index) }}" class="{{ ($loop->first)?'active' : '' }}"></li>
                @endforeach
            </ol>
        <div class="carousel-inner">
        @foreach ($banner as $row)
            <div class="carousel-item {{ ($loop->first) ?'active' : '' }}">
                <a href="/artikel-banner/{{ $row->slug }}"><img src="/upload/banner/{{ $row->sampul }}" height="400px" class="d-block w-100" alt="..."></a>
                <div class="carousel-caption d-none d-md-block">
                    <h3>{{ $row->judul }}</h3>
                </div>
            </div>
        @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
        </div>
    @endisset

    @isset($rekomendasi)
        <!--- Rekomendasi -->
        @if ($rekomendasi->isNotEmpty())
        <h2 class="my-4 text-center">Rekomendasi</h2>
        <div class="row mt-4 mb-4">
        @foreach ($rekomendasi as $row)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <a href="/{{ $row->post->slug }}"><img class="card-img-top" src="/upload/post/{{ $row->post->sampul }}" alt="Card image cap"></a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $row->post->judul }}</h5>
                        <p class="card-text"></p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">di upload {{ $row->post->created_at->diffforHumans() }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endisset

    <div class="d-flex justify-content-center mt-4">{{ $rekomendasi->links() }}</div>
    @endif

    <!---- Postingan -->
    <h2 class="my-4 text-center">@yield('title')</h2>

    <div class="d-flex justify-content-center" method="GET" action="{{ url()->full() }}">
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="{{ $search }}">
            <button class="btn btn-primary my-2 my-sm-0 mx-auto" type="submit">Search</button>
        </form>
    </div>

    @if (session('search'))
        <div class="row mt-4 justify-content-center text-center">
            <div class="col-md-6">
                <div class="alert alert-info" role="alert">
                    {{ session('search') }}
                </div>
            </div>
        </div>
    @else
        <div class="row mt-4 mb-4">
        @foreach ($artikel as $row)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <a href="/{{ $row->slug }}"><img class="card-img-top" src="/upload/post/{{ $row->sampul }}" alt="Card image cap"></a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $row->judul }}</h5>
                        <p class="card-text"></p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">di upload {{ $row->created_at->diffforHumans() }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @endif
    <div class="d-flex justify-content-center mt-4">{{ $artikel->links() }}</div>
@endsection