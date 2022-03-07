<html>
<table width="100%" border="0" cellpadding="0" cellspacing="1" height="30">
			<tbody><tr>
			<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" width="15%">&nbsp;<b>GL User</b></td>
			<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" width="30%"><b>&nbsp;Company</b></td>
			<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" width="22%"><b>&nbsp;City / Country</b></td>
			<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" width="12%"><b>&nbsp;Purchased On</b></td>
			<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" width="12%"><b>&nbsp;Type</b></td>
			
			</tr>
			</tbody></table>
			<table width="100%" border="1" cellpadding="2" cellspacing="1" bordercolor="#E1EAE0" style="border-collapse:collapse;">
			<tbody>
			<?php 
			$i=0;
			foreach($data as $value)
			{
			foreach($value as $key)
			{echo '<tr bgcolor="#f7f7f7"><td style="font-family:arial;font-size:11px;" width="15%">
			'.$data['FK_GLUSR_USR_ID'][$i].'</td>
			<td style="font-family:arial;font-size:11px;" width="30%" align="CENTER">'.$data['GLUSR_USR_COMPANYNAME'][$i].'</td>
			<td style="font-family:arial;font-size:11px;" width="22%" align="CENTER">'.$data['GLUSR_USR_CITY'][$i].' / '.$data['GL_COUNTRY_NAME'][$i].'</td>
			<td style="font-family:arial;font-size:11px;" width="12%" align="CENTER">'.$data['TDATE'][$i].'</td>
			<td style="font-family:arial;font-size:11px;" width="12%" align="CENTER">'.$data['FLAG'][$i].'</td>
			</tr>';
			$i++;
			}
			die;
			}
			?>
			</tbody></table>
<html>