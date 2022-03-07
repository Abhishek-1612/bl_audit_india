<?php
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
if(isset($_REQUEST["rtype"])){
    $rtype=$_REQUEST["rtype"];
}else{
    $rtype='P';
}

$html = '';
$this->pageTitle=Yii::app()->name . ' - Add / Edit Retail On Quantity';
$ga="/index.php?r=admin_bl/Isq_edit_screen/mcat&mid=3504";	

echo '<html><head><style type="text/css">
.hdfield{font-size:15px; color:#2676d1;}
.admintext1 {font-family: arial;font-size: 12px; padding:0 5px;line-height:20px;}
.admintext2 {font-family: arial;font-size: 12px; font-weight: bold; padding:0 5px;line-height:20px;}
.search { width: 10em;  height: 2em;}
</style>	
	
<script src="'.$utilsHost.'/js/jquery.min.js"></script>
<script src="'.$utilsHost.'/js/jquery-ui.min.js"></script>
<script type="text/javascript">
function showdiv(){
            document.getElementById(\'div_quotes\').style.display = "block";
           
        }
        function addTextArea1(){
            var div = document.getElementById(\'div_quotes\');
            div.innerHTML = "";
            div.innerHTML += "\n<br />";
        }

 function lookup(idd,obj,divId) {
		
		$("#mcatsmain").css("display", "block");
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
           mcatid_sel.value=mcatid;
           $("#mcatsmain").hide();
           
        }
        
        function chechform()
        {
         if(mcat_name.value.trim() =="")
         {
          alert("Please Enter Mcat Name");
          return false;
         }
        }
        
</script>';
?>
    
    
<script>
function addretail(){
        a={};
        a['unitid']=$('#unitid').val();
        a['industry_id']=$('#industry_id').val();
        a['industry_type']=$('#industry_type').val();
        a['cutoff']=$('#cutoff').val();                            
        a['action']=$('#add').val();
        if(a['cutoff'] == ""){
            alert('Please Select Cut OFF');
            return false;
        }else{
                 if(!$.isNumeric(a['cutoff'])){
                     alert('Invalid Quantity cut Off');
                     return false;
                 }
            }
       
           
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Retail_marking/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#add_message").html(result); 
                    $("#add").show(); 
            }
            , 	 	
            error: function(result) {
                    alert(result.responseText);
                    return false;
                    alert('Error occured');
                    result = false;
                    $("#add").show(); 
            } 	 	
            });  
}

function Update(i){
         a={};
           var unitid=$('#unitid'+i).val();
           var unitid_old=$('#unitid_old'+i).val();
           var industry_id=$('#industry_id'+i).val();
           var industry_type=$('#industry_type'+i).val();
           var cutoff=$('#cutoff'+i).val();
           var status=$('#status'+i).val();
           if(cutoff === ""){
                alert('Please fill Cut OFF for '+i);
                return false;
            }else{
                 if(!$.isNumeric(cutoff)){
                     alert('Invalid Quantity cut Off for Row Number: '+i);
                     return false;
                 }
            }
             a['unitid']=unitid,
             a['unitid_old']=unitid_old,
             a['industry_id']= industry_id;
             a['industry_type']=industry_type;
             a['cutoff']=cutoff; 
             a['status']=status;
            a['action']=$('#update'+i).val(); 
            $("#update"+i).hide();            
            
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Retail_marking/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#update_message"+i).html(result);                     
            }
            , 	 	
            error: function(result) {
                    $("#update_message"+i).html(result.responseText); 
                    $("#update"+i).show();
                    return false; 
            } 	 	
            });         
       
}
</script>
</head><body>
<?php
	echo '<TABLE bordercolor="#bedaff" border="1" cellpadding="4" class="table_txt" style="border-collapse: collapse; width:98%">
	<TR><TD colspan="2" bgcolor="#F0F9FF"><div ALIGN="CENTER" STYLE="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" width="70%">Add or Modify Retail Valuation Matrix</div></TD></TR>
	<TR><TD width="30%" bgcolor="#F0F9FF">
	<FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" onsubmit="return chechform();">
	<input type="hidden" name="mid" value="'.$cookie_mid.'">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>';
