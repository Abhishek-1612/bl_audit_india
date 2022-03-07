<?php

if($request ==0)
{
$recdata_isq=$sth->read();
$recdata_isq=array_change_key_case($recdata_isq,CASE_UPPER); 

$ISQ_FILLED_1=$recdata_isq['ISQ_FILLED_1'];
$ISQ_AVL=$recdata_isq['ISQ_AVL'];

$recdata_isq=$sth3->read();
$recdata_isq=array_change_key_case($recdata_isq,CASE_UPPER);

$tot_ques=$recdata_isq['TOT_QUESTION'];
$tot_response=$recdata_isq['TOT_RESPONSE'];

if($ISQ_AVL ==0)
{
$fill_isq_per='';
$fill_isq_per_oop='';
}
else
{
$fill_isq_per=($ISQ_FILLED_1/$ISQ_AVL)*100;
$fill_isq_per=round($fill_isq_per,2);

$fill_isq_per_oop=($tot_response/$tot_ques)*100;
$fill_isq_per_oop=round($fill_isq_per_oop,2);
}


echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;ISQ Fill Rate (Atleast 1)</TD>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fill_isq_per.'</TD>	
</TR>
<TR>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;ISQ Fill Rate (Opportunity  Wise)</TD>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fill_isq_per_oop.'</TD>	
</TR>
</table>';
exit;
}      
if($request ==1)
{
$rec=$sth->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$BIG_BUYER_APPROVED=isset($rec['BIG_BUYER_APPROVED']) ? $rec['BIG_BUYER_APPROVED'] : '';
$BIG_BUYER_COMPANY=isset($rec['BIG_BUYER_COMPANY']) ? $rec['BIG_BUYER_COMPANY'] : '';
$BIG_BUYER_PERSONAL=isset($rec['BIG_BUYER_PERSONAL']) ? $rec['BIG_BUYER_PERSONAL'] : '';

$DESC_100=isset($rec['DESC_100']) ? $rec['DESC_100'] : '';
$DESC_100_GR=isset($rec['DESC_100_GR']) ? $rec['DESC_100_GR'] : '';
$DESC_90DAYS=isset($rec['DESC_90DAYS']) ? $rec['DESC_90DAYS'] : '';
$DESC_ANY1=isset($rec['DESC_ANY1']) ? $rec['DESC_ANY1'] : '';

$DESC_ATLEAST_1ISQ=isset($rec['DESC_ATLEAST_1ISQ']) ? $rec['DESC_ATLEAST_1ISQ'] : '';
$DESC_SUBJECT=isset($rec['DESC_SUBJECT']) ? $rec['DESC_SUBJECT'] : '';
$BLFFT=isset($rec['BLFFT']) ? $rec['BLFFT'] : '';
$REPOST=isset($rec['REPOST']) ? $rec['REPOST'] : '';
$DNC_SETTING=isset($rec['DNC_SETTING']) ? $rec['DNC_SETTING'] : '';
          
            

$CNT=isset($rec['RETAIL']) ? $rec['RETAIL'] : ''; 
$order_value_auto=isset($rec['AOV_AUTO']) ? $rec['AOV_AUTO'] : ''; 
$quantity_auto=isset($rec['QTY_AUTO']) ? $rec['QTY_AUTO'] : ''; 
$manual_auto1=isset($rec['MANUAL_RETAIL']) ? $rec['MANUAL_RETAIL'] : ''; 

$verified_only=isset($rec['VERIFIED']) ? $rec['VERIFIED'] :''; 
$verified_update=isset($rec['VERIFIED_UPDATED']) ? $rec['VERIFIED_UPDATED'] :'';


$TOTAL_APP=isset($rec['TTL_APPROVAL']) ? $rec['TTL_APPROVAL'] :'';
$APPROVED_FORIEN=isset($rec['APPROVED_FORIEN']) ? $rec['APPROVED_FORIEN'] :'';
$APPROVED_IN_DO_NOT_CALL=isset($rec['TTL_DO_NOT_CALL']) ? $rec['TTL_DO_NOT_CALL'] :'';
$APPROVED_IN_MUST_CALL=isset($rec['TTL_CALL_APPROVED']) ? $rec['TTL_CALL_APPROVED'] :'';
$APPROVED_IN=$TOTAL_APP-$APPROVED_FORIEN;
$APPROVED_WITHOUT_EMAIL=isset($rec['APPROVED_WITHOUT_EMAIL']) ? $rec['APPROVED_WITHOUT_EMAIL'] :'';
$purpose=isset($rec['PURPOSE']) ? $rec['PURPOSE'] :'';
$total_leads_verified=isset($rec['LEADS_VERIFIED_BY_EMAIL']) ? $rec['LEADS_VERIFIED_BY_EMAIL'] :'';

$total_leads_verified_in=isset($rec['IN_LEADS_VERIFIED_BY_EMAIL']) ? $rec['IN_LEADS_VERIFIED_BY_EMAIL'] :'';

$total_leads_enriched=isset($rec['LEADS_ENRICHED_BY_EMAIL']) ? $rec['LEADS_ENRICHED_BY_EMAIL'] :'';

$total_leads_enriched_in=isset($rec['IN_LEADS_ENRICHED_BY_EMAIL']) ? $rec['IN_LEADS_ENRICHED_BY_EMAIL'] :'';

$APP_12=isset($rec['APPROVED_12_MORE']) ? $rec['APPROVED_12_MORE'] :'';
$APP_24=isset($rec['APPROVED_24_MORE']) ? $rec['APPROVED_24_MORE'] :'';

$APP_12=isset($rec['APPROVED_12_MORE']) ? $rec['APPROVED_12_MORE'] :'';
$APP_24=isset($rec['APPROVED_24_MORE']) ? $rec['APPROVED_24_MORE'] :'';

$sold=isset($rec['TOTAL_USOLD']) ? $rec['TOTAL_USOLD'] :0;
$transaction=isset($rec['TOTAL_SOLD']) ? $rec['TOTAL_SOLD'] :0;
$soldper=round((($sold*100)/$TOTAL_APP),2);
$transactionper=round((($transaction*100)/$TOTAL_APP),2);

echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0">
 <TR>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Sold %</TD>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$soldper.'</TD>	
</TR>
<TR>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Trasaction %</TD>
        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$transactionper.'</TD>	
</TR>
<TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;Delayed Approval
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;</TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Approved After 12 Hours
</TD>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_12.'</TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Approved After 24 Hours
</TD>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_24.'</TD>	
</TR>
<TR>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Total Retail Leads</TD>
		<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Order Value-Auto</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$order_value_auto.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Quantity-Auto</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$quantity_auto.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$manual_auto1.'</TD>	
	</TR>

</table>';
exit; 
}

