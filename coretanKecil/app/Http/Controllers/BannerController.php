<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
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
            $banner = Banner::select('id', 'slug', 'sampul', 'judul')->where('judul', 'LIKE', '%' . request()->search . '%')->latest()->Paginate(5);
            $search = request()->search;

            if (count($banner) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-warning mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $banner = Banner::select('id', 'slug', 'sampul', 'judul')->latest()->Paginate(5);
        }
        return view('admin/banner/index', compact('banner', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/banner/create');
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
        ]);

        $sampul = time() . '-' . $request->sampul->getClientOriginalName();
        $request->sampul->move('upload/banner', $sampul);

        Banner::create([
            'sampul' => $sampul,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'slug' => Str::slug($request->judul, '-'),
        ]);

        Alert::success('Success', 'Data Berhasil ditambahkan');
        return redirect('/banner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::select('id', 'judul', 'sampul', 'konten', 'created_at')->whereId($id)->firstOrFail();
        return view('admin/banner/show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::select('id', 'judul', 'sampul', 'konten')->whereId($id)->firstOrFail();
        return view('admin/banner/edit', compact('banner'));
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
            'konten' => 'required'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'slug' => Str::slug($request->judul, '-'),
        ];

        $banner = Banner::select('sampul', 'id')->whereId($id)->first();

        if ($request->sampul) {
            File::delete('upload/banner/' . $banner->sampul);

            $sampul = time() . '-' . $request->sampul->getClientOriginalName();
            $request->sampul->move('upload/banner', $sampul);

            $data['sampul'] = $sampul;
        }

        $banner->update($data);

        Alert::success('Success', 'Data Berhasil diupdate');
        return redirect('/banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function konfirmasi($id)
    {
        alert()->question('Pemberitahuan !', 'Apakah yakin ingin menghapus banner?')
            ->showConfirmButton('<a href="/banner/' . $id . '/hapus" class="text-white" style="text-decoration:none"> Hapus</a>', '#3085d6')->toHtml()
            ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect('/banner');
    }

    public function hapus($id)
    {
        $banner = Banner::select('sampul', 'id')->whereId($id)->firstOrFail();
        File::delete('upload/banner/' . $banner->sampul);
        $banner->delete();

        Alert::success('Success', 'Post Berhasil dihapus');
        return redirect('/banner');
    }
}
