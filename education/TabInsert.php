<?php
	header("Content-type:text/html;charset=utf-8");	
	include 'connect.php'; 
	$tab =$_POST['tab'];
    $data=$_POST['data']; 
    $result=array("flag"=>"","success"=>"false","message"=>"");
    if(empty($tab)){
    	$result["flag"]="101";
       	$result["success"]="false";
       	$result["message"]="参数不能为空";
    }else{
    	$sql ="insert into $tab (";
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
       		$result["success"]="true";
       		$result["message"]="成功";
		}else{
			$result["flag"]="101";
       		$result["success"]="false";
       		$result["message"]="失败";
       		
		}
    }
   echo json_encode($result);
?>