<?php 
//if($savedet['msg']!=''){
 //   echo'<div align="center"><span style="font-weight:bold;font-size:16px;color:green;">'.$savedet['msg'].'-'.$savedet['task_detail_id'].'</span></div>';
//}
if($jobtype['jobtype']!= 13){
if ( !empty($result['rec'])) {
$rec = $result['rec'];
}
$status = $result['status'];
$ETO_LEAP_VENDOR_NAME='';
$recMap1 = isset($arr_map_ref['arrmap'])?$arr_map_ref['arrmap']:'';
$recmcat_mondatory=isset($arr_map_ref['recmcat_mondatory'])?$arr_map_ref['recmcat_mondatory']:'';
$recmcat_mondatory[0]['gl_profile_old_value']=isset($recmcat_mondatory[0]['gl_profile_old_value'])?$recmcat_mondatory[0]['gl_profile_old_value']:'';
$recmcat_mondatory[0]['gl_profile_new_value']=isset($recmcat_mondatory[0]['gl_profile_new_value'])?$recmcat_mondatory[0]['gl_profile_new_value']:'';
if (isset($rec['ETO_LEAP_VENDOR_NAME'])) {
    if (preg_match("/In-Active/", $rec['ETO_LEAP_VENDOR_NAME']) > 0) {
        $associate_status = "In-Active";
        $ETO_LEAP_VENDOR_NAME = rtrim($rec['ETO_LEAP_VENDOR_NAME'], "|In-Active");
    } elseif (preg_match("/Active/", $rec['ETO_LEAP_VENDOR_NAME'])) {
        $ETO_LEAP_VENDOR_NAME = rtrim($rec['ETO_LEAP_VENDOR_NAME'], "|Active");
        $associate_status = "Active";
    } else {
        $ETO_LEAP_VENDOR_NAME = $rec['ETO_LEAP_VENDOR_NAME'];
    }
}
$ETO_OFR_DESC = '';
            if (isset($rec['ETO_OFR_DESC'])) {
                $ETO_OFR_DESC = htmlentities(strip_tags($rec['ETO_OFR_DESC']));
            }
$postDataOrig = isset($rec['APPROV_DATE']) ? $rec['APPROV_DATE'] : '';
$deletedon = '';
            if ($status == "T" or $status == "D") {
                $deletedon = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
            } else {
                $expiredDate = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
            }
            $modid = $result['origModid'];
            $tableType = isset($rec['TABLE_TYP']) ? $rec['TABLE_TYP'] : 3;
            $glid = isset($rec['FK_GLUSR_USR_ID'])?$rec['FK_GLUSR_USR_ID']:'' ;
            if (!empty($rec) && !empty($offerID) && isset($rec['ETO_OFR_ID'])) {
                $flagRecFound = 1;
                $rowCounter++;
            }
          }
          else{
           $call_record_id=$offerArr['fk_leap_call_records_id'];
           $ETO_LEAP_VENDOR_NAME =$offerArr['eto_leap_vendor_name'];
           $arr_map_ref=array();
          }
$job= array(
    "9" => "Connect Pool Approved BuyLead", 
    "10" => "DNC Pool Approved BuyLead",
"11" => "Connect Pool Deletion BuyLead",
"12" => "DNC Pool Deletion BuyLead",
    "13" => "FLPNS (Non BL)",
    "14" => "DNC Pool Reviewed BuyLead",
    "15" => "DNC Pool Fully Auto",
    );
    $x=0;
    $t_i=0;
           if(!empty($error) && isset($error)){
          foreach ($error as $e) {
              if($x==0){
                $t_i= $e['task_audit_id'];
                $x++;
                }
               else{
                break;
                 }
                }
              }
//require_once dirname(__FILE__).'/posted_details.php' ;
?>

