<?php 
class STOUniqueReport extends CFormModel
{
	public function show_results ($cookie_mid,$data,$dbh,$model)
	{		
		$my_group = (isset($data['my_group'])) ? $data['my_group'] : '';
		$emp_name = (isset($data['emp_name'])) ? $data['emp_name'] : '';
		$emp_id = (isset($data['emp_id'])) ? $data['emp_id'] : '';
		$from_date = (isset($data['from_date'])) ? $data['from_date'] : '';
		$to_date = (isset($data['to_date'])) ? $data['to_date'] : '';
		$total = 0;
		$sql = '';
		$sth = '';
		$h = array();
// 		my ($cnt1, $cnt2, $cnt3, $cnt4, $cnt4, $cnt5, $cnt5plus) = (0) x 6;
		$cnt1 = $cnt2 = $cnt3 = $cnt4 = $cnt4 = $cnt5 = $cnt5plus = 0;
		
		if ($my_group) 
		{
			$sql = "SELECT 
						COUNT( CASE WHEN CNT=1 THEN 1 END) CNT_1,
						COUNT( CASE WHEN CNT=2 THEN 1 END) CNT_2,
						COUNT( CASE WHEN CNT=3 THEN 1 END) CNT_3,
						COUNT( CASE WHEN CNT=4 THEN 1 END) CNT_4,
						COUNT( CASE WHEN CNT=5 THEN 1 END) CNT_5,
						COUNT( CASE WHEN CNT>5 THEN 1 END) CNT_5_PLUS,
						ETO_OFR_APPROV_BY
						FROM
							(SELECT COUNT(1) CNT,
								EMPLOYEENAME ETO_OFR_APPROV_BY,
								FK_ETO_OFR_ID ofr_id
							FROM ETO_OFR_HIST_DETAIL,
								ETO_OFR_HIST_MAIN,
								EMPLOYEE
							WHERE 
								ETO_OFR_HIST_OLD_VAL IN ('W','M')
								AND ETO_OFR_HIST_NEW_VAL = 'A'
								AND FK_ETO_OFR_HIST_ID = ETO_OFR_HIST_ID
								AND ETO_OFR_HIST_EMP_ID in (20102,20103,20105,20107,20114,20115,20116,27196,27197)
								AND ETO_OFR_HIST_EMP_ID         =EMPLOYEEID
								AND MANAGERID                 = :M_ID
								AND WORKING                   =-1
								AND TRUNC(ETO_OFR_HIST_DATE) >= TRUNC(to_date(:FROM_DATE, 'DD-MM-YYYY'))
								AND TRUNC(ETO_OFR_HIST_DATE)   <= TRUNC(to_date(:TO_DATE, 'DD-MM-YYYY'))
							GROUP BY EMPLOYEENAME,
								FK_ETO_OFR_ID
							)
						GROUP BY ETO_OFR_APPROV_BY";
						
			if ($from_date)
			{
				$bind[':FROM_DATE'] = $from_date;
			}
			if ($to_date)
			{
				$bind[':TO_DATE'] = $to_date;
			}
			if ($emp_id)
			{
				$bind[':M_ID'] = $emp_id;
			}
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
		
	
			print '<table cellpadding="2" width="98%" class="table-striped table-border">
					<TR>
					<TD><b>Vendor</b></TD>
					<TD><b>Operator</b></TD>
					<TD><b>Count 1</b></TD>
					<TD><b>Count 2</b></TD>
					<TD><b>Count 3</b></TD>
					<TD><b>Count 4</b></TD>
					<TD><b>Count 5</b></TD>
					<TD><b>Count 5+</b></TD>
					</TR>';
			while($h = $sth->read()) 
			{
				$ETO_OFR_APPROV_BY = $h['ETO_OFR_APPROV_BY'];
				$CNT_1 = $h['CNT_1'];
				$CNT_2 = $h['CNT_2'];
				$CNT_3 = $h['CNT_3'];
				$CNT_4 = $h['CNT_4'];
				$CNT_5 = $h['CNT_5'];
				$CNT_1_PLUS = $h['CNT_5_PLUS'];
				print <<<T
<TR><TD>$emp_name</TD><TD>$ETO_OFR_APPROV_BY</TD><TD>$CNT_1</TD>
				<TD>$CNT_2</TD><TD>$CNT_3</TD><TD>$CNT_4</TD><TD>$CNT_5</TD>
				<TD>$CNT_1_PLUS</TD></TR>
T;
				$cnt1 += $CNT_1;
				$cnt2 += $CNT_2;
				$cnt3 += $CNT_3;
				$cnt4 += $CNT_4;
				$cnt5 += $CNT_5;
				$cnt5plus += $CNT_1_PLUS;
			}
			print "<TR><TD colspan='2'><b>Total</b></TD> <TD><b>$cnt1</b></TD> <TD><b>$cnt2</b></TD> <TD><b>$cnt3</b></TD> <TD><b>$cnt4</b></TD> <TD><b>$cnt5</b></TD> <TD><b>$cnt5plus</b></TD></TR>";
		}
		else 
		{
			$sql = "SELECT NUM,
				COUNT(NUM) CNT
			FROM
			(
				SELECT FK_ETO_OFR_ID,
					COUNT(FK_ETO_OFR_ID) AS NUM
				FROM ETO_OFR_HIST_DETAIL,
					ETO_OFR_HIST_MAIN
				WHERE TRUNC(ETO_OFR_HIST_DATE) >= TRUNC(to_date(:FROM_DATE, 'DD-MM-YYYY'))
					AND TRUNC(ETO_OFR_HIST_DATE)   <= TRUNC(to_date(:TO_DATE, 'DD-MM-YYYY'))
					AND ETO_OFR_HIST_OLD_VAL IN ('W','M')
					AND ETO_OFR_HIST_NEW_VAL = 'A'
					AND FK_ETO_OFR_HIST_ID = ETO_OFR_HIST_ID
					AND ETO_OFR_HIST_EMP_ID in (20102,20103,20105,20107,20114,20115,20116,27196,27197) ";
			if ($emp_id)
			{		
				$sql .= "AND ETO_OFR_APPROV_BY           = :EMP_ID ";
			}
					
			$sql .= "GROUP BY FK_ETO_OFR_ID
					ORDER BY NUM DESC
				)
				GROUP BY NUM
				ORDER BY NUM";
			if ($emp_id )
			{
				$bind[':EMP_ID'] = $emp_id;
				if ($from_date)
				{
					$bind[':FROM_DATE'] = $from_date;
				}
				if ($to_date)
				{
					$bind[':TO_DATE'] = $to_date;
				}
				$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
			}
			else 
			{
				
				if ($from_date)
				{
					$bind[':FROM_DATE'] = $from_date;
				}
				if ($to_date)
				{
					$bind[':TO_DATE'] = $to_date;
				}
				$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
			}
			
			print <<<T
<table cellpadding="2" width="98%" class="table-striped table-border">
			<TR><TD><b>Num of Occurence 
T;

			if ($emp_id)
			{
				print " for $emp_name ($emp_id)";
			}
			print '</b></TD><TD><b>Count</b></TD></TR>';
			while($h = $sth->read())
			{
				$NUM = $h['NUM'];
				$CNT = $h['CNT'];
				print "<TR><TD>$NUM</TD><TD>$CNT</TD></TR>";
			}
		}


		print "</table>";
	}
	public function show_html($cookie_mid,$data)
	{
		$emp_name = (isset($data['emp_name'])) ? $data['emp_name'] : '';
		$emp_id = (isset($data['emp_id'])) ? $data['emp_id'] : '';
		$from_date = (isset($data['from_date'])) ? $data['from_date'] : '';
		$to_date = (isset($data['to_date'])) ? $data['to_date'] : '';
		$my_group = (isset($data['my_group'])) ? 'checked' : '';
		print <<<T
		<head>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-2.1.4.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
   <style type="text/css">
     .ui-datepicker  
    {
     font-size: 15px;
 
	}
	
 </style>
<script>
$(function(){
 $('#from_date, #to_date').datepicker({
     
     dateFormat: "dd-M-yy",
   	changeYear: "true",
	 changeMonth: "true",
     beforeShow: range
    });
    function range(input)
	{
	  var min = new Date(1999, 11 - 1, 1), 
        dateMin = min,
        dateMax = null;
       if (input.id == "from_date") {
        if ($("#to_date").datepicker("getDate")!= null) {
		 dateMax = $("#from_date").datepicker("getDate");
            dateMin = $("#to_date").datepicker("getDate");
            dateMin.setDate(dateMin.getDate() - 30);
            if (dateMin < min) {
                dateMin = min;
            }
        }
        else {
            dateMax = new Date;
        }                      
    }
    else 
	if (input.id == "to_date") {
        dateMax = new Date; 
        if ($("#from_date").datepicker("getDate")!= null) {
           dateMin = $("#from_date").datepicker("getDate");
           var rangeMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() +30);
               if(rangeMax < dateMax) {
                dateMax = rangeMax; 
            }
        }
    }
    return {
        minDate: dateMin, 
        maxDate: dateMax
    };
	}  
	});
</script>
</head>
		
<body><form NAME="fcp_report" id="fcp_report" onsubmit = "return checkvalidate();" method="post" >
		<INPUT TYPE="HIDDEN" NAME="mid" id="mid" value="$cookie_mid">
		<input type="hidden" name="frame_height" id="frame_height" value="">
		<table ALIGN="center" style="width:98%" BORDER="1" CELLSPACING="1" CELLPADDING="1" bordercolor="#a4d1ff">
		<tr><td class="admintlt" height="20" align="center" style="background-color:#006DCC;color:#fff" colspan="4"> <b>STO Unique Offer Approval Report</b></td><tr>
		<tr>
			<td WIDTH="32%" class="report" >Manager Name</td>
			<td CLASS="report" colspan=3>
			<input type="text" name="emp_name" id="emp_name" value="$emp_name" >
			<input type="hidden" name="emp_id" id="emp_id" value="$emp_id" >
			<a class="btn btn-info btn-small" onclick="LookupEmployee(1,2,document.fcp_report.emp_name.value,'')">
			<i class="icon-search icon-white"></i>&nbsp;Search</a> &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="my_group" value="my_group" id="my_group" $my_group>&nbsp;&nbsp;&nbsp;&nbsp;My Group
			</td>

		</tr>
		<tr>
			<td style="width:10%"><b>From Date</b></td>
			<td><input name="from_date" type="text" VALUE="$from_date" SIZE="10" id="from_date" readonly="readonly">&nbsp;&nbsp;</td>
			<td><b>To Date</b>
			<td><input name="to_date" type="text" VALUE="$to_date" SIZE="10" id="to_date" readonly="readonly">
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center"><input name="action" type="submit" value="Get Report" class="btn btn-small btn-primary" style="font-weight:normal" onclick="return chk_emp()"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-small btn-primary" type="button" onclick="form_reset();" value="Reset" name="Reset" style="font-weight:normal"></td>
		</tr>
		</table>
		</form>
		<br>
T;
	}
	public function get_header($cookie_mid,$js_path)
	{
	
		print <<<T
<html><head><meta charset="utf-8"><title>STO Unique Offer Approval Report</title>
			<link rel="stylesheet" type="text/css" href="$js_path/css/report.css"/>
			<script language="javascript" src="$js_path/protected/modules/admin_eto/js/sto-unique-report.js"></script>
			</head>
T;

	}
}	
?>
