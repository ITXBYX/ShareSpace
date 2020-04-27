<?php
 	header("Content-type: text/html; charset=utf-8");	
	header("Access-Control-Allow-Origin: *");
    include 'connect.php';      
    $phone =$_POST['phone'];
    $psw=$_POST['password'];    
	session_start();
    $phoneFlag = preg_match_all("/^13[0-9]{1}[0-9]{8}$|15[013589]{1}[0-9]{8}$|17[013589]{1}[0-9]{8}$|189[0-9]{8}$/",$phone,$tempPhone);  
    $pswFlag = preg_match_all("/^(\w){6,20}$/",$psw,$tempPsw);            
    $result=array("flag"=>"","success"=>"false","message"=>"");
    if($phoneFlag&&$pswFlag){
       	$sql= "select * from Users where Phone ='".$phone."' AND PassWord = '".$psw."'";      	
        $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));        	
       	if($row){
       		$result["flag"]="100";
       		$result["success"]="true";
       		$result["message"]="成功";
       		$_SESSION["userName"]=$row["Name"];
			$_SESSION["uId"]=$row["UId"];
       	}else{
       		$result["flag"]="101";
       		$result["success"]="false";
       		$result["message"]="用户名或密码错误";
       	}
    }else{
       		$result["flag"]="300";
       		$result["success"]="false";
       		$result["message"]="手机号码或密码格式不正确";
    }       
    echo json_encode($result);
?>