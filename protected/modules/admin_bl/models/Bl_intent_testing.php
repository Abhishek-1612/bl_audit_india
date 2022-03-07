<?php
class Bl_intent_testing extends CFormModel
{
	public function IIL_TAB_DETAIL($dbh,$start_date,$end_date,$glusr_id,$days_between)
	{
	
	$INTEREST=isset($_REQUEST['INTEREST']) ? $_REQUEST['INTEREST'] :'';
	
if($days_between > 2)
{


	$sql="SELECT 
IIL_ENQUIRY_INTEREST_ID,     
IIL_ENQ_INTEREST_DATE,           
INTEREST_RCV_GLUSR_ID,       
INTEREST_SENDER_GLUSR_ID,    
IIL_ENQ_INTEREST_MODID,      
IIL_ENQ_INTEREST_MODREFID,     
IIL_ENQ_INTEREST_MODREFNAME,       
IIL_ENQ_INTEREST_MODREFTYP,        
IIL_ENQ_SENDER_IP,                   
IIL_ENQ_SENDER_IP_COUNTRY,          
IIL_ENQ_SENDER_IP_CNTR_ISO,            
IIL_ENQ_CURRENT_URL,                 
FK_INTEREST_TYPE_ID,                       
IIL_ENQ_INTEREST_TYPE,                  
IIL_ENQ_INTEREST_FENQ_STATUS,             
IIL_ENQ_INTEREST_FENQ_ID,                
IIL_ENQ_INTEREST_PDATE  
FROM iil_enquiry_interest
WHERE INTEREST_SENDER_GLUSR_ID=:glid";
if($INTEREST != 'ALL')
{
$sql .= "  AND IIL_ENQ_INTEREST_TYPE=:INTEREST";
}
$sql .= "  AND trunc(IIL_ENQ_INTEREST_DATE)    >= trunc(to_date(:st_date,'DD-MM-YYYY'))
AND trunc(IIL_ENQ_INTEREST_DATE)    <= trunc(to_date(:end_date,'DD-MM-YYYY'))
UNION ALL
SELECT 
IIL_ENQUIRY_INTEREST_ID,     
IIL_ENQ_INTEREST_DATE,           
INTEREST_RCV_GLUSR_ID,       
INTEREST_SENDER_GLUSR_ID,    
IIL_ENQ_INTEREST_MODID,      
IIL_ENQ_INTEREST_MODREFID,     
IIL_ENQ_INTEREST_MODREFNAME,       
IIL_ENQ_INTEREST_MODREFTYP,        
IIL_ENQ_SENDER_IP,                   
IIL_ENQ_SENDER_IP_COUNTRY,          
IIL_ENQ_SENDER_IP_CNTR_ISO,            
IIL_ENQ_CURRENT_URL,                 
FK_INTEREST_TYPE_ID,                       
IIL_ENQ_INTEREST_TYPE,                  
IIL_ENQ_INTEREST_FENQ_STATUS,             
IIL_ENQ_INTEREST_FENQ_ID,                
IIL_ENQ_INTEREST_PDATE  
FROM iil_enquiry_interest_arch
WHERE INTEREST_SENDER_GLUSR_ID=:glid";
if($INTEREST != 'ALL')
{
$sql .= "  AND IIL_ENQ_INTEREST_TYPE=:INTEREST";
}

$sql .= "  AND trunc(IIL_ENQ_INTEREST_DATE)    >= trunc(to_date(:st_date,'DD-MM-YYYY'))
AND trunc(IIL_ENQ_INTEREST_DATE)    <= trunc(to_date(:end_date,'DD-MM-YYYY'))
order by IIL_ENQ_INTEREST_DATE desc";


	$sth=oci_parse($dbh,$sql);
	oci_bind_by_name($sth,':st_date',$start_date);
	oci_bind_by_name($sth,':end_date',$end_date);
	oci_bind_by_name($sth,':glid',$glusr_id);
	if($INTEREST != 'ALL')
	{
	 oci_bind_by_name($sth,':INTEREST',$INTEREST);
        }


	
	oci_execute($sth);
}
else
{

$sql="SELECT 
IIL_ENQUIRY_INTEREST_ID,     
IIL_ENQ_INTEREST_DATE,           
INTEREST_RCV_GLUSR_ID,       
INTEREST_SENDER_GLUSR_ID,    
IIL_ENQ_INTEREST_MODID,      
IIL_ENQ_INTEREST_MODREFID,     
IIL_ENQ_INTEREST_MODREFNAME,       
IIL_ENQ_INTEREST_MODREFTYP,        
IIL_ENQ_SENDER_IP,                   
IIL_ENQ_SENDER_IP_COUNTRY,          
IIL_ENQ_SENDER_IP_CNTR_ISO,            
IIL_ENQ_CURRENT_URL,                 
FK_INTEREST_TYPE_ID,                       
IIL_ENQ_INTEREST_TYPE,                  
IIL_ENQ_INTEREST_FENQ_STATUS,             
IIL_ENQ_INTEREST_FENQ_ID,                
IIL_ENQ_INTEREST_PDATE  
FROM iil_enquiry_interest
WHERE INTEREST_SENDER_GLUSR_ID=:glid";
if($INTEREST != 'ALL')
{
$sql .= "  AND IIL_ENQ_INTEREST_TYPE=:INTEREST";
}
$sql .= "  AND trunc(IIL_ENQ_INTEREST_DATE)    >= trunc(to_date(:st_date,'DD-MM-YYYY'))
AND trunc(IIL_ENQ_INTEREST_DATE)    <= trunc(to_date(:end_date,'DD-MM-YYYY'))
 order by IIL_ENQ_INTEREST_DATE desc";
 
 $sth=oci_parse($dbh,$sql);
	oci_bind_by_name($sth,':st_date',$start_date);
	oci_bind_by_name($sth,':end_date',$end_date);
	oci_bind_by_name($sth,':glid',$glusr_id);
	if($INTEREST != 'ALL')
	{
	 oci_bind_by_name($sth,':INTEREST',$INTEREST);
        }
        
        oci_execute($sth);

}
	
	return $sth;
	
	}
	public function IIL_TAB_DETAIL_DROP($dbh)
	{
	
	$sql="select IIL_ENQ_INTEREST_TYPE from
(
select distinct IIL_ENQ_INTEREST_TYPE from iil_enquiry_interest
union
select distinct IIL_ENQ_INTEREST_TYPE from iil_enquiry_interest_arch
)
order by to_number(IIL_ENQ_INTEREST_TYPE)";


	$sth1=oci_parse($dbh,$sql);
	oci_execute($sth1);
	
	return $sth1;
	
	}
	
}	
