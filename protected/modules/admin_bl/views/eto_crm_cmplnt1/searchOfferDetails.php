<?php
echo '<div id="crmreport">
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
		<br><table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
		<tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
		<td style="width:2%;padding:4px;">Sl.No</td>
		<td style="width:15%;padding:4px;">Glusr ID</td>
		<td style="width:40%;padding:4px;">Company Name</td>
		<td style="width:15%;padding:4px;">Complained On</td>
		<td style="width:15%;padding:4px;">Updated On</td>
		<td style="width:13%;padding:4px;">Updated By</td>
		</tr>';
	$cnt = 0;
	while($rec = oci_fetch_assoc($sth))
	{
		$cnt++;
		$htmlclass = '';
// 		$glusrID = $rec['GLUSR_ID'];
		if($cnt % 2 == 0 )
		{
			echo '
		<tr class="dark fnt">';
		}
		else
		{
			echo '
		<tr class="fnt wbg">';
		}
		if(!$rec['ETO_BL_CMPLNT_UPDATED_ON'])
		{
			$rec['ETO_BL_CMPLNT_UPDATED_ON'] = '-';
		}
		if(!$rec['GL_EMP_NAME'])
		{
			$rec['GL_EMP_NAME'] = '-';
		}
		echo '
		<td style="padding:4px;">'.$cnt.'</td>
		<td style="padding:4px;"><a href="/index.php?r=admin_bl/Eto_crm_cmplnt/Index&glusrID='.$rec['GLUSR_USR_ID'].'&glusr_submit=Submit&tabselect=2">'.$rec['GLUSR_USR_ID'].'</a></td>
		<td style="padding:4px;">'.$rec['GLUSR_USR_COMPANYNAME'].'</td>
		<td style="padding:4px;">'.$rec['ETO_BL_CMPLNT_ON'].'</td>
		<td style="padding:4px;">'.$rec['ETO_BL_CMPLNT_UPDATED_ON'].'</td>
		<td style="padding:4px;">'.$rec['GL_EMP_NAME'].'</td>
		</tr>';
	}
	if($cnt == 0)
	{
		echo '<tr class="wbg"><td colspan="6" style="padding:4px;"><div align="center" style="width:98% ; border:grey solid 1px;padding:4px;margin:4px;"><font color="red">No Complaint Found for This Offer</font></div></td><tr>';
	}
	echo '</table><br><br><br>
	</div>';
	


?>