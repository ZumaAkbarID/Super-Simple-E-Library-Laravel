<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Pinjam as ModelsPinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pinjam extends Controller
{
    public $user, $anggota, $buku;

    function index()
    {
        $this->user = Auth::user();
        $this->anggota = Anggota::all();
        $this->buku = Buku::where('status', 'Tersedia')->get();

        return view('Pinjam.Tambah', [
            'title' => parent::title('Buat Pinjam'),
            'user' => $this->user,
            'anggota' => $this->anggota,
            'buku' => $this->buku
        ]);
    }

    function addHandler(Request $request)
    {
        $this->validate($request, [
            'buku_id' => 'required|numeric',
            'anggota_id' => 'required|numeric',
        ], [
            'buku_id.required' => 'Form tidak valid',
            'buku_id.numeric' => 'Form tidak valid',
            'anggota_id.required' => 'Form tidak valid',
            'anggota_id.numeric' => 'Form tidak valid',
        ]);

        $this->user = Auth::user();
        $this->buku = Buku::where('id', $request->buku_id)->first();
        $this->anggota = Anggota::where('id', $request->anggota_id)->first();

        if (!$this->buku || !$this->anggota)
            return redirect()->back()->with('error', 'Form tidak valid');

        $data = [
            'user_id' => $this->user->id,
            'anggota_id' => $this->anggota->id,
            'buku_id' => $this->buku->id,
            'tgl_pinjam' => date('Y-m-d H:i:s'),
        ];

        DB::beginTransaction();
        try {
            $this->buku->update(['status' => 'Dipinjam']);
            ModelsPinjam::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Data peminjaman berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data peminjaman gagal disimpan.<br>' . $e->getMessage());
        }
    }
}