<!DOCTYPE html><html>
    <head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="protected/css/Poppins.css">
	<link rel="stylesheet" type="text/css" href="protected/css/audit.css?v=2">
	<script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
   <script src="protected/modules/admin_eto/js/SuperAudit.js?v=26"></script>
	
  <style>
  textarea {
  width: 350px;
  height: 130px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 10px;
  background-color: white;
  font-size: 14px;
  resize: both;
  vertical-align: top;
  }
  .after_f{
	border: 1px solid #000000;
box-sizing: border-box;
border-radius: 15px;
padding: 0px 0px 0px 10px;
width: 500px;
min-height:130px;
display: flex;
margin-top: 100px;
}
  </style>
	<title></title>
</head>
<body>
<form name="questionform" method="post" onsubmit=" return checkremark()">
<div class="header" style="width:100%;">
  <h5 style="width:100%;">Super Audit Screen</h5>
</div>
<div class="container-fluid">
  <div class="title_txt">
    <div class="first_txt">
      <span> Job Type : <strong><?php  print_r($job[$jobtype['jobtype']]); ?></strong></span>
    </div>
    <div class="first_txt">
      <span> Centre : <strong><?php echo $ETO_LEAP_VENDOR_NAME ; ?></strong></span>
    </div>
    <div class="first_txt">
      <span> Score : <strong>
        <input type="radio"onclick="setProducttype('3')" id="pass" name="score" value="3" <?php ?>>
          <label for="pass">Pass</label>
          <input type="radio" onclick="setProducttype('4')" id="fail" name="score" value="4" <?php ?>>
          <label for="fail">Fail</label>
          <input type="radio" onclick="setProducttype('4')" id="both" name="score" value="4" <?php ?>>
          <label for="both">Both</label>
        </strong></span>
    </div>
  </div>
</div>
<hr>
<div id="prodcontent">


<div style="clear:both"></div>

