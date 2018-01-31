<?php
/**
 * Application main page
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
//The following section is needed for rendering a FBML form, for instance.
//We activate XFBML by calling $FacebookAPP->EnableXFBML().
//This should take place immediately after the opening body tag.
?>
<html>
	<head>
		<title><?=$FacebookAPP->appName;?></title>
	</head>
	<body style='background-color:#ffffff;'>
		<?=$FacebookAPP->EnableXFBML();?>
<?
		echo '<center>This is "main.php", the application main page</center>';
		//Check the permissions we have
		if(!empty($FacebookAPP->userID)){
			//Here we can e.g. fetch user specific settings from the database.

			//If we haven't retrieved the user's data yet, we take care of this here.
			if(empty($FacebookAPP->userData)){
				$res = $FacebookAPP->GetUserInfo();
				if($res === FALSE){
					//Creation failed => Display error message and exit
					echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
					exit;
				}
			}
			echo '<h1>User information: </h1><pre>';
			print_r($FacebookAPP->userData);
			echo '<br>';
			echo "Depending on the user's security and privacy settings, the user's 'liked' objects may be visible also.<br>";
			//We can narrow the respective query, in this case to objects of the type
			//application with the name of our application. In doing so, we can specifically
			//determine whether the user has 'liked' our application.
			$erg = $FacebookAPP->GetLikes('','Application',APP_NAME);
			if($erg === FALSE){
				//Creation failed => Display error message and exit
				echo "PHPforFB Error: ".$FacebookAPP->lastErrorCode." -> ".$FacebookAPP->lastError;
				exit;
			}elseif(empty($erg)){
				//When the result is empty, the user hasn't 'liked' our application, or he may
				//have adjusted his privacy settings in a way that we can't see it.
				echo '<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D'.APP_ID.'&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;font&amp;colorscheme=light&amp;height=26" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:26px;" allowTransparency="true"></iframe>';
			}
			echo "<br>All the user's visible 'likes'<br>";
			$erg = $FacebookAPP->GetLikes('','','');
			print_r($erg);

			//For displaying a friends invitation form using FBML
			echo '<table class="maininfo" cellpadding="0" cellspacing="0" border=0 style="width:99%">';
			echo '<tr><td><h1>Freundesliste:</h1></td></tr>
				<tr height="500"><td align="center" valign=top><div style="z-index: 1;">
				<fb:serverfbml width="580">
				  <script type="text/fbml">
				    <fb:request-form action="'.$FacebookAPP->appFBURL.'"
			         method="POST"
			         invite="true"
			         type="'.APP_TITLE.'"
			         content="Acute allergies & pollen alert! See 
					'.htmlentities("<fb:req-choice url='".$FacebookAPP->appFBURL."' label='".$FacebookAPP->appName."' />").'">
				      <fb:multi-friend-selector showborder="false"
			            bypass="cancel"
			            email_invite="false"
			            import_external_friends="false"
			            cols=3
			            rows=4
			            max=20
			            actiontext="'.APP_TITLE.' recommend"/>
				    </fb:request-form>
				  </script>
				</fb:serverfbml>
				</div>
				</td></tr>
			</table>';
		}
		else{//Permissions are not available
			echo '<h1>Permissions have not been granted.</h1>.
			<br>Please <a href="permission.php" target="_self">grant permissions</a> first.';
		}
		echo '</body></html>';//close HTML
	}
}
?>