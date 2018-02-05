<?php
/*
 * PHPforFB
 * - a professional PHP Framework for Facebook�
 * 
 *
 * = Code template for a facebook application + page app =
 *
 * This PHP code template is a complete Facebook application.
 * The application can be added to any fan page, and it
 * additionally offers a standalone fan page mode.
 */

/**
 * Entry point for the whole application
 * - Basic structure and initializations for the different application modes
 * - Independent on whether it is called as an application or page
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
	//Mobile device detection for all subsequent pages
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
		$source = 'main';
		echo "Please complete the code in nonfb.php to offer a non-Facebook version of your application.<br>";
		echo "<br>Alternatively, display an error at this point in index.php, explaining that this application is only available in Facebook.";
		include('nonfb.php');
		exit;
	}
	else{
		/*
		 * In the following code section you can handle the page mode,
		 * if your application was called from or added to a fan page.
		 */
		if($FacebookAPP->callAsPage === TRUE){
			//PAGE MODE
			//Here you can specify what the admin and what a regular user should see.
			//The code is located in pageadmin.php and page.php, respectively.
			echo "In page mode, you may want to differentiate the following cases:<br>
			Using if($FacebookAPP->userLoggedIn == TRUE){}<br>
			you can distinguish between users who are logged in and those who are not,<br>
			using if($FacebookAPP->isAdmin == TRUE){}<br>
			you can tell page administrators and regular users apart,<br>
			using if($FacebookApp->userLikesPage === TRUE){}<br>
			you can determine whether the user has 'liked' your application (see page.php).
			";
			if($FacebookAPP->userLoggedIn === TRUE){
				//If the user is logged in to Facebook:
				if($FacebookAPP->isAdmin === TRUE){
					//Administrator view of the page
					include('pageadmin.php');
					exit;
				}
				else{
					//Normal page view for logged in users
					include('page.php');
					exit;
				}
			}
			else{
				//Normal page view for users who are not logged in, e.g. when someone
				//not logged in or without a Facebook aaccount followed a search engine link
				include('page.php');
				exit;
			}
		}
		else{
			//APP MODE
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
			}
			else{
				//Visitor view of our application, when the user isn't logged in at Facebook!
				$show = 2; //Specify what information should be displayed in info.php
				include('info.php');
				exit;
			}
		}
	}
}

?>