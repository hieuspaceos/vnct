<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usernewsletter;
class UsesnewsController extends Controller
{
    //
    public function add(Request $request)
    {
    	$request->validate([
	        'email' => 'required|email|max:255|unique:usernewsletters',
	        'phone' => 'required|numeric|unique:usernewsletters'
    	]);
    	Usernewsletter::Create([
    		"email" => $request->email,
    		"phone" => $request->phone,
    	]);
        $data = array(
            "email" =>  $request->email,
            "phone" => $request->phone,
            "subject" => "Email đăng ký nhận bản tin",
            "body" => "
                <div>email: ".$request->email."</div>
                <div>phone: ".$request->phone."</div>                
            ",
        );
        app('App\Http\Controllers\MailerController')->SendEmailall($data);
    	return array(
    		"sussess"=>true
    	);
        //return response()->json(['error'=>$validated->errors()->all()]);

    }
}
