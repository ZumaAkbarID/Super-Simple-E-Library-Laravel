<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Pengurus extends Controller
{
    function getUser($id)
    {
        $pengurus = User::findOrFail($id);

        if ($pengurus) {
            return response()->json($pengurus);
        } else {
            return response()->json(['status' => false], 404);
        }
    }

    function addHandler(Request $request)
    {
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'username' => 'required',
                'hp' => 'required',
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'hp.required' => 'Nomor HP tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
            ]
        );

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'hp' => $request->hp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Petugas',
        ];

        try {
            User::create($data);

            return redirect()->back()->with('success', 'Data petugas berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data petugas gagal ditambahkan');
        }
    }

    function editHandler(Request $request)
    {
        $pengurus = User::findOrFail($request->id);

        $this->validate(
            $request,
            [
                'id' => 'required|numeric',
                'nama' => 'required',
                'username' => 'required',
                'hp' => 'required',
                'email' => 'required',
            ],
            [
                'id.required' => 'Form tidak valid',
                'id.numeric' => 'Form tidak valid',
                'nama.required' => 'Nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'hp.required' => 'Nomor HP tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
            ]
        );

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'hp' => $request->hp,
            'email' => $request->email,
        ];

        if ($request->password)
            $data['password'] = Hash::make($request->password);

        try {
            $pengurus->update($data);

            return redirect()->back()->with('success', 'Data petugas berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data petugas gagal diperbarui');
        }
    }

    function deleteHandler(Request $request)
    {
        $pengurus = User::findOrFail($request->id);

        try {
            $pengurus->delete();
            return redirect()->back()->with('success', 'Data petugas berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data petugas gagal dihapus');
        }
    }
}
