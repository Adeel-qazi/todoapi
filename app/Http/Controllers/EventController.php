<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(['status' => true, 'message' => 'Events retrieved successfully', 'data' => $events],200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $clients = User::where('role','client')->get();
       return response()->json(['status' => true, 'message' => 'Successfuly fetching all clients','data'=>$clients],200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $validatedData = $request->validated();
        $client = '';

        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                $client = User::find($validatedData['client_id']);
            } elseif (auth()->user()->role === 'client') {
                $client = auth()->user()->id; 
            }
        }
        $event = $client->events()->create($validatedData);
        return response()->json(['status' => true, 'message' => 'Event created successfully','data'=>$event],200);
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        
    }

    public function show(Event $event)
    {
        try {
            return response()->json(['success' => true, 'message' => 'Successfully fetched the data', 'data' => $event], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch the data', 'error' => $th->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateEventRequest $request, Event $event)
    // {
    //     $validatedData = $request->validated();

    //     try {
    //     $client = '';
    //         if (auth()->check()) {
    //             if (auth()->user()->role === 'admin') {
    //                 $event = $validatedData['client_id'];
    //             } elseif (auth()->user()->role === 'client') {
    //                 $client = auth()->user()->id; 
    //             }
    //         }
    //         $event->update($validatedData);
    //         return response()->json(['success'=>true,'message'=>'Successfully update the event','data'=>$validatedData],200);
            
            
    //     } catch (\Throwable $th) {
    //         return response()->json(['success'=>false,'message'=>'Failed to update the data','error'=>$th->getMessage()], 500);

    //     }
        

      
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        try {
            $validatedData = $request->validated();
    
            if (auth()->check()) {
                if (auth()->user()->role === 'admin') {
                    $event->client_id = $validatedData['client_id'] ?? $event->client_id;
                } elseif (auth()->user()->role === 'client') {
                    $event->client_field = auth()->user()->id;
                }
            }
            $event->update($validatedData);
            return response()->json(['success' => true, 'message' => 'Successfully updated the event', 'data' => $event], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Failed to update the data', 'error' => $th->getMessage()], 500);
        }
    }
    

    public function destroy(Event $event)
    {
        try {
            $deletedEvent = $event->toArray();
            $event->delete();
            return response()->json(['success'=>true,'message'=>'Successfully deleted the event','data'=>$deletedEvent],200);
        } catch (\Throwable $th) {
            return response()->json(['success'=>false,'message'=>'Failed to delete the data','error'=>$th->getMessage()], 500);
        }
    }
}