if($request ==2)
{

 $WORKED15_FENQ='';
$WORKED15_GEN='';
$TTL_RCV_GEN='';
$TTL_RCV_FENQ='';
while($rec=$sth->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='FENQ')
{
$TTL_RCV_FENQ=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_FENQ=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
}
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='GEN')
{
$TTL_RCV_GEN=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_GEN=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
}
}

$worked_15=$WORKED15_GEN+$WORKED15_FENQ;
$total_24=$TTL_RCV_FENQ+$TTL_RCV_GEN;

$TTL_RCV_FENQ_9_9='';
$WORKED15_FENQ_9_9='';
$WORKED30_FENQ_9_9='';
$WORKED10_FENQ_9_9='';
$WORKED5_FENQ_9_9='';
$TTL_RCV_GEN_9_9='';
$WORKED15_GEN_9_9='';
$WORKED30_GEN_9_9='';
$WORKED10_GEN_9_9='';
$WORKED5_GEN_9_9='';
while($rec=$sth_4_2->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='FENQ')
{
$TTL_RCV_FENQ_9_9=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_FENQ_9_9=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
$WORKED30_FENQ_9_9=isset($rec['WORKED30']) ? $rec['WORKED30'] : '';
$WORKED10_FENQ_9_9=isset($rec['WORKED10']) ? $rec['WORKED10'] : '';
$WORKED5_FENQ_9_9=isset($rec['WORKED05']) ? $rec['WORKED05'] : '';
}
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='GEN')
{
$TTL_RCV_GEN_9_9=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_GEN_9_9=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
$WORKED30_GEN_9_9=isset($rec['WORKED30']) ? $rec['WORKED30'] : '';
$WORKED10_GEN_9_9=isset($rec['WORKED10']) ? $rec['WORKED10'] : '';
$WORKED5_GEN_9_9=isset($rec['WORKED05']) ? $rec['WORKED05'] : '';
}
}

