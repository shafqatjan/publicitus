<?php 
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE,'index.php');
 
$objDb = new Database();
$objDb->connect();

$objMediaType = new MediaType();

$error      	 = ""; 
$title		 = "";
$status		 	 = "";
$noOfStudents 	 = "";
$frm_tbl_width 	 = "400";

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

$link_URL = "mediatype-manage.php?start=".$start;
$_pageurl = "mediatype-manage.php";

if((!empty($_order)) and (!empty($_field)))
{
	$qry = "order by ".$_field." ".$_order;		
	$_pageurl .= "?sort=".$_order."&field=".$_field."";	
}
else 
{
	$qry = "order by id desc";		
}


if($act == "del" && $delid)
{ 
	$objMediaType->id = $delid;
	$sql = $objMediaType->Delete();

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
	$objMediaType->id = $editid; 
	$objMediaType->status = $status;	
   	$sql = $objMediaType->StatusUpdate();
		
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
if($act == "edit" && $editid)
{
	$sql = $objMediaType->PopulateGrid("*"," AND id = ".$editid);
	$editArray = $objDb->getArraySingle($sql);
 	//printArray($editArray);exit;
	$title = !empty($editArray['title'])? hlpHtmlSlashes($editArray['title']):"";
	$status = !empty($editArray['status'])?intval($editArray['status']):"";	
}

if(isset($_POST['btn_save']))
{
	//printArray($_POST);printArray($_FILES);exit;
	$title = !empty($_POST['title'])?$_POST['title']:"";
	$status = intval(!empty($_POST['status']))?$_POST['status']:"1";	
	$hdnid = intval(!empty($_POST['hdnid'])?$_POST['hdnid']:"");
	
	
	$objMediaType->title = $title;
	$objMediaType->status = $status;	
	$objMediaType->id = $hdnid;
		
		
	$error .= $objMediaType->validate();
	if(!$error)	
	{
		if($objMediaType->id)
			  $sqlusername = $objMediaType->PopulateGrid("1", " AND title = '".$objMediaType->title."' AND id !=".$objMediaType->id);
		 else 
			  $sqlusername = $objMediaType->PopulateGrid("1", " AND title ='".$objMediaType->title."'");
			  
		if($objDb->query($sqlusername) && $objDb->get_num_rows()>0)
			$error .= "&nbsp;&bull;&nbsp;FAQ Title already exists.<br>";
		
		
	
		if(!$error)
		{
			if($objMediaType->id)
				$sql = $objMediaType->Update();
			else
				$sql = $objMediaType->Add();
	
			//echo $sql;		exit;
				
			if($objDb->execute($sql))
			{
				if($objMediaType->id)
				{
					$objDb->close();				
					$objSession->setSessMsg("Record has been Updated successfully.");
					$objSession->redirectTo($link_URL);
				}
				else
				{
					$lastId = $objDb->insert_id();
					$objDb->close();				
					$objSession->setSessMsg("Record has been added successfully.");
					$objSession->redirectTo($link_URL);
				}
			}
			else
				$error = "&nbsp;&bull;&nbsp;Invalid error occured, please try again.";
		
		}
	}
}

$total = $objDb->GetCountSql($objMediaType->table); 

$paginate = new Paginate($page_limit, $total, $_pageurl, $max);
$paging   = $paginate->displayUl();
$page 	  = $paginate->currentPage;
	
$paginate->start = $paginate->start - 1;
if($paginate->start<=0)
{
	$paginate->start=0;
}
 
$sql = $objMediaType->PopulateGrid("*",$qry);  
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
<link rel="stylesheet" href="../plugin/jBread/Styles/BreadCrumb.css" type="text/css">
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
                  <td colspan="2" align="left" class="mainhead">Manage Media Type</td>
                </tr>
                <tr>
                  <td colspan="3"><div class="breadCrumbHolder module">
                      <div class="breadCrumb module">
                        <ul>
                          <li class="Verdana_Bold_11_Link"> <a href="main.php">Home</a> </li>
                          <li>Manage Media Type</li>
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
                  <td colspan="2"><?php
                 
				  ?>
                    <form method="post" enctype="multipart/form-data">
                      <table width="<?php echo $frm_tbl_width;?>" cellpadding="3" cellspacing="0" align="center" border="0">
                        <tr>
                          <td width="83" nowrap class="Verdana_Black_11">Title*</td>
                          <td width="9" class="Verdana_Black_11">:</td>
                          <td width="487" class="Verdana_Black_11"><input type="text" name="title" id="title" class="txtin" value="<?php echo $title; ?>" /></td>
                        </tr>
                        
                        <tr>
                          <td class="Verdana_Black_11">Status</td>
                          <td class="Verdana_Black_11">:</td>
                          <td class="Verdana_Black_11"><select name="status" class="txtin">
                              <option value="0" <?php if($status==0 or empty($status)){echo 'selected';}?>>Select Status</option>
                              <option value="1" <?php if($status==1){echo 'selected';}?>>Active</option>
                              <option value="2" <?php if($status==2){echo 'selected';}?>>Inactive</option>
                            </select></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left"><input type="submit" value="Save" name="btn_save" id="btn_save" class="button"  />
                            <?php
										if($editid)
										{
										?>
                            <input type="button" value="Cancel" name="btn_cancel" id="btn_cancel" class="button" onClick="window.location='<?php echo $link_URL;?>'" />
                            <input type="hidden" name="hdnid" id="hdnid" value="<?php echo $editid ?>" />
                            <?php
										 }
										 ?></td>
                        </tr>
                      </table>
                    </form>
                    <?php
				  
					?></td>
                </tr>
                <tr>
                  <td width="70%" align="right" class="Verdana_Bold_11_Link">&nbsp;</td>
                  <td width="30%" align="right" class="Verdana_Bold_11_Link"><a title="Active"><img src="../images/active.gif">Active Media Type</a> <a title="Active"><img src="../images/inactive.gif">Inactive Media Type</a>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2"><!--CONTENTS TABLE-->
                    
                    <table cellpadding="4" cellspacing="0" width="99%" align="center">
                      <tr>
                        <td width="22%" class="content_table_head_td" >Title&nbsp; <a href="<?php echo $link_URL;?>&sort=desc&field=title"><img src="../images/up.png" height="8" border="0" /></a> <a href="<?php echo $link_URL;?>&sort=asc&field=title"><img src="../images/down.png" height="8" border="0"/></a></td>
                        <td width="14%" class="content_table_head_td" align="center">Status</td>
                        <td width="10%" class="content_table_head_td" align="center">Dated</td>
                        <td width="15%" class="content_table_head_td" align="center">Action</td>
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
                        <td valign="top" class="content_table_data_td_border_lrb"><?php echo hlpHtmlSlashes($Data_Row['title']); ?>&nbsp;</td>
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
                        <td align="center" valign="top" class="content_table_data_td_border_lrb"><a href="<?php echo $link_URL?>&act=edit&editid=<?php echo $Data_Row['id']; ?>" title="Edit"><img src="../images/pencil.gif" height="16" width="16" border="0" /></a> | <a href="<?php echo $link_URL?>&act=del&delid=<?php echo $Data_Row['id']; ?>" title="Delete" onClick="return callDel('Are you sure to delete this record?');"> <img src="../images/delete.gif" width="16" height="16" border="0" /></a></td>
                      </tr>
                      <?php
										}
if($paging)
										{
										?>
                      <tr>
                        <td colspan="5" class="paginationClass" align="center"><span><?php echo $paging; ?></span></td>
                      </tr>
                      <?php
										}
									}
									else
									{
										?>
                      <tr>
                        <td colspan="5" class="content_table_data_td_border_lrb">Record not found.</td>
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

<?php
$objDb->close();
?>