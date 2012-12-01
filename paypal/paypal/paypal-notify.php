<?php
		
//		$_orderid		=isset($_POST['invoice'])?$_POST['invoice']:"";
 		$_orderid = 1;  //;$db->executeScalar("SELECT max(id) FROM ".TBL_ORDER);
		
		////////////////////////////////SANDBOX/////////////////////////////////////////////
		$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr';
		/////////////////////////////////LIVE//////////////////////////////////////////////
		//$paypal_url='https://www.paypal.com/cgi-bin/webscr';
	////////////////////////////////////////////////////////////////////	
		$url_parsed		= parse_url($paypal_url);  
		//print_r($url_parsed);
	
		$error			= "";
		$ipn_response	= "";
		$ipn_data		 = array(); 

      // generate the post string from the _POST vars aswell as load the
      // _POST vars into an arry so we can play with them from the calling
      // script.
      $post_string = '';    
      foreach ($_POST as $field=>$value) 
	  { 
         $ipn_data["$field"] = $value;
         $post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command
		$fullpayment  = $_POST['payment_gross'];
		$total_price  = 20;//$db->executeScalar("SELECT total_amount FROM ".TBL_ORDER." where id = ".$_orderid."");
		
		if($fullpayment	==	$total_price)
		{
		  // open the connection to paypal
		  $fp = fsockopen($url_parsed['host'],"80",$err_num,$err_str,30); 
		  if(!$fp)
		   {
	
			 // could not open the connection.  If loggin is on, the error message
			 // will be in the log.
			 $error = "fsockopen error no. $errnum: $errstr"; 
			 file_put_contents("error.txt",$error); 
			 echo $error;
			 exit;
		  
			 
		  } else { 
	 
			 // Post the data back to paypal
			 fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
			 fputs($fp, "Host: $url_parsed[host]\r\n"); 
			 fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			 fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
			 fputs($fp, "Connection: close\r\n\r\n"); 
			 fputs($fp, $post_string . "\r\n\r\n"); 
	
			 // loop through the response from the server and append to variable
			 while(!feof($fp))
			  { 
				$ipn_response .= fgets($fp, 1024); 
			 } 
	
			 fclose($fp); // close connection
	
		  }
		  
		  if (eregi("VERIFIED",$ipn_response)) {
			  echo "confirmed";
			  file_put_contents("paypal.txt",$ipn_data);
			  //Update status empty the cart//
			  //$sql = "update ".TBL_ORDER." set status=2 where id=".$_orderid;
			  //$db->execute($sql);
			  //$cart->deleteAllItem();
			  exit;
				  
			 
		  } else {
	  
			 // Invalid IPN transaction.  Check the log for details.
			 $error = 'IPN Validation Failed.';
			  file_put_contents("validate.txt",$error);
			 echo $error;
			 exit;
		 
			 
		  }
	}
?>