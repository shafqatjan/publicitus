// JavaScript Document
function callingImage(param,where,table,type)
{
	
	$.facebox({ 
        opacity      : 0.2,
        overlay      : true,
		ajax: '../../script-includes/getImage.php?param='+param+'&where='+where+'&table='+table+'&type='+type,
		closeImage:"../facebox/closelabel.gif", 
		loadingImage : '../facebox/loading.gif'
	});
	//$.fn.colorbox({inline:false, href:'testFile.php?ss=1'}); 
}
function callingFacebox(url)
{
	$.facebox({ 
        opacity      : 0.2,
        overlay      : true,
		ajax: url,
		closeImage:"../facebox/closelabel.gif", 
		loadingImage : '../facebox/loading.gif'
	});
	//$.fn.colorbox({inline:false, href:'testFile.php?ss=1'}); 
}
function callingRoleSubCat()
{
	var roleCatId=jQuery("#roleCatId").val();
	param =  "act=callingGetRoleSubCat&roleCatId="+roleCatId;
	jQuery('#roleSubCatDropDiv').html('');	
	jQuery.ajax({
			   type		: "GET",
			   data 	: param,
			   async	: false,
			   url 		: '../ajax/action.php',
			   success 	: function(msg)
			   {
					jQuery('#roleSubCatDropDiv').html(msg);
			   }
		});
}
function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements;
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	
	if(document.forms[FormName].elements['chkAll'].checked)
		CheckValue = true;
	else
		CheckValue = false;
	
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}
function callRow(val)
{
	if(val==1)
	{
		jQuery('#bannerRow').show();		
		jQuery('#comercialRow').hide();
		jQuery('#gadsenseRow').hide();			
	}
	if(val==2)
	{
		jQuery('#bannerRow').hide();		
		jQuery('#comercialRow').show();
		jQuery('#gadsenseRow').hide();			
	}
	if(val==3)
	{
		jQuery('#bannerRow').hide();		
		jQuery('#comercialRow').hide();
		jQuery('#gadsenseRow').show();			
	}
}
function displayVals() 
{
	var type=jQuery("#type").val();
	param =  "act=callingGetStdTeach&type="+type;
	jQuery('#roletypeDiv').html('');	
	jQuery.ajax({
			   type		: "GET",
			   data 	: param,
			   async	: false,
			   url 		: '../../ajax/action.php',
			   success 	: function(msg)
			   {
					jQuery('#roletypeDiv').html(msg);
			   }
		});	
}


function getStudents()
{
	var id=jQuery('#class').val();
	var dataString = 'id='+ id;
	jQuery.ajax
	({
		type: "POST",
		url: "../../ajax/getStudents.php",
		data: dataString,
		cache: false,
		 
		success: function(html)
		{
		 
			jQuery("#student").html(html);
		} 
	});
}

function SgetStudents()
{
	
	var id=jQuery('#class').val();
	var dataString = 'id='+ id;
	jQuery.ajax
	({
		type: "POST",
		url: "../ajax/getStudents.php",
		data: dataString,
		cache: false,
		 
		success: function(html)
		{
		 
			jQuery("#student").html(html);
		} 
	});
}
function getType()
{
	jQuery('#typeIdTitleDiv').html('');
	jQuery('#typeIdDiv').html('');	
	var type=jQuery('#type').val();

	if(type==0)
		return false;
	var typeId=jQuery('#typeId').val();	
	if(type==1)
		jQuery('#typeIdTitleDiv').html('Student');
	if(type==2)
		jQuery('#typeIdTitleDiv').html('Class');
	if(type==3)
		jQuery('#typeIdTitleDiv').html('Group');				
		
	var dataString = "act=callingGetTypeId&type="+type;
	//alert(dataString);
	jQuery.ajax
	({
		type: "GET",
		url: "../../ajax/action.php",
		data: dataString,
		cache: false,
		 
		success: function(html)
		{
			//alert(html);
			jQuery("#typeIdDiv").html(html);
		} 
	});
}
function getClass(id)
{	
	var teach_id = $('#teacher_id').val();				
	//alert(teach_id);
	jQuery.ajax
	({
		type: "GET",
		url: "../../ajax/getClasses.php",
		data: { teach_id : teach_id  },
		cache: false,
		 
		success: function(html)
		{
			//alert(html);		
			jQuery("#class_id").html(html);
		} 
	});
}		

function getSub(id)
{	
	var class_id = $('#class_id').val();				
	//alert(class_id);
	jQuery.ajax
	({
		type: "GET",
		url: "../../ajax/getSubjects.php",
		data: { class_id : class_id  },
		cache: false,
		 
		success: function(html)
		{
			//alert(html);		
			jQuery("#subject_id").html(html);
		} 
	});
}		
