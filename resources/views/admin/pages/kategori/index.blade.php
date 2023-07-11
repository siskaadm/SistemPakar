@extends('admin.layouts.app', [
'elementActive' => 'kategori'
])
@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <h1>Kategori<h1>
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
                                                <h5 class="modal-title">Tambah Kategori</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{route('kategori.store')}}"
                                                    enctype="multipart/form-data">

                                                    {{ csrf_field() }}

                                                    <div class="form-group">
                                                        <label>Kode Kategori</label>
                                                        <input type="text" name="kode_kategori" class="form-control"
                                                            placeholder="">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Daftar Solusi</label>
                                                        <select name="solusis[]" class="select2bs4 select2-multiple form-control" multiple>
                                                            @foreach ($solusis as $solusi)
                                                                <option value="{{ $solusi->kode_solusi }}">{{ $solusi->kode_solusi . ' - ' . $solusi->deskripsi_solusi }}
                                                            @endforeach
                                                        </select>
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
                                                <th>No</th>
                                                <th>Kode Kategori</th>
                                                <th>Daftar Solusi</th>
                                                <th>Aksi</th>
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
                                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                                <script>
                                    $(function() {
                                        var table = $('.yajra-datatable').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            responsive: true,
                                            ajax: "{{ route('kategori.list') }}",
                                            columns: [
                                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                            // {data: 'no', name: 'no'},
                                            {data: 'kode_kategori', name: 'kode_kategori'},
                                            {data: 'solusis', name: 'solusis'},
                                            {
                                                data: 'action',
                                                name: 'action',
                                                orderable: true,
                                                searchable: true
                                            },
                                            ]
                                        });

                                        $('.select2-multiple').select2({
                                            dropdownParent: $('#modalTambahBarang'),
                                            width: '100%',
                                        })
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