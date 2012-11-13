   <?php 
   if($error != '')
   {
   ?>
   <div class="error-report">  
   	<strong>Error Found.</strong><br><br>
    	<?php echo $error;?>	
    </div>
   <?php
   }
   
   echo $objSession->getSessMsg();
   ?>
	