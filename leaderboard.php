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
<div class='container'>
		<div class="row">
	        <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
	        	<div class="panel panel-default">
					<div class='panel-heading'>
						<h3 class='panel-title text-center'>Leaderboard</h3>
					</div>
					<div class="panel-body">
						<table class='table table-hover table-condensed'>
								<thead>
									<tr>
										<th>Username
										</th>
										<th>Team
										</th>
										<th>Level
										</th>
										<th>Experience
										</th>
										<th>W-L
										</th>
										<th>Ratio
										</th>
									</tr>
								</thead>
								<tbody>
_END;

$query = "SELECT * FROM person ORDER BY experience DESC LIMIT 20";
$result = queryMysql($query);
$num_rows = $result->num_rows;
for ($i = 0; $i < $num_rows; $i++)
{
	$row = fetchArray($result, $i);
	$personID = $row['pid'];
	$query = "SELECT name FROM team WHERE pid = '$personID'";
	$tResult = queryMysql($query);
	$tRow = fetchArray($tResult);
	if ($row['wins'] == 0 || $row['losses'] == 0) $ratio = "N/A";
	else { $ratio = $row['wins'] / $row['losses']; $ratio = round($ratio, 3); }
	
	echo "<tr>";
	echo "<td>" . $row['username'] . "</td>";
	echo "<td>" . $tRow['name'] . "</td>";
	echo "<td>" . expToPromotion($row['experience']) . "</td>";
	echo "<td>" . $row['experience'] . "</td>";
	echo "<td>" . $row['wins'] . "-" . $row['losses'].  "</td>";
	echo "<td>" . $ratio . "</td>";
	echo "</tr>";
}

echo <<< _END
								</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
</div>
_END;
	        
	        
	        
	        