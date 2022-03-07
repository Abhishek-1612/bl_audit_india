<?php
if(!key_exists('oid',$_REQUEST)){
    $oid=NULL;
    $searchClass = "";
}
else{
    $searchClass = "hide";
    $oid= $_REQUEST['oid'];
}
$order_status=[
    0=>"",
    1=>'order placed',
    2=>"order accepted",
    3=>"order cancelled",
    4=>"order shipped",
    5=>"order delivered",
];

if(!empty($data)){
    if (!key_exists('response',$data))$data = null;
    else $data= $data['response'];
}


function indexExists($arr,$indices,$count=0){
    // if($this->isJson($arr))$arr = json_decode($arr,true);
    if(is_array($arr))
    {
        if(count($indices)>0){
            $key=array_shift($indices);
            if(key_exists($key,$arr)&& count($indices)>=0){
                $arr = $arr[$key];
                if(!is_array($arr))if($key == 'product_image' && $arr!=NULL){
                    $arr = json_decode($arr,true);
                    if(key_exists('image_100x100',$arr) && $arr['image_100x100'] != null){
                        if(strpos($arr['image_100x100'],"\/"))$arr =  str_replace('\/','/',$arr['image_100x100']);
                        if(is_array($arr))$arr = $arr['image_100x100'];
                        if(!strpos($arr,'https://'))
                        {
                            $arr =  str_replace('http://','https://',$arr);
                        }
    
                    }
                }
                return indexExists($arr,$indices);
            }
            else return "";
        }   
    }elseif(empty($arr)){ 
        return "";
    }else {return $arr;}
}


if(empty($data) || !is_array($data)){
    $data = array();
    $data['glusr_details']['buyer']['name'] = '';
    $data['glusr_details']['seller']['name'] = '';
    $data['glusr_details']['buyer']['glid'] = '';
    $data['glusr_details']['seller']['glid'] = '';
    $data['glusr_details']['seller']['mobile_number'] = '';
    $data['glusr_details']['buyer']['mobile_number'] = '';
    $data['delivery_address']['address_line_1'] = '';
    $data['delivery_address']['address_line_2'] = '';
    $data['delivery_address']['city'] = '';
    $data['delivery_address']['state'] = '';
    $data['delivery_address']['pincode'] = '';
    $data['delivery_mode']='';
    $data['delivery_charges'] = '';
    $data['payment_id'] = '';
    $data['delivery_time'] ='';
    $data['payment_status'] = '';
    $data['tracking_id'] = '';
    $data['product_image'] = '';
    $data['product_name'] = '';
    $data['product_id'] = '';
    $data['order_date'] = '';
    $data['attributes']['order_quantity'] = '';
    $data['delivery_charges'] = '';
    $data['total_price'] = '';
    $data['tax']['tax_percentage']='';
};
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
    #btnModalClose{
        margin-bottom:20px;
    }
