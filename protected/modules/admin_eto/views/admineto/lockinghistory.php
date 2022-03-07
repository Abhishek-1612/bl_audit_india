<?php 
$actionArray=array(
1 =>'Displayed | Pool-Manual/PD | Buy Lead Lock',
2=>'Displayed | Pool-Manual | Buy Lead Displayed to Associate',
3=>'Flagged | Pool-Manual | Buy Lead Flagged under Not Talk and Pool',
4=>'Deleted | Pool-Manual | Buy Lead Deleted by Associate',
5=>'Approved | Pool-Manual | Buy Lead Approved By Associate',
6=>'Flagged | Pool-Manual | Buy Lead Flagged Under Not Talk Full Ring',
7=>'Flagged | Pool-PD | Buy Lead Flagged Under Not Talk',
8=>'Deleted | Pool-PD | Buy Lead Deleted by Associate',
9=>'Deleted | Pool-PD | Buy Lead Deleted by Dialer',
10=>'Approved | Pool-PD | Buy Lead Approved by Associate',
11=>'Flagged | Pool-PD | Buy Lead Flagged Under Not Talk',
12=>'Flagged | Pool-PD | Buy Lead Flagged Under Not Talk Full Ring',
13=>'Flagged | Pool-Manual Pool | Buy Lead to be Auto Release (12 AM)',
14=>'Flagged | Pool PD | Buy Lead to be Auto Released (12 AM)',
15=>'Deleted | Poo-NA | Buy Lead Deleted Through Auto Process',
16=>'Flagged | Pool-Inbound | Buy Lead Flagged in Not Talk',
17=>'Flagged | Pool-Inbound | Buy Lead Flagged in Connected But Flagged',
18=>'Deleted | Pool-Inbound | Buy Lead Deleted',
19=>'Approved | Pool-Inbound | Buy Lead Approved',
20=>'Moved | Pool-PD | Buy Lead Moved to Language Pool(s)',
21=>'Displayed | Pool-PD | Buy Lead Displayed to Associate',
22=>'Displayed | Pool-Inbound | Buy Lead Displayed to Associate');
echo '<STYLE TYPE="text/css">
	.admintext {font-family:arial; font-size:11px;line-height:15px;}
	.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	</STYLE>

	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Locking History Detail for Offer ID - <font color="red">'.$offerId.'</font> <BR></tbody></table>
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	        <tbody>';
	       $Arraysize=sizeof($returnResult);
	       if(empty($Postby))
	       $Postby='User Itself';
	
              for($i=0;$i<$Arraysize;$i++)
              {
                   $action_id=isset($actionArray[$returnResult[$i]['ACTION']])?$actionArray[$returnResult[$i]['ACTION']]:'';
                   $action=isset($returnResult[$i]['ACTION'])?$returnResult[$i]['ACTION']:'';
                   $action_time=isset($returnResult[$i]['ACTIVITY_TIME'])?$returnResult[$i]['ACTIVITY_TIME']:'';
                   $emp_name=isset($returnResult[$i]['ETO_LEAP_EMP_NAME'])?$returnResult[$i]['ETO_LEAP_EMP_NAME']:'';
                   $emp_id=isset($returnResult[$i]['FK_EMPLOYEE_ID'])?$returnResult[$i]['FK_EMPLOYEE_ID']:'';
              echo '<tr><td><BR></td></tr>
              <tr>
			<td class="admintext1" align="left"> <B style="color:red;">'.$action_id.' | '.$action.'</B> On '.$action_time.' by ' .'Emp ID - '.$emp_id;
			
			echo '</B></td></tr>';
              
              }
              echo '<tr><td><BR></td></tr>
              <tr>
			<td class="admintext1" align="left"> <B style="color:red;">New Posted</B> On '.$postDate.' by ' .$Postby;
			
			echo '</td></tr>';
		
              echo '</tbody></table>';





?>
