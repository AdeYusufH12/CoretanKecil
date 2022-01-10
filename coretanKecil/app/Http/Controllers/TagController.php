<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TagController extends Controller
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
            $tag = Tag::select('id', 'nama', 'slug')->where('nama', 'LIKE', '%' . request()->search . '%')->latest()->Paginate(5);
            $search = request()->search;

            if (count($tag) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-warning mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $tag = Tag::select('id', 'nama', 'slug')->latest()->Paginate(5);
        }
        return view('admin/tag/index', compact('tag', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/tag/create');
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

        Tag::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-')
        ]);

        Alert::success('Success', 'Tag Berhasil ditambahkan');
        return redirect('/tag');
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
        $tag = Tag::select('id', 'nama')->whereId($id)->firstOrFail();
        return view('admin/tag/edit', compact('tag'));
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

        Tag::whereId($id)->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama, '-')
        ]);

        Alert::success('Success', 'Tag Berhasil diupdate');
        return redirect('/tag');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::whereId($id)->delete();

        Alert::success('Success', 'Tag Berhasil dihapus');
        return redirect('/tag');
    }

    public function konfirmasi($id)
    {
        alert()->question('Pemberitahuan !', 'Apakah yakin ingin menghapus tag?')
            ->showConfirmButton('<a href="/tag/' . $id . '/destroy" class="text-white" style="text-decoration:none"> Hapus</a>', '#3085d6')->toHtml()
            ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect('/tag');
    }
}
