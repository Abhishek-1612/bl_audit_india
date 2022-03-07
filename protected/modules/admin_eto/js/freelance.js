var autoCheck2=false;
var autoCheck1=false;
var auto_ajax_call = 0;
var cat_mgr = true;
  var freelance = false;
var mcat;
var empid;

var today = new Date();
  
$(document).mouseup(function (e) {
  var container = $("#divState_empreport");
  var mcat_container=$("#mcatsmain");
  if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.hide();
  }
  if (!mcat_container.is(e.target) && mcat_container.has(e.target).length === 0) {
    mcat_container.hide();
}
});

$(document).ready(function () {
   $('#headline').hide();
  $("#export_btn").hide();
  $("input[type='radio']").click(function () {
    let radioValue = $("input[name='radio1']:checked")?.val();
    if (radioValue && (radioValue == "2" || radioValue == "3")) {
      $(".Status").hide();
    } else {
      $(".Status").show();
    }
  });
  $("#get_report").click(function () {
      let val=check();
      if(val==true){
    let radioValue = $("input[name='radio1']:checked")?.val();
    $('.note').hide();
    $('#export_btn').hide();
     
    if($('#mcat_label').val()==0){
      mcat= document.getElementById('mcat_id').value=" ";
    }
    else{
      mcat=$('#mcat_id').val();
    }
    if($('#emp_name').val()==0){
      empid=document.getElementById('emp_id').value=" ";  
    }
    else{
      empid=$('#emp_id').val();
    }
    if (radioValue == undefined) {
      alert("fill all the details");
    }

    let job_type = $("#job_type").val() || 0;
    if (radioValue && (radioValue == "1" || radioValue == "2")) {
      if (job_type == 1) {
        $("#noteforaudit").html('<h4>Products Reviewed after 18 May are only available for Audit for MCAT Enrichment.</h4>');        
      } else if(job_type == 8) {
        $("#noteforaudit").html('<h4>Products Reviewed after 15 May are only available for Audit for MCAT Cleaning.</h4>');
      }
    }

    if (radioValue && radioValue == "2") {
      
        $("#result3").hide();
        
          // if(empid>0){
          //   if(autoCheck1==true){
          //     showfreelanceDataAll();
          //   }else{
          //     alert("Please choose from auto suggest");
          //   }
          // }
          // else if(empid==0 && ($('#emp_name').val()).length>0){
          //   alert("Please choose from auto suggest");
          // }
          // else{
          showfreelanceDataAll();
          // }
     } 
    else if (radioValue && radioValue == "1") {
    
      $("#result1").hide();
      $("#result2").hide();
      $("#result3").show();
      showCategoryDetail();
      
     }
    
  }
  });
  if ($("#start_date").length > 0){
  $("#start_date").datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    beforeShow: function () {
      let status = $("#job_status").val();
      if (status != 6 ||  freelance==true) {
        let dt = $("#end_date").datepicker('getDate');
        if (dt) {
          return {
            maxDate: dt, minDate:'-10y'
          };
        } else {
          return {
            maxDate: today,  minDate:'-10y'
          };
        }
      } else if (cat_mgr == true && status == 6) {
        let dt = $("#end_date").datepicker('getDate');
        let dt1 = $("#end_date").datepicker('getDate');

        if (dt) {
          dt.setDate(dt.getDate() - 60);
          return {
            minDate: dt,
            maxDate: dt1
          };
        } else {
          return {
            maxDate: today,
            minDate: today.getDate() - 60
          };
        }
      }
    }

  });
  }
  if ($("#end_date").length > 0){
  $("#end_date").datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    maxDate: today,
    beforeShow: function () {
      let status = $("#job_status").val();
      if (status != 6 ||  freelance==true) {
        let dt = $("#start_date").datepicker('getDate');
        if (dt != null) {
          return {
            minDate: dt,
            maxDate: today
          };
        } else {
          return {
            maxDate: today,

          };
        }

      } else if (cat_mgr == true && status == 6) {

        let dt = $("#start_date").datepicker('getDate');
        let dt1 = $("#start_date").datepicker('getDate');
        if (dt != null) {
          dt.setDate(dt.getDate() + 60);

          return {
            minDate: dt1,
            maxDate: dt > today ? today : dt
          };
        } else {
          return {
            maxDate: today,
            minDate:today.getDate()-60
          };
        }
      }
    }
  });
  }

});

function check(){
let start_date = $("#start_date").val();
    let end_date = $("#end_date").val();
    // console.log(start_date);
    if(start_date=='' || end_date=='' ){
      alert("Please select date");
      return false;
    }
    else{
      return true;
    }

}
function checkVal(a1, a2) {

  if (a1 == true) {
    $("#job_status").show();
    cat_mgr = true;
    freelance = false;
  } else {
    $("#job_status").hide();
    cat_mgr = false;
    freelance = true;
  }
}
          
  
function lookup(idd, obj, divId) {
	timeStamp = new Date().getTime()
	$("#mcatsmain").css("display", "block");
	var inputString = $('#' + idd).val();
	obj = "find";
	if (inputString.length == 0) {
		$('#' + divId).html('<div></div>');
	} else if (inputString.length > 2) {
    $('#mcatsmain').show();
    $('#' + divId).show();
		if (/[.]/.test(inputString)) {
			$('#' + divId).html('<div></div>');
		} else {
			var typ = 'P';
			auto_ajax_call++;
			$.post(
				`https://suggest.imimg.com/suggest/suggest.php?q=${inputString}&tag=suggestions&limit=10&type=mcat&fields=name%2Cmcat_id&method=beginstring&display_fields=value%2C%5B+(%5D%2Cmcat_id%2C%5B)%5D&match=exact&_=${timeStamp}`, {},
				function (data) {
					var res = JSON.parse(data).mcat	;
          var divHtml = "";
          if(res.length>2){
            $('#' + divId).show();
          }
					for(i=0;i<res.length;i++){
            divHtml += `<div onclick="abc('${res[i].data.name}',${res[i].data.mcat_id});">${res[i].label}</div>`;
          }
          $('#' + divId).html(divHtml);
          if(res.length==0){
            $('#' + divId).hide();
          }
          // $('#' + mcat_label).html(divHtml);
				}
			);
		}
	} else if (inputString.length <2) {
    $('#' + divId).hide();
    // $('#mcatsmain').hide();
	}
}
function abc(mcatname, mcatid) {
  // // mcat_name.value = mcatname + " (" + mcatid + ")";
  mcat_id.value = mcatid;
  $("#mcatsmain").hide();
  $("#mcats").hide();
   $("#mcat_label").val(mcatname);
   if($("#mcat_label").val().length<=2){
    //  console.log("length");
     $("#mcats").hide();
   }
  document.getElementById("mcat_id").value =mcatid; 
}

