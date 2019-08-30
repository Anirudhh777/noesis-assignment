$(document).ready( function() {

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
		    }
	      },
	      submitHandler: function(form) {
	         document.getElementById("contactform").submit();
	          // grecaptcha.execute();
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