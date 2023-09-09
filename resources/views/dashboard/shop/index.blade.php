@extends('dashboard.layouts.main')

@section('title')
@lang('app.data.shop')
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@lang('app.data.shop')</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header with-border">
                <button onclick="addForm('{{ route('shop.store') }}')" class="btn btn-success btn-sm "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <table id="table" class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Toko</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Tipe Nota</th>
                        <th>Logo</th>
                        <th>Member Card</th>
                        <th>Diskon Member</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('dashboard.shop.form')
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
            url: '/shop',
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'name'},
            {data: 'address'},
            {data: 'contact'},
            {data: 'bill_type',
            render: function(data, type, row) {
                    if (data === 1) {
                        return 'Nota Kecil';
                    } else if (data === 2) {
                        return 'Nota Besar';
                    } else {
                        return data; // Jika nilai tidak sesuai dengan 1 atau 2
                    }
                }
        },
            {data: 'logo_path'},
            {data: 'member_card_path'},
            {data: 'disc'},
            {data: 'aksi', searchable: false, sortable: false},
        ]
    });

    $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-modal').attr('action'),
                    type: $('.form-modal').attr('method'),
                    data: new FormData($('.form-modal')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
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
        $('#modal-form .modal-title').text('Tambah Toko');
        $('.tampil-logo').html(`<img src=""`);
        $('.tampil-kartu-member').html(`<img src=">`);
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Toko');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=name]').val(response.name);
                $('#modal-form [name=address]').val(response.address);
                $('#modal-form [name=contact]').val(response.contact);
                $('#modal-form [name=bill_type]').val(response.bill_type);
                $('.tampil-logo').html(`<img src="{{ url('/') }}${response.logo_path}" width="150">`);
                $('.tampil-kartu-member').html(`<img src="{{ url('/') }}${response.member_card_path}" width="200">`);
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
    
</script>
@endpush