function showfreelanceDataAll() {
  let stdate = $("#start_date").val();
  let endate = $("#end_date").val();
  let job_type = $("#job_type").val() || 0;
  let isChecked = $("#myGroup").prop("checked");
  var mid= $('#mid').val() ;
  // console.log(data1,"data");
  
  $.ajax({
    url: "/index.php?r=admin_marketplace/JobDashboard/Index&mid="+mid,
    type: "POST",
    data: {
      action: 'getFreelanceDetail',
      stdate: stdate,
      endate: endate,
      job_type: job_type,
      empid: empid,
      isChecked: isChecked,
      mcat:mcat
    },
    beforeSend: function () {
      $('.note').hide();
      $("#loading").show();
      $("#result1").hide();
      $('#export_btn').hide();
    },
    success: function (response) {
      $("#loading").hide();
      $("#result1").show();
      if (response.trim() != "") {
        var response = $.parseJSON(response);
        var err = response["err"] || "";
       console.log(response);
        var data = response["data"] || [];
          if (data.length > 0) {
        let check=createfreelanceTable(data);
        if(check){
          showfreelanceDataSection();
        }
         if(check==false)  {
           $('#result2').hide();
          $("#result1").html(
            '<h2 style="text-align:center">No data found</h2>'
          );
         }
      }
      }
    },
  });
}
function createfreelanceTable(data) {
  let cnt_open = data[0]["opened_job"] || 0;
  let cnt_closed = data[0]["closed_job"] || 0;
  let cnt_delete = data[0]["deleted_job"] || 0;
  let cnt_wip = data[0]["wip_job"] || 0;
  let job_reviewed=data[0]['task_reviewed'] || 0;
  let mcat_count = data[0]["unique_mcat"] || 0;
  let subcat_count = data[0]["subcat_count"] || 0;
  let auto = data[0]["product_auto_approved"] || 0;
  let avg = data[0]["average_tat"] || 0;
  let task_created = data[0]["task_created"] || 0;
  
  if(cnt_open==0 && cnt_closed==0 && cnt_delete==0 && cnt_wip==0 &&  auto==0 && job_reviewed==0 && subcat_count==0 && mcat_count==0){
    return false;
  }
  var tablehtml ='<tr style="background-color:blue: width:100px;"><th >Jobs Opened</th><th >Jobs closed</th><th >Jobs Dropped</th><th >Pending Jobs</th><th >Average TAT</th><th >Jobs Audited</th><th >No. of Products Reviewed</th><th style="width:10%">Total Products for which job posted</th><th >Products auto-approved</th><th >Unique mcats worked</th><th >Unique subcats worked</th><th >Products audited<th>Products audit-approved</th><th>Audit Quality</th></tr>';
    
  tablehtml +="<tr><td>" + cnt_open +"</td><td>" +cnt_closed +"</td><td>" +cnt_delete + "</td><td>" +cnt_wip +"</td><td>" + avg +"</td><td>"+ "-" +"</td><td>" +job_reviewed +"</td><td>" +task_created + "</td><td>" +auto +"</td><td>" +mcat_count +"</td><td>" +subcat_count+"</td><td>" +"-" +"</td><td>" +"-" +
 "</td><td>" + "-" +"</td></tr>";
  tablehtml = '<table class="freelancer">' + tablehtml + "</table>";

  $("#result1").html(tablehtml);
   return true;
}

function emp_autosuggest1(id, divid) {
  $("#divState_empreport").show();
  call_auto();
}

function call_auto(id) {
  var a = $("#emp_name").val();
  if (a.length >= 3) {
    $("#loadinggif").show();
    $.ajax({
      url:
        "/index.php?r=getAutoSuggestEmp/Index&TextBoxID=emp_name&MenuDivID=divState&DataType=emp&NumMenuItems=15&IncludeMoreMenuItem=false&MoreMenuItemLabel=...&MenuItemCSSClass=asbMenuItem&Keyword=" +
        a,
      type: "post",
      data: "",
      success: function (result) {
        $("#divState_empreport").html(result);
        $("#divState_empreport").css("visibility", "visible");
        $("#loadinggif").hide();
      },
    });
  }
}

function showCategoryDetail() {
  let stdate = $("#start_date").val();
  let endate = $("#end_date").val();
  var job_type = $("#job_type").val() || 0;
  var job_status = $("#job_status").val() || 0;
 
  let isChecked = $("#myGroup").prop("checked");
  $('#action').val('getCategoryDetail');
  var mid= $('#mid').val();

  $.ajax({
    url: "/index.php?r=admin_marketplace/JobDashboard/Index&mid="+mid,
    type: "POST",
    data: {
      action: "getCategoryDetail",
      stdate: stdate,
      endate: endate,
      job_type: job_type,
      job_status: job_status,
     mcat:mcat,
      isChecked: isChecked,
      empid: empid,
    },
    beforeSend: function () {
      $("#loading").show();
      $("#result3 ").hide();
      $("#export_btn").hide();
    },
    success: function (response) {
      // $('.note').css('display'​​​​​​​​​​​​​​​​​​​​​​​​​​​,'block');​​​​​​
      $('.note').show();
      $("#loading").hide();
      $("#result3").show();
      if (response.trim() != "") {
        var response = $.parseJSON(response);
        var err = response["err"] || "";
        var data = response["data"];
        console.log(data);
        if (data != undefined) {
          if (job_status == "6") {
           let check= createCategorytableAll(data);
           if(check==false){
            $('.note').hide();
            $("#result3").html(
              '<h2 style="text-align:center">No data found</h2>'
            );
           }
          } else {
            createCategorytableOther(data);
          }
        } else {
          $('.note').hide();
          $("#result3").html(
            '<h2 style="text-align:center">No data found</h2>'
          );
        }
      }
    },
  });
}

