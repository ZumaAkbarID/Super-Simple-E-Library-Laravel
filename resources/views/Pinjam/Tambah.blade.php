@extends('Layouts.Main')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Buat Pinjaman Buku</h6>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('Pinjam.Tambah') }}" method="post">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="buku_id">Judul Buku</label>
                                <select name="buku_id" id="buku_id" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Buku --</option>
                                    @foreach ($buku as $item)
                                        <option value="{{ $item->id }}">{{ $item->judul . ' (' . $item->kode . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="anggota_id">Anggota</label>
                                <select name="anggota_id" id="anggota_id" class="form-control" required>
                                    <option value="" selected disabled>-- Pilih Anggota --</option>
                                    @foreach ($anggota as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama . ' (' . $item->nim . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row justify-content-end mb-3 mr-1">
                                <button type="submit" class="btn btn-primary">Buat Pinjaman</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
