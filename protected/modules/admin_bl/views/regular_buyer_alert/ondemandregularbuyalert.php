<?php 

if($report=='NOR'){
    
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
if($account==1)
{
        
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Monday";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Tuesday";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Wednesday";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Thursday";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Friday";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Saturday";

        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
        $i = 0;
        //print_r($value1);print_r($value2);
     
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        
        $i = 0;
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
 <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats -  Mcat mailers</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>
 
 <tr><td>Regular Buyer-Monday</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Tuesday</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Wednesday</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Thursday</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Friday</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-Saturday</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';                 
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4+ $delivered_sum5 + $delivered_sum6;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4+ $unique_opens_sum5 + $unique_opens_sum6;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4+ $unique_clicks_sum5 + $unique_clicks_sum6;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4+ $spamreports_sum5 + $spamreports_sum6;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4+ $unsubscribes_sum5 + $unsubscribes_sum6;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4+ $invalid_email_sum5 + $invalid_email_sum6;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4+ $bounces_sum5 + $bounces_sum6;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4+ $blocked_sum5 + $blocked_sum6;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 


                echo '</table>';
                
                
             // generic mails
                $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Monday-Gen";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Tuesday-Gen";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Wednesday-Gen";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Thursday-Gen";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Friday-Gen";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Saturday-Gen";

        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
        $i = 0;
        //print_r($value1);print_r($value2);
        echo '</table>';
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        
        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats -  Generic mailers</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-Monday-Gen</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Tuesday-Gen</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Wednesday-Gen</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Thursday-Gen</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Friday-Gen</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-Saturday-Gen</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4+ $delivered_sum5 + $delivered_sum6;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4+ $unique_opens_sum5 + $unique_opens_sum6;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4+ $unique_clicks_sum5 + $unique_clicks_sum6;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4+ $spamreports_sum5 + $spamreports_sum6;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4+ $unsubscribes_sum5 + $unsubscribes_sum6;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4+ $invalid_email_sum5 + $invalid_email_sum6;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4+ $bounces_sum5 + $bounces_sum6;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4+ $blocked_sum5 + $blocked_sum6;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 
                echo '</table>';
    // generic mails
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00am";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-10:30am";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-1:00pm";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-4:00pm";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-6:00pm";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-7:00pm";
        $sendgrid_json7 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00pm";
        $sendgrid_json8 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-9:00pm";
                
        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
         $json7 = file_get_contents($sendgrid_json7, false, $context);
        $value7 = json_decode($json7);
        
         $json8 = file_get_contents($sendgrid_json8, false, $context);
        $value8 = json_decode($json8);
        
        
        $i = 0;
        //print_r($value1);print_r($value2);
        echo '</table>';
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        $req_sum7 = 0;
        $delivered_sum7 = 0;
        $unique_opens_sum7 = 0;
        $unsubscribes_sum7 = 0;
        $bounces_sum7 = 0;
        $spamreports_sum7 = 0;
        $invalid_email_sum7 = 0;
        $unique_clicks_sum7 = 0;
        $blocked_sum7=0;
        
        $req_sum8 = 0;
        $delivered_sum8 = 0;
        $unique_opens_sum8 = 0;
        $unsubscribes_sum8 = 0;
        $bounces_sum8 = 0;
        $spamreports_sum8 = 0;
        $invalid_email_sum8 = 0;
        $unique_clicks_sum8 = 0;
        $blocked_sum8=0;
        
        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats - Mcat mailers [Time slots wise]</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-8:00am</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-10:30am</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-1:00pm</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-4:00pm</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-6:00pm</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-7:00pm</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';
                
  for ($i = 0; $i < $length; $i++) {
            $req = $value7[$i]->requests ;
            $delivered = $value7[$i]->delivered;
            $unique_opens =$value7[$i]->unique_opens;
            $unsubscribes = $value7[$i]->unsubscribes;
            $bounces = $value7[$i]->bounces;
            $spamreports = $value7[$i]->spamreports;
            $invalid_email = $value7[$i]->invalid_email;
            $unique_clicks = $value7[$i]->unique_clicks;
            $blocked = $value7[$i]->bounces;

            $req_sum7= $req_sum7 + $req;
            $delivered_sum7 = $delivered_sum7 + $delivered;
            $unique_opens_sum7 = $unique_opens_sum7 + $unique_opens;
            $unsubscribes_sum7 = $unsubscribes_sum7 + $unsubscribes;
            $bounces_sum7 = $bounces_sum7 + $bounces;
            $spamreports_sum7 = $spamreports_sum7 + $spamreports;
            $invalid_email_sum7 = $invalid_email_sum7 + $invalid_email;
            $unique_clicks_sum7 = $unique_clicks_sum7 + $unique_clicks;
            $blocked_sum7= $blocked_sum7 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-8:00pm</td><td>' . $req_sum7 . ' </td><td>' .$delivered_sum7 . '</td>
		<td>' . $unique_opens_sum7 . '</td><td>' . $unique_clicks_sum7  . '</td>
		<td>' . $spamreports_sum7  . '</td><td>' . $blocked_sum7 . '</td>
                <td>' . $unsubscribes_sum7. '</td><td>' . $invalid_email_sum7. '</td>
                <td>' . $bounces_sum7 . '</td></tr>';
                
   for ($i = 0; $i < $length; $i++) {
            $req = $value8[$i]->requests ;
            $delivered = $value8[$i]->delivered;
            $unique_opens =$value8[$i]->unique_opens;
            $unsubscribes = $value8[$i]->unsubscribes;
            $bounces = $value8[$i]->bounces;
            $spamreports = $value8[$i]->spamreports;
            $invalid_email = $value8[$i]->invalid_email;
            $unique_clicks = $value8[$i]->unique_clicks;
            $blocked = $value8[$i]->bounces;

            $req_sum8= $req_sum8 + $req;
            $delivered_sum8 = $delivered_sum8 + $delivered;
            $unique_opens_sum8 = $unique_opens_sum8 + $unique_opens;
            $unsubscribes_sum8 = $unsubscribes_sum8 + $unsubscribes;
            $bounces_sum8 = $bounces_sum8 + $bounces;
            $spamreports_sum8 = $spamreports_sum8 + $spamreports;
            $invalid_email_sum8 = $invalid_email_sum8 + $invalid_email;
            $unique_clicks_sum8 = $unique_clicks_sum8 + $unique_clicks;
            $blocked_sum8= $blocked_sum8 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-9:00pm</td><td>' . $req_sum8 . ' </td><td>' .$delivered_sum8 . '</td>
		<td>' . $unique_opens_sum8 . '</td><td>' . $unique_clicks_sum8  . '</td>
		<td>' . $spamreports_sum8  . '</td><td>' . $blocked_sum8 . '</td>
                <td>' . $unsubscribes_sum8. '</td><td>' . $invalid_email_sum8. '</td>
                <td>' . $bounces_sum8 . '</td></tr>';               
                
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4 + $delivered_sum5 + $delivered_sum6 + $delivered_sum7 + $delivered_sum8;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4 + $unique_opens_sum5 + $unique_opens_sum6 + $unique_opens_sum7 + $unique_opens_sum8;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4 + $unique_clicks_sum5 + $unique_clicks_sum6 + $unique_clicks_sum7 + $unique_clicks_sum8;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4+ $spamreports_sum5 + $spamreports_sum6 + $spamreports_sum7 + $spamreports_sum8;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4 + $unsubscribes_sum5 + $unsubscribes_sum6 + $unsubscribes_sum7 + $unsubscribes_sum8;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4 + $invalid_email_sum5 + $invalid_email_sum6 + $invalid_email_sum7 + $invalid_email_sum8;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4 + $bounces_sum5 + $bounces_sum6 + $bounces_sum7+ $bounces_sum8;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4 + $blocked_sum5 + $blocked_sum6 + $blocked_sum7 + $blocked_sum8;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 
                echo '</table>';

                
    // generic time slot mails
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00am-Gen";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-10:30am-Gen";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-1:00pm-Gen";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-4:00pm-Gen";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-6:00pm-Gen";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-7:00pm-Gen";
        $sendgrid_json7 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00pm-Gen";
        $sendgrid_json8 = "https://api.sendgrid.com/api/stats.get.json?api_user=emailmrktg@indiamart.com&api_key=motherindia19&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-9:00pm-Gen";
                
        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
         $json7 = file_get_contents($sendgrid_json7, false, $context);
        $value7 = json_decode($json7);
        
         $json8 = file_get_contents($sendgrid_json8, false, $context);
        $value8 = json_decode($json8);
        
        
        $i = 0;
        //print_r($value1);print_r($value2);
        echo '</table>';
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        
        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats - Generic mailers [Time slots wise]</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-8:00am-Gen</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-10:30am-Gen</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-1:00pm-Gen</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-4:00pm-Gen</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-6:00pm-Gen</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-7:00pm-Gen</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';
                
  for ($i = 0; $i < $length; $i++) {
            $req = $value7[$i]->requests ;
            $delivered = $value7[$i]->delivered;
            $unique_opens =$value7[$i]->unique_opens;
            $unsubscribes = $value7[$i]->unsubscribes;
            $bounces = $value7[$i]->bounces;
            $spamreports = $value7[$i]->spamreports;
            $invalid_email = $value7[$i]->invalid_email;
            $unique_clicks = $value7[$i]->unique_clicks;
            $blocked = $value7[$i]->bounces;

            $req_sum7= $req_sum7 + $req;
            $delivered_sum7 = $delivered_sum7 + $delivered;
            $unique_opens_sum7 = $unique_opens_sum7 + $unique_opens;
            $unsubscribes_sum7 = $unsubscribes_sum7 + $unsubscribes;
            $bounces_sum7 = $bounces_sum7 + $bounces;
            $spamreports_sum7 = $spamreports_sum7 + $spamreports;
            $invalid_email_sum7 = $invalid_email_sum7 + $invalid_email;
            $unique_clicks_sum7 = $unique_clicks_sum7 + $unique_clicks;
            $blocked_sum7= $blocked_sum7 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-8:00pm-Gen</td><td>' . $req_sum7 . ' </td><td>' .$delivered_sum7 . '</td>
		<td>' . $unique_opens_sum7 . '</td><td>' . $unique_clicks_sum7  . '</td>
		<td>' . $spamreports_sum7  . '</td><td>' . $blocked_sum7 . '</td>
                <td>' . $unsubscribes_sum7. '</td><td>' . $invalid_email_sum7. '</td>
                <td>' . $bounces_sum7 . '</td></tr>';
                
                
  for ($i = 0; $i < $length; $i++) {
            $req = $value8[$i]->requests ;
            $delivered = $value8[$i]->delivered;
            $unique_opens =$value8[$i]->unique_opens;
            $unsubscribes = $value8[$i]->unsubscribes;
            $bounces = $value8[$i]->bounces;
            $spamreports = $value8[$i]->spamreports;
            $invalid_email = $value8[$i]->invalid_email;
            $unique_clicks = $value8[$i]->unique_clicks;
            $blocked = $value8[$i]->bounces;

            $req_sum8= $req_sum8 + $req;
            $delivered_sum8 = $delivered_sum8 + $delivered;
            $unique_opens_sum8 = $unique_opens_sum8 + $unique_opens;
            $unsubscribes_sum8 = $unsubscribes_sum8 + $unsubscribes;
            $bounces_sum8 = $bounces_sum8 + $bounces;
            $spamreports_sum8 = $spamreports_sum8 + $spamreports;
            $invalid_email_sum8 = $invalid_email_sum8 + $invalid_email;
            $unique_clicks_sum8 = $unique_clicks_sum8 + $unique_clicks;
            $blocked_sum8= $blocked_sum8 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-9:00pm-Gen</td><td>' . $req_sum8 . ' </td><td>' .$delivered_sum8 . '</td>
		<td>' . $unique_opens_sum8 . '</td><td>' . $unique_clicks_sum8  . '</td>
		<td>' . $spamreports_sum8  . '</td><td>' . $blocked_sum8 . '</td>
                <td>' . $unsubscribes_sum8. '</td><td>' . $invalid_email_sum8. '</td>
                <td>' . $bounces_sum8 . '</td></tr>';                
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6 + $req_sum7 + $req_sum8;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4 + $delivered_sum5 + $delivered_sum6 + $delivered_sum7 + $delivered_sum8;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4 + $unique_opens_sum5 + $unique_opens_sum6 + $unique_opens_sum7 + $unique_opens_sum8;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4 + $unique_clicks_sum5 + $unique_clicks_sum6 + $unique_clicks_sum7 + $unique_clicks_sum8;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4 + $spamreports_sum5 + $spamreports_sum6 + $spamreports_sum7 + $spamreports_sum8;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4 + $unsubscribes_sum5 + $unsubscribes_sum6 + $unsubscribes_sum7 + $unsubscribes_sum8;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4 + $invalid_email_sum5 + $invalid_email_sum6 + $invalid_email_sum7 + $invalid_email_sum8;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4 + $bounces_sum5 + $bounces_sum6 + $bounces_sum7 + $bounces_sum8;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4 + $blocked_sum5 + $blocked_sum6 + $blocked_sum7 + $blocked_sum8;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 
                echo '</table>';  
                
                
                }
      if($account ==2) {
      
      // Sendgrid Account 2
                
     
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Monday";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Tuesday";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Wednesday";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Thursday";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Friday";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Saturday";

        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
        $i = 0;
        //print_r($value1);print_r($value2);
    
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        
        $i = 0;

      
            
           echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats -  Mcat mailers</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-Monday</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Tuesday</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Wednesday</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Thursday</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Friday</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-Saturday</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';                 
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4+ $delivered_sum5 + $delivered_sum6;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4+ $unique_opens_sum5 + $unique_opens_sum6;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4+ $unique_clicks_sum5 + $unique_clicks_sum6;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4+ $spamreports_sum5 + $spamreports_sum6;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4+ $unsubscribes_sum5 + $unsubscribes_sum6;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4+ $invalid_email_sum5 + $invalid_email_sum6;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4+ $bounces_sum5 + $bounces_sum6;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4+ $blocked_sum5 + $blocked_sum6;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 


                echo '</table>';
                
                
  // generic mails
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Monday-Gen";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Tuesday-Gen";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Wednesday-Gen";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Thursday-Gen";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Friday-Gen";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-Saturday-Gen";

        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
        $i = 0;
        //print_r($value1);print_r($value2);
        echo '</table>';
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        
        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats -  Generic mailers</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-Monday-Gen</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Tuesday-Gen</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Wednesday-Gen</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Thursday-Gen</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-Friday-Gen</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-Saturday-Gen</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4+ $delivered_sum5 + $delivered_sum6;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4+ $unique_opens_sum5 + $unique_opens_sum6;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4+ $unique_clicks_sum5 + $unique_clicks_sum6;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4+ $spamreports_sum5 + $spamreports_sum6;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4+ $unsubscribes_sum5 + $unsubscribes_sum6;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4+ $invalid_email_sum5 + $invalid_email_sum6;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4+ $bounces_sum5 + $bounces_sum6;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4+ $blocked_sum5 + $blocked_sum6;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 
                echo '</table>';
    // generic mails
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00am";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-10:30am";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-1:00pm";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-4:00pm";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-6:00pm";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-7:00pm";
        $sendgrid_json7 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00pm";
        $sendgrid_json8 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-9:00pm";
                
        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
         $json7 = file_get_contents($sendgrid_json7, false, $context);
        $value7 = json_decode($json7);
        
         $json8 = file_get_contents($sendgrid_json8, false, $context);
        $value8 = json_decode($json8);
        
        
        $i = 0;
        //print_r($value1);print_r($value2);
        echo '</table>';
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        $req_sum7 = 0;
        $delivered_sum7 = 0;
        $unique_opens_sum7 = 0;
        $unsubscribes_sum7 = 0;
        $bounces_sum7 = 0;
        $spamreports_sum7 = 0;
        $invalid_email_sum7 = 0;
        $unique_clicks_sum7 = 0;
        $blocked_sum7=0;
        
        $req_sum8 = 0;
        $delivered_sum8 = 0;
        $unique_opens_sum8 = 0;
        $unsubscribes_sum8 = 0;
        $bounces_sum8 = 0;
        $spamreports_sum8 = 0;
        $invalid_email_sum8 = 0;
        $unique_clicks_sum8 = 0;
        $blocked_sum8=0;
        
        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats - Mcat mailers [Time slots wise]</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-8:00am</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-10:30am</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-1:00pm</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-4:00pm</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-6:00pm</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-7:00pm</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';
                
  for ($i = 0; $i < $length; $i++) {
            $req = $value7[$i]->requests ;
            $delivered = $value7[$i]->delivered;
            $unique_opens =$value7[$i]->unique_opens;
            $unsubscribes = $value7[$i]->unsubscribes;
            $bounces = $value7[$i]->bounces;
            $spamreports = $value7[$i]->spamreports;
            $invalid_email = $value7[$i]->invalid_email;
            $unique_clicks = $value7[$i]->unique_clicks;
            $blocked = $value7[$i]->bounces;

            $req_sum7= $req_sum7 + $req;
            $delivered_sum7 = $delivered_sum7 + $delivered;
            $unique_opens_sum7 = $unique_opens_sum7 + $unique_opens;
            $unsubscribes_sum7 = $unsubscribes_sum7 + $unsubscribes;
            $bounces_sum7 = $bounces_sum7 + $bounces;
            $spamreports_sum7 = $spamreports_sum7 + $spamreports;
            $invalid_email_sum7 = $invalid_email_sum7 + $invalid_email;
            $unique_clicks_sum7 = $unique_clicks_sum7 + $unique_clicks;
            $blocked_sum7= $blocked_sum7 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-8:00pm</td><td>' . $req_sum7 . ' </td><td>' .$delivered_sum7 . '</td>
		<td>' . $unique_opens_sum7 . '</td><td>' . $unique_clicks_sum7  . '</td>
		<td>' . $spamreports_sum7  . '</td><td>' . $blocked_sum7 . '</td>
                <td>' . $unsubscribes_sum7. '</td><td>' . $invalid_email_sum7. '</td>
                <td>' . $bounces_sum7 . '</td></tr>';
                
   for ($i = 0; $i < $length; $i++) {
            $req = $value8[$i]->requests ;
            $delivered = $value8[$i]->delivered;
            $unique_opens =$value8[$i]->unique_opens;
            $unsubscribes = $value8[$i]->unsubscribes;
            $bounces = $value8[$i]->bounces;
            $spamreports = $value8[$i]->spamreports;
            $invalid_email = $value8[$i]->invalid_email;
            $unique_clicks = $value8[$i]->unique_clicks;
            $blocked = $value8[$i]->bounces;

            $req_sum8= $req_sum8 + $req;
            $delivered_sum8 = $delivered_sum8 + $delivered;
            $unique_opens_sum8 = $unique_opens_sum8 + $unique_opens;
            $unsubscribes_sum8 = $unsubscribes_sum8 + $unsubscribes;
            $bounces_sum8 = $bounces_sum8 + $bounces;
            $spamreports_sum8 = $spamreports_sum8 + $spamreports;
            $invalid_email_sum8 = $invalid_email_sum8 + $invalid_email;
            $unique_clicks_sum8 = $unique_clicks_sum8 + $unique_clicks;
            $blocked_sum8= $blocked_sum8 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-9:00pm</td><td>' . $req_sum8 . ' </td><td>' .$delivered_sum8 . '</td>
		<td>' . $unique_opens_sum8 . '</td><td>' . $unique_clicks_sum8  . '</td>
		<td>' . $spamreports_sum8  . '</td><td>' . $blocked_sum8 . '</td>
                <td>' . $unsubscribes_sum8. '</td><td>' . $invalid_email_sum8. '</td>
                <td>' . $bounces_sum8 . '</td></tr>';               
                
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4 + $delivered_sum5 + $delivered_sum6 + $delivered_sum7 + $delivered_sum8;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4 + $unique_opens_sum5 + $unique_opens_sum6 + $unique_opens_sum7 + $unique_opens_sum8;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4 + $unique_clicks_sum5 + $unique_clicks_sum6 + $unique_clicks_sum7 + $unique_clicks_sum8;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4+ $spamreports_sum5 + $spamreports_sum6 + $spamreports_sum7 + $spamreports_sum8;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4 + $unsubscribes_sum5 + $unsubscribes_sum6 + $unsubscribes_sum7 + $unsubscribes_sum8;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4 + $invalid_email_sum5 + $invalid_email_sum6 + $invalid_email_sum7 + $invalid_email_sum8;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4 + $bounces_sum5 + $bounces_sum6 + $bounces_sum7+ $bounces_sum8;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4 + $blocked_sum5 + $blocked_sum6 + $blocked_sum7 + $blocked_sum8;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 
                echo '</table>';

                
    // generic time slot mails
        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00am-Gen";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-10:30am-Gen";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-1:00pm-Gen";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-4:00pm-Gen";
        $sendgrid_json5 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-6:00pm-Gen";
        $sendgrid_json6 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-7:00pm-Gen";
        $sendgrid_json7 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-8:00pm-Gen";
        $sendgrid_json8 = "https://api.sendgrid.com/api/stats.get.json?api_user=marketing@indiamart.com&api_key=motherindia18&start_date=$start_date&end_date=$end_date&category=Regular%20Buyer-9:00pm-Gen";
                
        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
         $json5 = file_get_contents($sendgrid_json5, false, $context);
        $value5 = json_decode($json5);
        
         $json6 = file_get_contents($sendgrid_json6, false, $context);
        $value6 = json_decode($json6);
        
         $json7 = file_get_contents($sendgrid_json7, false, $context);
        $value7 = json_decode($json7);
        
         $json8 = file_get_contents($sendgrid_json8, false, $context);
        $value8 = json_decode($json8);
        
        
        $i = 0;
        //print_r($value1);print_r($value2);
        echo '</table>';
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

     $req_sum5 = 0;
        $delivered_sum5 = 0;
        $unique_opens_sum5 = 0;
        $unsubscribes_sum5 = 0;
        $bounces_sum5 = 0;
        $spamreports_sum5 = 0;
        $invalid_email_sum5 = 0;
        $unique_clicks_sum5 = 0;
        $blocked_sum5=0;
        
        $req_sum6 = 0;
        $delivered_sum6 = 0;
        $unique_opens_sum6 = 0;
        $unsubscribes_sum6 = 0;
        $bounces_sum6 = 0;
        $spamreports_sum6 = 0;
        $invalid_email_sum6 = 0;
        $unique_clicks_sum6 = 0;
        $blocked_sum6=0;
        
        
        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2">
           <tr><TD colspan=10 BGCOLOR="#CCCCFF"><B>Email Stats - Generic mailers [Time slots wise]</B></TD></tr>
                <tr><td><b>Mail Category</b></td>
                <td ><b>Sent </b></td><td><b>Delivered </b></td><td ><b>Unique Opens </b></td>
                <td ><b>Unique Clicks </b></td><td><b>Spam  </b></td>
                <td ><b>Blocked </b></td><td><b>Unsubscribes </b></td>
                <td ><b>Invalid Email </b></td><td><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td>Regular Buyer-8:00am-Gen</td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-10:30am-Gen</td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-1:00pm-Gen</td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-4:00pm-Gen</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

 for ($i = 0; $i < $length; $i++) {
            $req = $value5[$i]->requests ;
            $delivered = $value5[$i]->delivered;
            $unique_opens =$value5[$i]->unique_opens;
            $unsubscribes = $value5[$i]->unsubscribes;
            $bounces = $value5[$i]->bounces;
            $spamreports = $value5[$i]->spamreports;
            $invalid_email = $value5[$i]->invalid_email;
            $unique_clicks = $value5[$i]->unique_clicks;
            $blocked = $value5[$i]->bounces;

            $req_sum5 = $req_sum5 + $req;
            $delivered_sum5 = $delivered_sum5 + $delivered;
            $unique_opens_sum5 = $unique_opens_sum5 + $unique_opens;
            $unsubscribes_sum5 = $unsubscribes_sum5 + $unsubscribes;
            $bounces_sum5 = $bounces_sum5 + $bounces;
            $spamreports_sum5 = $spamreports_sum5 + $spamreports;
            $invalid_email_sum5 = $invalid_email_sum5 + $invalid_email;
            $unique_clicks_sum5 = $unique_clicks_sum5 + $unique_clicks;
            $blocked_sum5= $blocked_sum5 + $blocked;  
          
      }
                echo '<tr><td>Regular Buyer-6:00pm-Gen</td><td>' . $req_sum5 . ' </td><td>' .$delivered_sum5 . '</td>
		<td>' . $unique_opens_sum5 . '</td><td>' . $unique_clicks_sum5  . '</td>
		<td>' . $spamreports_sum5  . '</td><td>' . $blocked_sum5 . '</td>
                <td>' . $unsubscribes_sum5 . '</td><td>' . $invalid_email_sum5. '</td>
                <td>' . $bounces_sum5 . '</td></tr>'; 

                
                
 for ($i = 0; $i < $length; $i++) {
            $req = $value6[$i]->requests ;
            $delivered = $value6[$i]->delivered;
            $unique_opens =$value6[$i]->unique_opens;
            $unsubscribes = $value6[$i]->unsubscribes;
            $bounces = $value6[$i]->bounces;
            $spamreports = $value6[$i]->spamreports;
            $invalid_email = $value6[$i]->invalid_email;
            $unique_clicks = $value6[$i]->unique_clicks;
            $blocked = $value6[$i]->bounces;

            $req_sum6 = $req_sum6 + $req;
            $delivered_sum6 = $delivered_sum6 + $delivered;
            $unique_opens_sum6 = $unique_opens_sum6 + $unique_opens;
            $unsubscribes_sum6 = $unsubscribes_sum6 + $unsubscribes;
            $bounces_sum6 = $bounces_sum6 + $bounces;
            $spamreports_sum6 = $spamreports_sum6 + $spamreports;
            $invalid_email_sum6 = $invalid_email_sum6 + $invalid_email;
            $unique_clicks_sum6 = $unique_clicks_sum6 + $unique_clicks;
            $blocked_sum6= $blocked_sum6 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-7:00pm-Gen</td><td>' . $req_sum6 . ' </td><td>' .$delivered_sum6 . '</td>
		<td>' . $unique_opens_sum6 . '</td><td>' . $unique_clicks_sum6  . '</td>
		<td>' . $spamreports_sum6  . '</td><td>' . $blocked_sum6 . '</td>
                <td>' . $unsubscribes_sum6 . '</td><td>' . $invalid_email_sum6. '</td>
                <td>' . $bounces_sum6 . '</td></tr>';
                
  for ($i = 0; $i < $length; $i++) {
            $req = $value7[$i]->requests ;
            $delivered = $value7[$i]->delivered;
            $unique_opens =$value7[$i]->unique_opens;
            $unsubscribes = $value7[$i]->unsubscribes;
            $bounces = $value7[$i]->bounces;
            $spamreports = $value7[$i]->spamreports;
            $invalid_email = $value7[$i]->invalid_email;
            $unique_clicks = $value7[$i]->unique_clicks;
            $blocked = $value7[$i]->bounces;

            $req_sum7= $req_sum7 + $req;
            $delivered_sum7 = $delivered_sum7 + $delivered;
            $unique_opens_sum7 = $unique_opens_sum7 + $unique_opens;
            $unsubscribes_sum7 = $unsubscribes_sum7 + $unsubscribes;
            $bounces_sum7 = $bounces_sum7 + $bounces;
            $spamreports_sum7 = $spamreports_sum7 + $spamreports;
            $invalid_email_sum7 = $invalid_email_sum7 + $invalid_email;
            $unique_clicks_sum7 = $unique_clicks_sum7 + $unique_clicks;
            $blocked_sum7= $blocked_sum7 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-8:00pm-Gen</td><td>' . $req_sum7 . ' </td><td>' .$delivered_sum7 . '</td>
		<td>' . $unique_opens_sum7 . '</td><td>' . $unique_clicks_sum7  . '</td>
		<td>' . $spamreports_sum7  . '</td><td>' . $blocked_sum7 . '</td>
                <td>' . $unsubscribes_sum7. '</td><td>' . $invalid_email_sum7. '</td>
                <td>' . $bounces_sum7 . '</td></tr>';
                
                
  for ($i = 0; $i < $length; $i++) {
            $req = $value8[$i]->requests ;
            $delivered = $value8[$i]->delivered;
            $unique_opens =$value8[$i]->unique_opens;
            $unsubscribes = $value8[$i]->unsubscribes;
            $bounces = $value8[$i]->bounces;
            $spamreports = $value8[$i]->spamreports;
            $invalid_email = $value8[$i]->invalid_email;
            $unique_clicks = $value8[$i]->unique_clicks;
            $blocked = $value8[$i]->bounces;

            $req_sum8= $req_sum8 + $req;
            $delivered_sum8 = $delivered_sum8 + $delivered;
            $unique_opens_sum8 = $unique_opens_sum8 + $unique_opens;
            $unsubscribes_sum8 = $unsubscribes_sum8 + $unsubscribes;
            $bounces_sum8 = $bounces_sum8 + $bounces;
            $spamreports_sum8 = $spamreports_sum8 + $spamreports;
            $invalid_email_sum8 = $invalid_email_sum8 + $invalid_email;
            $unique_clicks_sum8 = $unique_clicks_sum8 + $unique_clicks;
            $blocked_sum8= $blocked_sum8 + $blocked;  
          
      }
                echo '<tr><td> Regular Buyer-9:00pm-Gen</td><td>' . $req_sum8 . ' </td><td>' .$delivered_sum8 . '</td>
		<td>' . $unique_opens_sum8 . '</td><td>' . $unique_clicks_sum8  . '</td>
		<td>' . $spamreports_sum8  . '</td><td>' . $blocked_sum8 . '</td>
                <td>' . $unsubscribes_sum8. '</td><td>' . $invalid_email_sum8. '</td>
                <td>' . $bounces_sum8 . '</td></tr>';                
                
$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4+ $req_sum5 + $req_sum6 + $req_sum7 + $req_sum8;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4 + $delivered_sum5 + $delivered_sum6 + $delivered_sum7 + $delivered_sum8;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4 + $unique_opens_sum5 + $unique_opens_sum6 + $unique_opens_sum7 + $unique_opens_sum8;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4 + $unique_clicks_sum5 + $unique_clicks_sum6 + $unique_clicks_sum7 + $unique_clicks_sum8;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4 + $spamreports_sum5 + $spamreports_sum6 + $spamreports_sum7 + $spamreports_sum8;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4 + $unsubscribes_sum5 + $unsubscribes_sum6 + $unsubscribes_sum7 + $unsubscribes_sum8;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4 + $invalid_email_sum5 + $invalid_email_sum6 + $invalid_email_sum7 + $invalid_email_sum8;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4 + $bounces_sum5 + $bounces_sum6 + $bounces_sum7 + $bounces_sum8;
$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4 + $blocked_sum5 + $blocked_sum6 + $blocked_sum7 + $blocked_sum8;

                echo '<tr><td width=200> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 
                echo '</table>';

      
      
      
      
      
      
      
      
      
      }
      
      }
      if($report =='REM'){
      
      
      if($sendgrid=='no'){
      
      if($request ==2)
      {
       $lead_sold=$rec6['UNIQ_LEAD_SOLD'];
       $total_transaction=$rec6['TOTAL_TRANSACTION'];
        
       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" BORDERCOLOR="black" width="100%" cellpadding="5" cellspacing="2">
              <tr><td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:13px;color:#000090;"><b>Total Transaction</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" ></TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Leads Sold</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $lead_sold . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Total Transaction</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $total_transaction . '</TD></tr>
                          </table>';
       
      
      }
      
      else
      {
      
       $tot_approved_15=$rec3['APPROVED_15'];
            $tot_approved_16=$rec3['APPROVED_16'];
            $tot_approved_17=$rec3['APPROVED_17'];
            $tot_approved_18=$rec3['APPROVED_18'];
            

            $tot_fenq_generated= $rec4['TOTAL_SEND_TO_FENQ'];
            $tot_generated= $rec3['TOTAL'];

            $tot_generated_15= $rec3['TOTAL_GEN_15'];
            $tot_generated_16= $rec3['TOTAL_GEN_16'];
            $tot_generated_17= $rec3['TOTAL_GEN_17'];
            $tot_generated_18= $rec3['TOTAL_GEN_18'];
            
            if($dbtype=='PG'){
                $rec_emktg1=pg_fetch_array($Rec_Regular);
                $rec_emktg1=array_change_key_case($rec_emktg1, CASE_UPPER);  
                $rec_emktg2=pg_fetch_array($Rec_re_activation);
                $rec_emktg2=array_change_key_case($rec_emktg2, CASE_UPPER);  
            }else{
                $rec_emktg1=oci_fetch_array($Rec_Regular,OCI_BOTH);
                $rec_emktg2=oci_fetch_array($Rec_re_activation,OCI_BOTH);
            }
            
          $tot_lead_generated=isset($rec_emktg1['REMKTG_GEN']) ? $rec_emktg1['REMKTG_GEN']: 0;
   
          
          
          $tot_lead_approved=isset($rec_emktg2['REMKTG_APPROVED']) ? $rec_emktg2['REMKTG_APPROVED'] : 0;
          
            $tot_app_notification= isset($rec9['TOTAL']) ? $rec9['TOTAL'] : '';
            $tot_app_notification_appr=isset($rec9['APPROVED']) ? $rec9['APPROVED'] : '';
             $UNIQUE_SENT_TO_DIR_QUERY_FREE=$rec10['UNIQUE_SENT_TO_DIR_QUERY_FREE'];
            $tot_generated_re=$tot_lead_generated + $UNIQUE_SENT_TO_DIR_QUERY_FREE+$tot_app_notification;
            
            
              $BL_INTENT_APP11=$rec10['APPROVED'];
            
//              $tot_lead_approved= $rec3['APPROVED'];
           $tot_fenq_approved = $rec4['APPROVED'];
           
          
           
           $tot_approved= $tot_lead_approved + $BL_INTENT_APP11+$tot_app_notification_appr ;

      
      echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" BORDERCOLOR="black" width="100%" cellpadding="5" cellspacing="2">
      <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;font-size:13px;color:#000090;" width="83%"><B>Total Generated</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_generated_re . '</TD></tr>
                            
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Leads Generated</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_lead_generated . '</TD></tr>
                            
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;Re1-Generic </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_generated_15 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;Re-MCAT </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_generated_16 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;BL-Gen </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_generated_17 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;Re2-MCAT </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_generated_18 . '</TD></tr>
                           


                          
                             <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL Intent Generated</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $UNIQUE_SENT_TO_DIR_QUERY_FREE . '</TD></tr>
                             <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;App Notification</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_app_notification . '</TD></tr>
                          

                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;font-size:13px;color:#000090;" ><B>Total  Approved</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_approved . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;Leads Approved</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' .  $tot_lead_approved . '</TD></tr>
                           <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;Re1-Generic </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_approved_15 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;Re-MCAT </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_approved_16 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;BL-Gen </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_approved_17 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;&nbsp;&nbsp;Re2-MCAT </b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" >' . $tot_approved_18 . '</TD></tr>
                          
 
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;BL Intent Approved</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $BL_INTENT_APP11 . '</TD></tr>
                            <tr><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:11px;" ><B>&nbsp;&nbsp;App Notification</b></td><TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >' . $tot_app_notification_appr . '</TD></tr>
                          </table>';
                          
                          }
                          
                          }
                          
                          if($sendgrid=='yes'){
                          
                          
		    
		    $start_date = date("Y-m-d", strtotime($start_date));
		    $end_date = date("Y-m-d", strtotime($end_date));
		    $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=rajkamal@indiamart.com&api_key=motherindia12&start_date=$start_date&end_date=$end_date&user=remktg-useractivity@indiamart.com&category=Re1-MCAT";
		    sendgrid_data($sendgrid_json1,$start_date,$end_date);
		    echo '<div>Category:Re1-Generic</div>';
		    $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=rajkamal@indiamart.com&api_key=motherindia12&start_date=$start_date&end_date=$end_date&user=remktg-useractivity@indiamart.com&category=Re1-Generic";
		    sendgrid_data($sendgrid_json2,$start_date,$end_date);
		    echo '<div>Category:Re2-MCAT</div>';
		    $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=rajkamal@indiamart.com&api_key=motherindia12&start_date=$start_date&end_date=$end_date&user=remktg-useractivity@indiamart.com&category=Re2-MCAT";
		    sendgrid_data($sendgrid_json3,$start_date,$end_date);
		    echo '<div>Category:csl-bl-gen</div>';
		    $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=rajkamal@indiamart.com&api_key=motherindia12&start_date=$start_date&end_date=$end_date&user=remktg-useractivity@indiamart.com&category=csl-bl-gen";
		    sendgrid_data($sendgrid_json4,$start_date,$end_date);
			    
                          }
      
      }
      
      if($report =='REACT'){
      
      if($sendgrid=='no'){
      
                $rec_enq=$rec1;
                $rec_user=$rec2;  
		$rec_direct_enq=$rec3;
                $rec_mail_spamreport=$rec8;
                $rec_mail_unsubscribe=$rec9;
                $rec_mail_bounce=$rec10;
                
                 $web_enq = !empty($rec_enq['WEB_ENQ_CNT']) ? $rec_enq['WEB_ENQ_CNT'] : 0;
        $pns_enq = !empty($rec_enq['PNS_ENQ_CNT']) ? $rec_enq['PNS_ENQ_CNT'] : 0;
        $bl_enq = !empty($rec_enq['PNS_ENQ_CNT']) ? $rec_enq['BL_ENQ_CNT'] : 0;
        $tot_enq =$web_enq + $pns_enq + $bl_enq;
       
        $web_enq_unq = !empty($rec_enq['WEB_ENQ_CNT']) ? $rec_enq['UNQ_WEB_ENQ_CNT'] : 0;
        $pns_enq_unq = !empty($rec_enq['PNS_ENQ_CNT']) ? $rec_enq['UNQ_PNS_ENQ_CNT'] : 0;
        $bl_enq_unq = !empty($rec_enq['PNS_ENQ_CNT']) ? $rec_enq['UNQ_BL_ENQ_CNT'] : 0;
        $tot_enq_unq =$web_enq_unq + $pns_enq_unq + $bl_enq_unq;
        
        $buyer_unq = !empty($rec_enq['UNQ_BYERS']) ? $rec_enq['UNQ_BYERS'] : 0;
        $first_time_buyer_unq = !empty($rec_enq['UNQ_FIRST_TIME_BYERS']) ? $rec_enq['UNQ_FIRST_TIME_BYERS'] : 0;
        
        $approved_user=!empty($rec_user['APPROV_CNT']) ? $rec_user['APPROV_CNT'] : 0;
        $disabled_user=!empty($rec_user['DISABLE_CNT']) ? $rec_user['DISABLE_CNT'] : 0;
        $total_user=$approved_user + $disabled_user;
        
        
        $gen_direct_enq=!empty($rec_direct_enq['TOTAL']) ? $rec_direct_enq['TOTAL'] : 0;
        $gen_direct_enq_in=!empty($rec_direct_enq['INDIAN']) ? $rec_direct_enq['INDIAN'] : 0;
        $gen_direct_enq_fr=!empty($rec_direct_enq['FORIGN']) ? $rec_direct_enq['FORIGN'] : 0;
        
        $spam_user=!empty($rec_mail_spamreport['CNT']) ? $rec_mail_spamreport['CNT'] : 0;
        
        
$unsubscribed_user=!empty($rec_mail_unsubscribe['CNT']) ?$rec_mail_unsubscribe['CNT'] : 0;
$bounced_user=!empty($rec_mail_bounce['CNT']) ? $rec_mail_bounce['CNT'] : 0;
$dropped_user=$bounced_user + $unsubscribed_user + $spam_user;

                
                            echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="0" width="100%" cellpadding="5" cellspacing="2">
                            <tr><td BGCOLOR="#CCCCFF" ALIGN="LEFT"><b>Unique Buyers:</b></td><td BGCOLOR="#CCCCFF">' . $buyer_unq . '</td></tr>

                            <tr><td BGCOLOR="#CCCCFF" ALIGN="LEFT"><b>Records with Sender ID Missing:</b></td><td BGCOLOR="#CCCCFF">' . $tot_enq . '</td></tr>
                            
			    <tr><td><B>&nbsp;&nbsp;Web Enquiry</B></td><td>' . $web_enq . '</td></tr>
			    <tr><td><B>&nbsp;&nbsp;PNS Enquiry</B></td><td>' . $pns_enq . '</td></tr>                                
			    <tr><td><B>&nbsp;&nbsp;BL Enquiry</B></td><td>' . $bl_enq . '</td></tr> 
                                
			    <tr><td BGCOLOR="#CCCCFF"><b>Unique Records with Sender ID Missing:</b></td><td BGCOLOR="#CCCCFF">' . $tot_enq_unq . '</td></tr>
			   <tr><td><B>&nbsp;&nbsp;Web Enquiry</B></td><td>' . $web_enq_unq . '</td></tr>
			    <tr><td><B>&nbsp;&nbsp;PNS Enquiry</B></td><td>' . $pns_enq_unq . '</td></tr>                                
			   <tr><td><B>&nbsp;&nbsp;BL Enquiry</B></td><td>' . $bl_enq_unq . '</td></tr>  


			   <tr><td BGCOLOR="#CCCCFF"><B>First time Buyer</B></td><td BGCOLOR="#CCCCFF">' . $first_time_buyer_unq . '</td></tr>
                          
			   <tr><TD BGCOLOR="#CCCCFF"><B>Dropped from Re-activation activity</B></td><td BGCOLOR="#CCCCFF">' . $dropped_user . '</td></tr>
                           <tr><td><B>&nbsp;&nbsp;Bounced</B></td><td>' . $bounced_user . '</td></tr>                                
                            <tr><td><B>&nbsp;&nbsp;Unsubscribed</B></td><td>' . $unsubscribed_user . '</td></tr> 
                            <tr><td><B>&nbsp;&nbsp;Spam</B></td><td>' . $spam_user . '</td></tr> 

                            <tr><td BGCOLOR="#CCCCFF"><B>User Status</B></td><td BGCOLOR="#CCCCFF">' . $total_user . '</td></tr>
                             <tr><td><B>&nbsp;&nbsp;Disabled</B></td><td>' . $approved_user . '</td></tr>                                
                            <tr><td><B>&nbsp;&nbsp;Approved</B></td><td>' . $disabled_user . '</td></tr> </table>';
      }
      if($sendgrid =='yes')
      {
     
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $sendgrid_json1 = "https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20India%201";
        $sendgrid_json2 = "https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20India%2015";
        $sendgrid_json3 = "https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20Foreign%201";
        $sendgrid_json4 = "https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20Foreign%2015";
 
                $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        
        $json1 = file_get_contents($sendgrid_json1, false, $context);
        $value1 = json_decode($json1);
        $length = count($value1);
        
        $json2 = file_get_contents($sendgrid_json2, false, $context);
        $value2 = json_decode($json2);       
        
        $json3 = file_get_contents($sendgrid_json3, false, $context);
        $value3 = json_decode($json3);
        
        $json4 = file_get_contents($sendgrid_json4, false, $context);
        $value4 = json_decode($json4);
        
        $i = 0;
        //print_r($value1);print_r($value2);
       
        $req_sum1 = 0;
        $delivered_sum1 = 0;
        $unique_opens_sum1 = 0;
        $unsubscribes_sum1 = 0;
        $bounces_sum1 = 0;
        $spamreports_sum1 = 0;
        $invalid_email_sum1 = 0;
        $unique_clicks_sum1 = 0;
        $blocked_sum1=0;

        $req_sum2 = 0;
        $delivered_sum2 = 0;
        $unique_opens_sum2 = 0;
        $unsubscribes_sum2 = 0;
        $bounces_sum2 = 0;
        $spamreports_sum2 = 0;
        $invalid_email_sum2 = 0;
        $unique_clicks_sum2 = 0;
        $blocked_sum2=0;

 $req_sum3 = 0;
        $delivered_sum3 = 0;
        $unique_opens_sum3 = 0;
        $unsubscribes_sum3 = 0;
        $bounces_sum3 = 0;
        $spamreports_sum3 = 0;
        $invalid_email_sum3 = 0;
        $unique_clicks_sum3 = 0;
        $blocked_sum3=0;

 $req_sum4 = 0;
        $delivered_sum4 = 0;
        $unique_opens_sum4 = 0;
        $unsubscribes_sum4 = 0;
        $bounces_sum4 = 0;
        $spamreports_sum4 = 0;
        $invalid_email_sum4 = 0;
        $unique_clicks_sum4 = 0;
        $blocked_sum4=0;

        $i = 0;

       echo '<table STYLE="font-family:arial;font-size:11px;" align="CENTER" border="1" width="100%" cellpadding="5" cellspacing="2"><tr><td BGCOLOR="#CCCCFF"><b>Mail Category</b></td>
                <td BGCOLOR="#CCCCFF"><b>Sent </b></td><td BGCOLOR="#CCCCFF"><b>Delivered </b></td><td BGCOLOR="#CCCCFF"><b>Unique Opens </b></td>
                <td BGCOLOR="#CCCCFF"><b>Unique Clicks </b></td><td BGCOLOR="#CCCCFF"><b>Spam  </b></td>
                <td BGCOLOR="#CCCCFF"><b>Blocked </b></td><td BGCOLOR="#CCCCFF"><b>Unsubscribes </b></td>
                <td BGCOLOR="#CCCCFF"><b>Invalid Email </b></td><td BGCOLOR="#CCCCFF"><b>Bounced </b></td>
                </tr>';
      for ($i = 0; $i < $length; $i++) {
            $req = $value1[$i]->requests ;
            $delivered = $value1[$i]->delivered;
            $unique_opens =$value1[$i]->unique_opens;
            $unsubscribes = $value1[$i]->unsubscribes;
            $bounces = $value1[$i]->bounces;
            $spamreports = $value1[$i]->spamreports;
            $invalid_email = $value1[$i]->invalid_email;
            $unique_clicks = $value1[$i]->unique_clicks;
            $blocked = $value1[$i]->bounces;

            $req_sum1 = $req_sum1 + $req;
            $delivered_sum1 = $delivered_sum1 + $delivered;
            $unique_opens_sum1 = $unique_opens_sum1 + $unique_opens;
            $unsubscribes_sum1 = $unsubscribes_sum1 + $unsubscribes;
            $bounces_sum1 = $bounces_sum1 + $bounces;
            $spamreports_sum1 = $spamreports_sum1 + $spamreports;
            $invalid_email_sum1 = $invalid_email_sum1 + $invalid_email;
            $unique_clicks_sum1 = $unique_clicks_sum1 + $unique_clicks;
            $blocked_sum1= $blocked_sum1 + $blocked; 
      }
 echo '<tr><td> Buyer Reactivation - India 1 </td><td>' . $req_sum1 . ' </td><td>' .$delivered_sum1 . '</td>
		<td>' . $unique_opens_sum1 . '</td><td>' . $unique_clicks_sum1  . '</td>
		<td>' . $spamreports_sum1  . '</td><td>' . $blocked_sum1 . '</td>
                <td>' . $unsubscribes_sum1 . '</td><td>' . $invalid_email_sum1. '</td>
                <td>' . $bounces_sum1 . '</td></tr>';


for ($i = 0; $i < $length; $i++) {
            $req = $value2[$i]->requests ;
            $delivered = $value2[$i]->delivered;
            $unique_opens =$value2[$i]->unique_opens;
            $unsubscribes = $value2[$i]->unsubscribes;
            $bounces = $value2[$i]->bounces;
            $spamreports = $value2[$i]->spamreports;
            $invalid_email = $value2[$i]->invalid_email;
            $unique_clicks = $value2[$i]->unique_clicks;
            $blocked = $value2[$i]->bounces;

            $req_sum2 = $req_sum2 + $req;
            $delivered_sum2 = $delivered_sum2 + $delivered;
            $unique_opens_sum2 = $unique_opens_sum2 + $unique_opens;
            $unsubscribes_sum2 = $unsubscribes_sum2 + $unsubscribes;
            $bounces_sum2 = $bounces_sum2 + $bounces;
            $spamreports_sum2 = $spamreports_sum2 + $spamreports;
            $invalid_email_sum2 = $invalid_email_sum2 + $invalid_email;
            $unique_clicks_sum2 = $unique_clicks_sum2 + $unique_clicks;
            $blocked_sum2= $blocked_sum2 + $blocked;  
          
      }
                echo '<tr><td> Buyer Reactivation - India 15 </td><td>' . $req_sum2 . ' </td><td>' .$delivered_sum2 . '</td>
		<td>' . $unique_opens_sum2 . '</td><td>' . $unique_clicks_sum2  . '</td>
		<td>' . $spamreports_sum2  . '</td><td>' . $blocked_sum2 . '</td>
                <td>' . $unsubscribes_sum2 . '</td><td>' . $invalid_email_sum2. '</td>
                <td>' . $bounces_sum2 . '</td></tr>';  


for ($i = 0; $i < $length; $i++) {
            $req = $value3[$i]->requests ;
            $delivered = $value3[$i]->delivered;
            $unique_opens =$value3[$i]->unique_opens;
            $unsubscribes = $value3[$i]->unsubscribes;
            $bounces = $value3[$i]->bounces;
            $spamreports = $value3[$i]->spamreports;
            $invalid_email = $value3[$i]->invalid_email;
            $unique_clicks = $value3[$i]->unique_clicks;
            $blocked = $value3[$i]->bounces;

            $req_sum3 = $req_sum3 + $req;
            $delivered_sum3 = $delivered_sum3 + $delivered;
            $unique_opens_sum3 = $unique_opens_sum3 + $unique_opens;
            $unsubscribes_sum3 = $unsubscribes_sum3 + $unsubscribes;
            $bounces_sum3 = $bounces_sum3 + $bounces;
            $spamreports_sum3 = $spamreports_sum3 + $spamreports;
            $invalid_email_sum3 = $invalid_email_sum3 + $invalid_email;
            $unique_clicks_sum3 = $unique_clicks_sum3 + $unique_clicks;
            $blocked_sum3= $blocked_sum3 + $blocked;  
          
      }
                echo '<tr><td> Buyer Reactivation - Foreign 1 </td><td>' . $req_sum3 . ' </td><td>' .$delivered_sum3 . '</td>
		<td>' . $unique_opens_sum3 . '</td><td>' . $unique_clicks_sum3  . '</td>
		<td>' . $spamreports_sum3  . '</td><td>' . $blocked_sum3 . '</td>
                <td>' . $unsubscribes_sum3 . '</td><td>' . $invalid_email_sum3. '</td>
                <td>' . $bounces_sum3 . '</td></tr>'; 

for ($i = 0; $i < $length; $i++) {
            $req = $value4[$i]->requests ;
            $delivered = $value4[$i]->delivered;
            $unique_opens =$value4[$i]->unique_opens;
            $unsubscribes = $value4[$i]->unsubscribes;
            $bounces = $value4[$i]->bounces;
            $spamreports = $value4[$i]->spamreports;
            $invalid_email = $value4[$i]->invalid_email;
            $unique_clicks = $value4[$i]->unique_clicks;
            $blocked = $value4[$i]->bounces;

            $req_sum4 = $req_sum4 + $req;
            $delivered_sum4 = $delivered_sum4 + $delivered;
            $unique_opens_sum4 = $unique_opens_sum4 + $unique_opens;
            $unsubscribes_sum4 = $unsubscribes_sum4 + $unsubscribes;
            $bounces_sum4 = $bounces_sum4 + $bounces;
            $spamreports_sum4 = $spamreports_sum4 + $spamreports;
            $invalid_email_sum4 = $invalid_email_sum4 + $invalid_email;
            $unique_clicks_sum4 = $unique_clicks_sum4 + $unique_clicks;
            $blocked_sum4= $blocked_sum4 + $blocked;  
          
      }
                echo '<tr><td> Buyer Reactivation - Foreign 15</td><td>' . $req_sum4 . ' </td><td>' .$delivered_sum4 . '</td>
		<td>' . $unique_opens_sum4 . '</td><td>' . $unique_clicks_sum4  . '</td>
		<td>' . $spamreports_sum4  . '</td><td>' . $blocked_sum4 . '</td>
                <td>' . $unsubscribes_sum4 . '</td><td>' . $invalid_email_sum4. '</td>
                <td>' . $bounces_sum4 . '</td></tr>'; 

$tot_req=$req_sum1 + $req_sum2 + $req_sum3 + $req_sum4;
$tot_delivered=$delivered_sum1 + $delivered_sum2 + $delivered_sum3 + $delivered_sum4;
$tot_unique_opens=$unique_opens_sum1 + $unique_opens_sum2 + $unique_opens_sum3 + $unique_opens_sum4;
$tot_unique_clicks=$unique_clicks_sum1 + $unique_clicks_sum2 + $unique_clicks_sum3 + $unique_clicks_sum4;
$tot_spamreports=$spamreports_sum1 + $spamreports_sum2 + $spamreports_sum3 + $spamreports_sum4;

$tot_blocked=$blocked_sum1 + $blocked_sum2 + $blocked_sum3 + $blocked_sum4;
$tot_unsubscribes=$unsubscribes_sum1 + $unsubscribes_sum2 + $unsubscribes_sum3 + $unsubscribes_sum4;
$tot_invalid_email=$invalid_email_sum1 + $invalid_email_sum2 + $invalid_email_sum3 + $invalid_email_sum4;
$tot_bounces=$bounces_sum1 + $bounces_sum2 + $bounces_sum3 + $bounces_sum4;

                echo '<tr><td> Total</td><td>' . $tot_req . ' </td><td>' .$tot_delivered . '</td>
		<td>' . $tot_unique_opens. '</td><td>' . $tot_unique_clicks  . '</td>
		<td>' . $tot_spamreports  . '</td><td>' . $tot_blocked . '</td>
                <td>' . $tot_unsubscribes . '</td><td>' . $tot_invalid_email. '</td>
                <td>' . $tot_bounces . '</td></tr>'; 


                echo '</table>';
      
      }
      }
      
      if($report =='SAAB')
      {
      if($request ==1)
      {
       echo '<TABLE border="1" bordercolor="#141907" cellpadding="0" cellspacing="0" width="90%">
			     ';
			    $catalog=0;
			    $tscatalog=0;
			    $star=0;
			    $leader=0;
			    $other=0;
			    $blpaid=0;
                if($dbtype=='PG'){
                        while($rec=pg_fetch_array($sth5))
			    {
                            $rec=array_change_key_case($rec, CASE_UPPER);  
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==2)
			    {
			    $catalog=$catalog+$rec['CNT'];
			    }
			    
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==1)
			    {
			    $tscatalog=$tscatalog+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==12)
			    {
			    $star=$star+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==10)
			    {
			     $leader=$leader+$rec['CNT'];
			    }
			   if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==15 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==13 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==7))
			    {
			     $other=$other+$rec['CNT'];
			    }
			   if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==16 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==24 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==8 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==21 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==26))
			    {
			     $blpaid=$blpaid+$rec['CNT'];
			    }
			   
			    }
                }else{
                                
                            
			    while($rec=oci_fetch_array($sth5,OCI_BOTH))
			    {
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==2)
			    {
			    $catalog=$catalog+$rec['CNT'];
			    }
			    
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==1)
			    {
			    $tscatalog=$tscatalog+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==12)
			    {
			    $star=$star+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==10)
			    {
			     $leader=$leader+$rec['CNT'];
			    }
			   if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==15 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==13 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==7))
			    {
			     $other=$other+$rec['CNT'];
			    }
			   if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==16 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==24 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==8 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==21 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==26))
			    {
			     $blpaid=$blpaid+$rec['CNT'];
			    }
			   
			    }
                    }
                            
                            
                            
			    echo ' <tr><TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;<b>TOTAL LEADS GENERATED</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;CATALOG</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;TSCATALOG</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;STAR</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;LEADER</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;OTHER</TD>
                              <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;BLPAID</TD>
			   
			    </tr>
			    <tr>
                            <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>COUNT</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$catalog.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$tscatalog.'</TD>			    
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$star.'</TD>			   
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$leader.'</TD>			    
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$other.'</TD>			  
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$blpaid.'</TD>
			    </tr>';
			    
		          echo '
		           </TABLE>
			    </tr>
			    </TABLE>
			    <br>
			    <TABLE>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;Count of Total Leads (Direct + FENQ) Approved By All Suppliers</TD></tr>
			    <table border="1" bordercolor="#141907" cellspacing="0" width=90%>			    
			    ';
			    $catalog=0;
			    $tscatalog=0;
			    $star=0;
			    $leader=0;
			    $other=0;
			    $blpaid=0;
                            
                     if($dbtype=='PG'){
                        while($rec=pg_fetch_array($sth6))
			    {
                            $rec=array_change_key_case($rec, CASE_UPPER);                                    
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==2)
                                    {
                                    $catalog=$catalog+$rec['CNT'];
                                    }

                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==1)
                                    {
                                    $tscatalog=$tscatalog+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==12)
                                    {
                                    $star=$star+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==10)
                                    {
                                     $leader=$leader+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==15 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==13 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==7))
                                    {
                                     $other=$other+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==16 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==24 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==8 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==21 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==26))
                                    {
                                     $blpaid=$blpaid+$rec['CNT'];
                                    }

                                }
                            }else{
                            
                                while($rec=oci_fetch_array($sth6,OCI_BOTH))
			    {
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==2)
			    {
			    $catalog=$catalog+$rec['CNT'];
			    }
			    
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==1)
			    {
			    $tscatalog=$tscatalog+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==12)
			    {
			    $star=$star+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==10)
			    {
			     $leader=$leader+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==15 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==13 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==7))
			    {
			     $other=$other+$rec['CNT'];
			    }
			    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==16 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==24 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==8 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==21 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==26))
			    {
			     $blpaid=$blpaid+$rec['CNT'];
			    }
			   
			    }
                            }        
                            
                            
			    echo '                               
			    <tr>
                            <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;<b>TOTAL LEADS APPROVED</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;CATALOG</TD>
			     <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;TSCATALOG</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;STAR</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;LEADER</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;OTHER</TD>
                              <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;BLPAID</TD>
			    </tr>
			    <tr>
                            <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>COUNT</b></TD>
                            <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$catalog.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$tscatalog.'</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$star.'</TD>
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$leader.'</TD>
                              <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$other.'</TD>     
                             <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$blpaid.'</TD>     
			    </tr>			    
			    </table>';
			    
      }
      if($request ==2)
      {
      echo '<table border="1" bordercolor="#141907" cellspacing="0" width=100%>	
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;<b>PENETRATION WISE LEADS APPROVED</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>COUNT</b></TD>
			    </tr>
			    ';
			    $catalog=0;
			    $tscatalog=0;
			    $star=0;
			    $leader=0;
			    $other=0;
			    $blpaid=0;
                             if($dbtype=='PG'){
                                  while($rec=pg_fetch_array($sth7))
                                    {
                                      $rec=array_change_key_case($rec, CASE_UPPER); 
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==2)
                                    {
                                    $catalog=$catalog+$rec['CNT'];
                                    }

                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==1)
                                    {
                                    $tscatalog=$tscatalog+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==12)
                                    {
                                    $star=$star+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==10)
                                    {
                                     $leader=$leader+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==15 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==13 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==7))
                                    {
                                     $other=$other+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==16 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==24 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==8 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==21 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==26))
                                    {
                                     $blpaid=$blpaid+$rec['CNT'];
                                    }
			   
			    }
                             }else{
                                  while($rec=oci_fetch_array($sth7,OCI_BOTH))
                                    {
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==2)
                                    {
                                    $catalog=$catalog+$rec['CNT'];
                                    }

                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==1)
                                    {
                                    $tscatalog=$tscatalog+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==12)
                                    {
                                    $star=$star+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==10)
                                    {
                                     $leader=$leader+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==15 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==13 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==7))
                                    {
                                     $other=$other+$rec['CNT'];
                                    }
                                    if(isset($rec['GLUSR_USR_CUSTTYPE_WEIGHT']) && ($rec['GLUSR_USR_CUSTTYPE_WEIGHT']==16 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==24 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==8 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==21 || $rec['GLUSR_USR_CUSTTYPE_WEIGHT']==26))
                                    {
                                     $blpaid=$blpaid+$rec['CNT'];
                                    }

                                    }
                             }
                            
                            
			   
                            
                            
                            
			    $catalog1=$catalog+$tscatalog+$star+$leader+$other;
			    echo '
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;CATALOG CUSTOMERS</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$catalog1.'</TD>
			    </tr>
			    
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;BLPAID CUSTOMERS</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$blpaid.'</TD>
			    </tr>
			    </table>
			    <br>';
                            
                            
                                echo '<TABLE border=1 cellpadding="0" cellspacing="0" width="100%">
			    <tr>
                            <td colspan=2 bgcolor="#00479e" align="CENTER" style="font-family:arial;font-size:14px;font-weight:bold;color:#FFF"><b>NPS</b></td>
                            </tr>
                            <tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;"><b>SAAB NPS SCORE</b></td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;"><b>COUNT</b></td></tr>';
                                $NPS_TOTAL =0;
                                $NPS_SCORE=0;
                                $Promotors=0;
                                $Detractors=0;
                                
                             if($dbtype=='PG'){
                                  while($rec=pg_fetch_array($sth18))
                                {
                                        $rec=array_change_key_case($rec, CASE_UPPER); 
                                    $NPS_TOTAL = $NPS_TOTAL + $rec['COUNT'];
                                    
                                    if($rec['SAAB_NPS_SCORE']=='Promotors'){
                                        $Promotors=$rec['COUNT'];
                                    }elseif($rec['SAAB_NPS_SCORE']=='Detractors'){
                                        $Detractors=$rec['COUNT'];
                                    }
                                    
                                    echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['SAAB_NPS_SCORE'].'</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['COUNT'].'</td></tr>';
                                }
                             }else{
                                  while($rec=oci_fetch_array($sth18,OCI_BOTH))
                                {
                                    $NPS_TOTAL = $NPS_TOTAL + $rec['COUNT'];
                                    
                                    if($rec['SAAB_NPS_SCORE']=='Promotors'){
                                        $Promotors=$rec['COUNT'];
                                    }elseif($rec['SAAB_NPS_SCORE']=='Detractors'){
                                        $Detractors=$rec['COUNT'];
                                    }
                                    
                                    echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['SAAB_NPS_SCORE'].'</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['COUNT'].'</td></tr>';
                                }
                             }   
                               
                                
                                
                                
                                 if($NPS_TOTAL > 0){                           
                                    $NPS_SCORE=  round(($Promotors - $Detractors)*100/($NPS_TOTAL),2);
                                 }
                         
                                 echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >Total</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$NPS_TOTAL.'</td></tr>';
                                 echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >Score</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$NPS_SCORE.'</td></tr>';
                                                        
                             

			   echo '<tr>
                            <tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;"><b>Buyer NPS SCORE</b></td>
                            <td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;"><b>COUNT</b></td></tr>';
                                $NPS_TOTAL =0;
                                $NPS_SCORE=0;
                                $Promotors=0;
                                $Detractors=0;
                            if($dbtype=='PG'){
                                while($rec=pg_fetch_array($sth19))
                                        {
                                     $rec=array_change_key_case($rec, CASE_UPPER); 
                                        $NPS_TOTAL = $NPS_TOTAL + $rec['COUNT'];

                                         if($rec['BUYER_NPS_SCORE']=='Promotors'){
                                             $Promotors=$rec['COUNT'];
                                         }elseif($rec['BUYER_NPS_SCORE']=='Detractors'){
                                             $Detractors=$rec['COUNT'];
                                         }
                                     echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['BUYER_NPS_SCORE'].'</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['COUNT'].'</td></tr>';
                                     }
                            }else{
                                while($rec=oci_fetch_array($sth19,OCI_BOTH))
                                        {
                                        $NPS_TOTAL = $NPS_TOTAL + $rec['COUNT'];

                                         if($rec['BUYER_NPS_SCORE']=='Promotors'){
                                             $Promotors=$rec['COUNT'];
                                         }elseif($rec['BUYER_NPS_SCORE']=='Detractors'){
                                             $Detractors=$rec['COUNT'];
                                         }
                                     echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['BUYER_NPS_SCORE'].'</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['COUNT'].'</td></tr>';
                                     }
                            }    
                                
                                 if($NPS_TOTAL > 0){                           
                                    $NPS_SCORE=  round(($Promotors - $Detractors)*100/($NPS_TOTAL),2);
                                 }   
                                  echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >Total</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$NPS_TOTAL.'</td></tr>';
                                  echo '<tr><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >Score</td><td BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$NPS_SCORE.'</td></tr>';
                            
                                echo '</table>'; 

      
      }
      if($request ==3)
      {
     echo ' <TABLE border="1" bordercolor="#141907" cellspacing="0">
			    <tbody>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;<b>IIL_MASTER_DATA_VALUE</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>IIL_MASTER_DATA_VALUE_TEXT</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>COUNT</b></TD>
			    </tr>
			    ';
     if($dbtype=='PG'){
         while($rec=pg_fetch_array($sth9))
			    {
             $rec=array_change_key_case($rec, CASE_UPPER); 
			    $IIL_MASTER_DATA_VALUE=empty($rec['IIL_MASTER_DATA_VALUE']) ? ''  : $rec['IIL_MASTER_DATA_VALUE'];
			    $IIL_MASTER_DATA_VALUE_TEXT=empty($rec['IIL_MASTER_DATA_VALUE_TEXT']) ? ''  :$rec['IIL_MASTER_DATA_VALUE_TEXT'];
			    $CNT=isset($rec['CNT']) ? $rec['CNT'] : '';
			    echo '
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$IIL_MASTER_DATA_VALUE.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$IIL_MASTER_DATA_VALUE_TEXT.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$CNT.'</TD>
			    </tr>';
			    }
     }else{
         while($rec=oci_fetch_array($sth9,OCI_BOTH))
			    {
			    $IIL_MASTER_DATA_VALUE=empty($rec['IIL_MASTER_DATA_VALUE']) ? ''  : $rec['IIL_MASTER_DATA_VALUE'];
			    $IIL_MASTER_DATA_VALUE_TEXT=empty($rec['IIL_MASTER_DATA_VALUE_TEXT']) ? ''  :$rec['IIL_MASTER_DATA_VALUE_TEXT'];
			    $CNT=isset($rec['CNT']) ? $rec['CNT'] : '';
			    echo '
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$IIL_MASTER_DATA_VALUE.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$IIL_MASTER_DATA_VALUE_TEXT.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$CNT.'</TD>
			    </tr>';
			    }
     }
			    
		          echo '</tbody>
		           </TABLE>
			    </tr>
			    </TABLE>
			    <br>
			    <TABLE>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;FENQ Lead Rejection Reasons:</TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" ></TD>
			    </tr>
			    <tr>
			    <TABLE border="1" bordercolor="#141907" cellspacing="0">
			    <tbody>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;<b>IIL_MASTER_DATA_VALUE</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>IIL_MASTER_DATA_VALUE_TEXT</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>COUNT</b></TD>
			    </tr>
			    ';
                          if($dbtype=='PG'){
                               while($rec=pg_fetch_array($sth10))
                                {
                                   $rec=array_change_key_case($rec, CASE_UPPER); 
                                $IIL_MASTER_DATA_VALUE=isset($rec['IIL_MASTER_DATA_VALUE']) ? $rec['IIL_MASTER_DATA_VALUE'] :'';
                                $IIL_MASTER_DATA_VALUE_TEXT=isset($rec['IIL_MASTER_DATA_VALUE_TEXT']) ? $rec['IIL_MASTER_DATA_VALUE_TEXT'] :'';
                                $CNT=isset($rec['CNT']) ? $rec['CNT'] :'';
                                echo '
                                <tr>
                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$IIL_MASTER_DATA_VALUE.'</TD>
                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$IIL_MASTER_DATA_VALUE_TEXT.'</TD>
                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$CNT.'</TD>
                                </tr>';
                                }
                          }else{
                               while($rec=oci_fetch_array($sth10,OCI_BOTH))
                                {
                                $IIL_MASTER_DATA_VALUE=isset($rec['IIL_MASTER_DATA_VALUE']) ? $rec['IIL_MASTER_DATA_VALUE'] :'';
                                $IIL_MASTER_DATA_VALUE_TEXT=isset($rec['IIL_MASTER_DATA_VALUE_TEXT']) ? $rec['IIL_MASTER_DATA_VALUE_TEXT'] :'';
                                $CNT=isset($rec['CNT']) ? $rec['CNT'] :'';
                                echo '
                                <tr>
                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$IIL_MASTER_DATA_VALUE.'</TD>
                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$IIL_MASTER_DATA_VALUE_TEXT.'</TD>
                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$CNT.'</TD>
                                </tr>';
                                }
                          }
			   
			       echo '</tbody>
		           </TABLE>';
			    
      
      }
      
      if($request ==4)
      {
      echo '<TABLE border="1" bordercolor="#141907" cellspacing="0">
			    <tbody>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>PAID_CNT</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>FREE_CNT</b></TD>
			    </tr>
			    ';
          while($rec=oci_fetch_array($sth11,OCI_BOTH))
			    {
			    $PAID_CNT=isset($rec['PAID_CNT']) ? $rec['PAID_CNT'] :'';
			    $FREE_CNT=isset($rec['FREE_CNT']) ? $rec['FREE_CNT'] :'';
		
			    echo '
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$PAID_CNT.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$FREE_CNT.'</TD>
			    </tr>';
			    }
      
			    
			    
			    echo '</tbody>
		           </TABLE>
			    </tr>
			    </TABLE>
			    <br>
			   <TABLE border=1 cellpadding="0" cellspacing="0" width="90%">
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;font-weight:bold;" >Count of Mobile Site Lead Approved</TD>
                            <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;font-weight:bold;" >Count of Mobile App Lead Approved</TD>
                             <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;font-weight:bold;" >Count of Email Lead Approved</TD>
			   
			    </tr>
                            <tr>
			     <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$count12.'</TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$count13.'</TD>
                                <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$count14.'</TD>
			    </tr>';
			  echo '</tbody>
		           </TABLE>
			    </tr>
			    </TABLE>
			    <TABLE>
			    ';
			     echo '</tbody>
		           </TABLE>
			    </tr>
			    </TABLE>
			    <TABLE>
			    <tr>
			   
			    
			    </tr>';
			     echo '</tbody>
		           </TABLE>
			    </tr>
			    </TABLE>
			    <BR>
			    <TABLE border=0 cellpadding="0" cellspacing="0" width="90%">
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >Count of Feedback Data:</TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" ></TD>
			    </tr>
			    
			    <tr>
			   <TABLE border=1 cellpadding="0" cellspacing="0" width="90%">
			    <tbody>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>FEEDBACK</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>Requirement Fulfilled Through IM</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>Reqirement Fulfilled but not from IM</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>In discussion with supplier</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>Do not want to purchase now</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>Need more suppliers</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>Total Feedback</b></TD>
			    </tr>
			    ';
                             if($dbtype=='PG'){
                                while($rec=pg_fetch_array($sth15))
                                    {
                                    $rec=array_change_key_case($rec, CASE_UPPER); 
                                    $rec['GLUSER FEEDBACK']=isset($rec['GLUSER FEEDBACK']) ? $rec['GLUSER FEEDBACK'] :0;
                                    $rec['REQ OVER CLICK']=isset($rec['REQ OVER CLICK']) ? $rec['REQ OVER CLICK'] :0;
                                    $rec['OTHER SUPPLIER SUBMIT']=isset($rec['OTHER SUPPLIER SUBMIT']) ? $rec['OTHER SUPPLIER SUBMIT'] :0;
                                    $rec['OTHER SUPPLIER CLICK']=isset($rec['OTHER SUPPLIER CLICK']) ? $rec['OTHER SUPPLIER CLICK'] :0;
                                    $rec['POSTPONED SUBMIT']=isset($rec['POSTPONED SUBMIT']) ? $rec['POSTPONED SUBMIT'] :0;
                                    $rec['POSTPONED CLICK']=isset($rec['POSTPONED CLICK']) ? $rec['POSTPONED CLICK'] :0;
                                    $rec['NEED SUPP FEEDBACK']=isset($rec['NEED SUPP FEEDBACK']) ? $rec['NEED SUPP FEEDBACK'] :0;
                                    $rec['NEGOTIATING FEEDBACK']=isset($rec['NEGOTIATING FEEDBACK']) ? $rec['NEGOTIATING FEEDBACK'] :0; 
                                    $rec['TOTAL FEEDBACK']=isset($rec['TOTAL FEEDBACK']) ? $rec['TOTAL FEEDBACK'] :0;

                                    $aaa=$rec['GLUSER FEEDBACK']+$rec['REQ OVER CLICK'];
                                    $bbb=$rec['OTHER SUPPLIER SUBMIT']+$rec['OTHER SUPPLIER CLICK'];
                                    $ccc=$rec['POSTPONED SUBMIT']+$rec['POSTPONED CLICK'];
                                    $ddd=$rec['NEED SUPP FEEDBACK'];
                                    $eee=$rec['NEGOTIATING FEEDBACK'];
                                    echo '
                                    <tr>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['FEEDBACK'].'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$aaa.'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$bbb.'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$eee.'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$ccc.'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$ddd.'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['TOTAL FEEDBACK'].'</TD>
                                    </tr>';
                                    } 
                             }else{
			    while($rec=oci_fetch_array($sth15,OCI_BOTH))
			    {
			    $rec['GLUSER FEEDBACK']=isset($rec['GLUSER FEEDBACK']) ? $rec['GLUSER FEEDBACK'] :0;
			    $rec['REQ OVER CLICK']=isset($rec['REQ OVER CLICK']) ? $rec['REQ OVER CLICK'] :0;
			    $rec['OTHER SUPPLIER SUBMIT']=isset($rec['OTHER SUPPLIER SUBMIT']) ? $rec['OTHER SUPPLIER SUBMIT'] :0;
			    $rec['OTHER SUPPLIER CLICK']=isset($rec['OTHER SUPPLIER CLICK']) ? $rec['OTHER SUPPLIER CLICK'] :0;
			    $rec['POSTPONED SUBMIT']=isset($rec['POSTPONED SUBMIT']) ? $rec['POSTPONED SUBMIT'] :0;
			    $rec['POSTPONED CLICK']=isset($rec['POSTPONED CLICK']) ? $rec['POSTPONED CLICK'] :0;
			    $rec['NEED SUPP FEEDBACK']=isset($rec['NEED SUPP FEEDBACK']) ? $rec['NEED SUPP FEEDBACK'] :0;
			    $rec['NEGOTIATING FEEDBACK']=isset($rec['NEGOTIATING FEEDBACK']) ? $rec['NEGOTIATING FEEDBACK'] :0; 
			    $rec['TOTAL FEEDBACK']=isset($rec['TOTAL FEEDBACK']) ? $rec['TOTAL FEEDBACK'] :0;
			    
			    $aaa=$rec['GLUSER FEEDBACK']+$rec['REQ OVER CLICK'];
			    $bbb=$rec['OTHER SUPPLIER SUBMIT']+$rec['OTHER SUPPLIER CLICK'];
			    $ccc=$rec['POSTPONED SUBMIT']+$rec['POSTPONED CLICK'];
			    $ddd=$rec['NEED SUPP FEEDBACK'];
			    $eee=$rec['NEGOTIATING FEEDBACK'];
			    echo '
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['FEEDBACK'].'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$aaa.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$bbb.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$eee.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$ccc.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$ddd.'</TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['TOTAL FEEDBACK'].'</TD>
			    </tr>';
			    }
                             }
			      echo '</tbody>
		           </TABLE>
			    </tr>
			    </TABLE>
			    <BR>
			   <TABLE border=0 cellpadding="0" cellspacing="0" width="90%">
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;Leads Sold/Unsold Suppliers Allocated:</TD>
			    </tr>			    
			    <tr>
			    <TABLE border=1 cellpadding="0" cellspacing="0" width="90%">
			    <tbody>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;<b>SOLD_LEADS</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>SOLD_SUPPLIER</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>SOLD_2</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>SOLD_3_5</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>SOLD_G_5</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>UNSOLD_LEADS</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>UNSOLD_SUPPLIER</b></TD>
			    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>UNSOLD_2</b></TD>
			     <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>UNSOLD_3_5</b></TD>
			     <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" ><b>UNSOLD_G_5</b></TD>
			    </tr>
			    ';
                            if($dbtype=='PG'){
                                    while($rec=pg_fetch_array($sth16))
                                                               {
                                                                $rec=array_change_key_case($rec, CASE_UPPER); 
                                                               $rec['SOLD_LEADS']=isset($rec['SOLD_LEADS']) ? $rec['SOLD_LEADS'] : 0;
                                                               $rec['SOLD_SUPPLIER']=isset($rec['SOLD_SUPPLIER']) ? $rec['SOLD_SUPPLIER'] : 0;
                                                               $rec['SOLD_2']=isset($rec['SOLD_2']) ? $rec['SOLD_2'] : 0;
                                                               $rec['SOLD_3_5']=isset($rec['SOLD_3_5']) ? $rec['SOLD_3_5'] : 0;
                                                               $rec['SOLD_G_5']=isset($rec['SOLD_G_5']) ? $rec['SOLD_G_5'] : 0;
                                                               $rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)']=isset($rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)']) ? $rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)'] : 0;
                                                               $rec['UNSOLD_LEADS']=isset($rec['UNSOLD_LEADS']) ? $rec['UNSOLD_LEADS'] : 0;
                                                               $rec['UNSOLD_SUPPLIER']=isset($rec['UNSOLD_SUPPLIER']) ? $rec['UNSOLD_SUPPLIER'] : 0;
                                                               $rec['UNSOLD_2']=isset($rec['UNSOLD_2']) ? $rec['UNSOLD_2'] : 0;
                                                               $rec['UNSOLD_3_5']=isset($rec['UNSOLD_3_5']) ? $rec['UNSOLD_3_5'] : 0;
                                                                $rec['UNSOLD_G_5']=isset($rec['UNSOLD_G_5']) ? $rec['UNSOLD_G_5'] : 0;
                                                               echo '
                                                               <tr>
                                                               <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_LEADS'].'</TD>
                                                               <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['SOLD_SUPPLIER'].'</TD>
                                                                <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_2'].'</TD>
                                                                 <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_3_5'].'</TD>
                                                                  <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_G_5'].'</TD>
                                                                   <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)'].'</TD>
                                                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_LEADS'].'</TD>
                                                                     <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_SUPPLIER'].'</TD>
                                                                      <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_2'].'</TD>
                                                                       <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_3_5'].'</TD>
                                                                       <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_G_5'].'</TD>
                                                               </tr>';
                                                               }
                            }else{
                                 while($rec=oci_fetch_array($sth16,OCI_BOTH))
                                    {
                                    $rec['SOLD_LEADS']=isset($rec['SOLD_LEADS']) ? $rec['SOLD_LEADS'] : 0;
                                    $rec['SOLD_SUPPLIER']=isset($rec['SOLD_SUPPLIER']) ? $rec['SOLD_SUPPLIER'] : 0;
                                    $rec['SOLD_2']=isset($rec['SOLD_2']) ? $rec['SOLD_2'] : 0;
                                    $rec['SOLD_3_5']=isset($rec['SOLD_3_5']) ? $rec['SOLD_3_5'] : 0;
                                    $rec['SOLD_G_5']=isset($rec['SOLD_G_5']) ? $rec['SOLD_G_5'] : 0;
                                    $rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)']=isset($rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)']) ? $rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)'] : 0;
                                    $rec['UNSOLD_LEADS']=isset($rec['UNSOLD_LEADS']) ? $rec['UNSOLD_LEADS'] : 0;
                                    $rec['UNSOLD_SUPPLIER']=isset($rec['UNSOLD_SUPPLIER']) ? $rec['UNSOLD_SUPPLIER'] : 0;
                                    $rec['UNSOLD_2']=isset($rec['UNSOLD_2']) ? $rec['UNSOLD_2'] : 0;
                                    $rec['UNSOLD_3_5']=isset($rec['UNSOLD_3_5']) ? $rec['UNSOLD_3_5'] : 0;
                                     $rec['UNSOLD_G_5']=isset($rec['UNSOLD_G_5']) ? $rec['UNSOLD_G_5'] : 0;
                                    echo '
                                    <tr>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_LEADS'].'</TD>
                                    <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >'.$rec['SOLD_SUPPLIER'].'</TD>
                                     <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_2'].'</TD>
                                      <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_3_5'].'</TD>
                                       <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SOLD_G_5'].'</TD>
                                        <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['SUM(TOTAL_PURCHASE+TOTAL_INTRODUCTION)'].'</TD>
                                         <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_LEADS'].'</TD>
                                          <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_SUPPLIER'].'</TD>
                                           <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_2'].'</TD>
                                            <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_3_5'].'</TD>
                                            <TD BGCOLOR="#FEFCFF" align="center" STYLE="font-family:arial;font-size:14px;" >&nbsp;&nbsp;'.$rec['UNSOLD_G_5'].'</TD>
                                    </tr>';
                                    }
                            }
			   
		
		          echo '</tbody>
		           </TABLE>';
      
      
      }
      
      }
      

