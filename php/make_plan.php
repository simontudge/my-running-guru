<?php

	//Given the imputs from the get method this calculates the running
	//plan based on the input of the user
	require("plan.php");
	$thePlan = new Plan( $_GET["weeks"], $_GET["distance"], $_GET["totalTime"], $_GET["days"] );
	$thePlan->describe();

?>