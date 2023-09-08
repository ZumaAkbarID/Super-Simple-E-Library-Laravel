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
                                    Anggota</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format(count($anggota), 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($user->role == 'Admin')
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Petugas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ number_format(count($petugas), 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="mb-3">
            <a class="btn btn-primary mb-2" href="#" data-toggle="modal" data-target="#modalTambahAnggota">
                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                Tambah Anggota
            </a>
            @if ($user->role == 'Admin')
                <a class="btn btn-warning mb-2" href="#" data-toggle="modal" data-target="#modalTambahPengurus">
                    <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                    Tambah Petugas
                </a>
            @endif
        </div>

        <div class="row">

            <div class="col-lg-12">
                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Anggota</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Nama</td>
                                        <td>NIM</td>
                                        <td>Program Studi</td>
                                        <td>Kelas</td>
                                        <td>Alamat</td>
                                        <td>Nomor HP</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($anggota as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->nim }}</td>
                                            <td>{{ $item->prodi }}</td>
                                            <td>{{ $item->kelas }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->hp }}</td>
                                            <td>
                                                <button type="button" onclick="editUser({{ $item->id }})"
                                                    class="btn btn-warning mb-1">Edit</button>
                                                <button type="button" onclick="hapusUser({{ $item->id }})"
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
                            {{ $anggota->links('Partials.Pagination') }}
                        </div>
                    </div>
                </div>

            </div>

            @if ($user->role == 'Admin')
                <div class="col-lg-12">

                    <!-- Basic Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Petugas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Nama Petugas</td>
                                            <td>Username</td>
                                            <td>Nomor HP</td>
                                            <td>Email</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($petugas as $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->hp }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <button type="button" onclick="editPengurus({{ $item->id }})"
                                                        class="btn btn-warning mb-1">Edit</button>
                                                    <button type="button" onclick="hapusPengurus({{ $item->id }})"
                                                        class="btn btn-danger mb-1">Hapus</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $petugas->links('Partials.Pagination') }}
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>

    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modalEditAnggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Anggota</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Anggota.Edit') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="edit-anggota-idUser">
                    <div class="modal-body">

                        <div class="form-group mb-2">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama" id="edit-anggota-nama" required
                                name="nama">
                        </div>

                        <div class="form-group mb-2">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" placeholder="NIM" id="edit-anggota-nim" required
                                name="nim">
                        </div>

                        <div class="form-group mb-2">
                            <label for="prodi">Program Studi</label>
                            <input type="text" class="form-control" placeholder="Program Studi"
                                id="edit-anggota-prodi" required name="prodi">
                        </div>

                        <div class="form-group mb-2">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" placeholder="Kelas" id="edit-anggota-kelas"
                                required name="kelas">
                        </div>

                        <div class="form-group mb-2">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" placeholder="Alamat" id="edit-anggota-alamat"
                                required name="alamat">
                        </div>

                        <div class="form-group mb-2">
                            <label for="hp">Nomor HP</label>
                            <input type="text" class="form-control" placeholder="08123xxx" id="edit-anggota-hp"
                                required name="hp">
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

    <div class="modal fade" id="modalTambahAnggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Anggota</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Anggota.Tambah') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-2">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama" required name="nama">
                        </div>

                        <div class="form-group mb-2">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" placeholder="NIM" required name="nim">
                        </div>

                        <div class="form-group mb-2">
                            <label for="prodi">Program Studi</label>
                            <input type="text" class="form-control" placeholder="Program Studi" required
                                name="prodi">
                        </div>

                        <div class="form-group mb-2">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" placeholder="Kelas" required name="kelas">
                        </div>

                        <div class="form-group mb-2">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" placeholder="Alamat" required name="alamat">
                        </div>

                        <div class="form-group mb-2">
                            <label for="hp">Nomor HP</label>
                            <input type="text" class="form-control" placeholder="08123xxx" required name="hp">
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

    <div class="modal fade" id="modalHapusAnggota" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Anggota</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('Anggota.Delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="hapus-anggota-id">
                    <div class="modal-body">Apakah Anda yakin ingin menghapus data Anggota?.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($user->role == 'Admin')
        <div class="modal fade" id="modalHapusPengurus" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Petugas</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('Pengurus.Delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="hapus-pengurus-id">
                        <div class="modal-body">Apakah Anda yakin ingin menghapus data Petugas?.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Ya, Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTambahPengurus" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Petugas</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('Pengurus.Tambah') }}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group mb-2">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" placeholder="Nama" required name="nama">
                            </div>

                            <div class="form-group mb-2">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" placeholder="Username" required
                                    name="username">
                            </div>

                            <div class="form-group mb-2">
                                <label for="hp">Nomor HP</label>
                                <input type="text" class="form-control" placeholder="08123xxx" required
                                    name="hp">
                            </div>

                            <div class="form-group mb-2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" placeholder="Alamat Email" required
                                    name="email">
                            </div>

                            <div class="form-group mb-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password" required
                                    name="password">
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

        <div class="modal fade" id="modalEditPengurus" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Petugas</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('Pengurus.Edit') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="edit-pengurus-id">
                        <div class="modal-body">

                            <div class="form-group mb-2">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" placeholder="Nama" required name="nama"
                                    id="edit-pengurus-nama">
                            </div>

                            <div class="form-group mb-2">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" placeholder="Username" required
                                    name="username" id="edit-pengurus-username">
                            </div>

                            <div class="form-group mb-2">
                                <label for="hp">Nomor HP</label>
                                <input type="text" class="form-control" placeholder="08123xxx" required
                                    name="hp" id="edit-pengurus-hp">
                            </div>

                            <div class="form-group mb-2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" placeholder="Alamat Email" required
                                    name="email" id="edit-pengurus-email">
                            </div>

                            <div class="form-group mb-2">
                                <label for="password">Password (Tidak wajib)</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    id="edit-pengurus-password">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        function hapusUser(id) {
            $('#hapus-anggota-id').val(id);
            $('#modalHapusAnggota').modal('show');
        }

        function editUser(id) {
            var userId = id;

            $.ajax({
                type: 'GET',
                url: '{{ url('/') }}/anggota/' + userId + '/data',
                success: function(response) {
                    var user = response;

                    $('#edit-anggota-nama').val(user.nama);
                    $('#edit-anggota-nim').val(user.nim);
                    $('#edit-anggota-kelas').val(user.kelas);
                    $('#edit-anggota-prodi').val(user.prodi);
                    $('#edit-anggota-alamat').val(user.alamat);
                    $('#edit-anggota-hp').val(user.hp);
                    $('#edit-anggota-idUser').val(user.id);
                    $('#modalEditAnggota').modal('show');
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

        @if ($user->role == 'Admin')
            function editPengurus(id) {
                var userId = id;

                $.ajax({
                    type: 'GET',
                    url: '{{ url('/') }}/pengurus/' + userId + '/data',
                    success: function(response) {
                        var user = response;

                        $('#edit-pengurus-id').val(user.id);
                        $('#edit-pengurus-nama').val(user.nama);
                        $('#edit-pengurus-username').val(user.username);
                        $('#edit-pengurus-hp').val(user.hp);
                        $('#edit-pengurus-email').val(user.email);
                        $('#modalEditPengurus').modal('show');
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

            function hapusPengurus(id) {
                $('#hapus-pengurus-id').val(id);
                $('#modalHapusPengurus').modal('show');
            }
        @endif
    </script>
@endsection
