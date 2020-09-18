<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ChatController extends Controller
{
    public function chat(){
         
        return view('welcome');
    }

    public function send(request $request){
         
        $user = User::findorFail(Auth::id()); 
        event(new ChatEvent( $request->$message, $user));
    }
}
