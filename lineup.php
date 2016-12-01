<?php

require_once 'header.php';

//*************** Get User Information
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
////////////////////////
// Update Lineup Here
$success = NULL;
if (isset($_POST['position']))
{
	//echo "You Changed a Position<br>";
	$position = $_POST['position'];
	$fillArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	$checkArray = array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
	foreach ($position as $changePos)
	{
		//echo "$changePos<br>";
		$string = explode(" ", $changePos);
		$fillArray[$string[0] - 1]++;
	}
	if ($fillArray === $checkArray) $passed = true;
	else $passed = false;
	if ($passed)
	{
		//echo "Updating Lineup<br>";
		beginTransaction();
		$total = $queries = 1;
		foreach ($position as $changePos)
		{
			$string = explode(" ", $changePos);
			$newPos = $string[0];
			$playerID = $string[1];
			$query = "UPDATE player SET position = '$newPos' WHERE plid = '$playerID'";
			$result = queryMysql($query);
			$total++;
			if ($result) $queries++;
			else break;
		}
		if ($total == $queries)
		{
			commitTransaction();
			$success = true;
		} else
		{
			rollBack();
			$success = false;
		}
	}
}


////////////////////////
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
//*************************

$errMsg = NULL;

echo "<form method='post' action='lineup.php'>
		<div class='container'>
			<div class='row'>
	        	<div class='col-xs-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1'>";
if (isset($passed) && $passed == false)
{
	alertMessage('danger', "Make Sure You Chose a Legal Lineup");
}

if (isset($success) && $success == 'true')
{
	alertMessage('success', "Lineup Updated");
} else if (isset($success) && $success == false)
{
	alertMessage('danger', "Error Updating Positions");
}

echo <<< _END
			<div class='col-md-5 col-xs-12'>
	        	<div class="panel panel-default">
					<div class="panel-body">
						<button class="btn btn-primary btn-lg btn-block" type="submit" name='hitting'>Update Lineup</button>
					</div>
				</div>
			</div>
<div class='col-md-7 col-xs-12'>
<style>
body{
	background-image: url("image2.jpg");
	background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: bottom right; 
	background-size: 100% 100%;
}
</style>
		        	<div class="panel panel-default">
						<div class='panel-heading'>
							<h3 class='panel-title text-center'>Team Lineup</h3>
						</div>
						<div class="panel-body">
							<div class='row'>
								<div class='col-xs-4'>
								</div>
								<div class='col-xs-3'><b>Name</b>
								</div>
								<div class='col-xs-1'><b>H</b>
								</div>
								<div class='col-xs-1'><b>T</b>
								</div>
								<div class='col-xs-1'><b>R</b>
								</div>
								<div class='col-xs-1'><b>C</b>
								</div>
							</div>
_END;

for ($i = 0; $i < 15; $i++)
{
	echo <<< _END
		<div class='row'>
			<div class='col-xs-4'>
				<div class="form-group">
				    <select class="form-control" name='position[]'>
_END;

	// Show Positions and the selected position
	// Get position of player 
	$query = "SELECT position FROM player WHERE plid='$playerPLID[$i]'";
	$result = queryMysql($query);
	$pRow = fetchArray($result);
	$pPos = $pRow['position'];
	for ($j = 0; $j < 15; $j++)
	{
		$posName = position($j);
		$posNum = $j + 1;
		$value = $posNum . " " . $playerPLID[$i];
		if ($pPos == $posNum) echo "<option value='$value' selected>$posName</option>";
		else echo "<option value='$value'>$posName</option>";
	}
	
echo <<< _END
				    </select>
				  </div>
			</div>
_END;
	$hitting = round($playerHittingStats[$i], 3);
	$throwing = round($playerThrowingStats[$i], 3);
	$running = round($playerRunningStats[$i], 3);
	$catching = round($playerCatchingStats[$i], 3);
	
	echo "<div class='col-xs-3'>$playerNames[$i]</div>";
	echo "<div class='col-xs-1'>$hitting</div>";
	echo "<div class='col-xs-1'>$throwing</div>";
	echo "<div class='col-xs-1'>$running</div>";
	echo "<div class='col-xs-1'>$catching</div>";
	echo "</div>";
}

echo <<< _END
						</div>
					</div>
				</div>
	        </div>
	    </div>
</div>
</form>
_END;
			