<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->paginate(10);
        return response()->json($bookings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $booking = $request->validated();
        $booking['user_id'] = auth()->id();
        Booking::create($booking);

        return response()->json(['message' => 'Booking created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        return response()->json($booking, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return response()->json(['message' => 'Booking updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        $booking->delete();
        return response()->json(['message' => 'Booking deleted'], 200);
    }
}
