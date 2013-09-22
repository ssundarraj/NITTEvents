<?php
	require "../includes/dbconfig.ini";
	$valid=0;
	$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
	$query="SELECT * FROM tokens";
	$res=mysqli_query($con, $query);
	while($row=mysqli_fetch_array($res)){
		if($row['token']==$_GET['token'])
			$valid=1;
	}
	
	if($valid){
		date_default_timezone_set('Asia/Calcutta');
		$curdatetime=date("Y-m-d:H:i:s");
		$sql="SELECT * FROM updatetime";
		$result=mysqli_query($con, $sql);
		while($row=mysqli_fetch_array($result)){
			$updatetime=$row['lasttime'];
		}
		$obj=array("status"=>'success', "updatetime"=>$updatetime);
		echo json_encode($obj);
	}
	else{
		$err=array('status'=> 'error', 'errcode'=>'err1');
		echo json_encode($err);
	}
	mysqli_close($con);
?>