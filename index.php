<?php

require_once 'header.php';

$username = NULL;
$password = NULL;

if (isset($_POST['username'])) $username = trim(sanitizeString($_POST['username']));
if (isset($_POST['password'])) $password = trim(sanitizeString($_POST['password']));

// Login
if (isset($username) && isset($password) && $username != "" && $password != "")
{
	$query = "SELECT * FROM person WHERE username='$username' AND password='$password'";
	$result = queryMysql($query);
	
	if ($result->num_rows == 1)
	{
		$row = fetchArray($result);
		$_SESSION['username'] = $row['username'];
		header('Location: home.php');
	} else $error = "Invalid Username/Password Combination";
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
			<div class = 'panel panel-default>
				<div class='panel panel-default>
					<div class='panel-heading'><strong>Log In</strong></div>
					<div class='panel-body'>
						<form class='form-horizontal' method='post' action='index.php'>
							<div class='form-group'>
								<label for='username' class='control-label col-sm-2'>Username</label>
								<div class='col-sm-10'>
									<input type='text' class='form-control' name='username' placeholder='Username' id='username' value='$username'>
								</div>
							</div>
							<div class='form-group'>
								<label for='password' class='control-label col-sm-2'>Password</label>
								<div class='col-sm-10'>
									<input type='password' class='form-control' name='password' placeholder='Password' id='password'>
								</div>
							</div>
							<div class='form-group'>
								<div class='col-sm-10 col-sm-offset-2'>
									<button name='login' value='' type='submit' class='btn btn-primary'>Log In</button>
									<a class="btn btn-default" href="create_account.php" role="button">Create Account</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
_END;
