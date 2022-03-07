<?php
 $this->pageTitle=Yii::app()->name . ' - MISC Reports'; 

echo '
<style type="text/css">
	.admintext1 {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; font-size:14px;line-height:17px; padding:0 0 5px 8px}</style>

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
<!--google analytics async code end-->';
echo '<table height="30" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
	<td style="font-family: arial; font-size: 20px; font-weight: bold; color: rgb(128, 0, 0);" bgcolor="#f4f4f4" align="CENTER">Miscellaneous Report</td>
	</tr>
	</tbody></table><br>  <div style="border:solid 1px #CFCFCF; padding:5px">';

# 	print qq~<center><font color="#800000" size="+1"><b>Miscellaneous Report</b></font></center>~;
	 echo '<table border="0" cellpadding="3" width="100%" cellspacing="1"><tbody><tr>
<td bgcolor="#f4f4f4" style="font-family: arial; padding-left:8px; font-size:18px; color:#000090">Indian Buy Leads With No City :</td></tr>';

// 	$query->param(-name=>'openpg',-value=>'admin-eto.pl?move=first&offer=0&act=edit&ofrtype=B&nocity1=N&status=A&country_iso=IN');
//          $queryString = $query->query_string();
           $queryString='?move=first&offer=0&act=edit&ofrtype=B&nocity1=N&status=A&country_iso=IN';
          $queryString= urlencode($queryString);
       
         echo '<tr><td style="padding-top:8px" class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-rightframes.pl?openpg=admin-eto.pl'.$queryString.'" TARGET="_blank">City ID Exists but City Name Blank</A> - ('.$totalOffers1.')<BR></td></tr>';


// 	$query->param(-name=>'openpg',-value=>'admin-eto.pl?move=first&offer=0&act=edit&ofrtype=B&nocity2=N&status=A&country_iso=IN');
//          $queryString = $query->query_string();
  
  
$queryString='?move=first&offer=0&act=edit&ofrtype=B&nocity2=N&status=A&country_iso=IN';
$queryString= urlencode($queryString);

         echo '<tr><td class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-rightframes.pl?openpg=admin-eto.pl'.$queryString.'" TARGET="_blank">City Name Exists but City ID Blank</A> - ('.$totalOffers2.')<BR></td></tr>';

// 	$query->param(-name=>'openpg',-value=>'admin-eto.pl?move=first&offer=0&act=edit&ofrtype=B&nocity3=N&status=A&country_iso=IN');
//          $queryString = $query->query_string();
$queryString='?move=first&offer=0&act=edit&ofrtype=B&nocity3=N&status=A&country_iso=IN';
$queryString= urlencode($queryString);

         echo '<tr><td class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;Both City ID and Name are Blank</A><BR></td></tr>';

         echo '<tr><td class="admintext1">&nbsp;&nbsp; <span style="font-size:14px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-rightframes.pl?openpg=admin-eto.pl'.$queryString.'" TARGET="_blank">Leads with Area Code</A> - ('.$totalOffers3.')<BR></td></tr>';


// 	$query->param(-name=>'openpg',-value=>'admin-eto.pl?move=first&offer=0&act=edit&ofrtype=B&nocity4=N&status=A&country_iso=IN');
//          $queryString = $query->query_string();
         
         $queryString='?move=first&offer=0&act=edit&ofrtype=B&nocity4=N&status=A&country_iso=IN';
         $queryString= urlencode($queryString);
         
         echo '<tr><td class="admintext1">&nbsp;&nbsp; <span style="font-size:14px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-rightframes.pl?openpg=admin-eto.pl'.$queryString.'" TARGET="_blank">Leads without Area Code</A> - ('.$totalOffers4.')<BR></td></tr>';
         echo '</tbody></table></div>';
         
    

         echo '<div style="border:solid 1px #CFCFCF; padding:5px">
         <table border="0" cellpadding="3" width="100%" cellspacing="1"><tbody><tr>
         <td bgcolor="#f4f4f4" style="font-family: arial; padding-left:8px; font-size:18px; color:#000090">AST-LUCENE Report :</td></tr>
         <tr><td style="padding-top:8px" class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="http://gladmin.intermesh.net/admin_eto/eto-ast-lucene.mp" TARGET="_blank">AstBuy Compare Lucene Data</A><BR></td></tr>
         </tbody></table></div>';

	 echo '<div style="border:solid 1px #CFCFCF; padding:5px">
         <table border="0" cellpadding="3" width="100%" cellspacing="1"><tbody><tr>
         <td bgcolor="#f4f4f4" style="font-family: arial; padding-left:8px; font-size:18px; color:#000090">Generic MCAT Report :</td></tr>
         <tr><td style="padding-top:8px" class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-ofr-generic-mcat.mp" TARGET="_blank">Buy Leads Mapped in Generic Mcats</A><BR></td></tr>
         </tbody></table></div>';

	 echo '<div style="border:solid 1px #CFCFCF; padding:5px">
         <table border="0" cellpadding="3" width="100%" cellspacing="1"><tbody><tr>
         <td bgcolor="#f4f4f4" style="font-family: arial; padding-left:8px; font-size:18px; color:#000090">Supplier Selection :</td></tr>
         <tr><td style="padding-top:8px" class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-ofr-supplier-mapping.mp" TARGET="_blank">Supplier Selected - New BL Approval Screen</A><BR></td></tr>
         </tbody></table></div>';

	 echo '<div style="border:solid 1px #CFCFCF; padding:5px">
         <table border="0" cellpadding="3" width="100%" cellspacing="1"><tbody><tr>
         <td bgcolor="#f4f4f4" style="font-family: arial; padding-left:8px; font-size:18px; color:#000090">Lead Approval Report :</td></tr>
         <tr><td style="padding-top:8px" class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<A HREF="admin_eto/eto-hourly-approval1.mp" TARGET="_blank">Hourly Lead Approval Report</A><BR></td></tr>
         </tbody></table></div>';

	echo '<div style="border:solid 1px #CFCFCF; padding:5px">
         <table border="0" cellpadding="3" width="100%" cellspacing="1"><tbody><tr>
         <td bgcolor="#f4f4f4" style="font-family: arial; padding-left:8px; font-size:18px; color:#000090">Buyer Requirement Over Fulfillment Report :</td></tr>
         <tr><td style="padding-top:8px" class="admintext1"><span style="font-size:18px; line-height:0; color:#666">&#8226;</span>&nbsp;<a href="admin_eto/buyer-req-feedbackReport.mp" target="_blank">Buyer Requirement Over Fulfillment Report</a><br></td></tr>
         </tbody></table></div>';



?>