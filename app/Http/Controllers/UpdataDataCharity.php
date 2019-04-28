<?php

namespace App\Http\Controllers;
use App\Charity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdataDataCharity extends Controller
{
  public function show()
  {
      $row=Charity::find(\request('id'));
      return view('update_ch',['row'=>$row]);
  }
  public function update()
  {
      $id=\request('id');
      if (\request('password')=="") {
          $data = $this->validate(request(),
              [
                  'name' => "required",
                  'email' => "required|email|unique:charities,email," . $id,
                  'phone' => "required",
                  'address' => "required",
                  'visa' => "required",
                  'lat'=>'required',
                  'long'=>'required'
              ], [], [
                  'name' =>'الاسم' ,
                  'email' =>'الاميل',
                  'phone' =>'رقم التلفون',
                  'address' =>'العنوان',
                  'visa' =>'رقم الحساب البنكى',
              ]);
      }
      else{
          $data = $this->validate(request(),
              [
                  'name' => "required",
                  'email' => "required|email|unique:charities,email," . $id,
                  'phone' => "required",
                  'address' => "required",
                  'visa' => "required",
                  'lat'=>'sometimes|nullable',
                  'long'=>'sometimes|nullable',
                  'password' => "sometimes|nullable|min:6"
              ], [], [
                  'name' =>'الاسم' ,
                  'email' =>'الاميل',
                  'phone' =>'رقم التلفون',
                  'address' =>'العنوان',
                  'visa' =>'رقم الحساب البنكى',
                  'password' =>'الرقم السرى',
              ]);
          $data['password']=bcrypt(request('password'));
      }
      Charity::where('id',$id)->update($data);
      session()->flash('update','تم تعديل بيانات الجمعيه بنجاح');

      return redirect('/profile/'.$id);
  }
}
