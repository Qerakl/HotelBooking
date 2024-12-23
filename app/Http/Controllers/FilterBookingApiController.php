<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class FilterBookingApiController extends Controller
{
    public function filter(Request $request){
        $booking = Booking::where('status', $request->input('status'))->paginate(10);
        return response()->json($booking);
    }
}
