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
			echo "<strong>$this->type</strong>: ";
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
		public function __construct( $sprintSpeed, $slowSpeed, $reps, $sprintTime = 1, $slowTime = 3 ){
			$this->type = "Sprint";
			$this->sprintSpeed = $sprintSpeed;
			$this->slowSpeed = $slowSpeed;
			$this->reps = $reps;
			$this->slowTime = $slowTime;
			$this->sprintTime = $sprintTime;
		}

		public function describe(){

			echo'<li class="list-group-item">';
			$this->displayType();
			echo "Run at ".number_format( $this->slowSpeed, 1)." km/h ";
			echo "for ". number_format($this->slowTime,2)." min "; 
			echo "and then at ".number_format($this->sprintSpeed,1)." km/h ";
			echo "for ".number_format( $this->sprintTime,2)." min. Repeat $this->reps times.";
			echo'</li>';

		}

	}

	//A hill training sessionn involves running up some inclines of various gradients for varous times
	//A class for sprint session
	class HillSession extends Session implements OutputObject{
		public $hillSpeed;
		public $flatSpeed;
		public $gradient;
		public $flatTime;
		public $hillTime;
		public $reps;

		//The constructor of the class
		public function __construct( $hillSpeed, $flatSpeed, $gradient, $flatTime = 4, $hillTime=1, $reps=8 ){
			$this->type = "Hill Training";
			$this->hillSpeed = $hillSpeed;
			$this->flatSpeed = $flatSpeed;
			$this->gradient = $gradient;
			$this->reps = $reps;
			$this->flatTime = $flatTime;
			$this->hillTime = $hillTime;
		}

		public function describe(){

			echo'<li class="list-group-item">';
			$this->displayType();
			echo "Run at ".number_format( $this->flatSpeed, 1)." km/h along the flat ";
			echo "for ". number_format($this->flatTime,2)." min "; 
			echo "and then at ".number_format($this->hillSpeed,1)." km/h ";
			echo "at a gradient of ".number_format($this->gradient)."% ";
			echo "for ".number_format( $this->hillTime,2)." min. ";
			echo "Repeat $this->reps times.";
			echo'</li>';

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

			echo '<li class="list-group-item" >';
			$this->displayType();
			echo "Run ".number_format($this->distance,1)." km in a time ";
			echo "of ".number_format( $this->time,0 )." mins";
			echo "</li>";
		}
	}

	//A class for a speeding up session (sometimes called a fartlek)
	class SpeedUpSession extends Session implements OutputObject{
		
		public $startSpeed;
		public $endSpeed;
		public $duration;
		public $warmupTime;

		public function __construct( $startSpeed, $endSpeed, $duration = 30, $warmupTime = 4 ){

			$this->type = "Increasing speed";
			$this->startSpeed = $startSpeed;
			$this->endSpeed = $endSpeed;
			$this->duration = $duration;
			$this->warmupTime = $warmupTime;

		}

		public function describe(){

			echo'<li class="list-group-item" >';
			$this->displayType();
			echo "Run at ";
			echo number_format($this->startSpeed,1);
			echo " km/h for ";
			echo number_format( $this->warmupTime,2 );
			echo " mins, then gradually increase speeds until you reach ";
			echo number_format( $this->endSpeed, 1);
			echo " km/h over a time of ";
			echo number_format( $this->duration,2);
			echo " mins.";
			echo "</li>";

		}

	}

	//A class for a rest, this is special in some ways, but we'll still treat it as
	//a session
	class Rest extends Session implements OutputObject{
		
		public function __construct(){
			$this->type = "Rest";
		}

		public function describe(){

			echo'<li class="list-group-item list-group-item-success" >';
			$this->displayType();
			echo "Put your feet up...";
			echo "</li>";

		}

	}

	//This session represents some cross training, but we won't specify what
	class CrossSession extends Session implements OutputObject{

		public function __construct(){
			$this->type = "Cross Training";
		}

		public function describe(){
			echo'<li class="list-group-item" >';
			$this->displayType();
			echo "Do something else that you enjoy, don't take it too seriously";
			echo "</li>";
		}
	}

	//Another special object that represents the race. No need for any input here as the user knows what they
	//want to do anyway.
	class Race extends Session implements OutputObject{

		public function __construct(){
			$this->type = "Race Day";
		}

		public function describe(){
			echo'<li class="list-group-item list-group-item-danger" >';
			$this->displayType();
			echo "Go for it!";
			echo "</li>";
		}
	}  
	
?>
