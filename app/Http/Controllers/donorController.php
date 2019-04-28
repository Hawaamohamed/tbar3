<?php

namespace App\Http\Controllers;

use App\Donor ;
use DB ;
use Illuminate\Http\Request;
use Carbon\Carbon;
class donorController extends Controller
{
    public function registerUser()
    {
        $confirm=\request('confirm');
        $data=$this->validate(\request(),[
            'email'=>'required|email|unique:donors',
            'password'=>'required|string|min:6',
        ]);
        if ($confirm==$data['password']){
            $data['password']=bcrypt(\request('password'));

            Donor::create($data);
            session()->flash('added','تم اضافة المستخدم بنجاح ');

            return redirect('/login');
        }
        else{
            return back();
        }
    }

    public function reset_password($token){
        $check_token=DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()
            ->subHours(2))->first();

        if(!empty($check_token))
        {
            return view('reset_password',['data'=>$check_token,'type'=>'donor']);
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
            $donor=Donor::where('email',$check_token->email)->update([
                'email'=>$check_token->email,
                'password'=>bcrypt(request('password'))
            ]);
            DB::table('password_resets')->where('email',request('email'))->delete();
            auth()->guard('donor')->attempt(['email'=>request('email'),'password'=>request('password')]);
            return redirect(url('/login'));
        }
        else
        {
            return redirect(url('reset/password'));
        }
    }
}
