<?php $tabselect=isset($_REQUEST['tabselect'])?$_REQUEST['tabselect']:'';
if($tabselect==8){
echo '<font COLOR ="red">'.$response.'</font>';
}else{
    echo $response;
}
?>