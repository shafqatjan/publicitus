<?php 
include('../settings/settings.php');
include('../helpers/helper.php');
fckInclude();
$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE);

$objDb = new Database();
$objDb->connect();


$objCms = new Cms();

$error       = ""; 
$pageid      = "";
$pagename    = "";
$pagetitle   = "";
$pagetext 	 = "";
$metadesc    = "";
$email	 	 = "";
	
$id = intval(isset($_REQUEST['id'])?$_REQUEST['id']:"");

$sql = $objCms->PopulateGrid("*"," order by page_name asc");
$cms_array = $objDb->getArray($sql);

if($id)
{
	$sql_content = $objCms->PopulateGrid("*"," AND id =".$id);
	$row_content = $objDb->getArraySingle($sql_content);
	//printArray($row_content);	
	$pageid      = !empty($row_content['id'])?$row_content['id']:"";
	$pagename    = !empty($row_content['page_name'])?$row_content['page_name']:"";
	$pagetitle   = !empty($row_content['page_title'])?$row_content['page_title']:"";
	$pagehead    = !empty($row_content['page_heading'])?$row_content['page_heading']:"";
	$metadesc    = !empty($row_content['meta_tag'])?$row_content['meta_tag']:"";
	$pagetext    = !empty($row_content['page_content'])?$row_content['page_content']:"";
	$email   	 = !empty($row_content['email'])?$row_content['email']:"";
		
	$pagename   = hlpHtmlSlashes($pagename);		
	$pagetitle  = hlpHtmlSlashes($pagetitle);		
	$metadesc   = hlpHtmlSlashes($metadesc);	
	$pagehead   = hlpHtmlSlashes($pagehead);	
	$pagetext   = hlpHtmlSlashes($pagetext);		
}

if(isset($_POST['btn_save']))
{
	//printArray($_POST);
	$pagename	= isset($_POST['pagename'])?$_POST['pagename']:"";
	$pagetitle	=	isset($_POST['pagetitle'])?$_POST['pagetitle']:"";
	$metadesc	=	isset($_POST['metadesc'])?$_POST['metadesc']:"";
	$pagehead	=	isset($_POST['pagehead'])?$_POST['pagehead']:"";
	$email		=	isset($_POST['email'])?$_POST['email']:"";
	$pagetext	=	isset($_POST['pagetext'])?$_POST['pagetext']:"";
	$pagetext   = hlpSafeString($pagetext);
			
	$objCms->id 	   = $id;
	$objCms->page_name  = $pagename;
	$objCms->page_heading  = $pagehead;
	$objCms->page_title = $pagetitle;
	$objCms->meta_tag  = $metadesc;
	$objCms->page_content  = $pagetext;
	$objCms->email	   = $email;
	
	$error = $objCms->validateCms();
	if($id==2)
	{
		if(!$email)
			$error .="&bull;&nbsp;Email ID can not be left blank.";
		else if(!hlpValidEmail($email))
			$error .="&bull;&nbsp;Invalid Email ID.";
	}
	if(empty($error))
	{		
		$sql_update = $objCms->Update();
		//echo $sql_update;exit;
		if($objDb->execute($sql_update))
		{
			$objDb->close();
			$objSession->setSessMsg("Record has been updated successfully.");
			$objSession->redirectTo("cms-manage.php?id=".$id);
		}
		else
			$error ="&nbsp;&bull;&nbsp;Internal error occured, please try again.<br>";
	}
}

