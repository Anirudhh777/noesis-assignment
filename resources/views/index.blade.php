@extends('app')
@section('main')

<div class="admin">
		<div class="wrapper fadeInDown">
		  <div id="formContent">
		  	@if(Route::currentRouteName() === 'home')
		  		<form role="form" method="POST" action="{{ secure_url('/login') }}">
			    	{{ csrf_field() }}
			      <input type="email" class="fadeIn second" name="email" placeholder="login" required="">
			      <input type="password" class="fadeIn third" name="password" placeholder="password" required="">
			      <input type="submit" class="fadeIn fourth" value="Log In">
			    </form>
			    @if(!empty(Session::get('error_code')) && Session::get('error_code') == 2)
						<p class="login-error">Credentials do not match, please try again.</p>
				@elseif(!empty(Session::get('error_code')) && Session::get('error_code') == 3)
						<p class="login-error">Registeration Succesfull, please login above</p>
				@endif
			    <div id="formFooter">
			    	<a class="underlineHover reg-link" href="{{ secure_url('/register') }}">Register</a>
			     	 <a class="underlineHover pass-link" href="{{ secure_url('/password/reset') }}">Forgot Password?</a>
			    </div>
			@elseif(Route::currentRouteName() === 'register')
				<form role="form" method="POST" action="{{ secure_url('/register') }}">
			    	{{ csrf_field() }}
			    	<input type="text" class="fadeIn second" name="name" placeholder="name" required="">
			     	<input type="email" class="fadeIn second" name="email" placeholder="email" required="">
			      	<input type="password" class="fadeIn third" name="password" placeholder="password" required="">
			      	<input type="submit" class="fadeIn fourth" value="Register">
			    </form>
			     @if(!empty(Session::get('error_code')) && Session::get('error_code') == 2)
						<p class="login-error">Email Already Registered</p>
				@endif
			    <div id="formFooter">
			    	<a class="underlineHover reg-link" href="{{ secure_url('/') }}">Login</a>
			     	 <a class="underlineHover pass-link" href="{{ secure_url('/password/reset') }}">Forgot Password?</a>
			    </div>
			 @else
			 	<form role="form" method="POST" action="{{ secure_url('/password/reset') }}">
			    	{{ csrf_field() }}
			     	<input type="email" class="fadeIn second" name="email" placeholder="enter your email id" required="">
			      	<input type="submit" class="fadeIn fourth" value="Send">
			    </form>
			     @if(!empty(Session::get('error_code')) && Session::get('error_code') == 3)
						<p class="login-error">Check email for password reset link.</p>
				@endif
				 <div id="formFooter">
				 	<a class="underlineHover reg-link" href="{{ secure_url('/') }}">Login</a>
				 	<a class="underlineHover pass-link" href="{{ secure_url('/register') }}">Register</a>
			    </div>
			 @endif
			</div>
		</div>
	</div>

@endsection