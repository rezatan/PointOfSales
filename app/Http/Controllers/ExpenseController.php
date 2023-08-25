<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Expense;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            return $this->data();
        }
        return view('dashboard.expense.index');
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
        $expense = Expense::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        return response()->json($expense);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::find($id)->update($request->all());
        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expense = Expense::find($id)->delete();

        return response(null, 204);
    }

    public function data()
    {
        $expense = Expense::orderBy('id', 'desc')->get();

        return datatables()
            ->of($expense)
            ->addIndexColumn()
            ->addColumn('created_at', function ($expense) {
                return tanggal_indonesia($expense->created_at, false);
            })
            ->addColumn('nominal', function ($expense) {
                return format_uang($expense->nominal);
            })
            ->addColumn('action', function ($expense) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('expense.update', $expense->id) .'`)" class="btn btn-sm btn-info "><i class="far fa-edit"></i> Edit</button>
                    <button type="button" onclick="deleteData(`'. route('expense.destroy', $expense->id) .'`)" class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i> Delete</button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
