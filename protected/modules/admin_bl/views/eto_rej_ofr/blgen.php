<?php
 
  echo '<html>
         <head><title>Users with > 0 Available Credits & >5 mapping but <=10 Buylead generation in last 30 days</title>
	<style>.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px; font-family:arial}
	</style>
	</head>
        <body>
        <table width="100%" bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<tr>
	<td colspan="8" align="CENTER" bgcolor="#e8f3f7" style="font-family: arial; font-size: 20px; font-weight: bold; border:1px solid #d2e2e8;color:#000099;">Users with > 0 Available Credits & >5 mapping but <=10 Buylead generation in last 30 days(Indian Only)</td>
	</tr>
	<TR  bgcolor="#dddddd">
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Gluser-Id</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">BL Generated</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Category Mappings</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Available Credits</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">CustType Weight</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">User URL</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Free Showroom URL</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Paid Showroom URL</td>
	</TR>';
      while($rec =$sth->read())
            {   
             $rec=array_change_key_case($rec, CASE_UPPER);  
		echo '<TR  bgcolor="#dddddd">
		<td align="right" width="16%"  bgcolor="#EFFBFB" class="ttext"><strong>'.$rec['GLUSR_USR_ID'].'</strong></td>
		<td align="center"  bgcolor="#EFFBFB" class="ttext">'.$rec['LEADS'].'</td>
		<td align="center"  bgcolor="#EFFBFB" class="ttext">'.$rec['MCAT_COUNT'].'</td>
		<td align="center"  bgcolor="#EFFBFB" class="ttext">'.$rec['CREDITS_AVAIL'].'</td>
		<td align="center"  bgcolor="#EFFBFB" class="ttext">'.$rec['CUST_WEIGHT'].'</td>
		<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['USR_URL'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['FREEUSR_URL'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['PAIDUSR_URL'].'</td></TR>';
        }
        echo '</table></div></body></html>';
	


?>