

		
		<style>
		.intd {
		    padding: 4px 0;
		    text-align: center;
		    word-wrap: break-word;
		}
		</style>
		<script type="text/javascript" LANGUAGE="JavaScript" src="http://gladmin.intermesh.net/js/calendar-v1.js"></script>
		<link rel="stylesheet" type="text/css" href="http://gladmin.intermesh.net/css/calendar-v1.css">
		<link href="/css/report.css" rel="stylesheet" type="text/css"> 
		  
 		<div id="showform1" style="width:100%; margin:0px auto;">
                        <form name="user_details" action="eto-bl-pur-pend.mp" method="post" style="margin-top:0;margin-bottom:0;">
                                <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%"  height="60px">
                                        <tbody>
                       <tr><td align="center" bgcolor="#dff8ff"><font color=" #000000" size=3px><b>Purchase Limit Pending Report</b></font></span></span></td></tr>
                        <tr>
                           <td width="32%" style="text-align:center;height:50px;">
Total Pending Limits &nbsp;&nbsp;<input type="text" value="$totalpl" name="totalpl" id="totalpl" autocomplete="off" size="5">
From Date &nbsp;&nbsp;<input type="text" value="$fromdate" name="fromdate" id="fromdate" autocomplete="off" onclick="displayDatePicker('fromdate')" size="10"> &nbsp; &nbsp;To Date &nbsp;&nbsp;<input type="text" value="$todate" name="todate" id="showDailyLimitPurchaseFormtodate" autocomplete="off" size="10" onclick="displayDatePicker('todate')" > &nbsp; &nbsp; <input type="radio" name="status" value="pending" $p >Pending &nbsp; &nbsp; <input type="radio" name="status" value="done" $d >Done &nbsp; &nbsp; <input type="radio" name="status" value="all" $a >All &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="submit" align="middle" value="Go"></td>
<td>
<form>
<input type="checkbox" name="5mins" value="5mins">5mins &nbsp;&nbsp;
<input type="checkbox" name="10mins" value="10mins">10mins &nbsp;&nbsp;
<input type="checkbox" name="15mins" value="15mins">15mins &nbsp;&nbsp;
<input type="checkbox" name=">15mins" value=">15mins">>15mins &nbsp;&nbsp;
</form>

</td>
						</tr>
                                        </tbody>
                                </table>
                        </form>
                </div>
	<table width="1300px" cellspacing="0" cellpadding="4" bordercolor="#bedadd" border="1" style="border-collapse: collapse;" id="datatable">
	<tr>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>S.No.</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>GLID</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Purchase Count</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Lead ID</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Platform</b></td>
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Purchase Date</b></td>
<!--	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Modified Date</b></td>-->
	<td width="100px" bgcolor="#dff8ff" style="text-align:center;"><b>Status123</b></td>
	</tr>
	
<?php

//if(!empty($data))

echo "view data";
//print_r($data);



?>














































