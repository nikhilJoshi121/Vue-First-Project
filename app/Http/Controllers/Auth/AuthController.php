<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
        $user = User::create([ 'name'=> $request->name,
                        'email'=>$request->email,
                        'password'=>Hash::make($request->password)
                     ]);

        return response()->json( ['message'=>'Successfully Registered'], 201);

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => ['required', 'string', 'min:6'],
        ]);

        if(!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
           return response()->json(['message'=>'Unauthorised please try attempt',
                                    'status_code'=>401
                                     ], 401);
        }

        $user = $request->user(); //Current User 
        $success['token'] = $user->createToken('Personal Access Token');
        $token =  $success['token'];

        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
        }
          
      
        return response()->json([
            'success' => true,
            'token' =>  $success['token']->accessToken,
            'token_type'=> 'Bearer',
            'expire_at'=> Carbon::parse( $success['token']->token->expires_at)->toDateTimeString(),
            'user' => $user,
            'status_code'=> 200
        ]);

        
    }

    public function logout(){
        
        Auth::user()->token()->revoke();

        if(auth::user()){
            return  response()->json(['message'=> 'Some issues are occured.'], 200);
        }
        else{
            return  response()->json(['message'=> 'Successfuly logout'], 200);
        }

       
    }
}
