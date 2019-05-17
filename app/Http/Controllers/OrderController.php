<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Pitstop;
use App\OrderDetail;
use App\Order;
use App\Fasilitas;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::all();
        $data= [];
        foreach($order as $orders) {
            $tmp = [
                'id' => $orders->id,
                'kode_order' => $orders->kode_order,
                'user_id' => $orders->user_id,
                'pitstop_id' => $orders->pitstop_id,
                'tanggal' => $orders->tanggal,
                'waktu' => $orders->waktu_boking,
                'harga' => $orders->harga,
                'created_at' => $orders->created_at,
                'updated_at' => $orders->updated_at,
                'order_detail' => $orders->orderdetails,        
            ];
            array_push($data, $tmp);
        }
        return response()->json([
            'status' => 'Mendapat Data',
            'code' => 200,
            'data' => $data,
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
        $validator = Validator::make($request->all(), [
            'kode_order' => 'required|min:5',
            'user_id' => 'required',
            'pitstop_id' => 'required',
            'tanggal' => 'required',
            'waktu_boking' => 'required',
        ]);

        if($validator->fails()) {
            
            return response()->json([
                'message' => 'Check, Field Anda Yang Kosong'
            ]);

        }else {          

            $order = new Order();
            $order->kode_order = 'PS' . $request->kode_order;
            $order->user_id = $request->user_id;
            $order->pitstop_id = $request->pitstop_id;
            $pitstop = Pitstop::find($request->pitstop_id);
            $order->tanggal = $request->tanggal;
            $order->waktu_boking = $request->waktu_boking;
            $order->harga = $pitstop->harga;
            $order->save();
            foreach($request->fasilitas_id as $fasilitas_id) {
                $orderdetail = new OrderDetail();
                $orderdetail->order_id = $order->id;
                $orderdetail->fasilitas_id = $fasilitas_id;
                $orderdetail->save();
            }
           
          
            // dd($request);
            
            // $order->orderdetails()->save($orderdetail);
             
            return response()->json([
                'status' => 'Menambahkan',
                'code' => 201,
                'data' => $order,
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
        $order = Order::find($id);
            $data = [array(
                'id' => $order->id,
                'kode_order' => $order->kode_order,
                'user_id' => $order->user_id,
                'pitstop_id' => $order->pitstop_id,
                'tanggal' => $order->tanggal,
                'waktu_boking' => $order->waktu_boking,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'order_detail' => $order->orderdetails,
            )];

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => $data,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->orderdetails()->delete();
        $order->delete();

        return response()->json([
            'status' => 'Sukses Hapus Data',
            'code' => 200,
            'data' => $order,
        ]);
    }
}