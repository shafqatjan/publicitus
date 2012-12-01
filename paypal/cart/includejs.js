// JavaScript Document

function addToCart(items,price,quantity)
{
	//alert(items+' '+price+' '+quantity);
	var quantityT=jQuery('#quantity'+quantity).val();
	 param =  "items="+items+"&price="+price+"&quantity="+quantityT+"&act=add";
//	 alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
					viewCart();
					return;
		   }
	});
}
function deleteCartAll()
{
	//alert(items+' '+price+' '+quantity);
	 param =  "act=del";
	 //alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
					viewCart();
					return;
		   }
	});
}
function deleteCartItem(items)
{
	 param =  "items="+items+"&act=delitem";
//	 alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
					viewCart();
					return;
		   }
	});
}
function countCartAll()
{
	 param =  "act=countall";
//	 alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
//					alert(msg); return;
					jQuery('#cartDiv').html(msg).show();
					return;
		   }
	});
}
function countCartItem(items)
{
	 param =  "items="+items+"&act=countitem";
//	 alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
//					alert(msg); return;
					jQuery('#cartDiv').html(msg).show();
					return;
		   }
	});
}
function viewCart()
{
	 param =  "act=viewcart";
//	 alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
//					alert(msg); return;
					jQuery('#cartDiv').html(msg).show();
					return;
		   }
	});
}
function checkOut()
{
	 param =  "act=checkout";
//	 alert(param); return;
	jQuery.ajax({
		   type		: "GET",
		   data 	: param,
		   url 		: 'cart-action.php',
		   success 	: function(msg){
					jQuery('#cartDiv').html(msg).show();
					return;
		   }
	});
}