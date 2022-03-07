<?php
$totlead=0;
 $totcredit=0;
 $totunqlead=0;
 $totunquser=0;
 $totactvusr=0;
 $totactvusr1=0;
 $totwebused=0;
 $totmy=0;
 $toteto=0;
 $totht=0;
 $totffext=0;
 $totmailused=0;
 $totalmailmobused=0;
 $totmailemor=0;
 $totmailmor=0;
 $totmaileve=0;
 $totmailleve=0;
 $totmailmor_f=0;
 $totmaileve_f=0;
 $totmailinstant=0;
 $totmail_withinstant=0;
 $total_lead_appv=0;
 $total_lead_appv_orig=0;
 $totmailmor_nf=0;
 $totfresh = 0;
 $totearned = 0;
 $totcontact = 0;
 $totcontactcrd = 0;
 $totmobileused = 0;
 $tothtmailused = 0;
 $total_nonretail_lead = 0;
 $totmobsms=0;
 $totandroidsms=0;

 $totalautoinst_cnt=0;
$total_app_email_cnt=0;
$total_app_cnt=0;   
$totalapps_cnt=0;  
$total_email_app_cnt=0;
$total_email_mob_cnt=0;
$total_email_my_cnt=0;
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
 echo  '<br><strong>IM Advantage</strong>:<input type="button" name="IMAdvantage" id="IMAdvantage" value="Show" onclick="IMAdvantage();"><span id="spIMAdvantage" name=id="spIMAdvantage"></span>';
 		

 
                 $bg_table = '#B5EAAA';
	         $bg_table_web = '#FFCCCC';
		 $bg_table_mob = '#E6E6FA';
		   echo '<TABLE WIDTH="100%" BORDER="1" CELLPADDING="5" CELLSPACING="1" ALIGN="CENTER" border-color="#f8f8f8" style="border-collapse:collapse" >
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" HEIGHT="30" rowspan="2" ALIGN="CENTER"><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Leads Sold</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Leads Sold (UNIQUE)</B></TD>
			<td width="180" bgcolor="#CCCCFF" align="CENTER" style="font-family:arial;font-size:11px;" rowspan="2"><b>Transactions per 100 leads approved</b> </td>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Total Credits Used</B></TD>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="4"><B>Web Used </B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="9"><B>Mail Used</B></TD>
                        <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="4"><B>Attribution for Display Only</B></TD>    
			<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="6"><B>Mobile Used</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Unique User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Fresh User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Transactions per Active User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Credits Earned Per Lead Transaction</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="180" rowspan="2"><B>Leads Approved</B><br><span style="font-size:10px; font-family:arial">(Shows data only if there is some consumption on a date)</span> </TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="180" rowspan="2"><B>Leads Approved ORIG_DATE</B><br><span style="font-size:10px; font-family:arial">(Shows data only if there is some consumption on a date)</span> </TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="180" rowspan="2"><B>Non Retail Leads Approved ORIG_DATE</B><br><span style="font-size:10px; font-family:arial">(Shows data only if there is some consumption on a date)</span> </TD>
			
			</TR>
			<TR>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MY</B></TD>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>ETO</B></TD>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>HT</B></TD>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>FFEXT</B></TD>
                            
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>TOTAL</B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>EMORNING</B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MORNING</B></TD>
			
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>LEVENING</B></TD>
			
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>AUTOINSTANT</B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>INSTANT</B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>WITHINST</B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Others</B></TD>
			<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>HT Mail</B></TD>
                            
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Mail Mob</B></TD>
                            
                        <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Email App</B></TD>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Email Mob</B></TD>
			<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Email MY</B></TD>    

			
                        <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android Total</b></td>
                        <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android Email Direct</b></td>
			<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android App</b></td>
			<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTE.iR"><b>Android SMS</b></td>
			<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTE.iR"><b>MIM</b></td>
			<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTE.iR"><b>MIM SMS</b></td>
			</TR>
			';
 
