<?php
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$html = '';
$fk_eto_leap_emp_id =isset($_REQUEST['emp_id']) ? $_REQUEST['emp_id'] : '';

echo '<html><head><script src="'.$utilsHost.'/js/jquery.min.js"></script>
<script src="'.$utilsHost.'/js/jquery-ui.min.js"></script>';
?>  
<script>
    
function Save(){
    var a ={};
    var x={};
    var j=0;
    for (i = 1; i < 6; i++) { 
            var fk_gl_language_id_v=$("#fk_gl_language_id"+i).val();//alert('fk_gl_language_id'+fk_gl_language_id_v);
            var language_priority_v=$("#language_priority"+i).val();//alert('language_priority'+language_priority_v);
            if(fk_gl_language_id_v>0){
                for (j = 1; j < 6; j++) {
                var fk_gl_language_id_a=$("#fk_gl_language_id"+j).val();//alert('fk_gl_language_id'+fk_gl_language_id_v);
                var language_priority_a=$("#language_priority"+j).val();//alert('language_priority'+language_priority_v);
                if(fk_gl_language_id_a>0 && j !== i){ //alert(fk_gl_language_id_a+'fk_gl_language_id'+fk_gl_language_id_v);
                    if(fk_gl_language_id_v === fk_gl_language_id_a){
                        alert('Duplicate Language selected');return false;
                    }
                    if(language_priority_v === language_priority_a){
                        alert('Duplicate Language Priority selected');return false;
                    }
                }
            }
        }  
        }
        
            var empid=$('#fk_eto_leap_emp_id').val(); 
            for (i = 1; i < 6; i++) { 
            var fk_gl_language_id_v=$("#fk_gl_language_id"+i).val();//alert('fk_gl_language_id'+fk_gl_language_id_v);
            var language_priority_v=$("#language_priority"+i).val();//alert('language_priority'+language_priority_v);
            if(fk_gl_language_id_v>0){ 
                    x[j]={
                        fk_eto_leap_emp_id:empid,
                        fk_gl_language_id:fk_gl_language_id_v,
                        language_priority:language_priority_v
                    };
                    j=j + 1;
            }
        }
        if(j === 0){
            alert('Please Select atleast one Language');return false;
        }
            var newArr=JSON.stringify(x);
            a['emp_lang_list']=newArr;
            a['action']='Save'; 
            a['fk_eto_leap_emp_id']=empid; 
            
            $("#update").hide();            
            
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/Language/Index",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#update_message").html(result);                     
            }
            , 	 	
            error: function(result) {
                    $("#update_message").html(result); 
                    return false; 
            } 	 	
            });         
       
}
function Moreoption(id,exp)
{
	if(exp ===2){
		id2=id-1;
	}
	else{
		id2=id+1;
	}
        if(exp ===1)
        {
                $("#div"+id2).css("display", "");
                $("#span"+id).css("display", "none");     
        }
        else
        {
                $("#"+div+id).css("display", "none");
                $("#"+span+id2).css("display", "none");
        }
}
function checkform()
{
var empId = $("#emp_id").val();
    if(empId == ""){
            alert("Please enter Employee Id");
            $("#emp_id").focus();
            return false;		
    }
    if(emp_id.value.match('^[0-9]+\$')){
        
    }else{
        alert('Enter only Numeric Value');return false;
    } 
}
</script>
</head><body>
<TABLE bordercolor="#bedaff" border="1" cellpadding="4" class="table_txt" style="border-collapse: collapse; width:98%">
<TR><TD colspan="2" bgcolor="#F0F9FF"><div ALIGN="CENTER" STYLE="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" width="70%">Manage Agent Language</div>
</TD></TR>
<TR><TD width="30%" bgcolor="#F0F9FF">
<FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" onsubmit="return checkform();">
<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
<tr><td WIDTH="40%" class="admintext1" align="center" >
<input style="width:80px;height:25px" name="emp_id" id="emp_id" value="<?php echo $fk_eto_leap_emp_id;?>" >
<input type="hidden" name="action" value="Search">
    <INPUT style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" TYPE="SUBMIT" NAME="Submit1" VALUE="Show Detail"></TD></TR>
