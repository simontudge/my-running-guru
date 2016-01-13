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
		//specify the difficulty
		public function __construct( $difficulty, $final_time, $final_distance, $aim_distance ){
			//Put together some activities based on the difficulty
			$this->difficulty = $difficulty;

			//Monday can be a speedup session
			$start_speed = ( 5 + 12*( $difficulty - 1 )/4 ) ;
			$end_speed = ( 10 + 18*( $difficulty - 1 )/4 ) ;
			$this->activities[1] = new SpeedUpSession($start_speed,$end_speed);


			//Tuesday and Thursday can be rest days
			$this->activities[2] = new Rest();

			//Wednesday can be a set distance race, for each distance there is a
			//set distance to run here. We'll gradully increase the speed.
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
			$this->activities[3] = new SetDistance( $dist, $t );

			$speed = ( 8 + 16*( $difficulty - 1 )/4 );

			//Another rest on Tursday
			$this->activities[4] = new Rest();

			//Friday can be a sprint session
			//Need to deside the sprint speed and the slow speed based
			//on the difficulty. Always do 8 reps for now.
			$sprintSpeed = ( 10 + 10*( $difficulty - 1 )/4 ) ;
			$slowSpeed = ( 5 + 7*( $difficulty - 1 )/4 ) ;
			$this->activities[5] = new SprintSession( $sprintSpeed, $slowSpeed, 8 ); 

			//Day 6 is always the distance training
			$this->activities[6] = new SetDistance( $final_distance, $final_time );

			//Day 7 is always for resting
			$this->activities[7] = new Rest();

		}

		public function describe(){
			echo "<ol>";
			foreach ($this->activities as $day => $activity) {
				echo"<li>";
				$activity->displayType();
				$activity->describe();
				echo "</li>";
			}
			echo "</ol>";
		}
	}

	// $myWeek = new Week(1, 10, 10);
	// $myWeek->describe();

?>