<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Mail\SendCredentialUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loggedIN = auth()->user();
        try {
            if($loggedIN->role == 'admin'){
                $users = User::where('role','=','team')->get();
                return response()->json(['success' => true, 'message' => 'Successfully All the Teams', 'user' => $users],200);
            }elseif ($loggedIN->role == 'client') {
                $users = User::where('role','=','team')->get();
                return response()->json(['success' => true, 'message' => 'Successfully All the Teams', 'user' => $users],200);
            }
           
                return response()->json(['success' => false, 'message' => 'No data'],200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
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
    public function store(StoreTeamRequest $request)
    {
        $validatedData = $request->validated();
           
        try {
            $loggedInUser = auth()->user();
            if($loggedInUser->role == 'admin'|| $loggedInUser->role == 'client'){
                $user = User::create($validatedData);
                $password = $validatedData['password'];
                Mail::to($user->email)->send(new SendCredentialUser($user,$password));
                $message = $loggedInUser->role == 'admin' ? 'Team stored successfully by Admin' : 'Team stored successfully by Client';
                return response()->json(['success' => true, 'message' => $message, 'Team' => $user], 200);

            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loggedIN = auth()->user();
        try {
            if($loggedIN->role == 'admin'){
            $user = User::findOrFail($id);
            if($user->role == 'team'){
                $user = User::find($user->id);
                return response()->json(['success' => true, 'message' => 'Team found', 'Team' => $user],200);
            }else{
            return response()->json(['success' => false, 'message' => 'Team not found'], 404);
            }
            }elseif($loggedIN->role == 'client'){
                $user = User::findOrFail($id);
                if($user->role == 'team'){
                    $user = User::find($user->id);
                    return response()->json(['success' => true, 'message' => 'Team found', 'Team' => $user],200);
                }else{
                return response()->json(['success' => false, 'message' => 'Team not found'], 404);
                }
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
    public function update(UpdateTeamRequest $request, string $id)
    {
        $validatedData = $request->validated();
        
        $loggedInUser = auth()->user();
    
        try {

            $team = User::where('role', 'team')->findOrFail($id);
    
            if ($loggedInUser->role == 'admin' || $loggedInUser->role == 'client') {
                if ($team->role == 'team') {
                    $team->update($validatedData);
                    $message = $loggedInUser->role == 'admin' ? 'Team updated successfully by Admin' : 'Team updated successfully by Client';
                    return response()->json(['success' => true, 'message' => $message, 'team' => $team], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Team not found'], 404);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = User::findOrFail($id);

        $loggedIN = auth()->user();
        try {
            if($loggedIN->role == 'admin'  || $loggedIN->role == 'client'){

                if($team->role == 'team'){
                    $team->delete();
                    $message = $loggedIN->role == 'admin' ? 'Team deleted successfully by admin': 'Team deleted successfully by Client';
                    return response()->json(['success' => true, 'message' => $message], 200);
                }else{
                    return response()->json(['success' => false, 'message' => 'Team not found'], 404);
                }

            }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    
}
