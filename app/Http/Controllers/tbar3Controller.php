<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charity ;
use App\Images ;
use App\Donor ;
use App\Post ;
use App\donors_charities;
use App\Charity_charity;

class tbar3Controller extends Controller
{
    public function home()
    {
        $n1 = Charity::all()->count() ;
        $n2 = Donor::all()->count() ;
        $n3 = Post::all()->count() ;
        return view("home" , compact('n1' , 'n2' , 'n3' ) ) ;
    }
    public function logout()
    {
        session()->flush() ;
        return redirect("/home") ;
    }
    public function login()
    {
        return view("login") ;
    }
    public function registerCharity()
    {
        return view("registerCharity") ;
    }
    public function registerUser()
    {
        return view("registerUser") ;
    }
    public function aboutUs()
    {
        return view("aboutUs") ;
    }
    public function needyPersons()
    {
        $posts = Post::orderBy('created_at','desc')->get() ;
        foreach ($posts as $post) {
            $charity = Charity::where( 'id' , $post->charity_id )->get()->first() ;
            $charity->name = $this->codepoint_decode( $charity->name ) ;
            $post['charity'] = $charity ;
            $post['image'] = $post->images() ;
        }
        $charities = Charity::all() ;

        if(session()->has('donor_id'))
        {
          $donor_id = session('donor_id');
          $donor = Donor::find($donor_id);
          $followings = $donor->charities;
        }else if(session()->has('charity_id')){
          $charity_id = session('charity_id');

          $all_followings_id = Charity_charity::where('followingid',$charity_id)->get();
          $followings = array();
          foreach($all_followings_id as $following_id)
          {
            $followings[]=Charity::find($following_id->charityid);
          }
        }else{
          $followings=$charities;
        }
        return view("needyPersons" ,['posts'=>$posts,'charities'=>$charities,'followings'=>$followings]) ;
    }


    function codepoint_decode($str) {
        return json_decode(sprintf('"%s"', $str));
    }



}
