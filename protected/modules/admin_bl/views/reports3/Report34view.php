<?php

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><META http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>
		<div>
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
		<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">Tender Purchase Report</TD>
		</TR>
		</TABLE>
		<table width="100%" cellspacing="1" cellpadding="4" border="1" align="CENTER" style="border-collapse:collapse">
		<tbody>
		<tr>
		<td bgcolor="#CCCCFF" align="CENTER" rowspan="2" style="font-family:arial;font-size:11px;border-bottom:#333 solid 2px"><b>Date</b></td>
		
		<td align="CENTER" colspan="2" bgcolor="#B5EAAA" style="font-family:arial;font-size:11px"><b>EMORNING</b></td>
		<td align="CENTER" colspan="2" bgcolor="#B5EAAA" style="font-family:arial;font-size:11px"><b>MORNING</b></td>
		<td align="CENTER" colspan="2" bgcolor="#B5EAAA" style="font-family:arial;font-size:11px"><b>LEVENING</b></td>
		
		<tr></tr>';
                $counts=0;
                $cnt1_tot='';
                $cnt2_tot='';
                $cnt3_tot='';
                
                $i=0;

               foreach($result as $arr1)
               {
                  foreach($arr1 as $arr)
                  {
                   
                    $counts++;
                    $date=$result['ETO_PUR_DATE'][$i];
		    
		    $cnt1 = $result['EMORNING'][$i];
		    $cnt1_tot += $cnt1;
		    $cnt2 = $result['MORNING'][$i];
		    $cnt2_tot += $cnt2;
		    $cnt3 = $result['LEVENING'][$i];
		    $cnt3_tot += $cnt3;
                    echo '<tr><td align="CENTER" colspan="1" style="font-family:arial;font-size:11px">'.$date.'</td>';
                    echo '<td align="CENTER" colspan="2" style="font-family:arial;font-size:11px">'.$cnt1.'</td>';
                    echo '<td align="CENTER" colspan="2" style="font-family:arial;font-size:11px">'.$cnt2.'</td>';
                    echo '<td align="CENTER" colspan="2" style="font-family:arial;font-size:11px">'.$cnt3.'</td></tr>';
                    $i++;
                 }
                 break;
                }

                 echo '<tr><td bgcolor="#CCCCFF" align="CENTER" colspan="1" style="font-family:arial;font-size:11px"><b>TOTAL</b></td>';
                 echo '<td bgcolor="#B5EAAA" align="CENTER" colspan="2" style="font-family:arial;font-size:11px">'.$cnt1_tot.'</td>';
                 echo '<td bgcolor="#B5EAAA" align="CENTER" colspan="2" style="font-family:arial;font-size:11px">'.$cnt2_tot.'</td>';
                 echo '<td bgcolor="#B5EAAA" align="CENTER" colspan="2" style="font-family:arial;font-size:11px">'.$cnt3_tot.'</td></tr>';
                 echo '</tbody></table></div></body></html>';
                 if($counts==0)
		{
                   echo '<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
                }

?>