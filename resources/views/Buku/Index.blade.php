@extends('Layouts.Main')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Buku</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format(count($bukus), 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mb-3">
            <a class="btn btn-primary mb-2" href="#" data-toggle="modal" data-target="#modalTambahBuku">
                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                Tambah Buku
            </a>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Buku</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Kode</td>
                                        <td>Judul</td>
                                        <td>Pengarang</td>
                                        <td>Penerbit</td>
                                        <td>Tahun Terbit</td>
                                        <td>Status</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bukus as $item)
                                        <tr>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->pengarang }}</td>
                                            <td>{{ $item->penerbit }}</td>
                                            <td>{{ $item->tahun_penerbit }}</td>
                                            <td>
                                                @if ($item->status == 'Tersedia')
                                                    <div class="badge bg-success">{{ $item->status }}</div>
                                                @else
                                                    <div class="badge bg-warning">{{ $item->status }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" onclick="editBuku({{ $item->id }})"
                                                    class="btn btn-warning mb-1">Edit</button>
                                                <button type="button" onclick="hapusBuku({{ $item->id }})"
                                                    class="btn btn-danger mb-1">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $bukus->links('Partials.Pagination') }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modalEditBuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Buku</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Buku.Edit') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="edit-buku-id">
                    <div class="modal-body">

                        <div class="form-group mb-2">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" placeholder="Judul buku" required name="judul"
                                id="edit-buku-judul">
                        </div>

                        <div class="form-group mb-2">
                            <label for="pengarang">Pengarang</label>
                            <input type="text" class="form-control" placeholder="Pengarang buku" required
                                name="pengarang" id="edit-buku-pengarang">
                        </div>

                        <div class="form-group mb-2">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" placeholder="Penerbit buku" required name="penerbit"
                                id="edit-buku-penerbit">
                        </div>

                        <div class="form-group mb-2">
                            <label for="tahun_penerbit">Tahun Terbit</label>
                            <input type="number" class="form-control" placeholder="Tahun terbit buku" required
                                name="tahun_penerbit" id="edit-buku-tahun-penerbit">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahBuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Buku.Tambah') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-2">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" placeholder="Judul buku" required name="judul">
                        </div>

                        <div class="form-group mb-2">
                            <label for="pengarang">Pengarang</label>
                            <input type="text" class="form-control" placeholder="Pengarang buku" required
                                name="pengarang">
                        </div>

                        <div class="form-group mb-2">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" placeholder="Penerbit buku" required
                                name="penerbit">
                        </div>

                        <div class="form-group mb-2">
                            <label for="tahun_penerbit">Tahun Terbit</label>
                            <input type="number" class="form-control" placeholder="Tahun terbit buku" required
                                name="tahun_penerbit">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusBuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Buku</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Buku.Delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="hapus-buku-id">
                    <div class="modal-body">Apakah Anda yakin ingin menghapus data Buku?.</div>
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
        function hapusBuku(id) {
            $('#hapus-buku-id').val(id);
            $('#modalHapusBuku').modal('show');
        }

        function editBuku(id) {

            $.ajax({
                type: 'GET',
                url: '{{ url('/') }}/buku/' + id + '/data',
                success: function(response) {
                    var user = response;

                    $('#edit-buku-id').val(user.id);
                    $('#edit-buku-judul').val(user.judul);
                    $('#edit-buku-pengarang').val(user.pengarang);
                    $('#edit-buku-penerbit').val(user.penerbit);
                    $('#edit-buku-tahun-penerbit').val(user.tahun_penerbit);
                    $('#modalEditBuku').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: "Error fetching user data."
                    });
                    $('.swal2-select').addClass('d-none');
                }
            });
        }
    </script>
@endsection
