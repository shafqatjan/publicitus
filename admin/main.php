<?php 
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE,'index.php');
//echo $_SESSION['time'] = time(); 
//echo '<pre>';print_r($objSession);
$objDb = new Database();
$objDb->connect();
$Today = date('M d, Y',time());
?>
<html>
<head>
<title><?php echo ADMIN_PAGE_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>

<script type="text/javascript" src="../js/lib/jquery.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
</head>
<body>
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
			    		<td valign="top" width="180" id="leftnav"><?php include("side-menu.php");?></td>
			        	<td valign="top" class="welcome_text"> <?php echo $welcomeMenu.' '.$objSession->username;?> <?php echo $Today;?>
                        <div class="Verdana_Bold_Black_11" align="right"></div></td>
                        
			    	</tr>
                  
				</table>
            </td>
		</tr>
		<tr>
			<td class="footer">&nbsp;</td>
		</tr>
	</table>
</body>
</html>
<?php
$objDb->close();
?>