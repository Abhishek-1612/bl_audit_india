<?php 
    $subtype=isset($_REQUEST['subtype']) ? $_REQUEST['subtype'] : '';
    $vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : ''; 
    $time=isset($_REQUEST['HR']) ? $_REQUEST['HR'] : '';
    $start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
    $prtype=isset($_REQUEST['prtype']) ? $_REQUEST['prtype'] : '';
    $totalRecords=isset($_REQUEST['totalcount']) ? $_REQUEST['totalcount'] : 0;
      $flag=0;
      $fresh=0;
      for($i=0;$i<count($data);$i++)
      {
       if($data[$i]['CALL_DURATION']==-1)
       {
        $flag++;
       }
       else
       {
        $fresh++;
       }
      }
      $tot = $flag+$fresh;

      echo '<table style="background-color: #FFFFFF;width: 1300px;">
      <tr>
          <td width = "90%" align="left" height="30" style="font-family:arial;font-size:14px;font-weight:bold;">';
              if($totalRecords > 0){                               						
                       $total_pg=ceil($totalRecords/5000);
                       $nextStart=1;
                       $nextEnd=5000;
                       for($i=1;$i<=$total_pg;$i++){                                                    
                          echo '<a style="background-color: #009DCC;font-weight: bold;height: 25px;width: auto;border: 1px solid #CCCCCC;color: #FFFFFF; margin-right: 10px; padding:3px;text-decoration:none;"class="pagina" href="http://'.$_SERVER['SERVER_NAME'].'/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&rtype=Detail&export=yes&mid='.$mid.'&total_records='.$totalRecords.'&start_date='.$start_date.'&subtype='.$subtype.'&HR='.$time.'&prtype='.$prtype.'&vendor='.$vendor.'&start='.$nextStart.'&end='.$nextEnd.'"&mid=3443> Page  '.$i. '  </a> ';
                          $nextStart=$nextStart+5000;
                          $nextEnd=$nextEnd + 5000;
                       }
              }
echo'
      </td></tr>
      </table>



                <html><head> <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
                <body>
                <form name="export" method="post" action="/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&rtype=Detail&export=yes&mid='.$mid.'">
                <table border=1>
                <tr>
                <td width="10%" align="left"><b>Flag(-1) = '.$flag.'</b></td>                
                <td width="10%" align="left"><b>Fresh(null) = '.$fresh.'</b></td>                
                <td width="10%" align="left"><b>Total = '.$tot.'</b></td>
                <td width="70%" align="left"><font color="red"><b>Only 100 Records as sample shown. To get more use export to excel feature.</b></font></td>    
                </tr>
                <tr>
                <td align="center" colspan="4">
                <input type="hidden" name="subtype" value="'.$subtype.'">
                <input type="hidden" name="vendor" value="'.$vendor.'">
                <input type="hidden" name="HR" value="'.$time.'">
                <input type="hidden" name="start_date" value="'.$start_date.'">
                <input type="hidden" name="prtype" value="'.$prtype.'">';


                echo'
                </td>

                </tr>
                </table>
                </form>
                <table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<tr>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>S.No.</b></td>
                <td  style="text-align:center;" bgcolor="#dff8ff" width="70px"><b>Auth ID</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="50px"><b>VENDOR NAME</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>GLUSER ID</b></td>
        	<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>MOBILE NUMBER</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>SEND DATE</b></td>
                <td  style="text-align:center;" bgcolor="#dff8ff" width="70px"><b>UPDATE DATE</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="50px"><b>CALL ATTEMPT DATE</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>CALL DURATION</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="70px"><b>CALL DISPOSITION</b></td>
		</tr>';

$sr_no=1;
for($i=0;$i<count($data);$i++)
{  
    if($i==100){
        exit;
    }
    echo '<tr>
        <td  style="text-align:center;" >'.$sr_no.'</td>
        <td  style="text-align:center;" >'.$data[$i]['LEAP_AUTH_ID'].'</td>
        <td  style="text-align:center;" >'.$data[$i]['LEAP_VENDOR_NAME'].'</td>
        <td  style="text-align:center;" >'.$data[$i]['FK_GLUSR_USR_ID'].'</td>
        <td  style="text-align:center;">'.$data[$i]['MOBILE_NO'].'</td>
        <td  style="text-align:center;">'.$data[$i]['SEND_DATE'].'</td>
        <td  style="text-align:center;">'.$data[$i]['UPDATE_DATE'].'</td>
        <td  style="text-align:center;" >'.$data[$i]['CALL_ATTEMPT_DATE'].'</td>
        <td  style="text-align:center;" >'.$data[$i]['CALL_DURATION'].'</td>
        <td  style="text-align:center;" >'.$data[$i]['CALL_DISPOSITION'].'</td>
        </tr>

';
$sr_no++;
}

echo '</table>
</body>
</html>';

?>