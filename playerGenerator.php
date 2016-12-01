<?php 
require_once 'player.php';

class playerGenerator
{
	private static $firstName;
	private static $lastName;
	private static $catching;
	private static $hitting;
	private static $throwing;
	private static $running;
	private static $FirstNameList = array("Kevin", "Austin", "Jimmy", "Kyle", "Carlos", "Lucas", "Jacob", "Steven", "Spongebob", "Overseer",
					 		"Patrick", "Jackie", "Babe", "Marcus", "Kanye", "North", "Saintiago", "Caesar", "Morimoto",
							 "Sammy", "Beyonce", "Jay", "Donny", "Jerry", "George", "Jorge", "Mike", "James", "Tony", "Suboh");
	private static $LastNameList = array("Marx", "Squarepants", "Castro", "Z", "Trump", "Drumph", "Escobar", "Willnow", "Ossa", "Plaza",
							"King", "TheTiger", "Bobby", "Gomez", "Jeter", "Rodriguez", "Brady", "Star", "Plager", "Duke",
							"Mosbey", "Stinson", "Erickson", "Finkle", "Abichar", "Suboh", "Turgut", "Bacanli", "Dave");
							
	public static function getNewTeam($playerExp)
	{
		$team = array();
		for ($i = 0; $i < 15; $i++)
		{
			array_push($team, playerGenerator::getNewPlayer($playerExp, $i + 1));
		}
		return $team;
	}
	
	private static function nameGenerator(){
		playerGenerator::$firstName = playerGenerator::$FirstNameList[rand(0, count(playerGenerator::$FirstNameList) - 1)];
		playerGenerator::$lastName = playerGenerator::$LastNameList[rand(0, count(playerGenerator::$LastNameList) - 1)];
	}
	
	private static function randomStats($playerExp){
		$scale = $playerExp;
		if($playerExp < 75){
			$scale = 75;
		}
		if($scale >= 1000)
		{
			$scale = 1000;
		}
		playerGenerator::$catching = round(playerGenerator::randomFloat(($scale/2)/1000, $scale/1000), 3);
		playerGenerator::$hitting = round(playerGenerator::randomFloat(($scale/2)/1000, $scale/1000), 3);
		playerGenerator::$throwing = round(playerGenerator::randomFloat(($scale/2)/1000, $scale/1000), 3);
		playerGenerator::$running = round(playerGenerator::randomFloat(($scale/2)/1000, $scale/1000), 3);
	}
	private static function randomFloat($min, $max){
		return $min + mt_rand()/mt_getrandmax() * ($max - $min);
	}

	
	public static function getNewPlayer($playerExp, $position){
		playerGenerator::randomStats($playerExp);
		playerGenerator::nameGenerator();
		$newPlayer = new player(playerGenerator::$firstName, playerGenerator::$lastName,
							 playerGenerator::$catching, playerGenerator::$hitting,
							 playerGenerator::$throwing, playerGenerator::$running, 50, NULL, $position);

		return $newPlayer;
	}
}
?>