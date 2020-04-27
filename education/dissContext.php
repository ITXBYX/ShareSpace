<?php
	header("Content-type:text/html;charset=utf-8");	
	header("Access-Control-Allow-Origin: *");
	include 'connect.php'; 
    $VId = $_POST['VId'];
	$result=array("flag"=>"","success"=>"0","context"=>"");
	date_default_timezone_set('prc');
	$CurrentDate=date('y-m-d h:i:s',time());
    $sql= "select * from discuss  where vedioId ='".$VId."'  AND  time BETWEEN '".$CurrentDate."' AND '".$CurrentDate."'";      	
    $dataArr = array();
        while($row = mysqli_fetch_assoc(mysqli_query($conn,$sql))){
        $dataArr[]=$row; 			
    }
	$result["flag"]="100";
    $result["success"]="1";
    $result["context"]=$dataArr;
   echo json_encode($result);
?>