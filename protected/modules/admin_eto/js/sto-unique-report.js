function checkvalidate () 
{
	if(validateDates()) 
	{
		return true;
	}
	else {
		return false;
	}
}
			
			function form_reset() {
				document.getElementById('from_date').value = '';
				document.getElementById('to_date').value = '';
				document.getElementById('my_group').checked = false;
				document.getElementById('emp_id').value = '';
				document.getElementById('emp_name').value = '';
			}
			
			function LookupEmployee(form,field,alphabet,empid) {
				var s = document.fcp_report.emp_name.value;
				s = s.replace(/(^\s*)|(\s*$)/gi,"");
				s = s.replace(/[ ]{2,}/gi," ");
				s = s.replace(/\n /,"\n");
				document.fcp_report.emp_name.value = s;

				if(document.fcp_report.emp_name.value =='') {
					alert('Please Enter Name To Search');
					document.fcp_report.emp_name.focus();
					return false;
				}
				if(document.fcp_report.emp_name.value.search(/^[0-9]+$/) != -1) {
					alert('Numeric Values Are Not Allowd');
					document.fcp_report.emp_name.value="";
					document.fcp_report.emp_name.value.focus();
					return false;
				}
				if(document.fcp_report.emp_name.value !='') {
					var iChars = "\W";
					for(var i = 0; i < document.fcp_report.emp_name.value.length; i++) {
						if (iChars.indexOf(document.fcp_report.emp_name.value.charAt(i)) != -1) {
							alert('Name Should Not Contain Special Characters');
							document.fcp_report.emp_name.value='';
							document.fcp_report.emp_name.focus();
							return false;
						}
					}
				}
				if (empid != '') {
					//window.open('/admin_query/emp_name.pl?formname='+form+'&fieldname='+field+'&alpha='+alphabet,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=350,height=400,left=0,top=0');
					  window.open('common-php/emp_name_k.php?formname=fcp_report&field[1]=emp_id&field[2]=emp_name&alpha='+alphabet,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=350,height=400,left=0,top=0');
				}
				else if(alphabet != '') {
					//window.open('/admin_query/emp_name.pl?formname='+form+'&fieldname='+field+'&alpha='+alphabet,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=350,height=400,left=0,top=0');
					  window.open('common-php/emp_name_k.php?formname=fcp_report&field[1]=emp_id&field[2]=emp_name&alpha='+alphabet,'Lookup','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=350,height=400,left=0,top=0');
				}
				else {
					alert('Kindly fill any keyword first');
					document.fcp_report.emp_name.focus();
				}
			}
			
			function chk_emp() {
				if (document.fcp_report.emp_name.value != '') {
					if(document.fcp_report.emp_id.value == '') {
						alert("Please Search Employee First And Select From Popup Window");
						document.fcp_report.emp_name.focus();
						return false;
					}
				}
				if(document.getElementById('my_group').checked){
					if (document.fcp_report.emp_name.value == '') {
						alert("Please enter manager name");
						document.fcp_report.emp_name.focus();
						return false;
					}

				}
			}