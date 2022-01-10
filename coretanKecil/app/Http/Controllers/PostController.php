<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Post;
use App\Models\Rekomendasi;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = '';
        if (request()->search) {
            $post = Post::select('id', 'judul', 'sampul', 'id_kategori')->where('id_user', Auth::user()->id)->where('judul', 'LIKE', '%' . request()->search . '%')->latest()->Paginate(5);
            $search = request()->search;

            if (count($post) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-warning mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $post = Post::select('id', 'judul', 'sampul', 'id_kategori')->where('id_user', Auth::user()->id)->latest()->Paginate(5);
        }

        return view('admin/post/index', compact('post', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = Tag::select('id', 'nama')->get();
        $kategori = Kategori::select('id', 'nama')->get();
        return view('admin/post/create', compact('kategori', 'tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'sampul' => 'required|mimes:jpg,jpeg,png',
            'konten' => 'required',
            'kategori' => 'required',
            'tag' => 'required',
        ]);

        $sampul = time() . '-' . $request->sampul->getClientOriginalName();
        $request->sampul->move('upload/post', $sampul);

        Post::create([
            'sampul' => $sampul,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'id_kategori' => $request->kategori,
            'slug' => Str::slug($request->judul, '-'),
            'id_user' => Auth::user()->id
        ])->tag()->attach($request->tag);

        Alert::success('Success', 'Post Berhasil ditambahkan');
        return redirect('/post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::select('id', 'judul', 'sampul', 'konten', 'created_at')->whereId($id)->where('id_user', Auth::user()->id)->firstOrFail();
        return view('admin/post/show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::select('id', 'nama')->get();
        $kategori = Kategori::select('id', 'nama')->get();
        $post = Post::select('id', 'judul', 'sampul', 'konten', 'id_kategori')->whereId($id)->where('id_user', Auth::user()->id)->firstOrFail();
        return view('admin/post/edit', compact('post', 'kategori', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'sampul' => 'mimes:jpg,jpeg,png',
            'konten' => 'required',
            'kategori' => 'required',
            'tag' => 'required',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'id_kategori' => $request->kategori,
            'slug' => Str::slug($request->judul, '-'),
            'id_user' => Auth::user()->id
        ];

        $post = Post::select('sampul', 'id')->whereId($id)->first();

        if ($request->sampul) {
            File::delete('upload/post/' . $post->sampul);

            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/post', $sampul);

            $data['sampul'] = $sampul;
        }

        $post->update($data);
        $post->tag()->sync($request->tag);

        Alert::success('Success', 'Post Berhasil diupdate');
        return redirect('/post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }

    public function konfirmasi($id)
    {
        alert()->question('Pemberitahuan !', 'Apakah yakin ingin menghapus post?')
            ->showConfirmButton('<a href="/post/' . $id . '/hapus" class="text-white" style="text-decoration:none"> Hapus</a>', '#3085d6')->toHtml()
            ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect('/post');
    }

    public function hapus($id)
    {
        $post = Post::select('sampul', 'id')->whereId($id)->where('id_user', Auth::user()->id)->firstOrFail();
        File::delete('upload/post/' . $post->sampul);
        $post->delete();

        Alert::success('Success', 'Post Berhasil dihapus');
        return redirect('/post');
    }

    public function rekomendasi($id)
    {
        $post = DB::table('post')
            ->join('rekomendasi', 'post.id', '=', 'rekomendasi.id_post')
            ->where('rekomendasi.id_post', $id)
            ->get();

        if ($post->isEmpty()) {
            Rekomendasi::create([
                'id_post' => $id
            ]);

            Alert::success('Success', 'Post Berhasil direkomendasi');
            return redirect('/post');
        } else {
            Rekomendasi::where('id_post', $id)->delete();
            Alert::success('Success', 'Post batal direkomendasi');
            return redirect('/post');
        }
    }
}
