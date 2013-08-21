<?php
	require "../dbconfig.ini";
	$valid=0;
	$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
	$query="SELECT * FROM tokens";
	$res=mysqli_query($con, $query);
	while($row=mysqli_fetch_array($res)){
		if($row['token']==$_POST['token'])
			$valid=1;
	}
	if($valid){
		$events=array();
		$sql="SELECT * FROM events ORDER BY eid DESC";
		$result=mysqli_query($con, $sql);
		while($row=mysqli_fetch_array($result)){
			$event=array("eid"=> $row['eid'], "uid"=> $row['uid'],"ename"=>$row['ename'], 
						"edesc"=>$row['edesc'], "edate"=>$row['edate'], "etime"=>$row['etime'],
						"lat"=>$row['lat'], "lng"=>$row['lng']);
			array_push($events, $event);
		}
		echo json_encode($events);
	}
	else{
		echo json_encode("err1");
	}
	mysql_close($con);
?>