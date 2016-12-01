<?php

class player{
	private $TID;
	public $PLID;
	public $firstName;
	public $lastName;
	public $catching;
	public $hitting;
	public $throwing;
	public $running;
	public $stamina;
	public $position;
	
	function __construct($first, $last, $c, $h, $t, $r, $s, $PLID, $position){
		$this->firstName = $first;
		$this->lastName = $last;
		$this->catching = $c;
		$this->hitting = $h;
		$this->throwing = $t;
		$this->running = $r;
		$this->stamina = $s;
		$this->PLID = $PLID;
		$this->position = $position;
	}
	public function setStats($c, $h, $t, $r, $s){ 
		setCatching($c);
		setHitting($h);
		setThrowing($t);
		setRunning($r);
		setStamina($s);		
	}
	
	public function setCatching($c){
		$this->catching = $c;
	}
	public function setHitting($h){
		$this->hitting = $h;
	}
	public function setThrowing($t){
		$this->throwing = $t;
	}
	public function setRunning($r){
		$this->running = $r;
	}
	public function setStamina($s){
		$this->stamina = $s;
	}
	public function setPLID($PLID){
		$this->PLID = $PLID;
	}
	public function setPosition($position){
		$this->PLID = $position;
	}
	
	public function getFirstName(){
		return $this->firstName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function getCatching(){
		return $this->catching;
	}
	public function getHitting(){
		return $this->hitting;
	}
	public function getThrowing(){
		return $this->throwing;
	}
	public function getRunning(){
		return $this->running;
	}
	public function getStamina(){
		return $this->stamina;
	}
	public function getPLID(){
		return $this->PLID;
	}
	public function getPosition(){
		return $this->position;
	}
}

?>