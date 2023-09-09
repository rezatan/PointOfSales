<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        if ($request->ajax()){
            return $this->data();
        }
        return view ('dashboard.user.index');
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
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = 2;
        $user->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password') && $request->password != "") 
            $user->password = bcrypt($request->password);
        $user->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response(null, 204);
    }

    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('users.update', $user->id) .'`)" class="btn btn-xs btn-info "><i class="far fa-edit"></i> Edit</button>
                    <button type="button" onclick="deleteData(`'. route('users.destroy', $user->id) .'`)" class="btn btn-xs btn-danger"><i class="fa fa-trash" ></i> Delete</button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function profile()
    {
        $profile = auth()->user();
        return view('dashboard.user.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $user->name = $request->name;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('photo')) {
            if ($user->photo != 'adminlte/dist/img/avatar5.png'){
                Storage::delete($user->photo);
            }
            $file = $request->file('photo');
            $nama = $user->username .'-'. date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->photo = "/img/$nama";
        }

        $user->update();

        return response()->json($user, 200);
    }
}
