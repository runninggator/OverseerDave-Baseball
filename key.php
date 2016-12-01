<?php

require_once 'header.php';
echo "<div class='container'>
		<div class='row'>
	        <div class='col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3'>";
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
		<div class = 'panel panel-default style= "margin: auto">
			<div class='panel panel-default>
				<div class='panel-heading'><strong>Key</strong></div>
					<div class='panel-body'>
						<div>Statistics:</div>
						<div style="margin-left: 2em;">
							<body><t>H = Hitting</t></body>
							<div>	C = Catching</div>
							<div>	T = Throwing</div>
							<div>	R = Running</div>
							<div>	S = Stamina</div>
						</div>
						<br></br>
						<div>Ranks:</div>
						<div style="margin-left: 2em;">
							<div>	Exp 0-99 	= Tee Ball</div>
							<div>	Exp 100-199 = Little League</div>
							<div>	Exp 200-299 = High School</div>
							<div>	Exp 300-399 = Junior College</div>
							<div>	Exp 400-499 = Ivy League</div>
							<div>	Exp 500-599 = Rookie</div>
							<div>	Exp 600-699 = Division A</div>
							<div>	Exp 700-799 = Division AA</div>
							<div>	Exp 800-899 = Division AAA</div>
							<div>	Exp 900-999 = Semi-Pro</div>
							<div>	Exp 1000-1499 = Pro</div>
							<div>	Exp 1500-1999 = Overseer</div>
							<div>	Exp 2000+ = DAVE!</div>
						</div>
					</div>
				</div>
			</div>
		</div>
_END;

?>