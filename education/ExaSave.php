<?php
	header("Content-type:text/html;charset=utf-8");	
	header("Access-Control-Allow-Origin: *");
	include 'connect.php'; 
    $data=json_decode($_POST['data']); 
	$result=array("flag"=>"","success"=>"false","message"=>"");
	$UUID = md5(uniqid());
	$UUIDT = md5(uniqid());
    if(empty($data)){
    	$result["flag"]="101";
       	$result["success"]="false";
       	$result["message"]="参数不能为空";
    }else{
		$dataPaper = $data->paper;
		$dataPaper->PId =$UUID;
		$sql ="insert into ExaPaper (";
    	$values ="values(";
   		foreach($dataPaper as $key => $value){  	
    		$sql.="{$key},";
    		$values.="'{$value}',";   	 
    	}
    	$sql =substr($sql,0,strlen($sql)-1).")";
    	$values =substr($values,0,strlen($values)-1).")";
		$SqlcommPaper = $sql.$values;
	
		$pFlag = mysqli_query($conn,$SqlcommPaper);
		$dataTitle = $data->title;
    	$sqlTitle ="insert into ExaTitle (";
		$valuesTitle ="values";
		$l=0;
   		foreach($dataTitle as  $key =>  $value){ 
			$value->PId =$UUID;
   			$valuesV="";	
   			foreach($value as $key2 => $value2){  						
				$valuesV.="'{$value2}',";     	
				if($l<1){
					$sqlTitle.="{$key2},"; 					
				}   			
			} 	
			$l++;
   			$valuesV ="(".substr($valuesV,0,strlen($valuesV)-1).")"; 
 			$valuesTitle.=$valuesV.",";
		}  
		$sqlTitle =substr($sqlTitle,0,strlen($sqlTitle)-1).")";
    	$valuesTitle =substr($valuesTitle,0,strlen($valuesTitle)-1);   	   		
		$SqlcommTitle = $sqlTitle.$valuesTitle;
		$tFlag = mysqli_query($conn,$SqlcommTitle);
		if($pFlag&&$tFlag){
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

   
		// $dataSelect = $data->select;
    	// $sqlSelect ="insert into ExaSelect (";
		// $valuesSelect ="values";
		// $l=0;
   		// foreach($dataSelect as  $key =>  $value){ 
		// 	$value->TId =$UUIDT;
   		// 	$valuesV="";	
   		// 	foreach($value as $key2 => $value2){  						
		// 		$valuesV.="'{$value2}',";     	
		// 		if($l<1){
		// 			$sqlSelect.="{$key2},"; 
		// 		}   			
		// 	} 	
		// 	$l++;
   		// 	$valuesV ="(".substr($valuesV,0,strlen($valuesV)-1).")"; 
 		// 	$valuesSelect.=$valuesV.",";
		// }  
		// $sqlSelect =substr($sqlSelect,0,strlen($sqlSelect)-1).")";
		// $valuesSelect =substr($valuesSelect,0,strlen($valuesSelect)-1);   		
		// $SqlcommSelect = $sqlSelect.$valuesSelect;
		// echo $SqlcommSelect;
		// $sFlag = mysqli_query($conn,$SqlcommSelect);
?>


