jQuery(document).ready(function($){
    $('#birthdate').datepicker({ dateFormat: "yy-mm-dd" });
    $('#dataForm').validate({
		rules: {
			identifier: "required",
			gender: "required"
	
		},
		messages: {
			identifier: "Please enter the child's name/nickname",
			gender: "Please select male or female"
	
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
