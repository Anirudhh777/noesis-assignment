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
use View;

class ContactsController extends Controller
{

	protected function index(){
		$contacts = DB::table("contacts")->where('user_id', Auth::user()->id)->get();
		return view('dashboard')->with('contacts', $contacts);
	}

	protected function insert(Request $request){
		$url = $this->file_upload($request);
		DB::table("contacts")->insert(['first_name' => $request->first_name, 'middle_name' => $request->middle_name, 'last_name' => $request->last_name, 'mobile' => $request->mobile, 'landline' => $request->landline, 'email' => $request->email, 'note' => $request->notes, 'image_url' => $url, 'user_id' =>  Auth::user()->id, 'created_at' =>  \Carbon\Carbon::now()]);
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

	protected function fetch($id){
		$this->update_count($id);
		$total_views = DB::table('views')->where('contact_id', $id)->sum('count');
		return $total_views;

	}

	protected function update_count($id){
		$date = date("Y/m/d");
		if(DB::table('views')->where('contact_id', $id)->where('date', $date)->exists()){
			$data = DB::table('views')->where('contact_id', $id)->where('date', $date)->first();
			DB::table('views')->where('id', $data->id)->update(['count' => $data->count + 1, 'updated_at' =>  \Carbon\Carbon::now()]);
		}else{
			DB::table('views')->insert(['count' => 1, 'date' => $date, 'contact_id' => $id, 'created_at' =>  \Carbon\Carbon::now()]);
		}
	}	
}
