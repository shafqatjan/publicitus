// JavaScript Document
function callDel(argMsg)
{
	if(!argMsg)
		argMsg = 'Are you sure to delete this record?';
		
	return confirm(argMsg);
}
