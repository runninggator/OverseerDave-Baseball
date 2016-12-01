<?php

require_once 'header.php';
redirect();

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
$experience = $user->getExperience();
$progress = $experience % 100;
$level = floor($experience / 100);
$level = pLevel($level);

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
<form method='post' action='pvp.php'>
	<div class='container'>
		<div class="row">
	        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
				<div class='col-md-6'>
		        	<div class="panel panel-default">
						<div class="panel-body">
							<div class="well well-sm">
								<h4 class='text-center'>Experience <span class="label label-default">$experience</span></h4>
							</div>
							<h4 class='text-center'>Promotion Level: <b>$level</b></h4>
							<div class="progress">
							  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="$progress" aria-valuemin="0" aria-valuemax="100" style="width: $progress%">
							    <span class="sr-only">$progress% Complete</span>
							  </div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6' col-xs-12>
		        	<div class="panel panel-default">
						<div class='panel-heading'>
							<h3 class='panel-title text-center'>Online Opponents</h3>
						</div>
						<div class="panel-body">
							<table class='table table-hover table-condensed'>
								<thead>
									<tr>
										<th>
											Teamname
										</th>
										<th>
											Username
										</th>
										<th>
											Level
										</th>
									</tr>
								</thead>
								<tbody>
_END;

//$query = "SELECT * FROM person WHERE experience < '$experience + 200' LIMIT 10";
$query = "SELECT * FROM person WHERE username != '$username' ORDER BY experience DESC LIMIT 10";
$result = queryMysql($query);
$num_rows = 0;
if ($result) $num_rows = $result->num_rows;
for ($i = 0; $i < $num_rows; $i++)
{
	$row = fetchArray($result, $i);
	$tempUser = getUser($row['username']);
	$number = $i + 1;
	$position = position($i);
	$button = "<button class='btn btn-default btn-md' type='submit' name='opponent' value='" . $tempUser->getUsername() . "'>" . $tempUser->getTeamname() . "</button>";
	echo 	"<tr>";
	echo		"<th>" . $button . "</th>";
	echo		"<td>" . $tempUser->getUsername() . "</td>";
	echo 		"<td><b>" . expToPromotion($tempUser->getExperience()) . "</b></td>";
	echo	"</tr>";
}

echo <<< _END
								</tbody>
							</table>
						</div>
					</div>
				</div>
	        </div>
	    </div>
	</div>
</form>
_END;
							    		