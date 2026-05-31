<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
  public function Contact_list()
    {
    	$list = Contact::all();
    	//dd($list->toArray());
    	return view('admin.page.contact_list',[
    		"allPosts" => $list,
    		"title" => "List Contact"
    	]);
    }
    public function Contact_see(Contact $id)
    {
    	$id->status = 1;
    	$id->save();
    	//dd($id->toarray());
    	return view('admin.page.contact_seen',[
    		"Post" => $id,
    		"title" => "See Contact ".$id->Name
    	]);
    }
}
