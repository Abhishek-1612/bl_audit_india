<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">	
<script type="text/javascript">
</script>
<?php 
        
           if(empty($auditArr['errMsg']))
           {
                echo '<form name="searchform" method="post" action="">
                <div style="height:150px;">
                 <table style="border-collapse: collapse;" border="0" cellpadding="4" cellspacing="0" width="100%" height="100%">
			  
		
		<tr>
		<td  align="center" style="color:#ffffff;" colspan="2" width="100%"  bgcolor="#0195d3"><b>Rebuttal for Audit Id:'.$auditId.'</b></td>
		</tr>
		<tr>
		<td width="10%"><span style="float:left;margin:3px 0px 0px 0px;">Remarks:</span></td>
		<td width="80%"><textarea id="remarks" name="remarks" style="width: 98%; height: 60px; margin-bottom:8px;resize: none; "></textarea></td>
		</tr>
		<tr>
                <td align="center" colspan="2" style="padding:4px;">
                <input type="hidden" name="audit_id1" value="'.$auditId.'">
                <input type="hidden" name="offer_id1" value="'.$OfferId.'">
                <input type="button" name="Raise" value="Raise" onclick="return validate_remark('.$auditId.','.$OfferId.','.$div_id.');">
                <input type="button" name="close" value="close" onclick="return show_alert_off('.$div_id.',2);">
                </td>
                </tr>
		 </table>
		 </div>
                </form>';
                
}
else
{
 echo '<div align="center" class="alrt-headTxt"  style="margin-top:50px;color:red;font-size:14px;"><b>'.$auditArr['errMsg'].'</b>
 <br><br>
 <div align="center"><input type="button" name="close" value="close" onclick="return show_alert_off('.$div_id.',2);"></div></div>
 </div>';
}
                ?>               