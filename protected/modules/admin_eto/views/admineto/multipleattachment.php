<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<html>
<head>


<script src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
    <script src="<?php echo$utilsHost?>/js/jquery-ui.min.js">
        </script>
        <script type = "text/javascript" >
        
    history.pushState(null, null, 'index.php?r=admin_eto/AdminEto/multipleattachment&offer=<?php echo $offer; ?>');
    window.addEventListener('popstate', function(event) {
    history.pushState(null, null, 'index.php?r=admin_eto/AdminEto/multipleattachment&offer=<?php echo $offer; ?>');
    });
    </script>
<style type="text/css">

#button{ position:absolute; top: 10px; left:0px; z-index:10; }
img{max-width:100%; }

</style>
</head>

<body>    
<?php 
$i=0;
$ofrStatus = isset($result['ofrStatus']) ? $result['ofrStatus'] : '';
echo ' <div style="width:830px; background-color:white; height:120px;">
 <div style="width: 2000px; height: 90px;">';
while($rec=$atttachsth->read())
{
$ETO_OFR_ATTACHEMENT_STATUS=$rec['ETO_OFR_ATTACHEMENT_STATUS'];

if($ETO_OFR_ATTACHEMENT_STATUS == -1)
{
if(($allowPrem && $allowPrem == 'Y') && ($ofrStatus == 1 || $ofrStatus == 3 || $ofrStatus == 4)) 
{
echo '<a href="/index.php?r=admin_eto/AdminEto/multipleattachment_del&offer='.$offer.'&attach_id='.$rec['ETO_OFR_ATTACHMENT_ID'].'" data-role="button">&#10006;</a>';           
}
}
if(!empty($rec['ETO_OFR_ATTACH_DOC_PATH'])){
    $doc=$rec['ETO_OFR_ATTACH_DOC_PATH'];
    echo '<a id="ofrdoclink" href="'.$doc.'" target="_blank">Click to open this PDF</a>';
}else{
   echo '<img src="'.$rec['ETO_OFR_ATTACH_IMG_ORIG'].'" style="width:150px;height:80px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
}

      $i++;

}
echo '</div></div>';

if($i == 0)
{
echo '<div id="button"><font color="red" align="top">No Attachment is available for this offer</font></div>';
}

?>
</body>
</html>