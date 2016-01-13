<?php
	//Definitions of all the classes to do with sessions
	//The all inherit session which has very little functionalilty
	//except to define a type and how to display the type.

	//A super class for all session classes
	class Session{
		public $type;

		public function __construct($type){
			$this->type = $type;
		}

		public function displayType(){
			echo "<h3>$this->type</h3><br/>";
		}
	}

	//The interface simply requires that all classes have a method describe
	interface OutputObject{
		public function describe();
	}
	
	//A class for sprint session
	class SprintSession extends Session implements OutputObject{
		public $sprintSpeed;
		public $slowSpeed;
		public $reps;

		//The constructor of the class
		public function __construct( $sprintSpeed, $slowSpeed, $reps ){
			$this->type = "Sprint";
			$this->sprintSpeed = $sprintSpeed;
			$this->slowSpeed = $slowSpeed;
			$this->reps = $reps;
		}

		public function describe(){
			echo "Run at $this->slowSpeed km/h and then at $this->sprintSpeed km/h. Repeat $this->reps times." ;
		}

	}

	//A class for running a set distance in a set time
	class SetDistance extends Session implements OutputObject{
		public $distance;
		public $time;

		public function __construct( $distance, $time){
			$this->type = "Timed Run";
			$this->distance = $distance;
			$this->time = $time;
		} 

		public function describe(){
			echo "Run $this->distance km in a time of $this->time mins";
		}
	}

	//A class for a rest, this is spcial in some ways, but we'll still treat it as
	//a session
	class Rest extends Session implements OutputObject{
		
		public function __construct(){
			$this->type = "Rest";
		}

		public function describe(){
			echo "Put your feet up...";
		}

	}

	// $mySes = new SprintSession( 3,4,5 );
	// $mySes->displayType();
	// $mySes->describe();
	
?>
