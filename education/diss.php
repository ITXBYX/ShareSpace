<?php
	header("Content-type:text/html;charset=utf-8");	
	header("Access-Control-Allow-Origin: *");
	include 'connect.php'; 
	$data=json_decode($_POST['data'],true);
    $result=array("flag"=>"","success"=>"0","context"=>"");
    if(empty($data)){
    	$result["flag"]="101";
       	$result["success"]="0";
       	$result["context"]="data参数不能为空";
    }else{
    	$sql ="insert into  discuss (";
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
			// $sql2= "select * from discuss  where time BETWEEN '".$data["time"]."' AND '".$data["time"]."'"; 
			// $Flag2 =mysqli_query($conn,$sql2);
			// $dataArr = array();
			// while($row = mysqli_fetch_assoc($Flag2)){
			// 	 $dataArr[]=$row; 			
		 	// }
			$result["flag"]="100";
       		$result["success"]="1";
       		$result["context"]="成功";
		}else{
			$result["flag"]="102";
       		$result["success"]="0";
       		$result["context"]="null";
       		
		}
    }
   echo json_encode($result);
?>