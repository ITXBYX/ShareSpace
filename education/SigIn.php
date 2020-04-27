<?php
	header("Content-type:text/html;charset=utf-8");	
	header("Access-Control-Allow-Origin: *");
	include 'connect.php'; 
	$data=json_decode($_POST['data'],true);
    $result=array("flag"=>"","success"=>"0","message"=>"");
    if(empty($data)){
    	$result["flag"]="101";
       	$result["success"]="0";
       	$result["message"]="data参数不能为空";
    }else{
    	$sql ="insert into  SignIn (";
		$values ="values(";
   		foreach($data as $key => $value){  	
    		$sql.="{$key},";
    		$values.="'{$value}',";   	 
    	}
    	$sql =substr($sql,0,strlen($sql)-1).")";
    	$values =substr($values,0,strlen($values)-1).")";
  		$Sqlcomm = $sql . $values;
  		$cFlag = mysqli_query($conn,$Sqlcomm);
		if($cFlag){
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