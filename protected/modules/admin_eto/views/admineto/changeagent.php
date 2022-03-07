<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<link href="/css/report.css" rel="stylesheet" type="text/css">
<?php 
$empId = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
if(isset($succMsg) && !empty($succMsg)){
        echo $succMsg;		
}
 $totalRecords=0;
?>
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="center">
	<form name="showAgentForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;" ACTION="/index.php?r=admin_eto/Addvendor/Changeagent&mid=3443">
	<TR>
	<td width="100%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 13px;color: #333399;" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Change Associate Screen</b>
	</td>
	</TR>
	<tr>
	<td class="intd" width="45%" style="text-align:right;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;&nbsp;Partner: </td>
	<td class="intd" width="10%" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;	
	<select name="vendor" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
	<?php 
         if(count($vendorArr)==1){
                              $vendor_name=$vendorArr[0];
                               if(preg_match("/COGENT/i",$vendor_name)) {
                                $vendorArr = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                                }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                                    $vendorArr = array('KOCHARTECHCHN','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHAUTO');
                                }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                                    $vendorArr = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK');    
                                }else{
                                    $vendorArr = array($vendor_name);
                                }
                            }else{
                                    $vendorArr = $vendorArr;
                            }
        foreach($vendorArr as $k)
	{
		if($vendor == $k)
			{
				echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
			}
			else
			{
				echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
			}
	}?>
	</td>
