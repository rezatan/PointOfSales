<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseDetails;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Purchase;
use App\Models\Supplier;

class PurchaseDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_pembelian = session('purchase_id');
        $product = Product::orderBy('name', 'asc')->get();
        $supplier = Supplier::find(session('supplier_id'));
        $diskon = Purchase::find($id_pembelian)->disc ?? 0;

        if (! $supplier) {
            abort(404);
        }

        return view('dashboard.purchase_details.index', compact('id_pembelian', 'product', 'supplier', 'diskon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
            $produk = Product::where('code', $request->kode_produk)->first();
            if (! $produk) {
                return response()->json('Data gagal disimpan', 400);
            }

            $dstock = new Stock();
            $dstock->product_id = $produk->id;
            $dstock->supplier_id = $request->id_supplier;
            $dstock->qty = 1;
            $dstock->save();
            $detail = new PurchaseDetails();
            $detail->purchase_id = $request->id_pembelian;
            $detail->stock_id = $dstock->id;
            $detail->qty = 1;
            $detail->subtotal = 0;
            $detail->save();

            return response()->json('Data berhasil disimpan', 200);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $detail = PurchaseDetails::find($id);
        if ($request->jumlah){
            $detail->qty = $request->jumlah;
        }
        if ($request->harga_beli) {
            $detail->buy_price = $request->harga_beli;
        }
        $detail->subtotal =  $detail->buy_price * $detail->qty;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detail = PurchaseDetails::find($id);
        $dstock = Stock::find($detail->stock_id);
        $dstock->delete();
        $detail->delete();
        return response(null, 204);
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data);
    }

    public function data($id)
    {
        $detail = PurchaseDetails::where('purchase_id', $id)->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">'. $item->stock->product['code'] .'</span';
            $row['nama_produk'] = $item->stock->product['name'];
            $row['harga_beli']  = '<input type="number" class="form-control input-sm buy_price" data-id="'. $item->id .'" value="'. $item->buy_price .'">';
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id .'" value="'. $item->qty .'">';
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('purchase_detail.destroy', $item->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->buy_price * $item->qty;
            $total_item += $item->qty;
        }
        $data[] = [
            'kode_produk' => 
                '<div class="total">'. $total .'</div>
                <div class="total_item">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah', 'harga_beli'])
            ->make(true);
    }
}