function createCategorytableAll(data) {
  var tablehtml =
    "<tr><th >Jobs Opened</th><th >Jobs closed</th><th >Jobs Dropped</th><th >Pending Jobs</th><th >Average TAT</th><th >Jobs Audited</th><th>Average Quality</th></tr>";
  for (let i = 0; i < data.length; i++) {
    let cnt_open = data[i]["opened_job"] || 0;
    let cnt_wip = data[i]["wip_job"] || 0;
    let closed = data[i]["closed_job"] || 0;
    let cnt_delete = data[i]["deleted_job"] || 0;
    let tat = data[i]["average_tat"] || 0;
    if(cnt_open==0 && cnt_wip==0 && cnt_delete==0 && closed==0){
      return false;
    }

    tablehtml += "<tr><td>" +cnt_open +"</td><td>" +closed +"</td><td>" +cnt_delete +"</td><td>" +cnt_wip +"</td><td>" +tat +"</td><td>" +"-" +"</td><td>" +
"-" +"</td></tr>";
  }
  tablehtml = "<table>" + tablehtml + "</table>";
  $("#result3").html(tablehtml);
  $('.note').html("<h4>Date range is mandatory for Job Status 'All'. The maximum duration of 2 months can be selected here as a date range.</h4>");
  $("#export_btn").show();
  return true;
}
function createCategorytableOther(data) {
  let job_status = $("#job_status").val();
  console.log(data);
  console.log("check");
  if (job_status == 5) {
    var tablehtml =
      "<tr><th>MCAT ID</th><th>MCAT Name</th><th>PMCAT Name</th><th>Category Manager</th><th>Product Count</th><th>Posted By</th><th>Posted On</th><th>Auto-Approved</th><th>Current Status</th><th>Drop Option</th><th>Completion Date</th><th>Perform Audit</th><th>Audit Date</th><th>Products Audited</th><th>Error Count</th><th>Quality</th></tr>";

    for (let i = 0; i < data.length; i++) {
      let mcatId = data[i]["mcat_id"] || "-";
      let mcatName = data[i]["glcat_mcat_name"] || "-";
      let pmcat = data[i]["pmcat_name"] || "-";
      let cm = data[i]["category_manager"] || "-";
      let count = data[i]["job_total_tasks"] || 0;
      let postedBy = data[i]["job_posted_by"] || "-";
      let postedOn = data[i]["job_creation_date"] || "-";
      let status=data[i]['job_status'] ||'-';
      let completion = data[i]["job_completion_date"] || "-";
      let autoapproved = data[i]["auto_approved_task"] || 0;
      if(postedOn!='-'){
      postedOn=postedOn.substring(8,10)+'-'+postedOn.substring(5,7)+'-'+postedOn.substring(0,4);
      }
      if(completion!='-'){
      completion=completion.substring(8,10)+'-'+completion.substring(5,7)+'-'+completion.substring(0,4);
      }
      if(status==0){
        status="Open";
      }
      else if(status==1){
        status="WIP";
      }
      else if(status==2){
        status="Closed"
      }
      else if(status==3){
        status="Deleted";
      }
      else if(status==4){
        status="Audited";
      }
      else if(status==5){
       status="Pending for Automation";
      }
      else if(status==6){
       status="Automated";
      }
      else if(status==7){
         status="Pending for task creation";
      }
    
    tablehtml += "<tr><td>" + mcatId +"</td><td>" + mcatName +"</td><td>" +pmcat +"</td><td>" +cm +"</td><td>" + count +"</td><td>" +  postedBy +
 "</td><td>" + postedOn +"</td><td>" +autoapproved +"</td><td>" +status +"</td><td>" + '-' +"</td><td>" +completion + "</td><td>" +'-' +"</td><td>" + '-' +"</td><td>" + '-' +"</td><td>" +'-' +"</td><td>" +'-' +"</td></tr>";
    }
    $('.note').html("<h4>Jobs are displayed on the basis of the Creation Date of the Jobs. Job for which Creation Date lies in the selected date range will be available here</h4>");
  } else if (job_status == 1) {
    var tablehtml =
      "<tr><th>MCAT ID</th><th>MCAT Name</th><th>PMCAT Name</th><th>Category Manager</th><th>Products Count</th><th>Job Status</th><th>Posted By</th><th>Posted On</th></tr>";

    for (let i = 0; i < data.length; i++) {
      let mcatId = data[i]["mcat_id"] ||0;
      let mcatName = data[i]["glcat_mcat_name"] || '-';
      let pmcat = data[i]["pmcat_name"] || '-';
      let cm = data[i]["category_manager"] || '-';
      let count = data[i]["job_total_tasks"] || 0;
      let postedBy = data[i]["job_posted_by"] || '-';
      let postedOn = data[i]["job_creation_date"] ||'-';
      let status=data[i]['job_status']||'-';
      if(postedOn!='-')
      postedOn=postedOn.substring(8,10)+'-'+postedOn.substring(5,7)+'-'+postedOn.substring(0,4);
      if(status==0){
        status="Open";
      }
      else if(status==1){
        status="WIP";
      }
      else if(status==2){
        status="Closed"
      }
      else if(status==3){
        status="Deleted";
      }
      else if(status==4){
        status="Audited";
      }
      else if(status==5){
       status="Pending for Automation";
      }
      else if(status==6){
       status="Automated";
      }
      else if(status==7){
         status="Pending for task creation";
      }
    
    tablehtml +=  "<tr><td>" +  mcatId +"</td><td>" +    mcatName + "</td><td>" + pmcat +  "</td><td>" +  cm + "</td><td>" + count +"</td><td>" +  status +"</td><td>" +postedBy +"</td><td>" +postedOn +"</td></tr>";
    }
    $('.note').html("<h4>All the jobs currently in 'WIP' status are made visible (irrespective of the selected date range)</h4>");

  } else if (job_status == 2) {
    var tablehtml =
      "<tr><th>MCAT ID</th><th>MCAT Name</th><th>PMCAT Name</th><th>Category Manager</th><th>Product Count</th><th>Posted By</th><th>Posted On</th><th>Job Status</th><th>Completion Date</th><th>Perform Audit</th><th>Audit Date</th><th>Product Audit</th><th>Error Count</th><th>Quality</th></tr>";
    for (let i = 0; i < data.length; i++) {
      let mcatId = data[i]["mcat_id"]|| 0;
      let mcatName = data[i]["glcat_mcat_name"]|| '-';
      let pmcat = data[i]["pmcat_name"] || '-';
      let cm = data[i]["category_manager"] || '-';
      let count = data[i]["job_total_tasks"] || 0;
      let postedBy = data[i]["job_posted_by"] ||'-';
      let postedOn = data[i]["job_creation_date"] || '-';
      let status=data[i]["job_status"] || '-';
      let completion = data[i]["job_completion_date"] || '-';
      if(postedOn!='-'){
       postedOn=postedOn.substring(8,10)+'-'+postedOn.substring(5,7)+'-'+postedOn.substring(0,4);
      }
      if(completion!='-'){
      completion=completion.substring(8,10)+'-'+completion.substring(5,7)+'-'+completion.substring(0,4);
      }
      if(status==0){
        status="Open";
      }
      else if(status==1){
        status="WIP";
      }
      else if(status==2){
        status="Closed"
      }
      else if(status==3){
        status="Deleted";
      }
      else if(status==4){
        status="Audited";
      }
      else if(status==5){
       status="Pending for Automation";
      }
      else if(status==6){
       status="Automated";
      }
      else if(status==7){
         status="Pending for task creation";
      }
      
    
    tablehtml +=
      "<tr><td>" +mcatId +"</td><td>" +mcatName +"</td><td>" +pmcat +  "</td><td>" + cm +"</td><td>" +  count +"</td><td>" +postedBy +  "</td><td>" +postedOn + "</td><td>" +status +"</td><td>" +completion +"</td><td>" +  '-' +"</td><td>" +  '-' +"</td><td>" +'-' +"</td><td>" +'-' +"</td><td>" +'-' +  "</td></tr>";
    }
    $('.note').html("<h4>Jobs are displayed on the basis of the Completion Date of the Jobs. Jobs for which Complete Date lies in the selected date range will be available here </h4>");
  } else if (job_status == 3) {
    var tablehtml =
      "<tr><th>MCAT ID</th><th>MCAT Name</th><th>PMCAT Name</th><th>Category Manager</th><th>Product Count</th><th>Posted By</th><th>Posted On</th><th>Dropped On</th><th>Dropped By</th></tr>";
    for (let i = 0; i < data.length; i++) {
      let mcatId = data[i]["mcat_id"] ||0;
      let mcatName = data[i]["glcat_mcat_name"]||'-';
      let pmcat = data[i]["pmcat_name"] ||'-';
      let cm = data[i]["category_manager"] ||'-';
      let count = data[i]["job_total_tasks"] ||0;
      let postedBy = data[i]["job_posted_by"] ||'-';
      let postedOn = data[i]["job_creation_date"] ||'-';
      let deletion = data[i]["job_deleted_date"] ||'-';
      if(deletion!='-'){
      deletion=deletion.substring(8,10)+'-'+deletion.substring(5,7)+'-'+deletion.substring(0,4);
      }
      if(postedOn!='-'){
      postedOn=postedOn.substring(8,10)+'-'+postedOn.substring(5,7)+'-'+postedOn.substring(0,4);
      }

    tablehtml +="<tr><td>" +mcatId +"</td><td>" +mcatName +"</td><td>" +   pmcat +  "</td><td>" +cm +"</td><td>" + count +"</td><td>" + postedBy +"</td><td>" + postedOn +"</td><td>" +  deletion +"</td><td>" +'-' +"</td></tr>";
    }
    $('.note').html("<h4> Jobs are displayed on the basis of the Deletion Date of the Jobs. Jobs for which Deletion Date lies in the selected date range will be available here</h4>");
  }
  if(job_status==5){
    tablehtml = '<table class="all">' + tablehtml + "</table>";
  }
  else if(job_status==3 || job_status==2){
    tablehtml = '<table class="all">' + tablehtml + "</table>";
  }
  
  else{
  tablehtml = "<table>" + tablehtml + "</table>";
  }
  $("#result3").html(tablehtml);
  $("#export_btn").show();
  
}

