<?php
 echo '<html>
         <head><title>Offer Purchase Details</title>
	<style>.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px; font-family:arial}
	.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;font-family:arial}
	.ttext1{font-size:12px; padding:4px 4px 4px 4px;font-family:arial}
	.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}</style>
	</head>
         <body>
         <div>
         <table width="100%" bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<TR  bgcolor="#dddddd">
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Gluser-Id</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Company-Name</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Purchase-Date</td>';
	echo '</TR>';
      while($rec =$sth->read())
            {   
             $rec=array_change_key_case($rec, CASE_UPPER);  
               echo '<TR  bgcolor="#dddddd">
		<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['FK_GLUSR_USR_ID'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['GLUSR_USR_COMPANYNAME'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext"><strong>'.$rec['ETO_PUR_DATE'].'</strong></td></TR>';
            }
                 
         echo '</table></div>
         </body></html>';
?>