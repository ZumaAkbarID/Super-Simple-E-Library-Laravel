<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataPinjam extends Controller
{
    public $user, $dataPinjam, $dataBuku;

    function index()
    {
        $this->user = Auth::user();
        $this->dataPinjam = Pinjam::with(['user', 'anggota', 'buku'])->get();

        return view('Data.Pinjam', [
            'title' => parent::title('Data Pinjaman'),
            'user' => $this->user,
            'dataPinjam' => $this->dataPinjam
        ]);
    }

    function signBookBackHandler($id)
    {
        $this->dataPinjam = Pinjam::findOrFail($id);
        $this->dataBuku = Buku::findOrFail($this->dataPinjam->buku_id);

        DB::beginTransaction();
        try {
            $this->dataBuku->update(['status' => 'Tersedia']);
            $this->dataPinjam->update(['tgl_kembali' => date('Y-m-d H:i:s')]);
            DB::commit();
            return redirect()->back()->with('success', 'Data pinjaman berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data pinjaman gagal diperbarui');
        }
    }

    function deleteHandler(Request $request)
    {
        $this->dataPinjam = Pinjam::findOrFail($request->id);
        $this->dataBuku = Buku::findOrFail($this->dataPinjam->buku_id);

        try {
            if ($this->dataBuku->status == 'Dipinjam') {
                $this->dataBuku->update(['status' => 'Tersedia']);
            }
            $this->dataPinjam->delete();
            return redirect()->back()->with('success', 'Data pinjaman berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data pinjaman gagal dihapus');
        }
    }
}
