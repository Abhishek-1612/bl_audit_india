<?php
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
?>
<style>
    *{
        box-sizing:border-box;
    }
    table, th, td {
      border: 1px solid;
      border-color:#bedaff;
    }
    .add_clickable.Disabled{
        color:grey;
    }
    .head_blue{
        background-color:#009DCC;
        color:white;
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
</style>
<!-- <sript src="js/jquery3.5.1.min.js"></script> -->
<LINK HREF="css/report.css" REL="STYLESHEET" TYPE="text/css">
<html>

<table>
    <thead>
        <th class="head_blue" colspan="6"><b>Seller BL Report Card</b></th>
    </thead>
    <tbody>
        <tr>
            <td style='display:flex;justify-content:left;padding:20px 40px 20px 40px;align-items:center;'>
                <select name="cred_type" id="credType">
                    <option value="glId">GL ID</option>
                    <!-- <option value="mobNo">Mobile No</option> -->
                </select>
                <input type="text" name="glid" id="glid" placeholder="Enter GL ID" />
                <input type="button" name="submit-btn" id="searchButton" value="Search">
            </td>
        </tr>
    </tbody>
</table>
    <!-- <div  style="background-color:#dff8ff;width:100%;display:flex;justify-content:center;align-items:center;padding:10px;margin-bottom:20px;">
        <h1 style="color:#333399;font-size:18px;"></h1>
    </div> -->
    

    
    
    

    <div id="result">
    
    </div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
let glid = 0;
const credType = document.getElementById("credType");

// validation for mobile and GL ID number
function idValidationHandler(str,mobile=false){
    if(str == ""){
        alert("No Values entered in GL ID");
        return true;
    }
    if(str.match(/[a-z]/)){
        alert("Invalid characters in Company ID");
        return true;
    }
    if(str.match(" ")){
        alert("Spaces are invalid in ID");
        return true;
    }
    if(str.match( /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)){
        alert('[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]+  are NOT ALLOWED');
        return true;
    }
    if (mobile && str.length != 10 ){
        alert("mobile number must be 10 digit by length")
        return true;        
    }

}

$(document).ready(
    function(){
    
    $('#searchButton').click(function(){
                let url = window.location.href;
                let mid = url.split("=")[2];
                let validate = false;
                glid=$('#glid').val().trim().toLowerCase();
                if (credType.value == "glId")
                    validate = idValidationHandler(glid);
                else validate = idValidationHandler(glid,true);
                result='';
                if (!validate){
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/ReportHeader&mid=${mid}&id=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                           $("#result").html(result);
                        }
                    });
                }            
            });



    
    // AJAX for Location Preference (DLP) - Current DLP
    $(document).on("change",'#credType',function(){
        if(credType.value == 'glId'){
            document.getElementById("glid").setAttribute('placeholder','Enter GL ID')
            
        }else document.getElementById("glid").setAttribute('placeholder','Enter Moblie Number')  
    }); 
            
    $(document).on('click','#locPrefBtn',function(){
                let url = window.location.href;
                let mid = url.split("=")[2];
                let locPrefBtnAttrib = document.getElementById("locPrefBtn").getAttribute("value");
                if(locPrefBtnAttrib === "Show more.."){
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/LocationPreference&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#prefBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#prefBody").html(result);
                            $("#locPrefBtn").attr("value","Hide...");
                        }
                    });
                }
                else{
                    $("#prefBody").html(null);
                    $("#locPrefBtn").attr("value","Show more..");
                }
                 
    })

