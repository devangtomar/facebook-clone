<?php
/**
 * This file displays a form and prompts the user to enter some data or
 * to select from a set of predefined choices. For example, the user could
 * choose his favorite color or an application preset here.
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
	//If you want to offer a non-Facebook mode:
	if($FacebookAPP->callFromFacebook===FALSE || $FacebookAPP->userLoggedIn === FALSE){
		//None-Facebook
		echo '<br>This application is available in Facebook only.';
		exit;
	}
	else{
		//Make sure that the user consented to basic permissions, otherwise we have no
		//Facebook userID and cannot associate his settings with a user in a database.
		if(!empty($FacebookAPP->userID)){
			//Basic permissions were granted.
			//Here, data can be processed that the user sends via form.
			if($_REQUEST['action']){
				//The form was filled out and submitted by the user.
				$err = 0;
				$info = $_REQUEST['info'];
				if(strlen($info) < 5){
					$err ++;
					$message = '<br><b>Your input must be at least 5 characters long.</b><br>';
				}
				if($err == 0){
					//When the data are correct, save them, and redirect the user to the
					//main page of the application.

					//Here you can save the data, e.g. in a database.

					header('location: main.php');
					exit;
				}
				else{
					//When there is an error in the user's input, display an error message
					//and resend the form.
				}
			}
			echo '
				Here in edit.php you can prompt the user for informations and save them in a database.<br>
				After successfully saving the data, you can fetch and process them from everywhere in your application.<br>
				In this example, we prompt the user to enter a string which is at least 5 characters long.
				<br>'.$message.'
				<form name="infos" action="edit.php" method="post">
					<input type="hidden" name="action" value="save"/>
					<input type="text" name="info" value="'.$info.'"/><br>
					<input type="submit" name="btnSave" value="Save"/><br>
				</form>
			';
		}else{
			//Basic permissions are not available, so the user must grant them first.
			header('location: permission.php');
			exit;
		}
	}
}
?>