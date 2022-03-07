<html>
<head>    
<style TYPE="text/css">.admintext {font-family:arial,ms sans serif,verdana; font-size:12px;}.adminhead{color:#333399;font-family:arial,ms sans serif,verdana; font-size:12px;font-weight:bold;}
</style>
<script type='text/javascript'>
function checkURL(url) {
    var u=url;
    if (u.toString().indexOf("/http/") == -1) {
        alert("The Recording URL is incorrect. Please check with the concerned team.");
        return false;
    }
    else{
        return true;
    }
}
</script>
</head>
<body>    
<?php 
$i=0;
echo ' <div style="width:830px; background-color:white; height:120px;">
 <table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
 <tr><td class="adminhead" bgcolor="#dff8ff">SN</td><td bgcolor="#dff8ff" class="adminhead">Date</td><td bgcolor="#dff8ff" class="adminhead">Url</td>';
foreach ($multiplecallrecordsth as $rec){
   $i++;
    $doc=$rec['LEAP_CALL_RECORDING_URL'];
    $date=$rec['RECORDING_DATE'];
    echo '<tr><td class="admintext">'.$i.'</td><td class="admintext">'.$date.'</td><td class="admintext"><a href="'.$doc.'" TARGET="_blank" onclick="return checkURL("'.$doc.'")"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A></td></tr>';  
}
if($i==0){
    echo '<tr><td align="center" class="admintext" colspan="3">No Record Found</td></tr>';
}
echo '</table><br><br>';
echo '<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
 <tr><td class="adminhead" bgcolor="#dff8ff">SN</td><td bgcolor="#dff8ff" class="adminhead">Date</td><td bgcolor="#dff8ff" class="adminhead">Click to Call Url</td>';
$callhtml='';$i=0;
foreach ($multiplecallrecordsth_c2c as $rec){
   $i++;
    $doc=$rec['LEAP_CALL_RECORDING_URL'];
    $date=$rec['RECORDING_DATE'];
    $callhtml .= '<tr><td class="admintext">'.$i.'</td><td class="admintext">'.$date.'</td><td class="admintext"><a href="'.$doc.'" TARGET="_blank" onclick="return checkURL("'.$doc.'")"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A></td></tr>';
}
if($i==0){
    $callhtml .= '<tr><td align="center" class="admintext" colspan="3">No Record Found</td></tr>';
}else{
    echo '<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1">
 <tr><td class="adminhead" bgcolor="#dff8ff">SN</td><td bgcolor="#dff8ff" class="adminhead">Date</td><td bgcolor="#dff8ff" class="adminhead">Url</td>';
}
echo $callhtml.'</table</div>';
?>
</body>
</html>