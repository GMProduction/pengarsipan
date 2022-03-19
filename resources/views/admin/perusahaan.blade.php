@extends('admin.base')

@section('title')
    Data Perusahaan
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success");
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            swal("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error");
        </script>
    @endif
    <section class="m-2">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Data Perusahaan</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Perusahaan
                </button>
            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Perusahaan</th>
                    <th>Alamat</th>
                    <th>No Hp</th>
                    <th>No. NPWP</th>
                    <th>Foto NPWP</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $v->nama }}</td>
                        <td>{{ $v->alamat }}</td>
                        <td>{{ $v->no_hp}}</td>
                        <td>{{ $v->npwp}}</td>
                        <td width="100">
                            <img src="{{ $v->npwp_url !== null ? $v->npwp_url : '' }}"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td>{{ $v->user->username}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit" id="editData"
                                    data-id="{{ $v->id }}"
                                    data-nama="{{ $v->nama }}"
                                    data-alamat="{{ $v->alamat }}"
                                    data-no_hp="{{ $v->no_hp }}"
                                    data-npwp="{{ $v->npwp }}"
                                    data-npwp_url="{{ $v->npwp_url }}"
                                    data-username="{{ $v->user->username }}"
                            >
                                edit
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data user</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
            </div>
        </div>


        <div>
            <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Perusahaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/admin/perusahaan/create" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat">Alamat</label>
                                    <textarea required class="form-control" id="alamat" rows="3"
                                              name="alamat"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="no_hp" name="no_hp">
                                </div>
                                <div class="mb-3">
                                    <label for="npwp" class="form-label">No. NPWP</label>
                                    <input type="number" required class="form-control" id="npwp" name="npwp">
                                </div>
                                <div class="mt-3 mb-2">
                                    <label for="npwp_url" class="form-label">Foto NPWP</label>
                                    <input class="form-control" type="file" id="npwp_url" name="npwp_url">
                                    <div id="showFoto"></div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username" name="username">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Perusahaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/admin/perusahaan/patch" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id-edit" id="id-edit">
                            <div class="mb-3">
                                <label for="nama-edit" class="form-label">Nama</label>
                                <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
                            </div>
                            <div class="mb-3">
                                <label for="alamat-edit">Alamat</label>
                                <textarea required class="form-control" id="alamat-edit" rows="3"
                                          name="alamat-edit"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="np_hp-edit" class="form-label">no. Hp</label>
                                <input type="number" required class="form-control" id="no_hp-edit" name="no_hp-edit">
                            </div>
                            <div class="mb-3">
                                <label for="npwp-edit" class="form-label">No. NPWP</label>
                                <input type="number" required class="form-control" id="npwp-edit" name="npwp-edit">
                            </div>
                            <div class="mt-3 mb-2">
                                <label for="npwp_url-edit" class="form-label">Foto NPWP</label>
                                <input class="form-control" type="file" id="npwp_url-edit" name="npwp_url-edit">
                                <div id="showFoto"></div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="username-edit" class="form-label">Username</label>
                                <input type="text" required class="form-control" id="username-edit"
                                       name="username-edit">
                            </div>
                            <div class="mb-3">
                                <label for="password-edit" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password-edit"
                                       name="password-edit">
                            </div>
                            <div class="mb-4"></div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#addData').on('click', function () {
                $('#modal-add').modal('show');
            });

            $('#editData').on('click', function () {
                $('#id-edit').val(this.dataset.id);
                $('#nama-edit').val(this.dataset.nama);
                $('#alamat-edit').val(this.dataset.alamat);
                $('#no_hp-edit').val(this.dataset.no_hp);
                $('#npwp-edit').val(this.dataset.npwp);
                $('#username-edit').val(this.dataset.username);
                $('#modal-edit').modal('show');
            });
        });



        function hapus(id, name) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Menghapus data!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
