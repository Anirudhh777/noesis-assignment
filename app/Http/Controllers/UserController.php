<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Log;
use Redirect;
use Auth;
use Guzzle;
use Session;


class UserController extends Controller
{

	protected function login(Request $data)
    {
    	if (Auth::attempt(['email' => $data->email, 'password' => $data->password])) {
            $user = User::where('email', $data->email)->first();
            Auth::login($user);
            return redirect()->to('/dashboard');
        }else{
        	return Redirect::back()->with('error_code', 2);
        }
    }

    protected function register(Request $data)
    {
    	if(DB::table('users')->where('email', $data->email)->doesntExist()){
    		User::insert(['name' => $data->name,'email' => $data->email, 'password' => bcrypt($data->password), 'created_at' =>  \Carbon\Carbon::now()]);
        	return redirect('/')->with('error_code', 3);
    	}else{
    		return Redirect::back()->with('error_code', 2);
    	}
    }

    protected function logout()
    {
    	Session::flush();
    	Auth::logout();
    	return redirect('/');
    }
}
