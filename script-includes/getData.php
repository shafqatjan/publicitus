<?php 
include('../settings/settings.php');
include('../helpers/helper.php');
$objDb = new Database();
$objDb->connect();
$param = isset($_GET['param'])?$_GET['param']:'';
$where = isset($_GET['where'])?$_GET['where']:'';
$type = isset($_GET['type'])?$_GET['type']:'';

//printArray($_GET);exit;
if($param!='' and $where!='' )
{
	$qry = 'SELECT '.$param.' FROM '.TBL_USER_IMAGES.' WHERE id='.$where;
	$fileArray = $objDb->getArraySingle($qry);
	//printArray($fileArray);//exit;
	//echo $fileArray[$param];
	if($type==1)
	{
		if(!empty($fileArray[$param]) and file_exists(ADMIN_PREFIX.$fileArray[$param]))
		{
		?>
			<div style="margin:5px">
			<img src="<?php echo ADMIN_PREFIX.$fileArray[$param];?>"/>
			</div>
		<?php
		}
		else
		{
		?>
			<div style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:20px;">Image not found.</div>
		<?php
		}
	}
	else if($type == 2)
		echo $link1 = SITE_ROOT.$fileArray['image'];
	else if($type == 4)
	    echo $thbforforum = "[URL=".SITE_ROOT.$fileArray['image']."][IMG]".SITE_ROOT.$fileArray['image']."[/IMG][/URL]" ;
	else if($type ==3)
	    echo $thbforwebsite = "&lt;a href=&quot;".SITE_ROOT.$fileArray['image']."&quot;&gt;&lt;img src=&quot;".SITE_ROOT.$fileArray['image']."&quot; alt=&quot;".$fileArray['image']."&quot; border=&quot;0&quot;/&gt;&lt;/a&gt;";
	elseif($type == 5)
		echo $urllinkforforum = "[URL]".SITE_ROOT.$fileArray['image']."[/URL]";
}
else
{
?>
	<div style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:20px;"><?php echo $invalidAccessMenu?></div>
<?php
}
?>