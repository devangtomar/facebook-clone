<?php
/**
 * This code handles the addition of the application to an user page.
 */
require_once("config.php");

$structInit = array(
	'app_id' => APP_ID,
	'app_name' => APP_NAME,
	'sec_key' => APP_SECKEY,
	'api_key' => APP_APIKEY
);
$FacebookAPP = new PHPforFB($structInit);
if($FacebookAPP->lastErrorCode>0){
	//Creation failed => Display error message and exit
	echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
	exit;
}
else{
	//APP_APIKEY must be set to the value from
	//https://www.facebook.com/developers/apps.php?app_id=APP_ID
	if(($res = $FacebookAPP->AddAppAsPage()) === FALSE){
		//Error
		echo '<br>File addpage.php: Please set APP_APIKEY to the value from <a href="https://www.facebook.com/developers/apps.php?app_id='.APP_ID.'" target="_top">here</a><p>';
		echo "PHP4FB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
		exit;
	}else{
		if($res==''){
			//The user has cancelled the form to add the application.
			echo '
			The user has cancelled adding the application to the fan page.
			';
		}
		else{
			//The user has selected one of his fan pages and confirmed addition.
			$pageID = $res;

			//Get information about the selected fan page
			$page = $FacebookAPP->GetPageInfo($pageID);
			if($page === FALSE){
				echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
				exit;
			}

			//Save data in a database here, if appropriate.

			//Now invoke the selected fan page and jump into the application there
			//(or change into the page mode of the application, if applicable).
			if(strpos($page['link'],'?') === false){
				$page['link'] = $page['link'].'?sk=app_'.APP_ID;
			}
			else{
				$page['link'] = $page['link'].'&sk=app_'.APP_ID;
			}
			echo '
				<script type="text/javascript">
					window.open(\''.$page['link'].'\',\'_top\');
				</script>
			';
			exit;

		}
	}
}
?>