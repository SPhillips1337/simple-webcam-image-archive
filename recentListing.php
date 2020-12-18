<?php
/*
Simple Webcam Image Archive Script
---------------------------------

Author: Stephen Phillips - http://www.stephen-phillips.co.uk/webcam.html
Date: 09/03/2012
Version: 1.0
*/

include('inc/config.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

?>
<head>

	<title>Recent Images</title>
    
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/prototype.js"></script>
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/lightbox.js"></script>

  <link rel="stylesheet" href="http://<?php echo $host; ?>/webcam/css/lightbox.css" type="text/css" media="screen" />
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  
</head>
<body>

<?php

  $query = "SELECT `id`, `filename`, `length`, `thumb`, `full`,`width`, `height` FROM `image_details`";

  $query .= " ORDER BY `date` DESC ";
  
  $query .= " LIMIT 0,10 ";

  $result = mysql_query($query) or die('Error, query failed'); 	

  if (mysql_num_rows($result) == 0) {

    print "No images!\n";

    exit;

  }
?>
<div id="images" style="float:left;width:1024px;">

<?php
  while ($row = mysql_fetch_assoc($result)) {
    ?>
 		<div style="float:left;background:#ffffff;width:150px;height:150px;">
          <a href="http://<?php echo $host; ?>/webcam/getImage.php?id=<?php echo $row['id']; ?>&preview=true" rel="lightbox[images]" title="image: <?php echo $row['filename']; ?> (<?php echo $row['length']; ?> bytes)" target="_blank">
              <img src="http://<?php echo $host; ?>/webcam/getImageThumbnail.php?id=<?php echo $row['id']; ?>" alt="image: <?php echo $row['filename']; ?> (<?php echo $row['length']; ?> bytes)" border="0">
          </a>
    </div>
    <?php
  }

?>
</div>
<div class="clear" style="clear:both;"></div>

	</body>
</html>
