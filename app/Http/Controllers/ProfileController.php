<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $data = [];
        foreach($users as $user){
            $tmp = array(
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'no_handphone' => $user->no_handphone,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'profile' => $user->profiles
            );
            array_push($data, $tmp);
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Create Not Support
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Not Support Store
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $data = [ array (
            'id' => $user->id,
            'nama' => $user->nama,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'no_handphone' => $user->no_handphone,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'profile' => $user->profiles
        )];

        return response()->json($data);
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Not Edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        dd($request);
        $user = User::find($id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->email_verified_at = date("Y-m-d H:i:s");
        $user->password = bcrypt($request->password);
        $user->no_handphone = $request->no_handphone;
        $user->remember_token = str_random(10);
        $user->save();
        if($request->has('path')) {
            $filename = $request->file('path')->store('profile_images');
            $user->profiles->path = $filename;
        }
        $user->profiles->alamat = $request->alamat;
        $user->profiles->tgl_lahir = $request->tgl_lahir;
        $user->profiles->save();
        // $filename = $request->path->store('path');
        // $profile->path = $filename;
        // $user->profiles->update([
        //     'alamat' => $request->alamat,
        //     'tgl_lahir' => $request->tgl_lahir,
        //     'path' => $request->path,
        // ]);

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'message' => 'Berhasil Ubah Data'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $user = User::find($id);
        $user->profiles()->delete();
        $user->delete();

        return response()->json([
            'status' => 'OK',
            'code' => 204,
            'message' => 'Berhasil Hapus Data'
        ]);
    }
}
