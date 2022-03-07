<?php 
class PblMy extends CFormModel
{
	public function totofferdisplay($filename,$arr,$dbh,$userDet,$usr_id)
	{
		$glusr_usr_id = '';
		$glusr_fname = '';
		$glusr_mname = '';
		$glusr_lname = '';
		$glusr_email = '';
		$glusr_company = '';
		$glusr_city = '';
		$glusr_country = '';
		$file_name=$filename;
		$q=$arr;
		$reject_flag_text = array();
		$sql = "select IIL_MASTER_DATA_VALUE FLAGID,IIL_MASTER_DATA_VALUE_TEXT FLAGDATA,decode(FK_IIL_MASTER_DATA_TYPE_ID,20,2,21,3) TABID from IIL_MASTER_DATA where FK_IIL_MASTER_DATA_TYPE_ID IN(20,21)";
		$sth2 = $dbh->createCommand($sql);
		$dataReader=$sth2->query();
		$result = $dataReader->readAll();
		foreach($result as $result2)
		{
			$flag=$result2['FLAGID'];
			$flagtxt=$result2['FLAGDATA'];
			$id = $result2['TABID'];
			$reject_flag_text[$id][$flag] = $flagtxt;
		}
		
		
		$sqlusr = "select GLUSR_USR_ID, GLUSR_USR_FIRSTNAME, GLUSR_USR_LASTNAME, GLUSR_USR_EMAIL, GLUSR_USR_COMPANYNAME, 
		GLUSR_USR_CITY, GLUSR_USR_COUNTRYNAME from glusr_usr where GLUSR_USR_ID= :GL_USR_ID";
		
		$stat=$dbh->createCommand($sqlusr);
		$stat->bindValue(':GL_USR_ID',$usr_id);
		$dataReader=$stat->query();
		$result3 = $dataReader->readAll();
	/*echo "result-->";print_r($result3);exit;*/
		
		$glusr_usr_id = !empty($result3[0]['GLUSR_USR_ID']) ? $result3[0]['GLUSR_USR_ID'] :0;
		$glusr_fname = !empty($result3[0]['GLUSR_USR_FIRSTNAME']) ? $result3[0]['GLUSR_USR_FIRSTNAME']:'';
		$glusr_mname = '';
		$glusr_lname = !empty($result3[0]['GLUSR_USR_LASTNAME']) ? $result3[0]['GLUSR_USR_LASTNAME']:'';
		$glusr_email = !empty($result3[0]['GLUSR_USR_EMAIL']) ? $result3[0]['GLUSR_USR_EMAIL']:'';
		$glusr_company = !empty($result3[0]['GLUSR_USR_COMPANYNAME']) ? $result3[0]['GLUSR_USR_COMPANYNAME']:'';
		$glusr_city = !empty($result3[0]['GLUSR_USR_CITY']) ? $result3[0]['GLUSR_USR_CITY']:'';
		$glusr_country = !empty($result3[0]['GLUSR_USR_COUNTRYNAME']) ? $result3[0]['GLUSR_USR_COUNTRYNAME']:'';
		
		
			
		
		
		echo '
			<style>
			td.space
			{
				padding-left:1%;
				padding-right:1%;
			}
			td.space1
			{
				padding:.5% 1%;
			}
			</style>

			<br><br>
			<table width="65%" align="center" border="1 solid" cellspacing="0" cellpadding="1" style="font-size:15px;">
			<tr>
			<td class="space"><b>GLUSER USER ID</b></td>
			<td class="space">'.$glusr_usr_id.'</td>
			<td class="space"><b>NAME</b></td>
			<td class="space">'.$glusr_fname.' '.$glusr_mname.' '.$glusr_lname.'</td>
			</tr>
			<tr>
			<td class="space"><b>EMAIL ID</b></td>
			<td class="space">'.$glusr_email.'</td>
			<td class="space"><b>COMPANY NAME</b></td>
			<td class="space">'.$glusr_company.'</td>
			</tr>
			<tr>
			<td class="space"><b>CITY</b></td>
			<td class="space">'.$glusr_city.'</td>
			<td class="space"><b>COUNTRY</b></td>
			<td class="space">'.$glusr_country.'</td>
			</tr>
			</table><br><br>
			<span id="cnt_lead" style="display:none">Total Lead: </span>';

$sqllb="SELECT ETO_OFR_ID,ETO_OFR_TITLE,ETO_OFR_DATE,ETO_OFR_DESC,FLAG,RN1,RN,PROCDATA,FK_GLUSR_USR_ID,GLUSR_USR_CITY,
GLUSR_USR_COUNTRYNAME,DECODE(NVL(GLUSR_USR_LOC_PREF,0),0,'',1,'Global',2,'India',3,'Foreign',4,'Local')LOCPREF
FROM 
(SELECT ETO_OFR_ID,ETO_OFR_TITLE,ETO_OFR_DATE,ETO_OFR_DESC,FLAG,ROW_NUMBER() OVER(PARTITION BY ETO_OFR_ID ORDER BY ETO_OFR_DATE)RN1, COUNT(1) OVER(PARTITION BY ETO_OFR_ID ORDER BY ETO_OFR_DATE)RN,PROCDATA,FK_GLUSR_USR_ID
FROM 
(SELECT DISTINCT ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TITLE,ETO_OFR_DATE,ETO_OFR_DESC,1 AS FLAG,-99 PROCDATA,ETO_OFR.FK_GLUSR_USR_ID
FROM 
    ETO_OFR
WHERE 
    ETO_OFR_TYP = 'B' 
    AND ETO_OFR_PREFERED_FK_GLUSR_ID = :USERID     
    AND ETO_OFR.FK_GLUSR_USR_ID<>:USERID
UNION
SELECT
    DISTINCT ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TITLE,ETO_OFR_DATE,ETO_OFR_DESC,2 AS FLAG,
    (
	SELECT ETO_REJECTION_MASTER_FLAG FROM ETO_REJECTION_MASTER 
  	WHERE ETO_REJECTION_MASTER_USER_ID=:USERID AND ETO_REJECTION_MASTER_LEAD_ID=ETO_OFR_DISPLAY_ID)PROCDATA,ETO_OFR.FK_GLUSR_USR_ID
FROM
    ETO_OFR, ETO_OFR_MAPPING, GLUSR_USR,
    (SELECT DISTINCT FK_GLCAT_MCAT_ID MYID
        FROM
            GLCAT_MCAT,ETO_TRD_ALERT_V2
        WHERE
            FK_GLUSR_USR_ID = :USERID
            AND ETO_TRD_ALERT_V2.FK_GLCAT_MCAT_ID = GLCAT_MCAT.GLCAT_MCAT_ID 
            AND ETO_TRD_ALERT_DISABLED_BY IS NULL
    ) ETO_MCATS
WHERE
    ETO_OFR_TYP = 'B' AND 
    ETO_OFR.ETO_OFR_APPROV = 'A' AND 
    ETO_OFR.ETO_OFR_DISPLAY_ID =ETO_OFR_MAPPING.FK_ETO_OFR_ID
    AND ETO_OFR_MAPPING.FK_GLCAT_MCAT_ID = MYID
  AND TRUNC(SYSDATE) - TRUNC(ETO_OFR_DATE) <= 30
    AND GLUSR_USR.GLUSR_USR_ID = ETO_OFR.FK_GLUSR_USR_ID
UNION
SELECT 
    DISTINCT ETO_OFR_DISPLAY_ID ETO_OFR_ID,
    ETO_OFR_TITLE,
    ETO_OFR_DATE,
    ETO_OFR_DESC,
    3 AS FLAG,
    ETO_LEADSUPMAP_PROCESSED PROCDATA,ETO_OFR.FK_GLUSR_USR_ID
FROM
        ETO_LEAD_SUPPLIER_MAPPING,
        ETO_OFR 
WHERE 
        ETO_OFR_TYP = 'B'AND 
        ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID 
        AND ETO_LEAD_SUPPLIER_MAPPING.FK_GLUSR_USR_ID = :USERID    
        AND ETO_OFR.ETO_OFR_APPROV = 'A' 
        AND ETO_OFR.ETO_OFR_PREFERED_FK_GLUSR_ID IS NULL
        AND TRUNC(SYSDATE) - TRUNC(ETO_OFR_DATE) <= 30 
        AND ETO_OFR.FK_GLUSR_USR_ID<>:USERID
)A
)B,GLUSR_USR
WHERE RN1=1
AND FK_GLUSR_USR_ID=GLUSR_USR_ID
ORDER BY ETO_OFR_DATE DESC";
//echo $sqllb;
$sth=$dbh->createCommand($sqllb);

$sth->bindValue(':USERID',$usr_id);

$dataReader=$sth->query();
//print_r($sth);exit;
$result1=$dataReader->readAll();
//echo "offer";print_r($result1);
echo '<table border="1" width="110%" cellpadding="1" cellspacing="1" align="CENTER" border-color="#f8f8f8" style="border-collapse:collapse;"><tr style="font-size:14px;background-color:#f0f9ff;font-weight:bold;"><td class="space1">S.No.</td><td class="space1">OFFER ID</td><td class="space1">COMMENT</td><td class="space1">OFFER TITLE</td><td class="space1">OFFER DATE</td><td class="space1">CITY</td><td class="space1">COUNTRY</td><td class="space1">LOCATION PREFERENCE</td><td class="space1" width="15%">MAPPED MCAT</td><td class="space1">OFFER DESCRIPTION</td></tr>';

//$hashcol={1=>'bgcolor="#fff"',2=>'bgcolor="#B5EAAA"'};
$commnetcol=array(1=>'PREFERRED',2=>'MAPPING',3=>'LEAD SUPPLIER');
$cnt=0;
foreach($result1 as $result)
{
$cnt++;
$flagcol='';
$flagcolspan='';
$flagva=$result['FLAG'];
$flagva1=$result['RN'];
$procdata=$result['PROCDATA'];
$eto_ofr_id=$result['ETO_OFR_ID'];

	$sql_mcat =
	"SELECT	LISTAGG (GLCAT_MCAT_NAME,', ') WITHIN GROUP (ORDER BY FK_GLCAT_MCAT_ID) MAPPEDMCAT
	FROM
	ETO_OFR_MAPPING, GLCAT_CAT, GLCAT_MCAT, GLCAT_GRP
	WHERE
	GLCAT_CAT_ID = FK_GLCAT_CAT_ID
	AND FK_GLCAT_GRP_ID = GLCAT_GRP_ID
	AND GLCAT_MCAT_ID(+) = FK_GLCAT_MCAT_ID
	AND FK_ETO_OFR_ID = $eto_ofr_id";
	$sth_mcat = $dbh->createCommand($sql_mcat);
	$dataReader=$sth_mcat->query();
	$rslt_mcat = $dataReader->readAll();
	//echo "rslt_mcat";print_r($rslt_mcat);
	$mapped_mcat = $rslt_mcat[0]['MAPPEDMCAT'];


if(($flagva==2 || $flagva==3) && !empty($procdata))
{
// this condition will be reviewed later on
	$flagcol='bgcolor="#FFE4E4"';
	$flagcolspan='<span style="font-size:10px;color:#ff0000">'.$reject_flag_text[$flagva][$procdata].'</span>';
 }
	echo '<tr style="font-size:13px;" '.$flagcol.'><td class="space1">'.$cnt.'</td><td class="space1">'.$eto_ofr_id.'</td>';	
	echo '<td class="space1">'.$commnetcol[$flagva].'<br>'.$flagcolspan.'</td>';
	echo '<td class="space1">'.$result['ETO_OFR_TITLE'].'</td><td    	 class="space1">'.$result['ETO_OFR_DATE'].'</td><td class="space1">'.$result['GLUSR_USR_CITY'].'</td><td class="space1">'.$result['GLUSR_USR_COUNTRYNAME'].'</td><td class="space1">'.$result['LOCPREF'].'</td>
		<td class="space1" width="15%">'.$mapped_mcat.'</td><td  class="space1" style="font-size:12px">'.$result['ETO_OFR_DESC'].'</td></tr>';
}
echo '</table>';

echo "<script>
document.getElementById('cnt_lead').style.display='block';
document.getElementById('cnt_lead').innerHTML =\"<b>Total Count :</b> \"+$cnt+\"<br><br>\";
</script>";


	}
}
?>