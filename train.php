<?php

require_once 'header.php';

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
	global $money;
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
////// BREAK IN THE PLAYER FECTHING TO UPDATE TEAM

$trainPlayers = NULL;
$errMsg = NULL;
$success = NULL;

function enoughMoney($trainPlayers, $money, $price)
{
	$cost = count($trainPlayers)*$price;
	if ($cost > $money) return false;
	else return $cost;
}

function trainStat($stat)
{
	if($stat >= 1)
		return .999;
		if ($stat <= 0)
			return .04;

			$temp = 1 - $stat;
			$temp = $temp*.05;
			return $stat + $temp;
}

function hasStamina($selected)
{
	global $errMsg;
	
	foreach($selected as $player)
	{
		$query = "SELECT stamina FROM player WHERE plid ='$player'";
		$result = queryMysql($query);
		$row = fetchArray($result);
		if ($row['stamina'] <= 0) { $errMsg = "A Selected Player Does Not Have Enough Stamina"; return false; }
	}
	
	return true;
}

if (isset($_POST['selected']) && hasStamina($_POST['selected']))
{
	$trainPlayers = $_POST['selected'];
	// 	foreach ($trainPlayers as $trainPLID)
	// 	{
	// 		echo "Train PLID: $trainPLID<br>";
	// 	}

	if (isset($_POST['hitting']))
	{
		//echo "You trained hitting<br>";
		if ($count = enoughMoney($trainPlayers, $money, 1))
		{
			// Train team
			switch($total = $queries = 1)
			{
				case 1:
					beginTransaction();
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "SELECT * FROM player WHERE plid = '$trainPLID' LIMIT 1";
						$result = queryMysql($query);
						$total++;
						if ($result) { $tRow = fetchArray($result); $queries++; }
						else break;
						$newValue = trainStat($tRow['hitting']);
						$query = "UPDATE player SET hitting = '$newValue' WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 2:
					// Update Players Stamina
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "UPDATE player SET stamina = stamina - 1 WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 3:
					// Update Money
					$query = "UPDATE person SET money = money - $count WHERE username='$username'";
					$result = queryMysql($query);
					$total++;
					if ($result) $queries++;
					else break;
				default:
					if ($total == $queries) { commitTransaction(); $success = true; }
					else { rollBack(); $errMsg = "Could Not Train Players"; }

			}
		} else
		{
			// Tell user that they don't have enough money
			$errMsg = "This Training Requires More Money";
		}
	}
	if (isset($_POST['throwing']))
	{
		//echo "You trained throwing<br>";
		//echo "You trained hitting<br>";
		if ($count = enoughMoney($trainPlayers, $money, 1))
		{
			// Train team
			switch($total = $queries = 1)
			{
				case 1:
					beginTransaction();
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "SELECT * FROM player WHERE plid = '$trainPLID' LIMIT 1";
						$result = queryMysql($query);
						$total++;
						if ($result) { $tRow = fetchArray($result); $queries++; }
						else break;
						$newValue = trainStat($tRow['throwing']);
						$query = "UPDATE player SET throwing = '$newValue' WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 2:
					// Update Players Stamina
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "UPDATE player SET stamina = stamina - 1 WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 3:
					// Update Money
					$query = "UPDATE person SET money = money - $count WHERE username='$username'";
					$result = queryMysql($query);
					$total++;
					if ($result) $queries++;
					else break;
				default:
					if ($total == $queries) { commitTransaction(); $success = true; }
					else { rollBack(); $errMsg = "Could Not Train Players"; }
		
			}
		} else
		{
			// Tell user that they don't have enough money
			$errMsg = "This Training Requires More Money";
		}
	}
	if (isset($_POST['running']))
	{
		//echo "You trained running<br>";
		//echo "You trained hitting<br>";
		if ($count = enoughMoney($trainPlayers, $money, 2))
		{
			// Train team
			switch($total = $queries = 1)
			{
				case 1:
					beginTransaction();
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "SELECT * FROM player WHERE plid = '$trainPLID' LIMIT 1";
						$result = queryMysql($query);
						$total++;
						if ($result) { $tRow = fetchArray($result); $queries++; }
						else break;
						if ($tRow['stamina'] < 2) { $total++; break;}
						$newValue = trainStat($tRow['running']);
						$query = "UPDATE player SET running = '$newValue' WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 2:
					// Update Players Stamina
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "UPDATE player SET stamina = stamina - 2 WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 3:
					// Update Money
					$query = "UPDATE person SET money = money - $count WHERE username='$username'";
					$result = queryMysql($query);
					$total++;
					if ($result) $queries++;
					else break;
				default:
					if ($total == $queries) { commitTransaction(); $success = true; }
					else { rollBack(); $errMsg = "A Selected Player Does Not Have Enough Stamina"; }
		
			}
		} else
		{
			// Tell user that they don't have enough money
			$errMsg = "This Training Requires More Money";
		}
	}
	if (isset($_POST['catching']))
	{
		//echo "You trained catching<br>";
		//echo "You trained hitting<br>";
		if ($count = enoughMoney($trainPlayers, $money, 2))
		{
			// Train team
			switch($total = $queries = 1)
			{
				case 1:
					beginTransaction();
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "SELECT * FROM player WHERE plid = '$trainPLID' LIMIT 1";
						$result = queryMysql($query);
						$total++;
						if ($result) { $tRow = fetchArray($result); $queries++; }
						else break;
						if ($tRow['stamina'] < 2) { $total++; break;}
						$newValue = trainStat($tRow['catching']);
						$query = "UPDATE player SET catching = '$newValue' WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 2:
					// Update Players Stamina
					foreach ($trainPlayers as $trainPLID)
					{
						$query = "UPDATE player SET stamina = stamina - 2 WHERE plid = '$trainPLID'";
						$result = queryMysql($query);
						$total++;
						if ($result) $queries++;
						else break;
					}
				case 3:
					// Update Money
					$query = "UPDATE person SET money = money - $count WHERE username='$username'";
					$result = queryMysql($query);
					$total++;
					if ($result) $queries++;
					else break;
				default:
					if ($total == $queries) { commitTransaction(); $success = true; }
					else { rollBack(); $errMsg = "A Selected Player Does Not Have Enough Stamina"; }
		
			}
		} else
		{
			// Tell user that they don't have enough money
			$errMsg = "This Training Requires More Money";
		}
	}
}

