<?php 

      $err = 'Some Err Ocurs.';
	if($genmis)

	{

		$err_stdt = 'Start Date is not valid:<br>';
		$err_enddt = 'End Date is not valid:<br>';
		$dtdiff = -1;

		if($startdate && $startmonth && $startyear)
		{
			if($checkValidDate1)
			{
				$err_stdt = '';
			}
			else
			{
				$err_stdt='Start Date is not valid:<br>';
			}
		}
		else
		{
			$err_stdt='Start Date is not valid:<br>';
		}

		if($enddate && $endmonth && $endyear)
		{
			if( $checkValidDate2)
			{
				$err_enddt = '';
			}
			else
			{
				$err_enddt='End Date is not valid:<br>';
			}
		}
		else
		{
			$err_enddt='End Date is not valid:<br>';
		}

		if($startdate && $startmonth && $startyear && $enddate && $endmonth && $endyear)
		{
			 $endyear = $endyear;
			 $endmonth = $endmonth;
			 $enddate = $enddate;
			 $startyear = $startyear;
			$startmonth = $startmonth;
			 $startdate = $startdate;
            		 $ed = $endyear . $endmonth . $enddate;
			 $sd = $startyear . $startmonth . $startdate;
			$dtdiff = $ed - $sd;
		}
		if($dtdiff <= -1)
		{
			$dtdiff = 'Start Date Should be Less or Equal to End Date<br>';
		}
		else
		{
			$dtdiff = '';
		}

		if($err_stdt && $err_stdt == '' && $err_enddt && $err_enddt != '' && $dtdiff && $dtdiff != '')
		{
			$err = '';
		}
		else
		{
			$err = $err_stdt . $err_enddt . $dtdiff;
		}
	}
	
$this->pageTitle=Yii::app()->name . ' -Consumption MIS';
	echo '<HTML>
  
  <HEAD>
    <!--google analytics async code start-->
  <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28761981-2\']);
  _gaq.push([\'_setDomainName\', \'.intermesh.net\']);
  _gaq.push([\'_setSiteSpeedSampleRate\', 10]);
  _gaq.push([\'_trackPageview\',\''.$_SERVER['REQUEST_URI'].'\']);
  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end-->
  </HEAD>
  
  <BODY>
    <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%" HEIGHT="30">
      <TBODY>
      <TR>
        <TD STYLE="font-family: arial; font-size: 14px; font-weight: bold;" 


        ALIGN="CENTER" BGCOLOR="#f4f4f4">Call Center Consumption MIS</TD>

      </TR>';
if($err && $err != 'Some Err Ocurs.')
{
	echo '<TR>
        <TD STYLE="font-family: arial; font-size: 14px; font-weight: bold;" 
        ALIGN="CENTER" BGCOLOR="#f4f4f4">'.$err.'</TD>
      </TR>';
}


echo '</TBODY>
    </TABLE>
 <FORM method="post" action="index.php?r=admin_bl/Eto_cons_mis/Index">
    <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="1" WIDTH="100%" align="center">
      <TBODY>
      <TR>
        <TD STYLE="font-family: arial; font-size: 12px; font-weight: bold;" 
        BGCOLOR="#ccccff" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
        <TD  STYLE="font-family: arial; font-size: 16px; font-weight: ;"
        BGCOLOR="#eaeaea">
        <TABLE>
          <TR>
            	<TD>
			<SELECT NAME="startdate" SIZE="1">
				'.$stdtddl.'
			</SELECT>
		</TD>

            	<TD>
			<SELECT NAME="startmonth" SIZE="1">
				'.$stmmddl.'
			</SELECT>
		</TD>

        	<TD>
			<SELECT NAME="startyear" SIZE="1">
				'.$styyddl.'
			</select>	
		</TD>
            <TD>&nbsp;to&nbsp;</TD>
            <TD>
			<SELECT NAME="enddate" SIZE="1">
				'.$eddtddl.'
			</SELECT>
		</TD>

            	<TD>
			<SELECT NAME="endmonth" SIZE="1">
				'.$edmmddl.'
			</SELECT>
		</TD>

        	<TD>
			<SELECT NAME="endyear" SIZE="1">
				'.$edyyddl.'
			</select>	
		</TD>
		<td>This Report Generates Date as per Indian Date (IST)</td>
          </TR>
        </TABLE></TD>
      </TR></TBODY>
    </TABLE>
    <TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%" HEIGHT="30">
      <TBODY>
      <TR>
        <TD STYLE="font-family: arial; font-size: 14px; font-weight: bold;" 
        ALIGN="CENTER" BGCOLOR="#f4f4f4"><INPUT NAME="action" VALUE="callcenterinfo" TYPE="hidden">
	<input type="submit" value="Generate Report" name="genmis">
        
      </TR></TBODY>
    </TABLE></FORM><br>';

	if($genmis && $err == '')
	{
		if($dbh)
		{
			echo '<TABLE WIDTH="80%" BORDER="0" CELLPADDING="5" CELLSPACING="1" STYLE="font-size:12px; font-family:arial;" ALIGN="CENTER">
				<TR STYLE="font-weight:bold">
					<TD align="center" BGCOLOR="#ccccff">Agent Name</TD>
					<TD align="center" BGCOLOR="#ccccff">Companies Assigned</TD>
					<TD align="center" BGCOLOR="#ccccff">Credit Consumed</TD>
					<TD align="center" BGCOLOR="#ccccff">Active User</TD>
					<TD align="center" BGCOLOR="#ccccff">Active User(%)</TD>
					<TD align="center" BGCOLOR="#ccccff">Unique Lead Sold</TD>
      				</TR>';


 
$totAss=0;
$totCrd=0;
$totActive=0;
$totActiveperc=0;
$activeuserperc=0;
$activeuserperc1=0;
$totActiveperc1=0;
$totsoldlead=0;

 foreach (range(0,34) as $x)
 {
    if(isset($totalAsigArray[$x]['TOTAL_GLUSR_ASSIGN']))
    {
    $totAss=$totalAsigArray[$x]['TOTAL_GLUSR_ASSIGN']+$totAss;
    }
    if(isset($totalConsArray[$x]['TOTAL_CREDIT_CONSUMED']))
    {
    $totCrd=$totalConsArray[$x]['TOTAL_CREDIT_CONSUMED']+$totCrd;
    }
    if(isset($totalConsArray[$x]['TOTAL_GLUSR_ACTIVE']))
    {
    $totActive=$totalConsArray[$x]['TOTAL_GLUSR_ACTIVE']+$totActive;
    }
    if(isset($totalConsArray[$x]['UNIQUE_LEAD_SOLD']))
    {
      $totsoldlead=$totalConsArray[$x]['UNIQUE_LEAD_SOLD']+$totsoldlead;
     }
      if(isset($totalAsigArray[$x]['AGENT_NAME']))
      {
      $agentName = $totalAsigArray[$x]['AGENT_NAME'];
      }
      else
      {
      $agentName='N/A';
      }
      if(isset($totalAsigArray[$x]['TOTAL_GLUSR_ASSIGN']))
      {
      $totAsigned = $totalAsigArray[$x]['TOTAL_GLUSR_ASSIGN'];
      }
      else
      {
      $totAsigned=0;
      }
      if(isset($totalConsArray[$x]['TOTAL_CREDIT_CONSUMED']))
      {
      $totCrdConsumed = $totalConsArray[$x]['TOTAL_CREDIT_CONSUMED'];
      }
      else
      {
      $totCrdConsumed=0;
      }
      if(isset($totalConsArray[$x]['TOTAL_GLUSR_ACTIVE']))
      {
      $totActiveGlusr = $totalConsArray[$x]['TOTAL_GLUSR_ACTIVE'];
      }
      else
      {
      $totActiveGlusr=0;
      }
      if(isset($totalConsArray[$x]['UNIQUE_LEAD_SOLD']))
      {
      $totUniquesoldlead = $totalConsArray[$x]['UNIQUE_LEAD_SOLD'];
      }
      else
      {
      $totUniquesoldlead=0;
      }
      if($totAsigned)
      {
      $activeuserperc =(($totActiveGlusr/$totAsigned)*100);
      $activeuserperc1 = sprintf("%.0f", $activeuserperc);
      }
      else
      {
      $activeuserperc1=0;
      }
     
				      echo '
					      <TR>
						      <TD align="center" BGCOLOR="#eaeaea">'.$agentName.'</TD>
						      <TD align="center" BGCOLOR="#f8f8f8">'.$totAsigned.'</TD>
						      <TD align="center" BGCOLOR="#f8f8f8">'.$totCrdConsumed.'</TD>
						      <TD align="center" BGCOLOR="#f8f8f8">'.$totActiveGlusr.'</TD>
						      <TD align="center" BGCOLOR="#f8f8f8">'.$activeuserperc1.'</TD>
						      <TD align="center" BGCOLOR="#f8f8f8">'.$totUniquesoldlead.'</TD>
					      </TR>';
			      }
			      $totActiveperc=(($totActive/$totAss)*100);
			      $totActiveperc1=sprintf("%.0f", $totActiveperc);
			       
			      if(isset($totalCountArray[0]['TOTAL_UNIQUE_LEAD_SOLD']))
			      {
			      $totcount = $totalCountArray[0]['TOTAL_UNIQUE_LEAD_SOLD'];
			      }
			      else
			      {
			      $totcount=0;
			      }
			      echo '
					      <TR STYLE="font-weight:bold">
						      <TD align="center" BGCOLOR="#ccccff">Total </TD>
						      <TD align="center" BGCOLOR="#ccccff">'.$totAss.'</TD>
						      <TD align="center" BGCOLOR="#ccccff">'.$totCrd.'</TD>
						      <TD align="center" BGCOLOR="#ccccff">'.$totActive.'</TD>
						      <TD align="center" BGCOLOR="#ccccff">['.$totActiveperc1.']</TD>
						      <TD align="center" BGCOLOR="#ccccff">'.$totsoldlead.' ['.$totcount.']</TD>
					      </TR>
					      <tr>
						      <td colspan="6"><div style="font-size:12px;color:red;line-height:19px;padding-top:8px">* The First [ ] shows Unique % active users<br>
      * The Second [ ] shows Unique leads sold (purchased by those unique users)</div></td>
					      </tr>
			      </TABLE>';
		      }
		      else
		      {
			      echo 'Cant connect to database';
		      }
		      
		      
	      }

	      echo '</BODY></HTML>';
 
	
	




?>