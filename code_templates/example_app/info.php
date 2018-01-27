<?php
/*
 * This is an include file.
 * This page can be used to inform the user about your application.
 * Use the "show" parameter to distinguish the possible causes for
 * displaying this page.
 */

if($show == 2){
	echo '
		Here in info.php we can inform a user (who is not currently logged in) that this application is available to registered users only, and display a link that takes him to the Facebook login.<br>
		Or, we can display a link that takes him directly to the section where he can grant us the needed permissions: <a href="permission.php" target="_self">Next >></a>
	';
}
else{
	echo '
		Here in info.php we can explain a user (who has not yet granted us permissions) what our application is about and why we require her permissions to proceed.<br>
		Following this, we can take her to the section where she can consent to the needed permissions: <a href="permission.php" target="_self">Next >></a>
	';
}
?>