</TABLE></TABLE></FORM><br>
 <?php $html = '<FORM name="retail_add" METHOD="post" ACTION="index.php?r=admin_eto/Language/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
  // print_r($resultArr);   
  
                $priarray=array(1,2,3,4,5);
                $langArr=array(0=>'Select',1=>'English',
2=>'Hindi',
3=>'Bengali',
4=>'Tamil',
5=>'Marathi',
6=>'Urdu',
7=>'Gujarati',
8=>'Telugu',
9=>'Sanskrit',
10=>'Kannada',
11=>'Malayalam',
12=>'Punjabi',
13=>'Odia',
14=>'Mizo',
15=>'Assamese',
16=>'Nepali',
17=>'Meitei (Manipuri)',
18=>'Khasi',
19=>'Nagamese',
20=>'Konkani',
21=>'Silent');
                
 $i=0;               
 if((isset($_POST['Submit1'])) && (!empty($resultArr))){
     $html .= '<br/><FORM name="retail_edit" METHOD="post" ACTION="index.php?r=admin_eto/Retail_marking/Index&mid='.$cookie_mid.'" STYLE="margin-top:0;margin-bottom:0;">';
     $html .='<table style="border-collapse: collapse;" width="99%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" >
             <th colspan="4" style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff">Update/Modify existing Agent Language - Emp ID -'.$fk_eto_leap_emp_id.'</th>
                <tr>
                <td class="admintext2"  style="width: 10%;line-height:25px;"  align="center"><b>SN</b></td>
                <td class="admintext2"  style="width: 40%;line-height:25px;" align="center"><b>Language</b></td>
                <td class="admintext2"  style="width: 40%;line-height:25px;" align="center"><b>Priority</b></td><td style="width: 10%;"></td></tr>';
                foreach($resultArr as $row)
                    {//print_r($row);
                    $drpl=$drpp='';
                     $i++;
                     $html .='<tr id="div'.$i.'"><td align="center" >'.$i.'</td>
                        <td align="center"><select class="admintext1" style="width:100px;" id="fk_gl_language_id'.$i.'" name="fk_gl_language_id'.$i.'">';
                        foreach($langArr as $key=>$value){    
                            if(isset($row['fk_gl_language_id']) && $key== $row['fk_gl_language_id']){
                               $drpl .= '<option value="'.$key.'" Selected >'.$value.'</option>';
                            }else{
                                $drpl .= '<option value="'.$key.'">'.$value.'</option>';
                            }
                        }
                     $html .=$drpl.'</select></td><td align="center"><select class="admintext1" style="width:100px;" id="language_priority'.$i.'" name="language_priority'.$i.'">';
                        foreach($priarray as $key){    
                            if(isset($row['language_priority']) && $key== $row['language_priority']){
                               $drpp .= '<option value="'.$key.'" Selected >'.$key.'</option>';
                            }else{
                                $drpp .= '<option value="'.$key.'">'.$key.'</option>';
                            }
                        }
                     $html .=$drpp.'</select></td><td>';
                     if(count($resultArr)==$i){
                     $html .='<span id="span'.$i.'" ><a href="javascript:Moreoption('.$i.',1)" style="text-decoration:none;font-size:20px;font-weight:bold">+</a></span>'; 
                    }
                    $html .='</td></tr>';
                }
            echo $html;
            $html_add='';
            $drpl=$drpp='';
            foreach($langArr as $key=>$value){    
                            $drpl .= '<option value="'.$key.'">'.$value.'</option>';
                        }
             foreach($priarray as $key){                                      
                        $drpp .= '<option value="'.$key.'">'.$key.'</option>';                                      
                    }           
for($cnt=1;$cnt<6;$cnt++){
            $i++;
            $display='none';$spdisplay='';
            if($i == 1){
                    $display='';
                }
                if($i==5)  {
                    $spdisplay='none';
                } 
            $html_add .='<tr id="div'.$i.'" style="display:'.$display.'"><td align="center" >'.$i.'</td><td align="center"><select class="admintext1" style="width:100px;" id="fk_gl_language_id'.$i.'" name="fk_gl_language_id'.$i.'">';                    
            $html_add .= $drpl.'</select></td><td align="center"><select class="admintext1" style="width:100px;" id="language_priority'.$i.'" name="language_priority'.$i.'">';
                    
            $html_add .= $drpp.'</select></td><td><span id="span'.$i.'" style="display:'.$spdisplay.'">'
                            . '<a href="javascript:Moreoption('.$i.',1)" style="text-decoration:none;font-size:20px;font-weight:bold">+</a></span></td></tr>'; 
}
        $html_add .='<tr><td align="center" colspan="4">'
                . '<input style="line-height:25px;font-family:arial;font-size:14px;font-weight:bold;background-color:#006DCC;color:#fff" 
                    type="button" name="update" id="update" value="Save" onClick="Save()">
        <span id="update_message" style="width:400px"><input id="fk_eto_leap_emp_id" type="hidden" value="'.$fk_eto_leap_emp_id.'"></td></tr></table>';
     $html_add .='</FORM><br><br>';    
   echo $html_add;
}else{
    //echo 'No Leap Agent Detail found';
}
 
?>