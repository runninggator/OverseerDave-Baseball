<?php

require_once 'header.php';
require_once 'User.php';
$money = NULL;
$experience = NULL;
$random1 = NULL;
$random2 = NULL;
$username = $_SESSION['username'];
$newPlayer = array();
$playerNames = array();
$playerHittingStats = array();
$playerThrowingStats = array();
$playerRunningStats = array();
$playerCatchingStats = array();
$playerPLID = array();
$replacePlayer = NULL;
$success = NULL;
$pName = '';

if (isset($_POST['replacePlayer'])) $replacePlayer = $_POST['replacePlayer'];
else header ('Location: scout.php');

class swapPlayer
{
	public $hitting;
	public $running;
	public $throwing;
	public $catching;
	public $forename;
	public $surname;
	public $swapID;
	
	function __construct($name, $hitting, $running, $throwing, $catching, $swapID)
	{
		$this->forename = $this->getForename($name);
		$this->surname = $this->getSurname($name);
		$this->hitting = $hitting;
		$this->running = $running;
		$this->throwing = $throwing;
		$this->catching = $catching;
		$this->swapID = $swapID;
	}
	
	function getForename($name)
	{
		$string = explode(" ", $name);
		//echo "First Name: $string[0]<br>";
		return $string[0];
	}
	
	function getSurname($name)
	{
		$string = explode(" ", $name);
		//echo "Last Name: $string[1]<br>";
		return $string[1];
	}
}

$query = "SELECT * FROM person WHERE username='$username'";
$result = queryMysql($query);
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);
if ($result->num_rows == 1)
{
	$money = $row['money'];
	if ($money < 10) header("Location: scout.php");
	$experience = $row['experience'];
	if($money < 10)
	{
		echo "You must have at least $10 to get a new player!";
	}
	else
	{	
		for($i = 0; $i < 5; $i++)
		{
			array_push($newPlayer, playerGenerator::getNewPlayer($experience, 10));
		}
		for($i = 0; $i < 5; $i++)
		{
			$playerNames[$i] = $newPlayer[$i]->getFirstName() . " " . $newPlayer[$i]->getLastName();
			$playerHittingStats[$i] = $newPlayer[$i]->getHitting();
			$playerThrowingStats[$i] = $newPlayer[$i]->getThrowing();
			$playerRunningStats[$i] = $newPlayer[$i]->getRunning();
			$playerCatchingStats[$i] = $newPlayer[$i]->getCatching();
			$playerPLID[$i] = $replacePlayer;
		}
	}
}

$random1 = rand(0,4);
$random2 = rand(0,4);
while($random1 == $random2)
{
	$random2 = rand(0,4);
}

function checkboxes()
{
	global $username;
	global $money;
	
	if (isset($_POST['random']))
	{
		global $success;
		global $pName;
		//echo "You chose Player 1<br>";
		$swapPlayer = unserialize(base64_decode($_POST['random']));
		$pName = $swapPlayer->forename . " " . $swapPlayer->surname;
		$success = true;
		$newAmount = $money - 10;
		$query = "UPDATE person SET money = '$newAmount' WHERE username='$username'";
		$result = queryMysql($query);
		if (!$result) echo "ERROR: Could Not Create Team<br>";
		
		$PLID = $swapPlayer->swapID;
		$hitting = $swapPlayer->hitting;
		$throwing = $swapPlayer->catching;
		$running = $swapPlayer->running;
		$catching = $swapPlayer->catching;
		$forename = $swapPlayer->forename;
		$surname = $swapPlayer->surname;
		//echo "PLID: $PLID<br>";
		
		$query = "UPDATE player SET hitting='$hitting', throwing='$throwing', running='$running', catching='$catching', stamina='50',
						first='$forename', last='$surname' WHERE plid='$PLID'";
		$result = queryMysql($query);
// 		if ($result) echo "Successfully Updated Player<br>";
// 		else echo "Did not Update Player<br>";
	}
}

$randPlayer1 = new swapPlayer($playerNames[$random1], $playerHittingStats[$random1], $playerRunningStats[$random1], 
		$playerThrowingStats[$random1], $playerCatchingStats[$random1], $playerPLID[$random1]);
$randPlayer2 = new swapPlayer($playerNames[$random2], $playerHittingStats[$random2], $playerRunningStats[$random2], 
		$playerThrowingStats[$random2], $playerCatchingStats[$random2], $playerPLID[$random2]);
$serialize1 = base64_encode(serialize($randPlayer1));
$serialize2 = base64_encode(serialize($randPlayer2));

checkboxes();

echo "<div class='container'>";
if (isset($success) && $success == true)
{
	//alertMessage('success', "You Chose $pName");
	echo <<< _END
	<form action="scout.php" method="post" name='myform'>
    	<input type="hidden" name="success" value="$pName">  
    	<input name='success' type="submit" value="$pName">
	</form>
	<script type="text/JavaScript">
      document.myform.submit();
 	</script>
_END;
}
echo <<< _END
<style>
body{
	background-image: url("image2.jpg");
	background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: bottom right; 
	 background-size: 100% 100%;
}
</style>
		<div class="row">
	        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
				<div class='row'>
					<div class='col-xs-12'>
						<div class="panel panel-default">
							<div class='panel-heading'>
								<h3 class='panel-title text-center'>Scouted Players</h3>
							</div>
							<div class="panel-body">
									<div class='row'>
										<div class='col-xs-0'>
										</div>
										<div class='col-xs-4'><b>Name</b>
										</div>
										<div class='col-xs-2'><b>H</b>
										</div>
										<div class='col-xs-2'><b>T</b>
										</div>
										<div class='col-xs-2'><b>R</b>
										</div>
										<div class='col-xs-2'><b>C</b>
										</div>
									</div>
_END;

for ($i = 0; $i < 5; $i++)
{
	echo "<div class='row'>
			<div class='col-xs-0'>
			</div>";
	echo "<div class='col-xs-4'>$playerNames[$i]</div>";
	echo "<div class='col-xs-2'>$playerHittingStats[$i]</div>";
	echo "<div class='col-xs-2'>$playerThrowingStats[$i]</div>";
	echo "<div class='col-xs-2'>$playerRunningStats[$i]</div>";
	echo "<div class='col-xs-2'>$playerCatchingStats[$i]</div>";
	echo "</div>";
}

echo <<< _END
							</div>
						</div>
					</div>
				</div>
	        	<div class="row">
					<div class='col-md-6 col-md-offset-3 col-xs-12'>
						<div class="panel panel-default">
							<div class='panel-heading'>
								<h3 class='panel-title text-center'>Directors Choice</h3>
							</div>
							<div class="panel-body">
								<form method='post' action='choosePlayer.php'>
									<fieldset class="form-group">
										<div class="form-check">
									      <label class="form-check-label">
									        <input type="radio" class="form-check-input" name="random" id="optionsRadios1" value="$serialize1" checked="">
									        $playerNames[$random1]
									      </label>
									    </div>
									    <div class="form-check">
									      <label class="form-check-label">
									        <input type="radio" class="form-check-input" name="random" id="optionsRadios1" value="$serialize2">
									        $playerNames[$random2]
									      </label>
									    </div>
									</fieldset>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6 col-md-offset-3 col-sm-12'>
		        	<div class="panel panel-default">
						<div class="panel-body">
							<button name='replacePlayer' value='$replacePlayer' type='submit' class='btn btn-primary btn-lg btn-block' >Add Player to Team</button>
								</form>
						</div>
					</div>
				</div>
	        </div>
		</div>
	</div>
_END;


