<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
//echo dirname(__FILE__);
$temp = explode("settings",dirname(__FILE__));
//echo '<pre>';print_r($temp); 
define(BASE_PATH, $temp[0]);

$temp = '';
unset($temp);

//define(SITE_ROOT, "http://localhost/publicitus/");
//define(SITE_ROOTADMIN, "http://localhost/publicitus/admin/");

define(SITE_ROOT, "http://www.publicitus.com/");
define(SITE_ROOTADMIN, "http://www.publicitus/admin/");

define(SITE_TITLE, 'Welcome publicitus for uloading!');

//define(CLASSES_DIR, BASE_PATH.'classes\\');
define(CLASSES_DIR, BASE_PATH.'classes/');

require_once(BASE_PATH."config/configuration.php");

function __autoload($className)
{
	if (!class_exists($className, false))
	{
		if(file_exists(CLASSES_DIR.$className.'.class.php'))
			require_once(CLASSES_DIR.$className.'.class.php');
	}
}
	
function fckInclude()
{
	require(BASE_PATH.'FCKeditor/fckeditor.php');
}
function secureImgInclude()
{
	require(BASE_PATH.'/dapphp-securimage-45c5afd/securimage.php');
}
?>