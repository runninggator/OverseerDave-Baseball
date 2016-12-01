<?php

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "overseer_dave";

$conn = new mysqli($server, $user, $pass, $db_name);
if ($conn->connect_error) die($conn->connect_error);

function queryMysql($query)
{
	global $conn;
	$result = $conn->query($query);
	//if (!$result) echo $conn->connect_error;
	return $result;
}

function destroySession()
{
	$_SESSION = array();

	if (session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time()-2592000, '/');

	session_destroy();
}

function sanitizeString($str)
{
	global $conn;
	$str = strip_tags($str);
	$str = htmlentities($str);
	$str = stripslashes($str);
	return $conn->real_escape_string($str);
}

function alertMessage($type, $message)
{
	if ($type == 'danger') $blurb = 'Uh-Oh: ';
	if ($type == 'success') $blurb = 'Success: ';
	if ($type == 'warning') $blurb = 'Heads Up: ';
	////////
	echo 	"<div class='alert alert-$type text-center' role='alert'>
	<strong>$blurb</strong>";
	echo $message;
	echo	"</div>";
}

function position($i)
{
	switch (++$i)
	{
		case 1:
			return "<b>Pitcher</b>";
		case 2:
			return "<b>Catcher</b>";
		case 3:
			return "<b>First Base</b>";
		case 4:
			return "<b>Second Base</b>";
		case 5:
			return "<b>Third Base</b>";
		case 6:
			return "<b>Shortstop</b>";
		case 7:
			return "<b>Left Field</b>";
		case 8:
			return "<b>Center Field</b>";
		case 9:
			return "<b>Right Field</b>";
		default:
			return "Bench";
			
	}
}

function beginTransaction()
{
	global $conn;
	$conn->autocommit(FALSE);
	$conn->begin_transaction();
}

function commitTransaction()
{
	global $conn;
	$conn->commit();
	$conn->autocommit(TRUE);
}

function rollBack()
{
	global $conn;
	$conn->rollback();
	$conn->autocommit(TRUE);
}

function fetchArray($result, $i = 0)
{
	$result->data_seek($i);
	return $result->fetch_array(MYSQLI_ASSOC);
}

function redirect()
{
	if (!isset($_SESSION['username'])) header("Location: index.php");
}

function getUser($username)
{
	$query = "SELECT * FROM person WHERE username = '$username' LIMIT 1";
	$result = queryMysql($query);
	if (!$result) return NULL;
	$row = fetchArray($result);
	$pid = $row['pid'];
	$query = "SELECT * FROM team WHERE pid = '$pid' LIMIT 1";
	$result = queryMysql($query);
	if (!$result) return NULL;
	$row = fetchArray($result);
	$user = new User($username, $row['name']);
	return $user;
}

function fiftyfifty()
{
	$val = rand(0, 1);
	if ($val == 0) return false;
	else return true;
}

function expToPromotion($experience)
{
	$level = floor($experience / 100);
	$level = pLevel($level);
	return $level;
}

function pLevel($pLevel)
{
	switch ($pLevel)
	{
		case 0:
			return "Tee Ball";
		case 1:
			return "Little League";
		case 2:
			return "High School";
		case 3:
			return "Junior College";
		case 4:
			return "Ivy League";
		case 5:
			return "Rookie";
		case 6:
			return "Division A";
		case 7:
			return "Division AA";
		case 8:
			return "Division AAA";
		case 9:
			return "Semi-Pro";
		case 10:
		case 11:
		case 12:
		case 13:
		case 14:
			return "Pro";
		case 15:
		case 16:
		case 17:
		case 18:
		case 19:
			return "Overseer";
		default:
			return "DAVE!";
	}
}





