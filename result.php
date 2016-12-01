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

// Go through the nine innings
$playerA = (float)55;
$playerB = (float)45;
$total = (float)($playerA + $playerB);
$playerA = $playerA / $total;
$playerB = $playerB / $total;
$playerAScore = array();
$playerBScore = array();

for ($i = 0; $i < 9; $i++)
{
	if ($i % 2)
	{
		// PlayerA turn
		if (fiftyfifty())
		{
			$playerAScore[] = floor ($playerA*rand(0, 8));
		} else $playerAScore[] = 0;
		$playerBScore[] = 0;
	} else 
	{
		// PlayerB turn
		if (fiftyfifty())
		{
			$playerBScore[] = floor ($playerB*rand(0, 8));
		} else $playerBScore[] = 0;
		$playerAScore[] = 0;
	}
}

// Calculate total 
$playerAScore[] = array_sum($playerAScore);
$playerAScore[] = floor(1.5 * $playerAScore[9]) + rand(1, 4);
$playerAScore[] = rand(0, 3);

$playerBScore[] = array_sum($playerBScore);
$playerBScore[] = floor(1.5 * $playerBScore[9]) + rand(1, 4);
$playerBScore[] = rand(0, 3);

// Catch a tie
if ($playerAScore[9] == $playerBScore[9])
{
	$playerAScore[8]++;
	$playerAScore[9]++;
	$playerAScore[10]++;
}

$outcome = "default";
// Determine a winner
if ($playerAScore[9] > $playerBScore[9])
{
	// The user wins
	$exp = 15;
	$mon = 5;
	$outcome = 'success';
	$message = '<b>Result</b>';
	$reward = "<div class='well'>
				<center>
					<h6><i>Victory</i></h6>
					<h4>Experience: <span class='label label-default'>+ $exp</span></h4>
					<h4>Money: <span class='label label-success'>+ $mon" . "k</span></h4>
				</center>
				</div>";
	$levelUp = $user->getExperience() % 100;
	$user->setExperience($user->getExperience() + $exp);
	$user->setMoney($user->getMoney() + $mon);
	$user->setWins($user->getWins() + 1);
	if (($levelUp + $exp) >= 100) { $user->setMoney($user->getMoney() + 150); $leveledUp = true; }
} 
else
{
	// The opponent wins
	$exp = 5;
	$mon = 2;
	$outcome = 'danger';
	$message = '<b>Result</b>';
	$reward = "<div class='well'>
				<center>
					<h6><i>Better Luck Next Time</i></h6>
					<h4>Experience: <span class='label label-default'>+ $exp</span></h4>
					<h4>Money: <span class='label label-success'>+ $mon" . "k</span></h4>
				</center>
				</div>";
	$levelUp = $user->getExperience() % 100;
	$user->setExperience($user->getExperience() + $exp);
	$user->setMoney($user->getMoney() + $mon);
	$user->setLosses($user->getLosses() + 1);
	if (($levelUp + $exp) >= 100) { $user->setMoney($user->getMoney() + 150); $leveledUp = true; }
}

//echo getUser("Mike McMike")->analyzeUser();

echo "<div class='container'>
		<div class='row'>
	        <div class='col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2'>";

if (isset($leveledUp) && $leveledUp == true)
{
	alertMessage('success', "You Leveled Up <span class='label label-success'>+ 150k</span>");
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
					<div class='col-sm-10 col-sm-offset-1 col-xs-12'>
						<div class="panel panel-default">
							<div class='panel-heading'>
								<h3 class='panel-title text-center'>Box Score - <b>$teamname vs. The Computer</b></h3>
							</div>
							<div class="panel-body">
								<table class='table table-bordered table-condensed'>
									<thead>
										<tr>
											<th>Team</th>
											<th>1</th>
											<th>2</th>
											<th>3</th>
											<th>4</th>
											<th>5</th>
											<th>6</th>
											<th>7</th>
											<th>8</th>
											<th>9</th>
											<th>R</th>
											<th>H</th>
											<th>E</th>
										</tr>
									</thead>
									<tbody>
_END;

// Visiting Team Results
echo "<tr>";
echo "<td>The Computer</td>";
for ($i = 0; $i < 12; $i++)
{
	if ($i < 9)
	{
		echo "<td>$playerBScore[$i]</td>";
	}
	else
	{
		echo "<th>$playerBScore[$i]</th>";
	}
}
echo "</tr>";

// Home Team Results
echo "<tr>";
echo "<td><b>$teamname</b></td>";
for ($i = 0; $i < 12; $i++)
{
	if ($i < 9)
	{
		echo "<td>$playerAScore[$i]</td>";
	}
	else 
	{
		echo "<th>$playerAScore[$i]</th>";
	}
}
echo "</tr>";



echo <<< _END

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-4 col-sm-offset-4 col-xs-12'>
						<div class="panel panel-$outcome">
							<div class='panel-heading'>
								<h3 class='panel-title text-center'>$message</h3>
							</div>
							<div class="panel-body">
								$reward
							</div>
						</div>
					</div>
				</div>
	        </div>
		</div>
</div>
_END;
