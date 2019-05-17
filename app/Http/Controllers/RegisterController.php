<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Validator;


class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|',
            'password' => 'required|',
            'no_handphone' => 'required|size:12|',
            'alamat' => 'required',
            'tgl_lahir' => 'required|date',
            
        ]);
        // dd($request);
        if ($validator->fails()) {

            return response()->json([
               
                'message' => 'Check, Field Ada Yang Kosong',
                
            ]);

        }else{
            $user = new User();
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->password = bcrypt($request->password);
            $user->no_handphone = $request->no_handphone;
            $user->remember_token = str_random(10);
            $user->save();
            $profile = new Profile();
            $profile->alamat = $request->alamat;
            $profile->tgl_lahir = $request->tgl_lahir;
            $profile->path = '';
            
            // dd($request);
            $user->profiles()->save($profile);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'Successfully for register'
            ]);
        }
    }
}
