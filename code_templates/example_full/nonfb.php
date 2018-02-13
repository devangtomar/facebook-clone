<?php
/*
 * This is an include file.
 * This file provides the non-Facebook variant of the application,
 * i.e. when it was not entered through Facebook.
 * Use the $source variable to differentiate the possible causes for
 * including this file.
 */

echo 'Here in nonfb.php you can insert your code for a non-Facebook version.<br>
<br>
You can display different informations here depending on which part of the application included this file.<br>

Included by: '.$source.'.php
';

switch ($source) {
    case "index":
        echo "We are on the application entry page.";
        break;
    case "main":
        echo "We are in the application main section.";
        break;
}

?>