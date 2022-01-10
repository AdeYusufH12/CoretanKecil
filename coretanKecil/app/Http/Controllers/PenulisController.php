<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PenulisController extends Controller
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
            $penulis = User::select('id', 'name', 'email')->where('name', 'LIKE', '%' . request()->search . '%')->latest()->paginate(10);
            $search = request()->search;

            if (count($penulis) == 0) {
                request()->session()->flash('search', '
                    <div class="alert alert-warning mt-4" role="alert">
                        Data yang anda cari tidak ada
                    </div>
                ');
            }
        } else {
            $penulis = User::select('id', 'name', 'email')->latest()->paginate(10);
        }

        return view('admin/penulis/index', compact('penulis', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/penulis/create');
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
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('penulis');

        Alert::success('Success', 'Penulis Berhasil ditambahkan');
        return redirect('/penulis');
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
        //
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
        //
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
        alert()->question('Pemberitahuan !', 'Apakah yakin ingin menghapus User?')
            ->showConfirmButton('<a href="/penulis/' . $id . '/hapus" class="text-white" style="text-decoration:none"> Hapus</a>', '#3085d6')->toHtml()
            ->showCancelButton('Batal', '#aaa')->reverseButtons();

        return redirect('/penulis');
    }

    public function hapus($id)
    {
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        User::whereId($id)->delete();

        Alert::success('Success', 'User Berhasil dihapus');
        return redirect('/penulis');
    }
}
