<?php
/*
 * PHPforFB
 * - a professional PHP Framework for Facebook�
 * 
 *
 * = Code template for a fan page =
 *
 * This PHP code template is a complete fan page extension.
 * The application can be added to any fan page, and it
 * additionally offers a standalone fan page mode.
 */

/**
 * Entry point for the whole application
 * - Basic structure and initializations for the page mode
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

	//Inhibit direct invocation:
	if($FacebookAPP->callFromFacebook===FALSE){
		//None-Facebook:
		echo 'This application is only available from Facebook.';
		exit;
	}
	else{
		//Detect Facebook page mode invocation:
		if($FacebookAPP->callAsPage == TRUE){
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
				//If the admin enters the page and should not be presented
				//the regular view ("&show=page") of the page (see admin page)
				if(($FacebookAPP->isPageAdmin === TRUE) && ($_REQUEST['show'] != 'page')){
					//admin view of the page
					include('pageadmin.php');
					exit;
				}
				else{
					if($FacebookApp->userLikesPage === true){
						echo 'To proceed, you must be a fan of this page!<p>';
						echo 'Press the "like" button to continue!';
					}else{
						//Normal fan page view for logged in users
						include('page.php');
					}
					exit;
				}
			}
			else{
				//Normal page view, for users not currently logged in, e.g. when someone
				//not logged in or without a Facebook account followed a search engine link
				include('page.php');
				exit;
			}
		}
		else{
			//Normal application mode
			//Here a user can add the application to his own page as a menu item.
			$show = 2;
			include('info.php');
			echo '<center><input style="width: 250px;" type="button" name="show" value="Add this page to your own page!" onclick="window.open(\'addpage.php\',\'_self\');"/></center>';
		}
	}
}

?>