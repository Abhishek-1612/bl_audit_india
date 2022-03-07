<?php 
      $sender_id =isset($_REQUEST["sender_id"]) ? $_REQUEST["sender_id"] : '';
      $receiver_id =isset($_REQUEST["receiver_id"]) ? $_REQUEST["receiver_id"] : '';
      $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : ''; 
      $total_count =isset($_REQUEST["total_count"]) ? $_REQUEST["total_count"] : 0;
      $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
   ?>
<html>

<head>
    <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>

    <title>Conversation</title>



    <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    ul {
        list-style-type: none;
    }

    .msgText {
        min-width: 50px;
        max-width: 100%;
    }

    .msgText {
        min-width: 50px;
        max-width: 100%;
    }

    .crb {
        clear: both;
    }

    .fl,
    .f1 {
        float: left;
    }

    .fl {
        float: left;
    }

    .maxw65 {
        max-width: 65%;
    }

    .por,
    .pr {
        position: relative;
    }

    .lh18 {
        line-height: 18px;
    }
    }

    .fs11 {
        font-size: 11px;
    }
    }

    .por {
        position: relative;
    }

    .msgCn {
        margin: 11px 0px;
        overflow-wrap: break-word;
        z-index: 0;
    }

    .msgCn:first-child {
        margin: 8px 0px 3px;
    }

    .msgCn.eqleft {
        border-radius: 0px 5px 5px;
        background-color: rgb(254, 254, 254);
        margin-left: 10px;

    }

    .msgCn::after {
        position: absolute;
        content: "";
        width: 0px;
        height: 0px;
        border-style: solid;
    }

    .msgCn.eqleft::after {
        border-width: 0px 10px 10px 0px;
        border-color: transparent rgb(254, 254, 254) transparent transparent;
        top: 0px;
        left: -10px;
    }

    .pd8 {
        padding: 8px;
    }

    .fr {
        float: right;
    }

    .fs11 {
        font-size: 11px;
    }

    .msgCn.eqright {
        border-radius: 5px 0px 5px 5px;
        background-color: rgb(216, 255, 210);
        margin-right: 10px;
    }

    .msgCn.eqright::after {
        border-width: 0px 0px 10px 10px;
        border-color: transparent transparent transparent rgb(216, 255, 210);
        top: 0px;
        right: -10px;
    }

    .pdl5 {
        padding-left: 5px;
    }

    #chatbox {
        padding: 30px;
        margin: 50px;

    }
    </style>

    <style type="text/css">
    .button {
        width: 150px;
        padding: 10px;
        background-color: #FF8C00;
        box-shadow: -8px 8px 10px 3px rgba(0, 0, 0, 0.2);
        font-weight: bold;
        text-decoration: none;
    }

    #cover {
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 5;
        width: 100%;
        height: 100%;
        display: none;
    }

    #loginScreen {
        height: 380px;
        width: 340px;
        margin: 0 auto;
        position: relative;
        z-index: 10;
        display: none;
        background: url(login.png) no-repeat;
        border: 5px solid #cccccc;
        border-radius: 10px;
    }

    #loginScreen:target,
    #loginScreen:target+#cover {
        display: block;
        opacity: 1;
    }

    .cancel {
        display: block;
        position: absolute;
        top: 0px;
        right: 0px;
        background: #f0f9ff;
        z-index: 5;
        color: black;
        height: 154px;
        width: 600px;
        font-size: 30px;
        text-decoration: none;
        text-align: center;
        font-weight: bold;
        opacity: 1;

        border-size: 2px;
        border-style: solid;
        border-color: #0195d3;
    }

    a:visited {
        color: red;
    }

    a:active {
        color: blue;
    }

    a:link {
        color: blue;
    }
    </style>


    <script>
    var start = 51;
    function makedivs(msg, time, align) {
        var class1 = "";
        var class2 = "";
        if (align == "left") {
            class1 = "eqleft"
            class2 = "fl";
        } else {
            class1 = "eqright"
            class2 = "fr";
        }


        var divblock = document.createElement("div");
        divblock.setAttribute("id", "reply9");
        divblock.className = "maxw65 crb " + class2 + " ";


        var divmsg = document.createElement("div");
        divmsg.className = "lh18 crb por wr msgCn pd8 " + class1 + " ";
        var msgtext = document.createTextNode(msg);
        divmsg.appendChild(msgtext);

        var divtimeblock = document.createElement("div");
        divtimeblock.className = " " + class2 + " " + "fs11 crb";

        var divtime = document.createElement("time");
        divtime.className = "fs11";
        var msgtime = document.createTextNode(time);
        divtime.appendChild(msgtime);

        divtimeblock.appendChild(divtime);
        divblock.appendChild(divmsg);
        divblock.appendChild(divtimeblock);

        var element = document.getElementById("conversation_block");
        element.appendChild(divblock);



    }

    function getMoreMsg(result) {
        var len = result.length;
        console.log(result[0]);
        for (var i = 0; i < len; i++) {
            var msg = result[i].msg_text;
            var time = result[i].msg_date;
            var align = result[i].msg_alignment;
            makedivs(msg, time, align);
        }


    }

    function getMessages(start) {
        result = '';
        if((start+50)><?php echo$total_count?>){
            $("#showmore").hide();
        }

        var a = {};
        a['sender_id'] = $('#sender_id').val();
        a['receiver_id'] = $('#receiver_id').val();
        a['start'] = start;




        $.ajax({
            url: "/index.php?r=admin_eto/Conversation/MoreMessages&mid=<?php echo$mid?>",
            type: 'post',
            data: a,
            dataType: 'JSON',
            success: function(result) {
                getMoreMsg(result);
                $("#conversation_block").append(result);
            },
            error: function(result) {
                alert("Error");
                $("#loading_overlay_div").hide();
                $("#loading_overlay_img").hide();
            }

        });
    }
    </script>

</head>



<body>
    <form name="conversation" method="post" action="/index.php?r=admin_eto/Conversation/Index&mid=<?php echo$mid?>">
        <table style="border-collapse: collapse;width:75%;" align="center" border="1" bordercolor="#bedaff"
            cellpadding="4" cellspacing="0">
            <tbody>
                <tr>
                    <td bgcolor="#0054CC" colspan="4" align="center" style="font-family: icon;font-size: large">
                        <font color=" #ffffff"><b>Gl User Conversation</b></font>
                    </td>
                </tr>

                <tr>
                    <td align="center" width="30%">
                        <font size="2px"><b>GL User 1:</b></font>&nbsp;&nbsp;&nbsp;
                        <input class="span2" name="sender_id" id="sender_id" style="margin: 0px;height:25px;"
                            type="number" value="<?php echo$sender_id?>" required>
                    </td>
                    <td align="center" width="30%">
                        <font size="2px"><b>GL User 2: </b></font>&nbsp;&nbsp;&nbsp;
                        <input class="span2" name="receiver_id" id="receiver_id" style="margin: 0px;height:25px;"
                            type="number" value="<?php echo$receiver_id?>" required>
                    </td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <td align="left" colspan="2">
                        <input type="submit" name="submit" value="submit" class="btn btn-primary btn-small">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div id="conversation_block"
        style="border-collapse: collapse;width:75%;margin-left: 12.5%;display: inline-block;background-color: #D6D6D6;"
        align="center" border="1" bordercolor="#bedaff">
        <?php
$response['response']['result'] = isset($response['response']['result'])? $response['response']['result']:array();
foreach ($response['response']['result'] as $d) {
   if($d['msg_alignment']=="right"){
      echo '            
      <div id="reply9" class="maxw65 crb fr" >
      <div class="lh18 crb por wr msgCn pd8 eqright">
         <div class="msgText">' . $d['msg_text'] . '</div>
      </div>
      <div class="fr fs11 crb"><time class="fs11">' . $d['msg_date'] . '</time></div>
      </div>';

   }
   else if($d['msg_alignment']=="left"){

      echo'
      <div id="reply8" class="maxw65 crb fl">
            <div class="lh18 crb por wr msgCn pd8 eqleft">
               <div class="msgText">' . $d['msg_text'] . '</div>
               <a href="https://s3.amazonaws.com/im-my-docs/EnquiryAttachment/GW/YF/PC/SELLERMY-59063812/unnamed.gif?AWSAccessKeyId=AKIAJQUZZ4S2WQT6I2LQ&Expires=1577790686&Signature=P2XbXZ2tdZxiFFElcidHSoNd1aU%3D" target="_blank">Image</a>
            </div>
            <div class="fr fs11 crb"><time class="fs11">' . $d['msg_date'] . '</time></div>
         </div>
      ';
   }
}
?>

    </div>

    <?php 
$submit = isset($_REQUEST["submit"]) ? $_REQUEST["submit"] : '';
if ($submit == "submit") {
    $total_count= isset($response['response']['total_count'])? $response['response']['total_count']:0;
    if($total_count>($start+50))
   { 
       $start = $start +50;
?>
    <div id ="showmore" style="border-collapse: collapse;width:75%;margin-left: 12.5%;display: inline-block;" align="center">
        <input type="button" value="Show all messages" align="center" style="align-self: center;"
            onclick="getMessages(<?php echo$start?>)">
    </div>
    <?php 
    	
}	
}
?>

</body>

</html>