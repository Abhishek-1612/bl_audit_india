<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<?php  
	$activityArr = $result;
	$action = $action;
	$offerID = $offerID;
	$finalActionArr = [1 => 'Lock', 2 => 'Display', 3 => 'Flagged', 4 => 'Deleted', 5 => 'Approved'];
?>
<?php
	if($action == 'show')
	{
?>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js" ></script>
<script language="javascript" type="text/javascript">
function OfferStats()
{
	var offerID = $("#offerID").val().trim();
	if(offerID == '')
	{
		alert("Please Enter Offer ID");
		return false;
	}	

	$.ajax({
                url: "index.php?r=admin_eto/AdminReport/leapactivitystats",
                type: "POST",
                data: {
                        action:'offerwise',
                        offerID:offerID
                },
                async: false,
                success:function (response) {
                        
                        $("#resultDiv").html(response);
			$("#resultDiv").show();
		},
		beforeSend: function(){
			$("#resultDiv").hide();
			$("#resultDivDetail").hide();
			$("#resultDiv").html("<img src='/public/images/spinner.gif'>");
		},
	});

}

function offerDetail(offerID)
{
	if(offerID == '')
	{
		alert("Please Enter Offer ID");
		return false;
	}	

	$.ajax({
                url: "index.php?r=admin_eto/AdminReport/leapactivitystats",
                type: "POST",
                data: {
                        action:'offerdetail',
                        offerID:offerID
                },
                async: false,
                success:function (response) {
                        
                        $("#resultDivDetail").html(response);
			$("#resultDivDetail").show();
		},
		beforeSend: function(){
			$("#resultDivDetail").hide();
			$("#resultDivDetail").html("<img src='/public/images/spinner.gif'>");
		},
	});

}
</script>

</head>
<body>
   
<div>
<table style="border-collapse:collapse;font-family:arial;font-size:12px" border="1" cellpadding="4" cellspacing="0" width="100%" align="center">
<tbody>
<form name="leapactivityForm" id="leapactivityForm" method="post">
<input type="hidden" name="action" id="action">
<tr>
	<td align="center" bgcolor="#dff8ff" width="10%"><strong>Offer ID</strong></td> 
	<td align="center" bgcolor="#dff8ff" width="10%">
	<input type="text" name="offerID" id="offerID">
	</td>
	<td width="10%" align="center" bgcolor="#dff8ff">
	<input type="button" name="offerGo" id="offerGo" value="Go" onclick="OfferStats();">
	</td>
	<td align="center" bgcolor="#dff8ff" width="10%"> </td>
	<td align="center" bgcolor="#dff8ff" width="10%"><strong>From Time</strong></td>
	<td align="center" bgcolor="#dff8ff" width="10%"> </td>
	<td align="center" bgcolor="#dff8ff" width="10%"><a><strong>To Time</strong></a></td>	
	<td align="center" bgcolor="#dff8ff" width="10%"></td>
	<td align="center" bgcolor="#dff8ff" width="10%">
	<input type="button" name="Go" id="Go" value="Go" onclick="DateStats();">
	</td>
</tr> 
</form>
</tbody>
</table>
<div id="resultDiv" name="resultDiv" style="display:none"></div>
<div id="resultDivDetail" name="resultDivDetail" style="display:none"></div>
</div>
</body></html>
<?php
	}
	else if($action == 'offerwise')
	{
?>
<div style="clear:both;padding-top:10px;"></div>
<table width="100%" cellspacing="0" cellpadding="4" border="1" align="center" style="border-collapse:collapse;font-family:arial;font-size:12px">
<tbody>   
<tr>
	<td align="center"  bgcolor="#dff8ff" height="20"></td> 	
	<td align="center" bgcolor="#dff8ff" height="20" colspan="2"><strong>Flagged Once</strong></td>
	<td align="center" bgcolor="#dff8ff" colspan="2" height="20"><strong>Flagged Twice</strong></td>
	<td align="center" bgcolor="#dff8ff" colspan="2" height="20"><strong>Flagged Trice</strong></td> 
        <td align="center" bgcolor="#dff8ff" colspan="2" height="20"><strong>Final Action</strong></td>	
</tr>            
            
<tr>
	<td align="center"  height="20">Display ID</td>	
	<td align="center"  height="20">Lock Time</td>
	<td align="center"  height="20">Display Time</td>
	<td align="center"  height="20">Lock Time</td>
	<td align="center"  height="20">Display Time</td>
	<td align="center"  height="20">Lock Time</td>
	<td align="center"  height="20">Display Time</td>
	<td align="center"  height="20">Action Taken</td>	
	<td align="center"  height="20">Action Time</td>

</tr> 
<?php		

	$firstLockTime = isset($activityArr['recStats']['FIRST_LOCK_DATE']) ? $activityArr['recStats']['FIRST_LOCK_DATE'] : '';
	$firstDispTime = isset($activityArr['recStats']['FIRST_DISPLAY_DATE']) ? $activityArr['recStats']['FIRST_DISPLAY_DATE'] : '';
	$secLockTime = isset($activityArr['recStats']['SECOND_LOCK_DATE']) ? $activityArr['recStats']['SECOND_LOCK_DATE'] : '';
	$secDispTime = isset($activityArr['recStats']['SECOND_DISPLAY_DATE']) ? $activityArr['recStats']['SECOND_DISPLAY_DATE'] : '';
	$thirdLockTime = isset($activityArr['recStats']['LAST_LOCK_DATE']) ? $activityArr['recStats']['LAST_LOCK_DATE'] : '';		
	$thirdDispTime = isset($activityArr['recStats']['LAST_DISPLAY_DATE']) ? $activityArr['recStats']['LAST_DISPLAY_DATE'] : '';
	$finalAction = isset($activityArr['recStats']['ACTION_TAKEN']) ? $finalActionArr[$activityArr['recStats']['ACTION_TAKEN']] : '';
	$finalActionTime = isset($activityArr['recStats']['ACTION_DATE']) ? $activityArr['recStats']['ACTION_DATE'] : '';
?>
<tr>
	<td align="center"  height="20"> <a onclick="offerDetail(<?php echo $offerID ?>)" href="javascript:void(0);"><?php echo $offerID; ?></a></td>	
	<td align="center"  height="20"><?php echo $firstLockTime; ?></td>
	<td align="center"  height="20"><?php echo $firstDispTime; ?> </td>
	<td align="center"  height="20"><?php echo $secLockTime; ?></td>
	<td align="center"  height="20"><?php echo $secDispTime; ?></td>
	<td align="center"  height="20"><?php echo $thirdLockTime; ?></td>
	<td align="center"  height="20"><?php echo $thirdDispTime; ?></td>
	<td align="center"  height="20"><?php echo $finalAction; ?></td>	
	<td align="center"  height="20"><?php echo $finalActionTime; ?></td>
</tr>          
				 
</tbody></table>
<?php	
}
	else if($action == 'offerdetail')
	{
?>
<div style="clear:both;padding-top:30px;"></div>
<table width="100%" cellspacing="0" cellpadding="4" border="1" align="center" style="border-collapse:collapse;font-family:arial;font-size:12px">
<tbody>   
<tr>
	<td align="center"  bgcolor="#dff8ff" height="20"><strong>Employee ID</strong></td>
	<td align="center"  bgcolor="#dff8ff" height="20"><strong>Action Time</strong></td>
	<td align="center"  bgcolor="#dff8ff" height="20"><strong>Action</strong></td>
</tr>            

<?php
	$offerDetails = array();
	$offerDetails = $activityArr['recStats'];
	
	foreach($offerDetails as $k=>$row)
	{
	    $empid = isset($row['FK_EMPLOYEE_ID']) ? $row['FK_EMPLOYEE_ID'] : '';
	    $actionTime = isset($row['ACTIVITY_DATE_TIME']) ? $row['ACTIVITY_DATE_TIME'] : '';
	    $action = isset($row['ACTION']) ? $finalActionArr[$row['ACTION']] : '';
?>
<tr>
	<td align="center"  height="20"> <?php echo $empid; ?></td>	
	<td align="center"  height="20"><?php echo $actionTime; ?></td>
	<td align="center"  height="20"><?php echo $action; ?> </td>
</tr> 
<?php  
	}
?>

</tbody></table>
<?php	
}
?>
