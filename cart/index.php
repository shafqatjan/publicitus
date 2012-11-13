<?php
include_once("cCart.php");
$objCart = &$_SESSION['cart'];
echo '<pre>';

$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if(isset($_POST['chkOutBtn']))
{
	print_r($objCart);
	echo $totItem = count($objCart->cart);exit;
	//$sql = "Select max(id) from ".TBL_ORDER;		 		 
	//$_orderid = $objDB2->executeScalar($sql);
	$_orderid = strtotime("now");
	$_clientmailtext = "Order Number: $_orderid\r\n";
	$_prodTotalPrice=0;
	for ($i=0; $i<$totItem; $i++){		 			 		
		 $_itemid       = $cart->cart[$i]['id']; 
		 $_itemtitle    = $cart->cart[$i]['item'];
		 $_itemPrice    = $cart->cart[$i]['price'];		 		
		 $_quantity     = $cart->cart[$i]['quantity'];
		 $_pType    = $cart->cart[$i]['type'];					 
		 $_quantity     = 1;
		 
							 
		
		 $_prodPrice = $cart->cart[$i]['price'];		 				 	   		 				 
		 $_prodTotalPrice  = $cart->checkout();

		 $_feature = "";
			for($x=0;$x<count($cart->subcart);$x++)
			{
				//$cart->cart[$i][0]

				if($cart->cart[$i]['id'] == $cart->subcart[$x]['pid'])
				{
					 $_feature .= $cart->subcart[$x]['id'].",";
				}
			}
			
		 if(!empty($_feature))
			$_feature = substr($_feature,0,-1);
			
			//echo $_feature;
		
		 $insert_cart = "insert into ".TBL_ORDER_DETAIL." 
							set order_id  = '$_orderid', 						
							product_id=$_itemid,
							product_type='$_pType',
							feature_ids = '".$_feature."'";  
	
		if($db->execute($insert_cart))
		{
				 //$_itemnumber = $db->executeScalar("Select max(id) from ".TBL_ORDER_DETAIL);
				$_itemnumber =strtotime("now");
				$_clientmailtext .= "Item Number : $_itemnumber\n";
				$_clientmailtext .= "Item: $_itemtitle  [Quantity : $_quantity] [Size : $_size] [Item Price : $$_itemPrice]";
				$_clientmailtext .="\r\n";		 			
		} 
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
			$_itemid    = $cart->cart[$i]['id'];						//echo '<br />';
			//echo 'item title=';
			$_itemtitle    = $cart->cart[$i]['item'];				//echo '<br />';
			//echo 'item price=';
			$_itemPrice    = $cart->cart[$i]['price'];		 	//echo '<br />';	
			//echo 'item quantity=';
			$_quantity     = $cart->cart[$i]['quantity'];			//echo '<br />';
			
			//echo 'item price=';
			$_PPrice = $cart->cart[$i]['totalprice']+$cart->getFeaturePrice($_itemid );//echo '<br />';

			$str .= "<input type='hidden' name='item_name_$j' value='$_itemtitle'>
			<input type='hidden' name='amount_$j' value='$_itemPrice'>
			<input type='hidden' name='quantity_$j' value='$_quantity'>";						

			$j++;
			//echo '<hr>';
		}
/*							for($si=0; $si<count($cart->subcart); $si++)
				{
					$ccc=1;
						$_sitemid    	= $cart->subcart[$si]['id'];					
						$_sitemtitle    = $cart->subcart[$si]['item'];
						$_sitemPrice    = $cart->subcart[$si]['price'];		 		
						$_squantity     = $cart->subcart[$si]['quantity'];								
						$_sPPrice = $cart->subcart[$si]['totalprice'];									
						$str .= "<input type='hidden' name='item_name_$ccc' value='$_sitemtitle'>
						<input type='hidden' name='amount_$ccc' value='$_sPPrice'>
						<input type='hidden' name='quantity_$ccc' value='$_squantity'>";

					$ccc++;
				}*/

		$str .= '<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="return" value="'.$url.'thanks.php?msg=1">
		<input type="hidden" name="rm" value="2">
		<input type="hidden" name="cancel_return" value="'.$url.'viewcart.php">
		<input type="hidden" name="notify_url"  value="'.$url.'paypal_notify.php">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc.gif" border="0" name="submit" alt="Make payment - it is fast, free and secure!">
		</form>';

	echo $str;	
	
	//unset($_SESSION["cart"]);

	echo '<script>document.form1.submit();</script>';
	 		
				
}
?>
<script src="jquery.js"></script>
<script src="includejs.js"></script>

<form method="post">
  <table border="0">
    <tr>
      <th>Title</th>
      <th>Price</th>
      <th>Quantiy</th>
      <th>Action</th>
    </tr>
    <tr>
      <td>Apple</td>
      <td>10</td>
      <td><input type='text' name='quantity1' id='quantity1'></td>
      <td><input type="button" value="Add to Cart" onclick="addToCart('Apple',10,1)" />
        <input type="button" value="Count Item" onclick="countCartItem('Apple')" />
        <input type="button" value="Delete Item" onclick="deleteCartItem('Apple')" /></td>
    </tr>
    <tr>
      <td>Banana</td>
      <td>12</td>
      <td><input type='text' name='quantity2' id='quantity2'></td>
      <td><input type="button" value="Add to Cart" onclick="addToCart('Banana',12,2)" />
        <input type="button" value="Count Item" onclick="countCartItem('Banana')" />
        <input type="button" value="Delete Item" onclick="deleteCartItem('Banana')" /></td>
    </tr>
    <tr>
      <td>Mango</td>
      <td>15</td>
      <td><input type='text' name='quantity3' id='quantity3'></td>
      <td><input type="button" value="Add to Cart" onclick="addToCart('Mango',15,3)" />
        <input type="button" value="Count Item" onclick="countCartItem('Mango')" />
        <input type="button" value="Delete Item" onclick="deleteCartItem('Mango')" /></td>
    </tr>
    <tr>
      <td colspan=4>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right"><input type="button" value="Delete cart" onclick="deleteCartAll();">
        <input type="button" value="Count Item" onclick="countCartAll();">
        <input type="button" value="View cart" onclick="viewCart();">
        <input type="submit" value="Check out" id="chkOutBtn" name="chkOutBtn"></td>
    </tr>
  </table>
</form>
<div id="cartDiv"><?php echo $objCart->viewCart();?></div>
