<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Charity;
use App\Post;
use App\Images;
class PostsAPIController extends Controller
{
    public function store(Request $request)
    {
        $charity = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        $validation = Validator::make($request->all(), [
            'post' => 'required'
        ]);
        if ($validation->passes()) {
            $posts_table = new Post;
            $ch_id = $charity->id;
            $posts_table->story = $request->input('post');
            $posts_table->charity_id = $charity->id;
            $posts_table->type = "post";
            $posts_table->required = 2000;
            $posts_table->payment = 0;
            $posts_table->save();

            $last_row = DB::table('posts')->where('charity_id', $ch_id)->orderBy('id', 'DESC')->first();
            $arr = '';
            if ($request->file('file')) {
                $images = $request->file('file');
                $validation = Validator::make($request->all(), [
                    'file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2024'
                ]);

                global $arr;
                $arr = array();
                $i = 0;
                foreach ($images as $image) {
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/images'), $new_name);

                    $img_table = new Images;
                    $img_table->image = $new_name;
                    $img_table->type = 'post';
                    $img_table->userid = 0;
                    $img_table->charityid = $ch_id;
                    $img_table->postid = $last_row->id;
                    $img_table->save();

                    $arr[] = $new_name;
                }
            }

            return response()->json([
                'message' => 'Post Added Successfully',
                'post' => $posts_table,
                'images' => $arr
            ], 200);
        } else {
            return response()->json([
                'message' => $validation->errors()->all(),
                'post' => '',
                'class_name' => 'alert-danger'
            ], 404);
        }
    }


    public function delete(Request $request)
    {
        $charity = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        $id = $request->input('pid');
        $post = DB::select('delete from posts where id =? and charity_id=?', [$id, $charity->id]);

        $images = DB::table('images')->where('postid', $id)->orderBy('id')->get();
        if (!empty($images)) {
            foreach ($images as $image) {
                unlink(public_path() . '/images/' . $image->image);
                $img = Images::find($image->id);
                $img->delete();
            }
        }

        return response(['status' => true, 'message' => "deleted successfully"]);
    }

    public function update(Request $request)
    {
        $charity = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        $this->validate($request, [
            "post" => 'required'
        ]);
        $id = $request->input('postid');
        $post =[];
        $ch_id = $charity->id;
        $post['story'] = $request->input('post');
        $post['charity_id'] = $ch_id;
        $post['type'] = "post";
        $post['required'] = 2000;
        $updated=Post::where("id",$id)->where("charity_id", $charity->id)->update($post);

        $imagesId = $request->input('imagesId');
        $imagesIds = explode(',', $imagesId);
        for ($i = 0; $i < count($imagesIds); $i++) {
            if ($imagesIds[$i] != '') {
                $intId = (int)$imagesIds[$i];
                $image = Images::find($intId);
                unlink(public_path() . '/images/' . $image->image);
                $image->delete();
            }
        }

        $new_images = $request->file('file');
        if (!empty($new_images)) {

            $validation = Validator::make($request->all(), [
                'file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2024'
            ]);
            if ($validation->passes()) {
                foreach ($new_images as $image) {
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

        return response()->json(["post updated"],200);
    }



}
