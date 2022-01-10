<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Kategori;
use App\Models\Logo;
use App\Models\Post;
use App\Models\Rekomendasi;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $logo = Logo::select('gambar')->first();
        $banner = Banner::select('slug', 'sampul', 'judul')->latest()->get();

        request()->session()->forget('search');
        if (request()->search) {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('judul', 'LIKE', '%' . request()->search . '%')->latest()->paginate(6);

            if (count($artikel) == 0) {
                request()->session()->flash('search', 'Post yang anda cari tidak ada');
            }
            $search = request()->search;
        } else {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->latest()->paginate(6);
            $search = '';
        }

        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $home = true;
        $author = User::select('id', 'name')->orderBy('name', 'asc')->get();
        $rekomendasi = Rekomendasi::select('id_post')->latest()->paginate(3);
        return view('artikel/index', compact('artikel', 'kategori', 'banner', 'logo', 'home', 'author', 'search', 'rekomendasi'));
    }

    public function artikel($slug)
    {
        $logo = Logo::select('gambar')->first();
        $artikel = Post::select('id', 'judul', 'konten', 'id_kategori', 'created_at', 'sampul', 'id_user')->where('slug', $slug)->firstOrFail();
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author = User::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('artikel/artikel', compact('artikel', 'kategori', 'logo', 'author'));
    }

    public function kategori($slug)
    {
        $logo = Logo::select('gambar')->first();
        $kategori = Kategori::select('id')->where('slug', $slug)->firstOrFail();

        request()->session()->forget('search');
        if (request()->search) {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_kategori', $kategori->id)->where('judul', 'LIKE', '%' . request()->search . '%')->latest()->paginate(6);
            if (count($artikel) == 0) {
                request()->session()->flash('search', 'Post yang anda cari tidak ada');
            }
            $search = request()->search;
        } else {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_kategori', $kategori->id)->latest()->paginate(6);
            $search = '';
        }

        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $kategori_pilih = Kategori::select('nama', 'slug')->where('slug', $slug)->firstOrFail();
        $author = User::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('artikel/index', compact('artikel', 'kategori', 'logo', 'kategori_pilih', 'author', 'search'));
    }

    public function tag($slug)
    {
        $logo = Logo::select('gambar')->first();
        $banner = Banner::select('slug', 'sampul', 'judul')->latest()->get();
        $artikel = Tag::Select('id')->where('slug', $slug)->latest()->firstOrFail();
        $artikel = $artikel->post;
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author = User::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('artikel/index', compact('artikel', 'kategori', 'banner', 'logo', 'author'));
    }

    public function banner($slug)
    {
        $logo = Logo::select('gambar')->first();
        $banner = Banner::select('id', 'judul', 'konten', 'created_at', 'sampul')->where('slug', $slug)->firstOrFail();
        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author = User::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('artikel/banner', compact('banner', 'kategori', 'logo', 'author'));
    }

    public function author($id)
    {
        $logo = Logo::select('gambar')->first();

        request()->session()->forget('search');
        if (request()->search) {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_user', $id)->where('judul', 'LIKE', '%' . request()->search . '%')->latest()->paginate(6);
            if (count($artikel) == 0) {
                request()->session()->flash('search', 'Post yang anda cari tidak ada');
            }
            $search = request()->search;
        } else {
            $artikel = Post::select('sampul', 'judul', 'slug', 'created_at')->where('id_user', $id)->latest()->paginate(6);
            $search = '';
        }

        $kategori = Kategori::select('slug', 'nama')->orderBy('nama', 'asc')->get();
        $author_pilih = User::select('name')->whereId($id)->firstOrFail();
        $author = User::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('artikel/index', compact('artikel', 'kategori', 'logo', 'author_pilih', 'author', 'search'));
    }
}