$Worked_5_min=$WORKED5_GEN_9_9+$WORKED5_FENQ_9_9;
$Worked_10_min=$WORKED10_GEN_9_9+$WORKED10_FENQ_9_9;
$Worked_15_min=$WORKED15_GEN_9_9+$WORKED15_FENQ_9_9;
$Worked_30_min=$WORKED30_GEN_9_9+$WORKED30_FENQ_9_9;
$worke_9_9=$TTL_RCV_FENQ_9_9+$TTL_RCV_GEN_9_9;


 

   echo  '<table align="CENTER" border="0" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;" width="70%" ALIGN="LEFT"  >&nbsp;<B>Total Leads Generated [24 hrs]</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_24.'<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 15 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$worked_15.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Leads Generated 9 to 9</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$worke_9_9.'<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 30 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_30_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 15 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_15_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 10 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_10_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 05 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_5_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total FENQ LEADS Generated 24 hrs</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$TTL_RCV_FENQ.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Worked Within 15 Min</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$WORKED15_FENQ.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$TTL_RCV_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 30 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED30_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 15 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED15_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 10 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED10_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 05 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED5_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total General LEADS Generated 24 hrs</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$TTL_RCV_GEN.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Worked Within 15 Min</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$WORKED15_GEN.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$TTL_RCV_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 30 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED30_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 15 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED15_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 10 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED10_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 05 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED5_GEN_9_9.'</TD>	
	</TR></table>';
	
exit;
}

