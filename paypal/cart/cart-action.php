<?php
include_once("cCart.php");
$items=isset($_GET['items'])?$_GET['items']:"";
$price=isset($_GET['price'])?$_GET['price']:"";
$quantity=isset($_GET['quantity'])?$_GET['quantity']:"";
$action=$_GET['act'];
$objCart = &$_SESSION['cart'];
if($action=="add")
{
	$objCart->addToCart($items,$price,$quantity);
}
if($action=="del")
{
	$objCart->deleteAllItem($items,$price,$quantity);
}
if($action=="delitem")
{
	$objCart->deleteItem($items);
}
if($action=="countall")
{
	$objCart->countCartAll();
}
if($action=="countitem")
{
	$objCart->countCartItem($items);
}
if($action=="viewcart")
{
	$objCart->viewCart();
}

if($action=="checkout")
{
		$ptitle=$_POST['ptitle'];
		$pprice=$_POST['pprice'];
		$totItem=1;
		/* Befor going further save in the table order*/
				$_orderid = strtotime("now");
				$_clientmailtext = "Order Number: $_orderid\r\n";
				$_prodTotalPrice=0;
				$totItem=1;
				for ($i=0; $i<$totItem; $i++)
				{		 			 		
					 $_itemid       = $pid; 
					 $_itemtitle    = $ptitle;
					 $_itemPrice    = $pprice;		 		
					 $_quantity     = 1;
					 $_prodPrice = $pprice;		 				 	   		 				 
					 $_prodTotalPrice  = $pprice;

							 //$_itemnumber = $db->executeScalar("Select max(id) from ".TBL_ORDER_DETAIL);
							$_itemnumber =strtotime("now");
							$_clientmailtext .= "Item Number : $_itemnumber\n";
							$_clientmailtext .= "Item: $_itemtitle  [Quantity : $_quantity] [Size : $_size] [Item Price : $$_itemPrice]";
							$_clientmailtext .="\r\n";		 			
				} 
				//exit;
				//////////////For Pay Pall////////////////////////////
				$str= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="form1" id="form1">';
				//$str= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="form1" id="form1">';
				
				$str.= '<input type="hidden" name="cmd" value="_cart">
					<input type="hidden" name="upload" value="1">
					<input type="hidden" name="business" value="smm_1268469407_biz@yahoo.com">';
					$str .="<input type='hidden' name='invoice' value='$_orderid'>";
					$j=1;
				
					for ($i=0; $i<$totItem; $i++)
					{		 			 		
						//echo 'itemid=';
						$_itemid    = $pid;
						//echo 'item title=';
						$_itemtitle    = $ptitle;
						//echo 'item price=';
						$_itemPrice    = $pprice;
					    //echo 'item quantity=';
						$_quantity     = 1;
						
						//echo 'item price=';
						$_PPrice = $pprice;

						$str .= "<input type='hidden' name='item_name_$j' value='$_itemtitle'>
						<input type='hidden' name='amount_$j' value='$_itemPrice'>
						<input type='hidden' name='quantity_$j' value='$_quantity'>";						

						$j++;
						//echo '<hr>';
					}

		
					$str .= '<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="return" value="'.$url.'thanks.php?msg=1">
					<input type="hidden" name="rm" value="2">
					<input type="hidden" name="cancel_return" value="'.$url.'index.php">
					<input type="hidden" name="notify_url"  value="'.$url.'paypal_notify.php">
					<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc.gif" border="0" name="submit" alt="Make payment - it is fast, free and secure!">
					</form>';
		
				echo $str;	
/*				unset($_SESSION["cart"]);
				unset($_SESSION["feature"]);*/
				echo '<script>document.form1.submit();</script>';

	 		
			


}

?>