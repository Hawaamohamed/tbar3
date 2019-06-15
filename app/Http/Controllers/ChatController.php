<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
class ChatController extends Controller
{
   public function send_message(){
       $message=$this->validate(\request(),[
           'message'=>"required",
           'from_id'=>"required",
           "to_id"=>"required",
       ]);

      $m= Message::create($message);
      return response(["status"=>true,"message"=>"sent"],200);
   }
   public function get_message(){
        if(\request()->ajax()){
       $mes1=DB::select("select* from messages where from_id=? and to_id=? or from_id=? and to_id=? Order By created_at ",[\request('me'),\request('him'),\request('him'),\request("me")]);
       //$mes2=DB::select("select* from messages where from_id=? and to_id=?",[\request('him'),\request('me')]);


      //$msg=array_merge($mes1,$mes2);
      //array_sort($msg,);
        return response()->json(["messages"=>$mes1],200);
   }
   }

   //API for Chat

    public function sendMessage(){

        $user= \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        $message=$this->validate(\request(),[
            'message'=>"required",
            'from_id'=>"required",
            "to_id"=>"required",
        ]);

        $m= Message::create($message);
        return response()->json(['success'=> 'message sent'],200);
    }

    public function getMessage(){
        $user= \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        if(\request()->ajax()){
            $mes1=DB::select("select* from messages where from_id=? and to_id=? or from_id=? and to_id=? Order By created_at ",[\request('me'),\request('him'),\request('him'),\request("me")]);
            return response()->json(['messages'=> $mes1],200);
        }
    }
}
