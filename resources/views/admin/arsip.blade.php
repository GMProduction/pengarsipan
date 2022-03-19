@extends('admin.base')

@section('title')
    Data Arsip
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
                <h5>Data Arsip</h5>
                <div class="form-group">
                    <label for="exampleFormControlSelect1" class="text-end d-block">Tahun</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option selected>2022</option>
                        <option>2021</option>
                        <option>2020</option>
                    </select>
                </div>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Arsip</th>
                        <th>Nama Perusahaan</th>
                        <th>Tahun</th>
                        <th>Tanggal Berkas</th>
                        <th>Keterangan</th>
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
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" id="detail" onclick="">detail</button>
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
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Arsip</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Judul Arsip</label>
                                    <input type="text" class="form-control" id="judul" name="judul">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat">Nama Perusahaan</label>
                                    <input class="form-control" id="nama_perusahaan" rows="3"
                                        name="nama_perusahaan"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="nphp" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="Tahun" name="Tahun">
                                </div>
                                <div class="mb-3">
                                    <label for="no_ktp" class="form-label">Tanggal Berkas</label>
                                    <input type="number" class="form-control" id="tanggal" name="tanggal">
                                </div>
                                <div class="mt-3 mb-2">
                                    <label for="foto" class="form-label">Keterangan</label>
                                    <textarea class="form-control"></textarea>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary">ACC</button>
                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                    <button type="submit" class="btn btn-success">Download</button>
                                </div>
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

        $(document).on('click', '#detail, #addData', function() {
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
