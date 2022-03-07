<?php
if($performance == 'emp_performance')
    {
    
    echo '<br><div id="emp-performance" style="display:block;"><br>';

echo '<table bgcolor="#d7e7ee" border="0" cellpadding="0" cellspacing="0" width="98%" align="center">
			<tbody><tr style="background: #0195d3; color: white; font-weight: bold; font-size: 12px;">
			<td width="13%" style="padding:4px; font-family:arial; font-size:13px;">Employee Performance</td>
			</tr>
			</tbody></table>
			<table bgcolor="#80c0e5" border="0" cellpadding="0" cellspacing="1" width="98%" align="center">
			<tr style="background: #1dafec; color: white; font-weight: bold; font-family:arial; font-size: 12px;">
			<td bgcolor="#00a2e6" style="padding:6px;">Total Talked</td>
			<td bgcolor="#00a2e6"  style="padding:4px;">'.$talkcount.'</td>
			</tr>
			';
			
			$cnt=0;
			$bgcolor = '';
			while($rec= oci_fetch_assoc($sth_performance))
			{
			$emp_cnt=$rec['CNT'];
			$emp_id=$rec['GL_EMP_ID'];
			$emp_name=$rec['GL_EMP_NAME'];
			$cnt++;
			if($cnt % 2 == 0)
			{
					$bgcolor = '#c1edff';
			}
			else
			{
					$bgcolor = '#eefaff';
			}



echo '<tr><td bgcolor="'.$bgcolor.'"  style="padding:4px;">'.$emp_name.'
</td>
<td bgcolor="'.$bgcolor.'"  style="padding:4px;">'.$emp_cnt.'
</td>';
			}
echo '</table></div>';
  }
  elseif(isset($_REQUEST['radio1']))
   {
     if($_REQUEST['mistabselect'] == '4')
	{
	    echo '<div id="complain_detail">';
            echo ''.$table.'</div>';
	}
   }
  else
  {
   echo '<br><div id="talkwisereport" style="display:block;"><br>';
   $cnt = 0;
   $file='';
  while($rec = oci_fetch_assoc($sth_talkwise))
                        {
				 $glusrID = $rec['FK_GLUSR_USR_ID'];
				 $cmplnt_close_by = $rec['ETO_BL_CMPLNT_CLOSE_BY'];

                                 $sup_name = $rec['SUPPLIER_NAME'];
				 $companyname = $rec['GLUSR_USR_COMPANYNAME']; 
				 $cmplnt_ID = $rec['FK_COMPLAINT_ID'];
                                 $cmplnt_on = $rec['ETO_BL_CMPLNT_ON']; 
				 $cmplnt_opening_reason = isset($rec['ETO_BL_CMPLNT_REASON']) ? $rec['ETO_BL_CMPLNT_REASON'] : '';
				 $cmplnt_opening_reason_desc = isset($rec['ETO_BL_CMPLNT_DESC']) ? $rec['ETO_BL_CMPLNT_DESC'] : '';
				
                                 $cmplnt_closing_reason = isset($rec['ETO_BL_CMPLNT_CRD_REV_DESC']) ? $rec['ETO_BL_CMPLNT_CRD_REV_DESC'] : '';
                                                   
                                 $cmplnt_close_on = isset($rec['ETO_BL_CMPLNT_CLOSE_ON']) ? $rec['ETO_BL_CMPLNT_CLOSE_ON'] : '';	

				 $emp_name = isset($rec['GL_EMP_NAME']) ? $rec['GL_EMP_NAME'] : '';	
					
                                 $cnt++;				
				if($cnt == 1)
				{
					$file .= '
                                        <table width="99%"border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#dde8ed">
                                        <tr>
					<td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Sl.No</td>
                                        
                                        <td width="10%" bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Supplier ID</td>
                                                
                                        <td width="30%"  bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Company Name</td>
                                        <td width="10%"bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Complaint ID</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Complaint On</td>';
# print qq~<td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Opening Reason</td>
#<td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Closing Reason</td>';
        
                                                    
					$file .= '<td width="10%" bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Closed on</td>
					   
					<td width="10%"bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Employee Name </td>       
					
					</tr>
                                        ';
					echo $file;
				}
                                 $file1 = '';
                                if($cnt % 2 == 0 )
                                {
                                        $file1 .=  '<tr class="dark fnt">';
                                }
                                else
                                {				
                                        $file1 .=  '<tr class="fnt wbg">';
                                }
                                $file1 .= '
                                <td style="padding:4px;">'.$cnt.'</td>
				
				<td style="padding:4px;">'.$glusrID.'</td>
				<td style="padding:4px;">'.$companyname.'</td>			
                                <td style="padding:4px;">'.$cmplnt_ID.'</td>
                                <td style="padding:4px;">'.$cmplnt_on.'</td>';
#                               print qq~<td style="padding:4px;">$cmplnt_opening_reason</td>
#                               <td style="padding:4px;">$cmplnt_closing_reason</td>~;
				$file1 .= '<td style="padding:4px;">'.$cmplnt_close_on.'</td>
                                <td style="padding:4px;">'.$emp_name.'</td>
                                
				</tr>';
                                
                                echo $file1;
                                
                                $file .= $file1;
                        }
			if($cnt == 0)
			{
				echo '<div align="center" style="font-size:12px; padding-bottom:5px; font-weight:bold; color:#FF0000;">No Complaint Found</div>';
			}
                         $file1 = '</table></div>';
                        echo $file1;
                        $file .= $file1;
                        echo '<br><br><br><br>';
                        
		
   
			echo '		
			<script>
				document.getElementById(\'talkcount\').style.display=\'block\';
				document.getElementById(\'talkcount\').innerHTML = "&nbsp;&nbsp;&nbsp;<strong>Report Count:</strong> '.$talkcount1.'";
			</script>';						
		
		
		

  }


?>