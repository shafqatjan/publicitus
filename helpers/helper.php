<?php
function hlpHtmlSlashes($str)
{
	return htmlspecialchars_decode(stripcslashes($str));
}
function hlpStripTags($str,$tag='')
{
	if($tag!='')
		return strip_tags($str,$tag);
	else
		return strip_tags($str);
}
function hlpHtmlDecode($str)
{
	return mysql_real_escape_string($str);
}
function printArray($myArray)
{
	echo '<pre>';print_r($myArray);echo '</pre>';
}

function hlpHtmlSlashes2($str)
{
	$data = $str;
	if(is_array($data))
	{
		foreach($data as $dataKey=>$dataValue)
			$data[$dataKey] = 	htmlspecialchars_decode(stripcslashes($dataValue));	
	}
	else
		return  htmlspecialchars_decode(stripcslashes($data));
}

function hlpMysqlRealScape($str)
{
	return mysql_real_escape_string($str);
}
function HTMLChars($str)
{
	return htmlspecialchars($str);
}	
function hlpEntities($inp_Date)
{
	return htmlentities($str);
}

function hlpDateFormat($inp_Date)
{
	return date(DATE_FORMAT, strtotime($inp_Date));
}

function hlpDateTimeFormat($inp_Date)
{
 	return date(DATE_TIME_FORMAT, strtotime($inp_Date));
}

function hlpTrimValue($str)
{
	return trim($str);
}
function csvDateFormat($inp_Date)
{
	return date("d/m/Y", strtotime($inp_Date));
}

function dbDateFormat($inp_Date)
{
	return date("Y-m-d", strtotime($inp_Date));
}

function DayFormat($inp_Date)
{
	return date("l", strtotime($inp_Date));
}


function hlpTimeFormat($inp_Date)
{
	return date(TIME_FORMAT, strtotime($inp_Date));
}
	
function hlpChmod($dir, $mode)
{
	if(!$dir)
			return;
		
	if(getmyuid() == fileowner($dir))
	{
		chgrp($dir, getmygid());
		chown($dir, getmyuid());
		if($mode == 1)
			chmod($dir, 0777);
		else if($mode == 0)
			chmod($dir, 0755);
	}
}
	
function hlpIsImage($file_type, $all_image = 1)
{
	$allowedExtensions = array('.jpg' => 'image/jpg', '.pjpeg'=>'image/pjpeg', '.jpeg'=>'image/jpeg', '.gif'=>'image/gif', '.png'=>'image/png');
	
	if($all_image == 2)
		$allowedExtensions = array('.jpg' => 'image/jpg', '.pjpeg'=>'image/pjpeg', '.jpeg'=>'image/jpeg', '.gif'=>'image/gif', '.png'=>'image/png', '.bmp'=>'image/bmp');
		
	if (in_array(strtolower($file_type), $allowedExtensions))
		return 1;
	
	return 'File format is invalid. Allowed extensions are: '.strtoupper(implode(', ',array_keys($allowedExtensions)));
}

function hlpEncrypt($data)
{
	return base64_encode($data);
}
		
function hlpDecode($data)
{
	return base64_decode($data);
}

function hlpValidateByType($validateText, $type)
{
	switch($type)
	{
		case 'email':
			return preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/",$validateText);
		break;
		
	}	
}

function hlpSafeString($str, $type = 'char')
{
	if($type == 'int')
		return intval($str);
	
	$str = preg_replace( "#<script[^>]*>.*?</script>#is",'', trim($str));
	$str = str_replace(array("\x00", "\n", "\r", "\\", "'", "\"", "\x1a"), array("\\x00", "\\n", "\\r", "\\\\" ,"\'", "\\\"", "\\\x1a"), $str);
	
	return htmlspecialchars($str);
}

