<HTML>
<HEAD><TITLE>Tender Purchase Report</TITLE>
 <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">   
<style>.td_head {color: #000;font-family: arial;font-size: 12px;font-weight: bold;}
</style>
</HEAD>
<body>
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
    <tr>  
  <td  colspan="4" align="center"><font COLOR =" #333399"><b>Tender Purchase History</b></font>           
  </td>   
  </TR>  
 <?php  
$cnt=0; 
 if(isset($rec) && !empty($rec)){
 echo '<tr style="color: #333399; background: #dff8ff;"><TD class="td_head" width="20%"><b>Gluser ID</b></td><td class="td_head" width="30%">Company</td><td class="td_head" width="30%">City/Country</td><td class="td_head" width="20%">Purchased On</td></tr>';
    
 foreach($rec as $row){
 $cnt++;    ?>
 <tr>
<td><?php echo @$row["GLUSRID"];?></td>
<td><?php echo @$row["GLUSR_USR_COMPANYNAME"];?></td>
<td><?php echo @$row["GLUSR_USR_CITY"].' / '.@$row["GLUSR_USR_COUNTRYNAME"];?></td>
<td ><?php echo @$row["PURCHASE_DATE"];?></td></tr>
 <?php }
echo '<tr style="color: #333399; background: #dff8ff;"><td class="td_head" colspan="5">Total Purchased: '.$cnt.'</td></tr>';
}else{
    echo '<tr ><td colspan="4">No Records found</td></tr>'; 
 }
 ?>
</TABLE>
</BODY>     
</HTML>
                