<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public $user;

    function index()
    {
        $this->user = Auth::user();

        $card = [
            'buku_dipinjam' => Pinjam::where('tgl_kembali', null)->count(),
            'total_pinjam' => Pinjam::all()->count(),
            'total_buku' => Buku::all()->count(),
            'anggota' => Anggota::all()->count()
        ];

        $table = [
            'pinjaman' => Pinjam::with(['anggota', 'buku'])->orderBy('id', 'DESC')->take(5)->get(),
            'topAnggota' => DB::table('pinjams')
                ->join('anggotas', 'pinjams.anggota_id', '=', 'anggotas.id')
                ->select('pinjams.user_id', 'anggotas.nama', 'anggotas.nim', 'anggotas.prodi', 'anggotas.kelas', DB::raw('COUNT(*) as count'))
                ->groupBy('pinjams.user_id', 'anggotas.nama', 'anggotas.nim', 'anggotas.prodi', 'anggotas.kelas')
                ->orderByDesc('count')
                ->take(5)
                ->get()
        ];

        return view('Dashboard', [
            'title' => parent::title('Dashboard'),
            'user' => $this->user,
            'card' => $card,
            'table' => $table,
        ]);
    }
}
