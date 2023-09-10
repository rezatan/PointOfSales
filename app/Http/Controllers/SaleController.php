<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shop;
use App\Models\Stock;
use App\Models\Cashier;
use Illuminate\Http\Request;
use PDF;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.sale.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penjualan = new Sale();
        $penjualan->member_id = null;
        $penjualan->total_qty = 0;
        $penjualan->total_price = 0;
        $penjualan->disc = 0;
        $penjualan->bill = 0;
        $penjualan->receipt = 0;
        $penjualan->user_id = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id]);
        return redirect()->route('cashier.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $penjualan = Sale::findOrFail($request->id_penjualan);
        $penjualan->member_id = $request->id_member;
        $penjualan->total_qty = $request->total_item;
        $penjualan->total_price = $request->total;
        $penjualan->disc = $request->diskon;
        $penjualan->bill = $request->bayar;
        $penjualan->receipt = $request->diterima;
        $penjualan->update();

        $detail = Cashier::where('sale_id', $penjualan->id)->get();
        foreach ($detail as $item) {
            $item->disc = $request->diskon;
            $item->update();

            $produk = Stock::find($item->stock_id);
            $produk->qty -= $item->qty;
            $produk->update();
        }

        return redirect()->route('transaksi.selesai');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detail = Cashier::with('stock')->where('sale_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->stock->product->code .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->stock->produk->name;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. '. format_uang($detail->sell_price);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->qty);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penjualan = Sale::find($id);
        $detail    = Cashier::where('sale_id', $penjualan->id)->get();
        foreach ($detail as $item) {
            $produk = Stock::find($item->stock_id);
            if ($produk) {
                $produk->qty += $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function selesai()
    {
        $setting = Shop::first();

        return view('dashboard.sale.done', compact('setting'));
    }

    public function notaKecil()
    {
        $setting = Shop::first();
        $penjualan = Sale::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = Cashier::with('stock')
            ->where('sale_id', session('id_penjualan'))
            ->get();
        
        return view('dashboard.sale.small_receipt', compact('setting', 'penjualan', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Shop::first();
        $penjualan = Sale::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = Cashier::with('stock')
            ->where('sale_id', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('dashboard.sale.big_receipt', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaksi-'. date('Y-m-d-his') .'.pdf');
    }

    public function data()
    {
        $penjualan = Sale::with('member')->orderBy('id', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item', function ($penjualan) {
                return format_uang($penjualan->total_qty);
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp. '. format_uang($penjualan->total_price);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp. '. format_uang($penjualan->bill);
            })
            ->addColumn('tanggal', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('kode_member', function ($penjualan) {
                $member = $penjualan->member->code ?? '';
                return '<span class="label label-success">'. $member .'</spa>';
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->disc . '%';
            })
            ->editColumn('kasir', function ($penjualan) {
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('sale.show', $penjualan->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('sale.destroy', $penjualan->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_member'])
            ->make(true);
    }
}