<div class="container-fluid" >
<div class="row">
    <div class="second_section">
      <div class="col-sm-3 col-md-3 col-lg-3 img_box">
        <div class="box_txt">
        <?php  if($jobtype['jobtype']!= 13){ ?> 
          <span><a target="_blank" href="index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=<?php echo $offerid ?>&go=Go&mid=3945"> OFFER DETAIL: <?php echo $offerid ?></a></span>
          <?php } else { ?> 
            <span> CALL RECORD ID: <?php echo  $call_record_id; ?></a></span>
            <?php }  ?>
        </div>
        <?php  if($jobtype['jobtype']!= 13 ){ ?> 
        <div class="box_img" style="padding:0px 0px 0px 0px ;">
        <table style="border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="3" >  
                     <td width="50%">
                             <div style="line-height:24px;padding-left:10px;padding-top:0px;font-size:12px;text-align:left;">
                         <b style="color:#000090"><span style="color:#000090">&#187;</span>History</b>
                     <b> &nbsp;&nbsp; <a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer=<?php echo $offerid ?>&mid=3424" target="_blank">Offer</a></b>         
                            <?php
                         $PostBy = isset($rec['POSTEDBYEMPLOYEE_NAME']) ? $rec['POSTEDBYEMPLOYEE_NAME'] : '';
                         $FK_GLUSR_USR_ID=isset($rec['FK_GLUSR_USR_ID']) ? $rec['FK_GLUSR_USR_ID'] : '';
                         $POST_DATE_ORIG=isset($rec['POST_DATE_ORIG'])?$rec['POST_DATE_ORIG']:'';
                         if(isset($result['status'])){
                          $s=$result['status'];
                        }
                        else{
                          $s='';
                        }
                         echo '&nbsp;|| 
                     <b>&nbsp;<a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=mapHist&offer=' .$offerid. '&mid=3424&status=' .$s. '&pl=no" target="_blank">Mapping</a></b>&nbsp;||
                     <b><a href="/index.php?r=admin_glusr/GlusrHistory/GlusrHistory&id=' . $FK_GLUSR_USR_ID . '&mid=46" target="_blank">GLUser </a></b>
                     &nbsp;||
                     <b><a href="/index.php?r=admin_eto/OfrHist/etohistory&act=locking&ad=' . $postDataOrig . '&dd=' . $deletedon . '&pd=' . $POST_DATE_ORIG . '&offer=' . $offerid . '&postby=' . $PostBy . '&mid=3424"." target="_blank">Locking </a></b>
                     &nbsp;||
                     <b><a href="/index.php?r=admin_eto/OfrHist/etohistory&act=Isq_hist&offer=' .$offerid . '&mid=3424" target="_blank">ISQ</a></b>';
             
             
                     echo '&nbsp;||<b><a href="/index.php?r=admin_eto/OfrHist/etohistory&act=autoHist&offer=' .$offerid . '&mid=3424" target="_blank">Auto Approval</a></b>
                     &nbsp;';
                    
                     $appDate = '';
                     if ($postDataOrig <> '') {
                         $appDate = substr($postDataOrig, 0, 11);
                     }
                         echo '<br /><b><span style="color:#000090">&#187;</span>';
                         echo '&nbsp;<a href="/index.php?r=admin_eto/EnrichmentDetail/viewenrichment&offer=' .$offerid  . '&modid=' . $modid . '&tabletype=' . $tableType . '&mid=3424" target="_blank">Enrichment Details</a>&nbsp;<br>';
                          
                         echo '&#187;<a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/Contact_details/Details&action=posted&offerID='.$offerid.'\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" > Posted/Apprroval Date &nbsp;</a> ||';
                         echo '&nbsp;<a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/Contact_details/Details&action=contact&offerID='.$offerid.'\',\'_blank\',\'scrollbars=yes,width=1400, height=800\');" > Buyer Contact Detail &nbsp;</a>';
                         if (isset($rec['CALL_RECORDING_URL'])) {
                             $prim1 = $rec['CALL_RECORDING_URL'];
                             echo '<a href="' . $prim1 . '" TARGET="_blank">&#187;&nbsp;Play Recording</A>';
                         } else {
                             echo '&#187;&nbsp;Recording Not Available';
                         }
                         echo '&nbsp;||&nbsp;<a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer=' .$offerid  . '&glid=' . $glid . '&dt=' . $appDate . '&mid=3424" target="_blank">View All Recordings</A>';
             ?>  
                             </div>
                     </td>
                     <tr>
                     <td style="padding:0px 5px 0px 8px;text-align:left;">
                     <span style="color:#000090">&#187;</span><b style="color:#000090;font-size:12px;">&nbsp;Unrealistic Usage&nbsp; </b><input type="button" name="usage" id="usage" value="Show" style="background-color: #e7e7e7; color: black" onclick="showusage(<?php echo $_REQUEST['offerID'] ?>);"><span id="usagestatus" name="usagestatus" style="text-align:center;color: black;font-size: small;" bgcolor="#dff8ff" width="12%"></span>
                     </td>
                             </tr>
                             <tr>
                     <td style="padding:0px 5px 0px 8px;text-align:left;">
                     <span style="color:#000090">&#187;</span><b style="color:#000090;font-size:12px;">&nbsp;TOV removed By LEAP identifier&nbsp; </b><input type="button" name="tov" id="tov" value="Show" style="background-color: #e7e7e7; color: black" onclick="showtov(<?php echo $_REQUEST['offerID'] ?>);"><span id="tovstatus" name="tovstatus" style="text-align:center;color: black;font-size: small;" bgcolor="#dff8ff" width="12%"></span>
                     </td>
                             </tr>
                             <tr>
                     <td style="padding:0px 5px 0px 8px;text-align:left;">
                     <span style="color:#000090">&#187;</span><b style="color:#000090;font-size:12px;">&nbsp;Unrealistic Quantity&nbsp; </b><input type="button" name="quantity" id="quantity" value="Show" style="background-color: #e7e7e7; color: black" onclick="showquantity(<?php echo $_REQUEST['offerID'] ?>);"><span id="quantitystatus" name="quantitystatus" style="text-align:center;color: black;font-size: small;" bgcolor="#dff8ff" width="12%"></span>
                     </td>
                             </tr>
                              <tr>
                     <td style="padding:0px 0px 0px 8px;text-align:left;">
                     <span style="color:#000090">&#187;</span><b style="color:#000090;font-size:12px;">&nbsp;User Stats&nbsp; </b><input type="button" name="showuserstat" id="showuserstat" value="Show" style="background-color: #e7e7e7; color: black" onclick="showuserstats(<?php echo $_REQUEST['offerID'] . ',' . $FK_GLUSR_USR_ID; ?>);">&nbsp;&nbsp; <br> <span id="userstat" name="userstat" style="text-align:center;color:green;font-weight: 500;white-space: nowrap;font-size: small;" bgcolor="#dff8ff" width="12%"></span>
                        </td>
                     </tr>
                    </table>
              <?php } if ($jobtype['jobtype']== 13) {
                ?><div style="margin-top: 50px;
                margin-left: 5px;">
              <?php   echo '<a href="' . $offerArr['call_recording_url'] . '" TARGET="_blank">&#187;&nbsp;Play Recording</A>'; }?>  
              </div>       
             
        </div>
       
        </div>
        <?php  if($jobtype['jobtype']!= 13){ ?> 
        <div class="col-sm-4 col-md-4 col-lg-5">
        <div class="dolphin">
          <h5 style="font-weight: 600;color: black;"><?php echo isset($rec['ETO_OFR_TITLE']) ? trim($rec['ETO_OFR_TITLE']) : ''; ?></h5>
          <p><?php echo isset($rec['ETO_OFR_DESC'])?$rec['ETO_OFR_DESC']:'' ;  ?></p>
          <?php } else{ ?>
            <div class="col-sm-4 col-md-4 col-lg-5">
        <div class="dolphin"> 
          <p> No description </p>
          <?php } ?>
        </div>
        </div>
    
        <div class="col-sm-5 col-md-5 col-lg-4">
        <div class="table_con">
        <?php $task_i=isset($task_id[0]['task_audit_id'])?$task_id[0]['task_audit_id']:''; ?>
        <?php if($jobtype['jobtype']!= 13){ ?> <strong> BuyLEAD ISQ </strong> <?php } else {?> <strong> Reason </strong> <?php } ?>
          <div id="id" style="display: inline;float: right;margin-top: -20px;color: #337ab7;font-size: medium;"> 
          <?php if ($jobtype['jobtype']== 9 || $jobtype['jobtype']== 10){ ?>
          <span><a target="_blank" href="index.php?mid=3826&r=admin_eto/auditEto/Auditedit_v1/audit_id/<?php echo $task_i; ?>/ven_app/ALL/ven_audit/ALL/sd//ed//offer_id/<?php echo $offerid ?>/r/0/"> 
           <?php } else if ($jobtype['jobtype']== 11 || $jobtype['jobtype']== 12){ ?>
            <span><a target="_blank" href="index.php?r=admin_eto/BulkAuditEto/AuditMis_Edit&offer_id=<?php echo $offerid ?>&auditid=<?php echo $task_i; ?>&mid=3549"> 
            <?php } else if ($jobtype['jobtype']== 13){ ?>
              <span><a target="_blank" href="index.php?r=admin_eto/NonBLAudit/Auditedit/stype/NONBL/audit_id/<?php echo $task_i; ?>/call_id/<?php echo $call_record_id;; ?>/"> 
              <?php } else if ($jobtype['jobtype']== 15){ ?>
              <span><a target="_blank" href="index.php?mid=3826&r=admin_eto/auditEto/Auditedit/stype/AUTO/audit_id/<?php echo $task_i; ?>/ven_app/ALL/ven_audit/ALL/sd//ed//offer_id/<?php echo $offerid; ?>/">
              <?php } else { ?>
              <span><a target="_blank" href="index.php?r=admin_eto/auditEto/Auditedit/stype/R/audit_id/<?php echo $task_i; ?>/ven_app/ALL/ven_audit/ALL/sd//ed//offer_id/<?php echo $offerid; ?>/r//">  
              <?php } ?>
              Audit ID: <?php echo $task_i ?>
                    </a></span>
        </div>
        </div>
       
        <div class="attribut_table">
          <table class="table">
        
                <tbody>
                <?php
                      if ( isset($offerdetHTML) && is_array($offerdetHTML) && (count($offerdetHTML) > 0)) {
                        foreach($offerdetHTML as $k=>$v){        
                      ?>
                    <tr>
                      <td style="color: #323484; font-size: 13px; font-weight: 550;"><?php echo $k; ?></td>
                    <td><?php echo $v; ?></td>
                    </tr>
                    <?php
                     }  
                    }
                else{
                  if($jobtype['jobtype']!= 13){
                  ?>
                  <td>ISQ unavailable </td>
                  
                  <?php
                  } else{
                 ?>  <p style="color: #337ab7;
                 padding: 5px 5px 5px 5px"><?php  echo $offerArr['disposition_remarks']. '-' .$offerArr['call_disposition_reason'];?></p>
               <?php    }
                }       
                ?>  
                     
                 </tbody>
              </table>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="afterbox" style="margin-top: -100%;">
    <div class="container-fluid">
      <div class="row row-space"  style="clear: none;">
        <div class="col-md-6">
          <div class="Before" style="color: #323484;">Mcat Mapped</div>
          <div class="after_first" style="min-height: 130px;overflow: scroll">
            <div class="row">
            <?php 
            if(isset($recMap1)){
            foreach ($recMap1 as $k => $rec_map) {
            
                    ?>
           <div class="col-xs-4">
              
                <h5 style="margin-top: 5px;color: #323484;font-size: 11px"><?php echo $rec_map['GLCAT_MCAT_NAME']; ?></h5>
            <?php
                       if ($rec_map['FK_GLCAT_MCAT_ID'] == $rec_map['PRIME_MCAT']) {         
                      ?>
                   <h6 style="color: red;">(Prime MCAT)</h6>
                   <?php
            } 
              if ($rec_map['GLCAT_MCAT_IS_BUSINESS_TYPE'] == 1 && ($rec_map['PRIME_MCAT'] == $rec_map['FK_GLCAT_MCAT_ID'])) {         
            ?>
             <h6 style="color: red;">(Business MCAT)</h6>  
              <?php
              }  if ($rec_map['GLCAT_MCAT_IS_GENERIC'] == 1 ) {       
              ?>
              <h6 style="color: red;">(PMCAT)</h6>  
              <?php
             } if ($recmcat_mondatory[0]['gl_profile_old_value'] !='' && $recmcat_mondatory[0]['gl_profile_new_value'] != '' && $recmcat_mondatory[0]['gl_profile_old_value']==$rec_map['FK_GLCAT_MCAT_ID'] && $rec_map['FK_GLCAT_MCAT_ID']== $recmcat_mondatory[0]['gl_profile_new_value'] && $recmcat_mondatory[0]['gl_profile_old_value']== $recmcat_mondatory[0]['gl_profile_new_value']) {  
              ?>
              <h6 style="color: red;">(MANDATORY MCAT)</h6>  
              <?php
              }
              ?>
             </div>
                  <?php
              }
            } else {
                 ?>
                No Mcat Available
               <?php
                      }
              ?>
            </div>
          </div>
        </div>
        
        <div class="col-md-6" style="margin-top: 270px;margin-bottom: -30px;">
          <div class="Before" style="color: #323484;margin-bottom: -95px;