function set_empid_new(empId, empName) {
  $("#divState_empreport").hide();
  $("#emp_name").val(`${empName}`);
  $("#emp_id").val(empId);
   window.autoCheck1=true;
}
 function generateExcel() {
  let st_date = $("#start_date").val();
  let end_date = $("#end_date").val();
  var job_type = $("#job_type").val() || 0;
  var job_status = $("#job_status").val() || 0;
  let isChecked = $("#myGroup").prop("checked");
  let radioValue = $("input[name='radio1']:checked")?.val();
   let action=$('#action').val();
  let mid = $("#mid").val();
  var string='';
  string += "&stdate=" + st_date;
  string += "&endate=" + end_date;
  string += "&emp_id=" + empid;
  string += "&job_type=" + job_type;
  string += "&job_status=" + job_status;
  string += "&mcatId=" + mcat;
  string += "&isChecked=" + isChecked;
  string+="&radioValue="+radioValue;
  string+="&action="+action;
  string+= "&mid="+mid;
  console.log(string);

   window.open("/index.php?r=admin_marketplace/JobDashboard/ExportExcel"+string, '_blank');
 }
 
function showfreelanceDataSection() {
  let stdate = $("#start_date").val();
  let endate = $("#end_date").val();
  let job_type = $("#job_type").val() || 0;
  let job_type_name = $("#job_type  :selected").text();
  let isChecked = $("#myGroup").prop("checked");
  let job_status = $("#job_status").val();
  $('#action').val('getFreelanceSectionDetail');
  var mid= $('#mid').val();
  $.ajax({
    url: "/index.php?r=admin_marketplace/JobDashboard/Index&mid="+mid,
    type: "POST",
    data: {
      action: "getFreelanceSectionDetail",
      stdate: stdate,
      endate: endate,
      job_type: job_type,
      empid: empid,
      isChecked: isChecked,
      mcat: mcat,
      job_status: job_status,
    },
    beforeSend: function () {
      $("#result2").hide();
      $("#result").show();
      $("#loading").show(); 
    },
    success: function (response) {
      $("#result").hide();
      $("#loading").hide();
      $("#result2").show();
      if (response.trim() != "") {
        var response = $.parseJSON(response);
        var err = response["err"] || "";
        var data = response["data"] || [];
         if (err == "") {
          createfreelanceTableSection(data, job_type_name);
         }
         else {
          $("#result2").html(
            '<h2 style="text-align:center">No data found</h2>'
          );
        }
      }
    },
  });
}
function createfreelanceTableSection(data, job_type_name) {
  // if(data.length==0){
  //   $("#result2").html(
  //           '<h2 style="text-align:center">No data found</h2>'
  //         );
  //         return;
  // }
  var tablehtml1 =
    '<tr style="background-color:blue: width:100px;"><th >Date</th><th >Associate</th><th >MCAT ID</th><th >MCAT Name</th><th >PMCAT Name</th><th >Category Manager</th><th >Posted By</th><th>Products Worked</th><th >Audit</th><th >Products Audited</th><th >Products Audit Approved</th></tr>';

    var start_date = $('#start_date').val();
    var end_date = $('#start_date').val();
    var job_type = $('#job_type').val();
    let dashboard_type = $("#freelance").prop("checked");


  for (let i = 0; i < data.length; i++) {
    let date = data[i]["date"] || "-";
    let Associate = data[i]["associate_name"] || "-";
    let mcatId = data[i]["mcat_id"] || "-";
    let mcatName = data[i]["glcat_mcat_name"] || "-";
    let pmcatName = data[i]["pmcat_name"] || "-";
    let categorymanager = data[i]["category_manager"] || "-";
    let count = data[i]["task_reviewed"] || 0;
    let postedBy=data[i]["created_by"] || "-";
    let taskDetailIds=data[i]["task_detail_ids"] || "";
    let task_assignedto_empid=data[i]["task_assignedto_empid"] || "";

    var mid= $('#mid').val();

    if(date!='-')
    date=date.substring(8,10)+'-'+date.substring(5,7)+'-'+date.substring(0,4);
  
    var auditLink = "";
    var logedInUserId = readCookie('adminiil');
    //if(logedInUserId == 27297 || logedInUserId == 61154 || logedInUserId == 32689 || logedInUserId == 1563 || logedInUserId == 24729){
      auditLink  = '<a href="index.php?r=admin_marketplace/JobAudit/Index&mid='+mid+'&start_date='+date+'&end_date='+date+'&job_type='+job_type+'&dashboard_type='+dashboard_type+'&mcatName='+mcatName+'&Associate='+Associate+'&job_type_name='+job_type_name+'&action=getFreelanceProductDetail&task_assignedto_empid='+task_assignedto_empid+'&mcatId='+mcatId+'" target="_blank" >Perform Audit</a>';
    //}
  tablehtml1 +=
    "<tr><td>" +  date+   "</td><td>" + Associate +"</td><td>" +  mcatId +"</td><td>" + mcatName +"</td><td>" +pmcatName +"</td><td>" +  categorymanager +   "</td><td>" +postedBy +"</td><td>" +count +"</td><td>"   +auditLink+"</td><td>" +"-" +"</td><td>" + "-" +  "</td></tr>";
  }
  tablehtml1 = "<table class='descriptive'>" + tablehtml1 + "</table>";
  $("#result2").html(tablehtml1);
  $("#export_btn").show();
 

}

