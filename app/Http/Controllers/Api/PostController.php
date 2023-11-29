<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // collect latest data
        $bookings = Booking::latest()->paginate(5);

        // return
        return new PostResource(true, 'List Data Bookings', $bookings);
    }

    public function store(Request $request)
    {
    // rule validator
    $validator = Validator::make($request->all(), [
        'atas_nama'         => 'required',
        'nomor_lapangan'    => 'required',
        'tgl_booking'       => 'required',
        'waktu_booking'     => 'required',
    ]);

    // validation
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // create post
    $booking = Booking::create([
        'atas_nama'         => $request->atas_nama,
        'nomor_lapangan'    => $request->nomor_lapangan,
        'tgl_booking'       => $request->tgl_booking,
        'waktu_booking'     => $request->waktu_booking,
    ]);

    // collect latest data
    $bookings = Booking::latest()->paginate(5);

    // return
    return new PostResource(true, 'List Data Bookings', $bookings);
    }

    public function show($id)
    {
        //find post by ID
        $bookings = Booking::find($id);

        //return 
        return new PostResource(true, 'Detail Data Post!', $bookings);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'atas_nama'         => 'required',
            'nomor_lapangan'    => 'required',
            'tgl_booking'       => 'required',
            'waktu_booking'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $bookings = Booking::find($id);



            //update post 
            $bookings->update([
                'atas_nama'         => $request->atas_nama,
                'nomor_lapangan'    => $request->nomor_lapangan,
                'tgl_booking'       => $request->tgl_booking,
                'waktu_booking'     => $request->waktu_booking,
            ]);
        

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $bookings);
    }

    public function destroy($id)
    {
        //find post by ID
        $bookings = Booking::find($id);

        //delete post
        $bookings->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
