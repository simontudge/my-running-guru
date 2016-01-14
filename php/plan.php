<?php
	//This contains the class which describes the whole training plan as one object
	//It takes the parameters given to it by the form in the client facing portion
	//of the site, and creates a plan.
	require( "week.php" );

	class Plan implements OutputObject{
		//These are the three things that come from the form
		public $total_weeks;
		public $distance;
		public $time;
		//This is an array of week objects
		public $weeks = array();
		public $times_array = array();
		public $distance_array = array();
		
		public function __construct( $total_weeks, $distance, $time ){
			$this->distance = $distance;
			$this->total_weeks = $total_weeks;
			$this->time = $time;
			//Categorise the difficulty of the run and come up with a plan
			$this->create_plan();
		}

		public function create_plan(){
			//This is the main bit of the code that can be changed and fiddled
			//with.

			//The actual logic of constructing a plan for a week is left to the
			//week class, we only need to construct an array of these.
			$difficulty_array = $this->getDifficultyArray();
			$this->setTimeDistanceArrays();
			for ($i=1; $i <= $this->total_weeks ; $i++) { 
				$this->weeks[ $i ] = new week( $difficulty_array[$i], $this->times_array[$i], $this->distance_array[$i], $this->distance );
			}
		}

		//Returns the difficulty of the plan based on the time and distance.
		//Returns an integer from 1-5 inclusive
		public function getDifficulty(){
			//Let's do this very crassly to begin with
			$speed = $this->distance/$this->time*60;
			if ( $speed < 8 ){
				return 1;
			} elseif ( $speed < 10){
				return 2;
			} elseif ( $speed < 12){
				return 3;
			} elseif ( $speed < 14){
				return 4;
			} elseif ( $speed < 16){
				return 5;
			}

		}

		//This function returns an array that corresponds to weeks and levels of
		//difficulty for each week
		public function getDifficultyArray(){
			$startingDifficulty = 1;
			$endDifficulty = $this->getDifficulty();
			//We basically make a line between the starting difficulty and the
			//end difficulty
			$delta_x = $this->total_weeks;
			$delta_y = $endDifficulty - $startingDifficulty;
			$m = $delta_y/$delta_x;
			$c = 1;
			$difficulty_array = array();
			for ($i=1; $i <= $this->total_weeks ; $i++) { 
				$difficulty_array[ $i ] = $m*$i + $c;
			}
			return $difficulty_array;
		}

		//Returns an array of times for the final run of the week
		public function setTimeDistanceArrays(){
			//We split this into two cases, if the distance is 5 or 10 km
			//then the training will be running that distance at increasing
			//speeds, otherwise the training will be running at the necessary
			//speed, but shorter distances.
			$necessary_speed = $this->distance / $this->time * 60;
			if ( $this->distance  <= 10 ){
				//we'll start them at 60% of their target speed and increase
				$start_speed = $necessary_speed*0.6;
				for ($i=1; $i <= $this->total_weeks; $i++) {
					$speed = $start_speed + ( $necessary_speed - $start_speed )*
					( $i - 1 )/( $this->total_weeks - 1);
					$this->times_array[$i] = $this->distance/$speed*60;
					$this->distance_array[$i] = $this->distance;
				}
			} else{
				//This is for the long distances, in this case we'll use a fixed speed
				//and increase the distance.
				$start_distance = $this->distance*0.6;
				for ($i=1; $i <= $this->total_weeks; $i++) {
					$dist = $start_distance + ( $this->distance - $start_distance )*
					( $i - 1 )/( $this->total_weeks - 1);
					$this->times_array[$i] = $dist/$necessary_speed*60;
					$this->distance_array[$i] = $dist;
				}

			}
		}

		public function describe(){
			foreach ($this->weeks as $week_number => $week_object) {
				//Every three weeks we need a new row
				if( $week_number%3 == 1 ){
					echo '<div class = "row">';
				}
				//We need tp set up the div
				echo '<div class = "col-md-4">';
				//And setup the header
			 	echo '<div class="panel panel-default">';
				echo '<div class="panel-heading">Week '.$week_number.'</div>';

				//Now we let the week object format it's own list
			 	$week_object->describe();

			 	//And close all the divs
			 	echo "</div>";
			 	echo "</div>";
			 	if( $week_number%3 == 0 ){
					echo '</div>';
				}
			 } 
		}
	
	}

//An example plan for debugging purposes
//$myPlan = new Plan(8, 5, 25);
// print_r($myPlan->times_array);
// echo "<br/>";
// print_r($myPlan->distance_array);

?>