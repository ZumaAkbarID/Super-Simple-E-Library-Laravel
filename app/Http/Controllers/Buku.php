<?php

namespace App\Http\Controllers;

use App\Models\Buku as ModelsBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Buku extends Controller
{
    public $user;

    function index()
    {
        $this->user = Auth::user();

        return view('Buku.Index', [
            'title' => parent::title('Buku'),
            'bukus' => DB::table('bukus')->paginate(5, ['*'], 'buku'),
            'user' => $this->user
        ]);
    }

    function addHandler(Request $request)
    {
        $this->validate(
            $request,
            [
                'judul' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_penerbit' => 'required',
            ],
            [
                'judul.required' => 'Judul tidak boleh kosong',
                'pengarang.required' => 'Pengarang tidak boleh kosong',
                'penerbit.required' => 'Penerbit tidak boleh kosong',
                'tahun_penerbit.required' => 'Tahun terbit tidak boleh kosong',
            ]
        );

        $data = [
            'kode' => 'BK-' . time(),
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_penerbit' => $request->tahun_penerbit,
        ];

        try {
            ModelsBuku::create($data);

            return redirect()->back()->with('success', 'Data buku berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data buku gagal ditambahkan');
        }
    }

    function getUser($id)
    {
        $buku = ModelsBuku::findOrFail($id);

        if ($buku) {
            return response()->json($buku);
        } else {
            return response()->json(['status' => false], 404);
        }
    }

    function editHandler(Request $request)
    {
        $buku = ModelsBuku::findOrFail($request->id);

        $this->validate(
            $request,
            [
                'judul' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_penerbit' => 'required',
            ],
            [
                'judul.required' => 'Judul tidak boleh kosong',
                'pengarang.required' => 'Pengarang tidak boleh kosong',
                'penerbit.required' => 'Penerbit tidak boleh kosong',
                'tahun_penerbit.required' => 'Tahun terbit tidak boleh kosong',
            ]
        );

        $data = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_penerbit' => $request->tahun_penerbit,
        ];

        try {
            $buku->update($data);

            return redirect()->back()->with('success', 'Data buku berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data buku gagal diperbarui');
        }
    }

    function deleteHandler(Request $request)
    {
        $buku = ModelsBuku::findOrFail($request->id);

        try {
            $buku->delete();
            return redirect()->back()->with('success', 'Data buku berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data buku gagal dihapus');
        }
    }
}
