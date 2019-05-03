<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charity;
use App\Donor;
use App\donors_charities;
use App\Charity_charity;
class followingsController extends Controller
{
    public function add(Request $request){
      $charityid = $request->input('charityid');
      $sessionid = $request->input('sessionid');
      $status = $request->input('status');

      if($status == "donor"){
         $follow = new donors_charities;
         $follow->donorid = $sessionid;
         $follow->charityid = $charityid;
         $follow->save();
      }else if($status == "charity"){
        $follow = new Charity_charity;
        $follow->charityid = $charityid;
        $follow->followingid = $sessionid;
        $follow->save();
      }
      $charity = Charity::find($charityid);
      $name = $charity->name;
      $profile = $charity->profile;
     return response(['status'=>true,'message'=>"successfully",'name'=>$name,'profile'=>$profile,'charityid'=>$charityid]);
    }


    public function search(Request $request){
    //  $search =  $request->input('search');
    //  $charity = Charity::query()->where('name', 'LIKE', "%{$searchTerm}%") ;
    //  $orders = App\Order::search('Star Trek')->where('user_id', 1)->get();
    }
}
