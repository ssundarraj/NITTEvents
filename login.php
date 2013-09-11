<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<title>

NITT Events - Login
</title>
<link href="./css/loginstyles.css" media="screen" rel="stylesheet" type="text/css" />
<script src="./js/loginscript.js" type="text/javascript"></script>
</head>
<?php
		session_start();
		require "dbconfig.ini";
		$errormsg=' ';
		if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==1){//Checking if already logged in
			echo "Already logged in";
			header('Location:  index.php');
			exit();
		}
		else{
			if(isset($_POST['username'])&&isset($_POST['password'])){//checking credentials
				$valid=0;
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$sql="SELECT * FROM users";
				$result=mysqli_query($con, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['username']==$_POST['username']){
						if($row['password']==md5($_POST['password'])){
							$valid=1;
							$uid=$row['uid'];
						}
					}

				}
				mysqli_close();
				if($valid==1){
					$_SESSION['logged_in']=1;
					$_SESSION['userid']=$uid;
					echo "Valid credentials";
					header('Location:  index.php');
					exit();	
				}
				else{
					$errormsg="Please enter valid login parameters";
				}
			}
		}
	?>
<body class='ui_basic login-page'>
<div class='flash-container'>

</div>

<div class='container'>
<div class='content'>
<center>
<h1 style='color:#E6E6E6'>NITT Events</h1>
</center>
<div class='login-box'>
<h3 class='page-title'>Sign in</h3>
<form accept-charset="UTF-8" action="login.php" class="new_user" id="new_user" method="post">
	<div style="margin:0;padding:0;display:inline">
		<input autofocus="autofocus" class="text top" id="user_login" decsription="Username" name="username" id="username" placeholder="Username" size="30" type="text" />
		<input class="text bottom" id="password" name="password" placeholder="Password" size="30" type="password" />
	<div class='clearfix append-bottom-10'></div>
	<div>
	<input class="btn-create btn" name="commit" type="submit" value="Sign in" />
	</div>
</form>

</div>

</div>
</div>
</body>
</html>