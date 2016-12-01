<?php

session_start();

require_once 'functions.php';
require_once 'User.php';

function loggedIn ()
{
	if (isset($_SESSION['username'])) return true;
	else return false;
}

$navButtons = '';

if (loggedIn())
{
	$userName = $_SESSION['username'];
	$navButtons = 
		"<p><center>
		<a href='home.php' class='btn btn-default' role='button'><span class='glyphicon glyphicon-home' aria-hidden='true'></span> Home</a>
		<a href='logout.php' class='btn btn-default' role='button'><span class='glyphicon glyphicon-off' aria-hidden='true'></span> Logout</a>
		<a href='key.php' class='btn btn-default' role='button'>Key</a>
		</center>
		<p><center>Welcome <i><b>$userName</b></i></center>";
}

echo <<< _END
	<!DOCTYPE html><html lang='en'>
	<head>
		<title>OverseerDave: Baseball</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	</head>

	<body>
	
	<div class= "panel panel-default">
		<div class="panel panel-header">
		  <h1 class='text-center'>OverseerDave: Baseball <small></small></h1>
		  $navButtons
		</div>
		</div>
	</body>
_END;

