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

	<title>Image Gallery</title>
    
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/prototype.js"></script>
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/lightbox.js"></script>

  <link rel="stylesheet" href="http://<?php echo $host; ?>/webcam/css/lightbox.css" type="text/css" media="screen" />
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  
</head>
<body>

<?php


if(isset($_GET['start']))
  $start = $_GET['start'];
else
  $start = 0;  

if($start<0)
   $start=0;  
     
if(isset($_GET['limit']))
  $limit = $_GET['limit'];
else
  $limit = 18;   
  
if(isset($_GET['sort']))
  $sort = $_GET['sort'];
else
  $sort = 'date';  
  
if(isset($_GET['order']))
  $order = $_GET['order'];
else
  $order = 'DESC';  
              

?>

<div id="container" style="width:1224px;min-height:768px;margin-left:auto;margin-right:auto;font-size:12px;">

<div id="pagination" style="width:200px;float:right;">
<?php

// lets make some pagination

// get total rows
  $query = "SELECT COUNT(`id`) as `total` FROM `image_details`";
    
  $result = mysql_query($query) or die('Error, query failed'); 	
  $row = mysql_fetch_assoc($result);

  $pages = floor($row['total']/$limit);

  for($i=0;$i<=$pages;$i++){
  
    ?>
          &nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=<?php echo ($i*$limit); ?>&limit=<?php echo $limit; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"><?php echo $i+1; ?></a>&nbsp;
    <?php
  
  }

?>
</div>
<div id="mainContent"  style="float:left;width:1024px;">
<div id="topNav" style="float:left;width:900px;">
<div id="topPagination" style="float:left;">
<?php

// lets make some pagination

// get total rows
  $query = "SELECT COUNT(`id`) as `total` FROM `image_details`";
      
  $result = mysql_query($query) or die('Error, query failed'); 	
  $row = mysql_fetch_assoc($result);

  $pages = floor($row['total']/$limit);

  // work out previous page
  if($start!=0)
    $previous = $start - $limit;
  else
    $previous = 0;
    
  if($previous<0)
    $previous = 0;

  // work out next page
  if($start!=0)
    $next = $start + $limit;
  else
    $next = $limit;
    
  if($next>=$row['total']){
     $next=$start;
  }    
    
  if($next<0)
    $next = 0;
    
  $end = $row['total']-$limit;
    
  if($row['total']<=$limit){
     $end=0;
  }    

?>
&nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=0&limit=18">Home</a>&nbsp;
&nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=0&limit=<?php echo $limit; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>">Start</a>&nbsp;
&nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=<?php echo $previous; ?>&limit=<?php echo $limit; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>">Previous</a>&nbsp;
&nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=<?php echo $next; ?>&limit=<?php echo $limit; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>">Next</a>&nbsp;
&nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=<?php echo $end; ?>&limit=<?php echo $limit; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>">End</a>&nbsp;
</div>

<div id="logout" style="float:right;">
  <a href="http://<?php echo $host; ?>/webcam/gallery.php?start=0&limit=18&sort=&order=">Reset</a>
</div>

<div id="limitSelect" style="float:right;padding-right:10px;">
  <form name="limitSelect" action="http://<?php echo $host; ?>/webcam/gallery.php" method="get">
    <input type="hidden" name="start" value="<?php echo $start; ?>" >
    <input type="hidden" name="sort" value="<?php echo $sort; ?>" >
    <input type="hidden" name="order" value="<?php echo $order; ?>" >      
    Limit: 
    <select name="limit" onchange="this.form.submit();">
      <option <?php echo ($limit==18?'selected="selected"':''); ?>>18</option>
      <option <?php echo ($limit==36?'selected="selected"':''); ?>>36</option>
      <option <?php echo ($limit==180?'selected="selected"':''); ?>>180</option>
      <option <?php echo ($limit==360?'selected="selected"':''); ?>>360</option>
      <option <?php echo ($limit==720?'selected="selected"':''); ?>>720</option>
    </select>
  </form>

</div>


<div id="sortSelect" style="float:right;padding-right:10px;">
  <form name="sortSelect" action="http://<?php echo $host; ?>/webcam/gallery.php" method="get">
    <input type="hidden" name="start" value="<?php echo $start; ?>" >    
    Sort: 
    <select name="sort" onchange="this.form.submit();">
      <option value="length" <?php echo ($sort=='length'?'selected="selected"':''); ?>>Size</option>
      <option value="filename" <?php echo ($sort=='filename'?'selected="selected"':''); ?>>Filename</option>
      <option value="width" <?php echo ($sort=='width'?'selected="selected"':''); ?>>Width</option>
      <option value="height" <?php echo ($sort=='height'?'selected="selected"':''); ?>>Height</option>
      <option value="extension" <?php echo ($sort=='extension'?'selected="selected"':''); ?>>Extension</option>
      <option value="date" <?php echo ($sort=='date'?'selected="selected"':''); ?>>Date</option>      
    </select>
     Order: 
    <select name="order" onchange="this.form.submit();">
      <option <?php echo ($order=='ASC'?'selected="selected"':''); ?>>ASC</option>
      <option <?php echo ($order=='DESC'?'selected="selected"':''); ?>>DESC</option>   
    </select>   

  </form>

</div>


</div>

<div class="clear" style="clear:both;"></div>

<br/><br/>
<?php

  $query = "SELECT `id`, `filename`, `length`, `thumb`, `full`,`width`, `height` FROM `image_details`";

  $query .= " ORDER BY `".$sort."` $order ";
  
  $query .= " LIMIT $start,$limit ";

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
    <div style="float:left;text-align:center;width:150px;height:150px;font-size:10px;">
 		<div style="float:left;background:#ffffff;width:150px;">
      		<div style="float:left;background:#ffffff;">
              <a href="http://<?php echo $host; ?>/webcam/getImage.php?id=<?php echo $row['id']; ?>" target="_blank">Download</a>
      		</div>
      		<div style="float:right;background:#ffffff;font-size:8px;">(<?php echo $row['width']." x ".$row['height']; ?>)&nbsp;</div>
      	</div>
      <div class="clear" style="clear:both;"></div>
          <a href="http://<?php echo $host; ?>/webcam/getImage.php?id=<?php echo $row['id']; ?>&preview=true" rel="lightbox[images]" title="image: <?php echo $row['filename']; ?> (<?php echo $row['length']; ?> bytes)" target="_blank">
              <img src="http://<?php echo $host; ?>/webcam/getImageThumbnail.php?id=<?php echo $row['id']; ?>" alt="image: <?php echo $row['filename']; ?> (<?php echo $row['length']; ?> bytes)" border="0">
          </a>
    </div>
    <?php
  }

?>
</div>
<div class="clear" style="clear:both;"></div>
<div id="pagination" style="float:left;width:1024px;">
<?php

// lets make some pagination

// get total rows
  $query = "SELECT COUNT(`id`) as `total` FROM `image_details`";

  $result = mysql_query($query) or die('Error, query failed'); 	
  $row = mysql_fetch_assoc($result);

  $pages = floor($row['total']/$limit);

  for($i=0;$i<=$pages;$i++){
  
    ?>
      &nbsp;<a href="http://<?php echo $host; ?>/webcam/gallery.php?start=<?php echo ($i*$limit); ?>&limit=<?php echo $limit; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>"><?php echo $i+1; ?></a>&nbsp;
    <?php
  
  }

?>
</div>
</div>
</div>

	</body>
</html>
