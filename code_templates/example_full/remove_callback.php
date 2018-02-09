<?php
/**
 * Application callback script
 * Facebook will call this script when an user (who previously granted
 * permissions to the application) removes the application or revokes
 * those permissions.
 *
 * The URL of this file must be registered at Facebook seperately
 * under Application settings -> Advanced.
 */
require_once("config.php");

//Activate callback mode
$structInit = array(
'mode' => 'callback',
);
$FacebookAPP = new PHPforFB($structInit);
if($FacebookAPP->lastErrorCode>0){
	//Creation failed => Display error message and exit
	echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
	exit;
}

$userID = $FacebookAPP->userID;

if(empty($userID)){
	echo "No UserID";
}else{
	//Here you could e.g. remove the user from your database,
	//or set his/her status to 'deleted'.
}
?>