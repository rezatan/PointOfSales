<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\PurchaseDetails;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Stock;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            return $this->data();
        }

        $supplier = Supplier::orderBy('name')->get();
        return view('dashboard.purchase.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $purchase = Purchase::create([
            'supplier_id' => $id,
            'total_qty' => 0,
            'total_price' => 0,
            'disc' => 0,
            'payment' => 0,
    ]);
   
        session(['purchase_id' => $purchase->id]);
        session(['supplier_id' => $purchase->supplier_id]);

        return redirect()->route('purchase_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $purchase = Purchase::findOrFail($request->id_pembelian);
        $purchase->total_qty = $request->total_item;
        $purchase->total_price = $request->total;
        $purchase->disc = $request->diskon;
        $purchase->payment = $request->bayar;
        $purchase->update();

        $detail = PurchaseDetails::where('purchase_id', $purchase->id)->get();
        foreach ($detail as $item) {
            $stock = Stock::find($item->stock_id);
            $stock->qty = $item->qty;
            $stock->buy_price = $item->buy_price;
            $stock->update();
        }
        return redirect()->route('purchase.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detail = PurchaseDetails::where('purchase_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="label label-success">'. $detail->stock->product->code .'</span>';
            })
            ->addColumn('name', function ($detail) {
                return $detail->stock->product->name;
            })
            ->addColumn('buy_price', function ($detail) {
                return 'Rp. '. format_uang($detail->buy_price);
            })
            ->addColumn('qty', function ($detail) {
                return format_uang($detail->qty);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang($detail->subtotal);
            })
            ->rawColumns(['code'])
            ->make(true);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $detail    = PurchaseDetails::where('purchase_id', $purchase->id)->get();
        foreach ($detail as $item) {
            $stock = Stock::find($item->stock_id);
            if ($stock) {
                $stock->delete();
            }
            $item->delete();
        }
        $purchase->delete();
        return response(null, 204);
    }

    public function data()
    {
        $purchase = Purchase::orderBy('id', 'desc')->get();

        return datatables()
            ->of($purchase)
            ->addIndexColumn()
            ->addColumn('total_qty', function ($purchase) {
                return format_uang($purchase->total_qty);
            })
            ->addColumn('total_price', function ($purchase) {
                return 'Rp. '. format_uang($purchase->total_price);
            })
            ->addColumn('payment', function ($purchase) {
                return 'Rp. '. format_uang($purchase->payment);
            })
            ->addColumn('date', function ($purchase) {
                return tanggal_indonesia($purchase->created_at, false);
            })
            ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier->name;
            })
            ->editColumn('disc', function ($purchase) {
                return $purchase->disc . '%';
            })
            ->addColumn('aksi', function ($purchase) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('purchase.show', $purchase->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('purchase.destroy', $purchase->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

}
