<?php

if(isset($valid) && $valid == 0){ ?>
	Your are not logged in<br> Click here to
	<a href="index.php?r=site/login" target="_top">login</a><br>
<?php } else { ?>
<html>
   <head>
    <title>Trade Admin</title>
  </head> 
   <iframe frameborder="0" border="0" rows="3%,*" src="<?php echo $openPage ?>" width="100%" height="1600" name="main" marginwidth="0" marginheight="0" scrolling="auto">
 </iframe> 
</html>
<?php } ?> 