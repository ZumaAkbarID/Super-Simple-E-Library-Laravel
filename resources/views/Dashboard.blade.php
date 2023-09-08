@extends('Layouts.Main')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Buku Sedang Dipinjam</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($card['buku_dipinjam'], 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Peminjaman Buku</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($card['total_pinjam'], 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bookmark fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Buku</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($card['total_buku'], 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Anggota</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($card['anggota'], 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">5 Pinjaman Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Nama Peminjam</td>
                                        <td>Judul Buku</td>
                                        <td>Tanggal Pinjam</td>
                                        <td>Tanggal Kembali</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($table['pinjaman'] as $item)
                                        <tr>
                                            <td>{{ $item->anggota->nama }}</td>
                                            <td>{{ $item->buku->judul }}</td>
                                            <td>{{ date('D d M, Y H:i:s', strtotime($item->tgl_pinjam)) }}</td>
                                            <td>
                                                @if (is_null($item->tgl_kembali))
                                                    <div class="badge bg-warning">Sedang Dipinjam</div>
                                                @else
                                                    {{ date('D d M, Y H:i:s', strtotime($item->tgl_kembali)) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-12">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 Anggota</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Nama Anggota</td>
                                        <td>NIM</td>
                                        <td>Program Studi</td>
                                        <td>Kelas</td>
                                        <td>Total Pinjam</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($table['topAnggota'] as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->nim }}</td>
                                            <td>{{ $item->prodi }}</td>
                                            <td>{{ $item->kelas }}</td>
                                            <td>{{ $item->count }}x</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
