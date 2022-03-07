<?php
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$html = '';
$rtype =isset($_REQUEST['rtype']) ? $_REQUEST['rtype'] : '0';

echo '<html><head><style type="text/css">
.hdfield{font-size:15px; color:#2676d1;}
.admintext1 {font-family: arial;font-size: 12px; padding:0 5px;line-height:20px;}
.admintext2 {font-family: arial;font-size: 12px; font-weight: bold; padding:0 5px;line-height:20px;}
.search { width: 10em;  height: 2em;}
.blinking{
    animation:blinkingText 1.2s infinite;
}
@keyframes blinkingText{
    0%{     color: #000;    }
    49%{    color: red; }
    60%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #000;    }
}

</style>	
	
<script src="'.$utilsHost.'/js/jquery.min.js"></script>
<script src="'.$utilsHost.'/js/jquery-ui.min.js"></script>';
?>
    
    
<script>
    function add_isq_display(exp){
	if(exp ==1)
	{
		$("#add_isq_show").css("display", "none");
		$("#add_isq_hide").css("display", "");
		$("#s").css("display", "");
	}
	else
	{
		$("#add_isq_show").css("display", "");
		$("#add_isq_hide").css("display", "none");
		$("#s").css("display", "none");
	}
}
function addretail(){
        a={};
        a['vendor_name']=$('#vendor_name').val();
        a['percentage']=$('#percentage').val();
        a['pri_number']=$('#pri_number').val(); 
        a['pri_flag']=$('#pri_flag').val();
        a['action']=$('#add').val();
        if(a['pri_number'] == ""){
            alert('Please Fill PRI Number');
            return false;
        }else{
                 if(!$.isNumeric(a['pri_number'])){
                     alert('Invalid PRI Number');
                     return false;
                 }
            }
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Pnscall_fallback/Index",	
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
           var vendor_name=$('#vendor_name'+i).val();
           var percentage=$('#percentage'+i).val();
           var pri_number=$('#pri_number'+i).val();
           a['pri_flag']=$('#pri_flag').val();
           a['vendor_name']=vendor_name;
            a['percentage']=percentage;
            a['pri_number']=pri_number;                            
            
           if(pri_number== ""){
            alert('Please Fill PRI Number');
            return false;
        }else{
                 if(!$.isNumeric(pri_number)){
                     alert('Invalid PRI Number');
                     return false;
                 }
            }
            a['action']=$('#update'+i).val(); 
            $("#update"+i).hide();            
            
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Pnscall_fallback/Index",	
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
function Disable(i){
         a={};
           var vendor_name=$('#vendor_name'+i).val();
           var pri_number=$('#pri_number'+i).val();
           a['vendor_name']=vendor_name;
            a['pri_number']=pri_number;                            
            a['pri_flag']=$('#pri_flag').val();

           if(pri_number== ""){
            alert('Please Fill PRI Number');
            return false;
        }else{
                 if(!$.isNumeric(pri_number)){
                     alert('Invalid PRI Number');
                     return false;
                 }
            }
            a['action']=$('#disable'+i).val(); 
            $("#disable"+i).hide();            
            
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Pnscall_fallback/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#disable_message"+i).html(result);                     
            }
            , 	 	
            error: function(result) {
                    $("#disable_message"+i).html(result.responseText); 
                    $("#disable"+i).show();
                    return false; 
            } 	 	
            });         
       
}

function Enable(i){
         a={};
           var vendor_name=$('#vendor_name'+i).val();
           var pri_number=$('#pri_number'+i).val();
           a['vendor_name']=vendor_name;
            a['pri_number']=pri_number;                            
            a['pri_flag']=$('#pri_flag').val();

           if(pri_number== ""){
            alert('Please Fill PRI Number');
            return false;
        }else{
                 if(!$.isNumeric(pri_number)){
                     alert('Invalid PRI Number');
                     return false;
                 }
            }
            a['action']=$('#enable'+i).val(); 
            $("#enable"+i).hide();            
            
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Pnscall_fallback/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#enable_message"+i).html(result);                     
            }
            , 	 	
            error: function(result) {
                    $("#enable_message"+i).html(result.responseText); 
                    $("#enable"+i).show();
                    return false; 
            } 	 	
            });         
       
}