if($request ==3)
{

    
$reasonwise='';   
while($rec=$sth->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
$REASON=isset($rec['REASON']) ? $rec['REASON'] : '';
$CNT=isset($rec['CNT']) ? $rec['CNT'] : '';
if($REASON !='-')
{
$reasonwise .= '<TR>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;'.$REASON.'
</TD>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT.'</TD>	
</TR>';
}
}

$modulewise='';   
while($rec=$sth3->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 

$REASON=isset($rec['FK_GL_MODULE_ID']) ? $rec['FK_GL_MODULE_ID'] : '';
$CNT=isset($rec['CNT']) ? $rec['CNT'] : '';
$modulewise .= '<TR>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;'.$REASON.'
</TD>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT.'</TD>	
</TR>';
}
$Auto_rej=$Mannual_Rej='';$TOT_rej='';
while($rec=$sth5->read())
{
    $rec=array_change_key_case($rec,CASE_UPPER);

    if(isset($rec['AUTO_DELETED']))
    {
    $Auto_rej=$rec['AUTO_DELETED'];
    }
    if(isset($rec['MAN_DELETED']))
    {
    $Mannual_Rej=$rec['MAN_DELETED'];
    }
    
    if(isset($rec['TTL_DELETED']))
    {
    $TOT_rej=$rec['TTL_DELETED'];
    }
    
}

$Auto_rej=$TOT_rej-$Mannual_Rej;


echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0">
    <TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" width="70%" ALIGN="LEFT" >&nbsp;&nbsp;Reason wise rejection
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;</TD>	
</TR><TR>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="70%">&nbsp;&nbsp;Manual Rejection
</TD>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Mannual_Rej.'</TD>	
</TR>
<TR>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Auto Rejection
</TD>
<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Auto_rej.'</TD>	
</TR>'.$reasonwise.'<TR>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;MODID wise Rejection
</TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;</TD>	
</TR>'.$modulewise.'</table>';

exit;
}
if($request ==4)
{ 

$rec=$sth_15->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$SUP_0=isset($rec['SUP_0']) ? $rec['SUP_0'] : ''; 
$SUP_1_2=isset($rec['SUP_1_2']) ? $rec['SUP_1_2'] : ''; 
$SUP_3_9=isset($rec['SUP_3_9']) ? $rec['SUP_3_9'] : ''; 
$SUP_10_PLUS=isset($rec['SUP_MORE_10']) ? $rec['SUP_MORE_10'] : ''; 

$selected_lead=$SUP_1_2+$SUP_3_9+$SUP_10_PLUS;

$rec=$sth_14->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$LEAD_APPROVED_MANUAL=isset($rec['LEAD_APPROVED_MANUAL']) ? $rec['LEAD_APPROVED_MANUAL'] : ''; 
$LEAD_APPROVED_AUTO=isset($rec['LEAD_APPROVED_AUTO']) ? $rec['LEAD_APPROVED_AUTO'] : ''; 

$SUP_DISPLAYED=isset($rec['SUP_DISPLAYED']) ? $rec['SUP_DISPLAYED'] : ''; 
$SUP_DISPLAYED_MANUAL=isset($rec['SUP_DISPLAYED_MANUAL']) ? $rec['SUP_DISPLAYED_MANUAL'] : ''; 
$SUPPLIERS=isset($rec['SUPPLIERS']) ? $rec['SUPPLIERS'] : ''; 
$SUPPLIERS_MANUAL=isset($rec['SUPPLIERS_MANUAL']) ? $rec['SUPPLIERS_MANUAL'] : ''; 

$SUPPLIERS_SELECTED=isset($rec['SUPPLIERS_SELECTED']) ? $rec['SUPPLIERS_SELECTED'] : '';

$SUPPLIERS_SELECTED_MANUAL=isset($rec['SUPPLIERS_SELECTED_MANUAL']) ? $rec['SUPPLIERS_SELECTED_MANUAL'] : '';

$SUPPLIERS=$SUP_DISPLAYED-$SUPPLIERS_SELECTED;
$SUPPLIERS_MANUAL=$SUP_DISPLAYED_MANUAL-$SUPPLIERS_SELECTED_MANUAL;

$supp_with_credit=isset($rec['WITH_CREDITS']) ? $rec['WITH_CREDITS'] : ''; 
$supp_without_credit=isset($rec['WITHOUT_CREDITS']) ? $rec['WITHOUT_CREDITS'] : ''; 

$CNT_30='';
$CNT_50='';
$CNT_75='';
while($rec=$sth_1->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['SUPPLIERS']) && $rec['SUPPLIERS'] ==30)
{
$CNT_30=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['SUPPLIERS']) && $rec['SUPPLIERS'] ==50)
{
$CNT_50=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['SUPPLIERS']) && $rec['SUPPLIERS'] ==75)
{
$CNT_75=isset($rec['CNT']) ? $rec['CNT'] : '';
}
}

if($APPROVED_IN==0)
{

$avg_supp_selected='';
}
else
{
$avg_supp_selected=(($supp_without_credit+$supp_with_credit)/$APPROVED_IN)*100;
$avg_supp_selected=round($avg_supp_selected,2);
}
if($TOTAL_APP ==0)
{
$supp_0_per='';
$supp_10_plus_per='';
}
else
{
$supp_0_per=($SUP_0/$TOTAL_APP)*100;
$supp_0_per=round($supp_0_per,2);

$supp_10_plus_per=(($SUP_1_2+$SUP_3_9)/$TOTAL_APP)*100;
$supp_10_plus_per=round($supp_10_plus_per,2);
}
if(($supp_without_credit+$supp_with_credit) ==0)
{
$sup_with_credit_per='';
$sup_without_credit_per='';
}
else
{

$sup_with_credit_per=(($supp_with_credit)/($supp_without_credit+$supp_with_credit))*100;
$sup_with_credit_per=round($sup_with_credit_per,2);

$sup_without_credit_per=(($supp_without_credit)/($supp_without_credit+$supp_with_credit))*100;
$sup_without_credit_per=round($sup_without_credit_per,2);
}
if(($LEAD_APPROVED_MANUAL+$LEAD_APPROVED_AUTO) ==0)
{
$Manual_selection_per='';
$auto_selection_per='';
}
else
{
$Manual_selection_per=($LEAD_APPROVED_MANUAL/($LEAD_APPROVED_MANUAL+$LEAD_APPROVED_AUTO))*100;
$Manual_selection_per=round($Manual_selection_per,2);

$auto_selection_per=($LEAD_APPROVED_AUTO/($LEAD_APPROVED_MANUAL+$LEAD_APPROVED_AUTO))*100;
$auto_selection_per=round($auto_selection_per,2);

}

