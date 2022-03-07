<?php

 echo '<html>
         <head>';
	if ($EnableFlag == 1)
	{
	     echo '<title>Enable Alerts Details</title>';
	}
        else
        {
	    echo '<title>Disable Alerts Details</title>';
	}
	
	echo '<style>.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px; font-family:arial}
	.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;font-family:arial}
	.ttext1{font-size:12px; padding:4px 4px 4px 4px;font-family:arial}
	.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}</style>
	</head>
         <body>
         <div>
         <table width="100%" bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<TR  bgcolor="#dddddd">
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Product Categories</td>
		<td align="LEFT" width="33%"  bgcolor="#f5f5f5" class="th-heading">Date</td>';
		if ($EnableFlag == 1)
		{
		echo '<td width="34%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Enabled By</td>';
		}
		else
		{
		echo '<td width="34%" align="LEFT" bgcolor="#f5f5f5" class="th-heading">Disabled By</td>';
		}
	 echo '</TR>';
         
      while($rec =$sth->read())
            {   
             $rec=array_change_key_case($rec, CASE_UPPER);  
               if(isset($rec['GLCAT_MCAT_IS_GENERIC']))
		{$rec['GLCAT_MCAT_IS_GENERIC'] = $rec['GLCAT_MCAT_IS_GENERIC'];}
		else
		{$rec['GLCAT_MCAT_IS_GENERIC']=0;}
                echo '<TR  bgcolor="#dddddd">';
		if($rec['GLCAT_MCAT_IS_GENERIC'] > 0)
		{
		 echo '<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['GLCAT_MCAT_NAME'].'<span style="color:red;font-weight:bold;">*</span></td>';
		}
		else 
		{
		echo '<td align="LEFT" width="16%"  bgcolor="#EFFBFB" class="ttext">'.$rec['GLCAT_MCAT_NAME'].'</td>';
		}
		echo '<td align="LEFT"  bgcolor="#EFFBFB" class="ttext">'.$rec['ETO_TRD_ALERT_DATE'].'</td>
		<td align="LEFT" bgcolor="#EFFBFB" class="ttext">'; 
		if(isset($rec['ETO_TRD_ALERT_BY'])  &&  $rec['ETO_TRD_ALERT_BY'] == -1)
		{
		$rec['ETO_TRD_ALERT_BY'] = 'User';
		}
		elseif(isset($rec['ETO_TRD_ALERT_BY']) && $rec['ETO_TRD_ALERT_BY'] == 0)
		{
		$rec['ETO_TRD_ALERT_BY'] = 'Scheduler';
		}
		else
		{
		$rec['ETO_TRD_ALERT_BY'] = 'Admin'.'-'.''.$rec['ETO_TRD_ALERT_BY'].'';
		}
		echo ''.$rec['ETO_TRD_ALERT_BY'].'</td>
		</TR>';
            }
          
         

         echo '</table></div>
         </body></html>'; 



?>