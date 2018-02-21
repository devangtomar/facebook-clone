<?php
/*
 * This is an include file.
 * This file provides the functionality for fan page administration,
 * for the owners and administrator(s) of the application, when your
 * application is integrated as a fan page and called from an administrator.
 */

$page_id = $FacebookAPP->pageID;

if($FacebookAPP->userLoggedIn == TRUE && $FacebookAPP->isAdmin == TRUE){
	//Admin view of the page
	echo "Here in pageadmin.php you can provide administration functions for the page mode of your application.<br/>";
	echo 'The configuration settings can be saved in a database using the page ID: '.$page_id.'.';
}
?>