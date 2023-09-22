@extends('dashboard.layouts.main')

@section('title')
    @lang('app.setting.shop')
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@lang('app.setting.shop')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="#" class="form-setting" data-toggle="validator" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="nama_perusahaan" class="col-lg-2 control-label">Nama Perusahaan</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" value="{{ $shop->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                        <div class="col-lg-6">
                            <textarea name="alamat" class="form-control" id="alamat" rows="3" readonly>{{ $shop->address }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact" class="col-lg-2 control-label">Kontak </label>
                        <div class="col-lg-6">
                            <input type="text" name="contact" class="form-control" id="contact" readonly value="{{ $shop->contact }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="path_logo" class="col-lg-2 control-label">Logo Perusahaan</label>
                        <div class="col-lg-4">
                            
                            <div class="tampil-logo">
                                <img src="{{ $shop->logo_path }}" width="200px">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="path_kartu_member" class="col-lg-2 control-label">Kartu Member</label>
                        <div class="col-lg-4">
                            <div class="tampil-kartu-member">
                                <img src="{{ $shop->member_card_path }}" width="200px">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                        <div class="col-lg-2">
                            <input type="number" name="diskon" class="form-control" id="diskon" readonly value="{{ $shop->disc }}">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe_nota" class="col-lg-2 control-label">Tipe Nota</label>
                        <div class="col-lg-2">
                            @if ($shop->bill_type == 1)
                                <label id="tipe_nota">Nota Kecil</label>
                            @elseif ($shop->bill_type == 2)
                                <label id="tipe_nota">Nota Besar</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

