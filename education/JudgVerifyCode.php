<?php
	header("Content-type: text/html; charset=utf-8");
	header("Access-Control-Allow-Origin: *");
	include 'connect.php';  
	$phone =$_POST['phone'];
    $validCode=$_POST['validCode'];  
  	
	
//	$phone ="15521003841";
//  $validCode="1343";  
    $phoneFlag = preg_match_all("/^13[0-9]{1}[0-9]{8}$|15[013589]{1}[0-9]{8}$|17[013589]{1}[0-9]{8}$|189[0-9]{8}$/",$phone,$tempPhone);  
	$result=array("flag"=>"","success"=>"false","message"=>"");
	if($phoneFlag){
		$sql= "select * from VerificationCode where Phone ='".$phone."' AND VerCode = '".$validCode."'";      	
       
        $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        if($row){ 
        	$one = strtotime($row["UpdateTime"]);
			$tow = strtotime(date('Y-m-d H:i:s', time()));
			$cle = $tow - $one; //得出时间戳差值
	//		$d = ceil($cle/3600/24);
	//		$h = ceil(($cle%(3600*24))/3600);
			$m = ceil(($cle%(3600*24))/60);		
       		$tFlag = (int)$m > 10 ?true:false;
            if($tFlag){
            	$result["flag"]="103";
       			$result["success"]="false";
       			$result["message"]="验证码已过期";
            }else{
            	$result["flag"]="100";
       			$result["success"]="true";
       			$result["message"]="成功";
            }                     	
        }else{
        	$result["flag"]="101";
       		$result["success"]="false";
       		$result["message"]="手机号码或验证码有误";
        }
	}else{
		$result["flag"]="300";
       	$result["success"]="false";
       	$result["message"]="手机号码或密码格式不正确";
	}
	echo json_encode($result);
?>