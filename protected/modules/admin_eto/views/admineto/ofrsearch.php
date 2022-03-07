<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
    <HEAD><TITLE>Buylead Search</TITLE>
        <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
           <style>.td_head {color: #000;font-family: arial;font-size: 12px;padding: 0px 0px;}
.pg_head {color: #000;background: #fff;font-family: arial;font-size: 14px;height: 13px;padding: 4px 5px;}</style>
        <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js" ></script>
        <script language="javascript" src="/js/calendar.js"></script>
        <SCRIPT LANGUAGE="JavaScript">
        <!--
        function goback() { history.go(-1)} // End the hiding here.

        function popup(url) {
             window.open(url,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=500');
        }
function set(){
	 if ($('input[name=stype]:radio:checked').val() === 'ADV') {
            if(((document.getElementById('start_date').value === '') || (document.getElementById('end_date').value === '')) && (document.getElementById('title').value.trim() === ''))
                {
                        alert("Please Select Atleast one Input");
                        return (false);
                }
        }else{
	<?php 
        
        $array_vendor_check=array('DDN','NOIDA','KOCHARTECHLDH','COGENTINBOUND');
        $rtype=isset($_REQUEST['rtype']) ? $_REQUEST['rtype'] : '';
        $status=isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
        $mcatName=isset($_REQUEST['mcat_name']) ? $_REQUEST['mcat_name'] : '';
        $mcat_id=isset($_REQUEST['mcat_id']) ? $_REQUEST['mcat_id'] : 0;
        $archive_data=isset($_REQUEST['archive_data']) ? $_REQUEST['archive_data'] :  '';
        $param['ltype']=isset($param['ltype']) ? $param['ltype'] :  '';
        $param['freq']=isset($param['freq']) ? $param['freq'] :  '';
        $param['title']=isset($param['title']) ? $param['title'] :  '';
        $param['ofrGeoId']=isset($param['ofrGeoId']) ? $param['ofrGeoId'] :  '';
        $param['reqtype']=isset($param['reqtype']) ? $param['reqtype'] :  '';
        if(!empty($archive_data)){
        $archive_data='checked';
        }
        if(empty($vendor_name) || in_array($vendor_name,$array_vendor_check))
        {
	?>
	if(document.getElementById('approvby_name').value != '' && document.getElementById('approv_by').value == '')
	{
		alert("Please select Approved By field properly from dropdown");
		document.getElementById('approvby_name').focus();
		return (false);
	}
	
	if(document.getElementById('postedby_name').value != '' && document.getElementById('posted_by').value == '')
	{
		alert("Please select Posted By field properly from dropdown");
		document.getElementById('postedby_name').focus();
		return (false);
	}	
	if(document.getElementById('memmobile').value.trim() != '')
	{
	if(isNaN(document.getElementById('memmobile').value) || document.getElementById('memmobile').value <= 0)
	{
		alert("Please Enter Valid Mobile Number");
		document.getElementById('memmobile').focus();
		return (false);
	}
	}
	if(document.getElementById('offer').value.trim() != '')
	{
	if(isNaN(document.getElementById('offer').value) || document.getElementById('offer').value <= 0)
	{
		alert("Please Enter Valid Offer Id");
		document.getElementById('offer').focus();
		return (false);
	}
	}
	if(document.getElementById('mem').value.trim() != '')
	{
	if(isNaN(document.getElementById('mem').value) || document.getElementById('mem').value <= 0)
	{
		alert("Please Enter Valid Glusr Id");
		document.getElementById('mem').focus();
		return (false);
	}
	}
	
	
       if(document.getElementById('offer').value.trim() == '' && document.getElementById('mem').value.trim() == '' && document.getElementById('memmail').value.trim() == ''  && document.getElementById('memmobile').value.trim() == '' && document.getElementById('approvby_name').value.trim() == '' && document.getElementById('postedby_name').value.trim() == '' && document.getElementById('group').value == 0  && document.getElementById('cat').value == 0 && document.getElementById('mcat_name').value.trim() == '') 
	{
		alert("Please select Atleast one Input");
		return (false);
	}	
	
	<?php 
	}
	else
	{	
	?>
        if(document.getElementById('offer').value.trim() == '' && document.getElementById('mem').value.trim() == '' && document.getElementById('memmail').value.trim() == ''  && document.getElementById('memmobile').value.trim() == '')
        {
                alert("Please select Atleast one Input");
                return (false);
        } 
	if(document.getElementById('memmobile').value.trim() != '')
	{
	if(isNaN(document.getElementById('memmobile').value) || document.getElementById('memmobile').value <= 0)
	{
		alert("Please Enter Valid Mobile Number");
		document.getElementById('memmobile').focus();
		return (false);
	}
	}
	
	if(document.getElementById('offer').value.trim() != '')
	{
	if(isNaN(document.getElementById('offer').value) || document.getElementById('offer').value <= 0)
	{
		alert("Please Enter Valid Offer Id");
		document.getElementById('offer').focus();
		return (false);
	}
	}
	if(document.getElementById('mem').value.trim() != '')
	{
	if(isNaN(document.getElementById('mem').value) || document.getElementById('mem').value <= 0)
	{
		alert("Please Enter Valid Glusr Id");
		document.getElementById('mem').focus();
		return (false);
	}
	}
    
	<?php } ?>
    
    }
}
var typewatch = function(){
var timer = 0;
return function(callback, ms){
clearTimeout (timer);
timer = setTimeout(callback, ms);
} 
}();
function look_up(obj,txtHint)
{
	var str=document.getElementById(obj).value;
	if(txtHint == 'textapprov')
	{
		document.getElementById('approv_by').value='';
	}
	else if(txtHint == 'textpost')
	{
		document.getElementById('posted_by').value='';
	}
	var xmlhttp;
	if (str=="")
	{
		document.getElementById(txtHint).innerHTML="";
		document.getElementById(txtHint).style.display="none";
		return;
	}
	else if(str.length > 2){
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById(txtHint).style.display='';
			document.getElementById(txtHint).innerHTML=xmlhttp.responseText;	
		}
		}
		xmlhttp.open("GET","/index.php?r=admin_eto/AdminEto/empajax&str="+str+"&typ="+txtHint,true);
		xmlhttp.send();
	}
	else
	{
	document.getElementById(txtHint).innerHTML="";
	document.getElementById(txtHint).style.display="none";
	}
}
function selc(e_name,e_id,d_id)
{
    
	if(d_id == "textapprov")
	{

		document.getElementById('approvby_name').value=e_name;
		document.getElementById('textapprov').style.display="none";
		document.getElementById('approv_by').value=e_id;
	}
	if(d_id == "textpost")
	{
		document.getElementById('postedby_name').value=e_name;
		document.getElementById('textpost').style.display="none";
		document.getElementById('posted_by').value=e_id;
	}
}
         //-->
	</SCRIPT>
<style>  .cls-enq{z-index: 1;display: block;position: absolute;}    
</style>
<script language="javascript" type="text/javascript">

function showOfr()
{
	var offer = document.getElementById('offer').value;
        if(offer == '')
	{
		alert("Please Enter Offer ID");
	}
	else
	{
            if($("#archive_data").prop('checked') == true){
                window.open('/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='+offer+'&arc=1&go=Go&mid=3424','_blank');
             }else{
                window.open('/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='+offer+'&go=Go&mid=3424','_blank');
             }
	}	
}
<?php
echo 'function lookup(idd,obj,divId) {
		
		$("#mcats").show();
		var inputString=$(\'#\'+idd).val();
		if(inputString.length == 0) {
			$(\'#\'+divId).html(\'<div></div>\');
		} else if(inputString.length > 2){
			if(/[.]/.test(inputString)){
				$(\'#\'+divId).html(\'<div></div>\');
			}
			else
			{
				var typ=\'\';
				
                                        var reportType=$(\'input[name="rtype"]:checked\').val();
                            				
                                $.post("/cron/rpc3.php", {queryString: ""+inputString+"", ff: ""+reportType+"",searchtype:""+obj+""}, function(data){
					if(data.length >0) {
						$(\'#\'+divId).html(data);
					}
					else{
						$(\'#\'+divId).html(\'<div></div>\');
					}

				});
                            
                            
			}
		}
		else if(inputString.length <=2){
			$(\'#\'+divId).html(\'<div></div>\');
		}
	}
	
function abcMcats(mcatname,mcatid){
            
           mcat_name.value=mcatname;
           mcat_id.value=mcatid;
           $("#mcats").hide();
           
        }';

?>
 $(function() {
    $('input:radio[name="stype"]').change(function() {
        if ($(this).val() == 'ADV') {
                $("#tr0").show();
                $("#tr1").show();
                $("#tr2").show();
                $("#tr3").show();
                $("#trd1").hide();
                $("#trd2").hide();                
                // $("#trd4").hide();
                $("#trd5").hide();
                $("#trd6").hide();
                
            }else{
                $("#tr0").hide();
                $("#tr1").hide();
                $("#tr2").hide();
                $("#tr3").hide();
                $("#trd1").show();
                $("#trd2").show();                
                // $("#trd4").show();
                $("#trd5").hide();
                $("#trd6").show();
                
            }        
    });
});
$(document).ready(
    function()
            { 
            if ($('input[name=stype]:radio:checked').val() == 'ADV') {
                $("#tr0").show();
                $("#tr1").show();
                $("#tr2").show();
                $("#tr3").show();
                $("#trd1").hide();
                $("#trd2").hide();
                $("#trd5").hide();
                $("#trd6").hide();
                
            }else{
                $("#tr0").hide();
                $("#tr1").hide();
                $("#tr2").hide();
                $("#tr3").hide();
                $("#trd1").show();
                $("#trd2").show();               
                // $("#trd4").show();
                $("#trd5").hide();
                $("#trd6").show();
                
            }   
           }
);  

	   
</script>
<style type="text/css">
.poit {cursor:pointer;color:#E01E1B;}
.norm {cursor:pointer;color:#1B56E0;font:normal 14px arial;margin:3px 0 0 0;border-bottom: 1px solid #FFFFFF;padding:0 0 0 7px }
.norm:hover{cursor:pointer;color:#FF0000;font:normal 14px arial;margin:3px 0 0 0;border-bottom: 1px solid #FFFFFF;padding:0 0 0 7px }
</style>
    </HEAD>
       <?php $dayArr = range(1,31); 
      		$montharr = array(1=> "January",2=> "February",3=> "March",4=> "April",5=> "May",6=> "June",7=> "July",8=> "August",9=> "September",10=> "October",11=> "November",12 => "December");
      		$sysyear = date("Y");
      		$valYear = array($sysyear-5,$sysyear-4,$sysyear-3,$sysyear-2,$sysyear-1,$sysyear,$sysyear+1,$sysyear+2,$sysyear+3,$sysyear+4,$sysyear+5);
      if (isset($mesg) && $mesg != '') {
         echo "<DIV>$mesg</DIV>";
      }
        $param['stype'] = isset($param['stype'])?$param['stype']:'';
	$param['offer'] = isset($param['offer'])?$param['offer']:'';
	$param['mem'] = isset($param['mem'])?$param['mem']:'';
	$param['memmail'] = isset($param['memmail'])?$param['memmail']:'';
	$param['memmobile']=isset($param['memmobile']) ? $param['memmobile'] : '';        
        $end_date=isset($param['end_date']) ? $param['end_date'] : strtoupper(date('d-M-Y', strtotime('-1 days')));  
        $start_date = isset($param['start_date']) ? $param['start_date'] : strtoupper(date('d-M-Y', strtotime('-1 days')));     
  $array_vendor_check=array('NOIDA'); $search_display='display:none;';
  if(empty($vendor_name) || in_array($vendor_name,$array_vendor_check))
        {
            $search_display='';
        }
?>
    <BODY>
     <FORM name="searchForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT=" return set()">   
        <table cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1" width="100%" style="border-collapse: collapse;">
<tr><td align="center" bgcolor="#dff8ff" colspan="4"><font color=" #333399"><b>Buylead Search</b></font></td></tr>
<TR id="tr_search" style="<?php echo $search_display?> ">
<TD  CLASS="admintext">Search Type</TD>
<TD colspan="3">      
<input type="radio" id="s1" name="stype" value="" checked>&nbsp;Default &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</TD>
</TR>
<TR id="trd1">
          <TD width="10%" CLASS="admintext">Offer ID</TD>
          <TD width="40%"><INPUT TYPE="TEXT" NAME="offer" id="offer" VALUE="<?php echo $param['offer']; ?>">&nbsp;
          <input type="checkbox" name="archive_data" id="archive_data" value="1" <?php echo $archive_data;?>  title="Click to Fetch Data From Archive (ETO_OFR_FROM_FENQ_ARCH+ETO_OFR_TEMP_DEL_ARCH+ETO_OFR_EXP_ARCH)">&nbsp;&nbsp;<b>Archive Data</b>  
	  <input type="button" name="ofrsearch" value="Go" onclick="showOfr();">
	</TD>       
          <TD  width="15%" CLASS="admintext">GL User ID</TD>
          <TD  width="35%" ><INPUT TYPE="TEXT" NAME="mem" id="mem" VALUE="<?php echo$param['mem']; ?>"></TD>
        </TR>
<TR id="trd2">
          <TD   CLASS="admintext">Email ID</TD>
          <TD ><INPUT TYPE="TEXT" NAME="memmail" id="memmail" VALUE="<?php echo $param['memmail']; ?>"></TD>       
          <TD   CLASS="admintext">Mobile Number</TD>
          <TD >
          <INPUT TYPE="TEXT" NAME="memmobile" id="memmobile" VALUE="<?php echo $param['memmobile']; ?>">
           <INPUT TYPE="RADIO" NAME="ph_country" VALUE="IN" checked>India
          <INPUT TYPE="RADIO" NAME="ph_country" VALUE="FR">Foreign
          </TD>
        </TR>
        <?php
        
        if(empty($vendor_name) || in_array($vendor_name,$array_vendor_check))
        {
        ?> 
        <TR id="trd4" style = "display:none;">
          <TD CLASS="admintext">Approved By</TD>
          <TD >
          <input type="text" NAME="approvby_name" onkeyup="typewatch(function(){look_up('approvby_name','textapprov');},500 );" autocomplete="off"  id="approvby_name" value="<?php 
          
          $approvby_name=isset($param['approvby_name']) ? $param['approvby_name'] :''; 
          echo $approvby_name; ?>">
          <input id="approv_by"  type="hidden"  NAME="approvby" value="<?php //echo $param['approvby']; ?>"   ><BR />
          <div id="textapprov" style="background-color:#F0F4FF;position:absolute;display:none;height:200px;width:200px;overflow:auto; border:1px solid #cccccc"></div></TD>
       
          <TD   CLASS="admintext">Posted By</TD>
          <TD >
          <input type="text" onkeyup="typewatch(function(){look_up('postedby_name','textpost');},500 );" autocomplete="off" NAME="postedby_name" id="postedby_name" value="<?php 
          $postedby_name=isset($param['postedby_name']) ? $param['postedby_name']:'';
          echo $postedby_name; ?>">
          <input type="hidden" id="posted_by" NAME="postedby" value="<?php //echo $param['postedby']; ?>" ><BR />
          <div id="textpost" style="background-color:#F0F4FF;position:absolute;display:none;height:200px;width:200px;overflow:auto; border:1px solid #cccccc"></div></TD>
        </TR>
        <TR id="trd5" style="display:none">
          <TD   CLASS="admintext">Category</TD>
          <TD ><SELECT NAME="group" id="group" SIZE="1">
             <OPTION VALUE="0">--- Any Category ---</OPTION> 
           </SELECT></TD>
       
          <TD   CLASS="admintext">Subcategory</TD>
          <TD ><SELECT NAME="cat" id="cat" SIZE="1">
             <OPTION VALUE="0">--- Any Subcategory ---</OPTION>
       </SELECT></TD>
        </TR>        
        <TR id="trd6">
          <TD   CLASS="admintext">Mcat</TD>
          <TD >
          <INPUT TYPE="TEXT" name="mcat_name" id="mcat_name" autocomplete="off" onkeyup="lookup('mcat_name','MCAT','mcats');" value="<?php echo $mcatName; ?>">
          <INPUT TYPE="hidden" name="mcat_id" id="mcat_id" value="<?php echo $mcat_id;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php 
          if($rtype =='P' || $rtype =='')
	    {
	    echo '<input type="radio" name="rtype" value="P" CHECKED>&nbsp;Product&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    }
	    else
	    {
	    echo '<input type="radio" name="rtype" value="P">&nbsp;Product&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    }
	    if($rtype =='S')
	    {
	    echo '<input type="radio" name="rtype" value="S" CHECKED>&nbsp;Service&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    }
	    else
	    {
	    echo '<input type="radio" name="rtype" value="S">&nbsp;Service&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    }
          
          ?>
           <div id="mcats" style="overflow-y: scroll; display: none;  max-height: 300px;"></div>
          </TD>
          <?php 
          echo '<TD  CLASS="admintext" colspan="2">';
          if($status=='L' || $status==''){
                echo '&nbsp;<input type="radio" name="status" value="L" CHECKED>&nbsp;&nbsp;Live Leads'
              . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="status" value="A">&nbsp;&nbsp;Expired Leads';
            }else{
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="status" value="L" >&nbsp;&nbsp;Live Leads'
              . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="status" value="A" CHECKED>&nbsp;&nbsp;Expired Leads';
            }          
          echo '</TD>';
          ?>
        </TR>

<tr id="tr0" style="display:none;">

			  <td>&nbsp;Approved Date:</td>
			  <td colspan='3'>			  
			  <input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			 <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
			  </td>
			  </tr>	
<TR id="tr2" style="display:none;">
           <TD CLASS="admintext">Type</TD>
           <TD>
            <input type="radio" name="ltype" value="" <?php echo ($param['ltype'] == '')?"checked":'' ?> >&nbsp;Both&nbsp;&nbsp;
           <input type="radio" name="ltype" value="NR" <?php echo ($param['ltype'] == 'NR')?"checked":'' ?> >&nbsp;Bulk&nbsp;&nbsp;
           <input type="radio" name="ltype" value="R" <?php echo ($param['ltype'] == 'R')?"checked":'' ?> >&nbsp;Retail
           </TD>       
           <TD   CLASS="admintext">Frequency</TD>
           <TD ><select name="freq" id="freq" name="freq">
                         <option value="">-- All --</option>
                         <option value="1" <?php echo ($param['freq'] == 1)?"selected":'' ?>>One Time</option>
                         <option value="2" <?php echo ($param['freq'] == 2)?"selected":'' ?>>Regular</option>
                         <option value="3" <?php echo ($param['freq'] == 3)?"selected":'' ?>>Daily</option>
                         <option value="4" <?php echo ($param['freq'] == 4)?"selected":'' ?>>Weekly</option>
                         <option value="5" <?php echo ($param['freq'] == 5)?"selected":'' ?>>Monthly</option>
                         <option value="6" <?php echo ($param['freq'] == 6)?"selected":'' ?>>Quarterly</option>
                         <option value="7" <?php echo ($param['freq'] == 7)?"selected":'' ?>>Half Yearly</option>
                         <option value="8" <?php echo ($param['freq'] == 8)?"selected":'' ?>>Yearly</option>
                         </select></TD>
         </TR> 
         <TR id="tr1" style="display:none;">
          <TD CLASS="admintext" width="15%">Title</TD>
          <TD colspan="3"><INPUT TYPE="TEXT" NAME="title" id="title" VALUE="<?php echo $param['title']; ?>" size="50"></TD> 
         </TR>
         
         <TR id="tr3" style="display:none;">
           <TD CLASS="admintext">Preferred Location</TD>
           <TD>
            <input name="ofrGeoId" id="r1" value="1" type="checkbox" <?php echo ($param['ofrGeoId'] == 1)?'CHECKED':'' ?> >
                 <b>Local Only</b>
                 <input name="ofrGeoId" id="r2" value="2" type="checkbox" <?php echo ($param['ofrGeoId'] == 2)?'CHECKED':'' ?>>
                 <b>Anywhere in India</b>
                 <input name="ofrGeoId" id="r3" value="3" type="checkbox" <?php echo ($param['ofrGeoId'] == 3)?'CHECKED':'' ?> >
                 <b>Global</b>
                 <input name="ofrGeoId" id="r4" value="4" type="checkbox" <?php echo ($param['ofrGeoId'] == 4)?'CHECKED':'' ?>>
                 <b>Specific Cities</b>
           </TD>       
           <TD CLASS="admintext">Need this for</TD>
           <TD><input type="checkbox" <?php echo ($param['reqtype'] == 1)?"checked":'' ?> value="1" id="n1" name="reqtype"><b>For Reselling</b>
            <input type="checkbox" <?php echo ($param['reqtype'] == 2)?"checked":'' ?> value="2" id="n2" name="reqtype"><b>For Own/Self Use</b>
            <input type="checkbox" <?php echo ($param['reqtype'] == 3)?"checked":'' ?> value="3" id="n3" name="reqtype"><b>As Raw Material</b> </TD>
        </TR>
        
        <?php }  ?>
        <TR>
          <TD COLSPAN="4" ALIGN="CENTER">
              <font color="red">(Records are not from Archive Table)</font> &nbsp;&nbsp;&nbsp; <INPUT TYPE="submit" NAME="go" VALUE="Search">
           </TD>
        </TR>
       </TABLE>
      </FORM>
    </BODY>
 </HTML>