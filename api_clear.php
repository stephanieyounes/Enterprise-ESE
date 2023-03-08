<?php
$username="unl609";
$password="rp8Cm7JGfBDqcW";


//set data as a string
$data="username=$username&password=$password";

//echo "data: $data\r\n"; 
$ch=curl_init('https://cs4743.professorvaladez.com/api/clear_session');
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'content-type: application/x-www-form-urlencoded',
	'content-length: ' . strlen($data))         
);

$time_start = microtime(true);
$result = curl_exec($ch);
$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
curl_close($ch);


$cinfo=json_decode($result, true);

	echo $cinfo[0];
	echo "\r\n";
	echo $cinfo[1];
	echo "\r\n";
	echo $cinfo[2];
	echo "\r\n";

//if first array's status is ok and session was successfully created
//if( $cinfo[0] =="Status: OK" && $cinfo[1]=="MSG: Session Created")
//{
//	$sid=$cinfo[2];
//	//make new connection, we have to set up data every time
//	$data="sid=$sid&uid=$username";
//	echo "\r\nSession Created Successfully!\r\n";
//	echo "SID: $sid\r\n";
//	echo "Create Session Execution Time: $execution_time\r\n";
//	$ch=curl_init('https://cs4743.professorvaladez.com/api/close_session');
//	curl_setopt($ch, CURLOPT_POST,1);
//	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//		'content-type: application/x-www-form-urlencoded',
//		'content-length: '. strlen($data))
//	);
//
//	$time_start = microtime(true);
//	$result = curl_exec($ch);
//	$time_end = microtime(true);
//	$execution_time = ($time_end - $time_start)/60;
//	curl_close($ch);
//
//
//	$cinfo=json_decode($result, true);
//
//	//if first array's status is ok and session was successfully created
//	if( $cinfo[0] =="Status: OK" && $cinfo[1]=="MSG: Session Created")
//	{	
//		$sid=$cinfo[2];
//		//make new connection, we have to set up data every time
//		$data="sid=$sid&uid=$username";
//		echo "\r\nSession Created Successfully!\r\n";
//		echo "SID: $sid\r\n";
//		echo "Create Session Execution Time: $execution_time\r\n";
//	}
//	//echo error out to the terminal
//	else
//	{
//	echo $cinfo[0];
//	echo "\r\n";
//	echo $cinfo[1];
//	echo "\r\n";
//	echo $cinfo[2];
//	echo "\r\n";
//	}
//}
////echo error out to the terminal
//else
//{
////	echo "data sent $data\r\n";
//	echo $cinfo[0];
//	echo "\r\n";
//	echo $cinfo[1];
//	echo "\r\n";
//	echo $cinfo[2];
//	echo "\r\n";
//}

?>