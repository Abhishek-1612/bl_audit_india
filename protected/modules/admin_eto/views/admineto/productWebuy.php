<?php
//print_r($data);
$i=0;
if($data['organic']!=NULL)
{
              
echo '<b> <center>Organic Products We Buy</center></b><br/><table align="center" BORDERCOLOR="#000" border="1" cellpadding="1" cellspacing="1" width="100%">
                        <tbody><tr>                           
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>PWB ID</b></td>
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>PWB Name</b></td> 
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>MCAT IDs</b></td>   
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>MCAT Name</b></td>  
                        <td class="admintext" align="left" width="20%" bgcolor="#ccccff"><b>Location Preference</b></td>  
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Cities</b></td>  
                         <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>PWB Insert Date</b></td>
                        </tr>';
           foreach($data['organic'] as $value)
            { 
               if($data['organic'][$i]['glusr_buyprd_id']!=''){
               echo '<tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea" >'.$data['organic'][$i]['glusr_buyprd_id'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea">'.$data['organic'][$i]['glusr_buyprd_name'].'</td> ';
               
               echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >';
               
              $pc_item_glcat_mcat_id_list =explode(',',$data['organic'][$i]['pc_item_glcat_mcat_id_list']);
              $pc_item_glcat_mcat_name_list=explode(',',$data['organic'][$i]['pc_item_glcat_mcat_name_list']);
              $size1=sizeof($pc_item_glcat_mcat_id_list);
              $temp2=0;
              
              if(isset($data['organic'][$i]['fk_glcat_mcat_id']))
               {
               echo '<b>'.$data['organic'][$i]['fk_glcat_mcat_id'].'</b><br>';
               }               
              
              foreach($pc_item_glcat_mcat_id_list  as $temp)
              {
               if(!(isset($data['organic'][$i]['fk_glcat_mcat_id']) && $data['organic'][$i]['fk_glcat_mcat_id'] == $temp))              
               {
               echo $temp;
               }
               if(($temp2 < $size1-1) && !($data['organic'][$i]['fk_glcat_mcat_id'] == $temp))
               {
               echo '<br>';
               }
               $temp2=$temp2+1;
              }
               
               
               
              echo '</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" >';
                
                $size2=sizeof($pc_item_glcat_mcat_name_list);
              $temp3=0;
              if(isset($data['organic'][$i]['glcat_mcat_name']))
               {
               echo '<b>'.$data['organic'][$i]['glcat_mcat_name'].'</b>';
               }
              
              foreach($pc_item_glcat_mcat_name_list  as $temp4)
              {
               if(($temp3 < $size2) && !($data['organic'][$i]['glcat_mcat_name'] == $temp4))
               {
               echo ',<br>';
               }   
               if(!(isset($data['organic'][$i]['glcat_mcat_name']) && $data['organic'][$i]['glcat_mcat_name'] == $temp4))              
               {
               echo $temp4;
               }
              
               $temp3=$temp3+1;
              }
              echo '</td>';  
              
              $location='';
                if(isset($data['organic'][$i]['glusr_buyprd_loc_pref']) && $data['organic'][$i]['glusr_buyprd_loc_pref']==1){
                    $location ='Local';
                }elseif(isset($data['organic'][$i]['glusr_buyprd_loc_pref']) && $data['organic'][$i]['glusr_buyprd_loc_pref']==2){
                     $location ='Any Where In India';
                }elseif(isset($data['organic'][$i]['glusr_buyprd_loc_pref']) && $data['organic'][$i]['glusr_buyprd_loc_pref']==3){
                     $location ='Anywhere in world';
                }elseif(isset($data['organic'][$i]['glusr_buyprd_loc_pref']) && $data['organic'][$i]['glusr_buyprd_loc_pref']==4){
                     $location ='Any Secific Location';     
                }
                
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">'.$location.'</td>';
                
                $cities='';
                if(isset($data['organic'][$i]['glusr_buyprd_loc_city1_name']) && trim($data['organic'][$i]['glusr_buyprd_loc_city1_name']) !='')
                {
                    $cities .=$data['blenquiry'][$i]['glusr_buyprd_loc_city1_name'];
                }
                if(isset($data['organic'][$i]['glusr_buyprd_loc_city2_name']) && trim($data['organic'][$i]['glusr_buyprd_loc_city2_name']) !='')
                {
                     $cities .=",<br>".$data['blenquiry'][$i]['glusr_buyprd_loc_city2_name'];
                }
                if(isset($data['organic'][$i]['glusr_buyprd_loc_city3_name']) && trim($data['organic'][$i]['glusr_buyprd_loc_city3_name']) !='')
                {
                     $cities .=",<br>".$data['organic'][$i]['glusr_buyprd_loc_city3_name'];
                }
              echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >'.trim($cities,',<br>').'</td>';
              
                echo '
               <td class="admintext1" align="left" bgcolor="#eaeaea" >'.$data['organic'][$i]['glusr_buyprd_insert_date'].'</td>
                </tr>';
                $i++;
            }
            }
            echo '</tbody></table><br/>';
 }
$i=0;
if($data['blenquiry']!=NULL)
{ 

$name = isset($_REQUEST['color']) ? $_REQUEST['color'] : '';

$submit=isset($_REQUEST['Apply']) ? $_REQUEST['Apply'] : '';

if($submit)

{


echo '<form id="inorganic" method="post" action="">
<b><center>Inorganic Products We Buy</center></b><br/>

<div class="admintext1">';
 if(in_array("inorganic_dir_query", $name))
 {
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_dir_query" checked> Enquiry &nbsp;&nbsp;&nbsp;';
}
else
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_dir_query"> Enquiry &nbsp;&nbsp;&nbsp;';
}
 if(in_array("inorganic_BL", $name))
 {
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_BL" checked> Buy Lead &nbsp;&nbsp;&nbsp;';
}
else
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_BL" > Buy Lead &nbsp;&nbsp;&nbsp;';
}
if(in_array("inorganic_BL_Exp", $name))
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_BL_Exp" checked> Expired Buy Lead &nbsp;&nbsp;&nbsp;';
}
else
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_BL_Exp" > Expired Buy Lead &nbsp;&nbsp;&nbsp;';
}
if(in_array("inorganic_SI", $name))
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_SI" checked> Search Intent &nbsp;&nbsp;&nbsp;';
}
else
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_SI" > Search Intent &nbsp;&nbsp;&nbsp;';
}
if(in_array("inorganic_SI_Arch", $name))
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_SI_Arch" checked> Search Intent Archived &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
echo '<input type="checkbox" name="color[]" id="color" value="inorganic_SI_Arch" > Search Intent Archived &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}