<td class="intd" width="45%" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;
<input name="agentstatus" value="All" type="RADIO" <?php if($agentstatus=='All'){ echo 'checked'; } ?> >&nbsp;All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="agentstatus" value="Active" type="RADIO" <?php if($agentstatus=='Active'){ echo 'checked'; } ?> >&nbsp;Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="agentstatus" value="Inactive" type="RADIO" <?php if($agentstatus=='Inactive'){ echo 'checked'; } ?>>&nbsp;Inactive&nbsp;&nbsp;&nbsp;
</td></tr>


		<tr>
		<td colspan="3" align="center"  style="text-align:center;font-family: arial;font-size:12px;background-color:#eeffff">
		<input type="hidden" name="action" value="ch">
		<input type="submit" name="Submit1" VALUE="Show">
		</td>
		</tr>
		</form>
	</table>
	
	<?php if($action == 'ch'){
		$tlhash = $result['tlhash']; 
                $qahash = $result['qahash']; 
		$flagemphash = $result['flagemphash']; 
		$recArr = $result['rec']; 
                $rec_vendor_employee_id=isset($rec['VENDOR_EMPLOYEE_ID'])?$rec['VENDOR_EMPLOYEE_ID']:'';
		$rec_shift_time=isset($rec['SHIFT_TIME'])?$rec['SHIFT_TIME']:'';
		?>
		<script language="javascript" src="/js/calendar.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
	<script language="JavaScript">

	function checkFields(res){
			
	    var vendor_emp_id = $("#vendor_emp_id"+res).val().trim();
		if(vendor_emp_id!='' && !vendor_emp_id.match(/^[0-9a-zA-Z]+$/) ){
			alert("Invalid Vendor Emp Id. Only Alphanumeric values are allowed.");
		$("#vendor_emp_id"+res).focus();
		return false;
	    } 
		}
	var empArray = new Array();
	var empArrayForTLName = new Array();
	var empArrayForJoinDate = new Array();
	$(document).ready(
				function(){
							emptyArray();
							$( "input.intd1:text" ).focus( function(){$(this).removeAttr('readonly')} );
						}
					);
	$(document).load(
						function(){emptyArray();}
					);
	function fillArray(inputid){
	empArray.push(inputid);
	}
	
	function emptyArray()
	{
	empArray.length = 0;
	
	}
	function saveEmpId(empId)
	{
		var saveDataArr = [];
		empArray.length = 0;
	}
	</script>
 	<BR>
	<?php 
       
        if(isset($recArr))
	     { 
	    $totalRecords=!empty($recArr[0]['RESULT_COUNT']) ? $recArr[0]['RESULT_COUNT'] : 0;
	echo '<div style="text-align:center;font-family: arial;font-size: 12px;color: #333399"><b>Total '.$totalRecords.' Record found</b>';
	
	        $serverName = $_SERVER['SERVER_NAME'];	
		$start = $result['start'];		
		$end = $result['end'];
		$nextStart = $end+1;
		if($totalRecords <= 200){
			$nextEnd = $totalRecords;		
		} 
		else{
			$nextEnd = $end+100;		
		}
		$prevStart = $start-100; $prevEnd = $start-1;
		$buttons = '';
		$cp=1;
                if(isset($_REQUEST['start']) && $_REQUEST['start'] > 100){
                    $cp = ($_REQUEST['start']-1)/100;
                    $cp = $cp+1;
                }  
	
	
			if($totalRecords > 100){
				echo '<td align="center" width= "50%">'; 
				if($start > 1){
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start=1&end=100&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">&nbsp;&nbsp;&nbsp;&nbsp;First &nbsp;&nbsp;&nbsp;&nbsp;</a>';
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start='.$prevStart.'&end='.$prevEnd.'&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">  Previous &nbsp;&nbsp;&nbsp;&nbsp;</a>';		
				}
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;border: 1px solid #b6b6b6;color: #474747;padding: 6px 9px">'.$cp.'</span>';
				if($end < $totalRecords){
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start='.$nextStart.'&end='.$nextEnd.'&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">&nbsp;&nbsp;&nbsp;&nbsp;Next  &nbsp;&nbsp;&nbsp;&nbsp;</a>';		
				}
				if($end < $totalRecords){
				      $remainder = ($totalRecords % 100);
				      $lastStart = ($totalRecords - $remainder) + 1;
                                      $total_pg=ceil($totalRecords/100);
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start='.$lastStart.'&end='.$totalRecords.'&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">Last [Total-'.$total_pg.']</a>';		
				}
				echo '</td></div>';
			}	
	
	
	
	
	} ?>
	<BR>
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%" align="center">
	
	<TR>
	<td  width="20px" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>S.No.</b></td>
	<td  width="7%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>IndiaMART Emp Id</b></td>
	<td  width="7%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>IndiaMART Emp Name</b></td>
	<td  width="10%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>Associate Name</b></td>
	<td  width="60px" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>On Floor Date</b></td>
	<td  width="10%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>TL</b></td>
        <td  width="10%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>QA</b></td>
	<td  width="10%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b> Emp for flagged Lead</b></td>	
	<td  width="8%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>Dialer Setting</b></td>
        <td  colspan="2" width="10%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b> Shift time</b></td>	
        <td  width="10%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b> Vendor Emp Id</b></td>	
        <td  width="8%" bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;color: #333399" ><b>&nbsp;</b></td>
	</TR>
        <tr><td bgcolor="#dff8ff" colspan="9"></td><td style="text-align:center;font-family: arial;font-size: 12px;color: #333399" bgcolor="#dff8ff">From</td><td style="text-align:center;font-family: arial;font-size: 12px;color: #333399" bgcolor="#dff8ff">To</td><td bgcolor="#dff8ff" colspan="2"></td></tr>
 <?php 
 $i=1;
 $start1=isset($_REQUEST['start']) ? $_REQUEST['start'] : 1; 
 $mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
 $Sno=1;
	foreach($recArr as $rec)
        {
        
       
	echo '<FORM name="editAgentForm'.$rec['ETO_LEAP_EMP_ID'].'" METHOD="post" action="/index.php?r=admin_eto/Addvendor/Changeagent&action=save&mid=3443" STYLE="margin-top:0;margin-bottom:0;" onsubmit=saveEmpId('.$rec['ETO_LEAP_EMP_ID'].');>';
	echo '<TR>
	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >'.$Sno.'</td>
	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >'.$rec['ETO_LEAP_EMP_ID'].'</td>
	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >'.$rec['ETO_LEAP_EMP_NAME'].'</td>
	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >
	<input type="text" id="'.$rec['ETO_LEAP_EMP_ID'].'" name="'.$rec['ETO_LEAP_EMP_ID'].'" value="'.$rec['ETO_LEAP_AGENT_NAME'].'" onchange=fillArray("'.$rec['ETO_LEAP_EMP_ID'].'") readonly="readonly" class="intd1"></td>

	<td class="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >
	<input width="60px" type="text" id="joindate'.$rec['ETO_LEAP_EMP_ID'].'" name="joindate'.$rec['ETO_LEAP_EMP_ID'].'" onfocus="displayCalendar(document.editAgentForm'.$rec['ETO_LEAP_EMP_ID'].'.joindate'.$rec['ETO_LEAP_EMP_ID'].',\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.editAgentForm.joindate'.$rec['ETO_LEAP_EMP_ID'].',\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" value="'.$rec['ETO_LEAP_AGENT_JOINING_DATE'].'" onchange=fillArray("'.$rec['ETO_LEAP_EMP_ID'].'") readonly="readonly"></td>
	<td width="7%"  class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >
	<select id="tl'.$rec['ETO_LEAP_EMP_ID'].'" name="tl'.$rec['ETO_LEAP_EMP_ID'].'"  onchange=fillArray("'.$rec['ETO_LEAP_EMP_ID'].'")  class="intd1" >'; 
		foreach($tlhash as $tlid=>$tlidVal)
		{
			if($tlid == $rec['ETO_LEAP_TL_ID'])
			{
				echo '<OPTION VALUE="'.$tlid.'" SELECTED="SELECTED" >'.$tlidVal.'</OPTION>';
			}
			else
			{
				echo '<OPTION VALUE="'.$tlid.'"  >'.$tlidVal.'</OPTION>'; 
			}
		}
		
	echo '</select></td> 
        <td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" ><select id="qa'.$rec['ETO_LEAP_EMP_ID'].'" name="qa'.$rec['ETO_LEAP_EMP_ID'].'"  onchange=fillArray("'.$rec['ETO_LEAP_EMP_ID'].'")  class="intd1" >'; 
                echo '<OPTION VALUE="0"'; 
		if($rec['ETO_LEAP_QA_ID'] == ''  || $rec['ETO_LEAP_QA_ID'] == 0)
		{
			echo 'SELECTED="SELECTED"'; 
		}
		echo '>--NONE--</OPTION>'; 
		foreach($qahash as $qaid=>$qaidVal)
		{
			if($qaid == $rec['ETO_LEAP_QA_ID'])
			{
				echo '<OPTION VALUE="'.$qaid.'" SELECTED="SELECTED" >'.$qaidVal.'</OPTION>';
			}
			else
			{
				echo '<OPTION VALUE="'.$qaid.'"  >'.$qaidVal.'</OPTION>'; 
			}
		}
		
	echo '</select></td>     

	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >
		<select id="flagemp'.$rec['ETO_LEAP_EMP_ID'].'" name="flagemp'.$rec['ETO_LEAP_EMP_ID'].'" onchange=fillArray("'.$rec['ETO_LEAP_EMP_ID'].'")  class="intd1" >
		
		<OPTION VALUE=""'; 
		if($rec['ETO_LEAP_FLAG_EMP_ID'] == '')
		{
			echo 'SELECTED="SELECTED"'; 
		}
		echo '>--NONE--</OPTION>'; 

		foreach($flagemphash as $flagempid => $flagempidVal)
		{
			if($flagempid == $rec['ETO_LEAP_FLAG_EMP_ID'])
			{
				echo '<OPTION VALUE="'.$flagempid.'" SELECTED="SELECTED" >'.$flagempidVal.'</OPTION>'; 
			}
			else
			{
				echo '<OPTION VALUE="'.$flagempid.'"  >'.$flagempidVal.'</OPTION>'; 
			}
		}
	echo '</select></td>';	
        $sel_dialer=0;
        echo '<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >
	<select id="pool'.$rec['ETO_LEAP_EMP_ID'].'" name ="pool'.$rec['ETO_LEAP_EMP_ID'].'">
	<OPTION value="">--NONE--</OPTION>';
        
        if(isset($rec['FK_LEAP_LOGIN_STATUS_ID']) && $rec['FK_LEAP_LOGIN_STATUS_ID']==1)
        {
             echo '<OPTION value="1" SELECTED="SELECTED">Must Call</OPTION>';
             $sel_dialer=1;
        }else{
             echo '<OPTION value="1">Must Call</OPTION>';
        }
        if(isset($rec['FK_LEAP_LOGIN_STATUS_ID']) && $rec['FK_LEAP_LOGIN_STATUS_ID']==2)
        {
             echo '<OPTION value="2" SELECTED="SELECTED">DNC</OPTION>';
             $sel_dialer=1;
        }else{
             echo '<OPTION value="2">DNC</OPTION>';
        } 
        
        if(isset($rec['FK_LEAP_LOGIN_STATUS_ID']) && $rec['FK_LEAP_LOGIN_STATUS_ID']==-1)
        {  
          echo '<OPTION value="-1" SELECTED="SELECTED">Predictive</OPTION>';
          $sel_dialer=1;
        }
        else
        {         
          echo '<OPTION value="-1">Predictive</OPTION>';
        }
        if($sel_dialer==0)
        {
             echo '<OPTION value="-999" SELECTED>Others</OPTION>';
        }else{
             echo '<OPTION value="-999">Others</OPTION>';
        }
         
       echo '</SELECT></TD>       
	<td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" >
        <select id="st1'.$rec['ETO_LEAP_EMP_ID'].'" name="st1'.$rec['ETO_LEAP_EMP_ID'].'" style="width:50px;height:25px">';
        $shift_time = isset($rec['SHIFT_TIME'])?$rec['SHIFT_TIME']:'';
        $vendor_emp_id = isset($rec['VENDOR_EMPLOYEE_ID'])?$rec['VENDOR_EMPLOYEE_ID']:'';
        $arrshift_time=array();
        $arrshift_time=explode('-', $shift_time);

        $empDet['st1'] = isset($arrshift_time[0])?$arrshift_time[0]:'';
        $empDet['st2'] = isset($arrshift_time[1])?$arrshift_time[1]:'';
                                  for($in=0;$in<24;$in++){
                                      if($empDet['st1']==$in){
                                          echo '<option value="'.$in.'" selected>'.$in.'</option>';
                                      }else{
                                          echo '<option value="'.$in.'">'.$in.'</option>';
                                      }
                                      
                                  }
                                  echo ' </select></td>';
                                  
                                  echo '<td style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff" ><select id="st2'.$rec['ETO_LEAP_EMP_ID'].'" name="st2'.$rec['ETO_LEAP_EMP_ID'].'" style="width:50px;height:25px">';
                                  for($in=0;$in<24;$in++){
                                       if($empDet['st2']==$in){
                                          echo '<option value="'.$in.'" selected>'.$in.'</option>';
                                      }else{
                                          echo '<option value="'.$in.'">'.$in.'</option>';
                                      }
                                  }
     echo ' </select></td><td class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff;width:50px" ><input type="text" id="vendor_emp_id'.$rec['ETO_LEAP_EMP_ID'].'" name="vendor_emp_id'.$rec['ETO_LEAP_EMP_ID'].'" value="'.$vendor_emp_id.'" class="intd1"></td>';
    echo '<td bgcolor="#dff8ff" class="intd" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff;">
  <INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Save" onclick="return checkFields('.$rec['ETO_LEAP_EMP_ID'].')"><input type="hidden" name="action" value="save"></td></tr>'; 
  echo '<input type="hidden" name="agentID" id="agentID" value="'.$rec['ETO_LEAP_EMP_ID'].'">
  <input type="hidden" value="'.$vendor.'" name="vendor"><input type="hidden" value="'.$agentstatus.'" name="agentstatus">';
  
  $start=isset($_REQUEST['start']) ? $_REQUEST['start'] : ''; 
  $end=isset($_REQUEST['end']) ? $_REQUEST['end'] : '';
  echo '<input type="hidden" name="start" id="start" value="'.$start.'">
  <input type="hidden" value="'.$end.'" name="end" id="end">';  
  echo '</form>';
  $i++;
  $Sno++;
  if($Sno>100){
      exit;
  }
}
	
	
		?>
	</table> 
<?php	}



	if($totalRecords > 100){
				echo '<br><div style="text-align:center;font-family: arial;font-size: 12px;color: #333399"><table<tr><td align="center" width= "50%">'; 
				if($start > 1){
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start=1&end=100&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">  First &nbsp;&nbsp;&nbsp;&nbsp;</a>';
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start='.$prevStart.'&end='.$prevEnd.'&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">  Previous &nbsp;&nbsp;&nbsp;&nbsp;</a>';		
				}
                                echo '<span style="font-weight:bold;border: 1px solid #b6b6b6;color: #474747;padding: 6px 9px">'.$cp.'</span>';
				if($end < $totalRecords){
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start='.$nextStart.'&end='.$nextEnd.'&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">&nbsp;&nbsp;&nbsp;&nbsp;Next  &nbsp;&nbsp;&nbsp;&nbsp;</a>';		
				}
				if($end < $totalRecords){
				      $remainder = ($totalRecords % 100);
				      $lastStart = ($totalRecords - $remainder) + 1;
                                      $total_pg=ceil($totalRecords/100);
					echo '<a class="pagina" style="text-decoration: none;" href="/index.php?r=admin_eto/Addvendor/Changeagent&action=ch&start='.$lastStart.'&end='.$totalRecords.'&vendor='.$vendor.'&agentstatus='.$agentstatus.'&mid=3443">Last [Total-'.$total_pg.']</a>';		
				}
				echo '</td></tr></table></div>';
			}	
	
	
?>
