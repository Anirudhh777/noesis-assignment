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

	//Check whether request has file upload, if yes then fetch file, set path and upload to S3 bucket. Return Image URL. 

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

	// Updating View Count and then Fetching the Total View Count for a Contact, Returning along with Contact Data

	protected function fetch($id){
		$this->update_count($id);
		$total_views = DB::table('views')->where('contact_id', $id)->sum('count');
		$contact = DB::table('contacts')->where('id', $id)->first();
		$data = array($total_views, (array) $contact);
		return $data;

	}


	// Checking if Row with Contact ID & Current Data Exist in Views Table, if exists then updating View Count, if not then inserting new Row.

	// Using the Date field in Views table to collect/count all views for a Contact for a particular date in a Single Row rather than have a new Row for every View.

	protected function update_count($id){
		$date = date("Y/m/d");
		if(DB::table('views')->where('contact_id', $id)->where('date', $date)->exists()){
			$data = DB::table('views')->where('contact_id', $id)->where('date', $date)->first();
			DB::table('views')->where('id', $data->id)->update(['count' => $data->count + 1, 'updated_at' =>  \Carbon\Carbon::now()]);
		}else{
			DB::table('views')->insert(['count' => 1, 'date' => $date, 'contact_id' => $id, 'created_at' =>  \Carbon\Carbon::now()]);
		}
	}

	// Fetching Contact View Count for the past 7 Days.
	// Current Date View Count is Fetched and stored in Days Array
	// Using Date format inside a Loop to itterate through past 7 Days. 

	protected function view_history($id){
		$date = date("Y/m/d");
		$days = array();
		$views = $this->count_views($id, $date);
		$days[0] = array('day' => date("D"), 'views' => $views);
		for ($i=1; $i < 7; $i++) { 
			$prev_day = date("Y/m/d", strtotime('-'.$i.'days', strtotime($date)));
			$prev_views = $this->count_views($id, $prev_day);
			$days[$i] = array('day' => date("D", strtotime('-'.$i.'days', strtotime(date("D")))), 'views' => $prev_views);
		}
		return $days;
	}	

	// Receiving Contact ID and Date from View History to fetch Contact View Count for the particular date. 

	protected function count_views($id, $date){
		if(DB::table('views')->where('contact_id', $id)->where('date', $date)->exists()){
			$view = DB::table('views')->where('contact_id', $id)->where('date', $date)->first();
			return $view->count;
		}else{
			return 0;
		}
	}
}