echo '<input type="submit" name="Apply" value="Apply">
</div><br>

<table align="center" BORDERCOLOR="#000" border="1" cellpadding="1" cellspacing="1" width="100%">



                        <tbody><tr>
                        <td class="admintext" align="left" width="7%" bgcolor="#ccccff"><b>PWB ID</b></td>
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>PWB Name</b></td> 
                        <td class="admintext" align="left" width="8%" bgcolor="#ccccff"><b>MCAT IDs</b></td>   
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>MCAT Name</b></td>
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Source</b></td>  
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Location Preference</b></td>  
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>Cities</b></td>  
                         <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>PWB Insert Date</b></td>
                          <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>Original Post Date</b></td>
                        </tr>';
           foreach($data['blenquiry'] as $value)
            {   
            if(in_array($data['blenquiry'][$i]['glusr_buyinprd_source'], $name))
            {
            echo '<tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea" >'.$data['blenquiry'][$i]['glusr_buyprd_id'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" >'.$data['blenquiry'][$i]['glusr_buyprd_name'].'</td> ';
                
             echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >';
               
              $pc_item_glcat_mcat_id_list =explode(',',$data['blenquiry'][$i]['pc_item_glcat_mcat_id_list']);
              $pc_item_glcat_mcat_name_list=explode(',',$data['blenquiry'][$i]['pc_item_glcat_mcat_name_list']);
              $size1=sizeof($pc_item_glcat_mcat_id_list);
              $temp2=0;
              
              if(isset($data['blenquiry'][$i]['fk_glcat_mcat_id']))
               {
               echo '<b>'.$data['blenquiry'][$i]['fk_glcat_mcat_id'].'</b><br>';
               }
              foreach($pc_item_glcat_mcat_id_list  as $temp)
              {
               if(($temp2 < $size1-1) && !($data['blenquiry'][$i]['fk_glcat_mcat_id'] == $temp))
               {
               echo '<br>';
               }   
               if(!(isset($data['blenquiry'][$i]['fk_glcat_mcat_id']) && $data['blenquiry'][$i]['fk_glcat_mcat_id'] == $temp))
               {
               echo $temp;
               }
              
               $temp2=$temp2+1;
              }
               
               
               
              echo '</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea">';
                
                $size2=sizeof($pc_item_glcat_mcat_name_list);
              $temp3=0;
              if(isset($data['blenquiry'][$i]['glcat_mcat_name']))
               {
               echo '<b>'.$data['blenquiry'][$i]['glcat_mcat_name'].'</b>';
               }
              foreach($pc_item_glcat_mcat_name_list  as $temp4)
              {
               if(($temp3 < $size2) && !($data['blenquiry'][$i]['glcat_mcat_name'] == $temp4))
               {
               echo ',<br>';
               }   
               if(!(isset($data['blenquiry'][$i]['glcat_mcat_name']) && $data['blenquiry'][$i]['glcat_mcat_name'] == $temp4))               
               {
               echo $temp4;
               }
              
               $temp3=$temp3+1;
              }
                
              echo '</td>';
                
                if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_dir_query')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">Enquiry</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_BL')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Buy Lead</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_BL_Exp')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Expired Buy Lead</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_SI')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">Search Intent</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_SI_Arch')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">Search Intent Archived</td>';
                }
                $location='';
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==1){
                    $location ='Local';
                }elseif(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==2){
                     $location ='Any Where In India';
                }elseif(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==3){
                     $location ='Anywhere in world';
                }elseif(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==4){
                     $location ='Any Secific Location';     
                }
                
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">'.$location.'</td>';
                
                $cities='';
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_city1_name']) && trim($data['blenquiry'][$i]['glusr_buyprd_loc_city1_name']) !='')
                {
                    $cities .=$data['blenquiry'][$i]['glusr_buyprd_loc_city1_name'];
                }
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_city2_name']) && trim($data['blenquiry'][$i]['glusr_buyprd_loc_city2_name']) !='')
                {
                     $cities .=",<br>".$data['blenquiry'][$i]['glusr_buyprd_loc_city2_name'];
                }
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_city3_name']) && trim($data['blenquiry'][$i]['glusr_buyprd_loc_city3_name']) !='')
                {
                     $cities .=",<br>".$data['blenquiry'][$i]['glusr_buyprd_loc_city3_name'];
                }
                
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">'.trim($cities,',<br>').'</td>';
                
               
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">'.$data['blenquiry'][$i]['glusr_buyprd_insert_date'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea">'.$data['blenquiry'][$i]['glusr_buyprd_orig_src_date'].'</td>
                </tr>';
             }
                $i++;
             }   
            
            echo '</tbody></table><br/></form>';
            
            
     }
  else
  {
  
echo '<form id="inorganic" method="post" action="">
<b><center>Inorganic Products We Buy</center></b><br/>

<div class="admintext1">';

echo '<input type="checkbox" name="color[]" id="color" value="inorganic_dir_query" checked> Enquiry &nbsp;&nbsp;&nbsp;';



echo '<input type="checkbox" name="color[]" id="color" value="inorganic_BL" checked> Buy Lead &nbsp;&nbsp;&nbsp;';


echo '<input type="checkbox" name="color[]" id="color" value="inorganic_BL_Exp" checked> Expired Buy Lead &nbsp;&nbsp;&nbsp;';


echo '<input type="checkbox" name="color[]" id="color" value="inorganic_SI" checked> Search Intent &nbsp;&nbsp;&nbsp;';


echo '<input type="checkbox" name="color[]" id="color" value="inorganic_SI_Arch" checked> Search Intent Archived &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';



echo '<input type="submit" name="Apply" value="Apply">
</div><br>

<table align="center" BORDERCOLOR="#000" border="1" cellpadding="1" cellspacing="1" width="100%">



                        <tbody><tr>
                        <td class="admintext" align="left" width="7%" bgcolor="#ccccff"><b>PWB ID</b></td>
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>PWB Name</b></td> 
                        <td class="admintext" align="left" width="8%" bgcolor="#ccccff"><b>MCAT IDs</b></td>   
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>MCAT Name</b></td>
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Source</b></td>  
                        <td class="admintext" align="left" width="15%" bgcolor="#ccccff"><b>Location Preference</b></td>  
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>Cities</b></td> 
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>PWB Insert Date</b></td>
                        <td class="admintext" align="left" width="10%" bgcolor="#ccccff"><b>Original  Post Date</b></td>
                        </tr>';
                        
               
           foreach($data['blenquiry'] as $value)
            {   
           if($data['blenquiry'][$i]['glusr_buyprd_id']!=''){
            echo '<tr>
                <td class="admintext1" align="left" bgcolor="#eaeaea">'.$data['blenquiry'][$i]['glusr_buyprd_id'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea">'.$data['blenquiry'][$i]['glusr_buyprd_name'].'</td>';
              
               echo '<td class="admintext1" align="left" bgcolor="#eaeaea">';
               
              $pc_item_glcat_mcat_id_list =explode(',',$data['blenquiry'][$i]['pc_item_glcat_mcat_id_list']);
              $pc_item_glcat_mcat_name_list=explode(',',$data['blenquiry'][$i]['pc_item_glcat_mcat_name_list']);
              $size1=sizeof($pc_item_glcat_mcat_id_list);
              $temp2=0;
               if(isset($data['blenquiry'][$i]['fk_glcat_mcat_id']))
               {
               echo '<b>'.$data['blenquiry'][$i]['fk_glcat_mcat_id'].'</b><br>';
               }
              
              foreach($pc_item_glcat_mcat_id_list  as $temp)
              {
               if(!(isset($data['blenquiry'][$i]['fk_glcat_mcat_id']) && $data['blenquiry'][$i]['fk_glcat_mcat_id'] == $temp))               
               {
               echo $temp;
               }
               if(($temp2 < $size1-1) && !($data['blenquiry'][$i]['fk_glcat_mcat_id'] == $temp))
               {
               echo '<br>';
               }
               $temp2=$temp2+1;
              }
               
               
               
              echo '</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea">';
                
                $size2=sizeof($pc_item_glcat_mcat_name_list);
              $temp3=0;
               if(isset($data['blenquiry'][$i]['glcat_mcat_name']))
               {
               echo '<b>'.$data['blenquiry'][$i]['glcat_mcat_name'].'</b>';
               }
              foreach($pc_item_glcat_mcat_name_list  as $temp4)
              {
               if(($temp3 < $size2) && !($data['blenquiry'][$i]['glcat_mcat_name'] == $temp4))
               {
               echo ',<br>';
               }   
               if(!(isset($data['blenquiry'][$i]['glcat_mcat_name']) && $data['blenquiry'][$i]['glcat_mcat_name'] == $temp4))              
               {
               echo $temp4;
               }
               
               $temp3=$temp3+1;
              }
                
                
                
                
                
                
              echo '</td>';
               
                if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_dir_query')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Enquiry</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_BL')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Buy Lead</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_BL_Exp')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Expired Buy Lead</td>';
                }
                 if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_SI')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Search Intent</td>';
                }
                if(isset($data['blenquiry'][$i]['glusr_buyinprd_source']) && $data['blenquiry'][$i]['glusr_buyinprd_source'] =='inorganic_SI_Arch')
                {
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >Search Intent Archived</td>';
                }
                
                $location='';
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==1){
                    $location ='Local';
                }elseif(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==2){
                     $location ='Any Where In India';
                }elseif(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==3){
                     $location ='Anywhere in world';
                }elseif(isset($data['blenquiry'][$i]['glusr_buyprd_loc_pref']) && $data['blenquiry'][$i]['glusr_buyprd_loc_pref']==4){
                     $location ='Any Secific Location';     
                }
                
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea">'.$location.'</td>';
                
                $cities='';
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_city1_name']) && trim($data['blenquiry'][$i]['glusr_buyprd_loc_city1_name']) !='')
                {
                    $cities .=$data['blenquiry'][$i]['glusr_buyprd_loc_city1_name'];
                }
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_city2_name']) && trim($data['blenquiry'][$i]['glusr_buyprd_loc_city2_name']) !='')
                {
                     $cities .=",<br>".$data['blenquiry'][$i]['glusr_buyprd_loc_city2_name'];
                }
                if(isset($data['blenquiry'][$i]['glusr_buyprd_loc_city3_name']) && trim($data['blenquiry'][$i]['glusr_buyprd_loc_city3_name']) !='')
                {
                     $cities .=",<br>".$data['blenquiry'][$i]['glusr_buyprd_loc_city3_name'];
                }
                
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >'.trim($cities,',<br>').'</td>';
               
                
                
                
                echo '<td class="admintext1" align="left" bgcolor="#eaeaea" >'.$data['blenquiry'][$i]['glusr_buyprd_insert_date'].'</td>
                <td class="admintext1" align="left" bgcolor="#eaeaea" >'.$data['blenquiry'][$i]['glusr_buyprd_orig_src_date'].'</td>
                </tr>';
             
                $i++;
            }
             }   
            
            echo '</tbody></table><br/></form>';
            

  }
     
}          


 if($data['blenquiry']==NULL and $data['organic']==NULL)
 {
 echo 'No Record Found';
 echo '<br/>';
 }
 
?>