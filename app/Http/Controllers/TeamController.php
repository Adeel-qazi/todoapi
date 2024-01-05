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
        try {
            $users = User::where('role','=','team')->get();
                return response()->json(['success' => true, 'message' => 'Successfully All the Teams', 'user' => $users],200);
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
            $user = User::create($validatedData);
            $password = $validatedData['password'];
            Mail::to($user->email)->send(new SendCredentialUser($user,$password));
            return response()->json(['success' => true, 'message' => 'Team created successfully', 'Team' => $user], 200);
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
            if($user->role == 'team'){
                $user = User::find($user->id);
                return response()->json(['success' => true, 'message' => 'Team found', 'Team' => $user],200);
            }else{
            return response()->json(['success' => false, 'message' => 'Team not found'], 404);
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
        $team = User::findOrFail($id);

        try {
            if($team->role == 'team'){
                $team->update($validatedData);
                return response()->json(['success' => true, 'message' => 'Team updated successfully', 'Team' => $team], 200);
            }else{
                return response()->json(['success' => false, 'message' => 'Team not found'], 500);

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
        $team = User::findOrFail($id);

        try {
            if($team->role == 'team'){
                $team->delete();
                return response()->json(['success' => true, 'message' => 'Team deleted successfully'], 200);
            }else{
                return response()->json(['success' => false, 'message' => 'Team not found'], 500);

            }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
