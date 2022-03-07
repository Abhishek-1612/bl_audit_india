<?php
if ($PurchaseFlag == 1)
{
 echo'<html>
         <head><title>Lead Purchase Details</title>
	<style>.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px;font-family:arial}
	.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;font-family:arial}
	.ttext1{font-size:12px; padding:4px 4px 4px 4px;font-family:arial}
	.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}</style>
	</head>
         <body>
         <div>
         <table bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<TR  bgcolor="#dddddd">
		<td align="LEFT" width="10%"  bgcolor="#f5f5f5" class="th-heading">Offer-Id</td>
		<td align="LEFT" width="12%"  bgcolor="#f5f5f5" class="th-heading">Title</td>
		<td width="12%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Purchase-Date</td>
		<td width="12%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Quantity</td>
		<td width="54" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Description</td>

	</TR>';
      while($rec =$sth->read())
            {   
             $rec=array_change_key_case($rec, CASE_UPPER);  
             if(isset($rec['ETO_OFR_QTY']))
		{$rec['ETO_OFR_QTY'] = $rec['ETO_OFR_QTY'];}
		else
		{$rec['ETO_OFR_QTY']= '';}
               echo '<TR  bgcolor="#dddddd">
		<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['OFR_ID'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['TITLE'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['PURCHASE_DATE'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['ETO_OFR_QTY'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['DESCRIPTION'].'</td>
		</TR>';
            }

         echo '</table></div>
         </body></html>';
}

elseif($PurchaseFlag == 2)
{
 echo '<html>
         <head><title>Lead Rejected Details</title>
	<style>
	.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px;font-family:arial}
	.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;font-family:arial}
	.ttext1{font-size:12px; padding:4px 4px 4px 4px;font-family:arial}
	.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}</style>
	</head></head>
         <body>
         <div>
	<table bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<TR  bgcolor="#dddddd">
		<td align="LEFT" width="08%"  bgcolor="#f5f5f5" class="th-heading">Offer-Id</td>
		<td align="LEFT" width="10%"  bgcolor="#f5f5f5" class="th-heading">Title</td>
		<td width="08%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Reject-Date</td>
		<td width="12%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Reject-Reason</td>
		<td width="12%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Quantity</td>
		<td width="05%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Source</td>
		<td width="45" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Description</td>

	</TR>';

      while($rec =$sth->read())
            {   
             $rec=array_change_key_case($rec, CASE_UPPER);  
             
             if(isset($rec['ETO_OFR_QTY']))
		{$rec['ETO_OFR_QTY'] = $rec['ETO_OFR_QTY'];}
		else
		{$rec['ETO_OFR_QTY'] = '';}
		echo '<TR  bgcolor="#dddddd">
		<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['ETO_OFR_ID'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['TITLE'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['REJECT_DT'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['ETO_OFR_REJECT_REASON'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['ETO_OFR_QTY'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['SOURCE'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'.$rec['DETAIL'].'</td>
		</TR>';
            }

        
         echo '</table></div>
         </body></html>';
	
}

?>