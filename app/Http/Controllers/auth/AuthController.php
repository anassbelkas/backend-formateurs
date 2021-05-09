<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Registration
     */
    public function register(Request $req){
        $this->validate($req, [
            'name'=>'required||min:4|max:55',
            'email'=>'email|required',
            'password'=>'required|confirmed|min:8'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        $user->tokenV = $token;
        $user->save();

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     */
    public function login(Request $req)
    {
        $data = [
            'email' => $req->email,
            'password' => $req->password
        ];

        //Check email
        $user = User::where('email', $data['email'])->first();

        //Check password
        if (!$user || !Hash::check($data['password'], $user->password)){
            return response([
                'message' => 'wrong email or password'
            ], 401);
        }

        if (auth()->attempt($data)) {

            $token = $user->createToken('LaravelAuthApp')->accessToken;

            return response()->json([
                'user' => $user,
                'email_verified_at' => $user->email_verified_at,
                'token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfuly logged out'
        ]);
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
