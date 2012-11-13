<?php
/*cart class*/

	class Cart{
		var $items;
		var $lastitemid;
		var $subItems;
		
		function Cart()
		{
			$this->items=array();
			$this->subItems=array();						
		}	//end of of constructor

		function add_item($id,$items,$prices,$quantities,$type,$image)	//$prod_id, $title, $price, $image, $qty
		{
			for($i=0; $i<count($this->items); $i++)
			{
				if($this->items[$i]['item']==$items)
				{
					$this->items[$i]['id']=$id;									
					$this->items[$i]['item']=$items;				
					$this->items[$i]['price']=$prices;								
					$this->items[$i]['quantity']=$this->items[$i]['quantity']+$quantities;
					$this->items[$i]['totalprice']=$this->items[$i]['price']*$this->items[$i]['quantity'];				
					$this->items[$i]['type']=$type;		
					$this->items[$i]['image']=$image;													
					return;
				}			
			}
			$totalPrice=$prices*$quantities;
			array_push($this->items, array('item'=>$items,'price'=>$prices,'quantity'=>$quantities,'totalprice'=>$totalPrice,'type'=>$type,'id'=>$id,'image'=>$image));	
		}// end of add_item
		
		function add_sub_item($pid,$id,$items,$prices,$quantities,$type,$image)	//$prod_id, $title, $price, $image, $qty
		{
			for($i=0; $i<count($this->subItems); $i++)
			{
				if($this->subItems[$i]['item']==$items and $this->subItems[$i]['pid']==$pid)
				{
					$this->subItems[$i]['pid']=$pid;														
					$this->subItems[$i]['id']=$id;									
					$this->subItems[$i]['item']=$items;				
					$this->subItems[$i]['price']=$prices;								
					$this->subItems[$i]['quantity']=$this->items[$i]['quantity']+$quantities;
					$this->subItems[$i]['totalprice']=$this->items[$i]['price']*$this->items[$i]['quantity'];				
					$this->subItems[$i]['type']=$type;		
					$this->subItems[$i]['image']=$image;													
					return;
				}			
			}
			$totalPrice=$prices*$quantities;
			array_push($this->subItems, array('item'=>$items,'price'=>$prices,'quantity'=>$quantities,'totalprice'=>$totalPrice,'type'=>$type,'id'=>$id,'image'=>$image,'pid'=>$pid));	
		}// end of add_item		
		function update_item($id,$quantities,$type)	//$prod_id, $title, $price, $image, $qty
		{
//			echo $id.' '.$quantities.' '.$type.'<br>';
			for($i=0; $i<count($this->items); $i++)
			{
				if($this->items[$i]['id']==$id and $this->items[$i]['type']==$type)
				{
					$this->items[$i]['id']=$id;									
					$this->items[$i]['quantity']=$quantities;
					$this->items[$i]['totalprice']=$this->items[$i]['price']*$this->items[$i]['quantity'];				
					$this->items[$i]['type']=$type;					
					return;
				}			
			}
		}// end of update item	
		function update_sub_item($pid,$id,$quantities,$type)	//$prod_id, $title, $price, $image, $qty
		{
//			echo $id.' '.$quantities.' '.$type.'<br>';
			for($i=0; $i<count($this->subItems); $i++)
			{
				if($this->subItems[$i]['id']==$id and $this->subItems[$i]['pid']==$pid and $this->subItems[$i]['type']==$type)
				{
					$this->subItems[$i]['quantity']=$quantities;
					$this->subItems[$i]['totalprice']=$this->subItems[$i]['price']*$this->subItems[$i]['quantity'];				
					return;
				}			
			}
		}// end of update item				
		function viewCart()
		{
			echo '<pre>';print_r($this->items);
/*			$str='';
			$str.="
				<table>
					<tr>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity</th>			
						<th>Total Price</th>
					</tr>";		
			for($i=0; $i<count($this->cart); $i++)
			{
				$str.="<tr>";
				$str.="<td>".$this->items[$i]['item']."</td>";
				$str.="<td>".$this->items[$i]['price']."</td>";
				$str.="<td>".$this->items[$i]['quantity']."</td>";			
				$str.="<td>".$this->items[$i]['totalprice']."</td>";
				$str.="</tr>";
			}
			echo "</table>";
			echo $str;*/
		}	//end of view cart
		function checkOut()
		{
			$total1=0;							
			$total2=0;			
			if(count($this->items)>0)
			{
				for($i=0; $i<count($this->items); $i++)
				{
					$total1=$total1+$this->items[$i]['totalprice'];
				}
				echo $total;
			}
			if(count($this->subItems)>0)
			{
				for($i=0; $i<count($this->subItems); $i++)
				{
					$total2=$total2+$this->subItems[$i]['totalprice'];
				}
			}
			 $total=$total1+$total2;
			return $total;			
		}//end of checkOut
		function deleteAllItem()
		{
			$this->items=array();
			$this->subItems=array();			
		}	//end of deleteAllItem
		function deleteItem($id)
		{
			for($i=0; $i<count($this->items); $i++)
			{
				if($this->items[$i]['id']==$id)
				{
					array_splice($this->items,$i,1);
					return 1;
				}			
			}
		}//end of deleteItem	
		function deleteSubItem($id)
		{
			for($i=0; $i<count($this->subItems); $i++)
			{
				if($this->subItems[$i]['id']==$id)
				{
					array_splice($this->subItems,$i,1);
					return 1;
				}			
			}
		}//end of deleteItem	
		function deleteSubItemByParent($pid)
		{
			for($i=0; $i<count($this->subItems); $i++)
			{
				if($this->subItems[$i]['pid']==$pid)
				{
					array_splice($this->subItems,$i);
				}			
			}
		}//end of deleteItem					
		function getFeaturePrice($tid)
		{
			$gTotal = 0;	
			
			for($i=0;$i<count($this->subItems);$i++)
			 {
				 	if($this->subItems[$i]['pid'] == $tid)
					$gTotal += $this->subItems[$i]['totalprice'];
			 }
			return $gTotal;
			
		}		
			
	}
		
	session_start();
	
	if(!$_SESSION['cart'])
	{
		$_SESSION['cart'] = new Cart;
	}
		
?>