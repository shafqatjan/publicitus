<?php 
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE,'index.php');
 
$objDb = new Database();
$objDb->connect();

$objUsers = new User();

$error      	 = ""; 
$status		 	 = "";
$frm_tbl_width 	 = "400";
$user_type       =   MEDIA;


$paging 	 = "";
$max		 = 10;
$page_limit  = 10;
$total 		 = 0;

$start 	= intval(isset($_GET['start'])?$_GET['start']:"");
$act 	= isset($_GET['act'])?$_GET['act']:"";
$delid 	= intval($_GET['delid']?$_GET['delid']:"");
$editid = intval(isset($_GET['editid'])?$_GET['editid']:"");
$status = intval($_GET['status'])?$_GET['status']:"2";
$_order		= isset($_GET['sort'])?$_GET['sort']:"";
$_field		= isset($_GET['field'])?$_GET['field']:"";

$link_URL = "media-manage.php?start=".$start;
$_pageurl = "media-manage.php";
$qry = " and user_type = ".$user_type;
if((!empty($_order)) and (!empty($_field)))
{
	$qry .= " order by ".$_field." ".$_order;		
	$_pageurl .= "?sort=".$_order."&field=".$_field."";	
}
else 
{
	$qry .= " order by id desc";		
}


$_SESSION['backUrlUser'] = basename($_SERVER['REQUEST_URI']);

if($act == "del" && $delid)
{ 
	//echo $delid;

	//$sql = $objUsers->PopulateGrid("*"," AND id = ".$delid);
	//$editArray = $objDb->getArraySingle($sql);
	//echo '<pre>'; print_r($editArray); exit;
	//@unlink(ADMIN_PREFIX.ADMIN_PREFIX.SITEDATA_DIR.NEWS_DIR.$editArray['thumb']);		
	//@unlink(ADMIN_PREFIX.ADMIN_PREFIX.SITEDATA_DIR.NEWS_DIR.$editArray['image']);
//	printArray($_GET);
	$objUsers->id = $delid;
	$sql = $objUsers->Delete();

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
	$objUsers->id = $editid; 
	$objUsers->status = $status;	
   	$sql = $objUsers->UpdateStatus();
		
	if($objDb->execute($sql))
	{
		$objDb->close();
			
		$objSession->setSessMsg("Status has been updated successfully.");
		$objSession->redirectTo($link_URL);
	}
	else
		$error = "&nbsp;&bull;&nbsp;Invalid error occured, please try again.";
}
	$user_name = "";
	$password = "";	
	$status = "";	
	$email = "";

$total = $objDb->GetCountSql($objUsers->table,$qry); 

$paginate = new Paginate($page_limit, $total, $_pageurl, $max);
$paging   = $paginate->displayUl();
$page 	  = $paginate->currentPage;
	
$paginate->start = $paginate->start - 1;
if($paginate->start<=0)
	$paginate->start=0;
 
$sql = $objUsers->PopulateGrid("*",$qry);  
$sql .= " LIMIT $paginate->start,$paginate->limit ;";

$Data_Array = array();
if($objDb->query($sql) and $objDb->get_num_rows()>0)
{
	while($Temp_Row = $objDb->fetch_row_assoc())
	{
		array_push($Data_Array,$Temp_Row);
	}
}
//echo '<pre>';print_r($Data_Array);exit;
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
<script language="javascript" src="../js/lib/jquery.js"></script>
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
            <td valign="top" align="center">
              <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tbllisting">
                <tr>
                  <td colspan="2" align="left" class="mainhead">Manage Media User</td>
                </tr>
                <tr>
                  <td colspan="3"><div class="breadCrumbHolder module">
                      <div class="breadCrumb module">
                        <ul>
                          <li class="Verdana_Bold_11_Link"> <a href="main.php">Home</a> </li>
                          <li>Manage  Media User</li>
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
                  <td width="76%" align="right" class="Verdana_Bold_11_Link">&nbsp;</td>
                  <td width="24%" align="right" class="Verdana_Bold_11_Link"><a title="Active"><img src="../images/active.gif">Active Users</a> <a title="Active"><img src="../images/inactive.gif">Inactive Users</a>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2"><!--CONTENTS TABLE-->
                    
                    <table cellpadding="4" cellspacing="0" width="99%" align="center">
                      <tr>
                       <!-- <td width="22%" class="content_table_head_td" >Username&nbsp; <a href="<?php echo $link_URL;?>&sort=desc&field=user_name"><img src="../images/up.png" height="8" border="0" /></a> <a href="<?php echo $link_URL;?>&sort=asc&field=user_name"><img src="../images/down.png" height="8" border="0"/></a></td> -->
                        <td width="8%" class="content_table_head_td" align="center">First Name</td>
                        <td width="8%" class="content_table_head_td" align="center">Last Name</td>						
                        <td width="15%" class="content_table_head_td" align="center">Email</td>
                        <td width="9%" class="content_table_head_td" align="center">Last Login</td>
                        <td width="14%" class="content_table_head_td" align="center">Current Login</td>
                        <td width="20%" class="content_table_head_td" align="center">Status</td>
                        <td width="14%" class="content_table_head_td" align="center">Dated</td>
                        <td width="12%" class="content_table_head_td" align="center">Action</td>
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
                        <td valign="top" class="content_table_data_td_border_lrb"><?php echo hlpHtmlSlashes($Data_Row['first_name']); ?>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lb"><?php echo hlpHtmlSlashes($Data_Row['last_name']); ?>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lb"><?php echo hlpHtmlSlashes($Data_Row['email']); ?>&nbsp;</td>						
                        <td align="center" valign="top" class="content_table_data_td_border_lrb"><?php 
						if($Data_Row['last_login']=='0000-00-00 00:00:00')
							echo 'Not Login yet!';
						else 
							echo hlpDateTimeFormat($Data_Row['last_login']); ?>&nbsp;</td>
                        <td align="center" valign="top" class="content_table_data_td_border_lrb"><?php 
						if($Data_Row['current_login']=='0000-00-00 00:00:00')
						echo 'Not Login!.';
						else
						echo hlpDateTimeFormat($Data_Row['current_login']); 
						?></td>
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
                        <td align="center" valign="top" class="content_table_data_td_border_lrb"><a href="user-media-manage.php?user=<?php echo $Data_Row['id']?>" title="Manage User Medias"><img src="../images/userexpertie.png" height="16" width="16" border="0" /></a> | <a href="<?php echo $link_URL?>&act=del&delid=<?php echo $Data_Row['id']; ?>" title="Delete" onClick="return callDel('Are you sure to delete this record?');"> <img src="../images/delete.gif" width="16" height="16" border="0" /></a></td>
                      </tr>
                      <?php
										}
if($paging)
										{
										?>
                      <tr>
                        <td colspan="8" class="paginationClass" align="center"><span><?php echo $paging; ?></span></td>
                      </tr>
                      <?php
										}
									}
									else
									{
										?>
                      <tr>
                        <td colspan="8" class="content_table_data_td_border_lrb">Record not found.</td>
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