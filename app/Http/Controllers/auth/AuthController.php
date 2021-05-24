<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required||min:4|max:55',
            'firstName' => 'nullable',
            'lastName' => 'nullable',
            'job' => 'nullable',
            'age' => 'nullable',
            'adresse' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'codePostal' => 'nullable',
            'aboutMe' => 'nullable'
        ]);
        if ($validator->fails()){
            $error = $validator->errors()->all()[0];
            return response()->json(['status'=>'false','message'=>$error,'data'=>[]],422);
        }else{
            $user = User::find($request->user()->id);
            $user->name = $request->name;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->job = $request->job;
            $user->age = $request->age;
            $user->adresse = $request->adresse;
            $user->city = $request->city;
            $user->country = $request->country;
            $user->codePostal = $request->codePostal;
            $user->aboutMe = $request->aboutMe;

            $user->update();
            return response()->json(['status'=>'true','message'=>'Profile Updated!','data'=>$user]);
        }
    }

    public function updatePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'nullable|image'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->all()[0];
            return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
        } else {
            $user = User::find($request->user()->id);
            if ($request->picture && $request->picture->isValid()) {
                $file_name = time() . '.' . $request->picture->extension();
                $request->picture->move(public_path('images'), $file_name);
                $path = "images/$file_name";
                $user->picture = $path;
            }
            $user->update();
            return response()->json(['status' => 'true', 'message' => 'Picture Updated!', 'data' => $user]);
        }
    }
}
