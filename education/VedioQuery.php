<?php
    header("Content-type:text/html;charset=utf-8");	
    header("Access-Control-Allow-Origin: *");
    include 'connect.php'; 
    $CId = $_POST['CId'];
    $result=array("flag"=>"","success"=>"0","context"=>"");
    if(empty($CId)){
    	$result["flag"]="101";
       	$result["success"]="0";
       	$result["context"]="data参数不能为空";
    }else{
    	$sql= "select * from CourseVedio where CId ='".$CId."'";      	
        $cFlag =mysqli_query($conn,$sql);
		if($cFlag){
            $dataArr = array();
            while($row = mysqli_fetch_assoc($cFlag)){
                $dataArr[]=$row; 			
            }
			$result["flag"]="100";
       		$result["success"]="1";
       		$result["context"]=$dataArr;
		}else{
			$result["flag"]="101";
       		$result["success"]="0";
       		$result["context"]="null";
       		
		}
    }
   echo json_encode($result);
?>