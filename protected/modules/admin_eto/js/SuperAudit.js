
function set_status(i){
    document.getElementById("status_disposition").value=1;
    $('#last_box'+i).hide(1500);
    $('#approve'+i).attr('style', 'background-color: #18EA6D; color: white;');
    $('#reject'+i).attr('style', 'background-color: white; color: red;');
}
function openRejectReason(i)
{
    document.getElementById("status_disposition").value=2;
    $('#reject'+i).attr('style', 'background-color: #E11A1A; color: white;');
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
function checkremark(){
  var savebtn=document.getElementById("save").value;
  var sv=document.getElementById("status_disposition").value;
  var rv= document.getElementById("remarks").value;
  var r1=document.getElementById("reason1").checked;
  var r2=document.getElementById("reason2").checked;
  var r3=document.getElementById("reason3").checked;
  var r4=document.getElementById("reason4").checked;

  if (rv.includes('\'')){
    alert("Please use \" instead of ' in remarks!");
    return false;
  }
  if (!sv){
    alert("You can't save without selecting an option!");
    return false;
  }
  if (sv ==2 && !r1 && !r2 && !r3 && !r4){
    alert("select reject reason!");
    return false;
  }
  if (sv ==2 && rv.length==1){
  alert("Enter Remarks to proceed!");
  return false;
   }
  else{
  return true;
  }
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

  function showuserstats(offerid,glusrid){
    $("#showuserstat").hide();
    $("#userstat").html('Processing...');
    $.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showuserstats&offerid="+offerid+"&glusrid="+glusrid,
                data: "",
        success: function(response){
            $("#userstat").html(response);
            $("#userstat").show();  
        }
    });        
}
function showusage(offerid){
	$("#usage").hide();
    $("#usagestatus").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/getglprofile&type=usage&offerid="+offerid,
                data: "",
        success: function(response){
            $("#usagestatus").html(response);
            $("#usagestatus").show();  
        }
    });   
}

function showtov(offerid){
	$("#tov").hide();
    $("#tovstatus").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/getglprofile&offerid="+offerid,
                data: "",
        success: function(response){
            $("#tovstatus").html(response);
            $("#tovstatus").show();  
        }
    });   
}
function showquantity(offerid){
	$("#quantity").hide();
        $("#quantitystatus").html('Processing...');
	$.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/getglprofilequantity&type=1&offerid="+offerid,
                data: "",
        success: function(response){
            $("#quantitystatus").html(response);
            $("#quantitystatus").show();  
        }
    });   
}
function showfcpdetail(offerid){
  $("#showfcp").hide();
  $("#fcpdetail").html('Processing...');
  $.ajax({
      type: "POST",
      url:"/index.php?r=admin_eto/OfferDetail/showfcpdetail&offerid="+offerid,
              data: "",
      success: function(response){
          $("#fcpdetail").html(response);
                      $("#fcpdetail").show();  
      }
  });        
}
