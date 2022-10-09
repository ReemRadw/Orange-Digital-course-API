<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authcontroller extends Controller
{
    public function register(Request $request) {
        $fields =$request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|string|unique:admins,email|string',
            'password' => 'required|string|confirmed',
            'phone' => 'required|string',
            'national_id'=>'required|string|unique:admins,national_id|string',
            
        ]);
        $admin =Admin::create([
            'fname' => $fields['fname'],
            'lname' => $fields['lname'],
            'password' => bcrypt($fields['password']),
            'phone' => $fields['phone'],
            'national_id' => $fields['national_id'],
            'email' => $fields['email'],
           

        ]);

        

        $token = $admin->createToken('myapptoken')->plainTextToken;
        $response =[
            'admin'=> $admin,
            'token' =>$token,


        ];
        return response($response,201);

    }
    public function login(Request $request) {
        $fields =$request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            
        ]);

        $admin =User::where('email',$fields['email'])->first();
        
        // return $admin;

        if (!$admin || !password_verify($fields['password'], $admin->password)) {
            return response([
                "message" => "Invalid Credentials"
            ], 401);
             
        }


        $token = $admin->createToken('myapptoken')->plainTextToken;
        $response =[
            'admin'=> $admin,
            'token' =>$token,
        ];
        return response($response,201);

    }
    public function logout(Admin $admin){
        $admin->tokens()->delete();
        return [
            'message'=>'logged out'
        ];
    }
}
