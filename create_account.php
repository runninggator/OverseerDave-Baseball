<?php

require_once 'header.php';

$username = NULL;
$team_name = NULL;
$password = NULL;
$confim_password = NULL;
$success = NULL;

if (isset($_POST['username'])) $username = trim(sanitizeString($_POST['username']));
if (isset($_POST['team_name'])) $team_name = trim(sanitizeString($_POST['team_name']));
if (isset($_POST['password'])) $password = trim(sanitizeString($_POST['password']));
if (isset($_POST['confirm_password'])) $confirm_password = sanitizeString($_POST['confirm_password']);

if (isset($username) && isset($team_name) && isset($password) && isset($confirm_password) &&
		$username != "" && $team_name != "" && $password != "")
{
	if ($password == $confirm_password)
	{
		//echo "About to create user<br>";
		global $conn;
		$conn->autocommit(FALSE);
		$conn->begin_transaction();
		$query = "INSERT INTO person(pid, username, password, surname, forename, experience, money) 
				VALUES(NULL, '$username', '$password', NULL, NULL, '0', '10')";
		$result = queryMysql($query);
		
		if ($result)
		{
			// Insert into team and players
			echo "About to create team<br>";
			
			$user = new User($username, $team_name);
			
			$conn->commit();
			$success = true;
			$_SESSION['username'] = $username;
			header("Location: home.php");
		}
		else { $conn->rollback(); $success = false; $error = "Username Taken" ; }
	} else $error = "Password Do Not Match";
}

echo "<div class='container'>
		<div class='row'>
	        <div class='col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3'>";

if (isset($error)) alertMessage('danger', $error);

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
				<div class='panel panel-default'>
					<div class='panel-heading'><strong>Create Account</strong></div>
					<div class='panel-body'>
						<form class='form-horizontal' method='post' action='create_account.php'>
							<div class='form-group'>
								<label for='username' class='control-label col-sm-2'>Username</label>
								<div class='col-sm-10'>
									<input type='text' class='form-control' name='username' placeholder='Username' id='username' value='$username'>
								</div>
							</div>
							<div class='form-group'>
								<label for='team_name' class='control-label col-sm-2'>Team Name</label>
								<div class='col-sm-10'>
									<input type='text' class='form-control' name='team_name' placeholder='Team Name' id='team_name' value='$team_name'>
								</div>
							</div>
							<div class='form-group'>
								<label for='password' class='control-label col-sm-2'>Password</label>
								<div class='col-sm-10'>
									<input type='password' class='form-control' name='password' placeholder='Password' id='password'>
								</div>
							</div>
							<div class='form-group'>
								<label for='confirm_password' class='control-label col-sm-2'>Confirm Password</label>
								<div class='col-sm-10'>
									<input type='password' class='form-control' name='confirm_password' placeholder='Confirm Password' id='confirm_password'>
								</div>
							</div>
							<div class='form-group'>
								<div class='col-sm-10 col-sm-offset-2'>
									<button name='create_account' value='' type='submit' class='btn btn-primary'>Create Account</button>
									<a class="btn btn-default" href="index.php" role="button">Back To Login</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

_END;
