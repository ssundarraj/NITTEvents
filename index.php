<html>
<head></head>
<body>
	<h1>Event management</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){
			echo "Please log in.";
			echo "<META HTTP-EQUIV='refresh' content='1; URL=login.php'>";
		}
		$errormsg="";
	?>
	<a href="logout.php">Logout</a><br />
	<a href="account.php">Account management</a>
	<form method="post" enctype="multipart/form-data" action="login.php">
	    <table>
	    <tbody>
	    <tr><?php echo $errormsg ?></tr>
	    <tr></tr>
		</tbody>
		</table>
	</form>
</body>
</html>