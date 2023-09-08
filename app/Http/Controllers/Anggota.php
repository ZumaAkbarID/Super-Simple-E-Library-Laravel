<?php

namespace App\Http\Controllers;

use App\Models\Anggota as ModelsAnggota;
use Illuminate\Http\Request;

class Anggota extends Controller
{

    function getUser($id)
    {
        $anggota = ModelsAnggota::findOrFail($id);

        if ($anggota) {
            return response()->json($anggota);
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
                'nim' => 'required|unique:anggotas,nim',
                'prodi' => 'required',
                'kelas' => 'required',
                'alamat' => 'required',
                'hp' => 'required',
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'nim.required' => 'NIM tidak boleh kosong',
                'nim.unique' => 'NIM sudah terdaftar',
                'prodi.required' => 'Program Studi tidak boleh kosong',
                'kelas.required' => 'Kelas tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'hp.required' => 'Nomor HP tidak boleh kosong',
            ]
        );

        $data = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ];

        try {
            ModelsAnggota::create($data);

            return redirect()->back()->with('success', 'Data anggota berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data anggota gagal ditambahkan');
        }
    }

    function editHandler(Request $request)
    {
        $anggota = ModelsAnggota::findOrFail($request->id);

        $this->validate(
            $request,
            [
                'id' => 'required|numeric',
                'nama' => 'required',
                'nim' => 'required|unique:anggotas,nim,' . $request->id,
                'prodi' => 'required',
                'kelas' => 'required',
                'alamat' => 'required',
                'hp' => 'required',
            ],
            [
                'id.required' => 'Form tidak valid',
                'id.numeric' => 'Form tidak valid',
                'nama.required' => 'Nama tidak boleh kosong',
                'nim.required' => 'NIM tidak boleh kosong',
                'nim.unique' => 'NIM sudah terdaftar',
                'prodi.required' => 'Program Studi tidak boleh kosong',
                'kelas.required' => 'Kelas tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'hp.required' => 'Nomor HP tidak boleh kosong',
            ]
        );

        $data = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ];

        try {
            $anggota->update($data);

            return redirect()->back()->with('success', 'Data anggota berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data anggota gagal diperbarui');
        }
    }

    function deleteHandler(Request $request)
    {
        $anggota = ModelsAnggota::findOrFail($request->id);

        try {
            $anggota->delete();
            return redirect()->back()->with('success', 'Data anggota berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data anggota gagal dihapus');
        }
    }
}
