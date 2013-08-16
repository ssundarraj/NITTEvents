<?php
	require "../dbconfig.ini";
	$events=array();
	$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
	$sql="SELECT * FROM events ORDER BY eid DESC";
	$result=mysqli_query($con, $sql);
	while($row=mysqli_fetch_array($result)){
		$event=array("eid"=> $row['eid'], "uid"=> $row['uid'],"ename"=>$row['ename'], 
					"edesc"=>$row['edesc'], "edate"=>$row['edate'], "etime"=>$row['etime'],
					"evenue"=>$row['evenue']);
		array_push($events, $event);
	}
	echo json_encode($events);
	mysql_close($con);
?>