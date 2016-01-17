<?php

	//Given the imputs from the get method this calculates the running
	//plan based on the input of the user
	require("plan.php");

	//This stops anyone from inserting scripts into this script
	$weeks =  htmlspecialchars($_GET["weeks"]);
	$distance = htmlspecialchars( $_GET["distance"] );
	$totalTime = htmlspecialchars($_GET["totalTime"]);
	$days = htmlspecialchars( $_GET["days"] );

	$thePlan = new Plan( $weeks, $distance, $totalTime, $days );
	$thePlan->describe();

?>