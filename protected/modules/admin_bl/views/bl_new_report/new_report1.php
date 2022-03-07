<?php 

echo '<html>
      <body>
      <table border="1" width="100%">
      ';
 echo '<tr>
      <td>IIL_ENQUIRY_INTEREST_ID</td>
      <td>IIL_ENQ_INTEREST_DATE</td>
      <td>INTEREST_RCV_GLUSR_ID</td>
      <td>INTEREST_SENDER_GLUSR_ID</td>
      <td>IIL_ENQ_INTEREST_MODID</td>
      <td>IIL_ENQ_INTEREST_MODREFID</td>
      <td>IIL_ENQ_INTEREST_MODREFNAME</td>
      <td>IIL_ENQ_INTEREST_MODREFTYP</td>
      <td>IIL_ENQ_SENDER_IP</td>
      <td>IIL_ENQ_SENDER_IP_COUNTRY</td>
      <td>IIL_ENQ_SENDER_IP_CNTR_ISO</td>
      <td>IIL_ENQ_CURRENT_URL</td>
      <td>FK_INTEREST_TYPE_ID</td>
      <td>IIL_ENQ_INTEREST_TYPE</td>
      <td>IIL_ENQ_INTEREST_FENQ_STATUS</td>
      <td>IIL_ENQ_INTEREST_FENQ_ID</td>
      <td>IIL_ENQ_INTEREST_PDATE</td>
      </tr>';
     

while($rec=oci_fetch_array($sth,OCI_BOTH))
{
$rec['IIL_ENQUIRY_INTEREST_ID']=isset($rec['IIL_ENQUIRY_INTEREST_ID']) ? $rec['IIL_ENQUIRY_INTEREST_ID'] : '';
$rec['IIL_ENQ_INTEREST_DATE']=isset($rec['IIL_ENQ_INTEREST_DATE']) ? $rec['IIL_ENQ_INTEREST_DATE'] : '';
$rec['INTEREST_RCV_GLUSR_ID']=isset($rec['INTEREST_RCV_GLUSR_ID']) ? $rec['INTEREST_RCV_GLUSR_ID'] : '';
$rec['INTEREST_SENDER_GLUSR_ID']=isset($rec['INTEREST_SENDER_GLUSR_ID']) ? $rec['INTEREST_SENDER_GLUSR_ID'] : '';
$rec['IIL_ENQ_INTEREST_MODID']=isset($rec['IIL_ENQ_INTEREST_MODID']) ? $rec['IIL_ENQ_INTEREST_MODID'] : '';
$rec['IIL_ENQ_INTEREST_MODREFID']=isset($rec['IIL_ENQ_INTEREST_MODREFID']) ? $rec['IIL_ENQ_INTEREST_MODREFID'] : '';
$rec['IIL_ENQ_INTEREST_MODREFNAME']=isset($rec['IIL_ENQ_INTEREST_MODREFNAME']) ? $rec['IIL_ENQ_INTEREST_MODREFNAME'] : '';
$rec['IIL_ENQ_INTEREST_MODREFTYP']=isset($rec['IIL_ENQ_INTEREST_MODREFTYP']) ? $rec['IIL_ENQ_INTEREST_MODREFTYP'] : '';
$rec['IIL_ENQ_SENDER_IP']=isset($rec['IIL_ENQ_SENDER_IP']) ? $rec['IIL_ENQ_SENDER_IP'] : '';
$rec['IIL_ENQ_CURRENT_URL']=isset($rec['IIL_ENQ_CURRENT_URL']) ? $rec['IIL_ENQ_CURRENT_URL'] : '';
$rec['FK_INTEREST_TYPE_ID']=isset($rec['FK_INTEREST_TYPE_ID']) ? $rec['FK_INTEREST_TYPE_ID'] : '';
$rec['IIL_ENQ_INTEREST_TYPE']=isset($rec['IIL_ENQ_INTEREST_TYPE']) ? $rec['IIL_ENQ_INTEREST_TYPE'] : '';
$rec['IIL_ENQ_INTEREST_FENQ_STATUS']=isset($rec['IIL_ENQ_INTEREST_FENQ_STATUS']) ? $rec['IIL_ENQ_INTEREST_FENQ_STATUS'] : '';
$rec['IIL_ENQ_INTEREST_FENQ_ID']=isset($rec['IIL_ENQ_INTEREST_FENQ_ID']) ? $rec['IIL_ENQ_INTEREST_FENQ_ID'] : '';
$rec['IIL_ENQ_INTEREST_PDATE']=isset($rec['IIL_ENQ_INTEREST_PDATE']) ? $rec['IIL_ENQ_INTEREST_PDATE'] : '';
$rec['IIL_ENQ_SENDER_IP_COUNTRY']=isset($rec['IIL_ENQ_SENDER_IP_COUNTRY']) ? $rec['IIL_ENQ_SENDER_IP_COUNTRY'] : '';
$rec['IIL_ENQ_SENDER_IP_CNTR_ISO']=isset($rec['IIL_ENQ_SENDER_IP_CNTR_ISO']) ? $rec['IIL_ENQ_SENDER_IP_CNTR_ISO'] : '';
echo '<tr>
      <td>'.$rec['IIL_ENQUIRY_INTEREST_ID'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_DATE'].'</td>
      <td>'.$rec['INTEREST_RCV_GLUSR_ID'].'</td>
      <td>'.$rec['INTEREST_SENDER_GLUSR_ID'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_MODID'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_MODREFID'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_MODREFNAME'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_MODREFTYP'].'</td>
      <td>'.$rec['IIL_ENQ_SENDER_IP'].'</td>
      <td>'.$rec['IIL_ENQ_SENDER_IP_COUNTRY'].'</td>
      <td>'.$rec['IIL_ENQ_SENDER_IP_CNTR_ISO'].'</td>
      <td>'.$rec['IIL_ENQ_CURRENT_URL'].'</td>
      <td>'.$rec['FK_INTEREST_TYPE_ID'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_TYPE'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_FENQ_STATUS'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_FENQ_ID'].'</td>
      <td>'.$rec['IIL_ENQ_INTEREST_PDATE'].'</td>
      </tr>';

}
echo '</table>
      </body>
      </html>
      ';

?>