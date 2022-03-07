<?php ?>
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
    select{
        width: 100px !important;
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
    #dataInline{
        display:flex;
        justify-content: left;
    }
    #dataInline div{
        display:flex;
        align-items:center;
        margin-right: 20px;
    }
    #loaderImg{
        width:100%;
        height:300px;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    #loaderImg>img{
        width:100px;
    }
</style>





<LINK HREF="css/report.css" REL="STYLESHEET" TYPE="text/css">

<html>
    <body>
        <table>
            <thead>
                <th class="head_blue" colspan="6"><b>Intent Report</b></th>
            </thead>
            <tbody>
                <tr>

                    <td style="text-align:left;">
                        <label style="background-color:transparent;">Date:</label>
                    </td>

                     <td style="text-align:left;">
                        <div id="date-wise-data" style="display:none;">
                            <label style="background-color:transparent;">From:</label>
                            <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>">

                            <label style="background-color:transparent;">To:</label>
                            <input type="date" id="end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div id="non-date-wise-data">
                            <label style="background-color:transparent;">On:</label>
                            <input type="date" id="data_date" name="data_date" disabled="true" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </td>

                    <td style="text-align:left;">
                        <label style="background-color:transparent;">Type:</label>
                    </td>

                    <td style="text-align:left;">
                        <div id="dataInline">
                            <div>
                                <input type="radio" id="modid-wise" class="type" name="modid-wise" value="modid-wise">
                                <label for="modid-wise">Modid Wise</label><br>
                            </div>

                            <div>
                                <input type="radio" id="intent-type-wise" class="type" name="intent-type-wise" value="intent-type-wise">
                                <label for="intent-type-wise">Intent Type Wise</label><br>
                            </div>

                            <div>
                                <input type="radio" id="rag-wise" class="type" name="rag-wise" value="rag-wise">
                                <label for="rag-wise">RAG Wise</label><br>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="text-align:left;">
                        <label style="background-color:transparent;">Trend:</label>
                    </td>
                    <td style="text-align:left;">
                        <div id="dataInline">
                            <div>
                                <input type="radio" id="captured" class="trend" name="captured" value="captured">
                                <label for="captured">Captured</label><br>
                            </div>

                            <div>
                                <input type="radio" id="generation" class="trend" name="generation" value="generation">
                                <label for="generation">Generation</label><br>
                            </div>

                            <div>
                                <input type="radio" id="approved" class="trend" name="approved" value="approved">
                                <label for="approved">Approved</label><br>
                            </div>
                        </div>
                    </td>

                    <td style="text-align:left;">
                        RAG:
                    </td>

                    <td style="text-align:left;">
                        <select name="rag" class="selectType" id="rag" disabled>
                            <option value="0">ALL</option>
                            <option value="1">BLUE</option>
                            <option value="2">GREEN</option>
                            <option value="3">YELLOW</option>
                            <option value="4">ORANGE</option>
                            <option value="5">RED</option>
                        </select>
                    </td>


                </tr>
                <tr>
                    <!-- <td style="text-align:left;">
                        <label style="background-color:transparent;">Data:</label>
                    </td>
                    <td style="text-align:left;">
                        <div id="dataInline">
                            <div>
                                <input type="radio" id="date-wise" class="data" name="date-wise" value="date-wise">
                                <label for="date-wise">Date Wise</label><br>
                            </div>

                            <div>
                                <input type="radio" id="hourly" name="hourly" class="data" value="hourly">
                                <label for="hourly">Hourly</label><br>
                            </div>
                        </div>
                     </td> -->
                     <td></td>
                     <td></td>

                    <td style="text-align:left;">
                        Intent Type:
                    </td>

                    <td style="text-align:left;">
                        <select name="intent-type" class="selectType" id="intent-type" disabled>
                            <option value="0">ALL</option>
                            <option value="1">ENQUIRY</option>
                            <option value="2">SEARCH</option>
                            <option value="3">BROWSE</option>
                            <option value="4">MCAT VIDEO</option>
                            <option value="5">NAME/CITY EXIT ON BL FORM</option>
                            <option value="6">NAME/CITY EXIT ON ENQ FORM</option>
                            <option value="7">SINGLE CLICK ON ENQ FORM</option>
                            <option value="8">SINGLE CLICK ON BL FORM</option>
                            <option value="9">CALL INTENT</option>
                        </select>
                    </td>


                </tr>
                <tr>
                    <td colspan="2">
                    </td>
                    <td style="text-align:left;">
                        Mod ID:
                    </td>
                    <td style="text-align:left;">
                        <select name="mod-id" class="selectType"  id="mod-id" disabled>
                            <option value="0">ALL</option>
                            <option value="1">IMOB</option>
                            <option value="2">DIR</option>
                            <option value="3">ANDROID</option>
                            <option value="4">IOS</option>
                            <option value="5">FCP</option>
                            <option value="6">PRODDTL</option>
                            <option value="7">IM</option>
                            <option value="8">MY</option>
                        </select>
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
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// JAVASCRIPT //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
    const selectRag = document.getElementById('rag');
    const selectModid = document.getElementById('mod-id');
    const selectIntentType = document.getElementById('intent-type');
    const radModWise = document.getElementById('modid-wise');
    const radIntentTypeWise = document.getElementById('intent-type-wise');
    const radRagWise = document.getElementById('rag-wise');
    const radCaptured = document.getElementById('captured');
    const radGeneration = document.getElementById('generation');
    const radApproved = document.getElementById('approved');
    const radDatewise = document.getElementById('date-wise');
    const radHourly = document.getElementById('hourly');
    const dateWise = document.getElementById('date-wise-data');
    const nonDateWise = document.getElementById('non-date-wise-data');
    const trendArray = [radCaptured,radGeneration,radApproved];
    const dataArray = [radDatewise,radHourly];
    const typeArray = [radModWise,radIntentTypeWise,radRagWise];
    const selectArray = [selectRag,selectModid,selectIntentType];
    const intentDescide = [false,false];
    const generateBtn = document.getElementById('generateButton')


    let selectValue = Object.freeze({
        'modid-wise':selectModid,
        'intent-type-wise':selectIntentType,
        'rag-wise':selectRag
    });

    let selectMonth = Object.freeze({
        '01': 'january',
        '02': 'february',
        '03': 'march',
        '04': 'april',
        '05': 'may',
        '06': 'june',
        '07': 'july',
        '08': 'august',
        '09': 'september',
        '10': 'october',
        '11': 'november',
        '12': 'december',
    });

    let type = "";
    let trend = "";
    let data = "hourly";
    let st_date = "";
    let end_date = "";
    let hourly = false;
    let validate = true;
    let selectVal = null;

    // function selectValueAssignment(){
    //     selectVal =
    // }

    function isDateEmpty(strtDate,endDate,hourly){
        if(!strtDate)
        {
            alert("Start Date field is mandatory!!")
            return true
        }
        if(hourly == false)
        {
            if(!endDate){
                alert("End Date field is mandatory!!")
                return true
            }
        }
    }

    function dateRange(strt_date,end_date){
        let date1 = new Date(strt_date);
        let date2 = new Date(end_date);
        let Difference_In_Time = date2.getTime() - date1.getTime();
        let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
        if (Difference_In_Days>7){
            alert("The Difference in Transaction dates must not exceed the period of 7 days incase if no GLID provided")
            return false;
        }
        return true
    }

    function radioBtnController(target,eleArray){
        eleArray.forEach(element => {
            if(target.id === element.id){
                element.checked = true;
                selectEnabler(element.id,selectArray)
                }
            else {
                element.checked = false;
            }
        })
    }
    function selectResetHandler(){
        selectArray.forEach(select=>select.selectedIndex = "0")
        selectVal = null;
    }
    function selectEnabler(elementId,arr){
        switch (elementId) {
            case 'modid-wise':
                {
                    selectHelper(arr);
                    selectResetHandler();
                    selectModid.disabled = false;
                    break;
                }
            case 'intent-type-wise':
            {
                selectHelper(arr);
                selectResetHandler();
                selectIntentType.disabled = false;
                break;
            }
            case 'rag-wise':
            {
                selectHelper(arr);
                selectResetHandler();
                selectRag.disabled = false;
                break;
            }
            default:
                break;
        }
    }
    function selectHelper(arr){
        arr.forEach(element=>element.disabled=true);
    }

    function dateFormatChanger(date){
        let dateArray = date.split('-');
        if(dateArray[0] === '') return null;
        return `${dateArray[2]}-${selectMonth[dateArray[1]]}-${dateArray[0]}`;
    }








