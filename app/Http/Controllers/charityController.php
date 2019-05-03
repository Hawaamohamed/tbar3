<?php

namespace App\Http\Controllers;

use App\Charity;
use App\Donor;
use App\Follow;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use DB ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class charityController extends Controller
{
    public function registerCharity(){
        $confirm=\request('confirm');
        $data=$this->validate(\request(),[
            'name'=>'required|string|max:20',
            'email'=>'required|email|unique:charities',
            'long'=>'sometimes|nullable|numeric',
            'lat'=>'sometimes|nullable|numeric',
            'phone'=>'required|numeric',
            'address'=>'required|string',
            'visa'=>'required|numeric',
            'password'=>'required|string|min:6',
            'profile'=>'sometimes|nullable|image|mimes:jpg,jpeg,png,gif',
            'cover'=>'sometimes|nullable|image|mimes:jpg,jpeg,png,gif',
            'advertising'=>'sometimes|nullable',
        ]);
        if ($confirm==$data['password']){
            $data['password']=bcrypt(\request('password'));

            Charity::create($data);
            session()->flash('added','تم اضافة الجمعية بنجاح ');
            return redirect('/login');
        }
        else{
            return back();
        }
    }

    public function login()
    {

        if( request('type') == 1 ) {
            if (auth()->guard('charity')->attempt(['email' => request('email'), 'password' => request('password')])) {

                $id = DB::table('charities')->where('email', request('email'))->value('id');
                $charity = Charity::find($id);
                session()->put('auth', 1);
                session()->put('charity_id', $id);
                session()->put('name', $charity->name);
                session()->put('profile', $charity->profile);
                return redirect( "/profile/".$id );
            }else {
                return back();
            }
        }
        else
        {
            if (auth()->guard('donor')->attempt(['email' => request('email'), 'password' => request('password')])) {
                $id = DB::table('donors')->where('email', request('email'))->value('id');
                session()->put('donor_id', $id);
                session()->put('auth', 1);

                  $donor = Donor::find($id);
                  $followings = $donor->charities;

                return redirect("/needy/persons")->with('followings',$followings);
            } else {
                return back();
            }
        }

    }
    public function resetPassword()
    {
        if (\request('type')=='1')
        {
            $charity=Charity::where('email',\request('email'))->first();
            if (!empty($charity)){
                $token=app('auth.password.broker')->createToken($charity);
                $data=DB::table('password_resets')->insert([
                   'email'=>$charity->email,
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
                return new ResetPassword(['data'=>$charity,'token'=>$token,'type'=>'charity']);
              //  Mail::to($charity->email)->send(new ResetPassword(['data'=>$charity,'token'=>$token]));
                session()->flash('email_sent','The Email is sent, Please Check Your Email ');
                return back();
            }
        }
        elseif (\request('type')=='2')
        {
            $donor=Donor::where('email',\request('email'))->first();
            if (!empty($donor)){
                $token=app('auth.password.broker')->createToken($donor);
                $data=DB::table('password_resets')->insert([
                    'email'=>$donor->email,
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
                return new ResetPassword(['data'=>$donor,'token'=>$token,'type'=>'donor']);
                //  Mail::to($charity->email)->send(new ResetPassword(['data'=>$charity,'token'=>$token]));
                session()->flash('email_sent','The Email is sent, Please Check Your Email ');
                return back();
            }
        }
        return back();
    }
    public function reset_password($token){
        $check_token=DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()
            ->subHours(2))->first();

        if(!empty($check_token))
        {
            return view('reset_password',['data'=>$check_token,'type'=>'charity']);
        }
        else
        {
            return redirect('reset/password');
        }
    }
    public function reset_password_final($token){
        $this->validate(request(),[
            'password'=>'required',
            'confirm'=>'required',

        ]);
        $check_token=DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()
            ->subHours(2))->first();
        if(!empty($check_token))
        {
            // dd($check_token);
            $charity=Charity::where('email',$check_token->email)->update([
                'email'=>$check_token->email,
                'password'=>bcrypt(request('password'))
            ]);
            DB::table('password_resets')->where('email',request('email'))->delete();
            auth()->guard('charity')->attempt(['email'=>request('email'),'password'=>request('password')]);
            return redirect(url('/login'));
        }
        else
        {
            return redirect(url('reset/password'));
        }
    }

    public  function showProfile($id)
    {
        $charity = Charity::find($id);
        $posts = $charity->posts()->orderBy('id', 'DESC')->get();

        return view("profile",compact('charity',"posts") ) ;
    }
}
