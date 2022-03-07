<?php 
$pre=isset($_REQUEST['dateflag'])?$_REQUEST['dateflag']:'1';
     if($pre==1){
                        $head="Pre 7 Days of Int Quality Scores";
                    }elseif($pre==2){
                        $head="Pre 7 Days of Ext Quality Scores";
                    }elseif($pre==3){
                        $head="Post 7 Days of Int Quality Scores";
                    }elseif($pre==4){
                        $head="Post 7 Days of Ext Quality Scores";
                    } 
             echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr style="background: #0195d3; color: white;">
                        <td colspan="7" align="center" style="padding:4px;"><b>'.$head.' for EmpId-'.$AssociateId.' </b></td>
                    </tr>';

                $tot_records = count($dataArr);
                $qualitypass = 0;
                $cnt = 0;
                $html = '';
                $row_num = 0;
                if ($tot_records > 0) {
                    for ($i = 0;$i < count($dataArr);$i++) {
                        if ($i == 0) {
                        } else {
                            $qualitypass = $qualitypass+$dataArr[$i][24];
                        }
                    }
                }
                $totalaudit = count($dataArr) - 1;
                if (count($dataArr) > 1) {
                    
                    echo '
                    <tr style="background: #dff8ff; color: white;">
                        <td style="padding:4px;font-weight:bold;">Total Audits</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Quality Score (Including Noise and Formatting)</td>' . '</tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">' . $totalaudit . '</td>' . '
                        <td align="center" style="padding:4px;">' . $qualitypass . '</td>' . '</tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">%</td>' . '
                        <td align="center" style="padding:4px;">' . round((($qualitypass / $totalaudit) * 100), 2) . '</td>' . '</tr>
                    ';
                    
                } else {
                    echo '<tr><td style="padding:4px;font-weight:bold;text-align:center;">No Records Found</td></tr>';
                }
                echo '</table>';
            
       

echo '<div style="clear:both;"><!-- --></div></div>';
?>
