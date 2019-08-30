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
    protected function index(){
    	$id = Auth::user()->id;
    	$faker = Faker\Factory::create();
    	for ($i=0; $i < 20; $i++) { 
    		DB::table("contacts")->insert(['first_name' => $faker->name, 'middle_name' => $faker->name, 'last_name' => $faker->lastName, 'mobile' => $faker->phoneNumber, 'landline' => $faker->phoneNumber, 'email' => $faker->email, 'note' => $faker->text($maxNbChars = 400), 'image_url' => $faker->imageUrl, 'user_id' =>  $id, 'created_at' =>  \Carbon\Carbon::now()->subDays(rand(1, 10))]);
    	}
    	return redirect()->to('/dashboard');
    }

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
