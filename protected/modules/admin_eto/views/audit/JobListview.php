<!DOCTYPE html>
<html lang="en">
<?php
//echo "Response is <pre>";
//print_r($response); echo "</pre>";
$buckettype =  isset($_REQUEST['buckettype']) ? $_REQUEST['buckettype'] : '';
$empId =  Yii::app()->session['empid'];
$status_arr = array(0 => 'Open', 1 => 'WIP', 2 => 'Close', 3 => 'Audited');
$host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'gladmin.intermesh.net';
$mid = isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
echo "<input type='hidden' name='mid' id='mid' value=$mid>";
echo "<input type='hidden' name='empid' id='empid' value=$empId>";
echo "<input type='hidden' name='buckettype' id='buckettype' value=$buckettype>";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job List</title>
    <link rel="stylesheet" href="protected/modules/admin_marketplace/css/fonts-googleapis.css">
    <link HREF="protected/modules/admin_marketplace/common-scripts/SOPIcon.css?v1" REL="STYLESHEET" TYPE="text/css">
    <link HREF="/protected/modules/admin_marketplace/common-scripts/freelancestyleBL.css?v=8.2" REL="STYLESHEET" TYPE="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="protected/modules/admin_marketplace/common-scripts/SOPIcon.js?v1"></script>
<script>function OpenApproveBLScreen(i,job_id,type_id) {
    var url='';
$("#showJob" + i).hide();
        $("#tdButton" + i).html("<img src='protected/modules/admin_marketplace/img/ajax-loader.gif'>");
    data = {
        "job_type_id": type_id,
        "job_id": job_id
    }
if(type_id===11 || type_id===12){
    url= "/index.php?r=admin_eto/AuditFreelance/Index&mid=3813"
}else if(type_id===13){
    url= "/index.php?r=admin_eto/AuditFreelance/Index&mid=3813"
}else if(type_id===14){
    url= "/index.php?r=admin_eto/AuditFreelance/Index&mid=3813"
}else if(type_id===15){
    url= "/index.php?r=admin_eto/AuditFreelance/Index&mid=3813"
}else{
    url= "/index.php?r=admin_eto/AuditFreelance/Index&mid=3813"
}
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (result) {
            $("#main").html(result);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\n" + xhr.responseText);
        },
    });
}
</script>

</head>