if(($CNT_30+$CNT_50+$CNT_75) == 0)
{
$supp_30_per='';
$supp_50_per='';
$supp_75_per='';
}
else
{
$supp_30_per=(($CNT_30)/($CNT_30+$CNT_50+$CNT_75))*100;
$supp_30_per=round($supp_30_per,2);

$supp_50_per=(($CNT_50)/($CNT_30+$CNT_50+$CNT_75))*100;
$supp_50_per=round($supp_50_per,2);

$supp_75_per=(($CNT_75)/($CNT_30+$CNT_50+$CNT_75))*100;
$supp_75_per=round($supp_75_per,2);
}
if($SUP_DISPLAYED_MANUAL ==0)
{
$per_supp_rejection='';
}
else
{
$per_supp_rejection=($SUPPLIERS_MANUAL/$SUP_DISPLAYED_MANUAL)*100;
$per_supp_rejection=round($per_supp_rejection,2);
}


echo '<table align="CENTER" border="0" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;;" width="70%" ALIGN="LEFT"  >&nbsp;<B>Average Supplier Selected Per Lead</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$avg_supp_selected.'<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;0 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_0_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;< 10 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_10_plus_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers with Credits</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$sup_with_credit_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers without Credits</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$sup_without_credit_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Leads - (Manual Supplier Selection)</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Manual_selection_per.'%<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Leads  - (Auto Supplier Selection)</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$auto_selection_per.'%<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;30 Suppliers Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_30_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;50 Suppliers Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_50_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;75 Suppliers Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_75_per.'%</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Rejection% of Supplier Displayed</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$per_supp_rejection.'%<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Select Supplier Report [India]</B></TD>
		<TD></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Leads Approved(IN)</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$APPROVED_IN.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;0 Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_0.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;1-2 Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_1_2.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;3-9 Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_3_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;10-10+ Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_10_PLUS.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Auto-Suppliers Selection Count</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Selected - Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$LEAD_APPROVED_MANUAL.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Selected - Auto</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$LEAD_APPROVED_AUTO.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;30 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_30.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;50 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_50.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;75 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_75.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Paid Free Supplier Selection [India]</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Leads with Supplier Not Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_0.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Leads with Supplier Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$selected_lead.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers with Credits</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_with_credit.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers without Credits</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_without_credit.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Rejection% of Supplier Displayed</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Displayed</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_DISPLAYED.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Rejected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUPPLIERS.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Displayed - Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_DISPLAYED_MANUAL.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Rejected - Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUPPLIERS_MANUAL.'</TD>	
	</TR>
	</table>';
exit;
}

if($request ==13){
$CNT_mcat_1='';
$CNT_mcat_2='';
$CNT_mcat_3='';
$CNT_mcat_4='';
$CNT_mcat_5='';
while($rec=$sth->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==1)
{
$CNT_mcat_1=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==2)
{
$CNT_mcat_2=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==3)
{
$CNT_mcat_3=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==4)
{
$CNT_mcat_4=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==5)
{
$CNT_mcat_5=isset($rec['CNT']) ? $rec['CNT'] : '';
}
}
$CNT_mcat_1_expired='';
$CNT_mcat_2_expired='';
$CNT_mcat_3_expired='';
$CNT_mcat_4_expired='';
$CNT_mcat_5_expired='';
while($rec=$sth_expired->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==1)
{
$CNT_mcat_1_expired=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==2)
{
$CNT_mcat_2_expired=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==3)
{
$CNT_mcat_3_expired=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==4)
{
$CNT_mcat_4_expired=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['OFR_MAPPING_COUNT']) && $rec['OFR_MAPPING_COUNT'] ==5)
{
$CNT_mcat_5_expired=isset($rec['CNT']) ? $rec['CNT'] : '';
}
}

