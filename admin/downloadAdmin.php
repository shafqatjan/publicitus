<?php
include('../../settings/settings.php');
include('../../helpers/helper.php');

	
	$objSession = new Session();
	$objSession->checkSession(TREACHER_ROLE,SITE_ROOT.'school/');
	
	$objDb = new Database();
	$objDb->connect();
	$objHomeworkFile 	= new SchoolHomeworkFile ();	 // change this object according to ur need
	
	$file_id = isset($_GET["id"])?intval($_GET["id"]):"";



	$sql = $objHomeworkFile->PopulateGrid("*", " AND id = ".$file_id);
	$file_Array = $objDb->getArraySingle($sql);




		$path	= ADMIN_PREFIX.$file_Array['files'];	

		$basename = basename($path);
		 
		$fileExt = hlpGetExtension($basename);
if(!empty($basename))
{
	if(file_exists($path))
	{
		header('Content-type: text/plain');
		header('Content-disposition: attachment; filename=' . preg_replace('/[^A-Za-z0-9]/', '_', $file_Array["name"]).".".$fileExt); 
		readfile($path);
	}
	else
	{
		echo "<h1>404 Page</h1>";
		echo "<p>The page you are looking for is no longer exists on this server.</p>";
		exit;
	}
	
}
else
{
	echo "<h1>404 Page</h1>";
	echo "<p>The page you are looking for is no longer exists on this server.</p>";
	exit;
}
?>