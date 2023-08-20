@extends('dashboard.layouts.main')

@section('title')
@lang('sidebar.product.product')
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@lang('sidebar.product.product')</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card card-primary card-outline px-1 py-2">
            <div class="box-header with-border mb-2">
                <button onclick="addForm('{{ route('product.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class=" table-responsive">
                <table id="table" class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>

                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('dashboard.product.form')
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
                url: '/product',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'code'},
                {data: 'name'},
                {data: 'category.name'},
                {data: 'brand'},
                {data: 'sell_price'},
                {data: 'disc'},
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

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=category_id]').val(response.category.id);
                $('#modal-form [name=brand]').val(response.brand);
                $('#modal-form [name=sell_price]').val(response.sell_price);
                $('#modal-form [name=disc]').val(response.disc);
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

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, $('.form-produk').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menghapus data');
                        return;
                    });
            }
        } else {
            alert('Pilih data yang akan dihapus');
            return;
        }
    }

    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
            return;
        } else {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush
