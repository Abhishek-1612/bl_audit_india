<?php
echo '<div id="crmreport">~;
		print qq~
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
		<td style="width:7%;padding:4px;">Glusr ID</td>
		<td style="width:9%;padding:4px;">Complaint ID</td>
		<td style="width:9%;padding:4px;">Closed On</td>
		<td style="width:8%;padding:4px;">Feedback Type</td>
		<td style="width:43%;padding:4px;">Comment</td>
		<td style="width:13%;padding:4px;">Employee Name (ID)</td>
                <td style="width:13%;padding:4px;">Total Leads Resolved</td>
                <td style="width:13%;padding:4px;">Credits Reversed</td>
                <td style="width:13%;padding:4px;">Credits not Reversed</td>
		</tr>';
		$cnt = 0;
	while($rec = oci_fetch_assoc($sth))
	{
		$htmlclass = '';
		$glusrID = $rec['GLUSR_ID'];
		$fontcolor = '';

		$complaint_hist = $rec['COMPLAINT_HISTORY'];
		if($rec['FEEDBACK'] == 'Negative')
		{
			$fontcolor = 'color:#C11B17;';
		}
		$complaint_hist = preg_replace('/^\s+|\s+$/','',$complaint_hist);
		
		if(($feedbackType == 1 || $feedbackType == 3 || $feedbackType == 5 || $feedbackType == 7 || $feedbackType == 8) && (preg_match('/Feedback: \S/',$complaint_hist)))
		{
			$cnt++;
			$bgcolor = '';
			if($cnt % 2 == 0 )
			{
				echo '
			<tr class="dark fnt" style="'.$fontcolor.'">';
			$bgcolor = '#eefaff';
			}
			else
			{
				echo '
			<tr class="fnt wbg" style="'.$fontcolor.'">';
				$bgcolor = '#FFFFFF';
			}
			echo '
			<td style="padding:4px;">'.$cnt.'</td>
			<td style="padding:4px;">'.$rec['FK_GLUSR_USR_ID'].'</a></td>
			<td style="padding:4px;">'.$rec['COMPLAINT_ID'].'</td>
			<td style="padding:4px;">'.$rec['CLOSED_ON'].'</td>
			<td style="padding:4px;">'.$rec['FEEDBACK'].'</td>
			<td style="padding:4px;">
			<textarea readonly="readonly" style="background:$bgcolor;border:none; width:99%;height:80px;text-align:left;resize:none;'.$fontcolor.'">'.$complaint_hist.'</textarea>
			</td>
			<td style="padding:4px;">'.$rec['CLOSEDBY_NAME'].' ('.$rec['CLOSEDBY_ID'].')</td>
                        <td style="padding:4px;">'.$rec['CMPLNT_CNT'].'</td>
                        <td style="padding:4px;">'.$rec['CRD_REV'].'</td>
                        <td style="padding:4px;">'.$rec['CRD_NOT_REV'].'</td>
			</tr>';
		}
		elseif(($feedbackType == 2 || $feedbackType == 4 || $feedbackType == 6 || $feedbackType == 8) && ((preg_match('/Feedback Type:/',$complaint_hist)) || preg_match('/Feedback:$/',$complaint_hist)))
		{
			$cnt++;
			$bgcolor = '';
			if($cnt % 2 == 0 )
			{
				echo '
			<tr class="dark fnt" style="'.$fontcolor.'">';
				$bgcolor = '#eefaff';
			}
			else
			{
				echo '
			<tr class="fnt wbg" style="'.$fontcolor.'">';
				$bgcolor = '#FFFFFF';
			}
			echo '
			<td style="padding:4px;">'.$cnt.'</td>
			<td style="padding:4px;">'.$rec['FK_GLUSR_USR_ID'].'</a></td>
			<td style="padding:4px;">'.$rec['COMPLAINT_ID'].'</td>
			<td style="padding:4px;">'.$rec['CLOSED_ON'].'</td>
			<td style="padding:4px;">'.$rec['FEEDBACK'].'</td>
			<td style="padding:4px;">
			<textarea readonly="readonly" style="background:'.$bgcolor.';border:none; width:99%;height:80px;text-align:left;resize:none;'.$fontcolor.'">'.$complaint_hist.'</textarea>
			</td>
			<td style="padding:4px;">'.$rec['CLOSEDBY_NAME'].' ('.$rec['CLOSEDBY_ID'].')</td>
                        <td style="padding:4px;">'.$rec['CMPLNT_CNT'].'</td>
                        <td style="padding:4px;">'.$rec['CRD_REV'].'</td>
                        <td style="padding:4px;">'.$rec['CRD_NOT_REV'].'</td>
			</tr>';
		}
	}
	if($cnt == 0)
	{
		echo '<tr class="wbg"><td colspan="8" style="padding:4px;"><div align="center" style="width:98% ; border:grey solid 1px;padding:4px;margin:4px;"><font color="red">Sorry, No Feedback Found as on Yesterday (MAINR)</font></div></td><tr>';
	}
	echo '</table><br><br><br>';
	echo '</div>';



?>