@extends('app')
@section('main')

<div class="dash-nav">
	<div class="dash-links">
		<ul>
			<a href="" data-toggle="modal" data-target="#insertmodal"><li> Add Contact</li></a> 
			<a href="{{ url('/logout') }}"><li>Logout</li></a>
		</ul>
	</div>
</div>

<div class="container contacts">
	<table class="table table-bordered table-striped " id="list">
		<thead>
			<tr>
				<th >Name <i class="fas fa-sort ml-1"></i></th>
				<th>Mobile <i class="fas fa-sort ml-1"></i></th>
				<th>Landline <i class="fas fa-sort ml-1"></i></th>
				<th>Date <i class="fas fa-sort ml-1"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach($contacts as $contact)
			<input type="hidden" name="contact_id" value="{{$contact->id}}">
			<tr data-target="#contact{{$contact->id}}" data-contact="{{$contact->id}}" class="rowtest">
				<td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
				<td>{{ $contact->mobile }}</td>
				<td>{{ $contact->landline}}</td>
				<td>{{  Carbon\Carbon::parse($contact->created_at)->format('d-m-Y') }}</td>
			</tr>
			<div id="contact{{$contact->id}}" class="modal fade" role="dialog">
				 <div class="modal-dialog">
    
			      <!-- Modal content-->
			    	<div class="modal-content">
						<div class="modal-header">
				      		<button type="button" class="close" data-dismiss="modal">&times;</button>
				      	</div>
				      	<div class="modal-body">
				      		<img src="{{ $contact->image_url }}">
				      		<p>First Name: {{ $contact->first_name }}</p>
				      		<p>Middle Name: {{ $contact->middle_name }}</p>
				      		<p>Last Name: {{ $contact->last_name }}</p>
				      		<p>Email: {{ $contact->email }}</p>
				      		<p>Mobile: {{ $contact->mobile }}</p>
				      		<p>Landline: {{ $contact->landline }}</p>
				      		<p>Notes: {{ $contact->note }}</p>
				      		<p>Total Views: <span class="total_views"></span>  </p>
				      	</div>
					</div>
				</div>
			</div>
			@endforeach
		</tbody>
	</table>
</div>



<div class="modal fade insert-modal" id="insertmodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
    	<div class="modal-content">
	      	<div class="modal-header">
	      		<button type="button" class="close" data-dismiss="modal">&times;</button>
	      	</div>
	      	<div class="modal-body">
	      		<h1>Add New Contact</h1>
	      		<form role="form" method="POST" action="{{ url('/contact/insert') }}" class="newcontact" enctype="multipart/form-data" id="contactform">
	      			{{ csrf_field() }}
	      			<div class="contact-field">
	      				<label>First Name*</label>
	      				<input type="text" name="first_name" class="form-control">
	      			</div>
	      			<div class="contact-field">
	      				<label>Middle Name</label>
	      				<input type="text" name="middle_name" class="form-control">
	      			</div>
	      			<div class="contact-field">
	      				<label>Last Name*</label>
	      				<input type="text" name="last_name" class="form-control">
	      			</div>
	      			<div class="contact-field">
	      				<label>Email</label>
	      				<input type="email" name="email" class="form-control">
	      			</div>
	      			<div class="contact-field">
	      				<label>Mobile</label>
	          			<input type="text" name="mobile" class="form-control" required="">
	      			</div>
	      			<div class="contact-field">
	      				<label>Landline*</label>
	          			<input type="text" name="landline" class="form-control" required="">
	      			</div>
	      			<div class="contact-field">
	      				<label>Upload Image</label>
				        <div class="input-group">
				            <span class="input-group-btn">
				                <span class="btn btn-default btn-file">
				                    Select <input type="file" id="imgInp" name="contact_image">
				                </span>
				            </span>
				            <input type="text" class="form-control" readonly placeholder="No File Selected">
				        </div>
				        <!-- <img id='img-upload'/> -->
	      			</div>
	      			<div class="contact-field">
	      				<label>Notes</label>
	      				<textarea name="notes" class="form-control"></textarea>
	      			</div>
	      			<input type="submit" name="submit" value="Submit" class="form-control"> 
	      		</form>
	      	</div>
	    </div>
	</div>
</div>


				     
@endsection