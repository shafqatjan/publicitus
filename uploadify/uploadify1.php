<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objHomeworkFile 	= new SchoolHomeworkFile ();	
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/schoolapp/sitedata/homework_files/reply_files'; // Relative to the root
$homework	= 	intval(isset($_GET['ahomework'])?$_GET['ahomework']:"");
//printArray($_POST);exit;
if (!empty($_FILES)) 
{
	$tempFile = $_FILES['Filedata']['tmp_name'];
	hlpMakeDir(CLIENT_PREFIX.SITEDATA_DIR);	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','doc','docx','pdf','xls','txt','php','html'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	//printArray($fileParts);

	hlpMakeDir(CLIENT_PREFIX.SITEDATA_DIR.HOMEWORK_DIR);				
	$upDir = CLIENT_PREFIX.SITEDATA_DIR.HOMEWORK_DIR.HW_REPLY_DIR;
	hlpMakeDir($upDir);		

	if (in_array($fileParts['extension'],$fileTypes)) 
	{
		$fileName = hlpUploadFile('Filedata',$upDir);
		$objHomeworkFile->type = 2;				
		$objHomeworkFile->type_id = $homework;
		$objHomeworkFile->name = $_FILES['Filedata']['name'];	
		$objHomeworkFile->status = 1;			
		$objHomeworkFile->files = SITEDATA_DIR.HOMEWORK_DIR.HW_REPLY_DIR.$fileName;		
		//echo $objHomeworkFile->Add();
		if($objDb->execute($objHomeworkFile->Add()));
			echo '1';
	}
	else 
		echo 'Invalid file type.';
}
?>