function hlpValidEmail($email)
{
	if(preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/",$email))
		return 1;
	
	return 0;
}
function hlpUploadFile($fileArrayName,$dir)	
{
	if ($_FILES[$fileArrayName]["error"] == 0)
	{
		if(is_uploaded_file($_FILES[$fileArrayName]["tmp_name"]))
		{
			$fileName = time().'_'.$_FILES[$fileArrayName]["name"];
			move_uploaded_file($_FILES[$fileArrayName]["tmp_name"],$dir.$fileName);
			return $fileName;
		}
	}
}
function hlpValidImage($arrayName,$allowExtensionArray)
{
	return 1;
	//printArray(func_get_args());
	//printArray($allowExtensionArray);
	$filename = $_FILES[$arrayName]['tmp_name'];
	//printArray(($filename));
	$m=array();

exit;
	if(function_exists("mime_content_type")) # if mime_content_type exists use it.
	{
		echo 'if';
		 $m = @mime_content_type($filename);
	}
	
	else if(function_exists(""))
	{
				echo 'else if';
		# if Pecl installed use it
		$finfo = finfo_open(FILEINFO_MIME);
		$m = finfo_file($finfo, $filename);
		finfo_close($finfo);
	}
	else
	{   
			echo 'else';
		 # if nothing left try shell
		if(strstr($_SERVER[HTTP_USER_AGENT], "Windows"))
		# Nothing to do on windows
		return ""; # Blank mime display most files correctly especially images.
		
		if(strstr($_SERVER[HTTP_USER_AGENT], "Macintosh"))
		# Correct output on macs
		$m = trim(exec('file -b --mime '.escapeshellarg($filename)));
		else
		# Regular unix systems
		$m = trim(exec('file -bi '.escapeshellarg($filename)));
	}
	//$m = explode(";", $m);
	printArray($m);exit;
	//echo '<pre>';print_r($allowExtensionArray);exit;
	if(in_array(trim($m),$allowExtensionArray))
		return 1;
	else
		return 0;	
}

function hlpMakeDir($dir, $fileName = 'index.php')
{	 
//printArray(func_get_args());
	$myData= '<style>
body{
background:#D2D2D2;
font-family: "Lucida Grande",Tahoma,Arial,Verdana,sans-serif;
font-size: 12px;
}
div {
background-color: white;
border: 3px solid #7E7E7E;
color: #757575;
display: block;
margin: 100px auto 0;
padding: 30px;
width: 550px;
}
h2 {
color: #4D9A49;
color:red;
margin: 0 0 10px;
}
</style>
<html>
<head>
<title>404 Error</title>
</head>
<body>
<div class="message">
<h2>Restricted Area: 404  Error Found. Page not found or wrong approach used</h2>
Please <a href="javascript:history.go(-1);" style="font-family:Arial, Helvetica, sans-serif;">Go Back</a> to Previous page.</div>
</body>
</html>
';
	if(!is_dir($dir))
	{
		@mkdir($dir,0777);
		$myFile = $dir.$fileName;
		$fp = fopen($myFile, 'w');
		@chmod($myFile,0777);
		fwrite($fp, $myData);
		sleep(0.5);		
	}
	else
	{
		if(!file_exists($dir.$fileName))
		{
			@chmod($dir,0777);						
			$myFile = $dir.$fileName;
			$fp = fopen($myFile, 'w');
			@chmod($myFile,0777);
			fwrite($fp, $myData);
			sleep(0.5);
		}
	}
}
function hlpGetExtension($str) 
{ 
	 $i = strrpos($str,"."); 
	 if (!$i) { return ""; }  
	 $l = strlen($str) - $i; 
	 $ext = substr($str,$i+1,$l); 
	 return $ext; 
}
function hlpGetCms($cmsArray, $pageName)
{
	$rtnCms = array();
	
	if(count($cmsArray)>0)
	{

		foreach($cmsArray as $cmsRow)
		{
			if($cmsRow['page_name']==$pageName)
			{
				array_push($rtnCms,$cmsRow);
				
			   break;
			}
		}
	}
      
	  	return $rtnCms;
	
}
function get_ip_details1 ($IP = null)
{
	$ip=$_SERVER['REMOTE_ADDR'];
	$url = "http://api.ipinfodb.com/v3/ip-city/?key=66bd90e799d7546cc1766db1833427ee343b3cc57efb31a8079ef6826da75deb&ip=".$ip;
	$dataFromFile=file_get_contents($url);
	$datafromIP=explode(';',$dataFromFile);
	return $datafromIP;
	//echo '<pre>';print_r($datafromIP);
}	



function get_ip_details ($IP = null)
{
   $country = '';
   $details = array ();
   if ($IP == null) $IP = $_SERVER['REMOTE_ADDR'];
   if (!$IP || $IP == '' || $IP == '127.0.0.1') return array ();
   $url='http://api.hostip.info/?ip='.$IP;
   $raw = file_get_contents($url);
   preg_match ('/<Hostip>(?<RawData>.*?)<\/Hostip>/imsU', $raw, $flushDetails);
   $flushDetails = $flushDetails['RawData'];
   preg_match ('/<ip>(?<ip>[0-9\.]{8,})<\/ip>/i', $flushDetails, $ip);
   $details['ip'] = $ip["ip"];
   preg_match ('/<countryName>(?<country>[A-Z]+)<\/countryName>/i', $flushDetails, $countryName);
   $details['country'] = strtolower($countryName["country"]);
   preg_match ('/<countryAbbrev>(?<countryAbbrev>[A-Z]+)<\/countryAbbrev>/i', $flushDetails, $countryAbbrev);
   $details['countryAbbrev'] = strtolower($countryAbbrev["countryAbbrev"]);
   preg_match ('/<gml:name>(?<city>[A-Z]+)<\/gml:name>/i', $flushDetails, $city);
   $details['city'] = strtolower($city["city"]);
   preg_match ('/<gml:coordinates>(?<coordinates>[0-9][0-9.,]+)<\/gml:coordinates>/i', $flushDetails, $coordinates);
   $coordinates = $coordinates["coordinates"];
   $cor = explode (',', $coordinates);
   $details['latitude'] = trim($cor[1]);
   $details['longitude'] = trim($cor[0]);
   return $details;
}	
?>