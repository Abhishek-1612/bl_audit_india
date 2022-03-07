<?php
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
?>
<style>
    *{
        box-sizing:border-box;
    }
    a{
        cursor: pointer;
        color:#0094D0;
    }
    button.img-display{
        background-color:transparent;
        border:none;
        color: #0094D0;
    }
    .page_no.active{
        background-color:white;
        color: grey;
        text-decoration:underline; 
    }
    #pagination{
        width:100%;
        display:flex;
        align-items: center;
        padding: 0 20px;
        justify-content:space-between;
    }
    #page-controller{
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .first_page,.last_page,.decrease_page_one,.increase_page_one{
        margin-left:5px;
        margin-right:5px;
    }
    .controls{
        font-size: 24px;
        margin: 0 10px;
    }
    .page_no{
        padding:10px;
        background-color:#009DCC;
        margin-right: 10px;
        border-radius:5px;
        color:white;       
    }
    .page_link{
        text-decoration:none;
    }
    #content{
        width:auto !important;
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
    thead th{
        background-color:#dff8ff;
    }
    td, th{
        text-align:center;
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
    #reportDataDwnld{
        width: 100%;
        padding: 20px 0;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .modal,.prodModal{
        position:fixed;
        top:0;
        left:0;
        width: 100vw;
        height: 100vh;
        z-index: 100;
        overflow-y:auto;
        background-color: rgba(0,0,0,0.6);
        display:none;
        /* padding-top:50px; */
        align-items:center;
        justify-content:center;
    }
    .img-holder{
        display:flex;
        position:relative;
        padding: 0 5px;
        background-color:#BDDAFD;
        border-radius:4px;
        align-items:center;
        justify-content:center; 
    }
    #close-btn{
        position:absolute;
        top:0;
        left:0;
        display:none;
        color:white;
        background-color:transparent;
    }
    #fullReportData{
        /* padding: 40px 0; */
    }
    #ListDownload{
        width: 100%;
        display:flex;
        align-items:center;
        justify-content:center;
    }
</style>
<LINK HREF="css/report.css" REL="STYLESHEET" TYPE="text/css">

<html>
    <body>
        <table>
            <thead>
                <th class="head_blue" colspan="6"><b>Order Detail</b></th>
            </thead>
            <tbody>
                <tr>

                    <td style="text-align:left;">
                        <label style="background-color:transparent;">Order Stage:</label>
                        <select name="order_stage" id="order_stage">
                            <option value="1">Order Placed</option>
                            <option value="2">Order Accepted</option>
                            <option value="3">Order Cancelled</option>
                            <option value="4">Order Shipped</option>
                            <option value="5">Order Delivered</option>
                        </select>
                    </td>

                     <td style="text-align:left;">
                        <label style="background-color:transparent;">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>">
                    </td>

                    <td style="text-align:left;">
                        <label style="background-color:transparent;">End Date:</label>
                        <input type="date" id="end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
                    </td>

                   
                </tr>
                <tr>
                    <td style="text-align:left;">
                        <label style="background-color:transparent;">GL User Type:</label>
                        <select name="glusr_flag" id="glusr_flag">
                            <option value="S">Seller</option>
                            <option value="B">Buyer</option>
                        </select>
                    </td>
                    <td style="text-align:left;">
                        <label style="background-color:transparent;">GLID:</label>
                        <input type="text" name="glid" id="glid"  />
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding:20px 0;">
                        <div style="display:flex;justify-content:center;align-items:center;">
                            <input type="button" name="submit-btn" id="generateButton" value="Generate Report">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="orderData"></div>
        <div id="reportDataDwnld"></div>
        <div id="ModalData"></div>
        <div id="ReportModal" style="position:relative;">
            <div id="modalCloseController" style="position:absolute;z-index:400;top:10px;left:80%;"></div>
            <div id="ReportModalData"></div>
        </div>
        <div id="ListDownload"></div>
        
    </body>
</html>
<script language="javascript" type="text/javascript" src="./js/jquery.min.js"></script>
<script>
let glid = 0;


// validation for mobile and GL ID number
function idValidationHandler(str,mobile=false,strt_date=0,end_date=0){
    if(str === ""){
    var date1 = new Date(strt_date);
    var date2 = new Date(end_date);
    var Difference_In_Time = date2.getTime() - date1.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    if (Difference_In_Days>7){
        alert("The Difference in Transaction dates must not exceed the period of 7 days incase if no GLID provided")
        return true;
    }
    }
    if(str.match(/[a-z]/)){
        alert("Invalid characters in GL ID");
        return true;
    }
    if(str.match(" ")){
        alert("Spaces are invalid in GL ID");
        return true;
    }
    if(str.match( /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)){
        alert('[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]+  are NOT ALLOWED');
        return true;
    }
   

}