function Delete(i){
         a={};
           var vendor_name=$('#vendor_name'+i).val();
           var pri_number=$('#pri_number'+i).val();
           a['vendor_name']=vendor_name;
            a['pri_number']=pri_number;                            
            a['pri_flag']=$('#pri_flag').val();

           if(pri_number== ""){
            alert('Please Fill PRI Number');
            return false;
        }else{
                 if(!$.isNumeric(pri_number)){
                     alert('Invalid PRI Number');
                     return false;
                 }
            }
            a['action']=$('#delete'+i).val(); 
            $("#delete"+i).hide();            
            
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Pnscall_fallback/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#update_message"+i).html(result);                     
            }
            , 	 	
            error: function(result) {
                    $("#delete_message"+i).html(result.responseText); 
                    $("#delete"+i).show();
                    return false; 
            } 	 	
            });         
       
}
</script>
</head><body>
<?php 
	echo '<TABLE bordercolor="#bedaff" border="1" cellpadding="4" class="table_txt" style="border-collapse: collapse; width:98%">
	<TR><TD colspan="2" bgcolor="#F0F9FF"><div ALIGN="CENTER" STYLE="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" width="70%">PNS CALL API Fallback Distribution </div>
        </TD></TR>
	<TR><TD width="30%" bgcolor="#F0F9FF">
	<FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" onsubmit="return chechform();">
	<input type="hidden" name="mid" value="'.$cookie_mid.'">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>';
 ?>
<td>&nbsp;<input type="radio" id="rtypeP" name="rtype" value="0" <?php echo ($rtype == '0' || $rtype == '')?'checked':''; ?> >&nbsp;Primary  Fallback Number
&nbsp;&nbsp;&nbsp;<input type="radio" id="rtypeS" name="rtype" value="1" <?php echo ($rtype == '1')?'CHECKED="CHECKED"':'' ?> >&nbsp;Secondary Fallback Number 
</td>      
<?php 
   echo '<td WIDTH="40%" class="admintext1" align="center" ><input type="hidden" name="action" value="Search">
    <INPUT style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" TYPE="SUBMIT" NAME="Submit1" VALUE="Show Detail">
</TD>';
   echo '</TR>