<body>
    <?php 
    $html_dnc=$html_connect='';
    $mobile =  '';
    $email =  '';
    $totalProcessed_dnc=$totalProcessed_connect=$totalprice_dnc=$totalprice_connect=$total_bl_dnc=$total_bl_connect=$total_left_connect=$total_left_dnc='';
    $len = count($response);
    if ($len > 0) {
        for ($i = 0; $i < $len; $i++) {
            $jobId = isset($response[$i]['job_master_id']) ? $response[$i]['job_master_id'] : '';
            $label = isset($response[$i]['job_type_name']) ? $response[$i]['job_type_name'] : '';
            $job_type_id=$response[$i]['fk_job_type_id'];
            $createdById = isset($response[$i]['job_created_by_empid']) ? $response[$i]['job_created_by_empid'] : '';
            $createdByName = isset($response[$i]['employeename']) ? $response[$i]['employeename'] : '';
            $totalTasks = isset($response[$i]['job_total_tasks']) ? $response[$i]['job_total_tasks'] : '';
            $totalProcessed = isset($response[$i]['job_total_tasks_processed']) ? $response[$i]['job_total_tasks_processed'] : '';
            $job_per_task_price=isset($response[$i]['job_per_task_price']) ? $response[$i]['job_per_task_price'] : 0;
            $job_status=isset($response[$i]['job_status']) ? $response[$i]['job_status'] : '';
            if($totalTasks>0){
                    $left_bl = $totalTasks - $totalProcessed;
                    $total_left = $totalTasks - $totalProcessed;
                    $status_text='';

            if($totalProcessed ==0){
                $status_text= "Open";
            }elseif($total_left ==0){
                $status_text= "Closed";
            }elseif($total_left>0){
                $status_text= "Open/WIP";
            }
            
            $actiontext='';
            $totalprice = round($totalTasks * $job_per_task_price);
            if ($job_status > 0) {
                $actiontext = "Continue";
            } else {
                $actiontext = "Start";
            }

            if($buckettype == 'DNCpool' && ( ($job_type_id==10) || ($job_type_id==12) || ($job_type_id==14) || ($job_type_id==15) || ($job_type_id==32) || ($job_type_id==33))){
                $label=preg_replace('/DNC Pool/','',$label); 
                $totalProcessed_dnc=$totalProcessed_dnc + $totalProcessed;
                $totalprice_dnc =$totalprice_dnc + $totalprice;
                $total_bl_dnc=$total_bl_dnc+$totalTasks;
                $total_left_dnc=$total_left_dnc+$left_bl;
                $action='<button class="continue_btn_child" id="showJob'.$i.'" type="button" onclick="return OpenApproveBLScreen('.$i.','.$jobId.','.$job_type_id.');">'.$actiontext.'</button>';
                $html_dnc .='<tr><td>'.$label.'('.$job_type_id.')</td><td>'.$totalTasks.'</td><td>₹'.$totalprice.'</td><td>'.$left_bl.'</td><td>'.$status_text.'</td><td id="tdButton'.$i.'">'.$action.'</td></tr>';
            }
            elseif($buckettype == 'Connectpool' )
            {
                $label=preg_replace('/Connect Pool/','',$label); 
                $totalProcessed_connect=$totalProcessed_connect + $totalProcessed;
                $totalprice_connect =$totalprice_connect + $totalprice;
                $total_bl_connect=$total_bl_connect+$totalTasks;
                $total_left_connect=$total_left_connect+$left_bl;
                
                $action='<button class="continue_btn_child" id="showJob'.$i.'" type="button" onclick="return OpenApproveBLScreen('.$i.','.$jobId.','.$job_type_id.');">'.$actiontext.'</button>';
               $html_connect .='<tr><td>'.$label.'('.$job_type_id.')</td><td>'.$totalTasks.'</td><td>₹'.$totalprice.'</td><td>'.$left_bl.'</td><td>'.$status_text.'</td><td id="tdButton'.$i.'">'.$action.'</td></tr>';
                }
            }
            }
        }
    $status_text_connect=$status_text_dnc='';
    if($total_bl_dnc ==0){
        $status_text_dnc= "Open";
    }elseif($total_left_dnc ==0){
        $status_text_dnc= "Closed";
    }elseif($total_left_dnc>0){
        $status_text_dnc= "Open/WIP";
    }
    if($total_bl_connect ==0){
        $status_text_connect= "Open";
    }elseif($total_left_connect ==0){
        $status_text_connect= "Closed";
    }elseif($total_left_connect>0){
        $status_text_connect= "Open/WIP";
    }
    ?>
 <div id="main">
    
 <div class="tile">
<div class="tile_pmcat" >
    <div id="info">
        <div class="infodiv">
            <span class="name_label">Bucket Name: </span>
            <span class="name_label_value" style="font-size:22px; color:#006ecd;Category"><b>Connect Pool</b></span>
            <span>
            </span>
            <span>
            </span>
        </div>
        <div>
            <span class="name_label">SPOC: </span>
            <span>Praveen Kumar</span>
            <span>
                <img src='images/email.png' alt='D' width='22' height='20' style="vertical-align: bottom;margin-left:15px;">
            </span>
            <span> kumar.praveen3@indiamart.com </span>
            <span>
                <img src='images/dialer.png' alt='D' width='20' height='20' style='vertical-align: bottom;margin-left:15px;'>
            </span>
            <span>7737879687</span>
        </div>
    </div>
    <div id="counts">
        <div>
            <span class="count">₹<?php echo $totalprice_connect ?></span>
            <span class="count_text"> Estimated Payout</span>
        </div>
        <div class="counts_mid">
            <span class="count"> <?php echo $total_bl_connect ?></span>
            <span class="count_text">Total Buylead</span>
        </div>
        <?php if ($total_left_connect != 0) { ?>
            <div>
                <span class="count"> <?php echo $total_left_connect ?></span>
                <span class="count_text">Remaining Buylead</span>
            </div>
        <?php } ?>
    </div>
    <div>
        <span class="continue_btn"><?php echo $status_text_connect ?></span>
    </div>
