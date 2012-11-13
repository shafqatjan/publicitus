<?php 
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE,'index.php');
 
$objDb = new Database();
$objDb->connect();

$objUsers = new User();
$objUserImages = new UserImages();

$error      	 = ""; 
$frm_tbl_width 	 = "400";

$paging 	 = "";
$max		 = 10;
$page_limit  = 10;
$total 		 = 0;

$start 	= intval(isset($_GET['start'])?$_GET['start']:"");
$act 	= isset($_GET['act'])?$_GET['act']:"";
$userId = intval($_GET['user']?$_GET['user']:"");
$delid 	= intval($_GET['delid']?$_GET['delid']:"");
$editid = intval(isset($_GET['editid'])?$_GET['editid']:"");
$status = intval($_GET['status'])?$_GET['status']:"2";
$_order		= isset($_GET['sort'])?$_GET['sort']:"";
$_field		= isset($_GET['field'])?$_GET['field']:"";

$link_URL = "user-images-manage.php?start=".$start."&user=".$userId;
$_pageurl = "user-images-manage.php?user=".$userId;

$qry = ' AND user_id='.$userId.' AND type=1 ';
if((!empty($_order)) and (!empty($_field)))
{
	$qry .= " order by ".$_field." ".$_order;		
	$_pageurl .= "&sort=".$_order."&field=".$_field."";	
}
else 
{
	$qry .= " order by id desc";		
}

$backToUser = $_SESSION['backUrlUser'];

if($act == "del" && $delid)
{
	$sql = $objUserImages->PopulateGrid("*"," AND id = ".$delid);
	$editArray = $objDb->getArraySingle($sql);
//	printArray($editArray); 	echo ADMIN_PREFIX.$editArray['thumb'];	exit;
	@unlink(ADMIN_PREFIX.$editArray['thumb']);		
	@unlink(ADMIN_PREFIX.$editArray['image']);
//	printArray($_GET);
	$objUserImages->id = $delid;
	$sql = $objUserImages->Delete();

	if($objDb->execute($sql))
	{
		$objDb->close();
			
		$objSession->setSessMsg("Record has been deleted successfully");
		$objSession->redirectTo($link_URL);
	}
	else
		$error = "&nbsp;&bull;&nbsp;Invalid error occured, please try again.";
	
}

if($act == "StatusUpdate" && $status)
{ 
	$objUserImages->id = $editid; 
	$objUserImages->status = $status;	
   	$sql = $objUserImages->UpdateStatus();
		
	if($objDb->execute($sql))
	{
		$objDb->close();
			
		$objSession->setSessMsg("Status has been updated successfully.");
		$objSession->redirectTo($link_URL);
	}
	else
		$error = "&nbsp;&bull;&nbsp;Invalid error occured, please try again.";
}

$total = $objDb->GetCountSql($objUserImages->table,$qry); 

$paginate = new Paginate($page_limit, $total, $_pageurl, $max);
$paging   = $paginate->displayUl();
$page 	  = $paginate->currentPage;
	
$paginate->start = $paginate->start - 1;
if($paginate->start<=0)
{
	$paginate->start=0;
}
 
$sql = $objUserImages->PopulateGrid("*",$qry);  
$sql .= " LIMIT $paginate->start,$paginate->limit ;";
$Data_Array = array();

if($objDb->query($sql) and $objDb->get_num_rows()>0)
{
	while($Temp_Row = $objDb->fetch_row_assoc())
	{
		array_push($Data_Array,$Temp_Row);
	}
}
//printArray($Data_Array);exit;
/** Next previous limits for pagination **/
	
$start = $paginate->start + 1;
$limit = $paginate->limit;
			
$pagError=0;
if(($start+$limit) > $total)
{
	$limit =  $total - $start;
	$pagError=1;
}


