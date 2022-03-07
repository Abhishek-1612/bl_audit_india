<?php 
$team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
$stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
?><head>
<title>Buy Lead Audit CRM</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script type="text/javascript">
    function Newfilter(id,team_leader,qa,agent)
{
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
$(document).ready(
    function()
            {
            if ($("input[name='stype']:checked"). val()== 'ADV') {
               $("#trmain").show();               
            }else{
                $("#trmain").hide();                
            }
                $('#submit_view').click(function(){                 
                        a={};
                        a['stype']= $("input[name='stype']:checked"). val();
                        a['vendor_approve']=$('#vendor_approve').val();
                        a['mailoption']=$('#mailoption').val();
                        a['maxrecords']=$('#maxrecords').val();
                        a['start_date']=$('#start_date').val();                        
                        a['submit_view']=$('#submit_view').val();
                        a['team_leader_select']=$('#team_leader_select').val();
                        a['qa_select']=$('#qa_select').val();
                        a['agent_select']=$('#agent_select').val();
                        a['remark']= $("input[name='remark']:checked"). val();
                        a['deletedreasonselect']=$('#deletedreasonselect').val();

                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/NonBLAudit/Sampling&mid=3880",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>");},
                success:function(result){                         
                               $('#sampleresult').html(result);                   
                            }
                        });                   
                    }); 
                    $('#submit_send').click(function(){                      
                        a={};
                        a['vendor_approve']=$('#vendor_approve').val();
                        a['mailoption']=$('#mailoption').val();
                        a['maxrecords']=$('#maxrecords').val();
                        a['start_date']=$('#start_date').val();                        
                        a['submit_send']=$('#submit_send').val();  
                        a['team_leader_select']=$('#team_leader_select').val();
                        a['qa_select']=$('#qa_select').val();
                        a['agent_select']=$('#agent_select').val();
                        a['deletedreasonselect']=$('#deletedreasonselect').val();
                        a['remark']= $("input[name='remark']:checked"). val();
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/NonBLAudit/Sampling&mid=3880",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>");},
                            success:function(result){                         
                               $('#sampleresult').html(result);                   
                            }
                        });                   
                    }); 
            }
); 
</script>
 </head>
<body>
<form name="sampleForm" id="sampleForm" method="post" action="/index.php?r=admin_eto/NonBLAudit/Sampling&mid=3880" style="margin-top:0;margin-bottom:0;">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="6" align="center"><font COLOR =" #333399"><b>Sample Data </b></font>             
              </td> 
              <TR id="tr1">
                <TD  CLASS="admintext">Search Type</TD>
                <TD colspan="2">      
                <input type="radio" id="s1" name="stype" value="" <?php echo ($stype=='') ?"checked":'' ?> >&nbsp;Default &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s2" name="stype" value="ADV"  <?php echo ($stype=="ADV")?"checked":'' ?> >&nbsp;Advanced&nbsp;&nbsp;&nbsp;
               </TD>
            </TR>
              </TR>
             <TR id="tr2">
              <td WIDTH="10%">&nbsp;Date:</td>
              <td WIDTH="20%"> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly"></td>
              <td WIDTH="10%">&nbsp;Center Name: </td>
              <td WIDTH="20%">&nbsp;<select name="vendor_approve" id="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:200px;">
   <?php $vendorArr1=array();
               if(count($vendorArr)==1){                                       
                     $vendor_name=key($vendorArr);
                     if(preg_match("/COMPETENT/i",$vendor_name)) {
                      $vendorArr1 = array('4'=>'COMPETENT','34'=>'COMPETENTDNC');
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('28'=>'KOCHARTECHAUTO','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('24'=>'RADIATEAUTO','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
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
                   echo '<OPTION VALUE="'.$key.'" SELECTED="SELECTED" >'.$value.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$key.'" >'.$value.'</OPTION>';
                }

        } echo '</select>';
        ?></td><td >&nbsp;Deletion Reason: </td>
    <td>   
         <span id="deletedreason" name="deletedreason">
         <select name="deletedreasonselect" id="deletedreasonselect">
         <OPTION VALUE="">ALL</OPTION>
         <?php 
         $deletedreasonArr=array(211=>"BL Approved",212=>"BL Enriched",
214=>"Particular Company Details",
215=>"Selling Related",
216=>"Short Call",
218=>"Voice Not Clear",
219=>"Supplier Call",
231=>"No Mcat",
232=>"Foreign Lead not approved",
233=>"No Response",
234=>"IVR Call",
235=>"Test Call",
249=>"Call Dropped in Between - Unable to Identify the Concern",
250=>"Call Drop in Between - BL Lead Opportunity",
251=>"No Product Requirement",
252=>"Banned Product",
253=>"Time Pass/ Abusive Caller",
254=>"Language Barrier",
255=>"Telemarketing/Promotional Call",
339=>"Disable Customer",
340=>"Job Related_BL not approved",
346=>"Duplicate Requirement");

         foreach($deletedreasonArr as $key=>$value)
         {
          echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
         }
          ?>
         </select>
         </td>
    </tr>
    <tr>
     
    <td WIDTH="10%">&nbsp;Max Records: </td><td WIDTH="10%"><select name="maxrecords" id="maxrecords" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
    <?php
        $recordsArr=array(5,10,15,20,25,30,40,50,60,70,80,90,100,120,140,160,180,200,220,240,260,280,300,400,500);
        foreach($recordsArr as $k)
    {
        if(isset($mailoption) && $maxrecords == $k)
            {
                echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
            }
            else
            {
                echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
            }

    } echo '</select></td>';
        ?>        </td>       
       
<td>&nbsp;Remark:&nbsp;</td>
<td colspan="3">
<input type="radio" id="remark1" name="remark" value="" checked >&nbsp;Both&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio"  id="remark2" name="remark" value="1" >&nbsp;With Remark&nbsp;&nbsp;
<input type="radio"  id="remark3" name="remark" value="2" >&nbsp;Without Remark&nbsp;&nbsp;
</td>
</tr>
 <tr id="trmain">
    <td >&nbsp;Team Leader: </td>
    <td colspan="5">&nbsp;<span name="team_leader" id="team_leader"></span>
    &nbsp;&nbsp;Associate:
    &nbsp;<span name="team_agent" id="team_agent"></span>
    &nbsp;&nbsp;QA:
    &nbsp;<span name="team_qa" id="team_qa"></span>
    </td>
     </tr>
     <tr>
<TD colspan="6" align="center"> 
<input type="button" name="submit_view" id="submit_view" value="View Sample">
&nbsp; &nbsp;<input type="button" name="submit_send" id="submit_send" value="Send Sample">
<div id="loading1" class="busy" style="display:none; width:20px;height:20px;"></div>
    </TD></tr>
</TABLE><div id="sampleresult" name="sampleresult"></div></form>
 
 <div style="clear:both;"><!-- --></div></div>