</div>
<div id="processing" class="centre" style="display: none;">
    <img src='images/ajax-loader.gif' style="vertical-align: bottom;margin-left:15px;">
</div>
<div class="tile_child" id="tile_child" >
    <div class="child_mcat_div" >
        <table class="child_mcat_table" id="child_mcat_table" border="1" style="display:;min-width:76%">
            <thead>
                <tr class="centre" style="background:#006DCC; color: white;font-weight:bold"><td colspan="6">Buylead Jobs</td></tr>
                <tr class="centre" style="color: black;background: aliceblue;">
                    <th>Buylead Type</th>
                    <th>Total Buylead Count</th>
                    <th>Estimate Payout</th>
                    <th>Remaining Buylead Count</th>
                    <th>Job Status</th>
                    <th>Action</th>
                </tr>
            </thead>
             <?php echo $html_connect ?>
        </table>
    </div>
</div>
</div>
   
<div class="tile" >
<div class="tile_pmcat" >
    <div id="info">
        <div class="infodiv">
            <span class="name_label">Bucket Name: </span>
            <span class="name_label_value" style="font-size:22px; color:#006ecd;"><b>DNC Pool</b></span>
            <span>
            </span>
            <span>
            </span>
        </div>
        <div>
            <span class="name_label">SPOC: </span>
            <span>Praveen Kumar</span>
            <span>
                <img src='images/email.png' alt='D' width='22' height='20' style="vertical-align: bottom;margin-left:15px;">
            </span>
            <span>kumar.praveen3@indiamart.com </span>
            <span>
                <img src='images/dialer.png' alt='D' width='20' height='20' style='vertical-align: bottom;margin-left:15px;'>
            </span>
            <span>7737879687</span>
        </div>
    </div>
    <div id="counts">
        <div>
            <span class="count">₹<?php echo $totalprice_dnc ?></span>
            <span class="count_text"> Estimated Payout</span>
        </div>
        <div class="counts_mid">
            <span class="count"> <?php echo $total_bl_dnc ?></span>
            <span class="count_text">Total Buylead</span>
        </div>
        <?php if ($total_left_dnc != 0) { ?>
            <div>
                <span class="count"> <?php echo $total_left_dnc ?></span>
                <span class="count_text">Remaining Buylead</span>
            </div>
        <?php } ?>
    </div>
    <div>
        <span class="continue_btn"><?php echo $status_text_dnc ?></span>
    </div>
</div>
<div id="processing" class="centre" style="display: none;">
    <img src='images/ajax-loader.gif' style="vertical-align: bottom;margin-left:15px;">
</div>
<div class="tile_child" id="tile_child" >
    <div class="child_mcat_div" >
        <table class="child_mcat_table" id="child_mcat_table" border="1" style="display:;min-width:76%">
            <thead>
                <tr class="centre" style="background:#006DCC; color: white;font-weight:bold"><td colspan="6">Buylead Jobs</td></tr>
                <tr class="centre" style="color: black;background: aliceblue;">
                    <th>Buylead Type</th>
                    <th>Total Buylead Count</th>
                    <th>Estimate Payout</th>
                    <th>Remaining Buylead Count</th>
                    <th>Job Status</th>
                    <th>Action</th>
                </tr>
            </thead>
             <?php echo $html_dnc ?>
        </table>
    </div>
</div>
</div>
     
 </div>
 <span class="info-box" >
    <img src="images/i-icon-blue.png" onclick="info_toggle();">
    <div class="main-infobox" style="display: none;">
        <div class="popup-body">
            <span class="shape"></span>
            <div class="top-box">
                <img src="images/cross_circle.png" style="position: absolute; right: 3%" onclick="info_toggle();">
                <div id="myUl">
                    
                </div>
            </div>
            <div class="bottom-box">
                <div id="myUl-b">
                    
                </div>
            </div>                        
        </div>                    
    </div>
</span>     
</body>

</html>
