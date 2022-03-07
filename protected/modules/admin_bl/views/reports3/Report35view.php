<?php

 echo '<div style="margin:0px auto;text-align:center;"><br><div style="font-weight:bold;">Tracking Report</div><br><table border="1" cellpadding="5" cellspacing="1" align="center" style="border-collapse:collapse"><tr bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER">
	<td>Date</td>
	<td>No. of Unique Visitors</td>
	<td>No. of leads viewed</td>
	</tr>';
 $i=0;
 if($c==1)
 {
 
 foreach($result as $arr1)
 {
  foreach($arr1 as $arr)
  {
   echo '<tr>
		<td>'.$result["SDT"][$i].'</td>
		<td>'.$result["UNIGLUSR"][$i].'</td>
		<td>'.$result["UNQIOFID"][$i].'</td>
		</tr>';
   $i++;
  }
  break;
 }
}

 $j=0;
 foreach($result1 as $arr1)
 {
  foreach($arr1 as $arr)
  {
      echo '<tr>
	<td>'.$result1["SDT"].'</td>
	<td>'.$result1["UNIGLUSR"].'</td>
	<td>'.$result1["UNQIOFID"].'</td>
	</tr>';
   $j++;
  }
  break;
 }

 echo '</table></div>';

?>