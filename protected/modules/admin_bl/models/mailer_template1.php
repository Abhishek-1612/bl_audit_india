<?php



echo <<<MSG
<html>
<head>
</script>
<title>HTML PREVIEW</title>
</head>
<body onload="return abc()">

<div style="padding:15px; width:600px; font-family:arial; font-size:12px;">
<script language="javascript">
document.write(opener.document.getElementById("textarea1").value);
</script>
</div>
</body>
</html>

MSG;




?>