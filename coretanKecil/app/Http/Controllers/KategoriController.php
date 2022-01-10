<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;


class KategoriController extends Controller
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
            $kategori = Kategori::select('id', 'nama', 'slug')->where('nama', 'LIKE', '%' . request()->search . '%')->latest()->Paginate(5);
            $search = request()->search;

            if (count($kategori) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-warning mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $kategori = Kategori::select('id', 'nama', 'slug')->latest()->Paginate(5);
        }
        return view('admin/kategori/index', compact('kategori', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/kategori/create');
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
            'nama' => 'required',
        ]);

        Kategori::create([
            'nama' => Str::title($request->nama),
            'slug' => Str::slug($request->nama, '-')
        ]);

        Alert::success('Success', 'Kategori Berhasil ditambahkan');
        return redirect('/kategori');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::select('id', 'nama')->whereId($id)->first();
        return view('admin/kategori/edit', compact('kategori'));
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
            'nama' => 'required',
        ]);

        Kategori::whereId($id)->update([
            'nama' => Str::title($request->nama),
            'slug' => Str::slug($request->nama, '-')
        ]);

        Alert::success('Success', 'Kategori Berhasil diupdate');
        return redirect('/kategori');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Kategori::whereId($id)->delete();

        Alert::success('Success', 'Kategori Berhasil dihapus');
        return redirect('/kategori');
    }

    public function konfirmasi($id)
    {
        alert()->question('Pemberitahuan !', 'Apakah yakin ingin menghapus kategori?')
            ->showConfirmButton('<a href="/kategori/' . $id . '/destroy" class="text-white" style="text-decoration:none"> Hapus</a>', '#3085d6')->toHtml()
            ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect('/kategori');
    }
}
