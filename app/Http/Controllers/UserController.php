<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandleRegisterValidation;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Log;

class UserController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('wordle')->plainTextToken;

            return response()->json(["retCode" => 200, "name" => auth()->user()->name, 'token' => $token]);
        }else{
            return response()->json(["retCode" => 404]);
        }
    }

    public function register(HandleRegisterValidation $request){
        $dataInput = $request->except(['surname', 'repeatPassword']);
        $dataInput['name'] = $request->name . ' ' . $request->surname;

        $user = User::create($dataInput);
        return response()->json(["retCode" => 200, "user" => $user]);
    }

    public function logout(User $user){
        $user->tokens()->delete();
        return response()->json(["retCode" => 200]);
    }

    public function getUser(){
        if(auth()->check()){
            return response()->json(["retCode" => 200, "name" => auth()->user()->name]);
        }else{
            return response()->json(["retCode" => 404]);
        }
    }
}
