$(document).ready(function(){

	var today = new Date();

	$('#date-from').datepicker({  
		autoclose: true,
	   format: 'dd-mm-yyyy',
	   startDate: new Date(today.getFullYear(), today.getMonth(), today.getDate())

	});  

});



$('#date-from').change(function(){

	$('#date-to').removeAttr("disabled");
	
	checkIfDatefromPastDateto();

});



function checkIfDatefromPastDateto(){

	var date_from = new Date($("#date-from").datepicker("getDate"));
	var date_to = $("#date-to").val();


	if(!date_to || date_to.length == 0 || date_to == ''){
		$('#date-to').datepicker({  
	    	autoclose: true,
	       format: 'dd-mm-yyyy',
	       startDate: new Date(date_from.getFullYear(), date_from.getMonth(), date_from.getDate())

	    }); 

		return;
	}


	var date_to = new Date($("#date-to").val());

	if(date_from != date_to){
		$("#date-to").val(null);
		$('#date-to').datepicker('remove');

		$('#date-to').datepicker({  
	    	autoclose: true,
	       format: 'dd-mm-yyyy',
	       startDate: new Date(date_from.getFullYear(), date_from.getMonth(), date_from.getDate())

	    }); 

		return;

	}
	
	return;
}