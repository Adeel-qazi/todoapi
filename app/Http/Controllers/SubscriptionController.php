<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSubscribeRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminSubscribeRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $user = auth()->user();
            if($user->role == 'admin'){
                $validatedData['admin_id'] = $user->id;
                $subscription = Subscription::create($validatedData);
                return response()->json(['success' => true, 'message' => 'Package has been created', 'package' => $subscription], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
