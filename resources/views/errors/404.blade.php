@extends('app')
@section('main')

<div class="admin">
	<div class="wrapper fadeInDown">
		<div id="formContent">
			<p class="login-error">Oops, 404 Error, Page Not Found</p>
			<div id="formFooter">
				@if(\Auth::check())
					<a class="underlineHover reg-link" href="{{ url('/dashboard') }}">Dashboard</a>
					
				@else
					<a class="underlineHover reg-link" href="{{ url('/') }}">Login</a>
					<a class="underlineHover pass-link" href="{{ url('/register') }}">Register</a>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection