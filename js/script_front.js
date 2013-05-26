jQuery(document).ready(function($){
    $('#birthdate').datepicker();
    $('#dataForm').validate({
		rules: {
			identifier: "required",
			gender: "required",
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			agree: "required"
		},
		messages: {
			identifier: "Please enter the child's name/nickname",
			gender: "Please select male or female",
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			}
		}
	});
		
		
    //alert('loaded');
    
    //test
    $('#get-due').click(function(e){
		country = $('#wb_country').val();        
		mem = $('#mem_type').val()        
            $.ajax({
            type :  "post",
            url : wpvrSettings.ajaxurl,
            timeout : 5000,
            data : {
                'action' : 'get_dues',
                'country':  country,
                'mem_type': mem
            
            },
            success :  function(data){
                $('#mem_output').html(data).hide().fadeIn('slow');             
            }
            
    } )
    
    });
    
    
})
