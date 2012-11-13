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
	$objCart->checkOut();
}

?>