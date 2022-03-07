 <?php
 
 
if($submit)
{
 echo '<html>
       <body>
 <table width="100%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; font-family:arial;" align="center" bgcolor="#F7F8E0">
                        <tr>
                          <td align="center" width="50%" valign="top">
 			<table width="90%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; font-family:arial;" align="center">
 				<tr>
 				<td align="center" bgcolor="#f6f6f6" width="18%" style="font-weight:bold;padding:4px;text-align:left;">Table Desc</td>';
 
       
                  if(isset($array2['IIL_MASTER_DATA_TYPE_TAB_DESC'][0]))
                  {
                  echo '
 				<td align="center" bgcolor="#fff" style="padding:4px;text-align:left;">'.$array2['IIL_MASTER_DATA_TYPE_TAB_DESC'][0].'</td>
 				';
                  }
                  else{
                  echo '
 				<td align="center" bgcolor="#fff" style="padding:4px;text-align:left;"></td>
 				';
                   
                   
                   }
 				
 			echo '	</tr>

 
 			</table> 
 			</td>
 			<td align="center" width="50%" valign="top">
 			<table width="90%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; font-family:arial;" align="center">
 				<tr>
 				<td align="center" bgcolor="#f6f6f6" width="18%" style="font-weight:bold;padding:4px;text-align:left;">Table Usage</td>';
                          
 				
 	if(isset($array2['IIL_MASTER_DATA_TYPE_TAB_USAGE'][0])){			
     echo '<td align="center" bgcolor="#fff" style="padding:4px;text-align:left;">'.$array2['IIL_MASTER_DATA_TYPE_TAB_USAGE'][0].'</td>';
 		      
 		      }
 		      else
 		      {
 		      echo '<td align="center" bgcolor="#fff" style="padding:4px;text-align:left;"></td>';
 		      }
 		      
 		      echo '</tr>
               
 
 			</table>
 
 			</td>
                        </tr>
                      </table>
 			
 			<BR>
 			
                        
                      <table  width="100%" border="0" cellpadding="5" cellspacing="1" style="font-size:12px; font-family:arial;" align="center">
                            <tr style="font-weight:bold">
                               <td align="center" bgcolor="#ccccff">Table Name</td>   
                               <td align="center" bgcolor="#ccccff">Column Name</td>
                               <td align="center" bgcolor="#ccccff">Comments</td>
                               <td align="center" bgcolor="#ccccff">Flag</td>
                               <td align="center" bgcolor="#ccccff">Flag Value Text</td>
                            </tr>';
                            
                           
        $i=0;
        foreach($array2 as $item1)
	{
	foreach($item1 as $item)
	{
       
                   echo '
                   
                            <tr>
                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_TYPE_TABLE'][$i].'</td>
                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_TYPE_COLUMN'][$i].'</td>
                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_TYPE_COMMENTS'][$i].'</td>
                               <td bgcolor="#eaeae"  align="center">'.$array2['IIL_MASTER_DATA_VALUE'][$i].'</td>
                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_VALUE_TEXT'][$i].'</td>
                            </tr>
                            ';
                $i++; 
                           }
                           break;
                           }
                    echo '</table>';  
                    
           
      
         echo '</body>
         </html>
';
}
?>