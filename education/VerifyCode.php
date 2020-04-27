<?php
	header("Content-Type:text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
	error_reporting(E_ALL^E_NOTICE);
	$apikey = "61f4cca17117de5caa55d3ce598a9023"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
	$mobile =$_POST['phone']; //获取传入的手机号
//	$mobile = "15521003841"; //请用自己的手机号代替
	$result=array("flag"=>"","success"=>"false","message"=>"");
	$num = rand(1000,9999);   //随机产生四位数字的验证码
	setcookie('shopCode',$num);
	$text="【云片网】您的验证码是".$num;
	$ch = curl_init();
	/* 设置验证方式 */
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8','Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
	/* 设置返回结果为流 */
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	/* 设置超时时间*/
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	/* 设置通信方式 */
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	$phoneFlag = preg_match_all("/^13[0-9]{1}[0-9]{8}$|15[013589]{1}[0-9]{8}$|17[013589]{1}[0-9]{8}$|189[0-9]{8}$/",$mobile,$tempPhone);  
	
	if($phoneFlag){	
		// 发送短信
		$data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
		$json_data = send($ch,$data);
		$array = json_decode($json_data,true);	
		$cTempFlag = saveData($mobile,$num);
		if($cTempFlag){
			$result["flag"]="100";
       		$result["success"]="true";
       		$result["message"]="成功";
		}
	}else{
		$result["flag"]="300";
       	$result["success"]="false";
       	$result["message"]="手机号码格式不正确";
	}
	echo json_encode($result);
	
	function send($ch,$data){
		curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		checkErr($result,$error);
//		return $result;
	}
	function checkErr($result,$error) {
		if($result === false)
		{
			echo 'Curl error: ' . $error;
		}else{
			//echo '操作完成没有任何错误';
		}
	}
	function saveData($phone,$num){
		include "connect.php";
		$sql= "select * from VerificationCode where Phone ='".$phone."'";  
        $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));   
        $sqlC="";  
        if(!$row){
        	$sqlC= "INSERT INTO VerificationCode(phone,Vercode,UpdateTime) VALUES('$phone','$num','".date('Y-m-d H:i:s', time())."')";      	       	
          
        }else{
        	$sqlC= "UPDATE VerificationCode SET VerCode='".$num."',UpdateTime='".date('Y-m-d H:i:s', time())."' WHERE Phone ='".$phone."'";      	      	       	        	
        }   
      $cFlag = mysqli_query($conn,$sqlC);
      return $cFlag;
	}
?>