<?php
	require "../dbconfig.ini";
	$valid=0;
	$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
	$query="SELECT * FROM tokens";
	$res=mysqli_query($con, $query);
	while($row=mysqli_fetch_array($res)){
		if($row['token']==$_GET['token'])
			$valid=1;
	}
	if($valid){
		$events=array();
		$sql="SELECT * FROM events ORDER BY eid DESC";
		$result=mysqli_query($con, $sql);
		while($row=mysqli_fetch_array($result)){
			$event=array("eid"=> $row['eid'], "uid"=> $row['uid'],"ename"=>$row['ename'], 
						"edesc"=>$row['edesc'], "edate"=>$row['edate'], "etime"=>$row['etime'],
						"evenue"=>$row['evenue'], "lat"=>$row['lat'], "lng"=>$row['lng'],
						"pic"=>$row['pic']);
			array_push($events, $event);
		}
		$obj=array("status"=>'success', "data"=>$events);
		echo json_encode($obj);
	}
	else{
		$err=array('status'=> 'error', 'errcode'=>'err1');
		echo json_encode($err);
	}
	mysqli_close($con);
?>