//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////// J-QUERY //////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function(){
        $('.type').click(function(e){
            radioBtnController(e.target,typeArray);
            type = e.target.id
        })
        $('.selectType').click(function(e){
            selectVal = e.target.value
        })
        $('.trend').click(function(e){
            radioBtnController(e.target,trendArray);
            trend = e.target.id
            if(trend === 'captured')radRagWise.disabled=true;
            else radRagWise.disabled=false;
            if(trend === 'approved')intentDescide[0]=true;
            else intentDescide[0]=false;
            if(intentDescide[0]&&intentDescide[1])radIntentTypeWise.disabled = true;
            else radIntentTypeWise.disabled = false;
        })
        $('.data').click(function(e){
            radioBtnController(e.target,dataArray);
            data = e.target.id
            // data = "hourly"
            if(data === 'date-wise')intentDescide[1]=true;
            else intentDescide[1]=false;
            if(intentDescide[0]&&intentDescide[1])radIntentTypeWise.disabled = true;
            else radIntentTypeWise.disabled = false;

            if(data === 'date-wise'){
                hourly = true
                dateWise.style.display = "block"
                nonDateWise.style.display = "none"
            }
            else{
                hourly = true
                dateWise.style.display = "none"
                nonDateWise.style.display = "block"
            }

        })


        $("#generateButton").click(function(){
            let url = window.location.href;
            let mid = url.split("=")[2];
            hourly = true;
            if(hourly == true){
                st_date = dateFormatChanger(document.getElementById('data_date').value);
                end_date=""
                validate = isDateEmpty(st_date,end_date,hourly);
            }else{
                st_date = dateFormatChanger(document.getElementById('start_date').value);
                end_date = dateFormatChanger(document.getElementById('end_date').value);
                validate = isDateEmpty(st_date,end_date,hourly);
                let date_validator = dateRange(document.getElementById('start_date').value,document.getElementById('end_date').value);
                validate = validate && date_validator;
            }
            let arr = [1,2,3];
            data = "hourly";
           if(type !=="" && trend !=="" && data !=="" && !validate){
                let selectQueryType = selectValue[type].value;
                $.ajax({

                url:`index.php?r=admin_eto/IntentReport/IntentReport&mid=${mid}&type=${type}&data=${data}&trend=${trend}&select=${selectQueryType}&start_date=${st_date}&end_date=${end_date}&array=${arr}&select=${selectVal}`,
                type:'post',
                beforeSend: function(){
                    generateBtn.disabled = true;
                    $("#orderData").html("<div id='loaderImg'><img src='./gifs/loader.gif'/></div>");
                },
                success:function(result){
                    generateBtn.disabled = false;
                    $("#orderData").html(result);
                }
                })
              }else if(type =="" || trend =="" || data ==""){
                  alert('Type , Trend and Data must not be left "BLANK!!!"')
              }
    })

})

</script>
