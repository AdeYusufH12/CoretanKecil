<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Kategori;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_post = Post::count();
        $jumlah_kategori = Kategori::count();
        $jumlah_tag = Tag::count();
        $jumlah_banner = Banner::count();

        $hari_ini = Carbon::today();
        $post = Post::select('id','judul','id_kategori','sampul')->whereDate('created_at', $hari_ini)->get();
        $kategori = Kategori::select('nama','slug')->whereDate('created_at', $hari_ini)->get();
        $tag = Tag::select('nama','slug')->whereDate('created_at', $hari_ini)->get();
        $banner= Banner::select('sampul','judul','slug')->whereDate('created_at', $hari_ini)->get();


        return view('admin/dashboard',compact('jumlah_post','jumlah_kategori','jumlah_tag','jumlah_banner','post','kategori','tag','banner'));
    }
}