$CNT_mcat_1=$CNT_mcat_1+$CNT_mcat_1_expired;
$CNT_mcat_2=$CNT_mcat_2+$CNT_mcat_2_expired;
$CNT_mcat_3=$CNT_mcat_3+$CNT_mcat_3_expired;
$CNT_mcat_4=$CNT_mcat_4+$CNT_mcat_4_expired;
$CNT_mcat_5=$CNT_mcat_5+$CNT_mcat_5_expired;



$rec=$sth6->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$TOTAL_APP=isset($rec['TTL_APPROVAL']) ? $rec['TTL_APPROVAL'] :'';
$APPROVED_FORIEN=isset($rec['APPROVED_FORIEN']) ? $rec['APPROVED_FORIEN'] :'';
$APPROVED_IN=$TOTAL_APP-$APPROVED_FORIEN;

$rec=$sth8->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$tot_mcat_select=isset($rec['CNT']) ? $rec['CNT'] :'';

$rec=$sth9->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$tot_mcat_select_expired=isset($rec['CNT']) ? $rec['CNT'] :'';

$tot_mcat_select=$tot_mcat_select+$tot_mcat_select_expired;

$avg_mcat_per_lead=$tot_mcat_select/$APPROVED_IN;
$avg_mcat_per_lead=round($avg_mcat_per_lead,2);


echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Leads with 1 MCAT selection</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_mcat_1.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Leads with 2 MCAT selection</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_mcat_2.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Leads with 3 MCAT selection</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_mcat_3.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Leads with 4 MCAT selection</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_mcat_4.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Leads with 5 MCAT selection</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_mcat_5.'</TD>	
	</TR></table>';




$SUP_0='';

$rec=$sth4->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$SUP_0=isset($rec['SUP_0']) ? $rec['SUP_0'] : ''; 
$SUP_1_2=isset($rec['SUP_1_2']) ? $rec['SUP_1_2'] : ''; 
$SUP_3_9=isset($rec['SUP_3_9']) ? $rec['SUP_3_9'] : ''; 
$SUP_10_PLUS=isset($rec['SUP_MORE_10']) ? $rec['SUP_MORE_10'] : ''; 

$selected_lead=$SUP_1_2+$SUP_3_9+$SUP_10_PLUS;

$rec=$sth3->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$LEAD_APPROVED_MANUAL=isset($rec['LEAD_APPROVED_MANUAL']) ? $rec['LEAD_APPROVED_MANUAL'] : ''; 
$LEAD_APPROVED_AUTO=isset($rec['LEAD_APPROVED_AUTO']) ? $rec['LEAD_APPROVED_AUTO'] : ''; 

$SUP_DISPLAYED=isset($rec['SUP_DISPLAYED']) ? $rec['SUP_DISPLAYED'] : ''; 
$SUP_DISPLAYED_MANUAL=isset($rec['SUP_DISPLAYED_MANUAL']) ? $rec['SUP_DISPLAYED_MANUAL'] : ''; 
$SUPPLIERS=isset($rec['SUPPLIERS']) ? $rec['SUPPLIERS'] : ''; 
$SUPPLIERS_MANUAL=isset($rec['SUPPLIERS_MANUAL']) ? $rec['SUPPLIERS_MANUAL'] : ''; 

$SUPPLIERS_SELECTED=isset($rec['SUPPLIERS_SELECTED']) ? $rec['SUPPLIERS_SELECTED'] : '';

$SUPPLIERS_SELECTED_MANUAL=isset($rec['SUPPLIERS_SELECTED_MANUAL']) ? $rec['SUPPLIERS_SELECTED_MANUAL'] : '';

$SUPPLIERS=$SUP_DISPLAYED-$SUPPLIERS_SELECTED;
$SUPPLIERS_MANUAL=$SUP_DISPLAYED_MANUAL-$SUPPLIERS_SELECTED_MANUAL;

$supp_with_credit=isset($rec['WITH_CREDITS']) ? $rec['WITH_CREDITS'] : ''; 
$supp_without_credit=isset($rec['WITHOUT_CREDITS']) ? $rec['WITHOUT_CREDITS'] : ''; 

