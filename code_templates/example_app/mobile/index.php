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
 * Entry point for the mobile web version of the facebook application
 * - initializations for the mobile modus and then jumps into ../index.php
 */
include('../config.php');

if($FacebookAPP->lastErrorCode>0){
	//Creation failed => Display error message and exit
	echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
	exit;
}else{

	if(($res=$FacebookAPP->ForcePermissions('basic'))===FALSE){
	    echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
	}else{
		if($res == 1){
			$_SESSION['isMobile'] = TRUE;
			Header('Location: ../');
		}else{
			echo 'Please try again and click on accept.';
		}
	}
}
?>