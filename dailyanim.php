<?php

include('inc/config.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

?>
<head>

	<title>Recent Images Animation</title>
    
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/prototype.js"></script>
	<script type="text/javascript" src="http://<?php echo $host; ?>/webcam/js/scriptaculous.js?load=effects,builder"></script>
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">

</head>
<body>
 
      <div>
          <h1>Webcam</h1>
          <div style="position:relative;top:-36px;left:100px;width:300px;"><a href="index.html">Back to live feed</a></div> 
      
                <div id="container" style="width:760px;min-height:768px;margin-left:auto;margin-right:auto;font-size:12px;">

                    <?php

                      $query = "SELECT `id`, `filename`, `length`, `thumb`, `full`,`width`, `height` FROM `image_details`";

                      $query .= " ORDER BY `id` DESC ";
                      
                      $query .= " LIMIT 0,140";

                      $result = mysql_query($query) or die('Error, query failed'); 	

                      if (mysql_num_rows($result) == 0) {

                        print "No images!\n";

                        exit;

                      }
                    ?>
                    <script type="text/javascript">

                          var images = [
                          <?php
                            $count = 0;
                            while ($row = mysql_fetch_assoc($result)) {
                              ?>'http://<?php echo $host; ?>/webcam/getImage.php?id=<?php echo $row['id']; ?>&preview=true',<?php
                              
                              $count++;
                            }
                          ?>
                          ];
                                      
                          var length = <?php echo $count; ?>;            

                          var webcamimage; 
                          var imgBase = images[0];
                          var count = 0;

                          function refreshImage() 
                          { 
                            
                              if(count<length){
                                  count++;
                              }
                              else{
                                  count = 0;
                              }
                            
                              var rightnow = new Date();
                              webcamimage.src=images[count];

                          } 
                            
                          function init() 
                          { 

                                <!-- Begin
                            
                                <?php

                                $query = "SELECT `id`, `filename`, `length`, `thumb`, `full`,`width`, `height` FROM `image_details`";

                                $query .= " ORDER BY `id` DESC ";

                                $query .= " LIMIT 0,140";

                                $result = mysql_query($query) or die('Error, query failed'); 	

                                if (mysql_num_rows($result) == 0) {

                                    print "No images!\n";

                                    exit;

                                }
        
                                $count = 1;
                                while ($row = mysql_fetch_assoc($result)) 
                                {
                                ?>
                                    image<?php echo $count; ?> = new Image();
                                    image<?php echo $count; ?>.src = 'http://<?php echo $host; ?>/webcam/getImage.php?id=<?php echo $row['id']; ?>&preview=true';
                                <?php
                              
                                     $count++;
                                }

                                ?>
        
                                // End -->

        
        
                                webcamimage 		= document.getElementById("webcamimage");
                                refreshImage();
           
                                if( webcamimage ) 
                                { 
                                    setInterval("refreshImage()",500); 
                                } 
                          } 
        
                          window.onload = init; 
                    </script> 


                    <div id="images" style="float:left;width:760px;">
                            
                        <div style="background:#fff;float:left;">
                              <div  id="webcamimageContainer" style="float:left;width:320px;height:240px;background:#fff;">
                                    <p align="center"><img src="#*$!webcam.jpg" name="image" id="webcamimage" style="width:320px;height:240px" alt="Simple Webcam Image Archive Script" title="Simple Webcam Image Archive Script" /></p>
                              </div>       		
                        </div>
                        <div style="clear:both;"></div>
                          
                    </div>
                    <div style="clear:both;"></div>


              </div>
          </div>     
      </div>

</body>
</html>        
