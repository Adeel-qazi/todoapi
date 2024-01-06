<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveClientRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Mail\SendCredentialUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::where('id','!=',1)->get();
                return response()->json(['success' => true, 'message' => 'Successfully All the Users', 'user' => $users],200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function approved($userId)
    {
        try {
            $loggedInUser = auth()->user();
    
            if ($loggedInUser->role == 'admin') {
                $user = User::where('id', $userId)->where('role', 'client')->first();
            } elseif ($loggedInUser->role == 'client') {
                $user = User::where('id', $userId)->where('role', 'team')->first();
            } else {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
    
            if ($user) {
                $user->update(['email_verified' => 1]);
                return response()->json(['success' => true, 'message' => 'User approved successfully.', 'user' => $user], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found.'], 404);
            }
    
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }
    
    


    public function disApproved($userId)
    {
        try {
            $loggedInUser = auth()->user();
    
            if ($loggedInUser->role == 'admin') {
                $user = User::where('id', $userId)->where('role', 'client')->first();
            } elseif ($loggedInUser->role == 'client') {
                $user = User::where('id', $userId)->where('role', 'team')->first();
            } else {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
    
            if ($user) {
                $user->update(['email_verified' => 0]);
                return response()->json(['success' => true, 'message' => 'User disapproved successfully.', 'user' => $user], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found.'], 404);
            }
    
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
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
    public function store(StoreClientRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $user = User::create($validatedData);
            $password = $validatedData['password'];
            Mail::to($user->email)->send(new SendCredentialUser($user,$password));
            return response()->json(['success' => true, 'message' => 'User created successfully', 'user' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if($user->role == 'client'){
                $user = User::find($user->id);
                return response()->json(['success' => true, 'message' => 'User found', 'user' => $user],200);
            }else{
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $client = User::findOrFail($id);

        try {
            if($client->role == 'client'){
                $client->update($validatedData);
                return response()->json(['success' => true, 'message' => 'Client updated successfully', 'client' => $client], 200);
            }else{
                return response()->json(['success' => false, 'message' => 'Client not found'], 500);

            }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = User::findOrFail($id);

        try {
            if($client->role == 'client'){
                $client->delete();
                return response()->json(['success' => true, 'message' => 'Client deleted successfully'], 200);
            }else{
                return response()->json(['success' => false, 'message' => 'Client not found'], 500);

            }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
