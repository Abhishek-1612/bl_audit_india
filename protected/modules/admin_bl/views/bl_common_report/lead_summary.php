<?php

$total = $rec_generated['TOTAL_LEADS_GEN_THIS_WEEK'];
$indian = $rec_generated['TOTAL_INDIAN_LEADS'];
$foreign = $rec_generated['TOTAL_FOREIGN_LEADS'];

echo '<br>
<br>';
		echo '<TABLE WIDTH="70%" BORDER="1" CELLPADDING="2" CELLSPACING="1"  border-color="#f8f8f8" style="border-collapse:collapse">
 			<tbody><tr>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="3"><b>Leads Generated:</b></td></tr>
			<tr>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>TOTAL</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Indian</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Foreign</B></TD></tr>
			<tr>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$total.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$indian.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$foreign.'</TD></tr>
			</tbody>
			</table>
			';
			
                        $total_approved = $rec_approved['LEADS_APPROVED_THIS_WEEK'];
			$totalindian_approved = $rec_approved['LEADS_APPROVED_INDIA'];
		        $totalforeign_approved = $rec_approved['LEADS_APPROV_FOREIGN'];
			$inverifyonly = $rec_approved['LEADS_INDIA_VER_ONLY'];
			$inenrichonly = $rec_approved['LEADS_INDIA_ENRCHD_ONLY'];
			$in_verify_enrich = $rec_approved['LEADS_INDIA_VER_ENRCHD'];
			$in_non_verify = $rec_approved['LEADS_INDIA_NON_VER'];
			$fornverifyonly = $rec_approved['LEADS_FOREIGN_VER_ONLY'];
			$fornenrichonly = $rec_approved['LEADS_FOREIGN_ENRCHD_ONLY'];
			$forn_verify_enrich = $rec_approved['LEADS_FOREIGN_VER_ENRCHD'];
			$forn_non_verify = $rec_approved['LEADS_FOREIGN_NON_VER'];
			

			echo '<br><br><TABLE WIDTH="100%" BORDER="1" CELLPADDING="2" CELLSPACING="1" border-color="#f8f8f8" style="border-collapse:collapse">
 			<tbody><tr>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"colspan="11"><b>Leads Approved:</b></td>
			</tr>
			<tr>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>TOTAL</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  colspan="5" align="center"><B>Indian</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  colspan="5" align="center"><B>Foreign</B></TD></tr>
			<tr>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B></B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Verified Only</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Enriched only</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Verified and Enriched</B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Non-Verified</B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Verified Only</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Enriched only</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Verified and Enriched</B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Non-Verified</B></TD>
			</tr>
			<tr>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$total_approved.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$totalindian_approved.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$inverifyonly.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$inenrichonly.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$in_verify_enrich.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$in_non_verify.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$totalforeign_approved.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$fornverifyonly.'</TD>

			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$fornenrichonly.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$forn_verify_enrich.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$forn_non_verify.'</TD>			
			</tr>

			</tbody>
			</table>	
					
			';
			
			$total_expired = $rec_expired['TOTAL_EXPIRED'];
			$indian_expired = $rec_expired['TOTAL_IN'];
			$foreign_expired = $rec_expired['TOTAL_FN'];
			
			$total_unsold = $rec_expired['TOTAL_UNSOLD'];
			$indian_unsold = $rec_expired['TOTAL_UNSOLD_IN'];
			$foreign_unsold = $rec_expired['TOTAL_UNSOLD_FN'];
			
			
			$total_nosup = $rec_nosup['TOTAL'];
			$indian_nosup = $rec_nosup['TOTAL_IN'];
			$foreign_nosup = $rec_nosup['TOTAL_FN'];
			

			echo '<br><br><TABLE WIDTH="70%" BORDER="1" CELLPADDING="2" CELLSPACING="1"  border-color="#f8f8f8" style="border-collapse:collapse">
			<tbody><tr>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="3" ><b>Expired Leads:</b></td>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="3" ><b>Expired Unsold Leads:</b></td></tr>
			<tr>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Indian</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Foreign</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Indian</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Foreign</B></TD></tr>
			
			<tr>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$total_expired.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$indian_expired.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$foreign_expired.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$total_unsold.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$indian_unsold.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$foreign_unsold.'</TD></tr>

			</tbody>
			</table>	
			';

#**********************************lead expired and unsold ends here******************

#**********************************expired unsold + No Supplier starts here*****************



			echo '<br><br><TABLE WIDTH="70%" BORDER="1" CELLPADDING="2" CELLSPACING="1"  border-color="#f8f8f8" style="border-collapse:collapse">
			<tbody><tr>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="3" ><b>Expired Unsold + No supplier Leads:</b></td>
			</tr>
			<tr>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ><B>Indian</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Foreign</B></TD>
			</tr>
			<tr>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$total_nosup.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$indian_nosup.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$foreign_nosup.'</TD>
			</tr>
			</tbody>
			</table>	
			';
			
			$totalverify_email = $rec_verifyemail['LEADS_VERIFIED_BY_EMAIL'];
			$totalenriched_email = $rec_verifyemail['LEADS_ENRICHED_BY_EMAIL'];
			$indian_verify = $rec_verifyemail['IN_LEADS_VERIFIED_BY_EMAIL'];
			$foreign_verify = $rec_verifyemail['FOR_LEADS_VERIFIED_BY_EMAIL'];
			$indian_enrich = $rec_verifyemail['IN_LEADS_ENRICHED_BY_EMAIL'];
			$foreign_enrich = $rec_verifyemail['FOR_LEADS_ENRICHED_BY_EMAIL'];
			
			$verify_call = $rec_verifycall['VERIFIED'];
			
			$enrichcall = $rec_enrichcall['VERIFIED_UPDATED'];
			
			echo '<br><br><TABLE WIDTH="90%" BORDER="1" CELLPADDING="2" CELLSPACING="1"  border-color="#f8f8f8" style="border-collapse:collapse">
			<tbody><tr>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="6"><b>Verify On-Email</b></td>
			<td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;" colspan="2"><b>Verify On-Call</b></td>
			</tr>
			<tr>	
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" colspan=\'3\'><B>Verified Leads</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" colspan=\'3\'><B>Enriched Leads</B></TD>
			
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Verified Leads</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Enriched Leads</B></TD>
			</tr>
			<tr>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Indian</B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Foreign</B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Indian</B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B>Foreign</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B></B></TD>
			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ><B></B></TD>
			

			</tr>
			<tr>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$totalverify_email.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$indian_verify.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$foreign_verify.'</TD>

			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$totalenriched_email.'</TD>
			
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$indian_enrich.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$foreign_enrich.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$verify_call.'</TD>
			<TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$enrichcall.'</TD>
			</tr>
			</tbody>
			</table>	
			';


			









?>