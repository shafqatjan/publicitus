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
function getStudents4List(val)
{
	var type = jQuery('#type').val();
	var dataString = 'type='+ type;
	//alert(type);
	if(type!='' || type!=null)
	{
		if(type==1)
		{
			jQuery('#classDiv').hide();				
			jQuery.ajax
			({
				type: "GET",
				url: "../../ajax/getClassOrGroup.php",
				data: dataString,
				cache: false,
				 
				success: function(html)
				{
					jQuery("#type_id").html(html);
				} 
			});
		}
		if(type==2)
		{
			jQuery('#classDiv').show();	
			//alert(val);
			if(val)
			{
				dataString += '&class_id='+jQuery('#class_id').val();
				//alert(dataString);
				jQuery.ajax
				({
					type: "GET",
					url: "../../ajax/getClassOrGroup.php",
					data: dataString,
					cache: false,
					 
					success: function(rtnHtml)
					{
						jQuery("#type_id").html(rtnHtml);
					} 
				});				
			}
			else
				jQuery('#classDiv').hide();	
		}
	}
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
function profileValidate(obj)
{    
	if(jQuery('#'+obj).val() == '' || jQuery('#'+obj).val() == null )   
	{ 
		jQuery('#'+obj).css("background-color","#FBE3E4"); 
		jQuery('#'+obj+'_e').html('This is a required field.');
		
	}
	if(jQuery('#'+obj).val() != '')  
	{ 
		jQuery('#'+obj).css("background-color","white"); 
		jQuery('#'+obj+'_e').html('');
	}  
}

function finalValidate()
{  
  
	var error = '';
	if(!jQuery('#f_name').val()) { error += '* First Name Required <br>'; jQuery('#f_name').css("background-color","#FBE3E4"); }
	if(!jQuery('#l_name').val()) { error += '* Last Name Required <br>'; jQuery('#l_name').css("background-color","#FBE3E4");}
	if(!jQuery('#phone').val()) { error += '* Phone Number Required <br>'; jQuery('#phone').css("background-color","#FBE3E4");}
	if(!jQuery('#country').val()) { error += '* Country Name Required <br>'; jQuery('#country').css("background-color","#FBE3E4");}
	if(!jQuery('#city').val()) { error += '* City Name Required <br>'; jQuery('#city').css("background-color","#FBE3E4");}
	if(!jQuery('#state').val()) { error += '* State Name Required <br>';jQuery('#state').css("background-color","#FBE3E4"); }
	if(!jQuery('#zip').val()) { error += '* Zip Code Required <br>'; jQuery('#zip').css("background-color","#FBE3E4");}
	if(!jQuery('#address').val()) { error += '* Address Required <br>'; jQuery('#address').css("background-color","#FBE3E4");}
	if(!jQuery('#landline').val()) { error += '* Landline Number Required <br>'; jQuery('#landline').css("background-color","#FBE3E4");}

	if(error)
	{
		jQuery('#message-error').show();
		jQuery('#all_msg').html(error);
		//alert($('#all_msg').hmtl());
		var targetOffset = jQuery('#message-error').offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
		return false;
	}
	else
	{
		return true;
	}
	
}

function scheduleValidate()
{  
 
	var error = '';
	if(!jQuery('#schedule').val()) { error += '* Please select a schedule <br>'; jQuery('#schedule').css("background-color","#FBE3E4"); }
	if(!jQuery('#dated_start').val()) { error += '* Start Date Required <br>'; jQuery('#dated_start').css("background-color","#FBE3E4");}
	if(!jQuery('#dated_end').val()) { error += '* End Date Required <br>'; jQuery('#dated_end').css("background-color","#FBE3E4");}

	if(error)
	{
		jQuery('#message-error').show();
		jQuery('#all_msg').html(error);
		//alert($('#all_msg').hmtl());
		var targetOffset = jQuery('#message-error').offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
		return false;
	}
	else
	{
		return true;
	}
	
}

function scheduleAdd()
{  
 
	var error = '';
	if(!jQuery('#subject').val()) { error += '* Please select a subject <br>'; jQuery('#subject').css("background-color","#FBE3E4"); }
	if(!jQuery('#schedule_name').val()) { error += '* Schedule Title Required <br>'; jQuery('#schedule_name').css("background-color","#FBE3E4");}
	if(!jQuery('#time_in').val()) { error += '* Time In Required <br>'; jQuery('#time_in').css("background-color","#FBE3E4");}
	if(!jQuery('#time_out').val()) { error += '* Time Out Required <br>'; jQuery('#time_out').css("background-color","#FBE3E4");}
	if(!jQuery('#dated').val()) { error += '* Date Required <br>'; jQuery('#dated').css("background-color","#FBE3E4");}

	if(error)
	{
		jQuery('#message-error').show();
		jQuery('#all_msg').html(error);
		//alert($('#all_msg').hmtl());
		var targetOffset = jQuery('#message-error').offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
		return false;
	}
	else
	{
		return true;
	}
	
}
function SubmitValidate()
{  
   
	var error = '';
	if(!jQuery('#title').val()) 
	{
	 error += '* Title Required <br>'; 
	 jQuery('#title').css("background-color","#FBE3E4"); 
	}
	if(!jQuery('#schooldate').val()) 
	{
	  error += '* Date Required <br>';
	   jQuery('#schooldate').css("background-color","#FBE3E4");
	}
	if(!jQuery('#description').val()) 
	{
	  error += '* Description Required <br>'; j
	  Query('#description').css("background-color","#FBE3E4");   
    }

	if(error)
	{
		jQuery('#message-error').show();
		jQuery('#all_msg').html(error);
		//alert($('#all_msg').hmtl());
		
		var targetOffset = jQuery('#message-error').offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
		return false;
	}
	else
	{
		return true;
	}
	
}


function finalChangePwd()
{  

	var error = '';
	if(!jQuery('#oldpassword').val()) { error = '* Old Password Required <br>'; jQuery('#oldpassword').css("background-color","#FBE3E4");}
	if(!jQuery('#newpassword').val()) { error += '* New Password Required <br>'; jQuery('#newpassword').css("background-color","#FBE3E4");}
	if(!jQuery('#confirmpassword').val()) { error += '* Confirm Password Required <br>'; jQuery('#confirmpassword').css("background-color","#FBE3E4");}
	else if(jQuery('#confirmpassword').val()!=jQuery('#newpassword').val()) 
	{ 
		error += '* Password Mismatched. <br>'; 
		jQuery('#newpassword').css("background-color","#FBE3E4");
		jQuery('#confirmpassword').css("background-color","#FBE3E4");
	}

	if(error)
	{
		jQuery('#message-error').show();
		jQuery('#all_msg').html(error);
		var targetOffset = jQuery('#message-error').offset().top;
		jQuery('html,body').animate({scrollTop: targetOffset}, 500);
		return false;
	}
	else
	{
		return true;
	}
	
}
function getSub(id)
{	
	var teach_id = $('#teacher_id').val();				
	//alert(teach_id);
	jQuery.ajax
	({
		type: "GET",
		url: "../../ajax/getSubjects.php",
		data: { teach_id : teach_id  },
		cache: false,
		 
		success: function(html)
		{
			//alert(html);
			jQuery("#subject_id").html(html);
		} 
	});
}
function getSubfromClass()
{	
	var class_id = $('#class_id').val();				
	//alert(teach_id);
	jQuery.ajax
	({
		type: "GET",
		url: "../../ajax/getSubjects.php",
		data: { class_id : class_id  },
		cache: false,
		 
		success: function(rtnhtml)
		{
			//alert(html);
			jQuery("#subject_id").html(rtnhtml);
		} 
	});
}
function getValuesfromlist()
{
		
}