<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>
<?php  
$request = Yii::app()->request;
$currentDate = date("d-m-Y");
$start_date=$start_date1= $request->getParam('start_date','');
$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
$end_date=$end_date1= $request->getParam('end_date','');
$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
$this->pageTitle=Yii::app()->name . ' - Buy Leads Rejection Summary';         
echo <<<END
<html>
  <head>
<script language="javaScript">
 function openPdf(e, path) {
           // stop the browser from going to the href
           e = e || window.event; // for IE
           e.preventDefault();

           // launch a new window with your PDF
           window.open(path, 'name');

        }
 \$\(document).ready(function() 
    { 
        \$\("#myTable").tablesorter(); 
    } 
);
</script>
<script>
function win_detail(urlpage)
{
myWindow=window.open(urlpage,'','scrollbars=1');
myWindow.focus();
}
</script>

<style type="text/css">

.releancy_pro-detail{border-bottom:1px solid #CCC; padding:10px 5px 10px 5px;}
.releancy_pro-detail h2{ font-size:14px; font-weight:700; color:#0000ff; padding:5px 0px; margin:0px;font-family:arial;}
.releancy_pro-detail p{ padding:0px; margin:0px; font-size:12px; font-family:arial;line-height:18px; text-align:justify;}
.releancy_pro-detail img{ float:left; margin:5px; border:1px solid #e1e1e1;}

.commented:hover
{
background-color: #FFEECA;
}

.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:#333;}
.ttext{font-size:12px; padding:4px 4px 4px 7px;}
.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;}
.ttext1{font-size:12px; padding:4px 4px 4px 4px;}
.ttext_b{font-size:12px; padding:4px 4px 4px 4px;font-weight:bold;}
.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}
</style>
<style type="text/css">
a.info div {
display: none;
}

a.info:hover {
position: relative;
}

a.info:hover div {
display: block;
width : 150px;
padding: 4px 8px 8px 8px;
position: absolute;
border: 2px solid #EAE9D8;
background-color: #FAF9E8;
margin-top: auto;
border-radius: 5px;
left: -176px;
top: -10px;
}
a{color:#0000ff;text-decoration:none}
a:hover{color:#0000ff}
</style >
END;


echo '<!--google analytics async code start-->
  <script type="text/javascript">
 
function disableElements()
{	
	document.getElementById("rej_id").disabled=true;	
}
function enableElements()
{	
	document.getElementById("rej_id").disabled=false;	
}

</script>
</head>  
 <BODY>
<!--google analytics async code end-->';

 echo '<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="90%" align="center">
      	<TBODY>';

echo '<tr style="display:table-row;">';

echo '<td width="900" style=" background:#ffffff;font-size:13px;font-family:arial;">
<form method="POST" style="margin:5px 0;" name="Report" id="Report" >
<table width="90%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"  style="border-collapse:collapse" align="center">';
echo '<TR>
      	<td  colspan="4" align="CENTER" bgcolor="#e8f3f7" style="font-family: arial; font-size: 16px; font-weight: bold; border:1px solid #d2e2e8;color:#000099;">Buy Leads Rejection Summary';
  echo '</td>
      	</TR>
<tr><td><b>Start Date:</b> ';?>
&nbsp;</td><td><input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.Report.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.Report.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.Report.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.Report.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
<?php 
echo '</td>
<td><strong>Service Type: </strong></td>
<td>
<input type="radio" name="service" id="ser1" value="All"';
 if(isset($_REQUEST["service"]) && $_REQUEST["service"] == 'All')
   {echo 'checked';}
   
echo '>&nbsp;&nbsp;All&nbsp;&nbsp;
<input type="radio" name="service" id="ser2" value="Catalog"';
   if(isset($_REQUEST["service"]) && isset($_REQUEST["service"]) && $_REQUEST["service"] == 'Catalog')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;Catalog&nbsp;&nbsp;

<input type="radio" name="service" id="ser3" value="Buylead"';
   if(isset($_REQUEST["service"]) && isset($_REQUEST["service"]) && $_REQUEST["service"] == 'Buylead')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;Buylead &nbsp;&nbsp;

<input type="radio" name="service" id="ser4" value="Free Catalog"';
   if(isset($_REQUEST["service"]) && isset($_REQUEST["service"]) && $_REQUEST["service"] == 'Free Catalog')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;Free&nbsp;&nbsp;
</td>    
    </tr>
<tr>
<td><strong>Rejection Source: </strong></td>
<td colspan=3><input type="radio" name="r1" id="r1" onclick="enableElements()" value="ALL" checked>&nbsp;&nbsp;All&nbsp;&nbsp;
<input type="radio" name="r1" id="r2" onclick="enableElements()" value="MY"';

if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'MY')
{echo 'checked';}

echo '>&nbsp;&nbsp;MY&nbsp;&nbsp;&nbsp;
<input type="radio" name="r1" id="r3" onclick="enableElements()" value="Email"';
   if(isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'Email')
   {echo 'checked';}
   
echo '>&nbsp;&nbsp;Mail&nbsp;&nbsp;
<input type="radio" name="r1" id="r4" onclick="disableElements()" value="Search1"';
   if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'Search1')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;Search1&nbsp;&nbsp;

<input type="radio" name="r1" id="r5" onclick="enableElements()" value="MIM"';
   if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'MIM')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;M.IM &nbsp;&nbsp;


