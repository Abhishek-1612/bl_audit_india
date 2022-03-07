function removeFiles(file,mid){
	$.ajax({
		url: "/index.php?r=admin_marketplace/BulkIsq/RemoveMExcel&excel="+file,
		type: 'post',
		data: "",
		success: function(result) {   
			window.location.href = "index.php?r=admin_marketplace/BulkIsq/Add&mid="+mid;
		}
	});
}

function upload()
{	
	var att = document.Search.S_attachment.value;
	if(document.Search.S_attachment.value=="")
	{
		alert("Please Enter a  Excel(XLSX) File");
		return false;
	}
	if(document.Search.S_attachment.value)
	{
		var check=document.Search.S_attachment.value.split(".");
		if(check[1]!='xlsx')
		{
			alert("Please Enter Only Excel(XLSX) File");
			return false;
		}
	}
        var x = $('input[name=optradio]:checked').val();
        $('#process_name').val(x);
        
	return true;

}

function upload2()
{	
	var att = document.Search.S_attachment.value;
	if(document.Search.S_attachment.value=="")
	{
		alert("Please Enter a  CSV File");
		return false;
	}
	if(document.Search.S_attachment.value)
	{
		var check=document.Search.S_attachment.value.split(".");
		if(check[1]!='csv')
		{
			alert("Please Enter Only CSV File");
			return false;
		}
	}
	return true;
}

