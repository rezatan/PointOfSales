<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            return $this->data();
        }
        return view('dashboard.category.index');
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
        $category = new Category();
        $category->name = $request->nama_kategori;
        $category->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $category->name = $request->nama_kategori;
        $category->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        return response(null, 204);
    }

    public function data()
    {
        $category = Category::latest()->get();
        return Datatables::of($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($category) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('category.update', $category->id) .'`)" class="btn btn-sm btn-info "><i class="far fa-edit"></i> Edit</button>
                    <button onclick="deleteData(`'. route('category.destroy', $category->id) .'`)" class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i> Delete</button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
