@extends('dashboard.layouts.main')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@push('css')
      <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush
@section('content')  
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $data['category'] }}</h3>
  
                  <p>Total @lang('app.category')</p>
                </div>
                <div class="icon">
                  <i class="fa fa-cube"></i>
                </div>
                <a href="{{ route('category.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ $data['product'] }}</sup></h3>
  
                  <p>Total @lang('app.product')</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tags"></i>
                </div>
                <a href="{{ route('product.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ $data['stock'] }}</h3>
  
                  <p>Total @lang('app.stock')</p>
                </div>
                <div class="icon">
                  <i class="fa fa-cubes"></i>
                </div>
                <a href="{{ route('stock.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{ $data['supplier'] }}</h3>
  
                  <p>Total Supplier</p>
                </div>
                <div class="icon">
                  <i class="fa fa-truck"></i>
                </div>
                <a href="{{ route('stock.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>

  
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            
  
              <!-- /.card -->
                <div class="col-md-4">
                  <!-- DIRECT CHAT -->
                  <!-- PRODUCT LIST -->
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Debit Terakhir</h3>
      
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($sale as $item)
                        <li class="item">
                          <div class="product-info mx-1">
                            <a href="javascript:void(0)" class="product-title">{{ $item->user->name }}
                              <span class="badge badge-success float-right">Rp {{ format_uang($item->bill) }}</span></a>
                            <span class="product-description">
                              {{ $item->created_at }}
                            </span>
                          </div>
                        </li>
                        @endforeach
                        <!-- /.item -->
                      </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                      <a href="{{ route('penjualan.index') }}" class="uppercase">View All Sales</a>
                    </div>
                    <!-- /.card-footer -->
                  </div>
              <!-- /.card -->
                </div>
                <!-- /.col -->
  
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Transaksi Bulan ini</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body p-0 px-2">
                                    <!-- Info Boxes Style 2 -->
                  <div class="info-box mb-1 bg-warning">
                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>
      
                    <div class="info-box-content">
                      <span class="info-box-text">Total @lang('app.transaction.purchase')</span>
                      <span class="info-box-number">Rp {{ format_uang($data['purchase']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                  <div class="info-box mb-1 bg-success">
                    <span class="info-box-icon"><i class="far fa-heart"></i></span>
      
                    <div class="info-box-content">
                      <span class="info-box-text">Total @lang('app.transaction.sales')</span>
                      <span class="info-box-number">Rp {{ format_uang($data['sale']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                  <div class="info-box mb-1 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>
      
                    <div class="info-box-content">
                      <span class="info-box-text">Total @lang('app.transaction.expense')</span>
                      <span class="info-box-number">Rp {{ format_uang($data['expense']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                  <div class="info-box mb-1 bg-info">
                    <span class="info-box-icon"><i class="far fa-comment"></i></span>
      
                    <div class="info-box-content">
                      <span class="info-box-text">@lang('app.income')</span>
                      <span class="info-box-number">Rp {{ format_uang($data['sale'] - $data['purchase'] - $data['expense']) }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                    </div>
                  </div>
                </div>
                <!-- /.col -->

                <div class="col-md-4">
                  <!-- DIRECT CHAT -->
                  <!-- PRODUCT LIST -->
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Kredit Terakhir</h3>
      
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($transactions as $item)
                        <li class="item">
                          <div class="product-info mx-1">
                            <a href="javascript:void(0)" class="product-title">{{ $item->description ?? $item->supplier_name }}
                              <span class="badge {{ $item->description ? 'badge-danger':'badge-warning'}} float-right">Rp {{format_uang($item->payment) }}</span></a>
                            <span class="product-description">
                              {{ $item->transaction_date }}
                            </span>
                          </div>
                        </li>
                        @endforeach
                        <!-- /.item -->
                      </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <a href="{{ route('purchase.index') }}" class="uppercase">View All Purchase</a>
                      <a href="{{ route('expense.index') }}" class="uppercase float-right">View All Expenses</a>
                    </div>
                    <!-- /.card-footer -->
                  </div>
              <!-- /.card -->
                </div>
                <!-- /.col -->
              <!-- /.row -->
            
            <!-- /.col -->
          </div>
          <!-- /.row -->
          {{-- chart --}}
          <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chart">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="salesChart" style="height: 180px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.js') }}"></script>
<script>
$(function() {
    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    
    var salesChartData = {
        labels: {{ json_encode($data_tanggal) }},
        datasets: [
          {
                label: 'Pembelian',
                backgroundColor: 'rgba(255, 193, 7, 0.9)',
                borderColor: 'rgba(255, 193, 7, 0.8)',
                borderWidth: 1,
                data: {{ json_encode($data_pembelian) }}
            },
            {
                label: 'Penjualan',
                backgroundColor: 'rgba(40, 167, 69, 0.9)',
                borderColor: 'rgba(40, 167, 69, 0.8)',
                borderWidth: 1,
                data: {{ json_encode($data_penjualan) }}
            },
            {
                label: 'Pengeluaran',
                backgroundColor: 'rgba(220, 53, 69, 0.9)',
                borderColor: 'rgba(220, 53, 69, 0.8)',
                borderWidth: 1,
                data: {{ json_encode($data_pengeluaran) }}
            },
            {
                label: 'Pendapatan',
                backgroundColor: 'rgba(23, 162, 184, 0.9)',
                borderColor: 'rgba(23, 162, 184, 0.8)',
                borderWidth: 1,
                data: {{ json_encode($data_pendapatan) }}
            }
        ]
    };

    var salesChartOptions = {
        scales: {
            x: [{
                stacked: true
            }],
            y: [{
                stacked: true
            }]
        },
        responsive : true
    };

    var salesChart = new Chart(salesChartCanvas, {
        type: 'bar', // Gunakan 'bar' untuk tipe grafik batang
        data: salesChartData,
        options: salesChartOptions
    });
});

</script>
@endpush