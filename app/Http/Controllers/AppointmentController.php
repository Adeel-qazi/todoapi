<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlotRequest;
use App\Models\Appointment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
 

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $bookedSlots = Event::with('client')->with('appointments')
            ->whereHas('appointments', function ($q) use ($request) {
                $q->where('date', '=', $request->input('date'));
            })
            // ->where('client_id', 3)
            ->get();

        $bookedSlotIds = $bookedSlots->pluck('id');

        $availableSlots = Event::with('client')->with('appointments')
            // ->where('client_id', 3)
            ->whereNotIn('id', $bookedSlotIds)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Slots information retrieved successfully.',
            // 'booked_slots' => $bookedSlots,
            'available_slots' => $availableSlots,
        ]);
    }


    public function bookedSlot(StoreSlotRequest $request, $slotId)
    {
        try {
            $event = Event::findOrFail($slotId);
    
            $validatedData = $request->validated();
    
            if (auth()->check()) {
                $team = auth()->user();
                $validatedData['event_id'] = $event->id;
                $team->appointments()->create($validatedData);
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment created successfully.',
                    'url'     => $event['zoom_link'],
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found.',
            ], 404);
        } 
    }
    
}
