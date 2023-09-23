@extends('dashboard.layouts.main')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body text-center">
                <h1>Selamat Datang {{ auth()->user()->name }}</h1>
                <h2>Anda login sebagai KASIR</h2>
                <br><br>
                <a href="/cashier" class="btn btn-success btn-lg">Transaksi Baru</a>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
<!-- /.row (main row) -->
@endsection