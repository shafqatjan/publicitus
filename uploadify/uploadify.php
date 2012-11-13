<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objUserImages = new UserImages();
$objSession = new Session(CLIENT_ROLE);
$objDb = new Database();
$objDb->connect();
unset($_SESSION['imgesupsess']);
$_SESSION['imgesupsess']= '';;
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
	
hlpMakeDir(BASE_PATH.SITEDATA_DIR);
$thumbnailSize = isset($_GET['size'])?$_GET['size']:'';
$userid = isset($_GET['userid'])?intval($_GET['userid']):'';
$username = isset($_GET['username'])?$_GET['username']:'';
hlpMakeDir(BASE_PATH.SITEDATA_DIR.USER_IMG_DIR);
$targetFolder = BASE_PATH.SITEDATA_DIR.USER_IMG_DIR; // Relative to the root
//printArray($_FILES);
if (count($_FILES)>0) 
{
	$tempFile = $_FILES['Filedata']['tmp_name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	//printArray($fileParts);

	if (in_array($fileParts['extension'],$fileTypes)) 
	{
		if(!empty($_FILES['Filedata']['name']))
		{
			$objImage = new SimpleImage();
			$temp = $objImage->uploadFileExt('Filedata',$targetFolder, 1, 1, $thumbnailSize, $thumbnailSize, 0,315,265);			

			$remVal = ' value ';
			$imagName = SITEDATA_DIR.USER_IMG_DIR.$temp['thumb'];
			echo $_SESSION['imgesupsess'] = $_SESSION['imgesupsess'].$imagName.',';
								
			if($userid!=0 and $username!='')
				$remVal .= '("1","'.$userid.'","'.$username.'","'.$_FILES['Filedata']['name'].'","'.$imagName.'","1"),';					
			else
				$remVal .= '("'.$_FILES['Filedata']['name'].'","'.$imagName.'","1"),';					
				
			$remVal = substr($remVal,0,-1);

			if($userid!=0 and $username!='')
				$objDb->execute($objUserImages->AddMultiSessId($remVal));
			else
				$objDb->execute($objUserImages->AddMulti($remVal));

			//echo $imagName;				
		}		
	}
	else 
		echo 'Invalid file type.';
}
else
	echo 'Please select file(s).';
?>