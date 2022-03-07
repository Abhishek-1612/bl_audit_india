

<?php
$file = '';

if (!$glusrID && !$ofrID)
{
 $file = '<div align="center" style="font-size:12px; padding-bottom:5px; font-weight:bold; color:#FF0000;">Please Enter Buyer ID</div>';
}

if ($glusrID && $glusrID > 0)
{

 // display report data for detailed

 echo '<br /><div id="leadwisereport" style="display:block;"><br />';
 $cnt = 0;
 while ($rec = oci_fetch_assoc($sth))
 {
  $ofr_id = $rec['OFR_ID'];
  $buyer_country = $rec['BUYER_COUNTRY_NAME'];
  $sup_name = $rec['SUPPLIER_NAME'];
  $ofr_desc = $rec['OFR_DESC'];
  $ofr_pur_date = $rec['PUR_DATE'];
  $ofr_verified = $rec['ETO_OFR_VERIFIED'];
  $ofr_post_date = $rec['ETO_OFR_POSTDATE_ORIG'];
  $cmplnt_on = $rec['ETO_BL_CMPLNT_ON'];
  $cmplnt_raised_from = $rec['ETO_CMPLNT_RAISED_FROM'];
  $cmplnt_opening_reason = $rec['ETO_BL_CMPLNT_REASON_DESC'];
  $cmplnt_reason = $rec['ETO_BL_CMPLNT_CRD_REV_DESC'];
  $cmplnt_emp_remark = $rec['ETO_BL_CMPLNT_EMP_REMARKS'];
  $credit_reversed = $rec['ETO_BL_CMPLNT_CRD_REV_FLG'];
  $credit_reversed1 = $rec['ETO_BL_CMPLNT_CRD_REV_STATUS'];
  $cmplnt_close_by = $rec['ETO_BL_CMPLNT_CLOSE_BY'];
  $cmplnt_emp_close = $rec['EMP_CLOSED'];
  $cmplnt_close_on = $rec['ETO_BL_CMPLNT_CLOSE_ON'];
  $cmplnt_id = $rec['FK_COMPLAINT_ID'];
  $cnt++;
  if ($cnt == 1)
  {
   $file.= '
                                        <table width="99%"border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#dde8ed">
                                        <tr>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Offer ID</td>
					<td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Buyer Country</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Supplier Name </td>
                                        <td width="30%"  bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Decription</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Post Date Org</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Purchase Date</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Complaint On</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Verified Status</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Raised from</td>
					<td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Opening Reason</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px3px; font-size:13px; font-weight:bold;color:#fff;">Closing Reason</td>
                                        <td width="8%" bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Emp Closing Remarks</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Credits Reversed</td>
                                        <td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Closed By </td>
					<td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Closed On </td>
					<td bgcolor="#60a5ec" style="padding:5px 0 5px 3px; font-size:13px; font-weight:bold;color:#fff;">Complaint Id </td>
                                        </tr>
                                        ';
   echo $file;
  }

  $file1 = '';
  if ($cnt % 2 == 0)
  {
   $file1.= '<tr class="dark fnt">';
  }
  else
  {
   $file1.= '<tr class="fnt wbg">';
  }

  $file1.= '
                                <td style="padding:4px;">' . $ofr_id . '</td>
				<td style="padding:4px;">' . $buyer_country . '</td>
                                <td style="padding:4px;">' . $sup_name . '</td>
                                <td style="padding:4px;">' . $ofr_desc . '</td>
                                <td style="padding:4px;">' . $ofr_post_date . '</td>
                                <td style="padding:4px;">' . $ofr_pur_date . '</td>
                                <td style="padding:4px;">' . $cmplnt_on . '</td>
                                <td style="padding:4px;">' . $ofr_verified . '</td>
                                <td style="padding:4px;">' . $cmplnt_raised_from . '</td>
				<td style="padding:4px;">' . $cmplnt_opening_reason . '</td>
                                <td style="padding:4px;">' . $cmplnt_reason . '</td>
                                <td style="padding:4px;">' . $cmplnt_emp_remark . '</td>';
  if ($credit_reversed == 2)
  {
   $credit_reversed = "No";
  }
  elseif ($credit_reversed == 1)
  {
   $credit_reversed = "Yes";
  }
  else
  {
   $credit_reversed = "WIP";
  }

  if ($credit_reversed1 == 3)
  {
   $credit_reversed1 = "No";
  }
  elseif ($credit_reversed1 == 1 || $credit_reversed1 == 2)
  {
   $credit_reversed1 = "Yes";
  }
  else
  {
   $credit_reversed1 = "WIP";
  }

  $file1.= '
                                <td style="padding:4px;">' . $credit_reversed1 . '</td>
                                <td style="padding:4px;">' . $cmplnt_emp_close . ' [ ' . $cmplnt_close_by . ' ]</td>
				<td style="padding:4px;">' . $cmplnt_close_on . '</td>
                                <td style="padding:4px;">' . $cmplnt_id . '</td>
                                </tr>';
  echo $file1;
  $file.= $file1;
 }

 if ($cnt == 0)
 {
  echo '<div align="center" style="font-size:12px; padding-bottom:5px; font-weight:bold; color:#FF0000;">No Complaint Found</div>';
 }

 $file1 = '</table></div>';
 echo $file1;
 $file.= $file1;
 echo '<br /><br /><br /><br />';
}
else
{
 echo '<div align="center" style="font-size:12px; padding-bottom:5px; font-weight:bold; color:#FF0000;">No Complaint Found</div>';
}

?>

