<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charity ;
use App\Images ;
use App\Donor ;
use App\Post ;

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

        return view("needyPersons" ,['posts'=>$posts,'charities'=>$charities] ) ;
    }

    function codepoint_decode($str) {
        return json_decode(sprintf('"%s"', $str));
    }
    
}
