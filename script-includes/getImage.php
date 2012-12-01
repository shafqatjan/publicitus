<?php 
include('../settings/settings.php');


$objDb = new Database();

$objDb->connect();

$param = isset($_GET['param'])?$_GET['param']:'';

$where = isset($_GET['where'])?$_GET['where']:'';

$table = isset($_GET['table'])?$_GET['table']:'';

$type = isset($_GET['type'])?$_GET['type']:'';

if($type == 2) { $img_dir = EVENTS_DIR; }
if($type == 1) { $img_dir = NEWS_DIR; }
if($type == 3) { $img_dir = LOGO_DIR; }
if($type == 4) { $img_dir = SLIDER_DIR; }

//printArray($_GET);exit;
if($param!='' and $where!='' and $table!='')
{
	$qry = 'SELECT '.$param.' FROM '.$table.' WHERE '.$where;
	$fileArray = $objDb->getArraySingle($qry);
	
	//printArray($fileArray);//exit;
	
	if(!empty($fileArray[$param]) and file_exists(ADMIN_PREFIX.$fileArray[$param]))
	{
	?>
		<div style="margin:5px">
		<img src="<?php echo ADMIN_PREFIX.ADMIN_PREFIX.$fileArray[$param];?>"/>
		</div>
	<?php
	}
	else
	{
	?>
		<div style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:20px;"><?php echo $imageNotFoundMenu?></div>
	<?php
	}
}
else
{
?>
	<div style="font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:20px;"><?php echo $invalidAccessMenu?></div>
<?php
}
?>