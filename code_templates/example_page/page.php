<?php
/*
 * This is an include file.
 * This file implements the fan page appearance and functionality
 * of the application, when it is integrated as a page.
 */

$page_id = $FacebookAPP->pageID;

if($FacebookAPP->callAsPage === TRUE){
	echo "Here in page.php you can provide the page appearance and functionality of your application.<br/>";
	if($FacebookApp->userLikesPage === TRUE){
		echo '<br>Thank you for liking our page!';
	}

}

?>