margin-left: -348px;"> Remark:</div>
          <div class="after_f" style="margin-left: -360px;overflow: scroll">
                <?php
                $x=0;
                if(!empty($error) && isset($error)){
                   foreach ($error as $e) {
                       if($x==0){
                echo $e['remark'];
                $x++;
                       }
                       else{
                           break;
                       }
                    }
                  }
                ?>     
          </div>
        </div>
        <div class="col-md-6" style=" margin-top: -160px; margin-left: 20px; ">
          <div class="Before" style="color: #323484;margin-left: -370px;
margin-bottom: -10px;margin-top: 40px; ">Error Marked 
  </div>
  
          <div class="after_first" style="min-height: 130px;margin-left: -370px;overflow: scroll">
            <div class="row">
                <?php  if (!empty($error)) {
                if($jobtype['jobtype']!= 13){
                 foreach ($error as $e) {
                  if ($e['error_marked']!='Pass'){
                ?>
                 <div class="col-xs-4">
            <h5 style="margin-top: 5px;color: #323484;font-size: 11px;"><?php echo $e['error_marked']; ?></h5>
            </div>
                  <?php
                  }
                 }
                } else {foreach ($error as $e) {
                  if ($e['error_marked']!='Pass'){
                ?>
                 <div class="col-xs-4">
            <h5 style="margin-top: 5px;color: #323484;font-size: 11px;"><?php echo $e['ques']?>-<?php echo $e['error_marked']; ?></h5>
            </div> 
            <?php } 
            }
          }
         } else{
                ?>
               
                No Error
            <?php } 
            ?>
            </div>
          </div>
          <div style="margin-left: 650px;width: 200px;height: 200px;margin-right: -20px;margin-top: -155px;">   <label for="remarks" style=" color: #323484;"> Super Auditor Remark </label>
  <textarea id="remarks" name="remarks"> </textarea>
                   </div>   
        </div>
      </div>
    </div>
    <div class="container-fluid">
    <div class="butons">
      <div class="first_buton">
        <a href="Javascript:void(0);" id="approve<?php echo $offerid ; ?>"  onclick="set_status(<?php echo $offerid ; ?>)"> Correct Audit</a>
      </div>
      <div class="second_button">
        <a href="Javascript:void(0);" id="reject<?php echo $offerid ; ?>" onclick="openRejectReason(<?php echo $offerid ;?>)">Wrong Audit</a>
      </div>
  </div>
