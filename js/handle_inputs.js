//Add some client side jqery checking of the inputs before sending to php for calculation
function buttonClicked(event){
	//Prevent the default from happening
	event.preventDefault();

	errorMessage = "";
	//Check that the number of weeks is within the default range
	var weeks = $("#weeks").val()
	if (weeks < 2){
		errorMessage += "Your event must be at least 2 weeks from now"
		errorMessage += "<br/>"
	}
	if (weeks > 20){
		errorMessage += "We don't currently support plans of more than 20 weeks"
		errorMessage += "<br/>"
	}

	//Check that the goal time is sensible 
	var total_time = 60*$("#hours").val() + 1*$("#mins").val();
	if( total_time > 600){
		errorMessage += "Please enter a time less than 10 hours"
	}

	//Check that mins is valid
	if( $("#mins").val() < 0 || $("#mins").val() > 59 ){
		errorMessage += "Please enter a number of mins between 0 and 59"
	}

	//Distance is OK as this is a dropdown choice but we'll get javascript to
	//Parse this into one of a few options here before sending to php
	var distance_string = $("#distance").val()
	//Days is a drop down menu so no need for value checking
	var days = $("#days").val();
	//Do some basic checking in case the user has entered a silly time
	var minTime
	switch ( distance_string ){
		case "5 km":
			minTime = 13;
			break 
		case "10 km":
			minTime = 27;
			break;
		case "1/2 Marathon":
			minTime = 60;
			break;
		case "Marathon":
			minTime = 125;
			break;
	}

	if (total_time < minTime){
		errorMessage += "You've entered an unrealistically quick time!"
	}

	//If no errors then call the php script
	if (errorMessage != ""){
		$("#errorDiv").html(errorMessage);
		$("#errorDiv").fadeIn();

	}else{
		$("#errorDiv").css("display", "none");
		var url_for_php = "php/make_plan.php?weeks="+weeks+"&distance="+distance_string+"&days="+days+"&totalTime="+total_time;
		//Then we'll display the contents of the php script to the screen
		$.get( url_for_php, function(data){
			
			//Now put the result in the right div
			$("#output").html(data);
			//And display the div
			$("#output").fadeIn();

		} )
	}
}

$("#submit").click( function(event){
	buttonClicked(event);
} )