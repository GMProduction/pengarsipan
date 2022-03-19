@extends('admin.base')

@section('title')
    Data Siswa
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
                        <td>{{ $v->user->username}}</td>
                        <td width="100">
                            <img src="{{ $d->npwp_url !== null ? $d->npwp_url : '' }}"
                                 onerror="this.src='{{ asset('/images/noimage.png') }}'; this.error=null"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit" id="editData" onclick="">
                                edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete">hapus</button>
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


            <!-- Modal Tambah-->
            <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
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
                                    <label for="nphp" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="nphp" name="no_hp">
                                </div>
                                <div class="mb-3">
                                    <label for="no_ktp" class="form-label">No. NPWP</label>
                                    <input type="number" required class="form-control" id="no_ktp" name="no_ktp">
                                </div>
                                <div class="mt-3 mb-2">
                                    <label for="foto" class="form-label">Foto NPWP</label>
                                    <input class="form-control" type="file" id="foto" name="foto_ktp">
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

    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#addData').on('click', function () {
                $('#modal-add').modal('show');
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
