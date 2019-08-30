<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Redirect;
use Auth;
use Guzzle;
use Session;
use Storage;

class ContactsController extends Controller
{

	protected function index(){

	}

	protected function insert(Request $request){
		$url = $this->file_upload($request);
		DB::table("contacts")->insert(['first_name' => $request->first_name, 'middle_name' => $request->middle_name, 'last_name' => $request->last_name, 'mobile' => $request->mobile, 'landline' => $request->landline, 'email' => $request->email, 'note' => $request->notes, 'image_url' => $url, 'created_at' =>  \Carbon\Carbon::now()]);
		return Redirect::back();
	}

	protected function file_upload($data){
		if($data->hasFile('contact_image')){
			$file = $data->file('contact_image');
			$name = time() . $file->getClientOriginalName();
			$filePath = 'images/' . $name;
			Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
			$url = env('AWS_URL').$filePath;
			return $url;
		}else{
			return null;
		}
	}	
}
