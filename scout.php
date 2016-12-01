<?php

require_once 'header.php';
require_once 'player.php';

// This commented out code was used to check
// that form inputs are working

//**************** GET USER INFORMATION
$money = NULL;
$pid = NULL;
$tid = NULL;
$team = array();
$teamNames = array();
$username = $_SESSION['username'];
$playerNames = array();
$playerHittingStats = array();
$playerThrowingStats = array();
$playerRunningStats = array();
$playerCatchingStats = array();
$playerStamina = array();
$playerPLID = array();

$query = "SELECT * FROM person WHERE username='$username'";
$result = queryMysql($query);
if ($result->num_rows == 1)
{
	$result->data_seek(0);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$money = $row['money'];
	$pid = $row['pid'];
	$query = "SELECT * FROM team WHERE pid='$pid'";
	$result = queryMysql($query);
	$result->data_seek(0);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$teamname = $row['name'];
}
/////////////////////////
// Update Team Here if User Purchased new Team
$newTeamSuccess = NULL;
if (isset($_POST['newTeam']))
{
	if ($money >= 150)
	{
		// Create a new team
		echo "Making a New Team<br>";
	} else 
	{
		$newTeamSuccess = false;
		$message = "You Don't Have Enough Money to Purchase a New Team";
	}
}

/////////////////////////
$user = new User($username, $teamname);
$team = $user->team;
for($i = 0; $i < 15; $i++)
{
	$playerNames[$i] = $team[$i]->getFirstName() . " " . $team[$i]->getLastName();
	$playerHittingStats[$i] = $team[$i]->getHitting();
	$playerThrowingStats[$i] = $team[$i]->getThrowing();
	$playerRunningStats[$i] = $team[$i]->getRunning();
	$playerCatchingStats[$i] = $team[$i]->getCatching();
	$playerStamina[$i] = $team[$i]->getStamina();
	$playerPLID[$i] = $team[$i]->getPLID();
}
//*******************************

if (isset($_POST['replace']))
{
	echo "You chose to replace this player<br>";
	
}

echo "<form method='post' action='choosePlayer.php'>
		<div class='container'>
			<div class='row'>
	        	<div class='col-xs-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1'>";

if (isset($_POST['success'])) { $pName = $_POST['success']; alertMessage('success', "You Chose $pName"); }
if (isset($_SESSION['newteam_error'])) { alertMessage('danger', $_SESSION['newteam_error']); unset($_SESSION['newteam_error']); }
if (isset($_SESSION['newteam_success'])) { alertMessage('success', $_SESSION['newteam_success']); unset($_SESSION['newteam_success']); }

if (isset($newTeamSuccess))
{
	if ($newTeamSuccess == true) alertMessage('success', "You Purchased a New Team");
	else alertMessage('warning', $message);
}
if ($money < 10)
{
	alertMessage('warning', "You Need Atleast $10k to Replace a Player");
}

$displayMoney = "$" . $user->getMoney() . "k";
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
					<div class='col-md-5 col-xs-12'>
			        	<div class="panel panel-default">
							<div class="panel-body">
								<div class="well well-sm">
									<h4 class='text-center'>Money <span class="label label-success">$displayMoney</span></h4>
								</div>
								<button name='submit' value='' type='submit' class='btn btn-primary btn-lg btn-block' >Replace Player <span class="label label-default">Costs 10k</span></button>
								<a class="btn btn-primary btn-lg btn-block" href="newteam.php" role="button">Purchase New Team <span class="label label-default">Costs 150k</span></a>
							</div>
						</div>
					</div>
					<div class='col-md-7 col-xs-12'>
						<div class="panel panel-default">
							<div class='panel-heading'>
								<h3 class='panel-title text-center'>Team Lineup</h3>
							</div>
						<div class="panel-body">
							<div class='row'>
								<div class='col-xs-1'>
								</div>
								<div class='col-xs-4'><b>Name</b>
								</div>
								<div class='col-xs-1'><b>H</b>
								</div>
								<div class='col-xs-1'><b>T</b>
								</div>
								<div class='col-xs-1'><b>R</b>
								</div>
								<div class='col-xs-2'><b>C</b>
								</div>
								<div class='col-xs-2'><b>Stamina</b>
								</div>
							</div>
_END;

for ($i = 0; $i < 15; $i++)
{
	echo <<< _END
							<div class='row'>
								<div class='col-xs-1'>
									<div class='form-check'>
										<input class='form-check-input' type='radio' name='replacePlayer' value='$playerPLID[$i]'>
									</div>
								</div>
_END;
	$hitting = round($playerHittingStats[$i], 3);
	$throwing = round($playerThrowingStats[$i], 3);
	$running = round($playerRunningStats[$i], 3);
	$catching = round($playerCatchingStats[$i], 3);
	
	echo "<div class='col-xs-4'>$playerNames[$i]</div>";
	echo "<div class='col-xs-1'>$hitting</div>";
	echo "<div class='col-xs-1'>$throwing</div>";
	echo "<div class='col-xs-1'>$running</div>";
	echo "<div class='col-xs-2'>$catching</div>";
	echo "<div class='col-xs-2'>$playerStamina[$i]</div>";
	echo "</div>";
}

echo <<< _END

						</div>
					</div>
				</div>
	        </div>
		</div>
</form>
_END;
