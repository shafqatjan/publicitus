<?php
include('../settings/settings.php');
require('../helpers/helper.php');


$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE,'index.php');

$objDb = new Database();
$objDb->connect();
$objGroupStudent = new SchoolGroupStudent();
$objStudent = new SchoolStudentProfile();

////////////////////GET FROM URL////////////////////////
$id = isset($_GET['id'])?$_GET['id']:""; 

////////////////LISTING////////////////////////////////
if($id)
{
	
	 	 $studentQuery =  $objStudent->PopulateGrid('*',' AND student_id IN ('.$objGroupStudent->PopulateGrid("student_id","  AND group_id =".$id).')');
		
		$studentArray = $objDb->getArray($studentQuery);
		
}
?>

<style>
.main td {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color: #393939;
	line-height:18px;
	position:relative;
	border:3px solid rgba(0, 0, 0, 0);
	padding:2px !important;
	border-radius:5px;/* 	-moz-box-shadow:0 0 18px rgba(0,0,0,0.4);
  	box-shadow:0 0 18px rgba(0,0,0,0.4);*/
}
.body {
	width:320px !important;
}
</style>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<div class="main">
  <?php 
	if (count($studentArray)>0)
	{ 
   ?>
  <table width="100%" cellpadding="3" cellspacing="0" align="center" border="0">
    <tr>
      <td colspan="5" class="mainhead"><?php echo $groupMenu.'&nbsp;'.$detailMEnu?></td>
    </tr>
    <tr>
        <td width="60%" >    
         <table width="114%" cellpadding="3" cellspacing="0" align="center" border="0">
         <tr>
         <td colspan="5"><?php echo $studentListMenu?></td></tr>
             <?php 
			 $counter = 1;
			 foreach($studentArray as $rowStudent){ ?>
             <tr>
                <th align="left" width="5%" class="Verdana_Bold_Black_11"><?php echo $counter?></th>
                <td width="50%" class="Verdana_Black_11"><?php echo $rowStudent['f_name'].' '.$rowStudent['l_name']; ?></td>
               
             </tr>
           
             <?php $counter++; }?>
           </table>
           </td>
     </tr>
    <tr>
      <td colspan="6" >&nbsp;</td>
    </tr>
    </table>
    <?php 
	}
	else
	   echo '<b>'.$noRecordFoundMsg.'</b>';
	?>
</div>
