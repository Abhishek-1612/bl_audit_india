<?php
// print_r($array1);
// var_dump($array1);die;

echo     '<html>
         <head>
         <title>Master Flags Data</title>
         </head>
         <body>   
         <div STYLE="font-family: arial; font-size: 20px; font-weight: bold; color:#8A0829;background-color:#F7F8E0;text-align:center">Master Flag Data Value</div>
         <div style="border:2px solid #F2F2F2;"></div>         
         <div STYLE="font-family: arial; font-size: 20px; font-weight: bold; color:#8A0829;background-color:#F7F8E0;">
         <form action="index.php?r=admin_bl/Eto_iil_master/Index" method="POST">
         <table width="100%">
         <tr>
         <td align="center"><select id="tablename" name="tablename"><option name="">--------select--------</option>';
         
        

         
         $tablename_type=array("1"=>'Table',"2"=>'Procedure',"3"=>'Cron',"4"=>'DB Object');
         
         $i = 0;
        foreach($array1 as $item1)
	{
	foreach($item1 as $item)
	{
 	   
	      $tablename = $array1['IIL_MASTER_DATA_TYPE_TABLE'][$i];
	      $table_type = $array1['TABLE_TYPE'][$i];
	      $rownum = $array1['RN'][$i];
	      if($rownum==1)
	      {
		echo '<optgroup label='.$tablename_type[$table_type].'>';
		}
		echo '<option name="tableopt" value="'.$tablename.'"';
		if(isset($selectopt) && $tablename == $selectopt)
		{
		echo 'selected';
		}
		echo '>'.$tablename.'</option>';
		if($rownum==$array1['TOTRN'][$i])
		{
		echo '</optgroup>';
		}
	$i++;
	}
	break;
	}
         echo '</select>
         &nbsp;&nbsp;
         <input type="hidden" name="action" value="get_cons_rpt">
         <input type="submit" name="submit" value="submit">
         </td>
         </tr>
         </table>
         </form>
         </div>';

// if($submit)
//          {
//          
//         // $tabname =$selectopt;
//         
//          
//          echo '<table width="100%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; font-family:arial;" align="center" bgcolor="#F7F8E0">
//                        <tr>
//                          <td align="center" width="50%" valign="top">
// 			<table width="90%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; font-family:arial;" align="center">
// 				<tr>
// 				<td align="center" bgcolor="#f6f6f6" width="18%" style="font-weight:bold;padding:4px;text-align:left;">Table Desc</td>
// 				<td align="center" bgcolor="#fff" style="padding:4px;text-align:left;">'.$item['IIL_MASTER_DATA_TYPE_TAB_DESC'].'</td>
// 				</tr>
// 
// 
// 			</table>
// 
// 			</td>
// 			<td align="center" width="50%" valign="top">
// 			<table width="90%" border="0" cellpadding="0" cellspacing="1" style="font-size:12px; font-family:arial;" align="center">
// 				<tr>
// 				<td align="center" bgcolor="#f6f6f6" width="18%" style="font-weight:bold;padding:4px;text-align:left;">Table Usage</td>
// 				<td align="center" bgcolor="#fff" style="padding:4px;text-align:left;">'.$item['IIL_MASTER_DATA_TYPE_TAB_USAGE'].'</td>
// 				</tr>
// 
// 
// 			</table>
// 
// 			</td>
//                        </tr>
//                      </table>
// 			
// 			<BR>
// 			
//                        
//                      <table  width="100%" border="0" cellpadding="5" cellspacing="1" style="font-size:12px; font-family:arial;" align="center">
//                            <tr style="font-weight:bold">
//                               <td align="center" bgcolor="#ccccff">Table Name</td>   
//                               <td align="center" bgcolor="#ccccff">Column Name</td>
//                               <td align="center" bgcolor="#ccccff">Comments</td>
//                               <td align="center" bgcolor="#ccccff">Flag</td>
//                               <td align="center" bgcolor="#ccccff">Flag Value Text</td>
//                            </tr>';
//                            
//          
//          do
//             {
//                   echo '
//                            <tr>
//                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_TYPE_TABLE'].'</td>
//                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_TYPE_COLUMN'].'</td>
//                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_TYPE_COMMENTS'].'</td>
//                               <td bgcolor="#eaeae"  align="center">'.$array2['IIL_MASTER_DATA_VALUE'].'</td>
//                               <td bgcolor="#eaeae"  align="left">'.$array2['IIL_MASTER_DATA_VALUE_TEXT'].'</td>
//                            </tr>
//                            ';
//                }while($array2);
//                    echo '</table>';  
//           }
      
         echo '</body>
         </html>
         ';



?>