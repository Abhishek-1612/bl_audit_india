
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title></title>
	<meta name="generator" content="LibreOffice 4.4.7.2 (Linux)"/>
	<meta name="author" content="Indiamart"/>
	<meta name="created" content="2016-02-03T06:07:29"/>
	<meta name="changedby" content="Indiamart"/>
	<meta name="changed" content="2016-03-03T05:04:04"/>
	<meta name="AppVersion" content="15.0300"/>
	<meta name="DocSecurity" content="0"/>
	<meta name="HyperlinksChanged" content="false"/>
	<meta name="LinksUpToDate" content="false"/>
	<meta name="ScaleCrop" content="false"/>
	<meta name="ShareDoc" content="false"/>
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Calibri"; font-size:15px }
	</style>
	
</head>

<body>
<br><br>
<?php
$zero_filled_att_cnt=0;
if(isset($_REQUEST['source']) && $_REQUEST['source']=='Buy Lead')
{
if(count($attribute_name['IM_SPEC_MASTER_DESC'])!=0)
{
echo '<table align="center" cellspacing="0" border="0">
	<colgroup width="278"></colgroup>
	<colgroup width="215"></colgroup>
	<colgroup width="152"></colgroup>
	<colgroup width="139"></colgroup>
	<colgroup width="119"></colgroup>
	<colgroup width="132"></colgroup>
	<colgroup width="135"></colgroup>
	
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Attributes/Fill Rate</font></b></td>
		';
		 $i=0;
		 $i=0;
		foreach ($attribute_name['IM_SPEC_MASTER_DESC'] as $value)
		 {  if($i==5)break;
		   $i++;
		  
		 echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">'.$value.'</font></b></td>';
		 }
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font color="#000000">Total BLs/Enquiry</font></b></td>
	</tr>';
		$j=0;
		$k=0;
		$tf=0;
		$ts=0;
		$l=0;
		$m=0;
		$n=0;
		$o=0;
		$p=0;
		$dictionary  = array(
				      0                   => 'Zero',
				      1                   => 'One',
				      2                   => 'Two',
				      3                   => 'Three',
				      4                   => 'Four',
				      5                   => 'Five',
				      6                   => 'Six',
				      7                   => 'Seven',
				      8                   => 'Eight',
				      9                   => 'Nine',
				      10                  => 'Ten',
				      11                  => 'Eleven',
				      12                  => 'Twelve',
				      13                  => 'Thirteen',
				      14                  => 'Fourteen',
				      15                  => 'Fifteen',
				      16                  => 'Sixteen',
				      17                  => 'Seventeen',
				      18                  => 'Eighteen',
				      19                  => 'Nineteen',
				      20                  => 'Twenty'
				      );
		
		$index1=0;
		$index2=0;
		$index3=0;
		$index4=0;
		$index5=0;
		$sum=0;
		$sum1=0;
		$sum2=0;
		$sum3=0;
		$sum4=0;
		$sum5=0;
		$sum6=0;
		while($i>=$j)
		{$index=0;
		echo '
		<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">'.$dictionary[$j].' Attribute Filled In</font></b></td>';
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=1)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index1]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index1]==$j)
		{ $sum1+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index1];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index1];
		  $index1++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=2)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index2]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index2]==$j)
		{ $sum2+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index2];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index2];
		  $index2++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
	        if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=3)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index3]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index3]==$j)
		{ $sum3+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index3];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index3];
		  $index3++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=4)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index4])&& $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index4]==$j )
		{ $sum4+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index4];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index4];
		  $index4++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=5)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index5]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index5]==$j )
		{ $sum5+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index5];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index5];
		  $index5++;
		}
		else
		echo '0';
		$index++;
		echo '</font></td>';
		}
		
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px sol$rec_otherid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="80" sdnum="1033;"><font color="#000000">';
		if((isset($total_bl['FILLED_ATTRIBUTE'][$k]) and $total_bl['FILLED_ATTRIBUTE'][$k]==$j))
		 {
		  if($k==0)
		  $zero_filled_att_cnt+=$total_bl['TOTAL_BL'][$k];
		  
		 if(isset($total_bl['TOTAL_BL'][$k]))
		  {if($j!=0)  
		   $sum6+=$total_bl['TOTAL_BL'][$k];
		    echo $total_bl['TOTAL_BL'][$k];
		   }
		  else 
		   echo '0';
		    $k++;
		 }  
		else 
		echo '0';
		
		echo '</font></td>
	        </tr>';
	        $j++;
	        }
	        echo '
	       <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Total with Attributes Filled in </font></b></td>';
		
		$ii=0;
		$x=0;
		while(($i-1)>=$ii)
		{$x=$ii+1;
		
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">
		</font>'.${"sum$x"}.'</td>';
		$ii++;
		}
		$x=$ii+1;
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">
		</font>'.$sum6.'</td>';
		echo '</tr>';
	        $zero_filled_att_cnt+=$sum6;
               
	       echo '
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Number of Buy/Lead Enquiry with Other Option Filled in </font></b></td>';
		 $ii=0;
		$cnt=0;
		while(($i-1)>=$ii)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">';
		if(isset($rec_other['OTHER_COUNT'][$ii]))
		{$cnt+=$rec_other['OTHER_COUNT'][$ii];
		echo $rec_other['OTHER_COUNT'][$ii];
		}
		else '0';
		echo '</font></td>';
		$ii++;
		}
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">'.$cnt.'</font></td>';
		
		////////
		  echo '</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Fill Rate </font></b></td>';
		$ii=0;
		$y=0;
		while(($i-1)>=$ii)
		{$y=$ii+1;
		if($zero_filled_att_cnt!=0)
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">
		</font>'.(round(${"sum$y"}*100/$zero_filled_att_cnt,2)).' %</td>';
		else
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">
		</font>0 %</td>';
		
		$ii++;
		}
		$y=$ii+1;
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000"> - </font></td>';
		//////////
		
	echo '	
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="40" align="center" valign=middle><b><font color="#000000">Total Leads Identified for MCAT</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b><font color="#000000">Unique Purchased</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b><font color="#000000">Number of Sold per Purchase</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom><b><font color="#000000">Unsold</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font color="#000000">Total BLs</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font color="#000000">Percent Perchased</font></b></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>';
	
	
	 $j=0;
	 $td=0;
	 $tdd=0;
	 $tdp=0;
	 $ptdp=0;
	 while($i>=$j)
		{
		echo '
		<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">'.$dictionary[$j].' Attribute Filled In</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="40" sdnum="1033;"><font color="#000000">';
		if((isset($sold_total_bl['FILLED_ATTRIBUTE'][$ts]) and $sold_total_bl['FILLED_ATTRIBUTE'][$ts]==$j))
		 {
		 if(isset($sold_total_bl['TOTAL_BL'][$ts]))
		  {echo $sold_total_bl['TOTAL_BL'][$ts];
		   }
		  else 
		   echo '0';
		    $ts++;
		 }  
		else 
		echo '0';
		echo '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1.5" sdnum="1033;"><font color="#000000">';
		if((isset($rec_sold_percent['FILLED_ATTRIBUTE'][$tdp]) and $rec_sold_percent['FILLED_ATTRIBUTE'][$tdp]==$j))
		 {
		  if(isset($rec_sold_percent['TOTAL_BL'][$tdp]))
		  {
		    	if(isset($sold_total_bl['TOTAL_BL'][$tdp]) and $sold_total_bl['TOTAL_BL'][$tdp]!=0)
			  {echo round(($rec_sold_percent['TOTAL_BL'][$tdp]/$sold_total_bl['TOTAL_BL'][$tdp]),2);
			  }
			  else 
			  echo 0;
		     
		    }
		  else 
		   echo '0';
		    $tdp++;
		 }  
		else 
		echo '0';
		
		echo '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="40" sdnum="1033;"><font color="#000000">';
		if((isset($total_bl['FILLED_ATTRIBUTE'][$td]) and $total_bl['FILLED_ATTRIBUTE'][$td]==$j))
		 {
		  if(isset($total_bl['TOTAL_BL'][$td]))
		  {
		    if((isset($sold_total_bl['FILLED_ATTRIBUTE'][$tdd]) and $sold_total_bl['FILLED_ATTRIBUTE'][$tdd]==$j))
			{
			if(isset($sold_total_bl['TOTAL_BL'][$tdd]))
			  {echo ($total_bl['TOTAL_BL'][$td]-$sold_total_bl['TOTAL_BL'][$tdd]);
			  }
			  else 
			  echo $total_bl['TOTAL_BL'][$td];
			    $tdd++;
		       } 
		       else
		      echo  $total_bl['TOTAL_BL'][$td];
		    }
		  else 
		   echo '0';
		    $td++;
		 }  
		else 
		echo '0';
		
		echo '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="80" sdnum="1033;"><font color="#000000">';
		if((isset($total_bl['FILLED_ATTRIBUTE'][$tf]) and $total_bl['FILLED_ATTRIBUTE'][$tf]==$j))
		 {
		 if(isset($total_bl['TOTAL_BL'][$tf]))
		  {echo $total_bl['TOTAL_BL'][$tf];
		   }
		  else 
		   echo '0';
		    $tf++;
		 }  
		else 
		echo '0';
		////////////////////////////
		echo '</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="80" sdnum="1033;"><font color="#000000">';
		if((isset($sold_total_bl['FILLED_ATTRIBUTE'][$ptdp]) and $sold_total_bl['FILLED_ATTRIBUTE'][$ptdp]==$j))
		 {
		  if(isset($sold_total_bl['TOTAL_BL'][$ptdp]))
		  {
		    	if(isset($total_bl['TOTAL_BL'][$ptdp]) and $total_bl['TOTAL_BL'][$ptdp]!=0)
			  {echo round((($sold_total_bl['TOTAL_BL'][$ptdp]*1.00)/$total_bl['TOTAL_BL'][$ptdp])*100,2).'%';
			  }
			  else 
			  echo '0'.'%';
		     
		    }
		  else 
		   echo '0%';
		    $ptdp++;
		 }  
		else 
		echo '0%';
		
		echo '
		</font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	       </tr>';
	       $j++;
	       }
	      echo '
	
	<tr>
		<td height="20" align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>
	
	<tr>
		<td height="20" align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="center" valign=bottom><b><font color="#000000"></font></b></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>
