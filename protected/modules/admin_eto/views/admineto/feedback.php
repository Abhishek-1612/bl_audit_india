 <?php

echo '<div align="center"><b>Feedback Details</b></div></br>';
    echo '<table align="center" cellspacing="0" cellpadding="2" border="1"  width="100%" style="font-family: arial; font-size: 12px;">';
$i=0;
 while($value=oci_fetch_array($sth,OCI_BOTH))
 {     
     echo '<tr><td width="10%"><b>Offer ID</b></td><td width="90%">'.$value['BUYER_REQ_OVR_OFR_DISPLAY_ID'].'</td></tr>
         <tr><td width="10%"><b>Feedback Received Day</b></td><td width="90%">'.$value['BUYER_REQ_OVER_RECV_DAY'].'</td></tr>
         <tr><td width="10%"><b>Feedback Received Date</b></td><td width="90%">'.$value['BUYER_REQ_OVER_DATE'].'</td></tr>
         <tr><td width="10%"><b>Feedback Source</b></td><td width="90%">'.$value['FEEDBACK_RECEIVED_MEDIUM'].'</td></tr>
         <tr><td width="10%"><b>Feedback Mode</b></td><td width="90%">'.$value['FEEDBACK_RECEIVED_MODE'].'</td></tr>
         <tr><td width="10%"><b>Feedback</b></td><td width="90%">'.$value['FEEDBACK_RECEIVED'].'</td></tr>
         <tr><td width="10%"><b>Feedback Comments</b></td><td width="90%">'.$value['BUYER_REQ_OVR_POST_OTHR'].'</td></tr>
         <tr><td width="10%"><b>Supplier Selected</b></td><td width="90%">'.$value['SUPP_CONNECTED'].'</td></tr>    
         <tr><td width="10%"><b>NPS</b></td><td width="90%">'.$value['IIL_NPS_SCORE'].'</td></tr>
         <tr><td width="10%"><b>NPS Comment</b></td><td width="90%">'.$value['IIL_NPS_COMMENT'].'</td></tr>';
     $i=1;
}
if($i==0){
    echo '<tr><td align="center" width="100%" >No Feedback Received';
}
echo '</table> <br>';
?>
 
 
