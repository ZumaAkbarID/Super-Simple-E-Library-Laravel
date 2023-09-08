<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Account extends Controller
{
    public $user;

    function index()
    {
        $this->user = Auth::user();

        return view('Anggota.Index', [
            'title' => parent::title('Anggota'),
            'user' => $this->user,
            'anggota' => DB::table('anggotas')->paginate(5, ['*'], 'anggota'),
            'petugas' => DB::table('users')->where('role', 'Petugas')->paginate(5,  ['*'], 'petugas'),
        ]);
    }
}
