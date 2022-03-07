<?php
class Etopblcompsrch1Controller extends Controller
{
     public function actioneto_pbl_comp_srch1()
	{
    $glEtoModel = new Globalconnection();
    $dbh = $glEtoModel->connect_db_oci('mainr');
    
   if($dbh)
{       if(isset($_REQUEST['selectedtext']))
	$string = $_REQUEST['selectedtext'];
	else
	$string = '';
// 	print "Content-type: text/html\n\n";
 	
	if($string)
	{
		$sql_st = "
		SELECT 
			COMPANY, FK_GLUSR_USR_ID
		FROM 
			COMPANY , ITRA_COMPTOSUBCATS , IHOT_COMPTOSUBCATS
		WHERE 
			COMPANY_SEARCHNAME LIKE UPPER(CHARS_ONLY(:search_string)) || '%' 
			AND ENABLED = -1 
			AND FK_GLUSR_USR_ID IS NOT NULL 
			AND COMPANY.COMPANYID=ITRA_COMPTOSUBCATS.COMPANYID(+)
			AND ITRA_COMPTOSUBCATS.COMPANYID IS NULL
			AND COMPANY.COMPANYID=IHOT_COMPTOSUBCATS.COMPANYID(+)
			AND IHOT_COMPTOSUBCATS.COMPANYID IS NULL
			ORDER BY COMPANY";
                $sth_st=oci_parse($dbh,$sql_st);
		
		oci_bind_by_name($sth_st,':search_string',$string);
		oci_execute($sth_st);
		$tr = '';
		$company_name = '';	
		
		while (($compName = oci_fetch_assoc($sth_st))!=false)
		{
			$company_name = $compName['COMPANY'];
			//$company_name =~ s/\'/\\\'/ig;
	
			$tr .='<tr>
			<td><a href="#" onClick="javascript:window.opener.document.validate_user.gluserid.value='.$compName['FK_GLUSR_USR_ID'].';window.opener.document.validate_user.comp.value='.$company_name.';window.close();">'.$compName['COMPANY'].'</a></td></tr>';
		}
		
		if($tr)
		{	
			echo "
			<table>$tr</table>";
		}
		else
		{
			echo '
			<div align="center"><font color="red">No Company Found with "'.$string.'"</font></div>';
		}
	}
	else
	{
		echo '<div align="center">
		<font color="red">Please Enter any Company Name</font></div>';
	}
}
else
{
	//print $q->header(-type=>"text/html");
         echo "Database not connected";
}
}
}
?>