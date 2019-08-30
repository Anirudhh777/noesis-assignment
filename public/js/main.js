$(document).ready( function() {

	$.validator.addMethod('filesize', function(value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param) 
	});

	$("#contactform").validate({
	    ignore: [],
	    rules: {
	    	first_name: {
		        required: true,
		        lettersonly: true
		      },
	      last_name: {
	        required: true,
	        lettersonly: true
	      },
	      middle_name: {
	        required: false,
	        lettersonly: true
	      },
	      email: {
        	email: true
	    	},
	 		mobile: {
		    	minlength: 10,
		    	maxlength: 10,
		    	number: true,
		    	required: false
		    },
		    landline: {
		    	minlength: 10,
		    	maxlength: 10,
		    	number: true,
		    	required: false
		    },
		    contact_image: {
		    	required: false,
		    	extension: "png|jpeg|jpg|gif",
		    	filesize: 1000 * 512,  
		    }
	      },
	      messages: { contact_image: "File must be JPG, GIF or PNG, less than 500Kb" },
	      submitHandler: function(form) {
	         document.getElementById("contactform").submit();
	      }
	  });

	$(document).on('change', '.btn-file :file', function() {
	var input = $(this),
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [label]);
	});

	$('.btn-file :file').on('fileselect', function(event, label) {
	    
	    var input = $(this).parents('.input-group').find(':text'),
	        log = label;
	    
	    if( input.length ) {
	        input.val(log);
	    } else {
	        if( log ) alert(log);
	    }

	});
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        
	        reader.onload = function (e) {
	            $('#img-upload').attr('src', e.target.result);
	        }
	        
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#imgInp").change(function(){
	    readURL(this);
	}); 	

});