function auditProduct(mcatId, mcatName, freelnaceName , jobType, taskDetailIds)
{
  var mid= $('#mid').val();
  $.ajax({
    url: "/index.php?r=admin_marketplace/JobAudit/Index&mid="+mid,
    type: "POST",
    data: {
      action: "getFreelanceProductDetail",      
      taskDetailIds: taskDetailIds,
    },
    /*beforeSend: function () {
      $("#result2").hide();
      $("#result").show();
      $("#loading").show(); 
    },*/
    success: function (response) {
      openAuditPopup(0, response, mcatId, mcatName, freelnaceName , jobType, taskDetailIds);
      
    },
  });


}

function openAuditPopup( fetchCount,  response, mcatId, mcatName, freelnaceName , jobType, taskDetailIds) {
  //var myWindow = window.open("", "myWindow", "width=400,height=400");
  //var obj = JSON.parse(response);
  var obj = response;
  if(typeof(obj.result) == 'undefined' || obj.length  == 0){    
    $("#prodcontent").html('<h2 style="text-align:center">No data found</h2>');
    $("#footerbotton").html('');
    $('.loader').hide();
    return;
  }
  
  var perPageRes = 1;
  html = "";
  if(fetchCount == 0 ){
  html = "<!DOCTYPE html><html>";
  html += '<head>\
	<meta charset="UTF-8">\
    <meta name="viewport" content="width=device-width, initial-scale=1">\
    <meta http-equiv="X-UA-Compatible" content="ie=edge">\
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">\
	<link rel="stylesheet" type="text/css" href="https://dev-gladmin.intermesh.net/protected/css/audit.css">\
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>\
  <script src="https://dev-gladmin.intermesh.net/protected/modules/admin_marketplace/js/freelance.js?v=13"></script>\
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>\
	<title></title>\
</head>';

html += '<body>\
<div class="header">\
  <h5>Product Audit Screen</h5>\
</div>\
<div class="container-fluid">\
  <div class="title_txt">\
    <div class="first_txt">\
      <span>Mcat name:<strong> '+mcatName+'</strong></span>\
    </div>\
    <div class="first_txt">\
      <span> Freelancer : <strong>'+freelnaceName+'</strong></span>\
    </div>\
    <div class="first_txt">\
      <span> Job Type : <strong>'+jobType+'</strong></span>\
    </div>\
    <div class="first_txt">\
      <span> Product Type : <strong>';
      if(jobType == 'Mcat Enrichment'){
      html += '<input type="radio" id="mcatrem" name="producttype" value="mcat removed">\
        <label for="male">MCAT mapped</label>\
        <input type="radio" id="mcatnotrem" name="producttype" value="mcat not removed">\
        <label for="male">MCAT not mapped</label>';
      } else if(jobType == 'Mcat Cleaning'){
        html += '<input type="radio" id="mcatrem" name="producttype" value="mcat removed">\
          <label for="male">Mcat removed</label>\
          <input type="radio" id="mcatnotrem" name="producttype" value="mcat not removed">\
          <label for="male">Mcat not removed</label>';
      }
        html += '</strong></span>\
    </div>\
  </div>\
</div>\
<hr>\
';
  }
for(i=0; i<obj.result.length; i++){
  var task_att_values = JSON.parse(obj['result'][i]['task_attribute_values']);
  var task_att_isqs  = JSON.parse(obj['result'][i]['task_attribute_isqs']);
  if (task_att_values == "" || task_att_values == null) { console.log(obj.result[i]); continue; }

  //var old_mcats = task_att_values.old_mapping.split(",");
  //var new_mcats = task_att_values.new_mapping.split(",");
  var old_mcats = task_att_values.old_mcat_data;
  var new_mcats = task_att_values.new_mcat_data;

html += '<div class="divider"></div>\
<div style="clear:both"></div><div class="container-fluid" style="padding-top:15px;">\
<div class="row">\
    <div class="second_section">\
      <div class="col-sm-3 col-md-3 col-lg-3 img_box">\
        <div class="box_img">\
          <img  height="250" width="250" src="'+task_att_values.image_250_new+'">\
        </div>\
        <div class="box_txt">\
          <span><a target="_blank" href="https://gladmin.intermesh.net/index.php?r=admin_products/ProductApproval/Search&item_id='+task_att_values.item_id+'&action=search&mid=27">Item id: '+task_att_values.item_id+'</a></span>\
        </div>\
      </div>\
      <div class="col-sm-4 col-md-4 col-lg-5">\
        <div class="dolphin">\
          <h5 style="font-weight: 600;color: black;">'+task_att_values.item_name_new+'</h5>';
          if(task_att_values.fob_price_old != ""){
            html += '<span style="color: black;"><sup>Rs.</sup><strong>'+task_att_values.fob_price_old+'</strong>Per Piece</span>';
          }
          html += '<p>'+task_att_values.item_desc_new+'</p>\
          <!--<h6 style="color: #323484;">Specfication</h6>\
          <p style="">\
          34’’ width to 130’’ width,  56reed to 120reed<br>\
          56 picks to 120 picks<br>\
          30 denier to 300 denier grey and dyed polyester fabric.\
          20s cotton to 100scotton grey and dyed fabric</p>-->\
        </div>\
      </div>\
      <div class="col-sm-5 col-md-5 col-lg-4">\
        <div class="table_con">\
          <h5>Product Attribute</h5>\
        </div>\
        <div class="attribut_table">\
          <table class="table">\
                <!--<thead>\
                  <tr>\
                    <td style="color: #323484; font-size: 13px; font-weight: 550;">Diameter</td>\
                  <td>Up to 10 mm</td>\
                  </tr>\
                </thead>-->\
                <tbody>';
                if(task_att_isqs != null && task_att_isqs.length > 0 ){
                  for(isq=0; isq<task_att_isqs.length; isq++){
                    html += '<tr>\
                      <td style="color: #323484; font-size: 13px; font-weight: 550;">'+task_att_isqs[isq]['IM_SPEC_MASTER_DESC']+'</td>\
                    <td>'+task_att_isqs[isq]['ISQ_RESPONSE']+'</td>\
                    </tr>';
                  }
                } else {
                  html += '<tr><td>Attribute unavailable</td></tr>';
                }
                  
                  html += '</tbody>\
              </table>\
        </div>\
        </div>\
      </div>\
    </div>\
  </div>\
  <div class="afterbox" style="margin-top:-100%">\
    <div class="container-fluid">\
      <div class="row row-space">\
        <div class="col-md-6">\
          <div class="Before" style="color: #323484;">Before</div>\
          <div class="after_first" style="min-height: 130px;">\
            <div class="row">';
            //for(omcat=0; omcat<old_mcats.length; omcat++){  
              for (var key in old_mcats) {
                if (old_mcats.hasOwnProperty(key)) {

              html += '<div class="col-xs-4">\
                <div class="after_inner1" >\
                  <img height="45" width="45" src="'+old_mcats[key]['glcat_mcat_125x125']+'">\
                </div>\
                <h5 style="margin-top: 5px;color: #323484;font-size: 11px">'+old_mcats[key]['mcat_name']+'</h5>'
                if(old_mcats[key]['prime'] == 1){
                  html += '<h6 style="color: red;">(Prime MCAT)</h6>';
                }
                html += '</div>';
                }
            } 
            if($.isEmptyObject(old_mcats)){
              html += 'No Mcat Available';
            }
            html += '</div>\
          </div>\
        </div>\
        <div class="col-md-6">\
          <div class="Before" style="color: #323484;">After</div>\
          <div class="after_first" style="min-height: 130px;">\
            <div class="row">';
            for (var key in new_mcats) {
              if (new_mcats.hasOwnProperty(key)) {

              html += '<div class="col-xs-4">\
                <div class="after_inner1" >\
                  <img height="45" width="45" src="'+new_mcats[key]['glcat_mcat_125x125']+'">\
                </div>\
                <h5 style="margin-top: 5px;color: #323484;font-size: 11px">'+new_mcats[key]['mcat_name']+'</h5>';
                if(new_mcats[key]['prime'] == 1){
                  html += '<h6 style="color: red;">(Prime MCAT)</h6>';
                }
                html += '</div>';
              }
            }
            if($.isEmptyObject(new_mcats)){
              html += 'No Mcat Available';
            }
              html += '</div>\
          </div>\
        </div>\
      </div>\
    </div>\
    <div class="container-fluid">\
    <div class="butons">\
      <div class="first_buton">\
        <a href="Javascript:void(0);" id="approve'+(i+(fetchCount-1)*perPageRes)+'" onclick="saveRejectReason('+(i+(fetchCount-1)*perPageRes)+', \'approved\', \''+obj['result'][i]['fk_task_detail_id']+'\')">approve</a>\
      </div>\
      <div class="second_button">\
        <a href="Javascript:void(0);" id="reject'+(i+(fetchCount-1)*perPageRes)+'"  onclick="openRejectReason('+(i+(fetchCount-1)*perPageRes)+', \'rejected\')">Reject</a>\
      </div>\
    </div>\
  </div>\
  </div>';

  html += '<div class="last_box" id="last_box'+(i+(fetchCount-1)*perPageRes)+'" style="display:none;">\
				<div class="wrong_mcat" style="margin: 40px;">';
              var countOptions = 0;
              var mcatRcnt = 0; 
              for (var key in new_mcats) {
                if (new_mcats.hasOwnProperty(key)) {
                  mcatRcnt++;countOptions++;
                  if(mcatRcnt == 1){
                    html += '<div class="container2"><input type="checkbox" id="reason1" name="reason1" value="Wrong MCAT Mapped"><span class="checkmark"></span>\
  						<label for="vehicle1"> <strong style="color: #9F9F9F;">Wrong MCAT Mapped / Retained<span style="color: black;font-size: 12px;"> (Select the MCAT that has been mapped incorrectly)</span></strong> </label></div>\
  						<div class="row">';
                  }
						    html += '&nbsp;<div class="container2"><input type="checkbox" name="wrong_mcat_mapped" mcatname="'+new_mcats[key]['mcat_name']+'" value="'+key+'" style=""><span class="checkmark"></span>'+new_mcats[key]['mcat_name']+' </div>';
                }
              }
              html += '';
              if(mcatRcnt >= 1){
                html += '<br></div>';
              }
  						
  						
              mcatRcnt = 0; 
              var newMcatIdArr = [];
              for (var key in new_mcats) {
                if (new_mcats.hasOwnProperty(key)) {
                  mcatRcnt++;countOptions++;
                  newMcatIdArr.push(key);
                  if(mcatRcnt == 1){
                    html += '<div class="container2"><input type="checkbox" id="reason2" name="reason2" value="Incorrect Prime MCAT Mapped"><span class="checkmark"></span>\
                    <label for="vehicle1"> <strong style="color: #9F9F9F">Incorrect Prime MCAT Mapped<span style="color: black;font-size: 12px;"> (Select the MCAT that should have been marked as Prime)</span></strong> </label></div>\
                    <div class="row">';
                  }
						    html += '&nbsp;<div class="container2"><input type="checkbox" name="incorrect_prime_mapped" mcatname="'+new_mcats[key]['mcat_name']+'" value="'+key+'" style=""><span class="checkmark"></span>'+new_mcats[key]['mcat_name']+' </div>';						    
                }
              }
              html += '';
              if(mcatRcnt >= 1){
                html += '<br></div>';
              }
              
              mcatRcnt = 0; 
              for (var key in old_mcats) {
                if (old_mcats.hasOwnProperty(key) && !newMcatIdArr.includes(key)) {
                  mcatRcnt++; countOptions++;
                  if(mcatRcnt == 1){
                    html += '<div class="container2"><input type="checkbox" id="reason3" name="reason3" value="Correct MCAT removed"><span class="checkmark"></span>\
                    <label for="vehicle1"> <strong style="color: #9F9F9F">Correct MCAT removed<span style="color: black;font-size: 12px;"> (Select the MCAT that has been removed incorrectly)</span></strong> </label></div>\
                    <div class="row">';
                  }
						    html += '&nbsp;<div class="container2"><input type="checkbox" name="correct_mcat_removed" mcatname="'+old_mcats[key]['mcat_name']+'" value="'+key+'" style=""><span class="checkmark"></span>'+old_mcats[key]['mcat_name']+' </div>';
                }
              }
              html += '';
              if(mcatRcnt >= 1){
                html += '<br></div>';
              }
              if(countOptions == 0){
                html += '<div style="color: red;"> MCAT not available</div>';
              }
              html += '<div class="botton_group" style="text-align: center;">\
  							<button style="border:none;padding: 5px 27px 5px 27px;"  onclick="saveRejectReason('+(i+(fetchCount-1)*perPageRes)+', \'rejected\', \''+obj['result'][i]['fk_task_detail_id']+'\')">Save	</button>\
  							<button style"border:none" onclick="closeRejectReason('+(i+(fetchCount-1)*perPageRes)+')">cancel</button>\
  						</div>\
				</div>\
			</div>';
  }
  html += '</div>';
  html1 = "";
  if(obj.paginationIds != "" || obj.result.length > 0) {
  html1 += '<div style="clear: both;"></div><div style="padding-top:15px;" class="botton_group" id="fetch'+fetchCount+'"  style="text-align: center;">\
            <button style="border:none;padding: 5px 27px 5px 27px;"  onclick="fetchMore('+fetchCount+', ' + mcatId+', \''+mcatName+'\', \''+freelnaceName+'\', \''+jobType+'\', \''+obj.paginationIds+'\')"> Fetch More	</button>\
          </div>';

          html1 = '<button  id="fetch'+fetchCount+'" style="border:none;padding: 5px 27px 5px 27px;"  onclick="saveAudit('+fetchCount+', ' + mcatId+', \''+mcatName+'\', \''+freelnaceName+'\', \''+jobType+'\', \''+obj.paginationIds+'\')"> Save Audit	</button>';
  }
  
  if(fetchCount == 0){
    html += '</body>\
</html>';
  }
  //myWindow.document.write("<title>Product Audit Screen</title>");
  //myWindow.document.write("<p>This is 'myWindow'</p>");
  //myWindow.document.write(html);
  //myWindow.opener.document.write("<p>This is the source window!</p>");
  $("#prodcontent").html(html);
  $(window).scrollTop(0);

  $("#footerbotton").append(html1);
  //$('.loader').hide();


}

