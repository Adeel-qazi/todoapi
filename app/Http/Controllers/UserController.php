<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginAdminRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if (Auth::attempt(["email" => $validatedData["email"], "password" => $validatedData["password"]])) {
                
                $token = auth()->user()->createToken('user')->accessToken;
                $user = auth()->user();
                return response()->json(['status' => true, 'access_token' => $token, 'user' => $user]);
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid email/password']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function dashboard()
    {
        dd('dashboard');        
    }


    public function show($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return response()->json(['success' => true, 'message' => 'User found', 'user' => $user],200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }


    public function update(UpdateAdminRequest $request, $userId)
    {
        $validatedData = $request->validated();
        try {
            $user = User::findOrFail($userId);

            $user->update($validatedData);
    
            return response()->json(['success' => true, 'message' => 'Successfully updated the admin', 'user' => $user],200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

    }


}