$CNT_30='';
$CNT_50='';
$CNT_75='';
while($rec=$sth7->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['SUPPLIERS']) && $rec['SUPPLIERS'] ==30)
{
$CNT_30=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['SUPPLIERS']) && $rec['SUPPLIERS'] ==50)
{
$CNT_50=isset($rec['CNT']) ? $rec['CNT'] : '';
}
if(isset($rec['SUPPLIERS']) && $rec['SUPPLIERS'] ==75)
{
$CNT_75=isset($rec['CNT']) ? $rec['CNT'] : '';
}
}

if($APPROVED_IN==0)
{

$avg_supp_selected='';
}
else
{
$avg_supp_selected=(($supp_without_credit+$supp_with_credit)/$APPROVED_IN)*100;
$avg_supp_selected=round($avg_supp_selected,2);
}

if(($LEAD_APPROVED_MANUAL+$LEAD_APPROVED_AUTO) ==0)
{
$Manual_selection_per='';
$auto_selection_per='';
}
else
{
$Manual_selection_per=($LEAD_APPROVED_MANUAL/($LEAD_APPROVED_MANUAL+$LEAD_APPROVED_AUTO))*100;
$Manual_selection_per=round($Manual_selection_per,2);

$auto_selection_per=($LEAD_APPROVED_AUTO/($LEAD_APPROVED_MANUAL+$LEAD_APPROVED_AUTO))*100;
$auto_selection_per=round($auto_selection_per,2);

}

if($SUP_DISPLAYED_MANUAL ==0)
{
$per_supp_rejection='';
}
else
{
$per_supp_rejection=($SUPPLIERS_MANUAL/$SUP_DISPLAYED_MANUAL)*100;
$per_supp_rejection=round($per_supp_rejection,2);
}

echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;" width="70%" ALIGN="LEFT"  >&nbsp;<B>Total Leads Approved(IN)</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$APPROVED_IN.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Average Supplier Selected Per Lead</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$avg_supp_selected.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Manual Supplier Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Manual_selection_per.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Auto Supplier Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$auto_selection_per.'</TD>	
	</TR>
	
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Rejection% of Supplier Displayed</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$per_supp_rejection.'</TD>	
	</TR>
	
	
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Average MCAT Selected Per Lead</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$avg_mcat_per_lead.'</TD>	
	</TR>
	
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;0 Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_0.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;1-2 Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_1_2.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;3-9 Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_3_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;10-10+ Supplier</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_10_PLUS.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Auto-Suppliers Selection Count</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Selected - Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$LEAD_APPROVED_MANUAL.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Selected - Auto</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$LEAD_APPROVED_AUTO.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;30 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_30.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;50 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_50.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;75 Suppliers</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$CNT_75.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Paid Free Supplier Selection [India]</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Leads with Supplier Not Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_0.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Leads with Supplier Selected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$selected_lead.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers with Credits</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_with_credit.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers without Credits</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$supp_without_credit.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Rejection% of Supplier Displayed</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Displayed</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_DISPLAYED.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Rejected</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUPPLIERS.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Displayed - Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUP_DISPLAYED_MANUAL.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Suppliers Rejected - Manual</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$SUPPLIERS_MANUAL.'</TD>	
	</TR>
	</table>';
exit;
}

if($request ==14)
{

 $WORKED15_FENQ='';
$WORKED15_GEN='';
$TTL_RCV_GEN='';
$TTL_RCV_FENQ='';
while($rec=$sth->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='FENQ')
{
$TTL_RCV_FENQ=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_FENQ=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
}
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='GEN')
{
$TTL_RCV_GEN=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_GEN=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
}
}

$worked_15=$WORKED15_GEN+$WORKED15_FENQ;
$total_24=$TTL_RCV_FENQ+$TTL_RCV_GEN;

