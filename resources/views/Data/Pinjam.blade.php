@extends('Layouts.Main')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12">

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman Buku</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Nama Peminjam</td>
                                        <td>Judul Buku</td>
                                        <td>Nama Petugas</td>
                                        <td>Tanggal Pinjam</td>
                                        <td>Tanggal Kembali</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataPinjam as $item)
                                        <tr>
                                            <td>{{ $item->user->nama }}</td>
                                            <td>{{ $item->buku->judul }}</td>
                                            <td>{{ $item->user->nama }}</td>
                                            <td>{{ date('D d M, Y H:i:s', strtotime($item->tgl_pinjam)) }}</td>
                                            <td>
                                                @if (is_null($item->tgl_kembali))
                                                    <div class="badge bg-warning">Sedang Dipinjam</div>
                                                @else
                                                    {{ date('D d M, Y H:i:s', strtotime($item->tgl_kembali)) }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('Data.Kembali', $item->id) }}"
                                                    class="btn btn-warning mb-1">Buku Dikembalikan</a>
                                                <button type="button" onclick="hapusPinjam({{ $item->id }})"
                                                    class="btn btn-danger mb-1">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
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

    <div class="modal fade" id="modalHapusPinjam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pinjaman?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Data.Delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="hapus-pinjam-id">
                    <div class="modal-body">Apakah Anda yakin ingin menghapus data pinjaman ini?.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hapusPinjam(id) {
            $('#hapus-pinjam-id').val(id);
            $('#modalHapusPinjam').modal('show');
        }
    </script>
@endsection