function openRejectReason(i)
{
  $('#last_box'+i).show(1500);
  //$('#reject'+i).attr('style', 'background-color: #E11A1A; color: white;');
  $('#approve'+i).attr('style', '');

  $('.container2 input[type=checkbox]').click(function(){
    let boxid = $(this).attr('id');
    if(this.checked){
      $(this).parent().css( "color", "#323484" );
      if(boxid == 'reason1' || boxid == 'reason2' || boxid == 'reason3' || boxid == 'reason4'){
        $(this).parent().find('strong').css( "color", "#323484" );        
      } else {
        $(this).parent().parent().prev('.container2').find('input[type=checkbox]').prop('checked', true);
        $(this).parent().parent().prev('.container2').find('strong').css( "color", "#323484" );
      }
      
    } else {
      $(this).parent().css( "color", "#9F9F9F" );
      if(boxid == 'reason1' || boxid == 'reason2' || boxid == 'reason3' || boxid == 'reason4'){
        $(this).parent().find('strong').css( "color", "#9F9F9F" );        
      }
    }
  })
  
}

function closeRejectReason(i)
{
  $('#last_box'+i).hide(1500);
}

function saveAudit(fetchCount, mcatId, mcatName, freelnaceName, jobType, taskDetailIds)
{
  auditStatusStr = JSON.stringify(auditStatus);
  if(auditStatusStr.length === 2){
    alert("Nothing to update, Kindly approve or reject");
    return;
  }
  $('#fetch'+fetchCount).hide();
  $('.loader').show();
  $("html, body").animate({ scrollTop: $(document).height() }, 50);
  fetchCount++;
  console.log('saveRejectReasonAll');
  var mid= $('#mid').val();
  
  $.ajax({
    url: "/index.php?r=admin_marketplace/JobAudit/Index",
    type: "POST",
    data: {
      mid : mid,
      action: "saveAuditDetailAll",
      auditStatus : auditStatusStr,
      taskDetailIds : taskDetailIds
    },    
    success: function (res) {
      var response = $.parseJSON(res);      
      $('#loader').hide(function(){         
        alert(response.message);
        //console.log(res);
        //fetchMore(fetchCount, mcatId, mcatName, freelnaceName, jobType, taskDetailIds);      
        openAuditPopup(fetchCount , response, mcatId, mcatName, freelnaceName , jobType, taskDetailIds);
      });
      auditStatus =  {};
      
    },
  });
}

