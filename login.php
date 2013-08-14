<html>
<head></head>
<body>
	<h1>Please Login</h1>
	<?php
		session_start();
		if(isset($_POST['username'])&&isset($_POST['password'])){
			$valid=0;
			//validate password
				$valid=1;
			if($valid==1){
				$_SESSION['logged_in']=1;
				//$_SESSION['userid']=$uid
				//redirect to index.php
			}
		}
	?>
	<form method="post" enctype="multipart/form-data" action="login.php">
	    <table>
	    <tbody>
	    <tr><th><label for="username">Username</label></th><td>
	    <input type="text" decsription="Username" name="username" id="username"></td></tr>
	    <tr><th><label for="password">Password</label></th><td><input type="password" id="password" name="password"></td></tr>
	    <tr><th><label for="Login"></label></th><td><button id="Login" name="Login">Login</button></td></tr>
		</tbody>
		</table>
	</form>
</body>
</html>