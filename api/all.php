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
	
	date_default_timezone_set('Asia/Calcutta');
	$date1=date("Y-m-d");

	$page=0;
	$ipp=20;
	if(isset($_GET['page']))
		$page=$_GET['page'];
	if(isset($_GET['ipp']))	
		$ipp=$_GET['ipp'];

	if($valid){
		$events=array();
		$sql="SELECT e.*, u.username FROM events e LEFT JOIN users u ON e.uid=u.uid WHERE edate>='$date1'"
			." ORDER BY edate ASC LIMIT ".$page*$ipp.", ".($ipp);
		$result=mysqli_query($con, $sql);
		while($row=mysqli_fetch_array($result)){
			$event=array("eid"=> $row['eid'], "uid"=> $row['uid'], "username"=> $row['username'],"ename"=>$row['ename'], 
						"edesc"=>$row['edesc'], "edate"=>$row['edate'], "etime"=>$row['etime'],
						"evenue"=>$row['evenue'], "lat"=>$row['lat'], "lng"=>$row['lng'],
						"pic"=>$row['pic'], "ver"=>$row['ver']);
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