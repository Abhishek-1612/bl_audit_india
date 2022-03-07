<?php
$tableColor= array(0=>'#F0F0F0',1=>'#FFFFFF'); $tableColorFlag=0;
$userDet['ID']=isset($userDet['ID']) ? $userDet['ID'] :  '';
$userDet['id']=isset($userDet['id']) ? $userDet['id'] :  '';
?>
<HTML>
     	<HEAD><TITLE>Contact Details</TITLE>
         <STYLE TYPE="text/css">.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;}
        .admintext1 {font-family:ms sans serif,verdana; font-size:14px;line-height:17px;}
        .admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE>
            <SCRIPT LANGUAGE="JavaScript">
            <!--
            function popup(url) {
                 window.open(url,'details','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=300');
            }
             //-->
    	</SCRIPT>
     	</head>
        <body bgcolor="#ffffff" leftmargin="0">
    <table width="100%" border="0">
      <tr>
        <td bgcolor="f1f1f1" align="center"><b><font size="-1" face="arial">Company
        Details</font></b></td>
      </tr>
      <tr>
        <td align="left" class="admintext1">
	<b><?php echo $userDet['GLUSR_USR_SALUTE'] .$userDet['GLUSR_USR_FIRSTNAME'] .$userDet['GLUSR_USR_LASTNAME'];?></b>
	 (<?php echo $userDet['GLUSR_USR_DESIGNATION']; ?>)
	 <!-- <a href="admin-contact.pl?do=sm&mem=<?php echo $userDet['ID']; ?>" TITLE="Send an E-Mail"><?php echo $userDet['GLUSR_USR_EMAIL']; ?></a><br> -->
	 <?php echo $userDet['GLUSR_USR_EMAIL']; ?><br>
        <b>
        <?php echo $userDet['GLUSR_USR_COMPANYNAME']."</b>";
        if (!empty($userDet['GLUSR_USR_URL'])) {
	   		if (preg_match_all('/^www/',$userDet['GLUSR_USR_URL'])) {
				$userDet['site_url'] = "http://".$userDet['GLUSR_USR_URL'];
	     }
	   echo "&nbsp;&nbsp;&nbsp;&nbsp; <A HREF=\"".$userDet['GLUSR_USR_URL']."\" TARGET=\"_new\">".$userDet['GLUSR_USR_URL']."</A>";
        }
        echo " <BR>
   	".$userDet['GLUSR_USR_ADD1']."<BR>";
        if ($userDet['GLUSR_USR_ADD2']){
            echo $userDet['GLUSR_USR_ADD2'].'<BR>';
        }
        echo  $userDet['GLUSR_USR_CITY'].', ';
        if ($userDet['GLUSR_USR_STATE']){
   	    echo $userDet['GLUSR_USR_STATE'].', ';
        }
        echo '<BR>'.$userDet['GLUSR_USR_COUNTRYNAME']." ".$userDet['GLUSR_USR_ZIP'].'<BR>
        <B>Ph:</B> '.$userDet['GLUSR_USR_PH_COUNTRY'].' - '.$userDet['GLUSR_USR_PH_AREA'].' - '.$userDet['GLUSR_USR_PH_NUMBER'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <B>Fx:</B> '.$userDet['GLUSR_USR_FAX_COUNTRY'].' - '.$userDet['GLUSR_USR_FAX_AREA'].' - '.$userDet['GLUSR_USR_FAX_NUMBER'].'&nbsp;&nbsp;&nbsp;&nbsp;
        <B>Mb:</B> '.$userDet['GLUSR_USR_PH_MOBILE'].'<BR>
        <B>Yr. of Estb:</B> '.$userDet['GLUSR_USR_YEAR_OF_ESTB'].'<BR>
        <B>Trn:</B> '.$userDet['GL_TURNOVER_VAL'].'<BR>
        <B>No. of Emp:</B> '.$userDet['GLUSR_NOOF_EMP_VAL'].'<BR>';

	if($userDet['GLUSR_USR_URL'])
	{
		echo '<b>Url:</b> <a href="'.$userDet['GLUSR_USR_URL'].'" target="_blank">'.$userDet['GLUSR_USR_URL'].'</a><BR>';
	}
	echo '<B>User Status:</B> '.$userDet['GLUSR_USR_APPROV'].' &nbsp;
        <A HREF="/index.php?r=admin_glusr/MultipleScreen/index&multiscreen=1&action=searchid&action1=edit&searchby=id&searchstr='.$userDet['GLUSR_USR_ID'].'&mid=46&screen_change=1&app=AL" TARGET="_new">Change Status</A>
        &nbsp; <A HREF="javascript:popup(\'../index.php?r=admin_glusr/MultipleScreen/moreinfo&id='.$userDet['id'].'&mid=46\');">More Details</A>
	</TD>
      </TR>
      </TABLE>';
    if (!empty($userDet['GLUSR_USR_ROLE'])){
           echo '<Table cellpadding=0 cellspacing=3 width=100% border=0><tr><td>';
           if ($userDet['GLUSR_USR_ROLE'] == 'S' || $userDet['GLUSR_USR_ROLE'] == 'A') {
	        	echo '<B>Seller Profile:</B> <FONT COLOR="#800000">'.$userDet['GLUSR_USR_SELLINTEREST'].'</FONT><BR></td></tr>';
           }
           if ($userDet['GLUSR_USR_ROLE'] == 'B' || $userDet['GLUSR_USR_ROLE'] == 'A') {
	        	echo '<tr><td><B>Buyer Profile:</B> <FONT COLOR="#800000">'.$userDet['GLUSR_USR_BUYINTEREST'].'</FONT><BR>';
           }
            echo '</td></tr></Table>';
        } 
           echo '<FONT COLOR="#800000">'.$userDet['GLUSR_USR_COMPANY_DESC'].'</FONT><BR>';
        
	 ?><br>
           <center><a href="javascript:window.close();">Close Window</a></center>
     	 </body>
        </html>