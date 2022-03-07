<?php 
$action='BB_ADD';
$process_time='12:04pm';
$content='Testing Mail';

echo 'hii22';die;
//check_old_mail();


// public function mailForXlsAttachment($filename_return,$excelfile_download,$email,$sub){
//             $file_size = filesize($excelfile_download);
//                     $handle    = fopen($excelfile_download, "r");
//                     $content   = fread($handle, $file_size);
//                     fclose($handle);
//                     $content = chunk_split(base64_encode($content));
//                     $uid     = md5(uniqid(time()));
//                     $name    = basename($excelfile_download);
//                     $file_size = filesize($excelfile_download);
//                     $handle    = fopen($excelfile_download, "r");
//                     $content   = fread($handle, $file_size);
//                     fclose($handle);
//                     $content = chunk_split(base64_encode($content));
//                     $uid     = md5(uniqid(time()));
//                     $name    = basename($excelfile_download);
//                     $header  = "From: Gladmin-Team <gladmin-team@indiamart.com>\r\n";
//                     $header .= "Cc: gladmin-team@indiamart.com \r\n";
//                     $header .= "Reply-To: " . $email . "\r\n";
//                     $header .= "MIME-Version: 1.0\r\n";
//                     $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
//                     $message = "This is a multi-part message in MIME format.\r\n";
//                     $message .= "--" . $uid . "\r\n";
//                     $message .= "Content-type:text/plain; charset=iso-8859-1\r\n";
//                     $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
//                     $message .= "--" . $uid . "\r\n";
//                     $message .= "Content-Type: application/ms-excel; name=\"" . $filename_return . "\"\r\n";
//                     $message .= "Content-Transfer-Encoding: base64\r\n";
//                     $message .= "Content-Disposition: attachment; filename=\"" . $filename_return . "\"\r\n\r\n";
//                     $message .= $content . "\r\n\r\n";
//                     $message .= "--" . $uid . "--";
//                     if (mail($email, $sub, $message, $header)){
//                         unlink($excelfile_download);
//                     }
//                     else
//                         echo "mail send ... ERROR!";
//     }


function check_old_mail(){
    $email = "sunny.sharma@indiamart.com";
    $excelfile_download="/home3/indiamart/public_html/excel_download/abc.xls";
    $filename_out="abc.xls";
    $uid     = md5(uniqid(time()));

    $message = "";
    $body="Please find the attached excel file for complete status of ISQ Bulk Copy\n\n";
     $file_size = filesize($excelfile_download);
      $handle    = fopen($excelfile_download, "r");
      $content   = fread($handle, $file_size);
      fclose($handle);
      $content = chunk_split(base64_encode($content));
      $uid     = md5(uniqid(time()));
      $name    = basename($excelfile_download);
      $file_size = filesize($excelfile_download);
      $handle    = fopen($excelfile_download, "r");
      $content   = fread($handle, $file_size);
      fclose($handle);
      $content = chunk_split(base64_encode($content));
     $content = chunk_split(base64_encode($content));
			  $uid     = md5(uniqid(time()));
			  $message = "";
			  $header  = "From: Gladmin-Team <gladmin-team@indiamart.com>\r\n";
                    $header .= "Cc: gladmin-team@indiamart.com \r\n";
                    $header .= "Reply-To: " . $email . "\r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
                  
                    $header .= "--" . $uid . "\r\n";
                    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
                    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                    $header .= "--" . $uid . "\r\n";
                    $header .= "Content-Type: application/ms-excel; name=\"" . $filename_out . "\"\r\n";
                    $header .= "Content-Transfer-Encoding: base64\r\n";
                    $header .= "Content-Disposition: attachment; filename=\"" . $filename_out . "\"\r\n\r\n";
                    $header .= $content . "\r\n\r\n";
                    $header .= "--" . $uid . "--";
			  $sub = "test mail";
			  
			  if (mail($email, $sub,"", $header));
			  else
			    echo "mail send ... ERROR!";
		  
}

?>