</div>

  </div>

  <div class="last_box" id="last_box<?php echo $offerid ;?>" style="display:none;">
    <div class="wrong_mcat" style="margin: 40px;">
            <?php
           
                  ?>
                  <div class="container2">    
                    <input type="radio" id="reason1" name="reason" value=" <?php echo $disp_arr[0]['task_disposition_id'] ;?> " ><span class="checkmark"> </span>
                      <label for="vehicle1"> <strong style="color: #9F9F9F"><?php  echo $disp_arr[0]['task_disposition_val'] ;?> </strong> </label>
                      <?php ?>
                </div>            
                <br>
           
                        <div class="container2">
                        <input type="radio" id="reason2" name="reason" value="  <?php echo $disp_arr[1]['task_disposition_id'] ;?>"><span class="checkmark"> </span>
                        <label for="vehicle1"> <strong style="color: #9F9F9F"><?php  echo $disp_arr[1]['task_disposition_val'] ;?></strong> </label>
                        </div>
                <br>        
                <div class="container2">
                        <input type="radio" id="reason3" name="reason" value="  <?php echo $disp_arr[2]['task_disposition_id'] ;?>"><span class="checkmark"> </span>
                        <label for="vehicle1"> <strong style="color: #9F9F9F"><?php  echo $disp_arr[2]['task_disposition_val'] ;?></strong> </label>
                        </div>        
              <br>
              <div class="container2">
                        <input type="radio" id="reason4" name="reason" value="  <?php echo $disp_arr[3]['task_disposition_id'] ;?>"><span class="checkmark"> </span>
                        <label for="vehicle1"> <strong style="color: #9F9F9F"><?php  echo $disp_arr[3]['task_disposition_val'] ;?></strong> </label>
                        </div>              
				</div>
			</div>
     


  </div>
  </div> 
  <div style="clear:both"></div>
  <footer>
  <div class="loader" id="loader"></div>
  <div class="botton_group" id="footerbotton" style="text-align: center; padding-top:15px;">
  <input type="submit" name="save" id="save" value="Save & Next" style="border:none;padding: 5px 27px 5px 27px;" >
  <input type="submit" name="save_close" id="save_close" value="Save & Close" style="border:none;padding: 5px 27px 5px 27px;" >
  <input id="status_disposition" name="status_disposition"  type="hidden" >
  <input type="hidden" id="task_id" name="task_id" value="<?php echo($jobtype['task_detail_id']) ?>" >
  <input type="hidden" id="job_id" name="job_id" value="<?php echo($jobtype['jobtype']) ?>" >
  <input type="hidden" id="audit_id" name="audit_id" value="<?php echo($jobtype['audit_id']) ?>" >
  <input type="hidden" id="offer_id" name="offer_id" value="<?php echo $offerid ?>" >

    </div>
    </footer>
  <?php

?>
</form>
  </body>
</html>