<input type="radio" name="r1" id="r6" onclick="enableElements()" value="APP"';
   if(isset($_REQUEST["r1"]) && isset($_REQUEST["r1"]) && $_REQUEST["r1"] == 'APP')
   {
   echo ' checked';
   }
echo '>&nbsp;&nbsp;APP&nbsp;
</td>
</tr>
<tr>
<td colspan="4"  align="center" >
<input type="Submit" align="center" value="Submit" id="Summary" name="Summary"/>
</td>
</tr>';

echo '
</table>
</form>
</td>
</tr>
</TABLE>
</td>
</tr>';
echo '</table>';

if(isset($_REQUEST['Summary'])){

	echo '<TABLE WIDTH="80%" BORDER="1" CELLPADDING="3" CELLSPACING="1"  bgcolor="#f5f5f5">
		<TR bgcolor="#f5f5f5">';		
	$total_rejection=0;
 echo '<TD ALIGN="left" class="ttext_b">Rejection Reason [Rejection Id]</TD>
<TD ALIGN="CENTER" class="ttext_b">All</TD>
<TD ALIGN="CENTER" class="ttext_b">Indian</TD>
<TD ALIGN="CENTER" class="ttext_b">Foreign</TD>
<TD ALIGN="CENTER" class="ttext_b">MY</TD>
<TD ALIGN="CENTER" class="ttext_b">Search1</TD>
<TD ALIGN="CENTER" class="ttext_b">EMAIL</TD>
<TD ALIGN="CENTER" class="ttext_b">M.IM</TD>
<TD ALIGN="CENTER" class="ttext_b">Mobile App</TD>
';
echo '</TR>';

                            $all =0;
                            $inleads =0;
                            $frleads = 0;
                            $srcleads = 0;
                            $myleads = 0;
                            $emailleads = 0;
                            $mim = 0;
                            $app=0;
                            $total =0;
    while ($rec =  $sth->read())
			{
                         $rec=array_change_key_case($rec, CASE_UPPER);  
                            $all = $rec['INLEADS'] + $rec['FRLEADS'];
                            $inleads = $inleads + $rec['INLEADS'];
                            $frleads = $frleads + $rec['FRLEADS'];
                            $srcleads = $srcleads + $rec['SEARCH1'];
                            $myleads = $myleads + $rec['MY'];
                            $emailleads = $emailleads + $rec['EMAIL'];
                            $mim = $mim + $rec['MOBILE_SITE'];
                            $app=$app + $rec['MOBILE_APP'];
                            $total = $total + $all;
                            echo '<TR bgcolor="#ffffff" >
                                        <TD ALIGN="left" class="ttext1">'.$rec['REASON'].'</TD>
					<TD ALIGN="CENTER" class="ttext1">'.$all.'</TD>';
                                        echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['INLEADS'].'</TD>';
                                        echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['FRLEADS'].'</TD>';					
					echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['MY'].'</TD>';
                                        echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['SEARCH1'].'</TD>';
					echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['EMAIL'].'</TD>';                                        
					echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['MOBILE_SITE'].'</TD>';
					echo '<TD ALIGN="CENTER" class="ttext1">'.$rec['MOBILE_APP'].'</TD>';
                                        
			echo '</TR>';
			}

			
                        
                        
                        
                        
                        
 echo '<TR>
                                        <TD ALIGN="CENTER" class="ttext_b">TOTAL</TD>
					<TD ALIGN="CENTER" width=9% class="ttext_b">'.$total.'</TD>';
                                        echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$inleads.'</TD>';
                                        echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$frleads.'</TD>';					
					echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$myleads.'</TD>';
                                        echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$srcleads.'</TD>';
					echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$emailleads.'</TD>';                                        
					echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$mim.'</TD>';
					echo '<TD ALIGN="CENTER" width=7% class="ttext_b">'.$app.'</TD>';
                                        
			echo '</TR>';
			
	
echo '</TABLE>';

if($total==0){
echo '<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
}

}
  

	echo '</BODY></HTML>';
?>
