<?php
/*
Simple Webcam Image Archive Script
---------------------------------

Author: Stephen Phillips - http://www.stephen-phillips.co.uk/webcam.html
Date: 09/03/2012
Version: 1.0
*/

include('inc/config.inc.php');

if(isset($_GET['preview'])){

  $max_width = 1024;
  $max_height = 1024;

  if (isset($_GET['id'])) {

    $query = "SELECT `contents` FROM `images` WHERE `id`='".$_GET['id']."' ";
    $result = mysql_query($query) or die('Error, query failed');

    if($row = mysql_fetch_assoc($result)){
      $contents   = $row['contents'];

      // Get original size of image
      $image = imagecreatefromstring($contents);
      $current_width = imagesx($image);
      $current_height = imagesy($image);

      if($current_width>$current_height){

          // Set thumbnail width
          $widths = array($current_width, $max_width);
          $new_width = min($widths);

          // Calculate thumbnail height from given width to maintain ratio
          $new_height = $current_height / $current_width*$new_width;

      }
      else{
        // Set thumbnail height
        $height = array($current_height, $max_height);
        $new_height = min($height);

        // Calculate thumbnail height from given width to maintain ratio
        $new_width = $current_width / $current_height*$new_height;
      
      }
      
      
      // Create new image using thumbnail sizes
      $thumb = imagecreatetruecolor($new_width,$new_height);

      // Copy original image to thumbnail
      imagecopyresampled($thumb,$image,0,0,0,0,$new_width,$new_height,imagesx($image),imagesy($image));

      // Show thumbnail on screen
      $show = imagejpeg($thumb);

      // Clean memory
      imagedestroy($image);
      imagedestroy($thumb);

      print $show;   

    }

  }
}
else{

  if (isset($_GET['id'])) {

    $query = "SELECT `contents` FROM `images` WHERE `id`='".$_GET['id']."' ";
    $result = mysql_query($query) or die('Error, query failed');

    if($row = mysql_fetch_assoc($result)){
      $contents   = $row['contents'];

      header("Content-type: image/jpeg");
      header("Content-Length: " .$row['length']);
      print $contents;   

    }

  }
  
}

exit();

?>