echo '<td WIDTH="90%" class="admintext1"><b>MCAT:</b>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="TEXT" style="width:300px" class="admintext1" name="mcat_name" id="mcat_name" autocomplete="off" onkeyup="lookup(\'mcat_name\',\'MCAT\',\'mcats\');" value="'.$mcatName.'">
<INPUT TYPE="hidden" name="mcatid_sel" id="mcatid_sel" value="'.$mcat_id.'">';
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
echo '<input type="hidden" name="action" value="Search"><INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Show Detail">
</TD>
</TR>
<TR>
<TD width="40%"><div id="mcatsmain" style="height:200px;overflow:auto;display:none; font-family: arial;font-size: 11px;width:500px;"><div id="mcats"></div></div></TD>
</TR>
</TABLE></TABLE></FORM><br><br>';
 $html = '<FORM name="retail_add" METHOD="post" ACTION="index.php?r=admin_eto/Retail_marking/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
      
 if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Search' && $mcat_id > 0)) 
 {   
    $html_unit='';$unitid=$text='';
    if(empty($glunitlist)){
        foreach($glunitlistall as  $rec_unit){
            if(isset($rec_unit['GL_UNIT_ID'])){
                $unitid = $rec_unit['GL_UNIT_ID'];
        }
         if(isset($rec_unit['GL_UNIT_NAME'])){
                 $text = $rec_unit['GL_UNIT_NAME'];
        }
         if(isset($rec['FK_GL_UNIT_ID']) && ($rec['FK_GL_UNIT_ID']==$unitid)){
             $html_unit .= '<OPTION selected VALUE="'.$unitid.'">'.$text.'</OPTION>';
         }else{
             $html_unit .= '<OPTION VALUE="'.$unitid.'">'.$text.'</OPTION>';
        }
    }
}

    if(!empty($glunitlist)){
           foreach($glunitlist as  $key=>$value){
            $unitid = $key;
            $text = $value;
            $html_unit .= '<OPTION VALUE="'.$unitid.'">'.$text.'</OPTION>';
            }
        }
           
    $html .='<table style="border-collapse: collapse;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" id="s">
             <th colspan="8" style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">Add new Combination of Retail Valuation</th>
                <tr><td class="admintext2">SN</td>
                <td class="admintext2">Mcat ID</td>
                <td class="admintext2">Unit ID</td>
                <td class="admintext2">Retail Evaluation Type</td>
                <td class="admintext2">Qty Cutoff</td>  
                </tr>';                            
            $html .='<tr>
                    <td>1</td>
                    <td><input readonly type="text" class="admintext1" width="100px" value="'.$mcat_id.'" name="industry_id" id="industry_id"></td>';
        $html .=    '<td><select class="admintext1" width="100px" name="unitid" id="unitid">'.$html_unit.'</select></td>                        
                    <td>
                    <select class="admintext1" style="width:100px;" id="industry_type" name="industry_type">
                    <option value="1" Selected>MCAT</option><option value="2">Order Value</option>
                    </select></td>
                    <td><input type="text" class="admintext1" width="100px"  name="cutoff" id="cutoff" value=""></td> 
                    </tr>
                    <tr>
                    <td align="center" colspan="5"><input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" type="button" name="add" id="add" value="Add" onClick="addretail()">
                       <span id="add_message" style="width:500px">
                    </td></tr>'; 
            
        $html .='</table>';
     $html .='</FORM>';
     
     
     $html .= '<br/><FORM name="retail_edit" METHOD="post" ACTION="index.php?r=admin_eto/Retail_marking/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
     $html .='<table style="border-collapse: collapse;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" id="s">
             <th colspan="11" style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">Update/Modify existing combination of Retail Valuation</th>
                <tr>
                <td class="admintext2"  style="width: 2%;"  align="center">SN</td>
                <td class="admintext2"  style="width: 8%;" align="center">Mcat ID</td>
                <td class="admintext2"  style="width: 10%;" align="center">Unit ID</td>
                <td class="admintext2"  style="width: 10%;" align="center">Retail Evaluation Type</td>
                <td class="admintext2"  style="width: 5%;" align="center">Qty Cutoff</td>   
                <td class="admintext2"  style="width: 10%;" align="center">Status</td>
                <td class="admintext2"  style="width: 10%;" align="center">Inserted By</td>
                <td class="admintext2"  style="width: 10%;" align="center">Inserted On</td>
                <td class="admintext2"  style="width: 10%;" align="center">Updated By</td>
                <td class="admintext2"  style="width: 10%;" align="center">Updated On</td>
                <td class="admintext2"  style="width: 10%;" align="center">Action</td>   
                </tr>';
            if(!empty($resultArr)){
                $i=0;
                foreach($resultArr as $row)
                    {
                        $status_row=isset($row['LEAP_RETAIL_STATUS'])?$row['LEAP_RETAIL_STATUS']:'';
                     $i++;                    
                     $html .='<tr>
                     <td align="center">'.$i.'</td>
                     <td align="center"><input type="hidden" id="unitid_old'.$i.'" value="'.$row['FK_GL_UNIT_ID'].'" >
                     <input readonly type="text" class="admintext1" width="100px" value="'.$row['LEAP_RETAIL_INDUSTRY_ID'].'" name="industry_id'.$i.'" id="industry_id'.$i.'"></td>';
                     $html_unit='';$unitid=$text='';
                     if(empty($glunitlist)){
                        foreach($glunitlistall as  $rec_unit){
                            if(isset($rec_unit['GL_UNIT_ID'])){
                                $unitid = $rec_unit['GL_UNIT_ID'];
                        }
                         if(isset($rec_unit['GL_UNIT_NAME'])){
                                 $text = $rec_unit['GL_UNIT_NAME'];
                        }
                         if(isset($rec['FK_GL_UNIT_ID']) && ($rec['FK_GL_UNIT_ID']==$unitid)){
                             $html_unit .= '<OPTION selected VALUE="'.$unitid.'">'.$text.'</OPTION>';
                         }else{
                             $html_unit .= '<OPTION VALUE="'.$unitid.'">'.$text.'</OPTION>';
                        }
                    }
                }
                
                    if(!empty($glunitlist)){
                        foreach($glunitlist as  $key=>$value){
                            $unitid = $key;
                            $text = $value;
                            if(isset($row['FK_GL_UNIT_ID']) && ($row['FK_GL_UNIT_ID']==$unitid)){
                                $html_unit .= '<OPTION selected VALUE="'.$unitid.'">'.$text.'</OPTION>';
                            }else{
                                $html_unit .= '<OPTION VALUE="'.$unitid.'">'.$text.'</OPTION>';
                            }
                           }
                        }
                    $html .= '<td align="center"><select class="admintext1" width="100px" name="unitid'.$i.'" id="unitid'.$i.'">'.$html_unit.'</select></td>                        
                        <td align="center"><select class="admintext1" style="width:100px;" id="industry_type'.$i.'" name="industry_type'.$i.'">';
                     if(isset($row['LEAP_RETAIL_INDUSTRY_TYPE']) && ($row['LEAP_RETAIL_INDUSTRY_TYPE']==1)){
                             $html .=  '<option value="1" selected>MCAT</option><option value="2">Order Value</option>';
                        }else{
                             $html .= '<option value="1">MCAT</option><option value="2" selected>Order Value</option>';
                        }
                            
                    $html .= '</select></td>
                        <td align="center"><input type="text" class="admintext1" width="100px"  name="cutoff'.$i.'" id="cutoff'.$i.'" value="'.$row['LEAP_RETAIL_QTY_CUTOFF'].'"></td>';
                        $html .= '<td align="center"><select class="admintext1" style="width:100px;" id="status'.$i.'" name="status'.$i.'">';
                     if($status_row==1 || $status_row==''){
                             $html .=  '<option value="1" selected>Enabled</option><option value="0">Disabled</option>';
                        }else{
                             $html .= '<option value="1">Enabled</option><option value="0" selected>Disabled</option>';
                        } 
                        $html .= '<td align="center">'; if(isset($row['LEAP_RETAIL_INSERTED_BY'])){
                            $html .= ''.$row['LEAP_RETAIL_INSERTED_BY'].'';
                        }
                        $html .= '</td><td align="center">'; if(isset($row['LEAP_RETAIL_INSERT_DATE'])){
                            $html .= ''.$row['LEAP_RETAIL_INSERT_DATE'].'';
                        }
                           $html .= '</td><td align="center">'; if(isset($row['LEAP_RETAIL_UPDATED_BY'])){
                            $html .= ''.$row['LEAP_RETAIL_UPDATED_BY'].'';
                        }
                        $html .= '</td><td align="center">'; if(isset($row['LEAP_RETAIL_UPDATE_DATE'])){
                            $html .= ''.$row['LEAP_RETAIL_UPDATE_DATE'].'';
                        }
                     $html .='</td><td align="center" colspan="5"><input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" type="button" name="update'.$i.'" id="update'.$i.'" value="Update" onClick="Update('.$i.')">
                        <span id="update_message'.$i.'" style="width:500px">
                        </td>';
                    $html .= '</tr>
                        '; 
                 }
            }
        $html .='</table>';
        $html .='<br><br>';
    }
    $html .='</FORM>';
 
   echo $html;

 
?>