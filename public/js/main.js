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

	$('#list').DataTable({"paging":false});
	// $('.dataTables_length').addClass('bs-select');
	
	$(".rowtest").click( function(e){
		e.preventDefault();
		url = encodeURI("/fetch/count/" + $(this).data("contact"));
		id = $(this).data("target");
		$.get(url, function(data, status){
			$('.contactimg').attr('src', data[1]['image_url']);
		    $(".total_views").html(data[0]);
		    $(".fname").html(data[1]['first_name']);
		    $(".lname").html(data[1]['last_name']);
		    $(".mname").html(data[1]['middle_name']);
		    $(".email").html(data[1]['email']);
		    $(".mobile").html(data[1]['mobile']);
		    $(".landline").html(data[1]['landline']);
		    $(".note").html(data[1]['note']);
		    $("#contactmodal").modal();
		    $('.fetch_history').attr("data-id",data[1]['id']);
		    // $('.chartinfo').attr("id", "myChart"+data[1]['id']);
		  });
	});

	var ctx = document.getElementById('myChart');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: [1, 2, 3, 4, 5, 6, 7],
	        datasets: [{
	            label: 'views',
	            data: [1, 2, 3, 4, 5, 6, 7],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});

	function updateConfigAsNewObject(chart, label, data1) {
	    chart.data = {
	    	labels: label,
	    	datasets: [{
	            label: 'views',
	            data: data1,
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255, 99, 132, 1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    }
	    chart.update(0);
	}

	function removeData(chart) {
	    chart.data.labels.pop();
	    chart.data.datasets.forEach((dataset) => {
	        dataset.data.pop();
	    });
	    chart.reset();
	}

	$(".fetch_history").click( function(e){
		e.preventDefault();
		url_new = encodeURI("/fetch/view/history/" + document.getElementById('fetchtest').getAttribute('data-id'));
		$.get(url_new, function(data, status){	
			labels = [data[0]['day'], data[1]['day'], data[2]['day'], data[3]['day'], data[4]['day'], data[5]['day'], data[6]['day']];
			dataset = [data[0]['views'], data[1]['views'], data[2]['views'], data[3]['views'], data[4]['views'], data[5]['views'], data[6]['views']];
			removeData(myChart);
			updateConfigAsNewObject(myChart, labels , dataset);
		});
		$('.contact-info').slideUp('slow');
		$('.viewhistory').show();
	});

	$(".close_canvas").click( function(e){
		e.preventDefault();	
		removeData(myChart);
		$('.viewhistory').hide();
		$('.contact-info').show();
	});

	$("#contactmodal").on("hidden.bs.modal", function () {
		removeData(myChart);
		$('.viewhistory').hide();
		$('.contact-info').show();		
	});
});