var auditStatus =  {};

function saveRejectReason(i, status, taskId)
{
  //auditStatus[taskId] = {};
  
  auditStatus[taskId] = {'status' : status};
  if(status == 'approved'){
    $('#reject'+i).attr('style', '');
    $('#approve'+i).attr('style', 'background-color: #18EA6D; color: white;');
    $('#last_box'+i).hide(1500);
    return;
  }
  
  console.log('saveRejectReason'+i);
  /*data =
  $("#last_box"+i+" input[type=radio]:checked").each(function(e){	
  });
  */
  var selectedOptionsCntAll = 0;
  var selectedOptionsCnt = 0;
  selectedOptions = {}
  if($("#last_box"+i+" input[id=reason1]:checked").val()){
    selectedOptionsCnt++;
    selectedOptionsCntAll++;
    //var wrong_mcat_mapped_val = $("#last_box"+i+" input[name=wrong_mcat_mapped]:checked").val();
    //var wrong_mcat_mapped_name = $("#last_box"+i+" input[name=wrong_mcat_mapped]:checked").attr('mcatname');
    selectedOptions['wrong_mcat_mapped'] = {};
    $("#last_box"+i+" input[name=wrong_mcat_mapped]:checked").each(function () {
      selectedOptionsCnt++;
      //selectedOptionsCntAll++;
      var key = $(this).val();
      var val = $(this).attr('mcatname');
      selectedOptions['wrong_mcat_mapped'][key] = val;
    });
    if(selectedOptionsCnt <2){
      alert('Select atleast one MCAT for the selected reason for rejecting the audit');
      return;
    }
  }
  selectedOptionsCnt = 0; 
  if($("#last_box"+i+" input[id=reason2]:checked").val()){
    selectedOptionsCnt++;
    selectedOptionsCntAll++;
    //var incorrect_prime_mapped_val = $("#last_box"+i+" input[name=incorrect_prime_mapped]:checked").val();

    //var incorrect_prime_mapped_name = $("#last_box"+i+" input[name=incorrect_prime_mapped]:checked").attr('mcatname');
    //selectedOptions['incorrect_prime_mapped'] = { incorrect_prime_mapped_val  : incorrect_prime_mapped_name};
    selectedOptions['incorrect_prime_mapped'] = {};
    $("#last_box"+i+" input[name=incorrect_prime_mapped]:checked").each(function () {
      selectedOptionsCnt++;
      //selectedOptionsCntAll++;
      var key = $(this).val();
      var val = $(this).attr('mcatname');
      selectedOptions['incorrect_prime_mapped'][key] =  val;
    });
    if(selectedOptionsCnt <2){
      alert('Select atleast one MCAT for the selected reason for rejecting the audit');
      return;
    }
  }
  selectedOptionsCnt = 0;
  if($("#last_box"+i+" input[id=reason3]:checked").val()){
    selectedOptionsCnt++;
    selectedOptionsCntAll++;
    //var correct_mcat_removed_val = $("#last_box"+i+" input[name=correct_mcat_removed]:checked").val();
    //var correct_mcat_removed_name = $("#last_box"+i+" input[name=correct_mcat_removed]:checked").attr('mcatname');
    //selectedOptions['correct_mcat_removed'] = { correct_mcat_removed_val : correct_mcat_removed_name };
    selectedOptions['correct_mcat_removed'] = {};
    $("#last_box"+i+" input[name=correct_mcat_removed]:checked").each(function () {
      selectedOptionsCnt++;
      //selectedOptionsCntAll++;
      var key = $(this).val();
      var val = $(this).attr('mcatname');
      selectedOptions['correct_mcat_removed'][key] = val ;
    });
    if(selectedOptionsCnt <2){
      alert('Select atleast one MCAT for the selected reason for rejecting the audit');
      return;
    }
  }
  if(selectedOptionsCntAll == 0){
    alert('Select atleast one reason for rejecting the audit');
    return;
  }
  //alert('Audit Saved');
  $('#last_box'+i).hide(1500);
  auditStatus[taskId]['reason'] = selectedOptions;
  $('#reject'+i).attr('style', 'background-color: #E11A1A; color: white;');
  return; 

}

