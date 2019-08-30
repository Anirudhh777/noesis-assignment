@extends('app')
@section('main')

<div class="dash-nav">
	<div class="dash-links">
		<ul>
			<a href="" data-toggle="modal" data-target="#insertmodal"><li> Add Contact</li></a> 
			<a href="{{ secure_url('/logout') }}"><li>Logout</li></a>
		</ul>
	</div>
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
	      		<form role="form" method="POST" action="{{ secure_url('/contact/insert') }}" class="newcontact" enctype="multipart/form-data" id="contactform">
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
				                    Select <input type="file" id="imgInp">
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