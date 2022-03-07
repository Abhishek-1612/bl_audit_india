<html>
   <head>
   <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
        <script>
        function  querycall(arg){
          var url = "/index.php?r=admin_bl/NonInterested/FirstQuery&action="+arg;
			
			    $("#loading").show(); 
                $.ajax({
                    type: "POST",
                    url: url,
                    data:"",
                    //async: false,
                    success: function(result){
                        $("#loading").hide();
                        $("input[type=submit]").attr('disabled', false);
                        if(result!=''){
                            $("#drop_div").html(result);
                        }else{
                        $("#drop_div").html('Problem Occured.');
                        }			
                    },
                    error: function() {
                        $("#loading").hide();
                        $("input[type=submit]").attr('disabled', false);
                        $("#error").show;
                        $("#drop_div").html('<span><center><font size = "3"><b>Something Went Wrong. Kindly Try again.</b></font></center></span>');
                    }
                });
        }

        function updateEmployee(glid,obj){
          empid = obj.value;
          var url = "/index.php?r=admin_bl/NonInterested/UpdateEmp&glid="+glid+"&empid="+empid;
			
                $.ajax({
                    type: "POST",
                    url: url,
                    data:"",
                    //async: false,
                    success: function(result){
                        		
                    },
                    error: function() {
                         }
                });
        }
        </script>
        <body>
      <div >
    <center><h3 style="background-color:blue;padding: 2px;">Glid to be worked upon today :</h3></center>
<div>
<center>
<!-- <button bgcolor="F9FCFF" onclick="querycall('great90')" style="cursor:pointer;padding:6px 6px 6px 6px;" id="great90"> >90 day Client</button> -->
<button bgcolor="F9FCFF" onclick="querycall('less90')" style="cursor:pointer;padding:6px 6px 6px 6px;" id="less90"><=90 day Client</button>
</center></div>

<br>
<br>
<div id="drop_info" class="inline">
                <div id="loading" style="display:none;" align="center"><img src="/images/loading2-new.gif"> Loading...</div>
                <div id="error" style="display:none;" align="center"><font color="red">Something Went Wrong. Kindly Try again.</font></div>
                <div id="drop_div" class="inline"></div>
             
            </div>
      </div>
      </body>
      </head>
      </html>