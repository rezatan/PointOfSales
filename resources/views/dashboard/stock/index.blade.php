@extends('dashboard.layouts.main')

@section('title')
@lang('app.product.stock')
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@lang('app.product.stock')</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header with-border">
                <button onclick="addForm('{{ route('stock.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
                <button onclick="deleteSelected('{{ route('stock.delete_selected') }}')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                <button onclick="cetakBarcode('{{ route('stock.print_barcode') }}')" class="btn btn-info btn-sm btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
            </div>
            <div class="card-body table-responsive">
                <form action="" method="post" class="form-stock">
                    @csrf
                <table id="table" class="table table-stiped table-bordered">
                    <thead>
                        <th>No</th>
                        <th>
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Stock</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('dashboard.stock.form')
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
                url: '/stock',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'product.name'},
                {data: 'product.category.name'},
                {data: 'supplier.name'},
                {data: 'buy_price'},
                {data: 'sell_price'},
                {data: 'disc'},
                {data: 'qty'},
                {data: 'action', searchable: false, sortable: false},
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
        $('#modal-form .modal-title').text('Tambah Stock');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=qty]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Stock');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=qty]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=product_id]').val(response.product_id);
                $('#modal-form [name=supplier_id]').val(response.supplier_id);
                $('#modal-form [name=buy_price]').val(response.buy_price);
                $('#modal-form [name=sell_price]').val(response.sell_price);
                $('#modal-form [name=disc]').val(response.disc);
                $('#modal-form [name=qty]').val(response.qty);
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
                $.post(url, $('.form-stock').serialize())
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
            $('.form-stock')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush
