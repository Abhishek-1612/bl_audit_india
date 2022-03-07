<?php 

if($jobtype['jobtype']!= 13){
if ( !empty($result['rec'])) {
$rec = $result['rec'];
}
$status = $result['status'];
$ETO_LEAP_VENDOR_NAME='';
$recMap1 = isset($arr_map_ref['arrmap'])?$arr_map_ref['arrmap']:'';
$recmcat_mondatory=isset($arr_map_ref['recmcat_mondatory'])?$arr_map_ref['recmcat_mondatory']:'';
$recmcat_mondatory['gl_profile_old_value']=isset($recmcat_mondatory['gl_profile_old_value'])?$recmcat_mondatory['gl_profile_old_value']:'';
$recmcat_mondatory['gl_profile_new_value']=isset($recmcat_mondatory['gl_profile_new_value'])?$recmcat_mondatory['gl_profile_new_value']:'';
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
         
?>
 <!DOCTYPE html>
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
   <title></title>
  </head>
   <body>
 <div id="posted_on">
      <td valign="top" width="320">
      <table width="100%" cellpadding="2" cellspacing="0" class="impPara" border="1" style="border-collapse:collapse;border:1px solid #FFF;background:#eeeeee;">
      <tr>
        <td width="92" class="pd5">Posted On:</td>
        <?php $postDataOrig = isset($rec['POST_DATE_ORIG']) ? $rec['POST_DATE_ORIG'] : ''; ?>
        <td> <span style="color:#000090"><?php echo $postDataOrig ?></span></td>
      </tr>
                       
      <tr>
        <td class="pd5">Posted By:</td>
        <td><span style="color:#000090">
        <?php if (isset($rec['POSTEDBYEMPLOYEE_NAME'])) {
                echo $rec['POSTEDBYEMPLOYEE_NAME'];
            } else {
              if (isset($rec['FK_GLUSR_USR_ID'])){
                echo $rec['FK_GLUSR_USR_ID'];}
            }
            echo "</span></td></tr>";
 ?>
                       <tr>
        <td  class="pd5" >Deleted On :</td>
        <?php $expiredDate = '';
            $deletedon = '';
            if ($status == "T" or $status == "D") {
                $deletedon = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
            } else {
                $expiredDate = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
            }
 ?>
        <td> <span style="color:#000090"><?php echo $deletedon ?></span> </td>
      </tr>
                        <?php echo '<tr><td class="pd5">Deleted By:</td><td><span style="color:#000090">';
            if ($status == "T" or $status == "D") {
                if(isset($rec['GL_EMP_ID'])) {
                    echo $rec['GL_EMP_ID'];
                } else {
                    if ($ETO_LEAP_VENDOR_NAME == 'Auto Delete') {
                        echo 'Auto Delete';
                    }
                }
            }
            echo '</span></td></tr>';
            echo '<tr><td class="pd5">Del Reason:</td><td><span style="color:#000090">';
            if (isset($rec['CALL_DEL_REASON']) && $rec['CALL_DEL_REASON'] <> '-') {
                echo $rec['CALL_DEL_REASON'];
            }
            echo '</span></td></tr>';
            echo '<tr><td width="92" class="pd5">Approved On:</td>';
            $postDataOrig = isset($rec['APPROV_DATE']) ? $rec['APPROV_DATE'] : '';
            echo '<td> <span style="color:#000090">' . $postDataOrig . '</span></td></tr>';
            
            if (($status == 'A' || $status == 'E') && isset($rec['GL_EMP_ID'])) {
                echo '<tr><td class="pd5">Approved By:</td><td><span style="color:#000090">';
                echo  $rec['GL_EMP_ID'];
                echo '</span></td></tr>';
                if(isset($bandetail['gl_profile_updated_by_id'])){
                    echo '<tr><td width="92" class="pd5">Reviewed In BAN Pool By</td>';
                    echo '<td> <span style="color:#000090">' . @$bandetail['gl_profile_audit_by'] . '</span></td></tr>';
                }                
            }else{               
                if(isset($bandetail['gl_profile_updated_by_id'])){
                    echo '<tr><td width="92" class="pd5">Approved By</td>';
                    echo '<td> <span style="color:#000090">' . $bandetail['gl_profile_updated_by_id'] . '</span></td></tr>';
                    echo '<tr><td width="92" class="pd5">Reviewed In BAN Pool By</td>';
                    echo '<td> <span style="color:#000090">' . @$bandetail['gl_profile_audit_by'] . '</span></td></tr>';
                }else{
                    echo '<tr><td class="pd5">Approved By:</td><td></td></tr>';
                }
            }
            
  ?>
                        <tr>
        <td  class="pd5" >Expired On:</td>        
        <td> <span style="color:#000090"><?php echo $expiredDate ?></span> </td>
      </tr>
       <tr>
        <td  class="pd5" >Expiry Date:</td>
        <?php $expiryDate = isset($rec['EXP_DATE']) ? $rec['EXP_DATE'] : ''; ?>
        <td> <span style="color:#000090"><?php echo $expiryDate ?></span> </td>
      </tr>
      <tr>
        <td class="pd5">Last Update:</td>
        <td> <span style="color:#000090"><?php echo isset($rec['OFFER_DATE'])?$rec['OFFER_DATE']:''; ?></span> </td>
      </tr>
                 <?php
            $glid = isset($rec['FK_GLUSR_USR_ID'])?$rec['FK_GLUSR_USR_ID']:'';
            echo '<tr><td class="pd5">Partner:</td><td><span style="color:#000090">';
            if (isset($ETO_LEAP_VENDOR_NAME) and $ETO_LEAP_VENDOR_NAME != 'Auto Delete') {
                echo $ETO_LEAP_VENDOR_NAME;
            }
            $ASSOCIATE_VINTAGE = $LEADER_NAME = '';
            if (isset($rec['ASSOCIATE_VINTAGE'])) {
                $ASSOCIATE_VINTAGE = $rec['ASSOCIATE_VINTAGE'];
            }
            $LEADER_NAME = isset($rec['LEADER_NAME']) ? $rec['LEADER_NAME'] : '';
            $lat = isset($rec['ETO_OFR_LATITUDE']) ? $rec['ETO_OFR_LATITUDE'] : '';
            $long = isset($rec['ETO_OFR_LONGITUDE']) ? $rec['ETO_OFR_LONGITUDE'] : '';
            if ($long <> '') {
                $lat = $lat . ', ' . $long;
            }
            $associate_status=isset($associate_status)?$associate_status:'';
            echo '</span></td></tr>';
            echo '<tr><td class="pd5">Associate Status:</td><td><span style="color:#000090">' . $associate_status . '</span></td></tr>';
            echo '<tr><td class="pd5">Associate Vintage(Days):</td><td><span style="color:#000090">' . $ASSOCIATE_VINTAGE . '</span></td></tr>';
            echo '<tr><td class="pd5">Team Leader:</td><td><span style="color:#000090">' . $LEADER_NAME . '</span></td></tr>      
    <tr>
    <td class="pd5">
    Lat Long:
    </td>
    <td ><span style="color:#000090">' . $lat . '</span>
    </td>
    </tr>';
            echo '</table>';
            ?>
            </div>
 </body>
</html>