<?php 
//print_r($result);

$errArr = isset($result['errArr'])?$result['errArr']:'';
$recResult = $result['rec'];
$totalOffers = isset($result['totalOffers'])?$result['totalOffers']:'';
$totalRows = isset($result['totalRows'])?$result['totalRows']:'';
$critHash = isset($result['critHash'])?$result['critHash']:'';
$status = isset($result['status'])?$result['status']:'';
$last = isset($result['last'])?$result['last']:'';
$rowCounter=0; 
 ?>
<HTML>         	
<script language="javascript" type="text/javascript" src="http://gladmin.intermesh.net/js/jquery.min.js" ></script>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
<style>.td_head {color: #000;font-family: arial;font-size: 12px;padding: 0px 0px;}
.pg_head {color: #000;background: #fff;font-family: arial;font-size: 14px;height: 13px;padding: 4px 5px;}
p.test {width: 11em;word-wrap: break-word;
}</style>
<SCRIPT>
function load_fenqdata(offer,mem,memmail,memmobile,last,ph_country){ 
            var post_data = {offer:offer, mem:mem,memmail:memmail,memmobile:memmobile,ph_country:ph_country,last:last}; 
            $.ajax({
                 url:"/index.php?r=admin_eto/AdminEto/ofrSearcharch&action=buyleads&start=0&status=ALL&type=B&go=Go&addfend=fenqdata&mid=3424",
                 type: 'post',
                 data: post_data,
                 success:function(result){
                     $("#glusr_details").html(result);

                 }
             });
        }
</script>
</HEAD>
            <body>
                
            <?php 
            echo '<div style="font-size:14px;align:center;color: #333399;"><b>Data From Archive Tables</b></div><br>';
            if(!empty($recResult)){ ?>            
           <div>
           <?php       
       	echo '<FORM name="adminForm" METHOD="post" ACTION="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&mid=3424" STYLE="margin-top:0;margin-bottom:0;">
            <TABLE style="width: 100%;" BORDER="1" bordercolor ="#bedaff" CELLPADDING="0" CELLSPACING="0">';

		$waiting_flag = 0;$flagRecFound=1;
         	foreach($recResult as $recK => $rec) {       	
                    $offerID = $rec['ETO_OFR_ID'];
                    $curStatus = $rec['ETO_OFR_APPROV'];
                   
                    $rowCounter++;
                    $start=isset($start)?$start:0;
                    $tableColorFlag=0; $tableType=$rec['TABLE_TYP'];$sn=$start + $rowCounter;$status= '';$empname='';$date_values=$glid=$glstatus='';
                    
              echo '<TR style="background: #dff8ff;"><TD algn="center" class="td_head" width="2%"></td> 
                  <td class="td_head" width="75%"><TABLE WIDTH="100%" BORDER="0" bordercolor ="#3f80d8" CELLPADDING="0" CELLSPACING="0"><tr style="color: #333399; background: #dff8ff;">
                        <TD class="td_head" width="15%"><b>GLID:</b>  <A HREF="javascript:popup(\'/index.php?r=admin_eto/AdminEto/admincontact&mem='.$rec["GLUSR_USR_ID"].'&mid=3424\');">'.$rec['FK_GLUSR_USR_ID'].'</A> ['.$userStatusDesc[$rec['GLUSR_USR_APPROV']].']</TD>
                          <TD class="td_head" width="15%"><b>ID:</b> '.$rec['ETO_OFR_ID'];                       
                        echo '</TD>
                        <TD class="td_head" width="25%"><b>Posted Date:</b> '.$rec['OFFER_DATE'].'</TD>';
                        echo '<TD class="td_head" width="25%">';
                         if($rec['OFR_STATUS'] == 'D'){
                            $date_values='&ad=&dd='.$rec['APPROV_DATE'].'&pd='.$rec['OFFER_DATE'];
                            $status= 'Deleted';
                            $empname='<b>Del By: </b>'.$rec["GL_EMP_NAME"];
                            echo '<b>Del Date Orig: </b>'.$rec['APPROV_DATE'].'</TD><TD class="td_head" width="20%"><b>Del Date:</b> '.$rec['APPROV_DATE'];
                        }elseif($rec['OFR_STATUS'] == 'W'){
                            $empname='<b>&nbsp;&nbsp; </b>';
                            $date_values='&ad=&dd=&pd='.$rec['OFFER_DATE'];
                            $status= 'Waiting';
                            echo '<b>App Date Orig: </b></TD><TD class="td_head" width="20%"><b>App Date:</b> '.$rec['APPROV_DATE'];
                        }elseif($rec['OFR_STATUS'] == 'E'){
                            $date_values='&ad='.$rec['OFFER_DATE'].'&dd=&pd='.$rec['OFFER_DATE'];
                            $status= 'Expired';
                            $empname='<b>App By: </b>'.$rec["GL_EMP_NAME"];
                            echo '<b>App Date Orig: </b>'.$rec['APPROV_DATE'].'</TD><TD class="td_head" width="20%"><b>App Date:</b> '.$rec['APPROV_DATE'];  
                        }else{
                            $date_values='&ad='.$rec['OFFER_DATE'].'&dd=&pd='.$rec['OFFER_DATE'];
                            $status= 'Approved';
                            $empname='<b>App By: </b>'.$rec["GL_EMP_NAME"];
                            echo '<b>App Date Orig: </b>'.$rec['APPROV_DATE'].'</TD><TD class="td_head" width="20%"><b>App Date:</b> '.$rec['APPROV_DATE'];
                        }
                        echo '</td></TR> 
                       </table>
                       </td>
                       <TD class="td_head" width="15%"><b>Pool:</b> '.$rec['POOL_TYPE'].'</TD>
                       </tr>
                        <TR style="background: #fff;"><td align="center" >'.$sn.'</td>'
                                . '<TD><TABLE WIDTH="100%" BORDER="0" bordercolor ="#3f80d8" CELLPADDING="0" CELLSPACING="0" style="background: #fff;"><tr><td colspan="5"><b>Title: </b>'.$rec["ETO_OFR_TITLE"].'</td>
                                    </tr>
                        <TR><TD colspan="5"><b>Description: </b><p class="test">';       
                            $desc_br = substr($rec['ETO_OFR_DESC'],0,256);
                            $desc_br = htmlspecialchars_decode($desc_br);
                             echo nl2br($desc_br);
                         if ($rec['ETO_OFR_DESC'] && strlen(($rec['ETO_OFR_DESC']) > 256)) {
                                     echo "...";
                         }
                        echo '</p></td></tr>';
                        echo '<tr><TD   colspan="5"><b>MCAT: </b>';
                                    if(isset($rec['GLCAT_CAT_NAME']))
                        {
                            echo $rec['GLCAT_CAT_NAME'];
                        }
                        else
                        {
                            echo 'Undefined Category';
                        }

                        if(isset($rec['GLCAT_MCAT_NAME']))
                        {
                            echo ' &gt;&gt; '.$rec["GLCAT_MCAT_NAME"].'';
                        }
                        $recording='';
                       if (isset($rec['CALL_RECORDING_URL']))
                        {                           
                            $prim1=$rec['CALL_RECORDING_URL'];
                            $recording= '<A href="'.$prim1.'" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';		
                        }else{
                            $recording= '<b style="color:#0000ff">&#187;&nbsp;Recording Not Available </b>';                    
                        }
                        echo '</TD></tr>';
                        echo '<tr><TD  width="15%">'.$empname.'</td>'
                        . '<TD  width="15%"><b>Centre: </b>'.$rec["ETO_LEAP_VENDOR_NAME"].'</td>'
                        . '<TD width="25%"><b>'.$recording.'</b></td>
                         <TD width="25%"><b>Source: </b>'.$rec["SOURCE"].'</td>
                         <TD width="20%"><b>MODID: </b>'.$rec["FK_GL_MODULE_ID"].'</td>    
                        </tr></table></td><TD class="td_head" ><TABLE WIDTH="100%" BORDER="0" bordercolor ="#3f80d8" CELLPADDING="0" CELLSPACING="0" style="background: #fff;"><tr><td class="td_head" ><b>Status: </b>';
                       
                        echo $status.'</td></tr>';   
                                if($rec["SOURCE"]=='DIRECT'){
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfferDetail/editflaggedleads&mid=3424&tableflag=TA&offer='.$offerID.'&status='.$rec['OFR_STATUS'].'&mid=3424">View</A></td></tr>';
                                }else{
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfferDetail/editflaggedleads&mid=3424&tableflag=FA&offer='.$offerID.'&status='.$rec['OFR_STATUS'].'&mid=3424">View</A></td></tr>';
                                }                                                             
                                if ($lvl_code=='E' || $lvl_code=='V') {
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer='.$offerID.'&mid=3424">Offer History<a></td></tr>';
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfrHist/etohistory&act=locking'.$date_values.'&offer='.$offerID.'&postby='.$rec['ETO_OFR_APPROV'].'&mid=3424">Locking History<a></td></tr>';
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/AdminEto/vieweditenrichment&offer='.$offerID.'&status='.$rec['ETO_OFR_APPROV'].'&modid='.$rec['FK_GL_MODULE_ID'].'&tabletype='.$tableType.'&mid=3424">Enrichment Detail<a></td></tr>';
                                }
                                echo '</table></td></tr>';
             }	
		
	echo '</TABLE>		
		</FORM></DIV>';
    	
            }else {
                 echo '<DIV ALIGN="center" style="color:red">No Offer Found</DIV><BR><BR>';
            }

                  echo '</BODY>
                </HTML>
                 ';