<?php
/**
 * This file prompts the user for basic permissions.
 */
include('config.php');

$structInit = array(
	'app_id' => APP_ID,
	'app_name' => APP_NAME,
	'sec_key' => APP_SECKEY,
);
$FacebookAPP = new PHPforFB($structInit);

if($FacebookAPP->lastErrorCode>0){
	//Creation failed => Display error message and exit
	echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
	exit;
}
else{
	//Make sure that we are really called through Facebook.
	if($FacebookAPP->callFromFacebook===FALSE || $FacebookAPP->userLoggedIn === FALSE){
		//This visitor is wrong here and will be sent to the starting page of the application.
		header('location: index.php');
		exit;
	}
	else{
		//Query basic permissions.
		if(($res = $FacebookAPP->ForcePermissions('basic')) === FALSE){
			//An error occurred when querying the permissions
			echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
			exit;
		}else{
			//Evaluate the result
			if($res==0){
				//The user declined.
				echo 'In permission.php we can decide what should happen when the user declines to grant permissions to the application.<br>
				E.g. we can explain what exactly the permissions are needed for, and then ask again.<br>
				<a href="permission.php?show=whypermission">Next >></a><br>
				Alternatively, we can send her back to the starting page of the application.<br>
				<a href="'.$FacebookAPP->appFBURL.'" target="_top">Cancel >></a>
				';
			}else{
				//The user accepted to grant permissions to the application.
				echo 'Here in permission.php we can decide what should happen when the user has granted permissions to the application.<br>
				E.g. we can send him to a page for entering some data or selecting from a set of predefined choices.<br>
				<a href="edit.php">Next >></a>';
			}
		}
	}
}
?>