//preferred Location Button
    $(document).on('click','#prefLocBtn',function(){
                let url = window.location.href;
                let mid = url.split("=")[2];
                let prefLocBtnAttrib = document.getElementById("prefLocBtn").getAttribute("value");
                if(prefLocBtnAttrib === "Show more.."){
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/PreferredLocation&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#prefLocBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#prefLocBody").html(result);
                            $("#prefLocBtn").attr("value","Hide...");
                        }
                    });
                }
                else{
                    $("#prefLocBody").html(null);
                    $("#prefLocBtn").attr("value","Show more..");
                }
    })

    // Negative location button
    $(document).on('click','#negLocBtn',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negLocBtnAttrib = document.getElementById("negLocBtn").getAttribute("value")
        if(negLocBtnAttrib === "Show more.."){ 
            $.ajax({
                url:`index.php?r=admin_eto/BLReport/NegativeLocations&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){$("#negLocBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                success:function(result){
                    $("#negLocBody").html(result);
                    $("#negLocBtn").attr("value","Hide..");
                }
            });
        }
        else{
            $("#negLocBody").html(null);
            $("#negLocBtn").attr("value","Show more..");
        }
    })

    function createDropDown(idName,idAttribName,elementName){
        let negativeNames = document.getElementById(idName)
        if(negativeNames.children[0])negativeNames.children[0].remove();
        let td = document.createElement(elementName);
        td.setAttribute("id",idAttribName)
        td.setAttribute("colspan","2");
        let negTd = negativeNames.appendChild(td);
        return negTd;
    }

    // function makeRemoveBtn()
    $(document).on('click','#removeEle',function(e){
        e.target.parentNode.remove();
    })

    // negative city names
    $(document).on('click','#negCityNames',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("negativeNamesCity","negativeCityNameList","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/NegativeCityNames&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){},
                success:function(result){
                    $('#negativeCityNameList').html(result);}
        })
    })
    $(document).on('click','#negCountryNames',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("negativeNamesCountry","negativeCountryNameList","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/NegativeCountryNames&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("country names coming")},
                success:function(result){
                   $('#negativeCountryNameList').html(result);}
        })
    })

    // preferred city
    $(document).on('click','#prefCityNames',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefNamesListCity","prefCityList","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredCityNames&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("city names coming")},
                success:function(result){
                    $('#prefCityList').html(result);}
        })
    })
    // preferred country
    $(document).on('click','#prefCountryNames',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefNamesListCountry","prefCountryList","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredCountryNames&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("ccountry names coming")},
                success:function(result){
                    $('#prefCountryList').html(result);}
        })
    })
    // preferred district
    $(document).on('click','#prefDistNames',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefNamesListDistrict","prefDistrictList","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredDistrictNames&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("ccountry names coming")},
                success:function(result){
                    $('#prefDistrictList').html(result);}
        })
    })
    // preferred state
    $(document).on('click','#prefStateNames',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefNamesListState","prefStateList","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredStateNames&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("ccountry names coming")},
                success:function(result){
                    $('#prefStateList').html(result);}
        })
    })

    // Preffered TOV button

    $(document).on('click','#prefTOVBtn',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let prefTOVBtnAttrib = document.getElementById("prefTOVBtn").getAttribute("value")
        if(prefTOVBtnAttrib === "Show more.."){  
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/PreferredTOV&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#prefTOVBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#prefTOVBody").html(result);
                            $("#prefTOVBtn").attr("value","Hide..");
                        }
                    });
        }
        else{
            $("#prefTOVBody").html(null);
            $("#prefTOVBtn").attr("value","Show more..");

        }
    })

    
    // TOV Slabs
    $(document).on('click','#TOVSlabsBtn',function(){ 
        let url = window.location.href;
        let mid = url.split("=")[2];
        let TOVSlabsBtnAttrib = document.getElementById("TOVSlabsBtn").getAttribute("value")
        if(TOVSlabsBtnAttrib === "Show more.."){  
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/TOVSlabs&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#TOVSlabsBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#TOVSlabsBody").html(result);
                            $("#TOVSlabsBtn").attr("value","Hide..");
                        }
                    });
        }
        else{
            $("#TOVSlabsBody").html(null);
            $("#TOVSlabsBtn").attr("value","Show more..");

        }
    })

    //prefered categories
    $(document).on('click','#prefCatBtn',function(){
        let url = window.location.href;
        let mid = url.split("=")[2]; 
        let prefCatBtnAttrib = document.getElementById("prefCatBtn").getAttribute("value")
        if(prefCatBtnAttrib === "Show more.."){  
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/PreferredCategories&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#prefCatBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#prefCatBody").html(result);
                            $("#prefCatBtn").attr("value","Hide..");
                        }
                    });
        }
        else{
            $("#prefCatBody").html(null);
            $("#prefCatBtn").attr("value","Show more..");

        }
    })

    // Business Type
    $(document).on('click','#busTypeBtn',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];  
        let busTypeBtnAttrib = document.getElementById("busTypeBtn").getAttribute("value")
        if(busTypeBtnAttrib === "Show more.."){  
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/BusinessType&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#busTypeBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#busTypeBody").html(result);
                            $("#busTypeBtn").attr("value","Hide..");
                        }
                    });
        }
        else{
                            $("#busTypeBody").html(null);
                            $("#busTypeBtn").attr("value","Show more..");
        }
    })




$(document).on('click','#mcatwiseBtn',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];  
        let mcatwiseBtnAttrib = document.getElementById("mcatwiseBtn").getAttribute("value")
        if(mcatwiseBtnAttrib === "Show more.."){  
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/McatwiseCallBack&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#mcatwiseBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#mcatwiseBody").html(result);
                            $("#mcatwiseBtn").attr("value","Hide..");
                        }
                    });
        }
        else{
                            $("#mcatwiseBody").html(null);
                            $("#mcatwiseBtn").attr("value","Show more..");
        }
    })

    $(document).on('click','#mcatwiserepliesBtn',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];  
        let mcatwiserepliesBtnAttrib = document.getElementById("mcatwiserepliesBtn").getAttribute("value")
        if(mcatwiserepliesBtnAttrib === "Show more.."){  
                    $.ajax({
                        url:`index.php?r=admin_eto/BLReport/McatwiseCallBack&mid=${mid}&glid=${glid}`,
                        type: 'post',
                        beforeSend: function(){$("#mcatwiserepliesBody").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br></DIV>");},
                        success:function(result){
                            $("#mcatwiserepliesBody").html(result);
                            $("#mcatwiserepliesBtn").attr("value","Hide..");
                        }
                    });
        }
        else{
                            $("#mcatwiserepliesBody").html(null);
                            $("#mcatwiserepliesBtn").attr("value","Show more..");
        }
    })

    $(document).on('click','#prefcatCountbuttonA',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefcatListA","prefCatListA","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredCat_A&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("pref cat coming A")},
                success:function(result){
                    $('#prefCatListA').html(result);
                }
        })
        
    })
    $(document).on('click','#prefcatCountbuttonB',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefcatListB","prefCatListB","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredCat_B&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("pref cat coming B")},
                success:function(result){
                    $('#prefCatListB').html(result);}
        })
    })
    $(document).on('click','#prefcatCountbuttonC',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefcatListC","prefCatListC","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredCat_C&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("pref cat coming C")},
                success:function(result){
                    $('#prefCatListC').html(result);}
        })
    })

    $(document).on('click','#prefcatCountbuttonD',function(){
        let url = window.location.href;
        let mid = url.split("=")[2];
        let negTd = createDropDown("prefcatListD","prefCatListD","DIV");
        $.ajax({
            url:`index.php?r=admin_eto/BLReport/PreferredCat_D&mid=${mid}&glid=${glid}`,
                type: 'post',
                beforeSend: function(){console.log("pref cat coming D")},
                success:function(result){
                    $('#prefCatListD').html(result);}
        })
     
    })

})

    
</script>


</html>

