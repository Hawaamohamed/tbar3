<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Images;
use App\Charity;
use Validator;

class photosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      return view("profile");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update_profile(Request $request)
     {
           $chid = $request->input('charity_id');
           $charity=Charity::find($chid);
           $validation = Validator::make($request->all(), [
           'select_file' => 'required|image|mimes:jpeg,png,jpg,gif,JPG,PNG,JPEG,GIF'
          ]);
          if($validation->passes())
          {
            if($charity->profile != 'pro.jpg')
            {
              unlink(public_path() .  '/avatar/' . $charity->profile );
            }

           $image = $request->file('select_file');
           $new_name = rand() . '.' . $image->getClientOriginalExtension();
           $image->move(public_path('avatar'), $new_name);

           $charity->profile=$new_name;
           $charity->save();




           return response()->json([
            'message'   => 'Image Upload Successfully',
            'uploaded_image' => $new_name,
            'class_name'  => 'alert-success'
           ]);
          }
          else
          {
           return response()->json([
            'message'   => $validation->errors()->all(),
            'uploaded_image' => 'no-image.jpg',
            'class_name'  => 'alert-danger'
           ]);
          }
   }


   public function update_cover(Request $request)
   {

         $chid = $request->input('charity_id');
         $charity=Charity::find($chid);
         $validation = Validator::make($request->all(), [
         'select_file' => 'required|image|mimes:jpeg,png,jpg,gif,JPG,PNG,JPEG,GIF'
        ]);
        if($validation->passes())
        {
          if($charity->cover != 'cover.jpg')
          {
           unlink(public_path() .  '/avatar/' . $charity->cover );
          }
         $image = $request->file('select_file');
         $new_name = rand() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('avatar'), $new_name);

         $charity->cover=$new_name;

         $charity->save();

         return response()->json([
          'message'   => 'Image Upload Successfully',
          'uploaded_image' => $new_name,
          'class_name'  => 'alert-success'
         ]);
        }
        else
        {
         return response()->json([
          'message'   => $validation->errors()->all(),
          'uploaded_image' => '',
          'class_name'  => 'alert-danger'
         ]);
        }
   }


}
