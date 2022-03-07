<?php       
       echo '<html>
         <head><title>User Having Less Than Or Equals to 5 BL Alert Category</title>
	<style>.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px; font-family:arial}
	</style>
	</head>
        <body>
        <table width="100%" bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<tr>
	<td colspan="8" align="CENTER" bgcolor="#e8f3f7" style="font-family: arial; font-size: 20px; font-weight: bold; border:1px solid #d2e2e8;color:#000099;">Users Having Less Than or equal to 5 BL ALert Categories(Indian Only)</td>
	</tr>
	<TR  bgcolor="#dddddd">
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Gluser-Id</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Available Credits</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">CustType Weight</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">User URL</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Free Showroom URL</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Paid Showroom URL</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Category Count</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Leads Purchased</td>
	</TR>';
      while($rec =$sth->read())
            {   
             $rec=array_change_key_case($rec, CASE_UPPER);  
     
              echo '<TR>
		<td align="right" width="16%"  class="ttext"><strong>'.$rec['FK_GLUSR_USR_ID'].'</strong></td>
		<td align="center"   class="ttext">'.$rec['CREDITS_AV'].'</td>
		<td align="center"   class="ttext">'.$rec['CUSTTYPE_WEIGHT'].'</td>
		<td align="LEFT" width="16%"   class="ttext">'.$rec['USR_URL'].'</td>
		<td align="LEFT"   class="ttext">'.$rec['FREESHOWROOM_URL'].'</td>
		<td align="LEFT"   class="ttext">'.$rec['PAIDSHOWROOM_URL'].'</td>
		<td align="center"  class="ttext">'.$rec['MCATCNT'].'</td>
		<td align="center" class="ttext" ><b>'.$rec['LEADPUR'].'</b></td></TR>';
		
    
    }  
       echo '</table></body></html>';
	


?>