?>
<html>
<head>
<title><?php echo ADMIN_PAGE_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<script language="javascript" src="../js/lib/jquery.js"></script>
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
			<td class="middlearea" valign="top">
			<table cellspacing="0" cellpadding="10" width="100%" height="100%">
				<tr>
			    	<td width="180px" valign="top" id="leftnav"><?php include("side-menu.php");?></td>
			        <td valign="top" align="center">
                    	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tbllisting">
                    	<tr>
                    	  <td align="left" class="mainhead">Change Contents</td>
                  	  	</tr>
                        <tr>
                  <td colspan="3"><div class="breadCrumbHolder module">
                      <div class="breadCrumb module">
                        <ul>
                          <li class="Verdana_Bold_11_Link"> <a href="main.php">Home</a> </li>
                          <li>Manage CMS</li>
                        </ul>
                      </div>
                    </div></td>
                </tr>
						<?php
						if($error)
						{
						?>
                    	<tr>
                    	  	<td class="error"><?php echo $error;?></td>
                   	    </tr>
                        <?php 
						}
						?>
                        <tr>
                    		<td><?php echo $objSession->getSessMsg(); ?></td>
                   	    </tr>
                        <tr>
                        	<td>
                            	
                            	<!--CONTENTS TABLE-->
                                <form method="post" name="formcms">
                                <table width="100%" cellpadding="4" cellspacing="0" align="center">
                                    <tr>
                                        <td width="10%" height="28" class="Verdana_Bold_Black_11">Page Name*</td>
                                      <td width="1%" class="Verdana_Black_11">:</td>
                                        <td width="89%">
                                        <select name="pagename" id="pagename" onChange="window.location='cms-manage.php?id='+this.value" class="txtin_full">
                                            <option value="">Select Page Name</option>
                                            <?php
											if(count($cms_array)>0)
												foreach($cms_array as $cms_row)
												{
													?>
                                                    <option value="<?php echo $cms_row['id']; ?>" <?php if($pageid == $cms_row['id']) echo 'selected'; ?>><?php echo $cms_row['page_name']; ?></option>
                                                    <?php
												}
											?>
                                        </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%" class="Verdana_Bold_Black_11">Page Title</td>
                                        <td width="1%" class="Verdana_Black_11">:</td>
                                        <td width="89%"><input type="text" name="pagetitle" id="pagetitle" class="txtin_full" value="<?php echo hlpHtmlSlashes($pagetitle);?>"></td>
                                    </tr>
                                    <tr>
                                      <td class="Verdana_Bold_Black_11">Page Heading*</td>
                                      <td class="Verdana_Black_11">:</td>
                                      <td><input type="text" name="pagehead" id="pagehead" class="txtin_full" value="<?php echo hlpHtmlSlashes($pagehead);?>" /></td>
                                    </tr>
									<?php if($id == 2)
									{
									?>
                                    <tr>
                                        <td width="10%" class="Verdana_Bold_Black_11">Email*</td>
                                        <td width="1%" class="Verdana_Black_11">:</td>
                                        <td width="89%" class="Verdana_Black_11"><input type="text" name="email" id="email" class="txtin" value="<?php echo hlpHtmlSlashes($email);?>">
                                         (Contact Us requests will be sent to this Email ID)</td>
                                    </tr>  
                                    <?php
									}
									?> 
                                                                        
                                    <tr>
                                        <td width="10%" valign="top" class="Verdana_Bold_Black_11">Page Text*</td>
                                        <td width="1%" valign="top" class="Verdana_Black_11">:</td>
                                        <td width="89%">
                                        <?php
                                            $oFCKeditor = new FCKeditor('pagetext',"custom");
                                            $oFCKeditor->BasePath = "../FCKeditor/";
                                            $oFCKeditor->Value= hlpHtmlSlashes($pagetext);
                                            $oFCKeditor->Height=350;
                                            $oFCKeditor->Width=700;
                                            $oFCKeditor->Create();
                                        ?></td>
                                    </tr>
                                     <tr>
                                      <td class="Verdana_Bold_Black_11" valign="top">Meta Tags</td>
                                      <td class="Verdana_Black_11" valign="top">:</td>
                                      <td><textarea name="metadesc" id="metadesc" class="txtin_full"  ><?php echo hlpHtmlSlashes($metadesc);?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" class="Verdana_Bold_Black_11"></td>
                                        <td width="1%" class="Verdana_Black_11"></td>
                                        <td width="89%"><input type="submit" name="btn_save"  id="btn_save" value="Save Content" class="button"></td>
                                    </tr>
                                </table>
                            </form>
                                <!--CONTENTS END-->
                              </td>
                            </tr>
                    </table>
                   </td>
			    </tr>
			</table>
            </td>
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