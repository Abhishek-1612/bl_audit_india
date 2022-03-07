<?php 
            if($stype=='AUTO'){
                $tot_records = count($dataArr);
                $q1 =$q2=$q3=$q4=$q5=$q6=$q7= 0;
                
                $prevId = '';
                $cnt = 0;
                $html = '';
                $row_num = 0;
                if ($tot_records > 0) {
                    $html.= '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                    for ($i = 0;$i < count($dataArr);$i++) {
                        if ($i == 0) {
                            $html.= '<tr style="background: #0195d3; color: white;"><td style="padding:4px;">S No</td>' . '<td style="padding:4px;">' . $dataArr[$i][0] . '</td>                         
                                      <td style="padding:4px;">' . $dataArr[$i][1] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][3] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][4] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][13] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][14] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][15] . '</td>
                                      <td style="padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                        } else {
                            $remark_display = 0;
                            if ($dataArr[$i][7] == '-') {
                                $remark_display = 1;
                            }
                            if($dataArr[$i][8]=='Pass'){
                            $q1 = $q1 + 1;
                            }
                            if($dataArr[$i][9]=='Pass'){
                            $q2 = $q2 + 1;
                            }
                            if($dataArr[$i][10]=='Pass'){
                            $q3 = $q3 + 1;
                            }
                            if($dataArr[$i][11]=='Pass'){
                            $q4 = $q4 + 1;
                            }
                            if($dataArr[$i][12]=='Pass'){
                            $q5 = $q5 + 1;
                            }
                            if($dataArr[$i][13]=='Pass'){
                            $q6 = $q6 + 1;
                            }
                           if(($dataArr[$i][8]=='Pass') && ($dataArr[$i][9]=='Pass') && ($dataArr[$i][10]=='Pass') && ($dataArr[$i][11]=='Pass') 
                                   && ($dataArr[$i][12]=='Pass') && ($dataArr[$i][13]=='Pass')){
                                $dataArr[$i][14]=1;
                               $q7 = $q7 + 1; 
                            }else{
                                $dataArr[$i][14]=0;
                            }
                            
                            $html.= '<tr><td style="padding:4px;">' . $i . '</td><td style="padding:4px;">' . $dataArr[$i][0] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][1] . '</td>
                                    <td style="padding:4px;width:100px;">' . $dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">
                                      <a href="#" onclick="javascript:window.open(\'index.php?r=admin_eto/auditEto/Auditedit/stype/'.$stype.'/audit_id/' . $dataArr[$i][3] . '/ven_app/' . $vendor_approve . '/ven_audit/' . $vendor_audit . '/sd/' . $start_date . '/ed/' . $end_date . '/offer_id/' . $dataArr[$i][4] . '/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      ' . $dataArr[$i][3] . '</a>';
                            $html.= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . $dataArr[$i][4] . '&go=Go&mid='.$mid.'" style="text-decoration:none;color:#0000ff" target="_blank">' . $dataArr[$i][4] . '</a></td>
                                      <td style="padding:4px;">' . $dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][13] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][14] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][15] . '</td>
                                   ';
                            if ($dataArr[$i][16] == 'No') {
                                $html.= '<td style="padding:4px;position:relative;"><div id="Rebuttal_div' . $i . '">'
                                        . '<input type="button" name="Raise_Rebuttal" id="Raise_Rebuttal" value="Raise Rebuttal" '
                                        . 'onclick="showCmplntForm(' . $dataArr[$i][3] . ',' . $dataArr[$i][4] . ',' . $i . ',' . $tot_records . ')"></div>
                                       <div id="cmplnt_div' . $i . '" class="cancel" style="display:none;" ></div>
                                      </td>';
                            } else {
                                $html.= '<td style="padding:4px;"><div id="cmplnt_div' . $i . '">Already Raised</div></td>';
                            }
                            $html.= '</tr>';
                        }
                    }
                    $html.= "</table>";
                }
                $totalaudit = count($dataArr) - 1;
                if (count($dataArr) > 1) {
                    echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                    echo '
                    <tr style="background: #0195d3; color: white;">
                        <td colspan="8" align="center" style="padding:4px;"><b>Quality Score Summary</b></td>
                    </tr>
                    <tr style="background: #dff8ff; color: white;">
                        <td style="padding:4px;font-weight:bold;">Total Audits</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Wrong MCAT Mapping</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Wrong Buylead Approval</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Important specifications missing/ wrongly updated</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Wrong BuyLead Title</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Wrong Contact Details</td>
                        <td  align="center" style="padding:4px;font-weight:bold;">Other Tech Issue</td>
                        <td  align="center" style="padding:4px;font-weight:bold;">Quality Score</td>' . '</tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">' . $totalaudit . '</td>' . '
                        <td align="center" style="padding:4px;">' . $q1 . '</td>' . '
                        <td align="center" style="padding:4px;">' . $q2 . '</td>' . '
                        <td align="center" style="padding:4px;">' . $q3 . '</td>' . '
                        <td align="center" style="padding:4px;">' . $q4 . '</td>' . '
                        <td align="center" style="padding:4px;">' . $q5 . '</td>' . '
                        <td align="center" style="padding:4px;">' . $q6 . '</td>
                            <td align="center" style="padding:4px;">' . $q7 . '</td></tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">%</td>' . '
                        <td align="center" style="padding:4px;">' . round((($q1 / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($q2 / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($q3 / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($q4 / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($q5 / $totalaudit) * 100), 2) . '</td>
                        <td align="center" style="padding:4px;">' . round((($q6 / $totalaudit) * 100), 2) . '</td>
                       <td align="center" style="padding:4px;">' . round((($q7 / $totalaudit) * 100), 2) . '</td>' . '</tr>
                    ';
                    echo '</table>';
                    echo '
                    <br>
                    <br>
                    <table border="1" cellpadding="0" cellspacing="1" width="100%" align="center">
                        <tr>
                            <td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total ' . (count($dataArr) - 1) . ' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="export_dump" id="export_dump" value="Export Dump">
                            </td>
                        </tr>
                    </table>
                    <div style="width:100%;">' . $html . '</div>
                    ';
                } else {
                    echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
                }
        } 
        else{
             
                $tot_records = count($dataArr);
                $callqualitypass = 0;
                $leadqualitypass = 0;
                $McatSupplierpass = 0;
                $Contactpass = 0;
                $qualitypass = 0;

                $callqualitypass_feed = 0;
                $leadqualitypass_feed = 0;
                $McatSupplierpass_feed = 0;
                $Contactpass_feed = 0;
                $qualitypass_feed = 0;

                
                $prevId = '';
                $cnt = 0;
                $html = '';
                $row_num = 0;
                if ($tot_records > 0) {
                    $html.= '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                    for ($i = 0;$i < count($dataArr);$i++) {
                        if ($i == 0) {
                            $html.= '<tr style="background: #0195d3; color: white;"><td style="padding:4px;">S No</td>' . '<td style="padding:4px;">' . $dataArr[$i][0] . '</td>                         
                                      <td style="padding:4px;">' . $dataArr[$i][1] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][3] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][4] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][13] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][14] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][15] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][16] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][17] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][18] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][19] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][20] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][21] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][22] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][23] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][24] . '</td>
                                      
                                      
                                      <td style="padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                        } else {
                            $remark_display = 0;
                            if ($dataArr[$i][7] == '-') {
                                $remark_display = 1;
                            }
                            $html.= '<tr><td style="padding:4px;">' . $i . '</td><td style="padding:4px;">' . $dataArr[$i][0] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][1] . '</td>
                                    <td style="padding:4px;width:100px;">' . $dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">
                                      <a href="#" onclick="javascript:window.open(\'/index.php?mid='.$mid.'&r=admin_eto/auditEto/Auditedit_v1/audit_id/' . $dataArr[$i][3] . '/ven_app/' . $vendor_approve . '/ven_audit/' . $vendor_audit . '/sd/' . $start_date . '/ed/' . $end_date . '/offer_id/' . $dataArr[$i][4] . '/r/' . $remark_display . '/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      ' . $dataArr[$i][3] . '</a>';
                            $html.= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . $dataArr[$i][4] . '&go=Go&mid='.$mid.'" style="text-decoration:none;color:#0000ff" target="_blank">' . $dataArr[$i][4] . '</a></td>
                                      <td style="padding:4px;">' . $dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][13] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][14] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][15] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][16] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][17] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][18] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][19] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][20] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][21] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][22] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][23] . '</td>
                                      <td style="padding:4px;">' . $dataArr[$i][24] . '</td>
                                   ';
                            if ($dataArr[$i][29] == 'No') {
                                $html.= '<td style="padding:4px;position:relative;"><div id="Rebuttal_div' . $i . '"><input type="button" name="Raise_Rebuttal" id="Raise_Rebuttal" value="Raise Rebuttal" onclick="showCmplntForm(' . $dataArr[$i][3] . ',' . $dataArr[$i][4] . ',' . $i . ',' . $tot_records . ')"></div>
                                       <div id="cmplnt_div' . $i . '" class="cancel" style="display:none;" ></div>
                                      </td>';
                            } else {
                                $html.= '<td style="padding:4px;"><div id="cmplnt_div' . $i . '">Already Raised</div></td>';
                            }
                            $html.= '</tr>';
                            $leadqualitypass = $leadqualitypass + $dataArr[$i][19];
                            $McatSupplierpass = $McatSupplierpass + $dataArr[$i][20];
                            $callqualitypass = $callqualitypass + $dataArr[$i][21];
                            $Contactpass = $Contactpass + $dataArr[$i][22];
                            $qualitypass = $qualitypass+$dataArr[$i][24];

                            $callqualitypass_feed = $callqualitypass_feed+$dataArr[$i][26];
                            $leadqualitypass_feed = $leadqualitypass_feed+$dataArr[$i][25];
                            $McatSupplierpass_feed = $McatSupplierpass_feed+$dataArr[$i][27];
                            $Contactpass_feed = $Contactpass_feed+$dataArr[$i][28];


                            
                        }
                    }
                    $html.= "</table>";
                }
                $totalaudit = count($dataArr) - 1;
                if (count($dataArr) > 1) {
                    echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                    echo '
                    <tr style="background: #0195d3; color: white;">
                        <td colspan="7" align="center" style="padding:4px;"><b>Quality Score Summary</b></td>
                    </tr>
                    <tr style="background: #dff8ff; color: white;">
                        <td style="padding:4px;font-weight:bold;">Total Audits</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Call Quality-Pass</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Lead Quality-Pass</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Mcat/Supplier Selection-Pass</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Contact Details-Pass</td>' . '
                        <td align="center" style="padding:4px;font-weight:bold;">Quality Score (Including Noise and Formatting)</td>' . '</tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">' . $totalaudit . '</td>' . '
                        <td align="center" style="padding:4px;">' . $callqualitypass . '</td>' . '
                        <td align="center" style="padding:4px;">' . $leadqualitypass . '</td>' . '
                        <td align="center" style="padding:4px;">' . $McatSupplierpass . '</td>' . '
                        <td align="center" style="padding:4px;">' . $Contactpass . '</td>' . '
                        <td align="center" style="padding:4px;">' . $qualitypass . '</td>' . '</tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">%</td>' . '
                        <td align="center" style="padding:4px;">' . round((($callqualitypass / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($leadqualitypass / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($McatSupplierpass / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($Contactpass / $totalaudit) * 100), 2) . '</td>' . '
                        <td align="center" style="padding:4px;">' . round((($qualitypass / $totalaudit) * 100), 2) . '</td>' . '</tr>
                    ';
                    echo '
                    <tr>
                        <td align="center" style="padding:4px;">Feedback</td>' . '
                        <td align="center" style="padding:4px;">' . $callqualitypass_feed . '</td>' . '
                        <td align="center" style="padding:4px;">' . $leadqualitypass_feed . '</td>' . '
                        <td align="center" style="padding:4px;">' . $McatSupplierpass_feed . '</td>' . '
                        <td align="center" style="padding:4px;">' . $Contactpass_feed . '</td>' . '
                        <td align="center" style="padding:4px;"> </td>' . '</tr>
                    ';
                    echo '</table>';
                    echo '
                    <br>
                    <br>
                    <table border="1" cellpadding="0" cellspacing="1" width="100%" align="center">
                        <tr>
                            <td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total ' . (count($dataArr) - 1) . ' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="export_dump" id="export_dump" value="Export Dump">
                            </td>
                        </tr>
                    </table>
                    <div style="width:100%;">' . $html . '</div>
                    ';
                } else {
                    echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
                }
       }
?>