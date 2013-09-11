<html>
<head>
	<title>NITT Events - Event Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" media='screen'>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      img, td{
      	height: 60px;
      }
    </style>

</head>
<body>
	  <div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
		<div class="container">
		  <a class="brand" href="#">NITT Events</a>
		  <div class="nav-collapse collapse">
			<ul class="nav">
			  <li><a href="./includes/logout.php">Logout</a></li>
			  <li><a href="index.php?action=manage">Manage Account</a></li>
			</ul>
		  </div><!--/.nav-collapse -->
		</div>
	  </div>
	</div>
	<div class="container">
		<h1>Event Management</h1>
		<a href="index.php?action=add">Add event</a>
		<?php
			session_start();
			require "dbconfig.ini";
			if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){//checking if logged in
				echo "Please log in.";
				header('Location:  login.php');
				exit();
			}
			else{
				$errormsg="";
				if(isset($_POST['action'])){//checking if form has been submitted
					if(!isset($_POST['event'])){
						$errormsg='Please select a valid option.';
					}
					else{
						$_SESSION['eid']=$_POST['event'];
						if($_POST['action']=='Modify')
							header('Location:  index.php?action=modify');
						else if($_POST['action']='Delete')
							header('Location:  index.php?action=delete');
						exit();	
					}
				}
			}
		?>
		
		
		<form method="post" enctype="multipart/form-data" action="index.php">
		<table border="2" class='table table-bordered'>
		<tbody>
			<th></th><th>Name</th><th>Description</th><th width='80px';>Image</th><th>Time</th><th>Venue</th><th>Location</th>
			<tr><?php echo $errormsg ?></tr>
			<tr>
			<?php
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$sql="SELECT * FROM events WHERE UID=$_SESSION[userid] ORDER BY eid DESC";
				$result=mysqli_query($con, $sql);
				$counter=0; $linebreak=2;
				//Displaying events in a table:
				while($row=mysqli_fetch_array($result)){
					if($row['pic']!=NULL)
						$imghtml="<img src='".$row['pic']."' height=60px/>";
					else $imghtml="No image";
					echo "</tr><tr>";
					echo "<td><input type='radio' name='event' value='".$row['eid']
						."'></td><td>".$row['ename']."</td><td>".$row['edesc']."</td><td>"
						.$imghtml."</td><td>"
						.$row['etime']."</td><td>".$row['evenue']."</td><td>".$row['lat'].", ".$row['lng']."</td>";
					$counter++;
				}
				mysqli_close($con);
			?>
			</tr>
		</tbody>
		</table>
			<input class="btn btn-inverse" type='submit' id="Modify" name="action" value='Modify'/>
			<input class="btn btn-inverse" type='submit' id="Delete" name="action" value='Delete'/>
		</form>
		
	</div>
	<div id="footer">
	  <div class="container">
		<p class="muted credit">Created by Delta <a href="index.php?action=terms">Terms of use</a></p>
	  </div>
	 </div>
</body>
</html>