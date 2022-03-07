<HTML>
     	<HEAD><TITLE>Contact Details</TITLE>
         <STYLE TYPE="text/css">.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;}
        .admintext1 {font-family:ms sans serif,verdana; font-size:14px;line-height:17px;}
        .admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE>
            <SCRIPT LANGUAGE="JavaScript">
            <!--
            function checkreason(fromAnchor,url)
	    {
		var checked=0;
		if(document.reasonForm.reason.length)
		{
			for(var i=0;i<document.reasonForm.reason.length;i++)
			{
				if(document.reasonForm.reason[i].checked)
				{
					checked=1;
					break;
				}
			}
			
			if(checked)
			{
				if(fromAnchor)
				{
					window.opener.document.location=unescape(url)+'&reason='+document.reasonForm.reason[i].value+'&reasondesc='+eval('document.reasonForm.reasondesc' + i + '.value');
				}
				else
				{
					window.opener.document.adminForm.reason.value=document.reasonForm.reason[i].value;
					window.opener.document.adminForm.reasondesc.value=eval('document.reasonForm.reasondesc' + i + '.value');
				}
				
				window.close();
			}
			else
			{
				alert("Please select any one of the reasons !");
			}
		}
	    }
             //-->
    	</SCRIPT>
     	</head>
        <body bgcolor="#ffffff" leftmargin="0">
	<form name="reasonForm">
    <table width="100%" border="0">
      <tr>
        <td bgcolor="f1f1f1" align="center"><b><font size="-1" face="arial">Select Reason For Delete</font></b></td>
      </tr>
      <tr>
        <td align="left" class="admintext1">
	<table width="100%" border="0">
	<?php
	$i=0;
	foreach($deleteResonResult['reject_reason_all'] as $rec => $value)
	{ ?>
		<tr><td width="5%" align="center" valign="top" class="admintext1">
		<input type="radio" name="reason" value="<?php echo $value['value']; ?>"></td>
		<td width="95%" align="left" valign="top" class="admintext1"><?php echo $value['text']; ?>
		<input type="hidden" name="reasondesc<?php echo $i; ?>" value="<?php echo $value['text']; ?>"></td></tr>
	<?php	$i++;
	 } ?>
	
	</table></td>
      </tr>
      </table>
      <br>
     <center>
     <?php if($fromAnchor)
     {
     	echo '<A HREF="javascript: checkreason('.$fromAnchor.',\''.$redirectURL.'\');">Delete</A>';
     }
     else
     {
     	echo '<A HREF="javascript: checkreason('.$fromAnchor.',\''.$redirectURL.'\');">Close Window</A>';
     }
     ?></center>
     </form>
     </body>
      </html>
