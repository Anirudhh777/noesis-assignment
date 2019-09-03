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
use Faker;

class DemoDataController extends Controller
{

    // Using Faker to insert 20 Random Contacts into DB under current Logged in User. 
    // Using Carbon subDays with rand to randomize timestamp for Contact. 

    protected function index(){
    	$id = Auth::user()->id;
    	$faker = Faker\Factory::create();
    	for ($i=0; $i < 20; $i++) { 
    		DB::table("contacts")->insert(['first_name' => $faker->name, 'middle_name' => $faker->name, 'last_name' => $faker->lastName, 'mobile' => $faker->phoneNumber, 'landline' => $faker->phoneNumber, 'email' => $faker->email, 'note' => $faker->text($maxNbChars = 400), 'image_url' => $faker->imageUrl, 'user_id' =>  $id, 'created_at' =>  \Carbon\Carbon::now()->subDays(rand(1, 10))]);
    	}
    	return redirect()->to('/dashboard');
    }

    // Fecthing all Contacts for Logged in User. 
    // Itterating through every Contact Fetched. 
    // Running a Loop for each individual Contact with a Random Value for Test Counter so it can insert different number of views for each Contact. 
    // Randomly Selecting a day from current date to last 7 Days in each itteration to insert a view. 

    protected function views(){
    	$id = Auth::user()->id;
    	$contacts = DB::table("contacts")->where('user_id', $id)->pluck('id');
    	$date = date("Y/m/d");
    	foreach ($contacts as $id) {
    		for ($i=0; $i < rand(5, 10); $i++) { 
    			$day = rand(1, 7);
    			$prev_day = date("Y/m/d", strtotime('-'.$day.'days', strtotime($date)));
    			if(DB::table('views')->where('contact_id', $id)->where('date', $prev_day)->exists()){
					$data = DB::table('views')->where('contact_id', $id)->where('date', $prev_day)->first();
					DB::table('views')->where('id', $data->id)->update(['count' => $data->count + 1, 'updated_at' =>  \Carbon\Carbon::now()]);
				}else{
					DB::table('views')->insert(['count' => 1, 'date' => $prev_day, 'contact_id' => $id, 'created_at' =>  \Carbon\Carbon::now()]);
				}
    		}
    	}
    	return redirect()->to('/dashboard');
    }
}
