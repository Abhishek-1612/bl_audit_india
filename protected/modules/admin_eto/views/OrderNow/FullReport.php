<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<style>
    *{
        box-sizing:border-box;
    }
    #content{
        width:auto !important;
    }
    .hide{
        display:none;
    }
    .show{
        display:block;
    }
    table, th, td {
      border: 1px solid;
      border-color:#BDDAFD;
    }
    .add_clickable.Disabled{
        color:grey;
    }
    .head_blue{
        background-color:#DDF8FF;
        color:#383294;
        padding: 10px 0;
    }
    td{
        background-color:#F0F9FF;
    }
    thead th,th{
        background-color:#F0F9FF;
    }
    td, th{
        text-align:left;
        padding: 10px 20px !important;
    }
    tr{
        background-color:white;
    }
    select,input{
        margin-right:10px !important;
    } 
    .add_clickable,.add_clickable:focus{
        background: none;
        border: none;
        color: #009DCC;
        cursor: pointer;
    }
    #orderData{
        width:inherit;
        overflow-x:auto;
    }
    label{
        padding: 10px 20px;
        background-color:white;
    }
    #orderHeader{
        display:flex;
        width:100%;
        align-items:center;
        justify-content:space-between;
    }
    
</style>
<LINK HREF="css/report.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" type="text/javascript" src="./js/jquery.min.js"></script>

<html>
    <body>
        <div>
            <label>Order ID:</label>
            <input type="text" name="oid" id="oid" />
            <input type="button" name="submit-btn" id="generateButton" value="Generate Report">
        </div>
        <div id='reportView'></div>
    </body>
</html>

<script>
let oid = 0;


// validation for mobile and GL ID number
function idValidationHandler(str,mobile=false){
    if(str == ""){
        alert("No Values entered in Order ID");
        return true;
    }
    if(str.match(/[a-z]/)){
        alert("Invalid characters in Order ID");
        return true;
    }
    if(str.match(" ")){
        alert("Spaces are invalid in Order ID");
        return true;
    }
    if(str.match( /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)){
        alert('[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]+  are NOT ALLOWED');
        return true;
    }
   

}

$(document).ready(
    function(){
    
    $('#generateButton').click(function(){
                let url = window.location.href;
                let validate = false;
                let mid = url.split("=")[2];
                oid=$('#oid').val().trim().toLowerCase();
                validate = idValidationHandler(oid,true);
                result='';
                if (!validate){
                    $.ajax({
                        url:`index.php?r=admin_eto/orders/GetOrderDetail&mid=${mid}&oid=${oid}`,
                        type: 'post',
                        beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                           $('#reportView').html(result)
                        }
                    });
                }            
            });
    });
</script>