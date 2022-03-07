<?php 

$flagError = $result['flagError'];
$errArr = $result['errArr'];
$recResult = $result['rec'];
$totalOffers = $result['totalOffers'];
$start = $result['start'];
$totalRows = $result['totalRows'];
$offersPerPage = $result['offersPerPage'];
$critHash = $result['critHash'];
$curPage = $result['curPage'];
$status = $result['status'];
$totalPages = $result['totalPages'];
$last = $result['last'];
$rowCounter=0; $linkStr = '';
foreach($critHash as $cK => $cR){
		if(empty($linkStr)){
			
			$linkStr .= !empty($cR)?$cK."=".$cR."":'';
		} else{
			$linkStr .= !empty($cR)?"&".$cK."=".$cR."":'';		
		}	
	}
	
if ($flagError == 1) {         
  } else {  ?>
<HTML>
<HEAD><TITLE>Buylead Search</TITLE>
<script language="javascript" type="text/javascript" src="http://gladmin.intermesh.net/js/jquery.min.js" ></script>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
<style>.td_head {color: #000;font-family: arial;font-size: 12px;padding: 0px 0px;}
.pg_head {color: #000;background: #fff;font-family: arial;font-size: 14px;height: 13px;padding: 4px 5px;}</style>
            <script type="text/javascript">
            <!--
		function confirmMulDelete()
		{
			var j = 0; 
			var delmuloffersArr = new Array();
			var mem = document.adminForm.mem.value;

			if(document.adminForm.delmulOfrs)
			{
				if(document.adminForm.delmulOfrs[0])
				{
					for (i = 0; i < document.adminForm.delmulOfrs.length; i++) {
						 if(document.adminForm.delmulOfrs[i].checked == true) { 
						  j = 1; 
						  //break;
						  var delmuloffersVal = document.adminForm.delmulOfrs[i].value;
						  delmuloffersArr.push(delmuloffersVal);
						   }
				}
				}
				else
				{
					
					if(document.adminForm.delmulOfrs.checked == true) {  
						j = 1;
						delmuloffersArr.push(document.adminForm.delmulOfrs.value);
					}
				}
			}

			if(j == 1)
			{
				if(document.adminForm.reason.value == '')
				{
					popup2('/index.php?r=admin_eto/AdminEto/showdelreason&action=showdelreason');
					return false;
				}
				else
				{
						
					var bool = confirm("Are you sure you want to delete selected offers? Responses to these offers (if any) will also be deleted.");
					if(bool == true){
						document.adminForm.delmuloffersArr.value = delmuloffersArr;
						document.adminForm.action = "/index.php?r=admin_eto/AdminEto/delmulrecord&mem="+mem;          
						 document.adminForm.submit();
					}
					else {
						return false;					
					}
				}
			}
			else alert("Please select a waiting offer to delete.");
		}

		function confirmDelete(url)
		{
			popup2('/index.php?r=admin_eto/AdminEto/bldeletereason&fromanchor=1&url='+escape(url));
			//popup2('eto-del-reasons.mp?fromanchor=1&url='+escape(url));
			return false;
		}
		
		function confirmDeleteMail(url)
		{
			popup2('/index.php?r=admin_eto/AdminEto/bldeletereason&fromanchor=1&url='+escape(url));
			//popup2('eto-del-reasons.mp?fromanchor=1&url='+escape(url));
			return false;
		}
		
		function confirmDeleteNormal() {
			return confirm("Are you sure you want to delete this offer? Responses to this offer (if any) will also be deleted.");
		}
		
		function popup2(url) {
		window.open(url,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=400,height=500');
		}
	    
            function goback() { history.go(-1)} // End the hiding here.

            function popup(url) {
                 window.open(url,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=350');
            }
             //-->
             
            function postedreport(oferid) 
             {
             
	        window.open("/index.php?r=admin_eto/AdminEto/ofrsearch/ofereportid/"+oferid,"_blank", "left=400,top=100,width=720, height=800,scrollbars=yes, resizable=yes");
	       
	     }
	     
	     function load_fenqdata(type,offer,mem,memmail,memmobile,ph_country,mcat_id){          
             var purl='';
                var post_data = {offer:offer, mem:mem,memmail:memmail,memmobile:memmobile,ph_country:ph_country,mcat_id:mcat_id}; 
                    if(type === 1){
                        purl ="/index.php?r=admin_eto/AdminEto/ofrSearcharch&action=buyleads&start=0&status=E&go=Go&addfend=fenqdata";
                    }else{
                        purl ="/index.php?r=admin_eto/AdminEto/ofrSearcharch&action=buyleads&start=0&status=D&go=Go&addfend=fenqdata";
                    }
               
                $.ajax({
                     url: purl,
                     type: 'post',
                     data: post_data,
                     success:function(result){
                         $("#glusr_details").html(result);                         
                     }
                 });
            }
           function product_detail(mem){ 
                
              window.open("/index.php?r=admin_eto/AdminEto/ofrsearch&Product=detail&go=GO&mid=3424&mem="+mem,"_blank", "left=400,top=100,width=720, height=800,scrollbars=yes, resizable=yes");
            }
    	</script>
    	
    	
    	<!--google analytics async code start-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28761981-2']);
  _gaq.push(['_setDomainName', '.intermesh.net']);
  _gaq.push(['_setSiteSpeedSampleRate', 10]);
  _gaq.push(['_trackPageview','/index.php?r=admin_eto/AdminEto/buyleads&action=etosearch']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end-->

	</HEAD>
            <body>
            <?php if(!empty($recResult)){ ?>            
           <div>
           <?php            
           echo '<div style="font-size:14px;"><FORM name="jumpForm" METHOD="post" ACTION="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&do=livelead" STYLE="margin-top:0;margin-bottom:0;">
           <TABLE WIDTH="100%" BORDER="0" bordercolor ="#bedadd" CELLPADDING="4" CELLSPACING="0">
            <TR>';
           echo '<TD ALIGN="left" class="pg_head">';
           if((!empty($_REQUEST['mem']) || !empty($_REQUEST['memmail']) || !empty($_REQUEST['memmobile']) ||  !empty($_REQUEST['offer'])) && isset($recResult[0]['FK_GLUSR_USR_ID']))
		{
                  echo '<a href="#" onclick="product_detail('."'".$recResult[0]['FK_GLUSR_USR_ID']."'".')">Products We Buy Details</a>';
		  }
              echo '</TD>';     
            	echo '<TD ALIGN="CENTER" class="pg_head">';
              if ($totalOffers > 0) {
                echo '<b>Total '.$totalOffers.' offers found</b>';
              }
              echo '</TD>
            </TD>
            <TD ALIGN="right" class="pg_head">&nbsp;&nbsp;Current Page: '.$curPage.'&nbsp;&nbsp;&nbsp;';
              if($callfrom=='adv_search'){
                  if ($start != 0) {
                    $diff = $start - $offersPerPage;
                     if(isset($result['fenqdata']) and $result['fenqdata']=='fenqdata')
                         {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start=0&status='.$status.'&'.$linkStr.'&go=Go&addfend=fenqdata&mid=3424">First</FONT></A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start='.$diff.'&status='.$status.'&'.$linkStr.'&go=Go&addfend=fenqdata&mid=3424">Previous</FONT></A>]&nbsp;&nbsp;';
                        }
                        else
                        {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start=0&status='.$status.'&'.$linkStr.'&go=Go&mid=3424">First</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start='.$diff.'&status='.$status.'&'.$linkStr.'&go=Go&mid=3424">Previous</A>]&nbsp;&nbsp;';
                        }
                   }
                   if ($start+$totalRows < $totalOffers) {
                        $lastStart=($totalPages*$offersPerPage)-$offersPerPage;
                        if(isset($result['fenqdata']) and $result['fenqdata']=='fenqdata')
                         {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start='.$last.'&status='.$status.'&'.$linkStr.'&go=Go&addfend=fenqdata&mid=3424">Next</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start='.$lastStart.'&status='.$status.'&total='.$totalOffers.'&'.$linkStr.'&go=Go&addfend=fenqdata&mid=3424">Last</A>]';
                        }
                        else
                        {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start='.$last.'&status='.$status.'&'.$linkStr.'&go=Go&mid=3424">Next</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=buyleads&start='.$lastStart.'&status='.$status.'&total='.$totalOffers.'&'.$linkStr.'&go=Go&mid=3424">Last</A>]';
                        
                        }
                   }
              }else{
                  if ($start != 0) {
                    $diff = $start - $offersPerPage;
                     if(isset($result['fenqdata']) and $result['fenqdata']=='fenqdata')
                         {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start=0&status='.$status.'&'.$linkStr.'&go=Go&mid=3424">First</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start='.$diff.'&status='.$status.'&'.$linkStr.'&go=Go&addfend=fenqdata&mid=3424">Previous</A>]&nbsp;&nbsp;';
                        }
                        else
                        {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start=0&status='.$status.'&'.$linkStr.'&go=Go&mid=3424">First</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start='.$diff.'&status='.$status.'&'.$linkStr.'&go=Go&mid=3424">Previous</A>]&nbsp;&nbsp;';
                        
                        }
                   }
                   if ($start+$totalRows < $totalOffers) {
                        $lastStart=($totalPages*$offersPerPage)-$offersPerPage;
                        if(isset($result['fenqdata']) and $result['fenqdata']=='fenqdata')
                         {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start='.$last.'&status='.$status.'&'.$linkStr.'&go=Go">Next</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start='.$lastStart.'&status='.$status.'&total='.$totalOffers.'&'.$linkStr.'&go=Go">Last</A>]'; 
                        }
                        else
                        {
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start='.$last.'&status='.$status.'&'.$linkStr.'&go=Go">Next</A>]&nbsp;&nbsp;';
                        echo '[<A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads&start='.$lastStart.'&status='.$status.'&total='.$totalOffers.'&'.$linkStr.'&go=Go">Last</A>]'; 
                        
                        }
                   }
              }
            
            echo '&nbsp;&nbsp;&nbsp;&nbsp;</TD></TR>
        </TABLE></FORM></DIV>';
           	echo '<FORM name="adminForm" METHOD="post" ACTION="/index.php?r=admin_eto/AdminEto/buyleads&action=buyleads" STYLE="margin-top:0;margin-bottom:0;">
            <TABLE WIDTH="100%" BORDER="1" bordercolor ="#bedaff" CELLPADDING="0" CELLSPACING="0">';

                
        $waiting_flag = 0;$flagRecFound=1;
         	foreach($recResult as $recK => $rec) { 

                    $offerID = $rec['ETO_OFR_ID'];
                    $curStatus = isset($rec['ETO_OFR_APPROV'])?$rec['ETO_OFR_APPROV']:'';                   
                    $rowCounter++;
                    $sn=$start + $rowCounter;$status= '';$empname='';$date_values='';
                    $tableColorFlag=0; $tableType=isset($rec['TABLE_TYP'])?$rec['TABLE_TYP']:''; 
              echo '<TR style="background: #dff8ff;"><TD algn="center" class="td_head" width="2%"></td> 
                  <td class="td_head" width="75%"><TABLE WIDTH="100%" BORDER="0" bordercolor ="#3f80d8" CELLPADDING="0" CELLSPACING="0"><tr style="color: #333399; background: #dff8ff;">
                        <TD class="td_head" width="15%"><b>GLID:</b> <A HREF="javascript:popup(\'/index.php?r=admin_eto/AdminEto/admincontact&mem='.$rec["GLUSR_USR_ID"].'&mid=3424\');">'.@$rec['FK_GLUSR_USR_ID'].'</A> ['.$userStatusDesc[@$rec['GLUSR_USR_APPROV']].']</TD>
                          <TD class="td_head" width="15%"><b>ID:</b> '.@$rec['ETO_OFR_ID'];                        
                        echo '</TD>
                        <TD class="td_head" width="25%"><b>Posted Date:</b> '.@$rec['OFFER_DATE'].'</TD>';
                        echo '<TD class="td_head" width="25%">';
                      if(@$rec['OFR_STATUS'] == 'D'){
                            $date_values='&ad=&dd='.@$rec['APPROV_DATE_ORIG'].'&pd='.$rec['OFFER_DATE'];
                            $status= 'Deleted';
                            $empname='<b>Del By: </b>'.@$rec["GL_EMP_NAME"];
                            echo '<b>Del Date Orig: </b>'.@$rec['APPROV_DATE_ORIG'].'</TD><TD class="td_head" width="20%"><b>Del Date:</b> '.@$rec['APPROV_DATE'];
                        }elseif(@$rec['OFR_STATUS'] == 'W' || @$rec['OFR_STATUS'] == 'F' || @$rec['OFR_STATUS'] == 'P' || @$rec['OFR_STATUS'] == 'Q'){
                            $empname='<b>&nbsp;&nbsp; </b>';
                            $date_values='&ad=&dd=&pd='.$rec['OFFER_DATE'];
                            $status= 'Waiting';
                            echo '<b>App Date Orig: </b></TD><TD class="td_head" width="20%"><b>App Date:</b> '.@$rec['APPROV_DATE'];
                        }elseif(@$rec['OFR_STATUS'] == 'E'){
                            $date_values='&ad='.@$rec['OFFER_DATE'].'&dd=&pd='.@$rec['OFFER_DATE'];
                            $status= 'Expired';
                            $empname='<b>App By: </b>'.$rec["GL_EMP_NAME"];
                            echo '<b>App Date Orig: </b>'.@$rec['APPROV_DATE_ORIG'].'</TD><TD class="td_head" width="20%"><b>App Date:</b> '.@$rec['APPROV_DATE'];  
                        }else{
                            $date_values='&ad='.@$rec['OFFER_DATE'].'&dd=&pd='.@$rec['OFFER_DATE'];
                            if($curStatus=='W'){
                                $status= 'Waiting';
                            }else{
                                $status= 'Approved';
                            }                            
                            $empname='<b>App By: </b>'.$rec["GL_EMP_NAME"];
                            echo '<b>App Date Orig: </b>'.@$rec['APPROV_DATE_ORIG'].'</TD><TD class="td_head" width="20%"><b>App Date:</b> '.@$rec['APPROV_DATE'];
                        }
                        
                        echo '</td></TR> 
                       </table>
                       </td>
                       <TD class="td_head" width="15%"><b>Pool:</b> '.@$rec['POOL_TYPE'].'</TD>
                       </tr>
                        <TR style="background: #fff;"><td align="center" >'.$sn.'</td>'
                                . '<TD><TABLE WIDTH="100%" BORDER="0" bordercolor ="#3f80d8" CELLPADDING="0" CELLSPACING="0" style="background: #fff;"><tr><td colspan="5"><b>Title: </b>'.$rec["ETO_OFR_TITLE"].'</td>
                                    </tr>
                        <TR><TD colspan="5"><b>Description: </b><p class="test">';       
                            $desc_br = substr(@$rec['ETO_OFR_DESC'],0,256);
                            $desc_br = htmlspecialchars_decode($desc_br);
                             echo nl2br($desc_br);
                         if (@$rec['ETO_OFR_DESC'] && strlen((@$rec['ETO_OFR_DESC']) > 256)) {
                                     echo "...";
                         }
                        echo '</p></td></tr>';
                        echo '<tr><TD   colspan="5"><b>MCAT: </b>';
                                    if(isset($rec['GLCAT_CAT_NAME']))
                        {
                            echo @$rec['GLCAT_CAT_NAME'];
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
                            $prim1=@$rec['CALL_RECORDING_URL'];
                            $recording= '<A href="'.$prim1.'" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';		
                        }else{
                            $recording= '<b style="color:#0000ff">&#187;&nbsp;Recording Not Available </b>';                    
                        }
                        echo '</TD></tr>';
                        $source=$rec["SOURCE"];
                        $modid=$rec["FK_GL_MODULE_ID"];
                        if(preg_match("/FENQ/",@$rec['FK_GL_MODULE_ID']))
                        {
                         $modid_arr=explode('-',@$rec['FK_GL_MODULE_ID']);
                         $modid=isset($modid_arr[1])?$modid_arr[1]:'';                         
                            if($modid==''){
                                $modid=$rec["FK_GL_MODULE_ID"];
                            }
                        }                        
                        echo '<tr><TD  width="15%">'.$empname.'</td>'
                        . '<TD  width="15%"><b>Centre: </b>'.@$rec["ETO_LEAP_VENDOR_NAME"].'</td>'
                        . '<TD width="25%"><b>'.$recording.'</b></td>
                         <TD width="25%"><b>Source: </b>'.$source.'</td>
                         <TD width="20%"><b>MODID: </b>'.$modid.'</td>    
                        </tr></table></td><TD class="td_head" ><TABLE WIDTH="100%" BORDER="0" bordercolor ="#3f80d8" CELLPADDING="0" CELLSPACING="0" style="background: #fff;"><tr><td class="td_head" ><b>Status: </b>';
                       
                         echo $status.'</td></tr>';
                        if(isset($rec['OFR_STATUS']) && ($rec['OFR_STATUS']=='D' || $rec['OFR_STATUS']=='E')){
                                        echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&mid=3424">View</A></td></tr>';
                                }else{
                                        echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&mid=3424">Edit</A></td></tr>';
                                    if ($lvl_code=='E' || $lvl_code=='V') {
                                        if(@$rec['ETO_OFR_APPROV'] == 'W')
                                        {                                                              
                                         echo '<tr><td class="td_head" ><A HREF="/index.php?r=admin_eto/AdminEto/DeleteSilent&action=DeleteSilent&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&start='.$start.'&'.$linkStr.'&act=search&mid=3424" onClick="return confirmDelete(this.href);">Delete Silent</A></td></tr>
                                               <tr><td class="td_head" ><A HREF="/index.php?r=admin_eto/AdminEto/DeleteSilent&action=DeleteSilent&delform=y&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&start='.$start.'&'.$linkStr.'&delmail=1&act=search" onClick="return confirmDeleteMail(this.href);">Delete Mail</A></td></tr>';
                                        }
                                       else
                                       {
                                        echo '<tr><td class="td_head" ><A HREF="/index.php?r=admin_eto/AdminEto/DeleteSilent&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&start='.$start.'&'.$linkStr.'&act=search&mid=3424" onClick="return confirmDelete(this.href);">Delete Silent</A></td></tr>
                                              <tr><td class="td_head" ><A HREF="/index.php?r=admin_eto/AdminEto/DeleteSilent&action=DeleteSilent&delform=y&delmail=1&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&start='.$start.'&'.$linkStr.'&delmail=1&act=search" onClick="return confirmDeleteMail(this.href);">Delete Mail</A></td></tr>';
                                        }
                                        echo '<tr><td class="td_head" >';
                                            if(@$rec['ETO_OFR_APPROV'] == 'W')
                                            {
                                                    if(!isset($rec['OFR_STATUS']) || ($rec['OFR_STATUS']!='D' && $rec['OFR_STATUS']!='E')){
                                                        echo '<input type="checkbox" name="delmulOfrs" value="'.$offerID.'">&nbsp;&nbsp;';               
                                                        $waiting_flag = 1;
                                                    }
                                            }
                                                echo '</TD></tr>';

                                    }
                                    
                                }
                                if ($lvl_code=='E' || $lvl_code=='V') {
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer='.$offerID.'&mid=3424">Offer History<a></td></tr>';
                                    echo '<tr><td class="td_head" ><A target="_blank" HREF="/index.php?r=admin_eto/OfrHist/EtoHistory&act=locking'.$date_values.'&offer='.$offerID.'&mid=3424">Locking History<a></td></tr>';
                                     echo '<tr><td class="td_head" ><a href="/index.php?r=admin_eto/EnrichmentDetail/viewenrichment&offer='.$offerID.'&status='.@$rec['ETO_OFR_APPROV'].'&modid='.@$rec['FK_GL_MODULE_ID'].'&tabletype='.$tableType.'&mid=3424" target="_blank">Enrichment Details</a></td></tr>';
                                }
                                echo '<tr><td class="td_head" ><a href="javascript:void(0);" onclick="window.open('."'"."/index.php?r=admin_bl/Transaction_report/Index&mid=3442&offer=".$offerID."&action=purchasers&Submit1=Generate Report"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">Transaction History</a></td></tr>';
                                echo '<tr><td class="td_head" ><a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer='.$offerID.'&mid=3424" target="_blank">View All Recordings</A></td></tr>';

                                echo '</table></td></tr>';
                         }
	
	if(!empty($waiting_flag))
	{            
		echo '
		<TR>
		<TD BGCOLOR="#FFFFFF" COLSPAN="3" HEIGHT="3"  align="right">
		<input type="hidden" name="delMulsilent" value="y">
		<input type="hidden" name="delmuloffersArr" value="">	
		<input type="hidden" name="status" value="'.$status.'">
		<input type="hidden" name="act" value="search">
		<input type="hidden" name="reason" value="">
		<INPUT TYPE="hidden" NAME="reasondesc" VALUE="">
		<input type="hidden" name="mem" value="'.$critHash['mem'].'">
		<input type="button" onclick="confirmMulDelete();" value="Delete all Selected Waiting Offers" STYLE="FONT-FAMILY:arial;font-size:14px;margin-right:310px;">
		</TD>
		</TR>
		';
            
        }
	echo '</TABLE>		
		</FORM>';

    	if ($flagRecFound != 0) {
            } else {
                 echo '<BR><BR><DIV ALIGN="center" style="color:red">No Offer Found</DIV><BR><BR>';
            }     
        $result['critHash']['offer'] = isset($result['critHash']['offer'])?$result['critHash']['offer']:'';
	$result['critHash']['mem'] = isset($result['critHash']['mem'])?$result['critHash']['mem']:'';
	$result['critHash']['memmail'] = isset($result['critHash']['memmail'])?$result['critHash']['memmail']:'';
        $result['critHash']['memmobile'] = isset($result['critHash']['memmobile'])?$result['critHash']['memmobile']:'';
        $result['critHash']['ph_country'] = isset($result['critHash']['ph_country'])?$result['critHash']['ph_country']:'';
        

            if($result['critHash']['memmail'] !='' || $result['critHash']['offer'] > 0 || $result['critHash']['mem'] !='' || $result['critHash']['memmobile']  > 0) {
                echo '</br><DIV ALIGN="center">'
                . '<button onclick="load_fenqdata(2,'."'".$result['critHash']['offer']."','".$result['critHash']['mem']."','".$result['critHash']['memmail']."','".$result['critHash']['memmobile']."','".$result['critHash']['ph_country']."'".','."'".$result['critHash']['mcat_id']."'".');this.style.display = '."'".'none'."'".';document.getElementById('."'".'glusr_details'."'".').style.display = '."'".'block'."'".'">Deleted Offer From Archive</button>&nbsp;&nbsp;&nbsp;<button onclick="load_fenqdata(1,'."'".$result['critHash']['offer']."','".$result['critHash']['mem']."','".$result['critHash']['memmail']."','".$result['critHash']['memmobile']."','".$result['critHash']['ph_country']."'".','."'".$result['critHash']['mcat_id']."'".');this.style.display = '."'".'none'."'".';document.getElementById('."'".'glusr_details'."'".').style.display = '."'".'block'."'".'">Expired Offer from Archive</button>'
                . ' <div id="glusr_details" style="display:none"><img src="/gifs/loading2.gif" alt="Searching" />'
                        . '</div>';
              }
    }else{
     echo '<BR><DIV ALIGN="center" style="color:red">No Offer Found</DIV><BR>';
     
     if($result['critHash']['memmail'] !='' || $result['critHash']['offer'] > 0 || $result['critHash']['mem'] !='' || $result['critHash']['memmobile']  > 0) {
                echo '</br><DIV ALIGN="center"><button onclick="load_fenqdata(2,'."'".$result['critHash']['offer']."','".$result['critHash']['mem']."','".$result['critHash']['memmail']."','".$result['critHash']['memmobile']."','".$result['critHash']['ph_country']."'".','."'".$result['critHash']['mcat_id']."'".');this.style.display = '."'".'none'."'".';document.getElementById('."'".'glusr_details'."'".').style.display = '."'".'block'."'".'">Deleted Offer From Archive</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="load_fenqdata(1,'."'".$result['critHash']['offer']."','".$result['critHash']['mem']."','".$result['critHash']['memmail']."','".$result['critHash']['memmobile']."','".$result['critHash']['ph_country']."'".','."'".$result['critHash']['mcat_id']."'".');this.style.display = '."'".'none'."'".';document.getElementById('."'".'glusr_details'."'".').style.display = '."'".'block'."'".'">Expired Offer From Archive</button>'
                        . '<div id="glusr_details" style="display:none"><img src="/gifs/loading2.gif" alt="Searching" /></div>';
              }
     
    }

                  echo '</BODY>
                </HTML>
                 ';
    } 
