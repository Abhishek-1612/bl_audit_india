
function chk_data()
{
	if(document.eto_report.from_date.value == '')
	{
		alert('From date can not be blank');
		document.eto_report.from_date.focus();
		return false;
	}

// 	if(document.fcp_report.status.value == '')
// 	{
// 		alert('Kindly select at least one Rejection Reason');
// 		document.fcp_report.status.focus();
// 		return false;
// 	}

	if(document.eto_report.to_date.value == '')
	{
		monthMaxDays	= [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		monthMaxDaysLeap= [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		hideSelectTags = [];

		var from_date=document.eto_report.from_date.value;
		var date = from_date.split('-');
		var day = date[0];
		var month = date[1];
		var year = date[2];

		var mon = 0;
		var monthArrayShort = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
		for (i =0; i<= 11; i++ )
		{
			if (monthArrayShort[i] == date[1])
			{
				mon = i;
				break;
			}
		}
		mon++;

		var mon=Number(mon) - 1;
		var totaldays=getDaysPerMonth(mon,year);
		if(totaldays >= Number(day))
		{
			day=getDaysPerMonth(mon,year);
		}
		else
		{
			day=1;
			if(Number(month) == 12)
			{
				month=1;
				year = Number(year)+1;
			}
			else
			{
				month=Number(month)+1;
			}
		}
		day	= day < 10 ? '0'+day : day;
		month	= month < 10 ? '0'+month : month;
		document.eto_report.to_date.value=day+'-'+month+'-'+year;
	}

	if (document.eto_report.to_date.value != '')
	{
		var str1 = document.eto_report.from_date.value;
		var str2 = document.eto_report.to_date.value;

		if(str2 != '')
		{
			var date1 = str1.split('-');
			var day1 = date1[0];
			var mon1 = date1[1];
			var year1 = date1[2];
			var date2 = str2.split('-');
			var day2 = date2[0];
			var mon2 = date2[1];
			var year2 = date2[2];
//alert(mon1+' '+mon2);
			if(mon1 != mon2)
			{
				monthMaxDays= [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
				monthMaxDaysLeap= [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
				hideSelectTags = [];
				var monthArrayShort = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
				for (i =0; i<= 11; i++ )
				{
					if (monthArrayShort[i] == mon1)
					{
						check_first_mon = i;
						break;
					}
				}

				for (i =0; i<= 11; i++ )
				{
					if (monthArrayShort[i] == mon2)
					{
						check_second_mon = i;
						break;
					}
				}

				var data1 = check_second_mon - check_first_mon;
//alert(data1);
				if(data1 == 1 )
				{
//alert(year1+' '+year2);
					if(year1 == year2)
					{
						var totaldays1=getDaysPerMonth(check_first_mon,year1);
						var final = totaldays1 - day1;
						var final_date = Number(final) + Number(day2);

						if(totaldays1 == 31 || totaldays1 == 30)
						{
							final_date = final_date+1;
						}
						else if(totaldays1 == 28 || totaldays1 == 29)
						{
							final_date = final_date+1;
						}
						else
						{
						}

						if(final_date <= 31)
						{

						}
						else
						{
							alert("Please Select Date Range Less Than Or Equal to 31 Days");
							return false;
						}
					}
					else
					{
						alert("Please Select Same year");
						return false;
					}
				}
				else if(check_first_mon > check_second_mon && year1 == year2)
				{

					alert("End Date Can not be Greater Than Start Date.");
						return false;
				}
				else if(data1 == -11)
				{
					var totaldays1=getDaysPerMonth(check_first_mon,year1);
					var final = totaldays1 - day1;
					var final_date = Number(final) + Number(day2);
					if(totaldays1 == 31)
					{
					final_date = final_date+1;
					}
					else if(totaldays1 == 28 || totaldays1 == 29)
					{
						final_date = final_date+1;
					}
					else{
					}

					if(final_date <= 31)
					{

					}
					else
					{
						alert("Please Select Date Range Less Than Or Equal to 31 Days");
						return false;

					}
				}
				else
				{
					alert("Please Select Date Range Less Than Or Equal to 31 Days");
					return false;
				}
			}
			else if(mon1 == mon2 && year1 != year2)
			{
				alert("Please Select Same year");
				return false;
			}
		}
	}
}

function getDaysPerMonth(month, year)
{
	/*
	Check for leap year. These are some conditions to check year is leap year or not...
	1.Years evenly divisible by four are normally leap years, except for...
	2.Years also evenly divisible by 100 are not leap years, except for...
	3.Years also evenly divisible by 400 are leap years.
	*/
	if ((year % 4) == 0)
	{
		if ((year % 100) == 0 && (year % 400) != 0)
			return monthMaxDays[month];

		return monthMaxDaysLeap[month];
	}
	else
		return monthMaxDays[month];
}

function Reset_form()
{
	document.eto_report.from_date.value = '';
	document.eto_report.to_date.value = '';
}
function toggle(ele,ofr_id) {
// 	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText_"+ofr_id);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "Show Details";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "Hide Details";
	}
}
function SwitchMenu2(obj)
		{
			var already_details = document.getElementById('offer_details').value;
			if(document.getElementById)
			{
				var el = document.getElementById(obj);
				var ar = document.getElementById("masterdiv").getElementsByTagName("div");
				if(el.style.display != "block")
				{
					if(already_details != 0)
					{
						document.getElementById('s'+already_details).style.display="none";
						document.getElementById('n'+already_details).className = "m-row";
					}
					el.style.display = "block";

					var obj1 = obj.split('s');
					document.getElementById('offer_details').value=obj1[1];
				}
				else
				{
					el.style.display = "none";
				}
			}
		}

		function bg(obj)
		{
			if(document.getElementById)
			{
				var el1 = document.getElementById(obj);
				var ar1 = document.getElementById("masterdiv").getElementsByTagName("div");
				if(el1.className != 'm-row1')
				{
					el1.className = "m-row1";
				}
				else
				{
					el1.className = "m-row";
				}
			}
		}