function fetchMore(fetchCount, mcatId, mcatName, freelnaceName, jobType, taskDetailIds)
{

  $('#fetch'+fetchCount).hide();
  fetchCount++;
  var mid= $('#mid').val();
  $.ajax({
    url: "/index.php?r=admin_marketplace/JobAudit/Index",
    type: "POST",
    data: {
      mid:mid,
      action: "getFreelanceProductDetailFetch",
      taskDetailIds: taskDetailIds,
    },
    success: function (response) {
      openAuditPopup(fetchCount , response, mcatId, mcatName, freelnaceName , jobType, taskDetailIds);
      
    },
  });

}

function setProducttype(producttype)
{
  var url = window.location.href
  
  url =removeURLParameter(url, 'producttype')
  url = url+'&producttype='+producttype;
  window.location.href = url;

}

function removeURLParameter(url, parameter) {
  //prefer to use l.search if you have a location/link object
  var urlparts= url.split('?');   
  if (urlparts.length>=2) {

      var prefix= encodeURIComponent(parameter)+'=';
      var pars= urlparts[1].split(/[&;]/g);

      //reverse iteration as may be destructive
      for (var i= pars.length; i-- > 0;) {    
          //idiom for string.startsWith
          if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
              pars.splice(i, 1);
          }
      }

      url= urlparts[0]+'?'+pars.join('&');
      return url;
  } else {
      return url;
  }
}


function readCookie(name){
  var search = name + "=";
  if (document.cookie.length > 0){ 
      offset = document.cookie.indexOf(search)
      if (offset != -1) // if cookie exists
      { 
          offset += search.length
          end = document.cookie.indexOf(";", offset)  // set index of beginning of value
          if (end == -1) end = document.cookie.length // set index of end of cookie value
          return unescape(document.cookie.substring(offset, end));
      }
  }
  if (name == 'v4iilex'){ return readCookie('v4iil'); }
  return "";
}



function changeTxtColor(id){
  //$('#'+id).attr('style', 'color: blue;');
  $("#"+id+" input[type=checkbox]:checked").each(function () {   $('#'+id).attr('style', 'color: blue;');})
  $("#"+id+" input[type=checkbox]:checked").each(function () {   $('#'+id).attr('style', 'color: red;');})

  $("#"+id+" input[type=checkbox]").each(function(){     
    if(this.checked){
      $('#'+id).attr('style', 'color: red;');
    }else{
      $('#'+id).attr('style', 'color: blue;');
    }
  });


}

