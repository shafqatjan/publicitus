<?php
	//echo '<pre>';print_r($_POST);
	$err=0;
if(isset($_POST) && isset($_POST['invoice']))
{
		$_orderid		=isset($_POST['invoice'])?$_POST['invoice']:"";
		$fullpayment  = $_POST['payment_gross'];
		//Last id
		$max_id=1;
		//$max_id  = $fun->executeScalar("SELECT max(id) FROM ".TBL_ORDER);		

		
		
		//get from db last payment and check it compare it last paid and paid from paypal
		//$total_price  = $fun->executeScalar("SELECT total_amount FROM ".TBL_ORDER." where id = ".$max_id);
		$total_price  = 20;
		
		//Sending mail to person who is paying 
		//$email  = $fun->executeScalar("SELECT email FROM ".TBL_USERS." where id = ".$_SESSION['userID']."");		
		$email="shafqat_jani@hotmail.com";
		
		//name of person
		//$name  = $fun->executeScalar("SELECT name FROM ".TBL_USERS." where id = ".$_SESSION['userID']."");				
		$name="Shafqat Jan Siddiqui";
		
		//Comaparing the payment 
		if($fullpayment==$total_price)
		{
			//update the status of payment Paid or pending
			
/*			$objOrder->fnSetStatus(2);	
			$objOrder->fnSetId($max_id);
			$updatestatus=$objOrder->UpdateStatus(TBL_ORDER);
			if($fuc->execute($updatestatus))
			{
*/				 $to 	  = $email ;
				$subject  = "Payment successfully done"; 
				$message  = "Dear User $name\r\n <br>";
				$message .= "Payment has been done of $$total_price.\r\n";
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: <".$email.">\r\n";
				//echo $to."<br>".$subject."<br>".$message."<br>".$headers;exit;
				mail($to, $subject, $message, $headers);
				$err=0;
			/*}*/
		}
		else
		{
			$to 	  = $email ;
			$subject  = "Payment unsuccessfull due to some technical problem.."; 
			$message  = "Dear User $name\r\n <br>";
			$message .= "Error occur Payment has not been done you buyied of this amount  $total_price and send us wrong information.\r\n copntack to administrator";
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: <".$email.">\r\n";
			//echo $to."<br>".$subject."<br>".$message."<br>".$headers;exit;
			mail($to, $subject, $message, $headers);
			$err=1;
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Auction Web Solution - Thank you</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php include("includes/header.php"); ?><!--top close-->


<div class="header-2"><!--header start-->

<div class="slogan-2"></div>
<!--slogan close--><!--img close--><!--vp close-->

</div><!--header  close-->

<div class="content"><!--content start--><!--packages  close-->

<div class="leftcol-inner"><!--leftcol start-->

<div class="leftcolhd-inner">Thank You
</div><!--leftcolhd close-->

<div style="clear:both"></div>

<div class="m1-para"><!--m1 start-->
 <p>
<?php

if(($fullpayment==$total_price)&&($_POST['payment_status']=='Completed') and $err==0)
{
	
	$cart->deleteAllItem();
	?>
    Thank you for your shopping. Your transaction has been completed.
<?php } 
else
{
	?>
    <span style="color:#F00">You have not payed the actual amount. Please pay the actual amount.</span>
<?php }
?>

 </p>
 

</div>

<!--featurecontainer close-->
<!--m1 close-->
<div style="clear:both"></div>
<!--featurecontainer close-->


<!--m1 close-->

<div class="clear"></div>
<!--leftcol start--><!--leftcolhd close-->

<div style="clear:both"></div>
<!--featurecontainer close-->
<!--m1 close-->
<!--featurecontainer close-->
</div>

<!--m1 close-->
<div class="rightcol"><!--rightcol start-->
<?php include("includes/right-bar.php"); ?>
</div>
<div class="clear"></div><div class="clear"></div>
</div>

<!--latesthdline close-->
<!--rightcol close-->
<!--leftcol close-->
<div style="clear:both"></div>
</div><!--content close-->


<?php include("includes/footer.php"); ?>




</body>
</html>
<?php
}
else
{
	header("location:index.php");
}
?>