function isDateEmpty(strtDate,endDate){
    if(!strtDate){
        alert("Start Date field is mandatory!!")
        return true
        }
    if(!endDate){
        alert("End Date field is mandatory!!")
        return true
        }
}

$(document).ready(
    function(){
    
    $('#generateButton').click(function(){
                let url = window.location.href;
                let validate = false;
                let mid = url.split("=")[2];
                gl_user = $('#glusr_flag').val();
                order_stage = $('#order_stage').val();
                start_date = $('#start_date').val(); 
                end_date = $('#end_date').val();
                let DateValidation = isDateEmpty(start_date,end_date)
                glid=$('#glid').val().trim().toLowerCase();
                validate = idValidationHandler(glid,true,start_date,end_date);
                result='';
                if (!validate && !DateValidation){
                    $.ajax({
                        url:`index.php?r=admin_eto/orders/GenerateReport&mid=${mid}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}&page_no=1`,
                        type: 'post',
                        beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            let btnElement = "<button id='lstDownload'>Download Complete List</button> .csv"
                           $('#orderData').html(result)
                           const validateData = document.getElementById('dataTable').getAttribute('data-true')
                           if(validateData === 'true') $('#ListDownload').html(btnElement)
                        }
                    });
                }            
            });

$(document).on('click','#lstDownload',function(){
            let totalData = document.getElementById('data_amount').innerText;
            let url = window.location.href;
            let mid = url.split("=")[2];
            gl_user = $('#glusr_flag').val();
            order_stage = $('#order_stage').val();
            start_date = $('#start_date').val(); 
            end_date = $('#end_date').val();
            $.ajax({
                url:`index.php?r=admin_eto/orders/CSVListDownloader&mid=${mid}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}&last_value=${totalData}`,
                type:'post',
                success:function(result){
                    if(result === 'false') alert("You don't permission for the action" )
                    else if(result !== ''){
                        let jsonObj = JSON.parse(result)
                        const headers = Object.keys(jsonObj[0])
                        let csvRows = []
                        csvRows.push(headers.join(','))

                        for(const row of jsonObj){
                            const values = headers.map(header=> {
                                if(header == 'product_image'){
                                    row[header]=row[header].replace( /,/g,' ')
                                    }
                                if(row[header] === null)row[header]="";
                                const escaped = (''+row[header]).replace(/"/g,'\\"')
                                return `"${escaped}"`
                            })
                            csvRows.push(values.join(','));
                        }
                        const csvData = csvRows.join('\n');
                        const blob = new Blob([csvData],{type: 'text/csv'})
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.setAttribute('hidden','')
                        a.setAttribute('href',url)
                        a.setAttribute('download','download.csv');
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }
                    else alert('No data to download!!');
                    }
                   
            })
})

$(document).on('click','.img-display',function(e){
    const element = e.target
    let dataImg = element.getAttribute('data-img')
    let url = window.location.href;
    let mid = url.split("=")[2];
    $.ajax({
            url:`index.php?r=admin_eto/orders/ModalCaller&mid=${mid}&img=${dataImg}`,
            type: 'post',
            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
            success:function(result){
                $('#ModalData').html(result)
                $('#ModalData').css('display','flex')
                $('.modal').css('display','flex')
            }
        });
})
$(document).on('click','.page_link',function(e){
    e.preventDefault();
})  


$(document).on('click','.page_no', function (e) {
    let url = window.location.href;
    gl_user = $('#glusr_flag').val();
    order_stage = $('#order_stage').val();
    start_date = $('#start_date').val();
    end_date = $('#end_date').val();
    const total_data = document.getElementById('data_amount').innerText;
    let mid = url.split("=")[2];
    let page_num = e.target.textContent;

    
    $.ajax({
        
            url:`index.php?r=admin_eto/orders/ListPagination&mid=${mid}&page_no=${page_num}&total_data=${total_data}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}`,
            type: 'post',
            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
            success:function(result){
                $('#orderData').html(result)
                const pageNum = document.querySelectorAll('.page_no');
                pageNum.forEach(element => {
                        element.className.remove='active';
                        if(element.innerText == page_num)
                        {
                            element.classList.add('active');
                        }                    
                });
                
            }
        });           
});

$(document).on('click','.prodId',function(e){
    const oid = e.target.innerText;
    let url = window.location.href;
    let mid = url.split("=")[2];
    $.ajax({
        url:`index.php?r=admin_eto/orders/getFullOrderDetailGladmin&mid=${mid}&oid=${oid}`,
        type: 'post',
        beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
        success:function(result){
            let modalCover = "<div id='productModal' class='prodModal' style='overflow-y:auto;'><div class='img-holder'><div id='fullReportData'></div></div></div>"
            $('#ReportModalData').html(modalCover)
            $('.prodModal').css('display','flex')
            $('#fullReportData').html(result)
        }
    })

})

$(document).on('click','#btnProdModalClose',function(){
    $('#productModal').css('display','none')
})
$(document).on('click','#btnModalClose',function(){
    $('#ModalData').css('display','none')
})

$(document).on('click','.increase_one_page',function(e){
    let url = window.location.href;
    gl_user = $('#glusr_flag').val();
    order_stage = $('#order_stage').val();
    start_date = $('#start_date').val();
    end_date = $('#end_date').val();
    let mid = url.split("=")[2];
    const total_data = document.getElementById('data_amount').innerText;
    const pageNum = document.querySelectorAll('.page_no');
                pageNum.forEach(element => {
                        if(element.className.match('active') !== null )
                        {
                            page_no = parseInt(element.innerText);
                        }                    
                });
                if(page_no+1 <= parseInt(pageNum[pageNum.length-1].innerText))
                {
                $.ajax({
        
                        url:`index.php?r=admin_eto/orders/ListPagination&mid=${mid}&page_no=${page_no+1}&total_data=${total_data}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $('#orderData').html(result)
                            const pageNum = document.querySelectorAll('.page_no');
                            
                                pageNum.forEach(element => {
                                    if(element.innerText == page_no+1)
                                    {
                                        element.classList.add('active');
                                    }                    
                                });            
                            }
                        });
                }

})
$(document).on('click','.decrease_one_page',function(e){
    let url = window.location.href;
    gl_user = $('#glusr_flag').val();
    let mid = url.split("=")[2];
    order_stage = $('#order_stage').val();
    start_date = $('#start_date').val();
    end_date = $('#end_date').val();
    const total_data = document.getElementById('data_amount').innerText;
    const pageNum = document.querySelectorAll('.page_no');
                pageNum.forEach(element => {
                        if(element.className.match('active') !== null )
                        {
                            page_no = parseInt(element.innerText);
                        }                    
                });
                if(page_no-1 >= 1)
                {
                $.ajax({
        
                        url:`index.php?r=admin_eto/orders/ListPagination&mid=${mid}&page_no=${page_no-1}&total_data=${total_data}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $('#orderData').html(result)
                            const pageNum = document.querySelectorAll('.page_no');
                            
                                pageNum.forEach(element => {
                                    if(element.innerText == page_no-1)
                                    {
                                        element.classList.add('active');
                                    }                    
                                });            
                            }
                        });
                }

})

$(document).on('click','.first_page', function (e) {
    let url = window.location.href;
    gl_user = $('#glusr_flag').val();
    order_stage = $('#order_stage').val();
    start_date = $('#start_date').val();
    end_date = $('#end_date').val();
    let mid = url.split("=")[2];
    const total_data = document.getElementById('data_amount').innerText;
    $.ajax({
        
            url:`index.php?r=admin_eto/orders/ListPagination&mid=${mid}&page_no=1&total_data=${total_data}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}`,
            type: 'post',
            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
            success:function(result){
                $('#orderData').html(result)
                const pageNum = document.querySelectorAll('.page_no');
                pageNum.forEach(element => {
                        if(element.innerText == 1)
                        {
                            element.classList.add('active');
                        }                    
                });
                
            }
        });           
});
$(document).on('click','.last_page', function (e) {
    let url = window.location.href;
    gl_user = $('#glusr_flag').val();
    order_stage = $('#order_stage').val();
    start_date = $('#start_date').val();
    end_date = $('#end_date').val();
    let mid = url.split("=")[2];
    const last_page = document.getElementById('last_page').innerText;
    const total_data = document.getElementById('data_amount').innerText;
    $.ajax({
        
            url:`index.php?r=admin_eto/orders/ListPagination&mid=${mid}&page_no=${last_page}&total_data=${total_data}&gl_user=${gl_user}&order_stage=${order_stage}&start_date=${start_date}&end_date=${end_date}&glid=${glid}`,
            type: 'post',
            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
            success:function(result){
                $('#orderData').html(result)
                const pageNum = document.querySelectorAll('.page_no');
                pageNum.forEach(element => {
            
                        if(element.innerText == last_page)
                        {
                            element.classList.add('active');
                        }                 
                });   
            }
        });           
});
    
    });
</script>