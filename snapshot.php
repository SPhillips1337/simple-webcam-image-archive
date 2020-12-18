<?php
/*
Simple Webcam Image Archive Script
---------------------------------

Author: Stephen Phillips - http://www.stephen-phillips.co.uk/webcam.html
Date: 09/03/2012
Version: 1.0
*/

  include('inc/config.inc.php');

	$size = array();
	
	$bits = array();
	
	$category = "";
	
	$tag = "";
	
	$filename = "";
	
	$bits = explode('/',str_replace($imagepath,'',$file));

	$tags = implode(' ',$bits);
	
	$endpos = (count($bits)-1);
	
	$filename = $bits[$endpos];
/*		
	$categoryPos = $endpos-1;
		
	$category = $bits[$categoryPos];
		
	$category = str_replace($filename,'',$file);
	*/
	
	$category = "";
	
	$tags = str_replace($filename,'',$file);
	
	
	$fileparts = explode('.',$filename);

  	$filepartsLength = (count($fileparts)-1);
	
	$extension = $fileparts[$filepartsLength];
	
	$path = $file;

	@chmod($file, 0777); 	

	$size = @getimagesize($file);

	$width = $size[0];
	$height = $size[1];
	
	$path = $file;
	
	$length = filesize($path);
	
	if(isset($size[0]))
		if($size[0]!=""){

			$handle = fopen($file, "r");
			if($handle){
				$content = fread($handle, filesize($file));
				
				/*** compression ****/
				$checksum = md5($content);
				/*** end of compression ***/
				
				$contents = addslashes($content);

				fclose($handle);			
	
				$query = "SELECT `checksum` FROM `image_details` WHERE `checksum` = '".mysql_real_escape_string($checksum)."' ";
				$result = mysql_query($query) or die('Error, image check failed<br/>'.$query); 	
				
				$num = mysql_num_rows($result);
				
				if($num==0){
          
          $query = "INSERT INTO `images` (`category`, `tags`, `filename`, `width`, `height`, `path`, `contents`, `extension`,`length`,`date`,`checksum`) ".
          "VALUES ('".mysql_real_escape_string($category)."', '".mysql_real_escape_string($tags)."', '".mysql_real_escape_string($filename)."', '".mysql_real_escape_string($width)."', '".mysql_real_escape_string($height)."', '".mysql_real_escape_string($path)."', '".$contents."', '".mysql_real_escape_string($extension)."', '".mysql_real_escape_string($length)."',NOW(), '".mysql_real_escape_string($checksum)."')";
          
          mysql_query($query) or die('Error, image creation failed'); 
          
          $id = mysql_insert_id();
          
          $thumb = "getImageThumbnail.php?id=".$id;
          $full = "getImage.php?id=".$id;
          
          $query = "INSERT INTO `image_details` (`id`, `category`, `tags`, `filename`, `width`, `height`, `path`, `thumb`, `full`, `extension`,`length`,`date`,`checksum`) ".
          "VALUES ('$id', '".mysql_real_escape_string($category)."', '".mysql_real_escape_string($tags)."', '".mysql_real_escape_string($filename)."', '".mysql_real_escape_string($width)."', '".mysql_real_escape_string($height)."', '".mysql_real_escape_string($path)."', '".mysql_real_escape_string($thumb)."', '".mysql_real_escape_string($full)."', '".mysql_real_escape_string($extension)."', '".mysql_real_escape_string($length)."',NOW(), '".mysql_real_escape_string($checksum)."')";
          mysql_query($query) or die('Error, image details creation failed'); 
          
          //@unlink($path);
          
				}
								
			}
			
			
		}

?>