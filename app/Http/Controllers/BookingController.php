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
        $this->authorize('viewAny', Booking::class);
        $bookings = Booking::where('user_id', auth()->id())->paginate(10);
        return response()->json($bookings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $this->authorize('create', Booking::class);

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
        $this->authorize('view', $booking);
        return response()->json($booking, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $booking->update($request->validated());
        return response()->json(['message' => 'Booking updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        $booking->delete();
        return response()->json(['message' => 'Booking deleted'], 200);
    }
}
