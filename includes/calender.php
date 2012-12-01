<div class="right-sec" >
       <div class="sec">
          <div class="heading1"> <?php echo $calendarManue;?> </div>
             <div class="fields">
<?php

function checkAvailabilty($arr,$chdate)
{

		//echo '<pre>';print_r($arr);
	$rtn =0;
	for($i=0; $i<count($arr); )
	{
		//echo $i.'<br>';
		//echo $arr[$i]['dated'].'=='.$chdate.'<br>';
		//echo in_array($chdate,$arr[$i]);
		if(in_array($chdate,$arr[$i]))
		{
			$rtn = 1;
			break;
		}
			   
		   $i=$i+1;
		}
	
		return $rtn;
}

	$m=intval(($_GET['month']));
	$y=intval(($_GET['year']));	
	
	if ($m>0)
	{
		if($m>12 or $m<=0)
		{
			 $month = date("n");		
			 $month = date("Y");					 
		}
		else
		{
			$month = $m;
			$year = $y;			
		}
	}
	else
	{
		 $month = date("n");
		 $year = date("Y");		 
	}
	
function cal($month1,$year1,$vid,$avalArr)
{ 	
	global $mth,$week,$m,$d,$y,$weekstartday;
	
	$askedmonth = $mth[$month1];
	$askedyear  = $year1;
	$firstday   = date ("w", mktime(12,0,0,$month1,1,$year1));
	$firstday;
	
	$d=date('d');
	$m=date('m');
	$y=date('Y');
	
	if($month1=="1" || $month1=='01')
	{
		$mon_msg="January";	
	}
	else if($month1=="2" || $month1=='02')
	{
		$mon_msg="Febuary";	
	}
	else if($month1=="3" || $month1=='03')
	{
		$mon_msg="March";	
	}
	else if($month1=="4" || $month1=='04')
	{
		$mon_msg="April";	
	}
	else if($month1=="5" || $month1=='05')
	{
		$mon_msg="May";	
	}
	else if($month1=="6" || $month1=='06')
	{
		$mon_msg="June";	
	}
	else if($month1=="7" || $month1=='07')
	{
		$mon_msg="July";	
	}
	else if($month1=="8" || $month1=='08')
	{
		$mon_msg="August";	
	}
	else if($month1=="9" || $month1=='09')
	{
		$mon_msg="September";	
	}
	else if($month1=="10" )
	{
		$mon_msg="October";	
	}
	else if($month1=="11" || $month1=='11')
	{
		$mon_msg="November";	
	}
	else if($month1=="12" || $month1=='12')
	{
		$mon_msg="December";	
	}
		
		
	$lastMonth=(date('n',mktime(12,0,0,$month1-1,1,$year1)));
	$lastYear=(date('Y',mktime(12,0,0,$month1-1,1,$year1)));		
	$lastMonthYear=date('F, Y',mktime(12,0,0,$month1-1,1,$year1));		
	$nextMonth=(date('n',mktime(12,0,0,$month1+1,1,$year1)));
	$nextYear=( date('Y',mktime(12,0,0,$month1+1,1,$year1)));
	$nextMonthYear=date('F, Y',mktime(12,0,0,$month1+1,1,$year1));				
	
	// number of days in askedmonth1
	$nr = date("t",mktime(12,0,0,$month1,1,$year1));
	$vid=($vid);
	
	echo "<form target='_parent'>
			<table width='500' align='center' style='line-height:3em;'>";
	echo "<thead>
    <tr>
		
		<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>
		 <a href='calender.php?month=".$lastMonth."&year=".$lastYear."' style='display:block;color:black;width:120px;'>".$lastMonthYear."</a>
		</th>
		<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' colspan='5' align='center'>".$mon_msg.", ".$year1."</th>
		<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>
		 <a href='calender.php?month=".$nextMonth."&year=".$nextYear."' style='display:block;color:black; width:120px;'>".$nextMonthYear."</a>
	   </th>
     </tr>
     <tr>
        	<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;' width='120'>Sunday</th>
            <th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>Monday</th>
            <th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>Tuesday</th>
            <th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>Wednesday</th>
			<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>Thursday</th>
			<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='#EEEEEE' align='center' style='width: 100px;'>Friday</th>
			<th class='fc-sun fc-widget-header fc-first' valign='middle' bgcolor='F4F4F4' align='center' style='width: 100px;'>Saturday</th>
    </tr>
    </thead>";
	echo "<tr>";

		for ($i=1;$i<=blankdays(intval($weekstartday),$firstday);$i++)
		{
			echo "<td  height='60' ";
			if (dayinweek($i) == 1)
				echo "bgcolor='F4F4F4'";
			else 
				echo "bgcolor='F4F4F4'";
			
			echo " style='border: 1px solid #CCCCCC;'>&nbsp;</td>";
		}
	
		$a=0;
		for ($i=1;$i<=$nr;$i++)
		{
			$str='';
			if($i<=9)
			{
				if($month1<=9)
					$str=$year1."-0".$month1."-".'0'.$i;
				else
					$str=$year1."-".$month1."-".'0'.$i;												
			}
			else
			{
				if($month1<=9)
					$str=$year1."-0".$month1."-".$i;
				else
					$str=$year1."-".$month1."-".$i;
			}		
			
			
			
			$statusAval = checkAvailabilty($avalArr,$str);	
           
			$class='';$sts=0;$bg='';$status=''; $statusStyle='';
			$statusStyle = "width:100px;height:20px;line-height:0px; text-align:center; margin-left:5px; padding:10px 1px 2px 1px;font-size:12px;";
			
			if($statusAval)
			{
				
				$class='sunday'; $sts=1; 
				$status='View';				
			}
			else
			{
				$class='yellow';
			}
			
			echo '<td height="60" style="text-align:center;border: 1px solid #CCCCCC;"  class="'.$class.'"';
			if ($i == $d && $month1 == $m && $year1 == $y)
			{ 
				echo "bgcolor='F4F4F4'";
			}			
			else if (date("w",mktime(0,0,0,$month1,$i,$year1))==0)
				echo "bgcolor='F4F4F4' ";
			else
				echo "bgcolor='F4F4F4'";
			
			echo ">";
			
			echo "<div class='calDay'>";
			
			if($i<=9)
			{
				$date = $year1."-".$month1."-0".$i ;
				echo '0'.$i;
			}
			else
			{
				$date = $year1."-".$month1."-".$i;
				echo $i;
			}
			echo "</div>";
			
			echo "<div class='calPlus'>";
			echo "<a href='view-calendar.php?date=".$str."' title='edit this ".$str."'>
			<img src='../images/calEdit.gif' border=0 align='left' />
			</a>";
			echo "</div>";
			
			echo "<div style='clear:both;line-height:0px;height:20px;'>&nbsp;</div>";
			
			echo "<div style='".$statusStyle."'>".$status."</div>";
			
			$date = $year1."-".$month1."-".$i;
			$event_start_date = date("Y-m-d", strtotime($i."-".$month1."-".$year1));
			$id     = 0;
			$title  = "";
			$rtnurl = "";
			echo "</td>";
			$a++;
			if(blankdays(intval($weekstartday),date("w",mktime(0,0,0,$month1,$i,$year1))) == 6) 
			{
				echo "</tr>\n\n<tr style='text-align:center'>";
				$a = 0;
			}
		}
		// ending stuff (making 'white' td's to fill table
		if ($a != 0)
		{
			  $last = 7-$a;
			  for ($i=1;$i<=$last;$i++)
				echo "<td class='light-callendar'>&nbsp;</td>";
		}
		echo "</tr>";
		echo "</table></form>"; }//function cal($month,$year)
	//  $today = date("Y-m-d"); 

$vendor_id = 1;
$sqlCal= '';//$objCalendar->PopulateGrid('dated');


//$vendor_available_array = array();//$objDb->getArray($sqlCal);
//	echo '<pre>';print_r($vendor_available_array);
cal($month,$year,$vendor_id,$catArray);
//cal(8,2011);

function dayinweek($num)
{
	while ($num>7)
		$num = $num-7 ;
  	return $num ;
}
function blankdays($wsd,$fsd)
{
  if ($wsd==$fsd)
  	return 0 ;
  else if ($wsd>$fsd)
  	return (7-$wsd+$fsd) ;
  else if ($fsd>$wsd)
  	return ($fsd-$wsd) ;
}
?>

  
  <!--footer--> 
  
  <!--//footer--> 
           

         </div>
     </div>
</div>