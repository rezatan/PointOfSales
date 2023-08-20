@extends('dashboard.layouts.main')

@section('title')
@lang('sidebar.product.stock')
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@lang('sidebar.product.stock')</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card card-primary card-outline px-1 py-2">
            <div class="box-header with-border mb-2">
                <button onclick="addForm('{{ route('stock.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class=" table-responsive">
                <table id="table" class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kategori</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('dashboard.category.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
    table = $('.table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '/category',
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'name'},
            {data: 'aksi', searchable: false, sortable: false},
        ]
    });

    $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });
       
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.name);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