$TTL_RCV_FENQ_9_9='';
$WORKED15_FENQ_9_9='';
$WORKED30_FENQ_9_9='';
$WORKED10_FENQ_9_9='';
$WORKED5_FENQ_9_9='';
$TTL_RCV_GEN_9_9='';
$WORKED15_GEN_9_9='';
$WORKED30_GEN_9_9='';
$WORKED10_GEN_9_9='';
$WORKED5_GEN_9_9='';
while($rec=$sth3->read())
{
$rec=array_change_key_case($rec,CASE_UPPER); 
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='FENQ')
{
$TTL_RCV_FENQ_9_9=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_FENQ_9_9=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
$WORKED30_FENQ_9_9=isset($rec['WORKED30']) ? $rec['WORKED30'] : '';
$WORKED10_FENQ_9_9=isset($rec['WORKED10']) ? $rec['WORKED10'] : '';
$WORKED5_FENQ_9_9=isset($rec['WORKED05']) ? $rec['WORKED05'] : '';
}
if(isset($rec['FK_GL_MODULE_ID']) && $rec['FK_GL_MODULE_ID'] =='GEN')
{
$TTL_RCV_GEN_9_9=isset($rec['TTL_RCV']) ? $rec['TTL_RCV'] : '';
$WORKED15_GEN_9_9=isset($rec['WORKED15']) ? $rec['WORKED15'] : '';
$WORKED30_GEN_9_9=isset($rec['WORKED30']) ? $rec['WORKED30'] : '';
$WORKED10_GEN_9_9=isset($rec['WORKED10']) ? $rec['WORKED10'] : '';
$WORKED5_GEN_9_9=isset($rec['WORKED05']) ? $rec['WORKED05'] : '';
}
}

$Worked_5_min=$WORKED5_GEN_9_9+$WORKED5_FENQ_9_9;
$Worked_10_min=$WORKED10_GEN_9_9+$WORKED10_FENQ_9_9;
$Worked_15_min=$WORKED15_GEN_9_9+$WORKED15_FENQ_9_9;
$Worked_30_min=$WORKED30_GEN_9_9+$WORKED30_FENQ_9_9;
$worke_9_9=$TTL_RCV_FENQ_9_9+$TTL_RCV_GEN_9_9;


 

   echo  '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;" width="70%" ALIGN="LEFT" width="70%">&nbsp;<B>Total Leads Generated [24 hrs]</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_24.'<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 15 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$worked_15.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Leads Generated 9 to 9</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$worke_9_9.'<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 30 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_30_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 15 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_15_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 10 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_10_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Worked Within 05 min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Worked_5_min.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total FENQ LEADS Generated 24 hrs</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$TTL_RCV_FENQ.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Worked Within 15 Min</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$WORKED15_FENQ.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$TTL_RCV_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 30 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED30_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 15 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED15_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 10 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED10_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - FENQ-within 05 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED5_FENQ_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total General LEADS Generated 24 hrs</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$TTL_RCV_GEN.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Worked Within 15 Min</B></TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$WORKED15_GEN.'</B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$TTL_RCV_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 30 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED30_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 15 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED15_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 10 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED10_GEN_9_9.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Post Date - EDT- 9 to 9 - GEN-within 05 Min</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$WORKED5_GEN_9_9.'</TD>	
	</TR></table>';
	
exit;
}

if($request ==15)
{


$rec=$sth->read();
$rec=array_change_key_case($rec,CASE_UPPER); 
$APPLICATION=isset($rec['APPLICATION']) ? $rec['APPLICATION'] :'';
$APPROXORDERVALUE=isset($rec['APPROXORDERVALUE']) ? $rec['APPROXORDERVALUE'] :'';
$LOCATIONPREF=isset($rec['LOCATIONPREF']) ? $rec['LOCATIONPREF'] :'';
$NEED_THIS=isset($rec['NEED_THIS']) ? $rec['NEED_THIS'] :'';
$REQ_FREQUENCY=isset($rec['REQ_FREQUENCY']) ? $rec['REQ_FREQUENCY'] :'';

  echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR>
		<TD STYLE="font-family:arial;font-size:11px;" width="70%" ALIGN="LEFT" width="70%" >&nbsp;&nbsp;Application</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APPLICATION.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Approx Order Value</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APPROXORDERVALUE.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Preferred suppliers location</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$LOCATIONPREF.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Why do you need this</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$NEED_THIS.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;&nbsp;Requirement Frequency</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$REQ_FREQUENCY.'</TD>	
	</TR></table>';
 exit;
}


?>