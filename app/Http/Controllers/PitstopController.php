<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Pitstop;
use App\Fasilitas;
use Validator;
use \Auth;

class PitstopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pitstop = Pitstop::all();
        $data = [];
        foreach ($pitstop as $pitstops) {
            $tmp = [
                'id' => $pitstops->id,
                'user_id' => $pitstops->user_id,
                'nama' => $pitstops->nama,
                'deskripsi' => $pitstops->deskripsi,
                'latitude' => $pitstops->latitude,
                'longitude' => $pitstops->longitude,
                'slot' => $pitstops->slot,
                'harga' => $pitstops->harga,
                'created_at' => $pitstops->created_at,
                'updated_at' => $pitstops->updated_at,
            ];
            array_push($data, $tmp);
        }
        return response()->json([  
            'success' => 'OK',
            'code' => 200,
            'data' => ['Pitstop' => $data],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'slot' => 'required',
            'harga' => 'required',
        ]);

        if($validator->fails()) {
            
            return response()->json([
                'message' => 'Check, Field Anda Yang Kosong'
            ]);

        }else {          

            $pitstop = new Pitstop();
            $pitstop->user_id = $request->user_id;
            $pitstop->nama = $request->nama;
            $pitstop->deskripsi = $request->deskripsi;
            $pitstop->latitude = $request->latitude;
            $pitstop->longitude = $request->longitude;
            $pitstop->slot = $request->slot;
            $pitstop->harga = $request->harga;
            
            if($pitstop->save()) {
                $pitstop->pitstop_fasilitas()->sync([]);
                foreach($request->pitstop_fasilitas as $fasilitas_id) {
                    $pitstop->pitstop_fasilitas()->attach($fasilitas_id);
                }
                // $pitstop->pitstop_fasilitas()->sync($request->pitstop_fasilitas, false);
            }
             
            return response()->json([
                'status' => 'Menambahkan',
                'code' => 201,
                'message' => ['Pitstop' => $pitstop],
            ]);
        }
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
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'no_handphone' => $user->no_handphone,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'profile' => $user->profiles,
            'pitstop' => $user->pitstops
        )];

        return response()->json([
            'status' => 'Menampilkan',
            'code' => 200,
            'data' => ['user' => $data]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $pitstop = Pitstop::find($id);
        $pitstop->user_id = $request->user_id;
        $pitstop->nama = $request->nama;
        $pitstop->deskripsi = $request->deskripsi;
        $pitstop->latitude = $request->latitude;
        $pitstop->longitude = $request->longitude;
        $pitstop->slot = $request->slot;
        $pitstop->harga = $request->harga;
        $pitstop->save();

        return response()->json([
            'status' => 'updated',
            'code' => 200,
            'data' => $pitstop
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
        
        $pitstop = Pitstop::find($id);
        $pitstop->delete();
        // dd($pitstop);

        return response()->json([
            'status' => 'deleted',
            'code' => 204,
            'data' => $pitstop,
        ]);
    }

    public function getRoute($latitude, $longitude)
    {
        /**Mencari Target Latitude */
        $tryAgain = 0;
        $radiusDistance = 1000;
        while($tryAgain < 3) {
            $earthRadius = 6371.137;
            $pi = pi();
            $meterDegree = (1/((2 * $pi / 360) * $earthRadius)) / 1000;
            /**Mencari Target Latitude */
            $targetLatitude = $latitude + ($radiusDistance * $meterDegree);
            /**Mencari Target Longitude */
            $targetLongitude = $longitude + ($radiusDistance * $meterDegree) / cos($latitude*($pi/180));

            /**Mencari Pitstop Terdekat */
            $pitstop = Pitstop::whereBetween('latitude', ($latitude < 0) 
            ? [$latitude, $targetLatitude] : [$targetLatitude, $latitude])
            ->whereBetween('longitude', ($longitude > 0)
            ? [$longitude, $targetLongitude] : [$targetLongitude, $longitude])
            ->get();

            if(count($pitstop) > 0){
                return response()->json([
                    'status' => 'OK',
                    'code' => 200,
                    'radius' => $radiusDistance / 1000 . ' kilometer',
                    'pitstop' => $pitstop
                ]);
            }else {
                if($tryAgain < 3) {
                    $tryAgain++;

                    $radiusDistance += 1000;

                }else {
                    break;
                }
            }
        }
        return response()->json([
            'status' => 'ERROR',
            'code' => 404,
            'message' => 'Nothing pitstop center found nearby'
        ]);
    }
}
