<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use PDF;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = Product::all()->pluck('name', 'id');
        $supplier = Supplier::all()->pluck('name', 'id');
        if ($request->ajax()){
            return $this->data();
        }
        return view('dashboard.stock.index', compact('product', 'supplier'));
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
        Stock::create($request->all());
        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stock = Stock::find($id);

        return response()->json($stock);
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
        $stock = Stock::find($id);
        $stock->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stock = Stock::find($id);
        $stock->delete();
        return response(null, 204);
    }
    public function data()
    {
        $stock = Stock::latest()->get();
        return datatables()
            ->of($stock)
            ->addIndexColumn()
            ->addColumn('select_all', function ($stock) {
                return '
                    <input type="checkbox" name="stock_id[]" value="'. $stock->id .'">
                ';
            })
            ->addColumn('buy_price', function ($stock) {
                return format_uang($stock->buy_price);
            })
            ->addColumn('sell_price', function ($stock) {
                return format_uang($stock->sell_price);
            })
            ->addColumn('action', function ($stock) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('stock.update', $stock->id) .'`)" class="btn btn-sm btn-info"><i class="far fa-edit"></i></button>
                    <button type="button" onclick="deleteData(`'. route('stock.destroy', $stock->id) .'`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action', 'select_all'])
            ->make(true);
    }
    public function deleteSelected(Request $request)
    {
        foreach ($request->stock_id as $id) {
            $stock = Stock::find($id);
            $stock->delete();
        }

        return response(null, 204);
    }

}