?>
<html>
<head>
<title><?php echo ADMIN_PAGE_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<link rel="stylesheet" type="text/css" href="../facebox/facebox.css"/>
<script language="javascript" src="../js/lib/jquery-1.6.4.js"></script>
<script language="javascript" src="../js/default.js"></script>
<script language="javascript" src="../js/admin.js"></script>
<script language="javascript" src="../facebox/facebox.js"></script>
<link rel="stylesheet" href="../jBread/Styles/BreadCrumb.css" type="text/css">
</head>
<body>
<div id="maincontent">
  <table cellspacing="0" cellpadding="0" class="maintbl" align="center">
    <tr>
      <td class="logo"><?php echo ADMIN_PAGE_HEADING;?></td>
    </tr>
    <tr>
      <td class="topnav" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td class="middlearea" valign="top"><table cellspacing="0" cellpadding="10" width="100%" height="100%">
          <tr>
            <td width="180px" valign="top" id="leftnav"><?php include("side-menu.php");?></td>
            <td valign="top" align="center"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="tbllisting">
                <tr>
                  <td colspan="2" align="left" class="mainhead"><?php echo $manageEventsManue;?></td>
                </tr>
                <tr>
                  <td colspan="3"><div class="breadCrumbHolder module">
                      <div class="breadCrumb module">
                        <ul>
                          <li class="Verdana_Bold_11_Link"> <a href="main.php">Home</a> </li>
                          <li class="Verdana_Bold_11_Link"> <a href="<?php echo $backToUser?>">Manage Users</a> </li>
                          <li>Manage <?php echo $Data_Array[0]['user_name'];?> Images</li>
                        </ul>
                      </div>
                    </div></td>
                </tr>
                <?php
						if($error)
						{
						?>
                <tr>
                  <td colspan="2" class="error"><?php echo $error;?></td>
                </tr>
                <?php 
						}
						?>
                <tr>
                  <td colspan="2"><?php echo $objSession->getSessMsg(); ?></td>
                </tr>
                <tr>
                  <td width="71%" align="right" class="Verdana_Bold_11_Link">&nbsp;</td>
                  <td width="29%" align="right" class="Verdana_Bold_11_Link"><a title="Active"><img src="../images/active.gif">Active Images</a> <a title="Active"><img src="../images/inactive.gif">Inactive Images</a> | <a href="<?php echo $backToUser?>">Back to user</a>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2"><!--CONTENTS TABLE-->
                    
                    <table cellpadding="4" cellspacing="0" width="99%" align="center">
                      <tr>
                        <td width="15%" class="content_table_head_td" align="center">View Image </td>
                        <td width="12%" class="content_table_head_td" align="center">Share Link</td>
                        <td width="15%" class="content_table_head_td" align="center">Thumbnail for website</td>
                        <td width="13%" class="content_table_head_td" align="center">thumbnail for forums</td>
                        <td width="11%" class="content_table_head_td" align="center">URL for forums</td>
                        <td width="15%" class="content_table_head_td" align="center">Status</td>
                        <td width="11%" class="content_table_head_td" align="center">Dated</td>
                        <td width="8%" class="content_table_head_td" align="center">Action</td>
                      </tr>
                      <?php
								if(count($Data_Array)>0)
									{
																				
										$bgColor = "";
										foreach($Data_Array as $Data_Row)
										{
											if($counter%2 == 0)
												$bgColor = CL_GRID_COLOR_1;
											else
												$bgColor = CL_GRID_COLOR_2;
											
											if($editid == $Data_Row['id'])
												$bgColor = CL_GRID_SELECTED;
											
										?>
                      <tr bgcolor="<?php echo $bgColor;?>">
                        <td align="center" valign="top" class="content_table_data_td_border_lb Verdana_Bold_11_Link"><a href="javascript:void(0)" onClick="callingFacebox('../script-includes/getData.php?param=image&where=<?php echo $Data_Row['id']?>&type=1');">Image</a>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb Verdana_Bold_11_Link"><a href="javascript:void(0)" onClick="callingFacebox('../script-includes/getData.php?param=image&where=<?php echo $Data_Row['id']?>&type=2');">View</a>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb Verdana_Bold_11_Link"><a href="javascript:void(0)" onClick="callingFacebox('../script-includes/getData.php?param=image&where=<?php echo $Data_Row['id']?>&type=3');">View</a>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb Verdana_Bold_11_Link"><a href="javascript:void(0)" onClick="callingFacebox('../script-includes/getData.php?param=image&where=<?php echo $Data_Row['id']?>&type=4');">View</a>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb Verdana_Bold_11_Link"><a href="javascript:void(0)" onClick="callingFacebox('../script-includes/getData.php?param=image&where=<?php echo $Data_Row['id']?>&type=5');">View</a>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb Verdana_Bold_11_Link"><?php 
											  	if($Data_Row['status']==1)
												{
											  ?>
                          <img src="../images/active.gif" border="0"> <a href="<?php echo $link_URL; ?>&act=StatusUpdate&editid=<?php echo $Data_Row['id']; ?>&status=2" title="Click to Inactive">(Click to Inactive)</a>
                          <?php
												}
											  	if($Data_Row['status']==2)
												{												
												?>
                          <img src="../images/inactive.gif" border="0"> <a href="<?php echo $link_URL; ?>&act=StatusUpdate&editid=<?php echo $Data_Row['id']; ?>&status=1" title="Click to Active">(Click to Active)</a>
                          <?php
												}
												?></td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb"><?php echo hlpDateTimeFormat($Data_Row['dated']); ?></td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb"><a href="<?php echo $link_URL?>&act=del&delid=<?php echo $Data_Row['id']; ?>" title="Delete" onClick="return callDel('Are you sure to delete this record?');"> <img src="../images/delete.gif" width="16" height="16" border="0" /></a></td>
                      </tr>
                      <?php
										}
if($paging)
										{
										?>
                      <tr>
                        <td colspan="9" class="paginationClass" align="center"><span><?php echo $paging; ?></span></td>
                      </tr>
                      <?php
										}
									}
									else
									{
										?>
                      <tr>
                        <td colspan="9" class="content_table_data_td_border_lrb">Record not found.</td>
                      </tr>
                      <?php
									}
								  ?>
                    </table>
                    
                    <!--CONTENTS END--></td>
                </tr>
              </table>
              <?php
			

		   ?></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td class="footer">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>
<script type="text/javascript">
			
function callCalender(field)
{ 
	new Calendar
	({ 
		inputField: field,
		dateFormat: "%Y-%m-%d",
		trigger: field,
		bottomBar: true,
		onSelect: function()
		{ 
			var date = Calendar.intToDate(this.selection.get());
			this.hide();
		}
	});
}

    </script>
<?php
$objDb->close();
?>