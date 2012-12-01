<?php
include_once("cCart.php");
$objCart = &$_SESSION['cart'];


	$wdir				= getcwd();

	$page_arr_part		= explode('\\',$wdir);
	$page				= end($page_arr_part);
	$previous = prev($page_arr_part);    

	$url				= "http://".$_SERVER['HTTP_HOST']."/".$page."/";
	if(isset($_POST) and !empty($_POST))
	{
//	echo '<pre>';print_r($_POST);exit;
				$totItem=count($objCart->cart);
		/* Befor going further save in the table order*/
				$_orderid = strtotime("now");
				$_clientmailtext = "Order Number: $_orderid\r\n";
				$_prodTotalPrice=0;
				$totItem=count($objCart->cart);
				for ($i=1; $i<=$totItem; $i++)
				{		 			 		
						$pid=$i;
						$ptitle=$_POST['Htitle'.$i];
						$pprice=$_POST['Hprice'.$i];
						$_quantity = $_POST['quantity'.$i];
						

					 $_itemid       = $pid; 
					 $_itemtitle    = $ptitle;
					 $_itemPrice    = $pprice;		 		
					 
					 $_prodPrice = $pprice;		 				 	   		 				 
					 $_prodTotalPrice  = $pprice;
					 $_size=count($objCart->cart);

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
				
					for ($i=1; $i<=$totItem; $i++)
					{		 			 		
						//echo 'itemid=';
						$_itemid    = 	$i;
						//echo 'item title=';
						$_itemtitle    = $_POST['Htitle'.$i];
						//echo 'item price=';
						$_itemPrice    = $_POST['Hprice'.$i];
					    //echo 'item quantity=';
						$_quantity     = $_POST['quantity'.$i];;
						
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
		<td>Apple<input type='hidden' name='Htitle1' id='Htitle1' value="Apple"></td>
		<td>
        10<input type='hidden' name='Hprice1' id='Hprice1' value="10">
        </td>
		<td>
        <input type='text' name='quantity1' id='quantity1'>
        </td>
		<td>
        	<input type="button" value="Add to Cart" onclick="addToCart('Apple',10,1)" />
        	<input type="button" value="Count Item" onclick="countCartItem('Apple')" />                        
        	<input type="button" value="Delete Item" onclick="deleteCartItem('Apple')" />                        
        </td>
	</tr>
	<tr>
		<td>Banana<input type='hidden' name='Htitle2' id='Htitle2' value="Banana"></td>
		<td>12<input type='hidden' name='Hprice2' id='Hprice2' value="12"></td>
		<td>
        <input type='text' name='quantity2' id='quantity2'>
 
        </td>
		<td>
        	<input type="button" value="Add to Cart" onclick="addToCart('Banana',12,2)" />
			<input type="button" value="Count Item" onclick="countCartItem('Banana')" />            
        	<input type="button" value="Delete Item" onclick="deleteCartItem('Banana')" />                     
        </td>
	</tr>
	<tr>
		<td>Mango<input type='hidden' name='Htitle3' id='Htitle3' value="Mango"></td>
		<td>15<input type='hidden' name='Hprice3' id='Hprice3' value="15"></td>
		<td>
        <input type='text' name='quantity3' id='quantity3'>
        
        </td>
		<td>
        	<input type="button" value="Add to Cart" onclick="addToCart('Mango',15,3)" />
        	<input type="button" value="Count Item" onclick="countCartItem('Mango')" />                                    
        	<input type="button" value="Delete Item" onclick="deleteCartItem('Mango')" />                                    
        </td>
	</tr>
	<tr>
		<td colspan=4>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="right">
        	<input type="button" value="Delete cart" onclick="deleteCartAll();">
            <input type="button" value="Count Item" onclick="countCartAll();">
            <input type="button" value="View cart" onclick="viewCart();">
            <input type="submit" value="Check out" >
        </td>
	</tr>
</table>
</form>
<div id="cartDiv">
<?php
echo $objCart->viewCart();
?>
</div>