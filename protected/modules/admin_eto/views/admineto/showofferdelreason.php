<HTML>
     	<HEAD><TITLE>Delete Reasons</TITLE>
         <STYLE TYPE="text/css">.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;}
        .admintext1 {font-family:ms sans serif,verdana; font-size:14px;line-height:17px;}
        .admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
	a{color:#0000ff; text-decoration:none;} a:hover{color:#000000; text-decoration:underline;}
	</STYLE>
        <SCRIPT type="text/javaScript">
        
	function checkreason(i,button)
	{
			if(button == 'delsilent')
			{
				var val = confirm("Are you sure you want to delete this offer? Responses to this offer (if any) will also be deleted.");
				if(val == true)
				{
					parent.document.getElementById("reason").value=eval('document.reasonForm.reason' + i + '.value');
					parent.document.getElementById("reasondesc").value=eval('document.reasonForm.reasondesc' + i + '.value');
				}
				else
				{
					return false;
				}
				
			}
			if(button == 'delform')
			{
				parent.document.adminForm.delform.value=1;
			}
			
			parent.document.adminForm.action = "/index.php?r=admin_eto/AdminEto/DeleteSilent";
			
			parent.document.adminForm.submit();
		
			closeWindow();
	}
	function closeWindow() {
		var framediv = parent.document.getElementById("subcontent2");
		framediv.style.display='none'
	} 
    	</SCRIPT>
     	</HEAD>
        <BODY style="margin:0;">
	<FORM NAME="reasonForm">
    <TABLE WIDTH="100%" BORDER="0" style="background:#ffffff;" height=''>
      
      <TR>
        <TD ALIGN="LEFT" CLASS="admintext1">
	<table border="1" cellpadding="3" cellspacing="0" border-color="#e7e7e7" style="font-size:12px; font-family:arial;">
	<?php 
	$i=0;$j =0;
	foreach($deleteResonResult['reject_reason_all'] as $k1=>$row1) 
	{ ?>
		<TR>
		<TD VALIGN="TOP">
		<a href="javascript:void(0);" onclick="checkreason(<?php echo $j; ?>,'<?php echo $button; ?>');" >
		<?php echo $row1['text']; ?></a></TD></TR>
		<INPUT TYPE="HIDDEN" NAME="reason<?php echo $j; ?>" id="reason<?php echo $j; ?>" VALUE="<?php echo $row1['value']; ?>">
		<INPUT TYPE="HIDDEN" NAME="reasondesc<?php echo $j; ?>" id="reasondesc<?php echo $j; ?>" VALUE="<?php $row1['text']; ?>">
		<?php $j++;
	}
	
	?></TABLE></TD>
      </TR>
      </TABLE>
     </FORM>
     </BODY>
      </HTML>