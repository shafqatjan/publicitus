<?php 
	/************************************************************
	SESSION ROLE CONTANTS
	/************************************************************/
	define(ADMIN_ID, 'publicitus_adminID');
	define(ADMIN_USERNAME, 'publicitus_adminUsername');
	define(ADMIN_ROLE, 'publicitus_admin');
	
	define(CLIENT_ID, 'publicitus_clientID');
	define(CLIENT_USERTYPE, 'publicitus_clientUserType');
	define(CLIENT_USERNAME, 'publicitus_clientUserName');	
	define(CLIENT_EMAIL, 'publicitus_clientEmail');	
	
	define(CLIENT_ROLE_EXPERT, 'publicitus_client_expert');	
	define(CLIENT_ROLE_MANAGER, 'publicitus_client_manager');	
	define(CLIENT_ROLE_ADVERTISER, 'publicitus_client_advertiser');	
	define(CLIENT_ROLE_MEDIA, 'publicitus_client_meida');				
	
	/************************************************************
	DATE TIME CONSTANTS
	/************************************************************/
	
	define(SERVER_DATE, 'now()');
	define(DATE_FORMAT, 'M d, Y');
	define(TIME_FORMAT, 'H:i A' );
	define(DATE_TIME_FORMAT, 'M d, Y H:i A');
	

	/************************************************************
	USER TYPE CONSTANTS
	/************************************************************/
	
	define(EXPERT, 1);
	define(PRM, 2);
	define(ADVERTISER, 3);
	define(MEDIA, 4);    // PRM => Public Relaation Manager
	

	
	/************************************************************
	GENERAL CONSTANTS
	/************************************************************/
	
	define(CURRENCY_CODE, '$');
	
	/************************************************************
	HEADINGS CONSTANTS
	/************************************************************/
	
	define(ADMIN_PAGE_TITLE, "Administration Panel");
	define(ADMIN_PAGE_HEADING, "Administration Panel");
	define(ADMIN_PAGE_FOOTER, "&copy; Website");	
	define(CLIENT_PAGE_FOOTER, "Publicitus. ALL rights reserved.");	
	define(CLIENT_PAGE_TITLE, "Publicitus");		
	/************************************************************
	GRID COLOR CONTANTS
	/************************************************************/	
	
	define(CL_GRID_COLOR_1, '#FFFFFF');
	define(CL_GRID_COLOR_2, '#EFEFEF');
	define(CL_GRID_SELECTED, '#ffff9e');
	/************************************************************
	DATEBASE CONSTANTS
	/************************************************************/
/*
	define("DB_HOST", '50.63.226.146');
	define('DB_USER', 'publicitus');
	define('DB_PASS', 'Java1234PHP');
	define('DB_NAME', 'publicitus');
*/

	
	define("DB_HOST", 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'publicitus');
	
	define("EMAIL_NO_REPLY","no-reply@publicitus.com");
	define("EMAIL_INFO","info@publicitus.com");
	define("EMAIL_SIGNATURE","Regards,<br />School Support Team<br />");
	
	
	/************************************************************
	DIRECTORIES CONSTANTS
	/************************************************************/
	define(ADMIN_PREFIX , "../");
	define(SITEDATA_DIR , "show/"); 
	define(NEWS_DIR , "news_images/");
	define(USER_IMG_DIR , "uploaded_images/");

	
	/************************************************************
	DATEBASE TABLE CONSTANTS
	/************************************************************/
	define(TBL_ADMIN,"pub_admin");
	define(TBL_CMS,"pub_cms");
	define(TBL_CAT,"pub_categories");
	define(TBL_MEDIATYPE,"pub_media_type");
	define(TBL_USER,"pub_users");
	define(TBL_USER_EXPERTISE,"pub_users_categories_map");
	define(TBL_USER_MEDIA,"pub_users_media_map");
?>