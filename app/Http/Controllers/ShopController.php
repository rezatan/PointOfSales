<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            return $this->data();
        }
        return view('dashboard.shop.index');
    }

 /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'contact' => 'required',
            'logo_path' => 'image|file|max:1024',
            'member_card_path' => 'image|file|max:1024',
            'bill_type' => 'required',
        ]);

        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $nama = 'logo-'. $request->name . date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $request['logo_path'] = "/img/$nama";
        }

        if ($request->hasFile('member_card_path')) {
            $file = $request->file('member_card_path');
            $nama = 'member-' . $request->name . date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $request['member_card_path'] = "/img/$nama";
        }

        dd($request->all());
        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        return response()->json($shop);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $setting = Shop::find($id);
        $setting->name = $request->name;
        $setting->contact = $request->contact;
        $setting->address = $request->address;
        $setting->disc = $request->disc;
        $setting->bill_type = $request->bill_type;

        if ($request->hasFile('logo_path')) {
            if ($setting->logo_path !== '/img/logo.png'){
                Storage::delete($setting->logo_path);
            }
            $files = glob(public_path('/img/logo-' . $setting->name . '*'));
            foreach ($files as $file) {
                unlink($file);
            }

            $file = $request->file('logo_path');
            $nama = 'logo-'. $setting->name . date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $setting->logo_path = "/img/$nama";
        }

        if ($request->hasFile('member_card_path')) {
            if ($setting->member_card_path != '/img/member.png'){
                Storage::delete($setting->member_card_path);
            }
            $file = $request->file('member_card_path');
            $nama = 'member-' . $setting->name . date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $setting->member_card_path = "/img/$nama";
        }

        $setting->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function destroy($id)
    {
        $shop = Shop::find($id);
        if ($shop->member_card_path != '/img/member.png'){
            Storage::delete($shop->member_card_path);
        }
        $shop->delete();

        return response(null, 204);
    }


    public function data()
    {
        $shop = Shop::latest()->get();
        return Datatables::of($shop)
            ->addIndexColumn()
            ->addColumn('logo_path', function ($shop) {
                return '<img src="' . $shop->logo_path . '" width="100" />';
            })
            ->addColumn('member_card_path', function ($shop) {
                return '<img src="' . $shop->member_card_path . '" width="100" />';
            })
            ->addColumn('aksi', function ($shop) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('shop.update', $shop->id) .'`)" class="btn btn-sm btn-info "><i class="far fa-edit"></i> Edit</button>
                    <button onclick="deleteData(`'. route('shop.destroy', $shop->id) .'`)" class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i> Delete</button>
                </div>
                ';
            })
            ->rawColumns(['logo_path', 'member_card_path', 'aksi'])
            ->make(true);
    }

    public function detail()
    {
        return view('dashboard.shop.detail');
    }

}
