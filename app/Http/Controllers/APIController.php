<?php
namespace App\Http\Controllers;
use App\Charity;

use App\Donor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class APIController extends Controller
{
   public function registerCharity()
   {
       $confirm=\request('confirm');
       $data=Validator::make(\request()->all(),[
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
       if ($data->fails())
       {
           return response()->json($data->errors());
       }
       if ($confirm==\request('password')){
          $password=bcrypt(\request('password'));
          $charity= Charity::create([
              'name'=>\request('name'),
              'email'=>\request('email'),
              'long'=>\request('long'),
              'lat'=>\request('lat'),
              'phone'=>\request('phone'),
              'address'=>\request('address'),
              'visa'=>\request('visa'),
              'password'=>$password,
              'profile'=>\request('profile'),
              'cover'=>\request('cover'),
              'advertising'=>\request('advertising')
          ]);
          $token=JWTAuth::fromUser($charity);
           return response()->json(['token'=>$token]);
       }
       else{
           return response()->json($data->errors());
       }
   }

    public function registerDonor(){
        $confirm=\request('confirm');
        $data=Validator::make(\request()->all(),[
            'name'=>'required|string|max:20',
            'email'=>'required|email|unique:donors',
            'password'=>'required|string|min:6',
        ]);
        if ($data->fails())
        {
            return response()->json($data->errors());
        }
        if ($confirm==\request('password')){
            $password=bcrypt(\request('password'));
            $donor= Donor::create([
                'name'=>\request('name'),
                'email'=>\request('email'),
                'password'=>$password,
            ]);
            $token=JWTAuth::fromUser($donor);
            return response()->json(['token'=>$token]);
        }
        else{
            return response()->json($data->errors());
        }
    }


    public function login(Request $request)
    {

        if (request('type') == 1) {

            $data = Validator::make(\request()->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($data->fails()) {
                return response()->json($data->errors());
            }
            $credential = $request->only('email', 'password');
            try {

                if (!$token = JWTAuth::attempt($credential)) {
                    return response()->json(['error', 'invalid username or password'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error', 'server error'], 500);
            }

            return response()->json(['token' => $token]);
        } else {

                $data = Validator::make(\request()->all(), [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);
                if ($data->fails()) {
                    return response()->json($data->errors());
                }
                $credential = $request->only('email', 'password');

                try {

                    if (!$token = JWTAuth::attempt($credential)) {
                        return response()->json(['error', 'invalid username or password'], 401);
                    }
                } catch (JWTException $e) {
                    return response()->json(['error', 'server error'], 500);
                }

                return response()->json(['token' => $token]);
            }


        }

    public function showProfile(){

        $charity= \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        $posts = $charity->posts()->orderBy('id', 'DESC')->get();
        return response()->json(['charity'=>$charity,'posts'=>$posts]);
    }

    public function updateCharity()
    {
        $charity= \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
        $input=\request()->all();
        if (\request('password') == "") {
            $data = Validator::make($input, [
                'name' => "required",
                'email' => "required|email|unique:charities,email," . $charity->id,
                'phone' => "required",
                'address' => "required",
                'visa' => "required",
                'lat'=>'required',
                'long'=>'required'
            ]);

        }
        else{
            $data = Validator::make($input, [
                    'name' => "required",
                    'email' => "required|email|unique:charities,email," . $charity->id,
                    'phone' => "required",
                    'address' => "required",
                    'visa' => "required",
                    'lat'=>'sometimes|nullable',
                    'long'=>'sometimes|nullable',
                    'password' => "sometimes|nullable|min:6"
                ] );
            $input["password"]=bcrypt(request('password'));
        }


        if ($data->fails()) {
            return response()->json($data->errors());
        }

        $updated=Charity::where('id',$charity->id)->update($input);

        return response()->json(['success'=> 'Data Updated'],200);
    }

}
