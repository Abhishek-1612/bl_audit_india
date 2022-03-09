<?php 
    $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : 'https://utils.intermesh.net';
    $team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
    $team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
    $team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
    $vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
    $offerid=isset($_REQUEST['offerid']) ? $_REQUEST['offerid'] : '';
?>
<head>
    <title>Buy Lead Audit CRM</title>
    <link href="/gladmin/css/report.css" rel="stylesheet" type="text/css">       
    <script language="javascript" type="text/javascript" src="/gladmin/js/jquery.min.js"></script>
    <script language="javascript" src="/gladmin/js/calendar.js"></script>
    <style type="text/css">
    .flatTable td {
        height: 36px;
    }
    .dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
    .tab-container{ background:#ffffff; width:100%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
    .data_off{display:none}.data_on{display:block}
    .nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
    .nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
    .nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
    </style>
</head>
<body>
    <?php 
        $pool=isset($_REQUEST['pool']) ? $_REQUEST['pool'] : array();
        $search=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
        $stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
        $start_date1=isset($start_date)?$start_date:'';
        $deletedreasonArr=array(
            1=>'Duplicate Requirement',
            3=>'Invalid Description',
            10=>'Wrong Contact Details',
            14=>'Is a Supplier',
            15=>'No Requirement',
            63 => 'No Requirement - Price Only',
            17=>'Test Requirement Posted',
            21=>'Job Enquiry',
            24=>'Not Ready to Confirm',
            33=>'Not Talked Lead',
            16=>'Do Not Call',
            31=>'Banned and Adult Product',
            35=>'One Time Pending Deletion',
            45=>'Deleted because one similar lead recently approved',
            11=>'Offer Rejected',
            53=>'Lead from IM employee',
            52=>'3 leads deleted on call',
            41=>'Drugs Keywords',
            51=>'Drugs Keywords',
            49=>'Duplicate Generation - Time',
            61=>'User Registered With Blacklisted Country',
            36=>'Blacklisted User',
            37=>'Disabled User',
            38=>'Invalid Email Domains',
            64=>'Calling Required',
            26=>'Language Barrier'
        );
    ?>
    <form name="sampleForm" id="sampleForm" method="post" action="/index.php?r=admin_eto/bulkauditEto/Sampling&mid=3794" style="margin-top:0;margin-bottom:0;">
        <table style="border-collapse: collapse;" border="1" class="flatTable" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
            <tr>
                <td bgcolor="#dff8ff" colspan="4" align="center"><font color =" #333399"><b>Sample Data </b></font></td>   
            </tr> 
            <tr id="tr1">
                <td WIDTH="20%">&nbsp;Process Level:</td>
                <td>
                    &nbsp;<input type="checkbox" id="process_level0" name="process_level" value="5" <?php echo (isset($_REQUEST['process_level0']) && $_REQUEST['process_level0'] == '5')?'CHECKED="CHECKED"':'' ?> />&nbsp;5&nbsp;&nbsp; 
                    <input type="checkbox" id="process_level1" name="process_level" value="6" <?php echo (isset($_REQUEST['process_level1']) && $_REQUEST['process_level1'] == '6')?'CHECKED="CHECKED"':'' ?> />&nbsp;6&nbsp;&nbsp;
                    <input type="checkbox" id="process_level2" name="process_level" value="7" <?php echo (isset($_REQUEST['process_level2']) && $_REQUEST['process_level1'] == '7')?'CHECKED="CHECKED"':'' ?>/>&nbsp;7&nbsp;&nbsp;
                </td>   
                <td>
                    &nbsp;Deletion Reason:
                </td>
                <td  CLASS="admintext">
                    <span id="deletedreason" name="deletedreason">
                        &nbsp;Direct&nbsp;&nbsp;<input type="radio" name="delsource" value="direct" id="delsource" checked>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fenq&nbsp;&nbsp;<input type="radio" name="delsource" value="fenq" id="delsource">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name="deletedcall_noncall" id="deletedcall_noncall">
                            <option value="0">ALL</option>
                            <option value="1">With Call</option>
                            <option value="2">Without Call</option>
                            <option value="3">Manual Flag</option>
                            <option value="4">Auto Delete</option>
                            <option value="5">Manual Delete</option>
                        </select>
                    </span>    
                </td>
            </tr>
            <tr id="tr2">
                <td WIDTH="20%">&nbsp;Date:</td>
                <td> 
                    &nbsp;<input name="start_date" type="text" value="<?php echo $start_date; ?>" size="13" onfocus="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" type="text" readonly="readonly">&nbsp;&nbsp;
                </td>
                <td >&nbsp;Deleted By: </td>
                <td>
                    &nbsp;<div style="float:left;margin:0 100 0 0">
                        <select onchange="Newfilter(this.value);" name="vendor_approval" id="vendor_approval" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
                            <?php       
                                $vendorArr1=array();
                                if(count($vendorArr)==1){                                       
                                    $vendor_name=key($vendorArr);
                                    if(preg_match("/COGENT/i",$vendor_name)) {
                                    $vendorArr1 = array('16'=>'COGENTBRB','15'=>'COGENTDNC','23'=>'COGENTPNS','4'=>'COMPETENT');
                                    }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                                        $vendorArr1 = array('28'=>'KOCHARTECHAUTO','6'=>'KOCHARTECHCHN','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                                    }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                                        $vendorArr1 = array('24'=>'RADIATEAUTO','1'=>'RADIATEDNC','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
                                    }elseif(preg_match("/VKALP/i",$vendor_name)) {
                                        $vendorArr1 = array('10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW');       
                                    }else{
                                        $vendorArr1 = $vendorArr;
                                    }
                                }else{    
                                    $vendorArr1 = $vendorArr;
                                }
                                foreach($vendorArr1 as  $key => $value)
                                {
                                    if($vendor_approve == $key)
                                    {
                                        echo '<option value="'.$key.'" selected="SELECTED" >'.$value.'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$key.'" >'.$value.'</option>';
                                    }

                                }
                            ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr id="tr6">
                <td width="20%">&nbsp;Buyer Type:</td>
                <td> 
                    &nbsp;<input type="radio" name="buyer_type" value="" checked />All&nbsp;&nbsp;
                    <input type="radio" name="buyer_type" value="Frequent" <?php echo (isset($_REQUEST['buyer_type']) && $_REQUEST['buyer_type'] == 'Frequent')?'CHECKED="CHECKED"':'' ?>/>Frequent
                </td>
                <td>&nbsp;Pool Type:</td>
                <td>
                    &nbsp;<input type="checkbox" value="MUSTCALL" id="mustcall"  <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'MUSTCALL')?'CHECKED="CHECKED"':'' ?> name="pool" >&nbsp;Must Call
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="INTENT" id="intent" <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'INTENT')?'CHECKED="CHECKED"':'' ?>   name="pool" >&nbsp;Intent
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="DNC-INDIAN" id="dnc"  <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'DNC-INDIAN')?'CHECKED="CHECKED"':'' ?> name="pool" >&nbsp;DNC-Indian
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="DNC-FORIEGN" id="foreign" <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'DNC-FORIEGN')?'CHECKED="CHECKED"':'' ?>  name="pool">&nbsp;Foreign
                    <input type="hidden" name="poolVal" id="poolVal" value="">
                </td>
            </tr>
            <tr id="tr5">
                <td >&nbsp;Search by Offer Id: </td>
                <td>
                    &nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="offer_id" id="offer_id" value="<?php echo $offerid ; ?>">
                </td>
                <td>&nbsp;Max Records:&nbsp;&nbsp;</td>
                <td>
                    <select name="maxrecords" id="maxrecords" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
                        <?php
                            $recordsArr=array(2,5,10,20);
                            foreach($recordsArr as $k)
                            {
                                // echo $maxrecords;die;
                                if($maxrecords == $k)
                                {
                                    echo '<option value="'.$k.'" selected="SELECTED" >'.$k.'</option>';
                                }
                                else
                                {
                                    echo "<option value=\"$k\"  >$k</option>";
                                }
                            } 
                            echo "<option value='1 Sample Per Associate'>1 Sample Per Associate</option>";
                        ?>   
                    </select>   
                </td>
            </tr>     
            <tr id="trmain">
                <td >&nbsp;Team Leader: </td>
                <td colspan="3">&nbsp;<span name="team_leader" id="team_leader"></span>
                    &nbsp;&nbsp;Associate:
                    &nbsp;<span name="team_agent" id="team_agent"></span>
                    &nbsp;&nbsp;QA:
                    &nbsp;<span name="team_qa" id="team_qa"></span>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center">                      
                    <input type="button" name="submit_view" id="submit_view" value="View Sample" >
                    <input type="hidden" name="action" id="action" value="generate">
                    <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"></div>
                </td>
            </tr>
        </table>
        <div id="sampleresult" name="sampleresult">

        </div>
        <div id="auditresult" name="auditresult" style="color:blue;text-align:center;"></div>
    </form>                    
