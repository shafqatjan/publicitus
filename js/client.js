// JavaScript Document
function callingImage(param,where,table,type)
{
	
	jQuery.facebox({ 
        opacity      : 0.2,
        overlay      : true,
		ajax: '../../script-includes/getImage.php?param='+param+'&where='+where+'&table='+table+'&type='+type,
		closeImage:"../facebox/closelabel.gif", 
		loadingImage : '../facebox/loading.gif'
	});
	//jQuery.fn.colorbox({inline:false, href:'testFile.php?ss=1'}); 
}

function callingFaceboxExtra(url)
{ 
	var allcheckval = '?ids=';
	canMov = 0;
	jQuery("input[name=userfile]").each(function()
	{
		if(this.checked)
		{
			allcheckval = allcheckval + this.value + ',';
			canMov = 1;
		}
	});
	//alert( url + allcheckval);
	//alert(canMov);
	if(canMov)
	{
		jQuery.facebox({ 
			opacity      : 0.2,
			overlay      : true,
			ajax:  url + allcheckval,
			closeImage:"../facebox/closelabel.gif", 
			loadingImage : '../facebox/loading.gif'
		});
	}
	else
		alert('Please select  any one image to moving into the album.');
	//jQuery.fn.colorbox({inline:false, href:'testFile.php?ss=1'}); 
}
function callingFacebox(url)
{ 

	jQuery.facebox({ 
        opacity      : 0.2,
        overlay      : true,
		ajax: url,
		closeImage:"../facebox/closelabel.gif", 
		loadingImage : '../facebox/loading.gif'
	});
	//jQuery.fn.colorbox({inline:false, href:'testFile.php?ss=1'}); 
}
function callingFaceboxImage(imgpath)
{
/*	alert(imgpath);
	jQuery.facebox({ 
		html: imgpath,
		closeImage:"facebox/closelabel.gif", 
		loadingImage : 'facebox/loading.gif'
	});*/
	jQuery('a[rel*=facebox]').facebox({closeImage:"facebox/closelabel.gif", loadingImage : 'facebox/loading.gif'});
}
function deletefunc(type)
{
	var checkedfiles = "";
	jQuery("input[name=userfile]").each(function()
	{
		if (this.checked == 1) {
			checkedfiles += (this.value + ",");
		}
	}); 
	//alert(checkedfiles);     
	if (checkedfiles !== "") {
		var con = confirm('Are you sure you want to delete these '+type);
		//alert(con);return false;
		if(con)
		{
			jQuery.ajax({
			   type		: "GET",
			   data 	: "type="+type+"&iora="+checkedfiles,
			   async	: false,
			   url 		: 'ajax/delete-image-or-album.php',
			   success 	: function(msg)
			   {
					window.location = window.location;
			   }
			});			
		}
		else
			return false;
	} else {
		alert('Please select '+type+' for delete.');
	}	
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

function setLeave(type)
{
	if(type==3)
	{
	jQuery('#leave_id').show();
	jQuery('#timeIn').hide();
	jQuery('#timeOut').hide();
	}
	
	if(type==2)
	{
	jQuery('#leave_id').hide();
	jQuery('#timeIn').hide();
	jQuery('#timeOut').hide();
	}
	
	if(type==1)
	{
	jQuery('#leave_id').hide();	
	jQuery('#timeIn').show();
	jQuery('#timeOut').show();
	}
}


function showDates(type)
{
	if(type==1)
	{
	 jQuery('#present').show('slow');
	}
	
	if(type==2)
	{
	 jQuery('#absent').show('slow');

	}
	
	if(type==3)
	{
		jQuery('#leave').show('slow');
	}
	
	if(type==4)
	{
		jQuery('#late').show('slow');
	}
}

	
function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements;
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	alert(countCheckBoxes);
	
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

function toggleChecked(status) {
	$(".checkall").each( function() {
		$(this).attr("checked",status);
	})
}

function validateChecked() 
{
	var errNo = 0;
	$(".checkall").each( function() 
	{
		if($(this).is(':checked'))
		{
			errNo = 1;
		}
	})
	if(errNo)
	{
		var myVar = callDel('Are you sure to Confirm selected student?');
		if(myVar)
			return true;
		else
			return false;
	}
	else
	{
		$('#all_msg').html('You must select one of them.')
		$('#message-error').show();
		var targetOffset = jQuery('.heading1').offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
		return false;
	}
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