///// END OF BREAK
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

$displayMoney = "$" . $user->getMoney() . "k";

echo "<form method='post' action='train.php'>
		<div class='container'>
			<div class='row'>
	        	<div class='col-xs-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1'>";
if (isset($errMsg))
{
	alertMessage('danger', $errMsg);
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
				<div class='col-md-5 col-xs-12'>
		        	<div class="panel panel-default">
						<div class="panel-body">
							<div class="well well-sm">
								<h4 class='text-center'>Money <span class="label label-success">$displayMoney</span></h4>
							</div>
							<button class="btn btn-primary btn-lg btn-block" type="submit" name='hitting'>Train Hitting <span class="label label-default">Costs 1k and 1 Stamina</span></button><br>
							<button class="btn btn-primary btn-lg btn-block" type="submit" name='throwing'>Train Throwing <span class="label label-default">Costs 1k and 1 Stamina</span></button><br>
							<button class="btn btn-primary btn-lg btn-block" type="submit" name='running'>Train Running <span class="label label-default">Costs 2k and 2 Stamina</span></button><br>
							<button class="btn btn-primary btn-lg btn-block" type="submit" name='catching'>Train Catching <span class="label label-default">Costs 2k and 2 Stamina</span></button>
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
					<input class='form-check-input' type='checkbox' value='$playerPLID[$i]' name='selected[]'>
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
</div>
</form>
_END;
