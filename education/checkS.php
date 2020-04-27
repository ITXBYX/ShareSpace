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
		$sqlQuery ="select * from ExaTitle where TYPE ='S' AND PId='".$data->PId."'";
		$qFlag =mysqli_query($conn,$sqlQuery);
		$dataArr = array();
		if($qFlag){
            while($row = mysqli_fetch_assoc($qFlag)){
				$tempArr["Answer"] =$row["Answer"];
				$tempArr["Scope"] =$row["Scope"];
				$dataArr[$row["Title"]]=$tempArr; 
							
            }			
		}
		$answerArr =array();
		$dataAnswer = $data->Answer;
		foreach($dataAnswer as $answerObj){
			foreach($answerObj as $key => $value){
				$answerArr[$key] =$value;
			}
			
		}
		$scope=0;
		foreach($answerArr as $keyA => $valueA){
			if($answerArr[$keyA] ==$dataArr[$keyA]["Answer"]){
				$scope+=($dataArr[$keyA]["Scope"]);
			}
		}
		$sqlScope ="insert into  Score(PId,UserId,Scores) values('".$data->PId."','".$data->UserId."','".$scope."')";
		echo $sqlScope;
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