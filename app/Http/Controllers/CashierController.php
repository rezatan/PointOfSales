<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shop;
use App\Models\Stock;
use App\Models\Member;
use App\Models\Cashier;

use App\Models\Product;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stock = Stock::orderBy('created_at', 'desc')->get();
        $member = Member::orderBy('name')->get();
        $diskon = Shop::first()->disc ?? 0;

        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            $penjualan = Sale::find($id_penjualan);
            $memberSelected = $penjualan->member ?? new Member();

            return view('dashboard.cashier.index', compact('stock', 'member', 'diskon', 'id_penjualan', 'penjualan', 'memberSelected'));
        } else {
                return redirect()->route('transaksi.baru');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->id_produk != '' ) {
            $stock = Stock::where('id', $request->id_produk)->first();
        }
        else{
            $product = Product::where('code', $request->kode_produk)->first();
            if ($product) {
                $stock = $product->stocks()->where('qty', '>', 0)->orderBy('created_at', 'desc')->first();
            }
        }
        if (! $stock) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new Cashier();
        $detail->sale_id = $request->id_penjualan;
        $detail->stock_id = $stock->id;
        $detail->sell_price = $stock->sell_price;
        $detail->qty = 1;
        $detail->disc = $stock->disc;
        $detail->subtotal = $stock->sell_price - ($stock->disc / 100 * $stock->sell_price);;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashier $cashier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cashier $cashier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detail = Cashier::find($id);
        $detail->qty = $request->jumlah;
        $detail->subtotal = $detail->sell_price * $request->jumlah - (($detail->disc * $request->jumlah) / 100 * $detail->sell_price);;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = Cashier::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0)
    {
        $bayar   = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data    = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];

        return response()->json($data);
    }

    public function data($id)
    {
        $detail = Cashier::where('sale_id', $id)->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">'. $item->stock->product['code'] .'</span';
            $row['nama_produk'] = $item->stock->product['name'];
            $row['harga_jual']  = 'Rp. '. format_uang($item->sell_price);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id .'" value="'. $item->qty .'">';
            $row['diskon']      = $item->disc . '%';
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('cashier.destroy', $item->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->sell_price * $item->qty - (($item->disc * $item->qty) / 100 * $item->sell_price);;
            $total_item += $item->qty;
        }
        $data[] = [
            'kode_produk' => '
                <div class="total">'. $total .'</div>
                <div class="total_item">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'jumlah'      => '',
            'diskon'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

}
