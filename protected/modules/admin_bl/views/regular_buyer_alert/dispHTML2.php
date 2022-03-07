<?php


echo '<html>
     <head><LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
      <script language="javascript" src="/js/calendar.js"></script>';







     echo '</head>

     <body>
  <FORM name="searchForm" METHOD="post" ACTION="/index.php?r=admin_bl/Regular_buyer_alert/Letsee&mid=99" STYLE="margin-top:0;margin-bottom:0;" >
  <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
  <TR>
    
    <TD bgcolor="#dff8ff" ALIGN="CENTER" colspan="2"><font COLOR =" #333399"><b>Generation Report</b></font></TD>
    
  </TR>
  
  <TR>
    <TD WIDTH="150" HEIGHT="30">&nbsp;Select Period</TD>  
    <TD>From:
    <input name="start_date" type="text"  SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchForm.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="start_date" TYPE="text" readonly="readonly">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          To:
    <input name="end_date" type="text"  SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchForm.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="end_date" TYPE="text" readonly="readonly">
    </TD>
    
    </TR>
                <TR>
                <td>MODID</td>
        <TD ><SELECT name="modid">';
        
foreach($a as $v)
    {
    echo '<option> '.$v.'</option>'; 
    }

            
            
       echo '</TR>';
    
echo '<TR>
  <TD>&nbsp;Country</TD>
        <TD>
        <TABLE width="60%" BORDER="0" CELLPADDING="1" CELLSPACING="0">
          <TR>';

echo '<TD><INPUT TYPE="RADIO" NAME="country" VALUE="NOR" ';

echo '></TD>
    <TD STYLE="font-family:arial;font-size:12px;">India&nbsp;&nbsp;</TD>
    <TD><INPUT TYPE="RADIO" NAME="country" VALUE="REM" ';



echo '></TD>
    <TD STYLE="font-family:arial;font-size:12px;">Foreign&nbsp;&nbsp;</TD>';
    '</TR>';
echo '</TABLE></TD></TR>';

echo '<TR>
    <TD colspan="2" align="center">
    <input type="hidden" name="action" value="sellstatus">
    <INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Search">
    </TD>
  </TR></table>
  </FORM><br>'; 
if(isset($_REQUEST['Submit1']))
{



 oci_fetch_all($intent,$rec);
 //print_r($rec);

/*
 echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
          <tbody>
                            <tr><td BGCOLOR="#dff8ff" ALIGN="LEFT"><b>Total Generated:</b></td><td BGCOLOR="#dff8ff">' . $data['generated'] . '</td></tr>
                              <tr><td BGCOLOR="#dff8ff" ALIGN="LEFT"><b>Total Enquiries Approved:</b></td><td BGCOLOR="#dff8ff">' . $data['enq_approved'] . '</td></tr>';
                          */
$i=0;
     
 echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
 <TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;</TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Captured</B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Generated</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approved</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approved %</B></TD>
  
 </TR>
 <TR> 
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Intent</B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD></TR>';
 
         oci_fetch_all($intent,$rec);
    
     if(!empty($rec)){
     foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
     $APP=isset($rec['APPROVED_INTENTS'][$i]) ? $rec['APPROVED_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERATED_INTENTS'][$i]) ? $rec['GENERATED_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_INTENTS'][$i].'</TD> 
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERATED_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  $i=$i+1;
   
   }
   }
   
   echo '<TR> 
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Types</B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD></TR>
<TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Enquiry Intent</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
  
 </TR>';
 
 $i=0;
 
  if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
      $APP=isset($rec['APPROVED_ENQUIRY_INTENTS'][$i]) ? $rec['APPROVED_ENQUIRY_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERTED_ENQUIRY_INTENTS'][$i]) ? $rec['GENERTED_ENQUIRY_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
     if(isset($rec['CAPTURED_ENQUIRY_INTENTS'][$i]) && ($rec['CAPTURED_ENQUIRY_INTENTS'][$i] !=0))
     {
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_ENQUIRY_INTENTS'][$i].'</TD> 
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_ENQUIRY_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_ENQUIRY_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  }
  $i=$i+1;
   
   }
   }
 
  echo '
<TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Call Intent</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
  
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
      $APP=isset($rec['APPROVED_CALL_INTENTS'][$i]) ? $rec['APPROVED_CALL_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERTED_CALL_INTENTS'][$i]) ? $rec['GENERTED_CALL_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
     if(isset($rec['CAPTURED_CALL_INTENTS'][$i]) && ($rec['CAPTURED_CALL_INTENTS'][$i] !=0))
     {
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_CALL_INTENTS'][$i].'</TD>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_CALL_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_CALL_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  }
  $i=$i+1;
   
   }
   
   }
 

      

      echo '
<TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>BL Form Intent</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
  
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
     $APP=isset($rec['APPROVED_BLFORM_INTENTS'][$i]) ? $rec['APPROVED_BLFORM_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERTED_BLFORM_INTENTS'][$i]) ? $rec['GENERTED_BLFORM_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
     if(isset($rec['CAPTURED_BLFORM_INTENTS'][$i]) && ($rec['CAPTURED_BLFORM_INTENTS'][$i] !=0))
     {
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_BLFORM_INTENTS'][$i].'</TD>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_BLFORM_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_BLFORM_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  }
  $i=$i+1;
   
   }
   }
   
       echo '
<TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Search Intent</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
  
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
      $APP=isset($rec['APPROVED_SEARCH_INTENTS'][$i]) ? $rec['APPROVED_SEARCH_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERTED_SEARCH_INTENTS'][$i]) ? $rec['GENERTED_SEARCH_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
      if(isset($rec['CAPTURED_SEARCH_INTENTS'][$i]) && ($rec['CAPTURED_SEARCH_INTENTS'][$i] !=0))
     {
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_SEARCH_INTENTS'][$i].'</TD>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_SEARCH_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_SEARCH_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  }
  $i=$i+1;
   
   }
   }
    echo '
<TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Browse Intent</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
  
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
      $APP=isset($rec['APPROVED_BROWSE_INTENTS'][$i]) ? $rec['APPROVED_BROWSE_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERTED_BROWSE_INTENTS'][$i]) ? $rec['GENERTED_BROWSE_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
     if(isset($rec['CAPTURED_BROWSE_INTENTS'][$i]) && ($rec['CAPTURED_BROWSE_INTENTS'][$i] !=0))
     {
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_BROWSE_INTENTS'][$i].'</TD>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_BROWSE_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_BROWSE_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  }
  $i=$i+1;
   
   }
   }
    echo '
<TR>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>BL Intent</B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD> 
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
    <TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>
  
 </TR>';
 
 $i=0;
 if(!empty($rec)){
  foreach($rec['IIL_ENQ_INTEREST_MODID'] as $temp)
     {
     $APP=isset($rec['APPROVED_BL_INTENTS'][$i]) ? $rec['APPROVED_BL_INTENTS'][$i] : 0;
     $GEN=isset($rec['GENERTED_BL_INTENTS'][$i]) ? $rec['GENERTED_BL_INTENTS'][$i] : 0;
     if($GEN)
     {
     $APP_PER=($APP/$GEN)*100;
     $APP_PER=round($APP_PER,2);
     }
     else
     {
     $APP_PER=0;
     }
      if(isset($rec['CAPTURED_BL_INTENTS'][$i]) && ($rec['CAPTURED_BL_INTENTS'][$i] !=0))
     {
  echo '<TR>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['IIL_ENQ_INTEREST_MODID'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['CAPTURED_BL_INTENTS'][$i].'</TD>  
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['GENERTED_BL_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$rec['APPROVED_BL_INTENTS'][$i].'</TD>
    <TD  STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$APP_PER.'%</TD>
  </TR>';
  }
  $i=$i+1;
   
   }
   }
        echo '</table>';
  









          
                       /*  echo'</table>';
*/
}




    
?>