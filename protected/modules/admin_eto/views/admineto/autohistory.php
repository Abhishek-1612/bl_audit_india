<?php
if(Yii::app()->session['empid']==3575){
    echo '<pre>';
    print_r($returnResult);
    echo '</pre>';
}
$status=isset($returnResult['status'])?$returnResult['status']:'';
$fk_gl_attribute_id=isset($returnResult['FK_GL_ATTRIBUTE_ID'])?$returnResult['FK_GL_ATTRIBUTE_ID']:'';

if($status!=''){
echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
        <td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Auto Approval History Detail for Offer ID -<font color="red">'.$offerId.'</font><span style="font-family: arial; font-size: 14px; font-weight: bold;float: right;" bgcolor="#eaeaea" height="30">Status:<font color="red">Auto Approved- '.$status.'</font></span><BR></tbody></table>';
}
else{
    echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
        <td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Auto Approval History Detail for Offer ID -<font color="red">'.$offerId.'</font><BR></tbody></table>';
}

if(!empty($returnResult)){
		echo '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	        <tbody>';
                    $returnResult=array_change_key_case($returnResult, CASE_UPPER);	
                   $insert_time=isset($returnResult['GL_PROFILE_ENRICHMENT_DATE'])?$returnResult['GL_PROFILE_ENRICHMENT_DATE']:'';
                   $action_time=isset($returnResult['AUDIT_DATE'])?$returnResult['AUDIT_DATE']:'';
                   $emp_name=isset($returnResult['EMP_NAME'])?$returnResult['EMP_NAME']:'';
                   $emp_id=isset($returnResult['EMP_ID'])?$returnResult['EMP_ID']:'';
                   $auditby=isset($returnResult['GL_PROFILE_AUDIT_BY'])?$returnResult['GL_PROFILE_AUDIT_BY']:'';
                   $screen=isset($returnResult['SCREEN_NAME'])?$returnResult['SCREEN_NAME']:'';
                   $status=isset($returnResult['STATUS'])?$returnResult['STATUS']:'';
                   $changes=isset($returnResult['CHANGE_MADE'])?$returnResult['CHANGE_MADE']:'';
if($fk_gl_attribute_id==227){       
         echo '<tr><td><BR></td></tr>
            <tr>
          <td class="admintext1" align="left"> <B style="color:red;">(Review Not Required)</B></td></tr>';        
        echo '<tr><td><BR></td></tr>
        <tr>
        <td class="admintext1" align="left"><B style="color:red;">Automatic Approved</B> On '.$insert_time.' with (Emp ID -14)';
        echo '</td></tr>';
}else{
        if($auditby==-1){
            echo '<tr><td><BR></td></tr>
                    <tr>
                  <td class="admintext1" align="left"> <B style="color:red;">'.$status.'</B> On '.$action_time.'</B></td></tr>';
        }else{
            echo '<tr><td><BR></td></tr>
              <tr>
			<td class="admintext1" align="left"> <B style="color:red;">'.$status.'</B> On '.$action_time.' by Emp ID - '.$emp_id.' using ['.$screen.'] ('.$changes.')';
            echo '</B></td></tr>';
         }
        echo '<tr><td><BR></td></tr>
        <tr>
        <td class="admintext1" align="left"><B style="color:red;">Approved By Auto Agent</B> On '.$action_time.' with (Emp ID -11)';
        echo '</td></tr>';
}

        echo '</tbody></table>';
}
            else{
                echo '<br><table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
                        <td class="admintext1" align="center"><B style="color:Black;">No Auto Approval History for This Offer</B></td></tbody></table>';
            }
























?>
