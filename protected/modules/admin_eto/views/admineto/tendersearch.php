<?php 
//print_r($rec);
$tid=isset($_REQUEST['tid'])?$_REQUEST['tid']:'';  ?>
<HTML>
<HEAD><TITLE>Tender Search</TITLE>
 <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">   
<style>.td_head {color: #000;font-family: arial;font-size: 12px;font-weight: bold;}
</style>
</HEAD>
<body>
<form name="searchForm" id="searchForm" method="post" style="margin-top:0;margin-bottom:0;"> 
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
    <tr>  
  <td bgcolor="#dff8ff" colspan="2" align="center"><font COLOR =" #333399"><b>Tender Search</b></font>           
  </td>   
  </TR>
  <TR><td class="td_head"><b>Enter Tender Id:</b></td><td>
&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="tid" id="tid" value="<?php echo $tid;  ?>"></td>
</tr> 
 <tr>
<TD colspan="2" align="center">                      
<input type="submit" name="search" id="search" value="Search" onclick="if(tid.value.match('^[0-9]+\$')){}else{alert('Enter only Numeric Value'); return false;}"> 
</TD>
</TR>
</TABLE> </form><br><br>
 <?php if(isset($_REQUEST['search'])){  
 if(isset($rec) && !empty($rec)){      ?>
<table><tr><td style="width:50%">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%"><tr style="color: #333399; background: #dff8ff;">
    <tr style="background: #dff8ff;"><TD class="td_head" width="15%"><b>Title :</b></td><td><?php echo $rec["ETO_TDR_TITLE"];?></td></tr> 
<tr><TD class="td_head" width="15%"><b>ID :</b></td><td><?php echo $rec["ETO_TDR_ID"];?></td><td class="td_head" width="15%">Vendor name</td><td><?php echo @$rec["VENDOR_NAME"];?></td></tr> 
<tr><TD class="td_head" width="15%"><b>Posted on :</b></td><td><?php echo $rec["ETO_TDR_PUBLISH_DATE"];?></td><td class="td_head" width="15%">Agent name (ID)</td><td ><?php echo @$rec_det["AGENT_NAME"].'('.@$rec_det["AGENT_ID"];?>)</td></tr>  
<tr><TD class="td_head" width="15%"><b>Tender Details:</td><td><?php echo $rec["ETO_TDR_DESC"];?></td><td class="td_head" width="15%">Company website</td><td><?php echo @$rec_det["COMPANY_WEBSITE"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>Tender Value</td><td><?php echo $rec["ETO_TDR_TENDERVALUE"];?></td><td class="td_head" width="15%">Authority name</td><td><?php echo @$rec_det["AUTHORITY_NAME"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>EMD</td><td><?php echo $rec["ETO_TDR_EARNEST"];?></td><td class="td_head" width="15%">Approval date</td><td><?php echo @$rec_det["APPROVAL_DATE"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>Notice Type</td><td><?php echo $rec["ETO_TDR_TYP"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>Products</b></td><td><?php echo $rec["PRIME_MCAT_NAME"];?></td></tr> 
<tr><TD class="td_head" width="15%"><b>Tender Publish Date</b></td><td><?php echo $rec["ETO_TDR_PUBLISH_DATE"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>Document Sale Starts</b></td><td><?php echo $rec["ETO_TDR_DOC_SALE_STARTDATE"];?></td></tr>
<tr><TD class="td_head" width="15%"><b>Document Sale Ends</b></td><td><?php echo $rec["ETO_TDR_DOC_SALE_LASTDATE"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>Document Submit Before</b></td><td><?php echo $rec["ETO_TDR_DOC_SUBMIT_BEFOREDATE"];?></td></tr>  
<tr><TD class="td_head" width="15%"><b>Tender Due Date</b></td><td><?php echo $rec["ETO_TDR_OPEN_DATE"];?></td></tr>  
<?php 
if(isset($rec["ETO_TDR_IMGPATH"])){
echo '<tr><TD class="td_head" width="15%"><b>Image</b></td><td><a target="_blank" href="'.$rec["ETO_TDR_IMGPATH"].'">View</a></td></tr>';  
 }
 if(isset($rec["ETO_TDR_DOCPATH"])){
echo '<tr><TD class="td_head" width="15%"><b>Document</b></td><td><a target="_blank" href="'.$rec["ETO_TDR_DOCPATH"].'">View</a></td></tr>';  
 }
 echo '<tr><TD class="td_head" width="15%"><b>Purchase History</b></td><td><a target="_blank" href="/index.php?r=admin_eto/tender/PurchaseTender&mid=3762&tid='.$tid.'">View</a></td></tr>';  
?> 
</TABLE>
 <?php 
 }else{
     echo 'No Record Found';
 }
 } ?>
</BODY>     
</HTML>
                