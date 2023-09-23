<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        if (auth()->user()->level == 1) {
            $data = [
                "category" => Category::count(),
                "product" => Product::count(),
                "supplier" => Supplier::count(),
                "stock" => Stock::sum('qty'),
                "purchase" => Purchase::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('payment'),
                "sale" => Sale::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->sum('bill'),
                "expense" => Expense::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('nominal'),
            ];
            $sale = Sale::where('bill', '>', 0)->latest()->take(4)->get();
            $transactions = DB::table('purchases')
                    ->select('id', 'supplier_id', 'payment', 'created_at as transaction_date', DB::raw('null as description'))
                    ->union(DB::table('expenses')->select('id', DB::raw('null as supplier_id'), 'nominal as payment', 'created_at as transaction_date', 'desc as description'))
                    ->orderBy('transaction_date', 'desc')
                    ->where('payment', '>', 0)
                    ->take(4)
                    ->get();
                    
            foreach ($transactions as $transaction) {
                if ($transaction->supplier_id) {
                    $supplier = Supplier::find($transaction->supplier_id);
                    $transaction->supplier_name = $supplier->name;
                }
            }

            $tanggal_awal = date('Y-m-01');
            $tanggal_akhir = date('Y-m-d');

            $data_tanggal = array();
            $data_pendapatan = array();
            $data_penjualan = array();
            $data_pembelian = array();
            $data_pengeluaran = array();

            while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
                $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

                $total_penjualan = Sale::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bill');
                $total_pembelian = Purchase::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('payment');
                $total_pengeluaran = Expense::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

                $data_penjualan[] += $total_penjualan; 
                $data_pembelian[] += $total_pembelian; 
                $data_pengeluaran[] += $total_pengeluaran; 

                $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
                $data_pendapatan[] += $pendapatan;

                $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
            }

            $tanggal_awal = date('Y-m-01');

            return view('dashboard.admin', compact('data', 'sale', 'transactions', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan', 'data_penjualan', 'data_pembelian', 'data_pengeluaran'));
        } else {
            return view('dashboard.cashier');
        }

    }
}
