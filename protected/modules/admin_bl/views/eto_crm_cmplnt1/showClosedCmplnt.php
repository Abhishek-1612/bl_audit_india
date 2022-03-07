<?php
$path  = $_SERVER['ADMIN_URL'];
echo ' <br><div id="crmreport">
	<style>
	.dark{
	background : #eefaff;
	}
	.fnt
	{
	font-size:12px;
	width:33%;
	height:15px;
	}
	</style>
	<br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="1" width="98%" align="center">
	<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
	<td style="width:2%;padding:4px;">Sl.No</td>
	<td style="width:10%;padding:4px;">Glusr ID</td>
	<td style="width:10%;padding:4px;">Offer ID</td>
	<td style="width:10%;padding:4px;">Complaint ID</td>
	<td style="width:8%;padding:4px;">Credits used</td>
	<td style="width:25%;padding:4px;">Agent Remarks</td>
	<td style="width:15%;padding:4px;">Disposition</td>
	<td style="width:10%;padding:4px;">Closed By</td>
	<td style="width:10%;padding:4px;">Update</td>
	</tr>';
	
	$cnt = 0;
	while($rec = oci_fetch_assoc($sth))
	{
		 $id = $rec['ETO_BL_CMPLNT_ID'];
		 $emp_remarks = $rec['ETO_BL_CMPLNT_EMP_REMARKS'];
		 $close_by = $rec['GL_EMP_NAME'];
		 $offerID = $rec['FK_ETO_OFR_ID'];
		 $glusrID = $rec['FK_GLUSR_USR_ID'];
		 $disposition = $rec['DISPOSITION'];
		 $complaint_no = isset($rec['FK_COMPLAINT_ID']) ? $rec['FK_COMPLAINT_ID'] : '-';
		 $credit = $rec['FK_ETO_CREDITS_USED'];
		$cnt++;
		if($cnt % 2 == 0 )
		{
			echo '
		<tr class="dark fnt" id="div_closed_'.$id.'">';
		}
		else
		{
			echo '
		<tr class="fnt wbg" id="div_closed_'.$id.'">';
		}
		echo '
		
		<td style="padding:4px;">'.$cnt.'</td>
		<td style="padding:4px;">'.$glusrID.'</td>
		<td style="padding:4px;">'.$offerID.'</td>
		<td style="padding:4px;">'.$complaint_no.'</td>
		<td style="padding:4px;">'.$credit.'</td>
		<td style="padding:4px;">
		<textarea id="emp_closed_remark_'.$id.'" name="emp_closed_remark_'.$id.'" style="max-height: 50px; max-width: 645px; width: 98%; height: 50px; margin-bottom:8px; ">'.$emp_remarks.'</textarea>
		</td>
		<td style="padding:4px;">'.$disposition.'</td>
		<td style="padding:4px;">
		'.$close_by.'
		</td>
		<td style="padding:4px;">
		<input type="button" name="update_closed_'.$id.'" id="update_closed_'.$id.'" value="Update" onclick="updateClosedCmplnt('.$id.');">
		</td>
		</tr>';
	}
	if($cnt == 0)
	{
		echo '<tr class="wbg"><td colspan="9" style="padding:4px;"><div align="center" style="width:98% ; border:grey solid 1px;padding:4px;margin:4px;"><font color="red">No Closed Complaints found for QC/Review</font></div></td></tr>';
	}
	echo '</table><br><br><br></div>';
	
	

?>