</TABLE></TABLE></FORM><br>';
 $html = '<FORM name="retail_add" METHOD="post" ACTION="index.php?r=admin_eto/Pnscall_fallback/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
      
 if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Search')) 
 {   
                $perarray=array(5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100);
     	 	$allVenders=CommonVariable::get_active_vendor_list();
                $i=$tot_percentage=0;

    $html .='<table style="border-collapse: collapse;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
             <th colspan="8" style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">Add new PNS CALL API Fallback Distribution</th>
                <tr><td class="admintext2">Vendor Name</td>
                <td class="admintext2">PRI Number</td>
                <td class="admintext2">Percentage</td>  
                </tr>'; 
    $drp=$drpp='';
            $html .='<tr>
                    <td>
                    <select class="admintext1" style="width:100px;" id="vendor_name" name="vendor_name">';
            foreach($allVenders as $key => $values){                                      
                                        $drp .= '<option value="'.$values.'">'.$values.'</option>';                                      
                                  }
                    $html .= $drp.'</select></td>
                    <td><input type="text" class="admintext1" width="100px"  name="pri_number" id="pri_number" value=""></td> 
                   <td><select class="admintext1" style="width:100px;" id="percentage" name="percentage">';
                    foreach($perarray as $key){                                      
                        $drpp .= '<option value="'.$key.'">'.$key.'</option>';                                      
                    }
                    $html .= $drpp.'</select></td>
                    </tr>
                    <tr>
                    <td align="center" colspan="3"><input type="hidden" name="pri_flag" id="pri_flag" value="'.$rtype.'">
                    <input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" 
                    type="button" name="add" id="add" value="Add" onClick="addretail()">
                       <span id="add_message" style="width:500px">
                    </td></tr>'; 
            
        $html .='</table>';
     $html .='</FORM>';
     
     
     $html .= '<br/><FORM name="retail_edit" METHOD="post" ACTION="index.php?r=admin_eto/Retail_marking/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
     $html .='<table style="border-collapse: collapse;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" >
             <th colspan="5" style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">Update/Modify existing PNS CALL API Fallback Distribution</th>
                <tr>
                <td class="admintext2"  style="width: 2%;"  align="center">SN</td>
                <td class="admintext2"  style="width: 8%;" align="center">Vendor Name</td>
                <td class="admintext2"  style="width: 10%;" align="center">PRI Number</td>
                <td class="admintext2"  style="width: 10%;" align="center">Percentage</td><td></td></tr>';
            if(!empty($resultArr)){
                foreach($resultArr as $row)
                    {
                    $trcolor=$drpp='';
                     $i++;
                     if($row['is_enabled']==1){$html .='<tr>';
                     $tot_percentage=$row['percentage']+$tot_percentage;
                     }else{$html .='<tr style="background-color:#ffc0cb">'  ;
                     }
                     
                     $html .='<td align="center" >'.$i.'</td><td align="center"><input type="text" readonly class="admintext1" width="100px"  name="vendor_name'.$i.'" id="vendor_name'.$i.'" value="'; 
                     if(isset($row['vendor_name'])){
                            $html .= ''.$row['vendor_name'].'';
                        }
                        $html .= '"></td><td align="center"><input type="text" class="admintext1" width="100px"  name="pri_number'.$i.'" id="pri_number'.$i.'" value="'; 
                        if(isset($row['pri_number'])){
                            $html .= ''.$row['pri_number'].'';
                        }
                        $html .= '" ></td><td align="center"><select class="admintext1" style="width:100px;" id="percentage'.$i.'" name="percentage'.$i.'">';
                        foreach($perarray as $key){    
                            if(isset($row['percentage']) && $key== $row['percentage']){
                               $drpp .= '<option value="'.$key.'" Selected >'.$key.'</option>';
                            }else{
                                $drpp .= '<option value="'.$key.'">'.$key.'</option>';
                            }
                        }
                     $html .=$drpp.'</select></td><td align="center" colspan="3">'
                             . '<input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" type="button" name="update'.$i.'" id="update'.$i.'" value="Update" onClick="Update('.$i.')">
                        <span id="update_message'.$i.'" style="width:500px">'
                             . '<input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" '
                             . 'type="button" name="delete'.$i.'" id="delete'.$i.'" value="Delete" onClick="Delete('.$i.')"></span>
                        <span id="delete_message'.$i.'" style="width:500px"></span>';
                        if($row['is_enabled']==1){
                            $html .='<input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" type="button" '
                                    . 'name="disable'.$i.'" id="disable'.$i.'" value="Disable" onClick="Disable('.$i.')">
                            <span id="disable_message'.$i.'" style="width:500px">';
                        }else{
                            $html .='<input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" type="button" name="enable'.$i.'" id="enable'.$i.'" value="Enable" onClick="Enable('.$i.')">
                            <span id="enable_message'.$i.'" style="width:500px">';                           
                        }
                    $html .= '<input type="hidden" name="pri_flag" value="'.$rtype.'"></td>';
                    $html .= '</tr>
                        '; 
                 }
                 $html .= '</tr>';
            }
        $html .='</table>';
        $html .='<br><br>';
    }
    $html .='</FORM>';
 if($tot_percentage >0 && $tot_percentage<100){
        echo '<div align="center" style="color:red"><b><span class="blinking">Total % is Less than 100%, Please Recheck</span></b></div><br>';
 }
 
            if(!empty($resultArr_deleted)){
                 $html .='<div id="deleted_dv" style="line-height:20px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">
      Deleted PNS CALL API Fallback Distribution Detail &nbsp;<a href="javascript:add_isq_display(1)" style="text-decoration:none;font-size:30px;color:#fff">
      <span id="add_isq_show">+</a></span></a><a href="javascript:add_isq_display(2)" style="text-decoration:none;font-size:30px;color:#fff;">
             <span id="add_isq_hide" style="display:none;color:#fff">-</a></span></a></div>
                <table style="border-collapse: collapse;display:none;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" id="s">
           <tr>
                <td class="admintext2"  style="width: 2%;"  align="center">SN</td>
                <td class="admintext2"  style="width: 8%;" align="center">Vendor Name</td>
                <td class="admintext2"  style="width: 10%;" align="center">PRI Number</td>
                <td class="admintext2"  style="width: 10%;" align="center">Percentage</td></tr>';
 
                foreach($resultArr_deleted as $row)
                    {
                    $drpp='';
                     $i++;                    
                     $html .='<tr><td align="center">'.$i.'</td><td align="center"><input type="text" readonly class="admintext1" width="100px"  name="vendor_name'.$i.'" id="vendor_name'.$i.'" value="'; 
                     if(isset($row['vendor_name'])){
                            $html .= ''.$row['vendor_name'].'';
                        }
                        $html .= '"></td><td align="center"><input type="text" class="admintext1" width="100px"  name="pri_number'.$i.'" id="pri_number'.$i.'" value="'; 
                        if(isset($row['pri_number'])){
                            $html .= ''.$row['pri_number'].'';
                        }
                        $html .= '" ></td><td align="center"><select class="admintext1" style="width:100px;" id="percentage'.$i.'" name="percentage'.$i.'">';
                        foreach($perarray as $key){    
                            if(isset($row['percentage']) && $key== $row['percentage']){
                               $drpp .= '<option value="'.$key.'" Selected >'.$key.'</option>';
                            }else{
                                $drpp .= '<option value="'.$key.'">'.$key.'</option>';
                            }
                        }
                        $tot_percentage=$row['percentage']+$tot_percentage;
                     $html .=$drpp.'</select></td>';
                    $html .= '</tr>
                        '; 
                 }
                 $html .= '</tr>';
                 $html .='</table>';
            }
        $html .='<br><br>';
    
   echo $html;

 
?>