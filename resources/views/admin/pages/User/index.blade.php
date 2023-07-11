@extends('admin.layouts.app', [
'elementActive' => 'user'
])
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <h1>User<h1>
        </div>
        <div class="col-md-12">
            <div class="container-fluid bg-white p-4">
                <div class="mb-4">
                    <table>
                        <div class="container-small">
                            <div class="row">
                                <button type="button" class="btn btn-md btn-primary" data-toggle="modal"
                                    data-target="#modalTambahBarang">Tambah</button>
                                <div class="modal fade" id="modalTambahBarang" tabindex="-1"
                                    aria-labelledby="modalTambahBarang" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah User</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{route('user.store')}}"
                                                    enctype="multipart/form-data">

                                                    {{ csrf_field() }}

                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" name="username" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Level</label>
                                                        <select name="level" class="form-control">
                                                            <option value="admin">admin</option>
                                                            <option value="pakar">pakar</option>
                                                            <option value="pengguna">pengguna</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" name="password" class="form-control" placeholder="">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-success" value="Tambah">
                                                    </div>

                                                </form>
                                                <!--END FORM TAMBAH BARANG-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100">
                                    <table class="table table-bordered yajra-datatable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Level</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <form action="" id="delete-form" method="post">
                                    @method('delete')
                                    @csrf
                                </form>

                                @section('javascript')
                                <script>
                                    $(function() {
                                        var table = $('.yajra-datatable').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            responsive: true,
                                            ajax: "{{ route('user.index') }}",
                                            columns: [
                                            {data: 'id', name: 'id'},
                                            {data: 'name', name: 'name'},
                                            {data: 'level', name: 'level'},
                                            {
                                                data: 'action',
                                                name: 'action',
                                                orderable: true,
                                                searchable: true
                                            },
                                            ]
                                        });
                                    });
                                </script>
                                <script>
                                    function notificationBeforeDelete(event, el) {
                                        event.preventDefault();
                                        // if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                                        //     $("#delete-form").attr('action', $(el).attr('href'));
                                        //     $("#delete-form").submit();
                                        // }
                                        Swal.fire({
                                            title: 'Apakah kamu yakin akan mengapus file ini?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            cancelButtonText: 'Batal',
                                            confirmButtonText: 'Ya'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                            $("#delete-form").attr('action', $(el).attr('href'));
                                            $("#delete-form").submit();
                                                Swal.fire(
                                                'Berhasil Dihapus',
                                                // 'Your file has been deleted.',
                                                // 'success'
                                                )
                                            }
                                        })
                                    }
                                </script>
                                @endsection
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection