<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html>
    <head>
      <title>Vendor Login Access</title>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js" ></script>
  </head>
      <body>
      <style>
	.td-label{font-size:18px;padding-right: 20px;}
      </style>
      <script type="text/javascript">
      setInterval(function () {
      	 $("#errMsg,#succMsg").delay(1000).hide(); }
      , 30000);
      function changeVal(){
			 if($('#is_working').is(":checked")){
     			$("#is_working").val(1);
     		}else{
				$("#is_working").val(0);     	
     		}     
      }
     
  			
			
	function checkFields(){
	    var empId = $("#emp_id").val().trim();
	    var vendorName = $("#vendor_name").val().trim();
	    var empLevel = $("#emp_level").val().trim();
            var empskillLevel = $("#emp_skill_level").val().trim();

		var vendor_emp_id = $("#vendor_emp_id").val().trim();
	    if(empId == ''){
		alert("Please enter Employee Id");
		$("#emp_id").focus();
		return false;
	    } else if(!empId.match(/(\d+)$/)){
		alert("Invalid Employee Id");
		$("#emp_id").focus();
		return false;
	    } else if(vendorName == ''){
		alert("Please select Vendor Name");
		$("#vendor_name").focus();
		return false;
	    } else if(empLevel == ''){
		alert("Please select Employee Level");
		$("#emp_level").focus();
		return false;
	    } else if(empskillLevel == ''){
		alert("Please select Employee Skill Level");
		$("#emp_skill_level").focus();
		return false;
	    } else if(vendor_emp_id!='' && !vendor_emp_id.match(/^[0-9a-zA-Z]+$/) ){
			alert("Invalid Vendor Emp Id. Only Alphanumeric values are allowed.");
		$("#vendor_emp_id").focus();
		return false;
	    }  
		else{
	      $("#vendorLoginAccess").submit();
	    }
	}
	function checkUpdateFields(){
	    var empId = $("#emp_id_updt").val().trim();
	    var vendorName = $("#vendor_name_updt").val().trim();
	    var empLevel = $("#emp_level_updt").val().trim();
            var empskillLevel = $("#emp_skill_level_updt").val().trim();
        var extno= $("#extension_no").val().trim();
	    var vendor_emp_id = $("#vendor_emp_id").val().trim();
	    if(empId == ''){
		alert("Please enter Employee Id");
		$("#emp_id_updt").focus();
		return false;
	    } else if(!empId.match(/(\d+)$/)){
		alert("Invalid Employee Id");
		$("#emp_id_updt").focus();
		return false;
	    } else if(vendorName == ''){
		alert("Please select Vendor Name");
		$("#vendor_name_updt").focus();
		return false;
	    } else if(empLevel == ''){
		alert("Please select Employee Level");
		$("#emp_level_updt").focus();
		return false;
	    } else if(empskillLevel == ''){
		alert("Please select Employee Skill Level");
		$("#emp_level_updt").focus();
		return false;
	    } else if(vendor_emp_id!='' && !vendor_emp_id.match(/^[0-9a-zA-Z]+$/) ){
			alert("Invalid Vendor Emp Id. Only Alphanumeric values are allowed.");
		$("#vendor_emp_id").focus();
		return false;
	    } 
		else if(vendorName== '51|OAP_PD' && extno=='' ){
		alert("Please enter Extension number!");
		$("#extension_no").focus();
		return false;
	    } 
		else{
	      $("#updateVendorLoginAccess").submit();
	    }
	}
	function empDetails(emp_id){
		$("#errMsg").hide();
		var empId = $("#"+emp_id).val();
		if(empId == ""){
			alert("Please enter Employee Id");
			$("#emp_id_updt").focus();
			return false;		
		}
		 $.ajax({
                        url: "/index.php?r=admin_eto/Addvendor/vendorleapmis&mid=3443",
                        type: "POST",
                        data: {
                                action:'getempdetail',
                                empId:empId					
                        },
                       
                        success:function (result) {
                        	var res = $.parseJSON(result);
                        	if(res.errmsg != ''){
                                        $("#errMsg").html(res.errmsg);
                                        $("#errMsg").show();                  	
                                        $("#succMsg").hide();                  	
                        	}
                        	 $.each(res,function(key,value) {
          							
          							if(key == "is_working" && value == -1){
                                                                     $("#updateVendorLoginAccess").find("input[name='"+key+"']").attr("checked",true);         							
          							} else {
                                                                        $("#updateVendorLoginAccess").find("input[name='"+key+"']").val(value);
          								$("#updateVendorLoginAccess").find("select[name='"+key+"']").val(value);          							
          							}
     								 });
                        }
          });
	}
      </script>	  
	      <div style="width:100%;font-size:23px;font-family:arial">
		  <div style="font-size:23px;background:#c70408;color:#ffffff;text-align:center;font-family:arial;padding:10px 0px">Vendor Login Access</div>
		  <div style="padding:10px;background:#edeaea;border:1px solid #cccccc; text-align:center;  background:#E0DDDD; vertical-align:top; box-shadow: 1px 3px 1px #cccccc;text-shadow:1px 1px 1px #ffffff; border:1px solid #ffffff;">
		  <div><span style='color:red;font-size:20px;display:none;' id="errMsg"></span>
 		    <span style='color:green;font-size:20px;display:<?php echo !empty($succMsg)?"block":"none"; ?>' id="succMsg"><?php echo $succMsg; ?></span>
 		    <span style='color:red;font-size:20px;display:<?php echo !empty($errMsg)?"block":"none"; ?>' id="errMsg"><?php echo $errMsg; ?></span>
 			  </div>
		    <div style="width:35%;display:inline-block; margin:10px 10px 0px 10px; ; vertical-align:top; border-right:dotted 1px #A09D9D">
		    <?php
 		    if($showForm == 1){?>
		    <form action="/index.php?r=admin_eto/Addvendor/vendorleapmis&mid=3443" method="post" name="vendorLoginAccess" id="vendorLoginAccess">
		      <table width="70%" border="0" align="center" cellpadding="3" cellspacing="0">
			<tbody>
			  <tr>
			    <td width="40%" align="right" class="td-label">Emp Id </td>
			    <td align="left" width="50%">
			      <input style="width:80%;height:25px" id='emp_id' name='emp_id'></input>
			    </td>
			  </tr>  
			  <tr> 
			    <td width="40%" align="right" class="td-label">Vendor Name </td>
			   <td align="left" width="50%">
				<select id='vendor_name' name='vendor_name' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <?php $vendorArr=array();
                                  if(count($allVenders)==1){
                                      if(preg_match("/COGENT/i",$allVenders[0])) {
                                        $vendorArr1 = array('2'=>'COGENT','16'=>'COGENTBRB','15'=>'COGENTDNC','3'=>'COGENTINBOUND','12'=>'COGENTINTENT','23'=>'COGENTPNS');
                                        }elseif(preg_match("/KOCHAR/i",$allVenders[0])) {
                                            $vendorArr1 = array('21'=>'KOCHARTECH','28'=>'KOCHARTECHAUTO','6'=>'KOCHARTECHCHN','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH');
                                        }elseif(preg_match("/RADIATE/i",$allVenders[0])) {
                                            $vendorArr1 = array('17'=>'RADIATE','24'=>'RADIATEAUTO','1'=>'RADIATEDNC','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
                                        }elseif(preg_match("/VKALP/i",$allVenders[0])) {
                                            $vendorArr1 = array('27'=>'VKALP','10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT');        
                                        }else{
                                            $vendorArr1 = array($allVenders[0]);
                                        }
                                  }else{  
                                      $vendorArr =$allVenders;                                        
                                  }
                                  foreach($vendorArr as $key => $values){                                      
                                        echo '<option value="'.$key.'|'.$values.'">'.$values.'</option>';                                      
                                  }?>
				</select>
			    </td>
			  </tr>
			  <tr>
			    <td width="40%" align="right" class="td-label">Access Level </td>
			      <td align="left" width="50%">
				<select id='emp_level' name='emp_level' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="0">EMP</option>
				  <option value="1">AGENT</option>
				  <option value="2">TL</option>
				  <option value="3">QA</option>
				  <option value="4">MGR</option>
			      </select>
			    </td>
			  </tr> 
                          <tr><td width="40%" align="right" class="td-label">Skill Level </td>
			      <td align="left" width="50%">
				<select id='emp_skill_level' name='emp_skill_level' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="10">Under certification (50 worked leads only)</option>
				  <option value="20">Certification done, training payment pending and new contract</option>
				  <option value="25">Certification done, training payment pending and old contract</option>
				  <option value="30">Training payment done</option>
			      </select>
			    </td>
			  </tr>
                           <tr>
			    <td width="40%" align="right" class="td-label">Shift Time </td>
			      <td align="left" width="50%">
				
                                  <?php 
                                  echo '<select id="st1" name="st1" style="width:50px;height:25px">';
                                  for($i=0;$i<24;$i++){
                                      echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
                                  echo ' </select>';
                                  
                                  echo '<select id="st2" name="st2" style="width:50px;height:25px">';
                                  for($i=0;$i<24;$i++){
                                      echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
                                  echo ' </select>';
				  ?>
			    </td>
			  </tr> 
                           <tr>
			    <td width="40%" align="right" class="td-label">Vendor Emp Id</td>
			      <td align="left" width="50%">
				<input type="text" id='vendor_emp_id' value="" name='vendor_emp_id' style="width:83%;height:25px">
			    </td>
			  </tr> 
			  <tr>
			    <td align="center" colspan="4" style="text-align:center;padding-top:20px">
                                <input type="hidden" value="" name="certification_date" value='' id="certification_date">
			      <input type="button" value="Add Agent" id='add_agent' name='add_agent' onclick='checkFields();'>
			    </td>
			  </tr>
			</tbody>
		      </table>
		    </form> 
		    <?php } ?>
		  </div>

		<div style="width:35%; display:inline-block;  margin:10px 0px 0px 10px; ">
		<form action="/index.php?r=admin_eto/Addvendor/vendorleapmis&mid=3443" method="post" name="updateVendorLoginAccess" id="updateVendorLoginAccess">
		      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
			<tbody>
			  <tr>
			    <td width="40%" align="right" class="td-label">Emp Id </td>
			    <td align="left" width="50%" valign="top">
			      <input style="width:80%;height:25px" name="emp_id" id="emp_id_updt">
			      <img src="/images/srch.jpg" style="vertical-align:middle; margin-left:4px;cursor:pointer;" onclick="empDetails('emp_id_updt');" title="Search Employee">
			    </td>
			  </tr>  
			  <tr> 
			    <td width="40%" align="right" class="td-label">Employee Name </td>
			   <td align="left" width="50%">
				 <input style="width:80%;height:25px" name="emp_name" id="emp_name_updt" disabled="true">
			    </td>
			  </tr>
			  <tr>
			    <td width="40%" align="right" class="td-label">Email </td>
			      <td align="left" width="50%">
				 <input style="width:80%;height:25px" name="emp_email" id="emp_email_updt" disabled="true">
			    </td>
			  </tr> 
               		<tr> 
			    <td width="40%" align="right" class="td-label">Vendor Name </td>
			   <td align="left" width="50%">
				<select name="vendor_name" id="vendor_name_updt" style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <?php foreach($allVenders as $key => $values)
				     echo '<option value="'.$key.'|'.$values.'">'.$values.'</option>';
				  ?>
				  </select>
			    </td>
			  </tr>
			  <tr>
			    <td width="40%" align="right" class="td-label">Access Level </td>
			      <td align="left" width="50%">
				<select name="emp_level" id="emp_level_updt" style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="0">EMP</option>
				  <option value="1">AGENT</option>
				  <option value="2">TL</option>
				  <option value="3">QA</option>
				  <option value="4">MGR</option>
			      </select>
			    </td>
			  </tr>
                            <tr>
			    <td width="40%" align="right" class="td-label">Skill Level </td>
			      <td align="left" width="50%">
                          <select name='emp_skill_level' id='emp_skill_level_updt' style="width:83%;height:25px">
				  <option value="">--SELECT--</option>
				  <option value="10">Under certification (50 worked leads only)</option>
				  <option value="20">Certification done, training payment pending and new contract</option>
				  <option value="25">Certification done, training payment pending and old contract</option>
				  <option value="30">Training payment done</option>
			      </select></td>
			  </tr>
                           <tr>
			    <td width="40%" align="right" class="td-label">Shift Time </td>
			      <td align="left" width="50%">
				
                                  <?php 
                                  echo '<select id="st1" name="st1" style="width:50px;height:25px">';
                                  for($i=0;$i<24;$i++){
                                      echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
                                  echo ' </select>';
                                  
                                  echo '<select id="st2" name="st2" style="width:50px;height:25px">';
                                  for($i=0;$i<24;$i++){
                                      echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
                                  echo ' </select>';
				  ?>
			    </td>
			  </tr> 
                           <tr>
			    <td width="40%" align="right" class="td-label">Vendor Emp Id</td>
			      <td align="left" width="50%">
				<input type="text" id='vendor_emp_id' value="" name='vendor_emp_id' style="width:83%;height:25px">
			    </td>
			  </tr> 
			  <tr>
			    <td width="40%" align="right" class="td-label">Extension Number</td>
			      <td align="left" width="50%">
				<input type="text" id='extension_no' value="" name='extension_no' style="width:83%;height:25px">
			    </td>
			  </tr> 
			  <tr>
			    <td width="40%" align="right" class="td-label">Is Working</td>
			      <td align="left" width="50%">
			      	<input type="checkbox" name="is_working" id="is_working" value="1" onclick="changeVal();">
			     </td>
			  </tr>
                          <input type="hidden" value="" name="certification_date" value='' id="certification_date">
              <input type="hidden" value="1" name="isUpdate" id="isUpdate">
			  <tr><td>&nbsp;</td>
			    <td align="left" style="text-align:center;padding-top:20px" class="td-label">
			      <input type="button" value="Update" name="update" id="update" onclick='checkUpdateFields();'>
			    </td>
			  </tr>
			</tbody>
		      </table>
		    </form></div>
			<div style="clear:both"></div>
	      </div>
	  </div>
      </body>
   </html>
