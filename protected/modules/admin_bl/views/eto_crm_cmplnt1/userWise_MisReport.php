<?php
echo '<br><div id="userwisereport" style="display:block;"><br>';
        
                 $chart = "http://weberp1.intermesh.net/company/QueryBarChart.aspx?GLUsrID=$glusrID&ReportType=PBL";

		$file = ' <div align="center" HEIGHT="520" WIDTH="890" style="display:block;">';

		if($glusrID > 0)
		{
		    $file .= '
		    <IFRAME BORDER="0" BORDERCOLOR="0" FRAMEBORDER="0" FRAMESPACING="0" SRC="'.$chart.'" HEIGHT="520" WIDTH="890" HSPACE="0" VSPACE="0" MARGINWIDTH="0" MARGINHEIGHT="0" NORESIZE="NORESIZE" ID="cmplnt_chart" NAME="cmplnt_chart"></IFRAME>';
		}
		else
		{
			$file .= '<div align="center" style="font-weight:bold; font-size:12px; color:#FF0000;">No Chart Available';
		}
		$file .= '</div><br /><br />';
		
		   $file .= '<table width="99%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#dde8ed">
                <tr>
                <td width="6%" align="center" bgcolor="#60a5ec" style="padding:5px 0 5px 0; font-size:14px; font-weight:bold;color:#fff;">Month</td>
                <td width="47%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0; font-size:14px; font-weight:bold;color:#fff;">India</td>
                <td width="47%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0;font-size:14px; font-weight:bold;color:#fff;">Foreign</td>
                </tr>
		<tr>
                <td align="center" bgcolor="#ffffff" style="padding:4px 0 4px 0; font-size:13px;color:#000;">&nbsp;</td>
                <td bgcolor="#ffffff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td width="34%" align="center" style="padding:4px 0 4px 4px;font-size:12px;color:#0000ff">Leads Purchase</td>
                <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px; border-left:1px solid #dde8ed;color:#0000ff"">Complaint</td>
                <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;color:#0000ff""">Reversed</td>
                </tr>
                </table>
                </td>
                <td width="50%" bgcolor="#ffffff" style="padding:0px 0 0px 0">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td width="34%" align="center" style="padding:4px 0 4px 4px;font-size:12px; color:#0000ff">Leads Purchase</td>
                <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px; border-left:1px solid #dde8ed;color:#0000ff">Complaint</td>
                <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;color:#0000ff">Reversed</td>
                </tr>
                </table></td></tr>';

		$tot_purCnt_IN = 0;		
		$tot_cmplntCnt_IN = 0;
		$tot_revCnt_IN = 0;

		$tot_purCnt_FO = 0;
		 $tot_cmplntCnt_FO = 0;		
		 $tot_revCnt_FO = 0;

		while( $rec_pur = oci_fetch_assoc($sth_pur))
		{
			 $date = isset($rec_pur['_MONTH']) ? $rec_pur['_MONTH'] : '';
			
			 $purCnt_IN = isset($rec_pur['IN_LEAD_PUR_CNT']) ? $rec_pur['IN_LEAD_PUR_CNT'] :0;
			 $purCnt_FO = isset($rec_pur['FORGN_LEAD_PUR_CNT']) ?  $rec_pur['FORGN_LEAD_PUR_CNT'] : 0;

			 $cmplntCnt_IN = isset($rec_pur['IN_CMPLNT_CNT']) ? $rec_pur['IN_CMPLNT_CNT'] : 0; 
			 $cmplntCnt_FO = isset($rec_pur['FORGN_CMPLNT_CNT']) ? $rec_pur['FORGN_CMPLNT_CNT'] : 0;

			 $purcmplnt_IN = isset($rec_pur['IN_PUR_CMPT']) ? $rec_pur['IN_PUR_CMPT'] : 0;
			 $purcmplnt_FN = isset($rec_pur['FN_PUR_CMPT']) ? $rec_pur['FN_PUR_CMPT'] : 0;			

			 $revCnt_IN = isset($rec_pur['IN_REV_CNT']) ? $rec_pur['IN_REV_CNT'] : 0;
			 $revCnt_FO = isset($rec_pur['FORGN_REV_CNT']) ? $rec_pur['FORGN_REV_CNT'] : 0;

			 $wip_IN = isset($rec_pur['IN_WIP']) ? $rec_pur['IN_WIP'] : 0;
			 $wip_FO = isset($rec_pur['FO_WIP']) ? $rec_pur['FO_WIP'] : 0;
			
			$tot_purCnt_IN = $tot_purCnt_IN + $purCnt_IN;
			$tot_cmplntCnt_IN = $tot_cmplntCnt_IN + $cmplntCnt_IN;
			$tot_revCnt_IN = $tot_revCnt_IN + $revCnt_IN;

			$tot_purCnt_FO = $tot_purCnt_FO + $purCnt_FO;
			$tot_cmplntCnt_FO = $tot_cmplntCnt_FO + $cmplntCnt_FO;
			$tot_revCnt_FO = $tot_revCnt_FO + $revCnt_FO;

                        $file .= '
                        <tr>
                        <td align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 0; font-size:12px;color:#000;">'.$date.'</td>
                        <td bgcolor="#f5f5f5">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                                <td width="34%" align="center" style="padding:4px 0 4px 4px;font-size:12px;">'.$purCnt_IN.'</td>
                                <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px; border-left:1px solid #dde8ed;">'.$cmplntCnt_IN.'';
                                if($wip_IN > 0)
				$file .= '&nbsp;[ WIP = '.$wip_IN.' ]' ;
				if($purcmplnt_IN > 0)
				$file .= '&nbsp;[ '.$purcmplnt_IN.' ]' ;
				$file .= '</td>
                                <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">'.$revCnt_IN.'</td>
                        </tr>
                        </table>
                        </td>
			<td width="50%" bgcolor="#f5f5f5" style="padding:0px 0 0px 0">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
                	    <td width="34%" align="center" style="padding:4px 0 4px 4px;font-size:12px;">'.$purCnt_FO.'</td>
			    <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px; border-left:1px solid #dde8ed;">'.$cmplntCnt_FO.'';
			     if($wip_FO > 0)
			    $file .= '&nbsp; [ WIP = '.$wip_FO.' ]';
			    if($purcmplnt_FN > 0)
			    $file .= '&nbsp; [ '.$purcmplnt_FN.' ]';
			    $file .= '</td>
			    <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">'.$revCnt_FO.'</td>
			</tr>
                	</table>
			</td>
			</tr>';			
		}

                $file .= '		
                <tr>
                <td align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 0; font-size:12px;color:#000; font-weight:bold;"> Total</td>
                <td bgcolor="#f5f5f5">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                        <td width="34%" align="center" style="padding:4px 0 4px 4px;font-size:12px; font-weight:bold;">'.$tot_purCnt_IN.'</td>
                        <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px; border-left:1px solid #dde8ed; font-weight:bold;">'.$tot_cmplntCnt_IN.'</td>
                        <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed; font-weight:bold;">'.$tot_revCnt_IN.'</td>
                </tr>
                </table>
                </td>
                <td width="50%" bgcolor="#f5f5f5" style="padding:0px 0 0px 0">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                        <td width="34%" align="center" style="padding:4px 0 4px 4px;font-size:12px; font-weight:bold;">'.$tot_purCnt_FO.'</td>
                        <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px; border-left:1px solid #dde8ed; font-weight:bold;">'.$tot_cmplntCnt_FO.'</td>
                        <td width="33%" align="center" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed; font-weight:bold;">'.$tot_revCnt_FO.'</td>
                </tr>
                </table>
                </td>
                </tr>
          
                </table>
                <br />
                <br />';
                $all_reason=array();	
                $i=1;
                
                while($rec_oreason = oci_fetch_assoc($sth_oreason))
                {   
                        if(isset($rec_oreason['ETO_BL_CMPLNT_REASON_DESC']))
                        {
                        $all_reason["REASON$i"]["OPEN_REASON"] = $rec_oreason['ETO_BL_CMPLNT_REASON_DESC'];
                        }
                        else
                        {
                         $all_reason["REASON$i"]["OPEN_REASON"] = ''; 
                        
                        }
			if(isset($rec_oreason['CNT']))
                        {
                        $all_reason["REASON$i"]["OPEN_REASON_CNT"] = $rec_oreason['CNT'];
                        }
                        else
                        { 
                          $all_reason["REASON$i"]["OPEN_REASON_CNT"] = '';
                        }
                        $i++;       	
                }  
               
                $i=1;                
                while($rec_creason = oci_fetch_assoc($sth_creason))
                {      
                        if(isset($rec_creason['ETO_BL_CMPLNT_CRD_REV_DESC']))
                        {
                        $all_reason["REASON$i"]["CLOSE_REASON"] = $rec_creason['ETO_BL_CMPLNT_CRD_REV_DESC'];
                        }
                        else
                        {
                         $all_reason["REASON$i"]["CLOSE_REASON"] = '';
                         echo 'in else of close';
                        }
                        if(isset($rec_creason['CNT']))
                        {
                        $all_reason["REASON$i"]["CLOSE_REASON_CNT"] = $rec_creason['CNT'];
                        }
                        else
                        { 
                         $all_reason["REASON$i"]["CLOSE_REASON_CNT"] = '';
                        }
                        $i++;			        	
                }
             
             $all_reason["REASON1"]["DAY"] = 'Same Day';
		$all_reason["REASON2"]["DAY"] = '1 Day';
		$all_reason["REASON3"]["DAY"] = '2 Day';
		$all_reason["REASON4"]["DAY"] = '>2 Day';
                                        
                $all_reason["REASON1"]["DAY_CNT"] = isset($rec_day['SAME_DAY']) ? $rec_day['SAME_DAY'] : '';                			        	
		$all_reason["REASON2"]["DAY_CNT"] = isset($rec_day['ONE_DAY']) ? $rec_day['ONE_DAY'] : '';
		$all_reason["REASON3"]["DAY_CNT"] = isset($rec_day['TWO_DAY']) ? $rec_day['TWO_DAY'] : '';
		$all_reason["REASON4"]["DAY_CNT"] = isset($rec_day['MORE_TWO_DAY']) ? $rec_day['MORE_TWO_DAY'] : '';
		
	
		if(sizeof(array_keys($all_reason)))
		{
		 $file .= '
		 <table width="99%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#dde8ed">
                 <tr>                   
                   <td width="25%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0; font-size:14px; font-weight:bold;color:#fff;">Opening Reason</td>
		   <td width="7%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0;font-size:14px; font-weight:bold;color:#fff;">Count</td>
                   <td width="25%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0;font-size:14px; font-weight:bold;color:#fff;">Closing Reason</td>
		   <td width="7%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0;font-size:14px; font-weight:bold;color:#fff;">Count</td>
		   <td width="25%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0;font-size:14px; font-weight:bold;color:#fff;">Difference [Lead Purchase and Complaint Date]</td>
		   <td width="7%" align="center" bgcolor="#0064ca" style="padding:5px 0 5px 0;font-size:14px; font-weight:bold;color:#fff;">Count</td>
                 </tr>';
		}
		
		
		
	$i=1;
		foreach (array_keys($all_reason) as $x)
		{
			$file .= '
			<tr>                   
                   	  <td width="25%" align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">';
                   	  if(isset($all_reason["REASON$i"]["OPEN_REASON"]))
                   	  {
                   	  $file .=  $all_reason["REASON$i"]["OPEN_REASON"];
                   	  }
                   	 $file .= '</td>
                   	  <td width="7%" align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">';
                   	  if(isset($all_reason["REASON$i"]["OPEN_REASON_CNT"]))
                   	  {
                   	  $file .= $all_reason["REASON$i"]["OPEN_REASON_CNT"];
                   	  }
                   	  
                   	  $file .= '</td>
                   	  <td width="25%" align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">';
                   	  if(isset($all_reason["REASON$i"]["CLOSE_REASON"]))
                   	  {
                   	  $file .= $all_reason["REASON$i"]["CLOSE_REASON"];
                   	  }
                   	  $file .= '</td>
                   	  <td width="7%" align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">';
                   	  if(isset($all_reason["REASON$i"]["CLOSE_REASON_CNT"]))
                   	  {
                   	  $file .= $all_reason["REASON$i"]["CLOSE_REASON_CNT"];
                   	  }
                   	  $file .= '</td>
			  <td width="25%" align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">';
			  if(isset($all_reason["REASON$i"]["DAY"]))
			  $file .= $all_reason["REASON$i"]["DAY"];
			  $file .= '</td>
			   <td width="7%" align="center" bgcolor="#f5f5f5" style="padding:4px 0 4px 4px;font-size:12px;border-left:1px solid #dde8ed;">';
			   if(isset($all_reason["REASON$i"]["DAY_CNT"]))
			   $file .= $all_reason["REASON$i"]["DAY_CNT"];
			   $file .= '</td>
                 	</tr>
			';
			$i++;
		}
		$file .= '</table><br /><br />';


		$file .= '<table width="99%"border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#dde8ed">
                <tr>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Offer ID</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Buyer Name</td>
                    <td width="3%" bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">City</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Country</td>
                    <td width="30%"  bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Decription</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Post Date Org</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Purchase Date</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Complaint On</td>                    
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Verified Status</td>                   
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Raised from</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Opening Reason</td>
		    <td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Client Remarks</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Closing Reason</td>
                    <td width="8%" bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Emp Closing Remarks</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Credits Reversed</td>
                    <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Closed By </td>                    
                </tr>
		';
	echo $file;
                $cnt = 0;
                while( $rec = oci_fetch_assoc($sth))
                {                        
			 $ofr_id = $rec['OFR_ID'];                        
                         $buyer_name = $rec['BUYER_NAME'];
			 $buyer_city = $rec['GLUSR_USR_CITY'];
                         $buyer_country = $rec['GLUSR_USR_COUNTRYNAME'];
                         $ofr_desc = $rec['OFR_DESC'];
                         $ofr_pur_date = $rec['PUR_DATE'];                        
                         $ofr_verified = $rec['ETO_OFR_VERIFIED'];                        
                         $ofr_post_date = $rec['ETO_OFR_POSTDATE_ORIG'];                        
                         $cmplnt_on = $rec['ETO_BL_CMPLNT_ON'];                        
			 $cmplnt_raised_from = $rec['ETO_CMPLNT_RAISED_FROM'];
			 $cmplnt_open_reason = $rec['ETO_BL_CMPLNT_REASON_DESC'];
			 $client_remarks = $rec['ETO_BL_CMPLNT_DESC'];
			 $cmplnt_reason = $rec['ETO_BL_CMPLNT_CRD_REV_DESC'];
                         $cmplnt_emp_remark = $rec['ETO_BL_CMPLNT_EMP_REMARKS'];
                         $credit_reversed = $rec['ETO_BL_CMPLNT_CRD_REV_FLG'];
			 $cmplnt_close_by = $rec['ETO_BL_CMPLNT_CLOSE_BY'];                    
                         $cmplnt_emp_close = $rec['EMP_CLOSED'];
                         $credit_reversedStatus = isset($rec['ETO_BL_CMPLNT_CRD_REV_STATUS']) ? $rec['ETO_BL_CMPLNT_CRD_REV_STATUS'] : '';
                        
                        $cnt++;
                         $file1 = '';
                        if($cnt % 2 == 0 )
                        {
                                $file1 .=  '<tr class="dark fnt">';
                        }
                        else
                        {
				 $start_date = ($_REQUEST['uw_s_month']).'-'.($_REQUEST['uw_s_year']);
        			 $end_date = ($_REQUEST['uw_e_month']).'-'.($_REQUEST['uw_e_year']);
                                $file1 .=  '<tr class="fnt wbg">';
                        }
                        $file1 .= '                        
			<td style="padding:4px;">'.$ofr_id.'</td>                        
                        <td style="padding:4px;">'.$buyer_name.'</td>
			<td style="padding:4px;">'.$buyer_city.'</td>
			<td style="padding:4px;">'.$buyer_country.'</td>
			<td style="padding:4px;">'.$ofr_desc.'</td>
                        <td style="padding:4px;">'.$ofr_post_date.'</td>
                        <td style="padding:4px;">'.$ofr_pur_date.'</td>
			<td style="padding:4px;">'.$cmplnt_on.'</td>
                        <td style="padding:4px;">'.$ofr_verified.'</td>                        
			<td style="padding:4px;">'.$cmplnt_raised_from.'</td>
			<td style="padding:4px;">'.$cmplnt_open_reason.'</td>
			<td style="padding:4px;">'.$client_remarks.'</td>
			<td style="padding:4px;">'.$cmplnt_reason.'</td>
			<td style="padding:4px;">'.$cmplnt_emp_remark.'</td>';

			if($credit_reversedStatus)
			{
			  if($credit_reversedStatus == 1 || $credit_reversedStatus == 2)
			  {
			    $credit_reversed = "Yes";
			  }
			  elseif($credit_reversedStatus==3)
			  {
			    $credit_reversed = "No";
			  }
			}
			else
			{
			  if($credit_reversed == 2)
			  {
				  $credit_reversed = "No";
			  }
			  elseif($credit_reversed == 1)
			  {
				  $credit_reversed = "Yes";
			  }
			  else
			  {
				  $credit_reversed = "WIP";
			  }
                        }
                    
			$file1 .= '
			<td style="padding:4px;">'.$credit_reversed.'</td>			
			<td style="padding:4px;">'.$cmplnt_emp_close.' [ '.$cmplnt_close_by.' ]</td> 
			</tr>';
                        
                        echo $file1;
                        
                        $file .= $file1;
                }
                 $file1 = '</table></div>';
                echo $file1;
                $file .= $file1;
                echo '<br><br><br><br>';							
		 


		


?>