foreach($array1 as $item)
{
		$totlead=$item['LEADCNT']+$totlead;
		$totcredit=$item['CREDIT']+$totcredit;
		$totunqlead=$item['UNIQUELEADS']+$totunqlead;
		$totunquser=$item['UNIQUE_USER']+$totunquser;
		$totwebused=$item['WEBUSED']+$totwebused;
		$totmobileused=$item['MOB_COUNT']+$totmobileused;
// 		$totmobileused=$item['MOB_COUNT']+$totmobileused;
		$totmy=$item['MY']+$totmy;
		$toteto=$item['ETO']+$toteto;
		$totht=$item['HT']+$totht;
                $totffext=$item['FFEXT']+$totffext;
		$totmailused=$item['MAILUSED']+$totmailused;
		$totalmailmobused=$item['MAIL_COUNT_MAILMOB']+$totalmailmobused;
                
		$totmobsms=$item['IMOB_SMS_COUNT']+$totmobsms;
		$totandroidsms=$item['ANDROID_SMS_COUNT']+$totandroidsms;
                $totalautoinst_cnt=$item['AUTOINST_COUNT']+$totalautoinst_cnt;
                
                
                
                $total_email_app_cnt=$item['EMAIL_APP_COUNT']+$total_email_app_cnt;
                $total_email_mob_cnt=$item['EMAIL_MOB_COUNT']+$total_email_mob_cnt;
                $total_email_my_cnt=$item['EMAIL_MY_COUNT']+$total_email_my_cnt;
               
                
                $total_app_email_cnt=$item['APP_EMAIL_COUNT']+$total_app_email_cnt;
                $total_app_cnt=$item['APP_COUNT']+$total_app_cnt;   
		$totalapps_cnt=$item['ANDROID_COUNT']+$totalapps_cnt;
                
                
		
		$totmailemor=$item['MAIL_COUNT_EMOR']+$totmailemor;
		$totmailmor=$item['MAIL_COUNT_MOR']+$totmailmor;		
		$totmailleve=$item['MAIL_COUNT_LEVE']+$totmailleve;
		$totmailmor_f=$item['MAIL_COUNT_MOR_F']+$totmailmor_f;
		$totmaileve_f=$item['MAIL_COUNT_EVE_F']+$totmaileve_f;
		
		$tothtmailused = $item['HTD_CNT_MAIL'] + $tothtmailused;
		$totmailinstant = $item['MAIL_COUNT_INST'] + $totmailinstant;
		$totmail_withinstant = $item['MAIL_COUNT_WITHINST'] + $totmail_withinstant;

			  $totcontact = $item['CONTACT_COUNT']+ $totcontact;
			  $totcontactcrd = $item['TOTAL_CONTACT_CRDITS']+$totcontactcrd;
			  if(isset($item['CNT']))
			  {
			  $fresh_user = $item['CNT'];
			  }
			  else
			  {
			  $fresh_user=0;
			  }
			  
			  $totfresh = $totfresh + $fresh_user;
			  if(($item['LEADCNT'] - $item['CONTACT_COUNT'])!=0)
			  {
			  $credit_per_lead = ($item['CREDIT'] - $item['TOTAL_CONTACT_CRDITS'])/($item['LEADCNT'] - $item['CONTACT_COUNT']);
			  }
			  else
			  {
			   $credit_per_lead=0;
			  }
			  $credit_per_lead=sprintf("%.2f",$credit_per_lead );

					$date=$item['ETO_PUR_DATE'];
					$lead=$item['LEADCNT'];
					$credit=$item['CREDIT'];
					$unqlead=$item['UNIQUELEADS'];
					$unquser=$item['UNIQUE_USER'];

					$actvusr=($lead/$unquser);
					$actvusr1=sprintf("%.2f", $actvusr);
					$webused=$item['WEBUSED'];
					$my=$item['MY'];
					$eto=$item['ETO'];
					$ht=$item['HT'];
                                        $ffext=$item['FFEXT'];
					$mailused=$item['MAILUSED'];
					$mailMobUsed=$item['MAIL_COUNT_MAILMOB'];
					$mail_emorming = $item['MAIL_COUNT_EMOR'];
					$mail_morming = $item['MAIL_COUNT_MOR'];
					
					$mail_levening = $item['MAIL_COUNT_LEVE'];
					$mail_morming_f = $item['MAIL_COUNT_MOR_F'];
					$mail_evening_f = $item['MAIL_COUNT_EVE_F'];
					
					$mob_used = $item['MOB_COUNT'];
					$ht_cnt_mail = $item['HTD_CNT_MAIL'];
					
					
                                        $autoinst_cnt=$item['AUTOINST_COUNT'];
					
                                        
					$mail_instant = $item['MAIL_COUNT_INST'];
					$mail_withinstant = $item['MAIL_COUNT_WITHINST'];
					$other=($lead-($my+$eto+$ht+$mailused+$mob_used));

					$mailother = ($mailused - ($mail_emorming + $mail_morming +  $mail_levening + $mail_morming_f + $mail_evening_f +  $mail_instant + $mail_withinstant + $ht_cnt_mail + $autoinst_cnt));
					$cont = $item['CONTACT_COUNT'];
					$cont_credits = $item['TOTAL_CONTACT_CRDITS'];
		$lead_appv = 0;
		
		if(isset($appv_lead["$date"]))
		{
		$lead_appv_date = $appv_lead["$date"];
		}
		else{
		$lead_appv_date=0;
		}
		if(isset($lead_appv_date)){ 
		$lead_appv = $lead_appv_date ;
		}
                
                
		 if(isset($total_lead_appv))
		 {
		$total_lead_appv=$lead_appv+$total_lead_appv;
                 }
                 else
                 {
                 $total_lead_appv=0;
                 }
		$lead_appv_orig = 0;
		if(isset($appv_lead_orig["$date"]))
		{
		$lead_appv_date_orig = $appv_lead_orig["$date"];
		}
		else{
		$lead_appv_date_orig=0;
		}
		if(isset($lead_appv_date_orig)){
		$lead_appv_orig = $lead_appv_date_orig;
		}
		$total_lead_appv_orig=$lead_appv_orig+$total_lead_appv_orig;     
               
                $nonretail_lead_cnt=0;  
		if(isset($nonretail_lead["$date"]))
		{
                    $nonretail_lead_cnt = $nonretail_lead["$date"];
		}
		else{
                    $nonretail_lead_cnt=0;
		}
                
                
		 if(isset($total_nonretail_lead))
		 {
                        $total_nonretail_lead=$nonretail_lead_cnt+$total_nonretail_lead;
                 }
                 else
                 {
                 $total_nonretail_lead=0;
                 }
               
                
		$trasper_100 = 0;
		if($lead_appv_orig!=0)
		{
		$trasper_100 = ($lead * 100)/$lead_appv_orig;
		}
		$trasper_100=sprintf("%.2f", $trasper_100);

   echo '
			<TR>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$date".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$lead".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$unqlead".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$trasper_100".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$credit".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$my".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$eto".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$ht".'</TD>
                                <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$ffext".'</TD>    
				
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mailused".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mail_emorming".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mail_morming".'</TD>
				
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mail_levening".'</TD>';
				
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['AUTOINST_COUNT'].'</TD>';				
				
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mail_instant".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mail_withinstant".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mailother".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$ht_cnt_mail".'</TD>
                                    
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$mailMobUsed".'</TD>';


///////////////////////////////////// Start Editing ///////////////////////////////////////////////////////////////////////////////////////////////
                                echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['EMAIL_APP_COUNT'].'</TD>';                            
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['EMAIL_MOB_COUNT'].'</TD>'; 
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['EMAIL_MY_COUNT'].'</TD>'; 
                                
                                 
				 
                                echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['APP_COUNT'].'</TD>';                            
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['APP_EMAIL_COUNT'].'</TD>';
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['ANDROID_COUNT'].'</TD>';
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['ANDROID_SMS_COUNT'].'</TD>';			
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['MOB_COUNT'].'</TD>';	
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$item['IMOB_SMS_COUNT'].'</TD>';	
			      echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$unquser".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$fresh_user".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$actvusr1".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$credit_per_lead".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$lead_appv".'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$lead_appv_orig".'</TD>
                                <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$nonretail_lead_cnt".'</TD>
			</TR>
			';
}

