function upload()
{
    var type = $('input[name=radioAction]:checked').val();
    if(document.Search.S_attachment.value=="")
    {
        alert("Please Enter a  Excel File");
        return false;
    }
    if(document.Search.S_attachment.value)
    {
        var check=document.Search.S_attachment.value.split(".");
        if(check[1]!='xls')
        {
            alert("Please Enter Only Excel File");
            return false;
        }
    }
    return true;

}
function remove(del_val,data_val)
{
    if(data_val == 'excel_name')
    {
        document.Search.excel_name.value = del_val;
        document.Search.submit();
        return true;
    }
    if(data_val == 'excel')
    {
        document.Search.excel.value = del_val;
        document.Search.submit();
        return true;
    }
}

function process()
{
    document.getElementById('Upload').disabled=true;
}

function remove_file(file,type,act,mid,url){
    $.ajax({
        url: "/index.php?r=admin_eto/Bulkvendor/RemoveExcel&excel="+file,
        type: 'post',
        data: "",
        success: function(result) {
            $("#removedexcel").show();
            window.location.href = "index.php?r=admin_eto/Bulkvendor/Index&mid="+mid;
        }
    });
}