</table>
<!-- ************************************************************************** -->
</body>

</html>';
}
else
echo '<center style="font-family:arial;font-size:14px;font-weight:bold;">No Record Found</center>';
}
else
{/////////////////////code for Enquiry/////////////////////////////////////

if(count($attribute_name['IM_SPEC_MASTER_DESC'])!=0)
{
echo '<table align="center" cellspacing="0" border="0">
	<colgroup width="278"></colgroup>
	<colgroup width="215"></colgroup>
	<colgroup width="152"></colgroup>
	<colgroup width="139"></colgroup>
	<colgroup width="119"></colgroup>
	<colgroup width="132"></colgroup>
	<colgroup width="135"></colgroup>
	
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Attributes/Fill Rate</font></b></td>
		';
		 $i=0;
		 $i=0;
		foreach ($attribute_name['IM_SPEC_MASTER_DESC'] as $value)
		 {if($i==5)break; 
		   $i++;
		 echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">'.$value.'</font></b></td>';
		 }
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font color="#000000">Total BLs/Enquiry</font></b></td>
	</tr>';
		$j=0;
		$k=0;
		$tf=0;
		$ts=0;
		$l=0;
		$m=0;
		$n=0;
		$o=0;
		$p=0;
		$dictionary  = array(
				      0                   => 'Zero',
				      1                   => 'One',
				      2                   => 'Two',
				      3                   => 'Three',
				      4                   => 'Four',
				      5                   => 'Five',
				      6                   => 'Six',
				      7                   => 'Seven',
				      8                   => 'Eight',
				      9                   => 'Nine',
				      10                  => 'Ten',
				      11                  => 'Eleven',
				      12                  => 'Twelve',
				      13                  => 'Thirteen',
				      14                  => 'Fourteen',
				      15                  => 'Fifteen',
				      16                  => 'Sixteen',
				      17                  => 'Seventeen',
				      18                  => 'Eighteen',
				      19                  => 'Nineteen',
				      20                  => 'Twenty'
				      );
		
		$index1=0;
		$index2=0;
		$index3=0;
		$index4=0;
		$index5=0;
		$sum=0;
		$sum1=0;
		$sum2=0;
		$sum3=0;
		$sum4=0;
		$sum5=0;
		$sum6=0;
		while($i>=$j)
		{$index=0;
		echo '
		<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">'.$dictionary[$j].' Attribute Filled In</font></b></td>';
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=1)
		{echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index1]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index1]==$j)
		{$sum1+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index1];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index1];
		  $index1++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=2)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index2]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index2]==$j)
		{$sum2+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index2];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index2];
		  $index2++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=3)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index3]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index3]==$j)
		{ $sum3+= $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index3];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index3];
		  $index3++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=4)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index4])&& $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index4]==$j )
		{$sum4+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index4];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index4];
		  $index4++;
		}
		else
		echo '0';
		$index++;
		echo  '</font></td>';
		}
		if(count($attribute_name['IM_SPEC_MASTER_DESC'])>=5)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00"><font color="#000000">';
		///////////
		if(isset($attribute_name['IM_SPEC_MASTER_DESC'][$index]) && isset( $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index5]) && $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['FILLED_ATTRIBUTE'][$index5]==$j )
		{$sum5+=$att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index5];
		  echo  $att_data[$attribute_name['IM_SPEC_MASTER_DESC'][$index]]['TOTAL_FILLED'][$index5];
		  $index5++;
		}
		else
		echo '0';
		$index++;
		echo '</font></td>';
		}
		echo '
		<td style="border-top: 1px solid #000000; border-bottom: 1px sol$rec_otherid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="80" sdnum="1033;"><font color="#000000">';
		if((isset($total_bl['FILLED_ATTRIBUTE'][$k]) and $total_bl['FILLED_ATTRIBUTE'][$k]==$j))
		 {
		 if(isset($total_bl['TOTAL_BL'][$k]))
		  {if($j!=0)
		   $sum6+=$total_bl['TOTAL_BL'][$k];
		  echo $total_bl['TOTAL_BL'][$k];
		   }
		  else 
		   echo '0';
		    $k++;
		 }  
		else 
		echo '0';
		
		echo '</font></td>
	        </tr>';
	        $j++;
	        }
	         echo '
	       <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Total with Attributes Filled in </font></b></td>';
		
		$ii=0;
		$x=0;
		while(($i-1)>=$ii)
		{$x=$ii+1;
		  if($x==6)break; 
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">
		</font>'.${"sum$x"}.'</td>';
		$ii++;
		}
		$x=$ii+1;
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">
		</font>'.$sum6.'</td>';
		echo '</tr>';
	       echo '
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="center" valign=middle><b><font color="#000000">Number of Buy/Lead Enquiry with Other Option Filled in </font></b></td>';
		 $ii=0;
		$cnt=0;
		while(($i-1)>=$ii)
		{
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">';
		if(isset($rec_other['OTHER_COUNT'][$ii]))
		{$cnt+=$rec_other['OTHER_COUNT'][$ii];
		echo $rec_other['OTHER_COUNT'][$ii];
		}
		else '0';
		echo '</font></td>';
		$ii++;
		}
		echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#FFFF00" sdval="1" sdnum="1033;"><font color="#000000">'.$cnt.'</font></td>';
		
	echo '	
	</tr></table>
<!-- ************************************************************************** -->
</body>

</html>';
}
else
echo '<center style="font-family:arial;font-size:14px;font-weight:bold;">No Record Found</center>';
}
