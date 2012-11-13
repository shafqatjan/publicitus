<?php
class cCart
{
	private $cart = array();
	function cCart()
	{
		$this->cart=array();
	}
	function addToCart($items,$prices,$quantities)
	{
		for($i=0; $i<count($this->cart); $i++)
		{
			if($this->cart[$i]['item']==$items)
			{
				$this->cart[$i]['item']=$items;				
				$this->cart[$i]['price']=$prices;								
				$this->cart[$i]['quantity']=$this->cart[$i]['quantity']+$quantities;
				$this->cart[$i]['totalprice']=$this->cart[$i]['price']*$this->cart[$i]['quantity'];				
				return;
			}			
		}
		$totalPrice=$prices*$quantities;
		array_push($this->cart, array('item'=>$items,'price'=>$prices,'quantity'=>$quantities,'totalprice'=>$totalPrice));		
	}
	function updateCart()
	{

	}
	function deleteItem($items)
	{
		for($i=0; $i<count($this->cart); $i++)
		{
			if($this->cart[$i]['item']==$items)
			{
				array_splice($this->cart,$i,1);
				return 1;
			}			
		}
	}
	function deleteAllItem()
	{
		$this->cart=array();
	}
	function viewCart()
	{
		$str='';
		$str.="
			<table>
				<tr>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>			
					<th>Total Price</th>
				</tr>
		";		
		for($i=0; $i<count($this->cart); $i++)
		{
			$str.="<tr>";
			$str.="<td>".$this->cart[$i]['item']."</td>";
			$str.="<td>".$this->cart[$i]['price']."</td>";
			$str.="<td>".$this->cart[$i]['quantity']."</td>";			
			$str.="<td>".$this->cart[$i]['totalprice']."</td>";
			$str.="</tr>";
		}
		echo "</table>";
		echo $str;
	}
	function countCartAll()
	{
		$counts=count($this->cart);
		echo $counts.' ';		
		echo ($counts>1)?" Items found":" Item found";
	}
	function countCartItem($items)
	{
		$counts=0;
		for($i=0; $i<count($this->cart); $i++)
		{
			if($this->cart[$i]['item']==$items)
			{
				$counts=$this->cart[$i]['quantity'];
			}			
		}
		echo $counts.' '.$items;		
		echo ($counts>1)?"'s found":" found";		
	}
	
	function checkOut()
	{
		$total=0;
		for($i=0; $i<count($this->cart); $i++)
		{
			$total=$total+$this->cart[$i]['totalprice'];
		}
		echo $total;
	}		
}
session_start();
if(!isset($_SESSION['cart']))
{
	$_SESSION['cart'] = new cCart;
}	
?>