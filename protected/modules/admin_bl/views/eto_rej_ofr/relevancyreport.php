<!DOCTYPE html>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<?php 
$request = Yii::app()->request;
$currentDate = date("d-m-Y", strtotime(' -1 day'));
$start_date=$start_date1= $request->getParam('start_date','');
$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
$end_date=$end_date1= $request->getParam('end_date','');
$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
$this->pageTitle=Yii::app()->name . ' - Relevancy Report';   


?>
<html>
  <head>

  <script>
  
  function validate(arg)
	{
		var start=new Date(document.Report.start_date.value);
		if(document.Report.start_date.value =='' || document.Report.end_date.value =='')
		{ 
		alert("Kindly Select Start and End Date");
			return false;
		}
		
		var end=new Date(document.Report.end_date.value);
		var timeDiff = end.getTime() - start.getTime();
		var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

		if(diffDays>30)
		{ 
		alert("Kindly Select Dates In Span Of 30 Days Only");
					return false;
		}
		else if(diffDays<0)
		{
			alert("End Date Cant Be Smaller Than Start Date");
			return false;
		}
}
$(document).ready(function() {
    $('#example').DataTable( {
        "order": [[ 0, "asc" ]],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );
} );
  </script>
  <STYLE>
table {width:100%;padding:0px;font-family:arial;font-size:12px;color:#414141;border-collapse:collapse;background-color:white;}
td{height:21px;font-family:arial;font-size:12px;color:#000000;padding:4px 5px 4px 5px;}
td b.rd{color:#b40000;font-size:12px}
td b.textcolor{color:#333399;font-size:12px}
.table-border td{border:1px solid #BEDAFF;}
.button,input[type="button"],input[type="reset"],input[type="submit"] {  cursor: pointer; -webkit-appearance: button;background-color: #009DCC;font-weight:bold; height: 25px;width: auto; border: 1px solid #CCCCCC;color: #FFFFFF;}
      </style>
  </head>  
 <BODY><form method="POST" name="Report" id="Report" style="margin:5px 0;">
<table width="90%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"  align="center">     	
<TR><td  colspan="4" style="font-family: arial; font-size: 16px; font-weight: bold; border:1px solid #d2e2e8;color:#000099;background-color:#F0F9FF;" align="CENTER">
        Buy Leads Marked as Not Interested/ Not Relevant
</td></TR><tr>
    <td style="font-size:14px;"><strong>Enter Date :</strong><br>(Upto 30 days)</td>
<td style="font-size:14px" colspan=2>
<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.Report.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.Report.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.Report.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.Report.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
<?php
echo '</td>';
$custtype='';
 if(isset($_REQUEST['Submit']))
 {
 $custtype=$_REQUEST['custtype'];
 }else{
    $custtype="Paid"; 
 }
$custtype_arr = array("Paid" =>"Paid","Free" => "Free",""=>"All",'Catalog'=>'Catalog','TSCatalog'=>'TSCatalog','Star'=>'Star','Leader'=>'Leader');
echo '
<td style="font-size:14px;font-family:arial;padding-left:6px;"><strong>Customer Type</strong>&nbsp;
 <select name="custtype" id="custtype">';
 
foreach($custtype_arr as $key => $val){
	if ($key==$custtype)
	{
		echo '<option value="'.$key.'" selected>'.$val.'</option>';
	}else
	{
		echo '<option value="'.$key.'" >'.$val.'</option>';
	}
}
echo '</select></td></tr>
<tr>
<td style="font-size:14px;font-family:arial;">
<strong>Select Reason</strong></td>
<td style="font-size:14px;font-family:arial;padding-left:6px;">';
$reason_value='';
 if(isset($_REQUEST['Submit']))
  {
  $reason_value=$_REQUEST['reason'];
  }
 $reason_arr= array('1'=>'Product not relevant','5'=>'Location issue','11'=>'Retail leads','3'=>'Insufficient description','7'=>'Any other','All'=>'ALL');
echo '<select name="reason" id="reason">';
foreach($reason_arr as $key => $val){
	if($key == $reason_value)
	{
		echo '<option value="'.$key.'" selected>'.$val.'</option>';
	}else
	{
		echo '<option value="'.$key.'"> '.$val.'</option>';
	}
}
 echo '</select>';
	
 $comment='';
 if(isset($_REQUEST['Submit']))
 {
 $comment=$_REQUEST['comment'];
 }
  $comment1 = array("1" =>"With Comment","2" => "Without Comment");
 echo '</td>
<td style="font-size:14px;font-family:arial;padding-left:6px;"><strong>Comment</strong></td>
<td style="font-size:14px;font-family:arial;padding-left:6px;">
 <select name="comment" id="comment"><option value="ALL" selected>Both</option>';
 
foreach($comment1 as $key => $val){
	if ($key==$comment)
	{
		echo '<option value="'.$key.'" selected>'.$val.'</option>';
	}else
	{
		echo '<option value="'.$key.'" >'.$val.'</option>';
	}
}
echo '</select></td></tr>
<tr>
<td style="font-size:14px" align="center" colspan="4">
<input type="hidden" name="relevant" value="1"/><input type="Submit" align="center" value="Submit" id="Submit" name="Submit" ONCLICK="return validate(1)" />
</td>
</tr>
<tr style="display:none;">
<td style="font-size:14px"><strong>Credits Available: </strong></td> 
<td style="font-size:14px"><input type="radio" name="r3" id="r5" value=">=1000" checked>&nbsp;&nbsp;>=1000</td>
<td style="font-size:14px" colspan="3"><input type="radio" name="r3" id="r6" value="<1000"';
if(isset($_REQUEST["r3"]) && $_REQUEST["r3"] == '<1000')
 {
 echo 'checked';
 }
echo '>&nbsp;&nbsp;<1000</td>
</tr>';
echo '
</table>
</form>';
if(isset($_REQUEST['Submit']))
{	
$var = '';
$var1 = '';
	echo '<table id="example" class="display" style="width:100%">
        <thead><tr><th>SN</th><th>Gl Id</th>
		<th>Company Name</th>
		<th>Customer Type</th>
		<th>Lead Purchased</th>
		<th>Lead Rejected Till Date</th>
		<th>Lead rejected in the Duration</th>
                <th>Negative MCAT rejected in the Duration</th>
		</tr></thead>';
		$cnt = 0;
		$row = 1;
            $currentDate = date("d-m-Y");
            $end_date1 = strtoupper(date("d-M-Y",strtotime($currentDate)));
            $start_date1 = strtoupper(date('d-M-Y',strtotime("-29 days")));

		if($sth1){
		while($rec = $sth1->read())
		{
			$rec=array_change_key_case($rec, CASE_UPPER);
			$cnt++;
			
			if(isset($rec['GLUSR_USR_COMPANYNAME']))
			{
			$rec['GLUSR_USR_COMPANYNAME']=$rec['GLUSR_USR_COMPANYNAME'];
			}
			else{$rec['GLUSR_USR_COMPANYNAME'] = '';}
			
			if(isset($rec['GLUSR_USR_CUSTTYPE_NAME']))
			{
			$rec['GLUSR_USR_CUSTTYPE_NAME']=$rec['GLUSR_USR_CUSTTYPE_NAME'];
			}
			else
			{$rec['GLUSR_USR_CUSTTYPE_NAME'] = '';}
			if($row==1)
			{ 
			$var = "Gl Id  , Company Name, Customer Type ,Lead Purchased ,Lead Rejected Till Date , Lead rejected in the Duration , Negative Mcat Lead rejected in the Duration";
			
                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                        }else{
                            fwrite($fp,"$var\n");
                        }

			}
			echo '
			<TR  bgcolor="#ffffff" ><TD ALIGN="CENTER">'.$cnt.'</td>
			<TD ALIGN="CENTER"><a href="index.php?r=admin_bl/Eto_rej_ofr/Index&end_date='.$end_date1.'&start_date='.$start_date1.'&mid=3439&fromdays=365&genmis=Generate&report='.$rec['FK_GLUSR_USR_ID'].'&detail=1" target="'.$rec['FK_GLUSR_USR_ID'].':GLusr_detail">'.$rec['FK_GLUSR_USR_ID'].'</a></TD>
			<TD ALIGN="LEFT">'.$rec['GLUSR_USR_COMPANYNAME'].'</TD>
			<TD ALIGN="LEFT">'.$rec['GLUSR_USR_CUSTTYPE_NAME'].'</TD>
			<TD ALIGN="CENTER">'.$rec['LEAD_PUR'].'</td>
			<TD ALIGN="CENTER">'.$rec['LEAD_REJ_TILLDATE'].'</TD>
			<TD ALIGN="CENTER">'.$rec['LEAD_REJ_IN_DUR'].'</TD>
                        <td align="center">'.$rec['LEAD_REJ_IN_DUR_NEG_MCAT'].'</TD>
			</TR>';
			$GLUSR_USR_COMPANYNAME=$rec['GLUSR_USR_COMPANYNAME'];
			
			$var1 = $rec['FK_GLUSR_USR_ID'].','.str_replace(',', ' ', $GLUSR_USR_COMPANYNAME).','.$rec['GLUSR_USR_CUSTTYPE_NAME'].','.$rec['LEAD_PUR'].','.$rec['LEAD_REJ_TILLDATE'].','. $rec['LEAD_REJ_IN_DUR'];

                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                        }else{
                            fwrite($fp,"$var1\n");
                        }
			
			$row++;
		}         
		}      

		echo '<div style="font-size:15px;font-family:arial" align="CENTER">'.$cnt.' Records Found</div>';
		echo '</TABLE>';
	if($row > 1)
	{
		echo '</table></div><div align="center"><A HREF="/email-notification/'.$filename.'" style="font-family:arial;font-size:16px;font-weight:bold">CLICK HERE TO DOWNLOAD ALL RECORDS</A></div></body></html>';
	}
	else
	{
		echo '<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
	}

}
echo '</BODY></HTML>';
?>