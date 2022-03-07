<html>
<head>			
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
</head>
<body>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
	<style>
		.pagina:link { text-decoration: none;padding: 6px 9px; } a:visited { text-decoration: none; } a:hover { text-decoration: underline; } a:active {   text-decoration: underline; }</style>
		
		<table style="background-color: #FFFFFF;width: 1300px;">
		<tr>
                	<td align="right" height="30" style="font-family:arial;font-size:14px;font-weight:bold;" colspan="10">               	
			 
			 <a href="/index.php?r=admin_eto/BLDashboard/exportisqfillrate&action=exportisqfillrate&tlid=<?php echo $_REQUEST['tlid']; ?>&vendor=<?php echo $_REQUEST['vendor']; ?>&source=<?php echo $_REQUEST['source']; ?>&start_date=<?php echo $_REQUEST['start_date']; ?>&mid=3443" target="_blank">Export To Excel</a>
			
		</tr>
		</table>  
		<?php echo $result; ?>
</body></html>