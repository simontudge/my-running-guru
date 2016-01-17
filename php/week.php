<?php
	//A week is an object that consists mainly of an array of 7 activities
	//Some of these can be the special activity rest
	//The object also has a method for displaying the information contained with.
	
	//This is where all the object definitions live
	require( "session_objects.php" );
	
	class Week implements OutputObject{

		public $activities = array();
		private $difficulty;

		//The class itself contains the logic for which activities it needs to
		//contian. We also assume that the end of the week will contain a custom
		//distance, that we can specify in the constuctor as well. We only need
		//specify the difficulty. The user can specify the number of days on which they
		//would like to train as well.
		public function __construct( $difficulty, $final_time, $final_distance, $aim_distance, $days ){
			//Put together some activities based on the difficulty
			$this->difficulty = $difficulty;
			$this->days = $days;

			//Monday can be a speedup session
			if( $this->days > 2 ){
				$start_speed = ( 5 + 12*( $difficulty - 1 )/4 ) ;
				$end_speed = ( 10 + 18*( $difficulty - 1 )/4 ) ;
				$this->activities[1] = new SpeedUpSession($start_speed,$end_speed);
			} else{
				$this->activities[1] = new Rest();
			}

			//For plans with more than 4 days Tuesday can be a crosstraining day
			if( $this->days > 4){
				$this->activities[2] = new CrossSession();
			} else{
				$this->activities[2] = new Rest();
			}
			

			//Wednesday can be a set distance race, for each distance there is a
			//set distance to run here. We'll gradully increase the speed.
			if($this->days > 1){
				$this->activities[3] = $this->getSetDistanceSession($difficulty, $aim_distance);
			} else{
				$this->activities[3] = new Rest();
			}

			//If the number of training days is greater than 5 we'll have a hill training
			//session
			if ( $this->days > 5 ){
				$hillSpeed = ( 6 + 8*( $difficulty - 1 )/4 ) ;
				$flatSpeed = ( 7 + 6*( $difficulty - 1 )/4 ) ;
				$gradient = ( 2 + 11*( $difficulty - 1 )/4 ) ;
				$this->activities[4] = new HillSession( $hillSpeed, $flatSpeed, $gradient );
			}else{
				$this->activities[4] = new Rest();
			}

			//Friday can be a sprint session
			//Need to deside the sprint speed and the slow speed based
			//on the difficulty. Always do 8 reps for now.
			if($this->days > 3){
				$sprintSpeed = ( 10 + 10*( $difficulty - 1 )/4 ) ;
				$slowSpeed = ( 5 + 7*( $difficulty - 1 )/4 ) ;
				$this->activities[5] = new SprintSession( $sprintSpeed, $slowSpeed, 8 );
			}else{
				$this->activities[5] = new Rest();
			}

			//Day 6 is always the distance training
			$this->activities[6] = new SetDistance( $final_distance, $final_time );

			//Day 7 is always for resting
			$this->activities[7] = new Rest();

		}

		public function  getSetDistanceSession($difficulty, $aim_distance){
			//Gets the set time session for a given difficulty and aim distance
			//This could be a static method really.

			switch ($aim_distance){

				case 5:

					$dist = 4;
					$speed = ( 8 + 16*( $difficulty - 1 )/4 );
					break;

				case 10:

					$dist = 6;
					$speed = ( 7 + 15*( $difficulty - 1 )/4 );
					break;

				case 21.1:
					
					$dist = 8;
					$speed = ( 7 + 14*( $difficulty - 1 )/4 );
					break;

				case 42.2:

					
					$dist = 12;
					$speed = ( 7 + 14*( $difficulty - 1 )/4 );
					break;

			}
			$t = $dist/$speed*60;
			return new SetDistance( $dist, $t );
		}

		public function describe(){
			echo '<ul class = "list-group" >';
			foreach ($this->activities as $day => $activity) {
				$activity->describe();
			}
			echo "</ul>";
		}
	}

	//A special class for the race week in which the fitness program is much more relaxed
	class RaceWeek extends Week implements OutputObject{

		public function __construct( $difficulty, $final_time, $final_distance ){
			$this->difficulty = $difficulty;
			//Keep Monday as it would have been
			$start_speed = ( 5 + 7*( $difficulty - 1 )/4 ) ;
			$end_speed = ( 10 + 8*( $difficulty - 1 )/4 ) ;
			$this->activities[1] = new SpeedUpSession($start_speed,$end_speed);

			//Tuseday can be a rest day as normal
			$this->activities[2] = new Rest();

			//Wednesday can be a set run but at a difficulty only 60% of what it would have been
			$this->activities[3] = $this->getSetDistanceSession($difficulty*0.6, $final_distance);

			//Thursday and Friday are then rest days
			$this->activities[4] = new Rest();
			$this->activities[5] = new Rest();

			//Day 6 is the day of the race
			$this->activities[6] = new Race();


			//Day 7 is still a rest day
			$this->activities[7] = new Rest();

		}
	} 

?>