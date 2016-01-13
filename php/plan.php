<?php
	//This contains the class which describes the whole training plan as one object
	//It takes the parameters given to it by the form in the client facing portion
	//of the site, and creates a plan.
	require("session_objects.php");

	class Plan implements OutputObject{
		//These are the three things that come from the form
		public $total_weeks;
		public $distance;
		public $time;
		//This is an array of week objects
		public $weeks = array();
		
		public function __construct( $total_weeks, $distance, $time ){
			$this->distance = $distance;
			$this->total_weeks = $total_weeks;
			$this->time = $time;
			//Categorise the difficulty of the run and come up with a plan
			$this->create_plan();
		}

		public function create_plan(){

		}

		public function describe(){
			echo "Run $this->distance in $this->time in $this->total_weeks"; 
		}
	
	} 
?>