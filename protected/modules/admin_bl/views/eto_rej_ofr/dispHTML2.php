<?php
 if($dbtype=='PG'){
     while($rec_offer=pg_fetch_array($sth_list))
		{
		$name=$rec_offer['pc_item_name'];
		$desc=$rec_offer['pc_item_desc_small'];
		$image=$rec_offer['pc_item_img_small'];
		
		
		echo '
		<html>
		<head>
		<style type="text/css">

.releancy_pro-detail{border-bottom:1px solid #CCC; padding:10px 5px 10px 5px;}
.releancy_pro-detail h2{ font-size:14px; font-weight:700; color:#0000ff; padding:5px 0px; margin:0px;font-family:arial;}
.releancy_pro-detail p{ padding:0px; margin:0px; font-size:12px; font-family:arial;line-height:18px; text-align:justify;}
.releancy_pro-detail img{ float:left; margin:5px; border:1px solid #e1e1e1;}

.commented:hover
{
background-color: #FFEECA;
}

.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:#333;}
.ttext{font-size:12px; padding:4px 4px 4px 7px;}
.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;}
.ttext1{font-size:12px; padding:4px 4px 4px 4px;}
.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}
</style>
<style type="text/css">
a.info div {
display: none;
}

a.info:hover {
position: relative;
}

a.info:hover div {
display: block;
width : 150px;
padding: 4px 8px 8px 8px;
position: absolute;
border: 2px solid #EAE9D8;
background-color: #FAF9E8;
margin-top: auto;
border-radius: 5px;
left: -176px;
top: -10px;
}
a{color:#0000ff;text-decoration:none}
a:hover{color:#0000ff}
</style >
  </head>
<body>

		<div id="overlay_container" style="none">
		<div class="releancy_pro-detail">
		<img src="'.$image.'"><h2>'.$name.'</h2>
		<p>'.$desc.'</p>
		<br style="clear:both" />
		</div>
		</div>
		</body>
		</html>';

		
  
  
  }
 }else{
         
     while($rec_offer=oci_fetch_array($sth_list))
		{
		$name=$rec_offer['PC_ITEM_NAME'];
		$desc=$rec_offer['PC_ITEM_DESC_SMALL'];
		$image=$rec_offer['PC_ITEM_IMG_SMALL'];
		
		
		echo '
		<html>
		<head>
		<style type="text/css">

.releancy_pro-detail{border-bottom:1px solid #CCC; padding:10px 5px 10px 5px;}
.releancy_pro-detail h2{ font-size:14px; font-weight:700; color:#0000ff; padding:5px 0px; margin:0px;font-family:arial;}
.releancy_pro-detail p{ padding:0px; margin:0px; font-size:12px; font-family:arial;line-height:18px; text-align:justify;}
.releancy_pro-detail img{ float:left; margin:5px; border:1px solid #e1e1e1;}

.commented:hover
{
background-color: #FFEECA;
}

.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:#333;}
.ttext{font-size:12px; padding:4px 4px 4px 7px;}
.ttext2{font-size:12px; padding:4px 4px 4px 24px; font-style:italic;}
.ttext1{font-size:12px; padding:4px 4px 4px 4px;}
.btn{font-size:14px;font-family:arial; font-weight:bold; padding:2px 4px; color:#484848; cursor:pointer;}
</style>
<style type="text/css">
a.info div {
display: none;
}

a.info:hover {
position: relative;
}

a.info:hover div {
display: block;
width : 150px;
padding: 4px 8px 8px 8px;
position: absolute;
border: 2px solid #EAE9D8;
background-color: #FAF9E8;
margin-top: auto;
border-radius: 5px;
left: -176px;
top: -10px;
}
a{color:#0000ff;text-decoration:none}
a:hover{color:#0000ff}
</style >
  </head>
<body>

		<div id="overlay_container" style="none">
		<div class="releancy_pro-detail">
		<img src="'.$image.'"><h2>'.$name.'</h2>
		<p>'.$desc.'</p>
		<br style="clear:both" />
		</div>
		</div>
		</body>
		</html>';

		
  
  
  }
 }

  
 ?>