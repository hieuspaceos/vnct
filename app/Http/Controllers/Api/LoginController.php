<?php 
namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class LoginController extends Controller
{
	public function login(Request $request)
	{
		 $config = Config::all()->toArray(); 

		 
		 $data = array();
		 if(Auth::attempt(['email' => $request->email, 'password' =>$request->pass,'Level'=>0]))
    	 {
         	$data["sucsess"] = true;
         	$data["data"] = [Auth::user()->toArray()];
         }
         else
         {
         	$data["sucsess"] = false;
         	$data["data"] = [];
         }        
         return Response()->json($data);

	}
	  public function loginfacebook(Request $request)
    {
        //dd($request->picture["data"]["url"]);
          $config = Config::all()->toArray(); 
          $user = User::where("fb_id",$request->id);
          $data = array();
         if ($user->exists())
         {
            $user->update(['name'=> $request->name,
                'email'=> $request->email,
                'profile_photo_path'=> $request->picture["data"]["url"],]);
            $user = User::where("fb_id",$request->id)->get();
            $data["sucsess"] = true;
         	$data["data"] = $user->toArray();
         }
         else
         {
            $user = User::Create([ 
                'name'=> $request->name,
                'email'=> $request->email,
                'profile_photo_path'=> $request->picture["data"]["url"],
                'fb_id'=> $request->id,
            ]);
            $user = User::find($user->id);
            $data["sucsess"] = true;
         	$data["data"] = $user->toArray();
         }
         return Response()->json($data);
           
    }
    public function loginBiometric(Request $request)
    {
         $config = Config::all()->toArray();
         $user = User::where('device_id', 'like', '%'.$request->device_id.'%');
         $data = array();
         if($user->exists())
         {
            $data["sucsess"] = true;
            $data["data"] = $user->get()->toArray();
        }
        else
        {
            $data["sucsess"] = false;           
        }
         return Response()->json($data);
    }
    public function enableauth(Request $request)
    {
         $config = Config::all()->toArray();
         $user = User::find($request->id);

         $data = array();
         if ($user->exists())
         {
            if($request->type==true)
            {
                if($user->device_id=="" || $user->device_id==null)
                {
                    $item = array();
                    array_push($item,$request->device_id);
                }
                else
                {
                    $item = json_decode($user->device_id);

                    if(!in_array($request->device_id,$item))
                    {
                        array_push($item,$request->device_id);
                    }

                }   
                      
                $user->update(['device_id'=> json_encode($item)]);
                $user = User::find($request->id);
            }
            else if($request->type==false)
            {
                $item = json_decode($user->device_id);
                foreach($item as $key => $v)
                {
                    if($v==$request->device_id)
                    {
                        unset($item[$key]);
                    }
                }
                $user->update(['device_id'=> json_encode($item)]);
                $user = User::find($request->id);
            }            
            $data["sucsess"] = true;
            $data["data"] = $user->toArray();
         }
         else
         {
            $data["sucsess"] = false;
            $data["data"] = [];
         }
         
         return Response()->json($data);

    }
}