<?php
/*
Simple Webcam Image Archive Script
---------------------------------

Author: Stephen Phillips - http://www.stephen-phillips.co.uk/webcam.html
Date: 09/03/2012
Version: 1.0
*/

// website (no trailing slash or http://)
$host = 'yourwebsite.co.uk';
// root path to the folder on the server where the image you want to archive is (keep trailing slash)
$imagepath = '/www/yourwebsite.co.uk/';
// the name of the file you wish to archive (must be a jpeg .jpg extension at the moment, I have a version with mime code written but just not packaged yet should anyone want it!)
$file = $imagepath."webcam.jpg";

// debug
ini_set('display_errors',0);
error_reporting(E_NONE);

// database details
$link = mysql_connect('localhost', 'dbuser', 'dbpass');
$db_selected = mysql_select_db('dbname', $link);

?>