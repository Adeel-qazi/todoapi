<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Http\Requests\RegisterClientRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Mail\RegisterClientEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function register(RegisterClientRequest $request)
    { 
        $validatedData = $request->validated();

        try {
            $user = User::create($validatedData);
            Mail::to($user->email)->send(new RegisterClientEmail($user));
            return response()->json(['success' => true, 'message' => 'User created successfully Please check you email', 'user' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }

    }


    public function login(LoginAdminRequest $request)
    {
        try {
            $validatedData = $request->validated();
        
            if (Auth::attempt(["email" => $validatedData["email"], "password" => $validatedData["password"]])) {
                $user = auth()->user();
        
                if ($user->email_verified == 1) {
                    $token = $user->createToken('user')->accessToken;
                    return response()->json(['status' => true, 'access_token' => $token, 'user' => $user]);
                } else {
                    return response()->json(['status' => false, 'message' => 'You are not authorized to access. Please verify your email.']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid email or password']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        
    }


    public function dashboard()
    {
        dd('dashboard');        
    }


    public function show($userId)
    {
        try {
            $loggedInUser = auth()->user();

            if ($loggedInUser->id == $userId) {
            $user = User::findOrFail($userId);
            return response()->json(['success' => true, 'message' => 'User found', 'user' => $user],200);
            }
            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }



    public function update(UpdateAdminRequest $request, $userId)
    {
        try {
            $loggedInUser = auth()->user();

            if ($loggedInUser->id == $userId) {
                $user = User::findOrFail($userId);
                $user->update($request->validated());

                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully',
                    'user' => $user,
                ], 200);
            }

            return response()->json(['success' => false, 'message' => 'Permission denied'], 403);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }




}
