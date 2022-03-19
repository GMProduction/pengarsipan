@extends('admin.base')

@section('title')
    Data Admin
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
                <h5>Data Admin</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Admin
                </button>
            </div>
            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $v->username }}</td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm btn-edit" id="editData"
                                    data-id="{{ $v->id }}" data-username="{{ $v->username }}">edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $v->id }}">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data user</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/admin/admin/create">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username" name="username">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required class="form-control" id="password" name="password">
                                </div>
                                {{--                                <div class="mb-3">--}}
                                {{--                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>--}}
                                {{--                                    <input type="password" required class="form-control" id="password-confirmation"--}}
                                {{--                                           name="password_confirmation">--}}
                                {{--                                </div>--}}
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
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/admin/admin/patch">
                            @csrf
                            <input type="hidden" id="id-edit" name="id-edit">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" required class="form-control" id="username-edit"
                                       name="username-edit">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password-edit" name="password-edit">
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

            $('.btn-edit').on('click', function () {
                let id = this.dataset.id;
                let username = this.dataset.username;
                $('#id-edit').val(id);
                $('#username-edit').val(username);
                $('#modal-edit').modal('show');
            });

            $('.btn-delete').on('click', function () {
                let id = this.dataset.id;
                hapus(id);
            })
        });

        async function destroy(id) {
            try {
                let response = await $.post('/admin/admin/delete', {
                    _token: '{{ csrf_token() }}',
                    id: id
                });
                if (response['status'] === 200) {
                    swal("Berhasil Menghapus data!", {
                        icon: "success",
                    });
                    window.location.reload();
                } else {
                    swal("Gagal Menghapus Data", {
                        icon: "error",
                    });
                }
            } catch (e) {
                swal("Gagal Menghapus Data", {
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
                        destroy(id);
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>
@endsection
