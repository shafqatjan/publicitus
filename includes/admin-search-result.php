<?php

 if($_POST['btn_search'])
 {
  $search = $_POST['search'];
   $membertype = $_POST['membertype'];
 
      if($membertype==2)
		 $me_type .= " And email like '%$search%'";
		 
	  else
	      $me_type .= " And user_name like '%$search%'";
		 
		
 }
?>