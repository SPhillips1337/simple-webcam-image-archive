<?php
/*
Simple Webcam Image Archive Script
---------------------------------

Author: Stephen Phillips - http://www.stephen-phillips.co.uk/webcam.html
Date: 09/03/2012
Version: 1.0
*/

include('inc/config.inc.php');

header("Content-type: image/jpeg");

$max_width = 150;
$max_height = 150;
				
$saveThumb = 0;

if (isset($_GET['id'])) {

  $query = "SELECT `contents` FROM `image_details` WHERE `id`='".$_GET['id']."' ";
  $result = mysql_query($query) or die('Error, query failed');

  if($row = mysql_fetch_assoc($result)){
  
    if($row['contents']!=""){
      $contents   = $row['contents'];

      // Show thumbnail on screen
      ob_start();
      $image = imagecreatefromstring($contents);
      imagejpeg($image);
      $show = ob_get_contents();
      ob_end_clean();
    
    }
    else{
      $saveThumb = 1;
      $query = "SELECT `contents` FROM `images` WHERE `id`='".$_GET['id']."' ";
      $result = mysql_query($query) or die('Error, query failed');
      
      $row = mysql_fetch_assoc($result);
      
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
      ob_start();
      imagejpeg($thumb);
      $show = ob_get_contents();
      ob_end_clean();
      if($saveThumb==1){
      

        $query = "UPDATE `image_details` SET `contents`='".addslashes($show)."' WHERE `id`='".$_GET['id']."' ";
        //echo $query;
        $result = mysql_query($query) or die('Error, query failed');            

      }
      
      imagedestroy($thumb);
      
    }
        
    // Clean memory
    imagedestroy($image);


    print $show;   

  }

}

exit();

?>
