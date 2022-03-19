@extends('admin.base')

@section('title')
    Data Arsip
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
                <h5>Data Arsip</h5>
                <div class="form-group">
                    <label for="tahun" class="text-end d-block">Tahun</label>
                    <select class="form-control" id="tahun" name="tahun">
                        <option value="">Semua</option>
                        @foreach($tahun as $v)
                            <option>{{ $v->tahun_pajak }}</option>
                        @endforeach
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="data-container">

                </tbody>
                {{--                <tr>--}}
                {{--                    <td></td>--}}
                {{--                    <td></td>--}}
                {{--                    <td></td>--}}
                {{--                    <td></td>--}}
                {{--                    <td></td>--}}
                {{--                    <td></td>--}}
                {{--                    <td>--}}
                {{--                        <button type="button" class="btn btn-primary btn-sm" id="detail" onclick="">detail</button>--}}
                {{--                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>--}}
                {{--                    </td>--}}
                {{--                </tr>--}}
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
            <div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Data Arsip</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input id="id" name="id" hidden>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Judul Arsip</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="perusahaan">Nama Perusahaan</label>
                                <textarea class="form-control" id="perusahaan" rows="3"
                                          name="perusahaan"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tahun_pajak" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="tahun_pajak" name="tahun_pajak">
                            </div>
                            <div class="mb-3">
                                <label for="no_ktp" class="form-label">Tanggal Berkas</label>
                                <input type="number" class="form-control" id="tanggal" name="tanggal">
                            </div>
                            <div class="mt-3 mb-2">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-2">
                                    <label for="baris" class="form-label">Baris</label>
                                    <input type="number" class="form-control" id="baris" name="baris">
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="sisi" class="form-label">Sisi</label>
                                    <input type="number" class="form-control" id="sisi" name="sisi">
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="rak" class="form-label">Rak</label>
                                    <input type="number" class="form-control" id="rak" name="rak">
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="lantai" class="form-label">Lantai</label>
                                    <input type="number" class="form-control" id="lantai" name="lantai">
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="box" class="form-label">Box</label>
                                    <input type="number" class="form-control" id="box" name="box">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-primary btn-acc" id="btn-acc">ACC</button>
                                <button type="button" class="btn btn-danger btn-tolak" id="btn-tolak">Tolak</button>
                                <a href="#" type="button" class="btn btn-success btn-download" id="btn-download">Download
                                </a>
                            </div>
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
            getDataArsip();
            $('#btn-acc').on('click', function () {
                let id = this.dataset.id;
                let status = 1;
                confirmArsip(id, status);
            });

            $('#btn-tolak').on('click', function () {
                let id = this.dataset.id;
                let status = 2;
                confirmArsip(id, status);
            });
        });

        function elTable(data, key) {
            let status = 'Menunggu';
            switch (data['status']) {
                case 1:
                    status = 'Di Terima';
                    break;
                case 2:
                    status = 'Di Tolak';
                    break;
                default:
                    break;
            }
            return '<tr>' +
                '<td>' + key + '</td>' +
                '<td>' + data['nama'] + '</td>' +
                '<td>' + data['perusahaan']['nama'] + '</td>' +
                '<td>' + data['tahun_pajak'] + '</td>' +
                '<td>' + data['tanggal'] + '</td>' +
                '<td>' + data['keterangan'] + '</td>' +
                '<td>' + status + '</td>' +
                '<td>' +
                '<button type="button" class="btn btn-primary btn-sm btn-detail" id="detail" ' +
                'data-id="' + data['id'] + '"' +
                'data-nama="' + data['nama'] + '"' +
                'data-perusahaan="' + data['perusahaan']['nama'] + '"' +
                'data-tahun="' + data['tahun_pajak'] + '"' +
                'data-tanggal="' + data['tanggal'] + '"' +
                'data-keterangan="' + data['keterangan'] + '"' +
                'data-baris="' + data['baris'] + '"' +
                'data-sisi="' + data['sisi'] + '"' +
                'data-rak="' + data['rak'] + '"' +
                'data-lantai="' + data['lantai'] + '"' +
                'data-box="' + data['box'] + '"' +
                'data-url="' + data['url'] + '"' +
                '>detail</button>' +
                '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' + data['id'] + '">hapus</button>' +
                '</td>' +
                '</tr>';
        }

        async function getDataArsip() {
            try {
                let tahun = $('#tahun').val();
                let el = $('#data-container');
                let response = await $.get('/admin/arsip/data?tahun=' + tahun);
                if (response['status'] === 200) {
                    $.each(response['payload'], function (k, v) {
                        el.append(elTable(v, (k + 1)));
                    });
                    $('.btn-detail').on('click', function () {
                        $('#nama').val(this.dataset.nama);
                        $('#perusahaan').val(this.dataset.perusahaan);
                        $('#tahun_pajak').val(this.dataset.tahun);
                        $('#tanggal').val(this.dataset.tanggal);
                        $('#keterangan').val(this.dataset.keterangan);
                        $('#baris').val(this.dataset.baris);
                        $('#sisi').val(this.dataset.sisi);
                        $('#rak').val(this.dataset.rak);
                        $('#lantai').val(this.dataset.lantai);
                        $('#box').val(this.dataset.box);
                        $('#btn-acc').attr('data-id', this.dataset.id);
                        $('#btn-tolak').attr('data-id', this.dataset.id);
                        $('#btn-download').attr('href', this.dataset.url);
                        $('#btn-download').attr('target', '_blank');
                        $('#modal-detail').modal('show');
                    });

                    $('.btn-delete').on('click', function () {
                        let id = this.dataset.id;
                        hapus(id);
                    })
                } else {
                    alert('Terjadi Kesalahan');
                }
                console.log(response);
            } catch (e) {
                alert('Terjadi Kesalahan');
            }

        }

        async function confirmArsip(id, status) {
            try {
                let response = await $.post('/admin/arsip/confirm', {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status
                });
                if (response['status'] === 200) {
                    swal("Berhasil Mengkonfirmasi data!", {
                        icon: "success",
                    });
                    window.location.reload();
                } else {
                    swal("Gagal Mengkonfirmasi data!", {
                        icon: "error",
                    });
                }
            } catch (e) {
                swal("Gagal Mengkonfirmasi data!", {
                    icon: "error",
                });
            }
        }

        async function destroyArsip(id) {
            try {
                let response = await $.post('/admin/arsip/delete', {
                    _token: '{{ csrf_token() }}',
                    id: id,
                });
                if (response['status'] === 200) {
                    swal("Berhasil Menghapus data!", {
                        icon: "success",
                    });
                    window.location.reload();
                } else {
                    swal("Gagal Menghapus data!", {
                        icon: "error",
                    });
                }
            } catch (e) {
                swal("Gagal Menghapus data!", {
                    icon: "error",
                });
            }
        }

        function hapus(id) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        destroyArsip(id);
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>
@endsection