if($totcredit!=0)
	{
                if($unique_glusr!=0)
                {
		$totactvusr=($totlead/$unique_glusr);
		}
		else
		{
		$totactvusr=0;
		}
		$totactvusr1=sprintf("%.2f", $totactvusr);

		 $tottrasper_100 = 0;
		 if($total_lead_appv_orig!=0){
		$tottrasper_100 = ($totlead * 100)/$total_lead_appv_orig ;
		}
		 else
		 {
		 $tottrasper_100=0;
		 }
		$tottrasper_100=sprintf("%.2f", $tottrasper_100);

# 		my $totother=($totcredit-($totmy+$toteto+$totht+$totmailused));
		 $totother=($totlead-($totmy+$toteto+$totht+$totmailused+$totmobileused));
		 if(($totlead-$totcontact)!=0)
		 {
		 $totearned = sprintf(($totcredit-$totcontactcrd)/($totlead-$totcontact));
		 }
		 else
		 {
		 $totearned=0;
		 }
		 $totearned=sprintf("%.2f", $totearned);

		$totmailother = ($totmailused - ($totmailemor + $totmailmor + $totmaileve + $totmailleve + $totmailmor_f + $totmaileve_f + $totmailmor_nf + $totalautoinst_cnt + $totmailinstant + $totmail_withinstant + $tothtmailused));
			

                         echo '
			<TR STYLE="height:30px">
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;"  ALIGN="CENTER"><B>Total</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totlead".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$unique_lead_sold".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$tottrasper_100".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totcredit".'</B></TD>
			<TD BGCOLOR="'."$bg_table_web".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmy".'</B></TD>
			<TD BGCOLOR="'."$bg_table_web".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$toteto".'</B></TD>
			<TD BGCOLOR="'."$bg_table_web".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totht".'</B></TD>
                        <TD BGCOLOR="'."$bg_table_web".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totffext".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmailused".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmailemor".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmailmor".'</B></TD>			
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmailleve".'</B></TD>
			
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totalautoinst_cnt".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmailinstant".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmail_withinstant".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmailother".'</B></TD>
			<TD BGCOLOR="'."$bg_table".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$tothtmailused".'</B></TD>
			<TD BGCOLOR="#FFCCCC" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totalmailmobused".'</B></TD>
                            
                        <TD BGCOLOR="#FFCCCC" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$total_email_app_cnt".'</B></TD>
			<TD BGCOLOR="#FFCCCC" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$total_email_mob_cnt".'</B></TD>
			<TD BGCOLOR="#FFCCCC" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$total_email_my_cnt".'</B></TD>



                          

			
 <TD BGCOLOR="'."$bg_table_mob".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$total_app_cnt.'</B></TD>
<TD BGCOLOR="'."$bg_table_mob".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$total_app_email_cnt.'</B></TD> 
			<TD BGCOLOR="'."$bg_table_mob".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totalapps_cnt".'</B></TD>
			<TD BGCOLOR="'."$bg_table_mob".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totandroidsms.'</B></TD>
			<TD BGCOLOR="'."$bg_table_mob".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totmobileused".'</B></TD>
			
			<TD BGCOLOR="'."$bg_table_mob".'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmobsms.'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$unique_glusr".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totfresh".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totactvusr1".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$totearned".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$total_lead_appv".'</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$total_lead_appv_orig".'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'."$total_nonretail_lead".'</B></TD>
			</TR>
			';
	}
		
		echo '</TABLE>';
?>