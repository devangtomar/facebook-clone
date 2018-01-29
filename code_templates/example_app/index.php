<?php
/*
 * PHPforFB
 * - a professional PHP Framework for Facebook�
 * 
 *
 * = Code template for an facebook application =
 *
 * This PHP code template is a complete Facebook application.
 */

/**
 * Entry point for the whole application
 * - Basic structure and initializations for the different application modes
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
	//PHPforFB framework established

	/**
	 * If you want a custom visual appearance (e.g. for mobile devices), you can
	 * set a session variable here and use it subsequently whereever you see fit,
	 * e.g. for displaying a certain stylesheet.
	 */
	//Mobilger�tedetektion f�r alle weiteren Seiten
	if(!isset($_SESSION['isMobile'])){
		if($FacebookAPP->isMobileDevice === TRUE){
			$_SESSION['isMobile'] = TRUE;
		}else{
			$_SESSION['isMobile'] = FALSE;
		}
	}

	//Your application could be called directly, without Facebook.
	//Insert your code here if you want to handle this case.
	if($FacebookAPP->callFromFacebook===FALSE){
		//None-Facebook:
		echo 'This application is only available from Facebook.';
		exit;
	}
	else{
		//'Mobile' appearance without border:
		//If you want the 'Mobile' edition to appear borderless (for leaving more space
		//for your application), disable the border here.
		if($_SESSION['isMobile'] === TRUE){
			if($FacebookAPP->runOutofIframe === FALSE){
				//If a border exists, remove it for the 'Mobile' edition
				if($FacebookAPP->KillIframeBorder()===FALSE){
					echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
					exit;
				}
			}
		}
		//Here you can differentiate between users which are logged in and those who are not.
		if($FacebookAPP->userLoggedIn === TRUE){
			//If the user is logged in at Facebook:
			//Here you can determine if the user has at least once before
			//granted basic permissions to your application.
			if($FacebookAPP->userAuthenticated === FALSE){
				//The user has not yet granted basic permissions:
				//First we inform the user about our application, and then we redirect her
				//to a page where we prompt her for the basic permissions (permission.php)
				header('location: info.php');
				exit;
			}else{
				//The user has already granted basic permissions, therefore his Facebook ID
				//is known to us. It is always available in $FacebookAPP->userID:
				$userID = $FacebookAPP->userID;
				//The known or recognized user is being redirected to the main page of
				//our application.
				header('location: main.php');
				exit;
			}
		}else{
			//Visitor view of our application, when the user isn't logged in at Facebook!
			$show = 2; //Specify what information should be displayed in info.php.
			include('info.php');
			exit;
		}
	}
}

?>