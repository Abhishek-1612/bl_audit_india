<HTML>
     	<HEAD><TITLE>Contact Details</TITLE>
         <STYLE TYPE="text/css">.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;}
        .admintext1 {font-family:ms sans serif,verdana; font-size:14px;line-height:17px;}
        .admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE>
            <script type="text/javascript">
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
					window.opener.document.location= unescape(url)+'&reason='+document.reasonForm.reason[i].value+'&reasondesc='+eval('document.reasonForm.reasondesc' + i + '.value')+'&referalUrl='+escape(document.reasonForm.referalUrl.value);
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
    	</script>
     	</head>
        <body bgcolor="#ffffff" leftmargin="0">
        <?php 
        if($valid == 0){
        		echo "You are not loggedin";
        } else{
        
			$result = $delResult['result'];        
			$redirectURL = $delResult['redirectURL'];        
			$fromAnchor = $delResult['result'];        
        ?>
	<form name="reasonForm">
    <table width="100%" border="0">
      <tr>
        <td bgcolor="f1f1f1" align="center"><b><font size="-1" face="arial">Select Reason for Delete</font></b></td>
      </tr>
      <tr>
        <td align="left" class="admintext1">
	<table width="100%" border="0">
	<?php $i=0;
	foreach($result['reject_reason_all'] as $k=>$row) 
	{
		echo '<TR><TD WIDTH="5%" ALIGN="CENTER" VALIGN="TOP" CLASS="admintext1">
		<INPUT TYPE="RADIO" NAME="reason" VALUE="'.$row['value'].'"></TD>
		<TD WIDTH="95%" ALIGN="LEFT" VALIGN="TOP" CLASS="admintext1">'.$row['text'].'
		<INPUT TYPE="HIDDEN" NAME="reasondesc'.$i.'" VALUE="'.$row['text'].'"></TD></TR>';
		$i++;
	}
	echo '<INPUT TYPE="HIDDEN" NAME="referalUrl" VALUE="'.$referalUrl.'">';
	?>
	</TABLE></TD>
      </TR>
      </TABLE>
      <BR>
     <CENTER>
     <?php
     if(!empty($fromAnchor)) {
     		echo '<A HREF="javascript: checkreason('.$fromAnchor.',\''.$redirectURL.'\');">Delete</A>';
     }
     else
     {
     		echo '<A HREF="javascript: checkreason('.$fromAnchor.',\''.$redirectURL.'\');">Close Window</A>';
     }
     ?>
     </CENTER>
     </FORM>
     <?php } ?>
     </BODY>
      </HTML>