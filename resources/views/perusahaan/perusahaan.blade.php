@extends('admin.base')

@section('title')
    Data Perusahaan
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
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

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" id="editData" onclick="">edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
                    </td>
                </tr>

                {{-- @forelse($data as $key => $d)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->pelanggan ? $d->pelanggan->alamat : '' }}</td>
                        <td>{{ $d->pelanggan ? $d->pelanggan->no_hp : '' }}</td>
                        <td width="100">
                            <img src="{{ $d->pelanggan ? $d->pelanggan->foto_ktp : '' }}"
                                onerror="this.src='{{ asset('/images/noimage.png') }}'; this.error=null"
                                style=" height: 100px; object-fit: cover" />
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data user</td>
                    </tr>
                @endforelse --}}

                
            </table>
            <div class="d-flex justify-content-end">
                {{-- {{ $data->links() }} --}}
            </div>
        </div>


        <div>


            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Perusahaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat">Alamat</label>
                                    <textarea required class="form-control" id="alamat" rows="3" name="alamat"></textarea>
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
                                <div class="mb-3">
                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" required class="form-control" id="password-confirmation"
                                        name="password_confirmation">
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
        $(document).ready(function() {

        })

        $(document).on('click', '#editData, #addData', function() {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #nphp').val($(this).data('hp'))
            $('#modal #alamat').val($(this).data('alamat'))
            $('#modal #no_ktp').val($(this).data('ktp'))
            $('#modal #username').val($(this).data('username'))
            $('#modal #password').val('')
            $('#modal #password-confirmation').val('')
            $('#showFoto').empty();
            if ($(this).data('id')) {
                $('#modal #password').val('**********')
                $('#modal #password-confirmation').val('**********')
            }
            if ($(this).data('foto')) {
                $('#showFoto').html('<img src="' + $(this).data('foto') + '" height="50">')
            }
            $('#modal').modal('show')
        })

        function save() {
            saveData('Simpan Data', 'form');
            return false;
        }

        function after() {

        }

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