</body>
<div style="clear:both;"><!-- --></div></div>

<script type="text/javascript">
    function Newfilter(id,team_leader,qa,agent)
    {
        if(id=='40'){                        
            $('#maxrecords').append(new Option('2 Sample Per Associate', '2 Sample Per Associate'));
        }else{
            $("#maxrecords option[value='2 Sample Per Associate']").remove();                    
        }
    
        a={};
        a['vendor']=id;
        a['leader']=team_leader;
        a['qa']=qa;
        a['agent']=agent;
        $.ajax({
            type : 'POST',
            url : "/index.php?r=admin_eto/auditEto/Newfilter/",
            data : a,
            success:function(result){
                var fields = result.split('####');
                document.getElementById('team_leader').innerHTML =fields[0];
                document.getElementById('team_qa').innerHTML =fields[1];
                document.getElementById('team_agent').innerHTML =fields[2];
            }
        });
    }    
    function pagination(pg)
    {
        a={};var pagination='';
        if(document.getElementById("pagination")){
            pagination=document.getElementById("pagination").innerHTML;
        }
        if(document.getElementById("auditresult")){
            document.getElementById("auditresult").innerHTML='';
        }
        a['ofrlist']=document.getElementById("hdn"+pg).value;
        a['vendor_approval']=$('#vendor_approval').val();
        a['maxrecords']=$('#maxrecords').val();
        a['start_date']=$('#start_date').val(); 
        a['submit_view']=$('#submit_view').val();
        a['tlselect']=$('#tlselect').val();
        a['team_leader_select']=$('#team_leader_select').val();
        a['qa_select']=$('#qa_select').val();
        a['agent_select']=$('#agent_select').val();
        a['agentselect']=$('#agentselect').val();  
        a['offer_id']=$('#offer_id').val(); 
        if($('input[name="delsource"]:checked').val() =='direct')
        {
            a['delsource']='direct';
        }
        else
        {
            a['delsource']='fenq';
        }
        a['bucket']=$('#bucket').val();  
        a['deletedreasonselect']=$('#deletedreasonselect').val();
        a['deletedcall_noncall']=$('#deletedcall_noncall').val();
        a['leadtype']= $('input[name="leadtype"]:checked').val();
        a['buyer_type']= $('input[name="buyer_type"]:checked').val();
        a['pool']= $('input[name="pool"]:checked').val();
        vendorVal = $('input[name="pool"]:checked').map(function() {
            return this.value;
        }).get().join();
        a['poolVal']=vendorVal; 
        a['sample_type']= $('input[name="sample_type"]:checked').val();                        
        result='';              
        $.ajax({
            url:"/index.php?r=admin_eto/BulkAuditEto/Sampling&mid=3794",
            type: 'post',
            data:a,
            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
            success:function(result){ 
                var resulthtml=pagination + result;
                $('#sampleresult').html(resulthtml);                   
            }
        });                   
    }
    function showuserstats(offerid,glusrid){  
        $("#showuserstat_"+offerid).hide();
        $("#userstat_"+offerid).html('Processing...');    
        $.ajax({
            type: "POST",
            url:"/index.php?r=admin_eto/OfferDetail/showuserstats&offerid="+offerid+"&glusrid="+glusrid,
                    data: "",
            success: function(response){            
                $("#userstat_"+offerid).html(response);            
            }
        });        
    }   
    function validate_opt(grpname){
        var group =document.getElementsByName(grpname);
        if (group[0].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
        if (group[1].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
        if (group[2].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
        if (group[3].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
    }
    function validate_radio(radioname){
        grpname=radioname.replace("delopt", "chk");
        var opt_val= $('input:radio[name=\''+radioname+'\']:checked').val();
        if(opt_val===2){
            
        }else{  
            $('input[name=\''+grpname+'\']').each(function() {
                    this.checked = false;
            });
        }
    }
    function check_validate(){
        var a ={};
        var x={};
        var ids = document.getElementById("all_ofr_id").value.split(",");
        console.log(ids);
        for(var j=0;j<ids.length;j++)
        {
            ofrid= ids[j];
            primeId="delopt_"+ofrid;
            var opt_val= $('input:radio[name=\''+primeId+'\']:checked').val();
            if(opt_val==2){                        
                var grpname="chk_" + ofrid;
                var sel_grp=false;
                var group =document.getElementsByName(grpname);   
                for (var opt=0; opt< group.length; opt++) {
                        if(group[opt].checked === true){                                         
                            sel_grp=true;                                         
                        }                      
                }
                if(sel_grp === false){
                    alert("Please Select Atleast one Flagged option for Offer Id " + ofrid);                                 
                    return false;
                } 
            }  
        }
        for(var j=0;j<ids.length;j++)
        {
            var optionvalues = new Array();
            var questionvalues = new Array();
            ofrid= ids[j];
            primeId="delopt_"+ofrid;
            primeId2="chk_"+ofrid;
            var opt_val= $('input:radio[name=\''+primeId+'\']:checked').val();
            optionvalues.push(opt_val);
            questionvalues.push('32');
            var rem_val=$('#remarks_'+ofrid).val();
            var opt_id=ofrid;
            if(opt_val==227){                            
                x[opt_id]={
                        ofr_id:ofrid,
                        opt_val:optionvalues,
                        ques_val:questionvalues,
                        rem_val:rem_val
                    };                   
            }else{
                var optionvalues = new Array();
                var questionvalues = new Array();
                var opt_val= document.getElementsByName(primeId2);
                for(var i=0;i<opt_val.length;i++)
                {
                    if(opt_val[i].checked === true ){
                        optionvalues.push(opt_val[i].value); 
                        questionvalues.push('32'); 
                    }
                }
                x[opt_id]={
                    ofr_id:ofrid,
                    opt_val:optionvalues,
                    ques_val:questionvalues,
                    rem_val:rem_val
                };  
            }
        }                
        var newArr=JSON.stringify(x);
        // console.log(newArr);
        a['opt_ids']=newArr;
        $("#save_all").hide();   
        $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url: "./index.php?r=admin_eto/FlagAuditEto/Audit&mid=3549", 	 	
            data: a, 
            success: function(result){ 	 
                $('#auditresult').html(result);                          
            }, 	 	
            error: function() { 
                alert('Error occured');
                result = false;
            } 	 	
        });  
    }

    $(function() {
        $('input:radio[name="stype"]').change(function() {
            if ($(this).val() == 'ADV') {
                Newfilter('<?php echo $vendor_approve ?>','<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');
                    $("#trmain").show();
                }else{
                    $("#trmain").hide();                 
                }
        });
    });
    $(document).ready(function(){
        if ($("input[name='stype']:checked"). val()== 'ADV') {
            $("#trmain").show();               
        }else{
            $("#trmain").hide();                
        } 
        $('#submit_view').click(function(){                 
            a={};
            a['stype']= $("input[name='stype']:checked"). val();
            a['vendor_approval']=$('#vendor_approval').val();
            a['maxrecords']=$('#maxrecords').val();
            a['start_date']=$('#start_date').val(); 
            a['submit_view']=$('#submit_view').val();
            a['tlselect']=$('#tlselect').val();
            a['team_leader_select']=$('#team_leader_select').val();
            a['qa_select']=$('#qa_select').val();
            a['agent_select']=$('#agent_select').val();
            a['agentselect']=$('#agentselect').val();  
            a['offer_id']=$('#offer_id').val(); 
            if($('input[name="delsource"]:checked').val() =='direct'){
                a['delsource']='direct';
            }else{
                a['delsource']='fenq';
            }
            a['bucket']=$('#bucket').val();  
            a['deletedreasonselect']=$('#deletedreasonselect').val();
            a['deletedcall_noncall']=$('#deletedcall_noncall').val();
            a['leadtype']= $('input[name="leadtype"]:checked').val();
            a['buyer_type']= $('input[name="buyer_type"]:checked').val();
            a['pool']= $('input[name="pool"]:checked').val();
            vendorVal = $('input[name="pool"]:checked').map(function() {
            return this.value;
            }).get().join();
            a['poolVal']=vendorVal; 
            var process_level_val = '';
            process_level_val = $('input[name="process_level"]:checked').map(function() {
            return this.value;
            }).get().join();
            a['process_level']=process_level_val;
            a['sample_type']= $('input[name="sample_type"]:checked').val();
            result='';
            // alert(a);return false;              
            $.ajax({
                url:"./index.php?r=admin_eto/FlagAuditEto/Sampling&mid=3794",
                type: 'post',
                data:a,
                beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                success:function(result){                         
                    $('#sampleresult').html(result);                   
                }
            });                   
        });                     
    }); 
</script>