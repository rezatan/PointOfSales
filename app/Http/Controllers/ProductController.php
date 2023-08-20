<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = Category::all()->pluck('name', 'id');
        if ($request->ajax()){
            return $this->data();
        }
        return view('dashboard.product.index', compact('category'));
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
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'sell_price' => 'required',
        ]);
        $product = Product::latest()->first() ?? new Product();
        $request['code'] = 'P'. tambah_nol_didepan((int)$product->id +1, 6);
        Product::create($request->all());
        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response(null, 204);
    }

    public function data()
    {
        $product = Product::orderBy('code', 'asc')->get();
        return datatables()
            ->of($product)
            ->addIndexColumn()
            ->addColumn('select_all', function ($product) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $product->id .'">
                ';
            })
            ->addColumn('code', function ($product) {
                return '<span class="label label-success">'. $product->code .'</span>';
            })
            ->addColumn('sell_price', function ($product) {
                return format_uang($product->sell_price);
            })
            ->addColumn('aksi', function ($product) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('product.update', $product->id) .'`)" class="btn btn-sm btn-info"><i class="far fa-edit"></i>Edit</button>
                    <button type="button" onclick="deleteData(`'. route('product.destroy', $product->id) .'`)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Delete</button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'code', 'select_all'])
            ->make(true);
    }
}
