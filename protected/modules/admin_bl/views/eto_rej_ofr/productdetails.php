<?php

     echo '<html>
         <head><title>Product-Details</title>
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
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Mcat-Mapping</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Product-Count</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Product-Mapping</td>';
	echo '</TR>';
        if($dbtype=='PG'){
            while($rec = pg_fetch_array($sth))
            {   
                  $rec=array_change_key_case($rec, CASE_UPPER);  
                if(isset($rec['GLCAT_MCAT_IS_GENERIC']))
		{$rec['GLCAT_MCAT_IS_GENERIC']=$rec['GLCAT_MCAT_IS_GENERIC'];}
		else
		{$rec['GLCAT_MCAT_IS_GENERIC'] = 0;}
                
                echo '<TR  bgcolor="#dddddd">';
		if ($rec['GLCAT_MCAT_IS_GENERIC'] > 0)
		{
		echo '<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['MCAT_NAME'].'<span style="color:red;font-weight:bold;">*</span></td>';
		}
		else
		{
		echo '<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['MCAT_NAME'].'</td>';
		}
		echo '<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['PRO_COUNT'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext"><strong>'.$rec['DETAILS'].'</strong></td></TR>';
            }
        }else{
             while($rec = oci_fetch_assoc($sth))
            {   
                if(isset($rec['GLCAT_MCAT_IS_GENERIC']))
		{$rec['GLCAT_MCAT_IS_GENERIC']=$rec['GLCAT_MCAT_IS_GENERIC'];}
		else
		{$rec['GLCAT_MCAT_IS_GENERIC'] = 0;}
                
                echo '<TR  bgcolor="#dddddd">';
		if ($rec['GLCAT_MCAT_IS_GENERIC'] > 0)
		{
		echo '<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['MCAT_NAME'].'<span style="color:red;font-weight:bold;">*</span></td>';
		}
		else
		{
		echo '<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['MCAT_NAME'].'</td>';
		}
		echo '<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['PRO_COUNT'].'</td>
		<td align="LEFT"  bgcolor="#EFFBFB" class="ttext"><strong>'.$rec['DETAILS'].'</strong></td></TR>';
            }
        }
        
         echo '</table></div>
         </body></html>'; 



?>