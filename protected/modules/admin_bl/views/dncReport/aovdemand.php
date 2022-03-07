<?php
ini_set('memory_limit', '-1');
if(!empty($result))
{
	if($req == 1 || $req == 4)
	{
		echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0">';
		$headingsArray = array("Organic","Inorganic","ISQ Fill-Rate","ISQ Fill-Rate >5","ISQ FILL RATE ASSOCIATE WISE, WHERE APPROVAL >5");	
		for($i=0;$i<5;$i++)
		{
			$heading = $headingsArray[$i];
			$data = isset($result[$i]) ? $result[$i] : array();
			$total = 0;
			
			echo '<TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" ><B>'.$heading.'</B></TD>';
			// if(!empty($data))
			// {
				// for($x = 0; $x < $counter;$x++)
				// {
					// $w = $x;
					// if($trend == 'hourly'){
						// $w = ($x <10) ? "0$x" : $x;
					// }
					
					// $value = isset($data[$w]['TOTAL']) ? $data[$w]['TOTAL'] : 0;
					// $total += $value;
					// echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$value.'</TD>';
				// }
				
				// $totvalue = ($total != 0) ? $total : 'NA';
				// echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$totvalue.'</TD>';				
			// }
			echo '</TR>';
		}
		echo '</table>';
	}
	elseif($req == 2 || $req == 5)
	{
		echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0">';
		$headingsArray = array('Unique Sold','Transaction','Wrong Product','Total BL NI','Wrong Product QRF','Irrelavant QRF','NPS','Fulfillment');		
		for($i=0;$i<6;$i++)
		{
			$heading = $headingsArray[$i];
			$data = isset($result[$i]) ? $result[$i] : array();
			$total = 0;
			
			echo '<TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" ><B>'.$heading.'</B></TD>';
			if(!empty($data))
			{
				for($x = 0; $x < $counter;$x++)
				{
					$w = $x;
					if($trend == 'hourly'){
						$w = ($x <10) ? "0$x" : $x;
					}
					
					$value = isset($data[$w]['TOTAL']) ? $data[$w]['TOTAL'] : 0;
					$total += $value;
					echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$value.'</TD>';
				}
				
				$totvalue = ($total != 0) ? $total : 'NA';
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$totvalue.'</TD>';				
			}
			echo '</TR>';
		}
		echo '</table>';
	}
	elseif($req == 3 || $req == 6)
	{
		echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0">';
		$headingsArray = array('MCAT Selection Error','Supplier Selection Error');	
		for($i=0;$i<2;$i++)
		{
			$heading = $headingsArray[$i];
			$data = isset($result[$i]) ? $result[$i] : array();
			$total = 0;
			
			echo '<TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" ><B>'.$heading.'</B></TD>';
			if(!empty($data))
			{
				for($x = 0; $x < $counter;$x++)
				{
					$w = $x;
					if($trend == 'hourly'){
						$w = ($x <10) ? "0$x" : $x;
					}
					
					$value = isset($data[$w]['ERROR']) ? $data[$w]['ERROR'] : 0;
					$total += $value;
					echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$value.'</TD>';
				}
				
				$totvalue = ($total != 0) ? $total : 'NA';
				echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$totvalue.'</TD>';				
			}
			echo '</TR>';
		}
		echo '</table>';
	}
	elseif($req == 7)
	{
		$total = 0;
		
		echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" ><B>ISQ Feedback Given</B></TD>';
		
		for($x = 0; $x < $counter;$x++)
		{
			$w = $x;
			if($trend == 'hourly'){
				$w = ($x <10) ? "0$x" : $x;
			}
			
			$value = isset($result[$w]['TOTAL']) ? $result[$w]['TOTAL'] : 0;
			$total += $value;
			echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$value.'</TD>';
		}
		
		$totvalue = ($total != 0) ? $total : 'NA';
		echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$totvalue.'</TD></TR></table>';
	}
	elseif($req == 8)
	{
		$total = 0;
		
		echo '<table align="CENTER" border="1" width="100%" cellpadding="0" cellspacing="0"><TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" ><B>Custom ISQ Inserted</B></TD>';
		for($x = 0; $x < $counter;$x++)
		{
			$w = $x;
			if($trend == 'hourly'){
				$w = ($x <10) ? "0$x" : $x;
			}
			
			$value = isset($result[$w]['TOTAL']) ? $result[$w]['TOTAL'] : 0;
			$total += $value;
			echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$value.'</TD>';
		}
		
		$totvalue = ($total != 0) ? $total : 'NA';
		echo '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  width="3%">&nbsp;'.$totvalue.'</TD></TR></table>';
	}
}
else{
	echo 'No data Found';
}