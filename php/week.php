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
		//Specify the difficulty
		public function __construct( $difficulty, $final_time, $final_distance ){
			//Put together some activities based on the difficulty
			$this->difficulty = $difficulty;
			#Try this simply by having a spintsession every day for now
			for ($i=0; $i < 5 ; $i++) { 
				$this->activities[$i] = new SprintSession(2,2,2);
			}
			//Day 6 is always the distance training
			$this->activities[6] = new SetDistance( 10, 45 );

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

	$myWeek = new Week(1, 10, 10);
	$myWeek->describe();

?>