<?php
	header("Content-type:text/html;charset=utf-8");	
	header("Access-Control-Allow-Origin: *");
	include 'connect.php'; 
	$data=json_decode($_POST['data']);
    $result=array("flag"=>"","success"=>"0","message"=>"");
    if(empty($data)){
    	$result["flag"]="101";
       	$result["success"]="0";
       	$result["message"]="data参数不能为空";
    }else{
		$scope=0;
		$sqlQuery ="select * from Score where UserId ='".$data->UserId."' AND PId='".$data->PId."'";
		$qFlag =mysqli_query($conn,$sqlQuery);
		if($qFlag){
            while($row = mysqli_fetch_assoc($qFlag)){
				$scope = $row["Scores"];		
            }			
		}
		$dataScores = $data->Scores;
		foreach($dataScores as $keyA => $valueA){
			$scope+=$valueA;
		}
		$sqlScope ="update Score set Scores = '".$scope."' where UserId ='".$data->UserId."' AND PId='".$data->PId."'";
  		$sFlag = mysqli_query($conn,$sqlScope);
		if($sFlag){
			$result["flag"]="100";
       		$result["success"]="1";
       		$result["message"]="成功";
		}else{
			$result["flag"]="101";
       		$result["success"]="0";
       		$result["message"]="失败";
		}
    }
   echo json_encode($result);
?>