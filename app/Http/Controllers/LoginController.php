<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Profile;
use Validator;
use \Auth;

class LoginController extends Controller
{

    public function check(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'message' => 'Check, Field Ada Yang Kosong'
            ]);
            
        }else{

            $email = $request->email;
            $password = $request->password;
            $data = User::where('email', $email)->first();
    
            if($data)
            {
                if(Hash::check($password, $data->password))
                {
                    // dd($data);
                    return response()->json([
                        'status' => 'OK',
                        'code' => 200,
                        'message' => "Berhasil Login",
                    ]);
                }else
                {
                    return response()->json([
                        'status' => 'Password Salah',
                        'message' => 'Periksa Kembali Password Anda'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'Gagal Login',
                    'message' => 'Masukan email dan password dengan benar'
                ]);
            }
        }
    }
}
