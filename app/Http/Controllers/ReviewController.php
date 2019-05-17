<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Pitstop;
use App\Review;
use Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $review = Review::all();
        $data = [];
        foreach($review as $reviews) {
            $tmp = [
                'id' => $reviews->id,
                'pitstop_id' => $reviews->pitstop_id,
                'user_id' => $reviews->user_id,
                'message' => $reviews->message,
                'rate' => $reviews->rate,
                'created_at' => $reviews->created_at,
                'updated_at' => $reviews->updated_at,
            ];
            array_push($data, $tmp);
        }
        
        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => ['Review' => $data],
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
            'pitstop_id' => 'required',
            'user_id' => 'required',
            'message' => 'required',
            'rate' => 'required',
        ]);

        if($validator->fails()) {
            
            return response()->json([
                'message' => 'Check, Field Anda Yang Kosong'
            ]);

        }else {
            $review = new Review();
            $review->pitstop_id = $request->pitstop_id;
            $review->user_id = $request->user_id;
            $review->message = $request->message;
            $review->rate = $request->rate;
           
            $review->save();
    
            return response()->json([
                'status' => 'Menambahkan',
                'code' => 200,
                'Review' => $review,
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
        $pitstop = Pitstop::find($id);
        $data = [ array (
            'id' => $pitstop->id,
            'user_id' => $pitstop->user_id,
            'nama' => $pitstop->nama,
            'deskripsi' => $pitstop->deskripsi,
            'latitude' => $pitstop->latitude,
            'longitude' => $pitstop->longitude,
            'slot' => $pitstop->slot,
            'harga' => $pitstop->harga,
            'created_at' => $pitstop->created_at,
            'updated_at' => $pitstop->updated_at,
            'review' => $pitstop->reviews,
        )];

        return response()->json([
            'status' => 'OK',
            'code' => 200,
            'data' => [ 'Pitstop' => $data ],
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
        $validator = Validator::make($request->all(), [
            'pitstop_id' => 'required',
            'user_id' => 'required',
            'message' => 'required',
            'rate' => 'required',
        ]);

        if($validator->fails()) {
            
            return response()->json([
                'message' => 'Check, Field Anda Yang Kosong'
            ]);

        }else {
            $review = Review::find($id);
            $review->pitstop_id = $request->pitstop_id;
            $review->user_id = $request->user_id;
            $review->message = $request->message;
            $review->rate = $request->rate;
           
            $review->save();
    
            return response()->json([
                'status' => 'Updated',
                'code' => 200,
                'data' => ['Review' => $review],
            ]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        $review->delete();

        return response()->json([
            'status' => 'Deleted',
            'code' => 200,
            'data' => ['Review' => $review],
        ]);
    }
}