</style>
<div id="reportView" >
<button id="btnModalClose">Close</button>
        <table>
                <tr>
                   <td colspan='4'>
                       <div id='orderHeader'>
                           <div><h2>Order Status: <?php echo  $order_status[abs(indexExists($data,['status_id']))];?><h2> </div>
                            <div>
                                <table>
                                    <tr>
                                        <td><h2>Order ID: </h2></td>
                                        <td><h2><?php echo ($oid)?$oid:"";?></h2></td>
                                    </tr>
                                </table>
                            </div>
                       </div>
                   </td> 
                </tr>
                <tr>
                   <th >Buyer Name : </th> 
                   <td  ><input type='text' id='buyerName' name='buyerName' value= "<?php echo  indexExists($data,['glusr_details','buyer','name']);?>" ></td> 
                   <th >Seller Name :</th> 
                   <td ><input type='text' id='sellerName' name='sellerName' value="<?php echo indexExists($data,['glusr_details','seller','name']);?>"></td> 
                </tr>
                <tr>
                <tr>
                   <th >Buyer Glid :</th> 
                   <td  ><input type='text' id='buyerGlid' name='buyerGlid' value="<?php echo indexExists($data,['glusr_details','buyer','glid']);?>"></td> 
                   <th >Seller Glid :</th> 
                   <td ><input type='text' id='sellerGlid' name='sellerGlid' value="<?php echo indexExists($data,['glusr_details','seller','glid']);?>"></td> 
                </tr>
                </tr>
                <tr>
                <th >Buyer Mobile :</th> 
                   <td  ><input type='text' id='buyerMobile' name='buyerMobile' value="<?php echo indexExists($data,['glusr_details','buyer','mobile_number']);?>"></td> 
                   <th >Seller Mobile :</th> 
                   <td ><input type='text' id='sellerMobile' name='sellerMobile' value="<?php echo indexExists($data,['glusr_details','seller','mobile_number']);?>"></td> 
                </tr>
                <tr>
                    <td rowspan='2'>Delivery Address:</td>  
                    <td rowspan='2'>
                    <?php 
                    echo indexExists($data,['delivery_address','address_line_1']).", ".indexExists($data,['delivery_address','address_line_2']).", ".indexExists($data,['delivery_address','city'])." ".indexExists($data,['delivery_address','state']).", Pincode: ".indexExists($data,['delivery_address','pincode']);
                    ?>   
                    </td>  
                    <th>Delivery Mode :</th> 
                    <td><input type='text' id='deliveryMode' name='deliveryMode' value="<?php echo indexExists($data,['delivery_mode']);?>"></td> 
                </tr>
                <tr>
                    <th>Delivery Charge :</th> 
                    <td><input type='text' id='deliveryCharge' name='deliveryCharge'  value="<?php echo indexExists($data,['delivery_charges']);?>"></td> 
                </tr>
                <tr>
                   <th>Payment ID :</th> 
                   <td><input type='text' id='paymentId' name='paymentId' value="<?php echo indexExists($data,['payment_id']);?>"></td> 
                   <th>Delivery Time :</th> 
                   <td><input type='text' id='deliveryTime' name='deliveryTime' value="<?php echo indexExists($data,['delivery_time']);?>"></td>  
                </tr>
                <tr>
                    <th>Payment Status :</th> 
                   <td><input type='text' id='paymentStatus' name='paymentStatus' value="<?php echo indexExists($data,['payment_status']);?>"></td> 
                   <th>Delivery Tracking ID/URL:</th> 
                   <td><input type='text' id='deliveryTracking' name='deliveryTracking' value="<?php echo indexExists($data,['tracking_id']);?>"></td>  
                </tr>
                <tr>
                   <th>  Product ID: </th> 
                   <td><input type='text' id='paymentId' name='paymentId' value="<?php echo indexExists($data,['product_id']);?>"></td> 
                   <th>Product Name :</th> 
                   <td><input type='text' id='deliveryTime' name='deliveryTime' value=" <?php echo indexExists($data,['product_name']);?>"></td>  
                </tr>
                <tr>
                    <th>Order Date:</th> 
                   <td><input type='text' id='paymentStatus' name='paymentStatus' value=" <?php echo indexExists($data,['order_date']);?> "></td> 
                   <th>Quantity:</th> 
                   <td><input type='text' id='order_quantity' name='order_quantity' value="<?php echo indexExists($data,['attributes','order_quantity']);?>"></td>  
                </tr>
                <tr>
                    <th>Delivery Charges:</th> 
                   <td><input type='text' id='order_quantity' name='order_quantity' value=" Rs. <?php echo indexExists($data,['delivery_charges']);?>"></td>  
                </tr>
                <tr>
                    <th>Total Order Value:</th> 
                   <td><input type='text' id='paymentStatus' name='paymentStatus' value=" Rs. <?php echo indexExists($data,['total_price']);?> "></td> 
                   <th> Tax Included:</th> 
                   <td><input type='text' id='order_quantity' name='order_quantity' value="<?php echo indexExists($data,['tax','tax_percentage']);?> %"></td>  
                </tr>
                <tr>
                    <td>
                        <?php if(indexExists($data,['product_image','image_100x100'])){
                            echo "<img src='".indexExists($data,['product_image','image_100x100'])."'/>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
</div>