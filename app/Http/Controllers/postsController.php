<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use App\Charity;
use App\Post;
use App\Images;
use Validator;

class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->get();

        return view("profile",compact("posts"));
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
    public function store(Request $request)
    {
      $validation = Validator::make($request->all(), [
      'post' => 'required'
        ]);
        if($validation->passes())
        {
            $posts_table = new Post;
            $ch_id = $request->input("ch_id");
            $posts_table->story = $request->input('post');
            $posts_table->charity_id = $request->input('ch_id');
            $posts_table->type = "post";
            $posts_table->required = $request->input('required');
            $posts_table->payment = 0;
            $posts_table->save();

            $last_row=DB::table('posts')->where('charity_id',$ch_id)->orderBy('id', 'DESC')->first();
            $arr='';
            if($request->file('file'))
            {
              $images = $request->file('file');
              $validation = Validator::make($request->all(), [
              'file.*' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

              global $arr;
              $arr=array();
              $i=0;
              foreach($images as $image)
              {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/images'), $new_name);

                $img_table = new Images;
                $img_table->image = $new_name;
                $img_table->type = 'post';
                $img_table->userid = 0;
                $img_table->charityid = $ch_id;
                $img_table->postid = $last_row->id;
                $img_table->save();

                $arr[]=$new_name;
              }
            }

        return response()->json([
          'message'   => 'Post Added Successfully',
          'post' => $posts_table,
          'images'=> $arr
        ]);
      }else{
        return response()->json([
          'message'   => $validation->errors()->all(),
          'post' => '',
          'class_name'  => 'alert-danger'
        ]);
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $charity = Charity::find($id);
        $posts = $charity->posts;
        return view("profile",compact("charity","posts"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $post=Post::find($id);
      return view('editPost')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      $this->validate($request,[
      "post"=>'required'
      ]);
      $id = $request->input('postid');
      $post = Post::find($id);
      $ch_id = $request->input("ch_id");
      $post->story = $request->input('post');
      $post->charity_id = $ch_id;
      $post->type = "post";
      $post->required = 2000;
      $post->payment = 0;
      $post->save();

      $imagesId=$request->input('imagesId');
      $imagesIds = explode(',',$imagesId);
      for($i=0;$i<count($imagesIds);$i++)
      {
        if($imagesIds[$i] != '')
        {
          $intId=(int)$imagesIds[$i];
          $image = Images::find($intId);
          unlink(public_path() .  '/images/' . $image->image );
          $image->delete();
       }
     }

      $new_images = $request->file('file');
      if(!empty($new_images))
      {
        
        $validation = Validator::make($request->all(), [
        'file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2024'
       ]);
        if($validation->passes())
        {
          foreach($new_images as $image)
          {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/images'), $new_name);

            $img_table = new Images;
            $img_table->image = $new_name;
            $img_table->type = 'post';
            $img_table->userid = 0;
            $img_table->charityid = $ch_id;
            $img_table->postid = $id;
            $img_table->save();

          }
      }
    }

     return redirect()->route("show",$ch_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $id = $request->input('pid');
      $post = Post::find($id);
      $post->delete();
      $images = DB::table('images')->where('postid',$id)->orderBy('id')->get();
       if(!empty($images))
       {
       foreach($images as $image)
       {
          unlink(public_path() .  '/images/' . $image->image );
          $img=Images::find($image->id);
          $img->delete();
       }
     }

      return response(['status'=>true,'message'=>"deleted successfully"]);
   }
}