function sendgrid_data($sendgrid_json,$start_date,$end_date)
    {
    $context = stream_context_create(array(
            'http' => array(
                'ignore_errors' => true
            )
        ));
        $json = file_get_contents($sendgrid_json, false, $context);
        $value = json_decode($json);
        $length = count($value);
        $i = 0;

        echo ' <TABLE bgcolor="#6495ED" WIDTH="100%">
			    <tbody><tr style="font-family: arial; padding-left:8px; font-size:15px;color:#000090;">
			    <td ><b>Date </b></td>
			    <td ><b>Requests </b></td>
			    <td ><b>Delivered </b></td>
			    <td ><b> Unique Opens  </b></td>
			    <td ><b> Unique Clicks  </b></td>
			    <td ><b>Unsubscribes </b></td>
			    <td ><b>Bounces </b></td>
			    <td ><b>Spam Reports </b></td>
			    <td ><b>Invalid Email </b></td>
			    
			    
			    </tr>';
        $req_sum = 0;
        $delivered_sum = 0;
        $unique_opens_sum = 0;
        $unsubscribes_sum = 0;
        $bounces_sum = 0;
        $spamreports_sum = 0;
        $invalid_email_sum = 0;

        for ($i = 0; $i < $length; $i++) {
            echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">' . $start_date . ' </td>';
            $req = $value[$i]->requests;
            $delivered = $value[$i]->delivered;
            $unique_opens = $value[$i]->unique_opens;
            $unsubscribes = $value[$i]->unsubscribes;
            $bounces = $value[$i]->bounces;
            $spamreports = $value[$i]->spamreports;
            $invalid_email = $value[$i]->invalid_email;
            $unique_clicks = $value[$i]->unique_clicks;
            if ($req == 0) {
                $unique_clicks_per = 0;
            } else {
                $unique_clicks_per = round(($unique_clicks / $req) * 100, 2);
            }
            echo '<td bgcolor="#F0E68C">' . $req . ' </td>
		<td bgcolor="#F0E68C">' . $delivered . '</td>
		<td bgcolor="#F0E68C">' . $unique_opens . '</td>
		<td bgcolor="#F0E68C">' . $unique_clicks_per . '%</td>
		<td bgcolor="#F0E68C">' . $unsubscribes . '</td>
		<td bgcolor="#F0E68C">' . $bounces . '</td>
		<td bgcolor="#F0E68C">' . $spamreports . '</td>
		<td bgcolor="#F0E68C">' . $invalid_email . '</td>
		</tr>';

            $datetime = new DateTime($start_date);
            $datetime->modify('+1 day');
            $start_date = $datetime->format('Y-m-d');

            $req_sum = $req_sum + $req;
            $delivered_sum = $delivered_sum + $delivered;
            $unique_opens_sum = $unique_opens_sum + $unique_opens;
            $unsubscribes_sum = $unsubscribes_sum + $unsubscribes;
            $bounces_sum = $bounces_sum + $bounces;
            $spamreports_sum = $spamreports_sum + $spamreports;
            $invalid_email_sum = $invalid_email_sum + $invalid_email;
            
        }

        echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
		<td bgcolor="#90EE90"> TOTAL </td>
		<td bgcolor="#90EE90">' . $req_sum . '</td>
		<td bgcolor="#90EE90">' . $delivered_sum . '</td>
		<td bgcolor="#90EE90">' . $unique_opens_sum . '</td>
		<td bgcolor="#90EE90"> - </td>
		<td bgcolor="#90EE90">' . $unsubscribes_sum . '</td>
		<td bgcolor="#90EE90">' . $bounces_sum . '</td>
		<td bgcolor="#90EE90">' . $spamreports_sum . '</td>
		<td bgcolor="#90EE90">' . $invalid_email_sum . '</td>
		</tr></table><br><br>';
    }

?>