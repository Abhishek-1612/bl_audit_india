var auto_ajax_call = 0;
var originalState = '';
var detect_change = '';

var somethingChanged = false;
$(document).ready(function () {
	$('#question_list input').change(function () {
		somethingChanged = true;
	});
});

var somethingChanged_new = false;
var $form = $('#saveisqform'),
origForm = $form.serialize();

$('#saveisqform :input').on('change input', function () {
	if($form.serialize() !== origForm){
		somethingChanged_new = true;
	}else{
		somethingChanged_new = false;
	}
});

$(document).on("keydown", "searchForm", function (event) {
	return event.key != "Enter";
});
$(function () {
	$('input[type="text"]').change(function () {
		this.value = $.trim(this.value);
	});
});
$(document).keypress(
	function (event) {
		if (event.which == '13') {
			event.preventDefault();
		}
	});

$(function () {
	var availableTags = [
		"Approximate Order Value",
		"Quantity",
		"Quantity Unit",
		"Currency"
	];
	$(".add_quesdesc").autocomplete({
		source: availableTags,
		minLength: 3,
		appendTo: "#add_questions",
		select: function (a, b) {
			var w = window.open('', '', 'width=0,height=0');
			w.document.write('');
			setTimeout(function () {
				w.close();
			}, 0);
		}
	});
	$(".ui-helper-hidden-accessible").hide();
});

function autocompleteagain() {
	var availableTags = [
		"Approximate Order Value",
		"Quantity",
		"Quantity Unit",
		"Currency"
	];
	$(".add_quesdesc").autocomplete({
		source: availableTags,
		minLength: 3,
		appendTo: "#add_questions",
		select: function (a, b) {
			var w = window.open('', '', 'width=0,height=0');
			w.document.write('');
			setTimeout(function () {
				w.close();
			}, 0);
		}
	});
	$(".ui-helper-hidden-accessible").hide();
}



function lookup(idd, obj, divId) {
	$("#mcatsmain").css("display", "block");
	var inputString = $('#' + idd).val();
	obj = "find";
	if (inputString.length == 0) {
		$('#' + divId).html('<div></div>');
	} else if (inputString.length > 2) {
		if (/[.]/.test(inputString)) {
			$('#' + divId).html('<div></div>');
		} else {
			var typ = 'P';
			auto_ajax_call++;
			$.post("/cron/rpc2.php", {
				queryString: "" + inputString + "",
				ff: "" + typ + "",
				searchtype: "" + obj + "",
				ajax_rq: "" + auto_ajax_call + ""
			}, function (data) {
				if (data.length > 0) {
					var mcat_arr = data.split("###");
					if (mcat_arr[0] == auto_ajax_call) {
						$('#' + divId).html(mcat_arr[1]);
						var typ = 'S';
						auto_ajax_call++;
						$.post("/cron/rpc2.php", {
							queryString: "" + inputString + "",
							ff: "" + typ + "",
							searchtype: "" + obj + "",
							ajax_rq: "" + auto_ajax_call + ""
						}, function (data) {
							if (data.length > 0) {
								var mcat_arr = data.split("###");
								if (mcat_arr[0] == auto_ajax_call) {
									$('#' + divId).append(mcat_arr[1]);
								}
							} else {
								$('#' + divId).append('<div></div>');
							}
						});
					}
				} else {

				}
			});
		}
	} else if (inputString.length <= 2) {
		$('#' + divId).html('<div></div>');
	}
}

function abc(mcatname, mcatid) {
	mcat_name.value = mcatname + "(" + mcatid + ")";
	mcat_id.value = mcatid;
	$("#mcatsmain").hide();
	$("#mcat_image_name").text(mcat_name.value);
	validate();
}

function validate() {
	arr = {};
	arr['mcat_name'] = $('#mcat_name').val();
	arr['mcatid'] = $('#mcat_id').val();
	arr['action'] = document.searchForm.action.value
	$.ajax({
		url: "/index.php?r=admin_marketplace/Isq/Index&mid=3504",
		type: 'post',
		data: arr,
		beforeSend: function () {
			$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='/images/loading2-new.gif' align='absmiddle'></DIV>");
		},
		success: function (result) {
			showimage();
			$('#result').html(result);
			originalState = $("#add_question_list").html();
			detect_change = $("#question_list").html();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status + ':' + thrownError);
			$("#result").html("");
		}
	});
}

function showimage() {
	$("#header").css({
		"text-align": "left",
		"background-image": "linear-gradient(-120deg, white,white,white,white)",
		"padding-left": "5%",
		"color": "blue",
		"margin-bottom": "50px",
		"margin-bottom": "17px"
	});
	$("#isq_heading").css({
		"color": "blue"
	});

}

//save isqform
$(function () {
	$('#saveisqform').on('submit', function (e) {

		$('input[type="text"]').change(function () {
			this.value = $.trim(this.value);
		});
		var dataa = $('#saveisqform').serialize();
		$.ajax({
			type: 'post',
			url: "/index.php?r=admin_marketplace/Isq/Save&mid=3504",
			data: $('#saveisqform').serialize(),
			beforeSend: function () {
				$("#save_btn_result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='/images/loading2-new.gif' align='absmiddle'></DIV>");
				$("#save_btn").hide("fast");
			},
			success: function (result) {
				console.log(result);
				alert(result);
				$('#result').append(result);
				$('#save_btn_result').html('<p style="margin-top:10px ;margin-bottom:-10px;color:green;text-align: center;">' + result + '</p>');
				$("#save_btn").show();
				validate();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr);
				alert(thrownError + "\n" + xhr.responseText);
				$('#save_btn_result').html('<p style="margin-top:10px ;margin-bottom:-10px;color:red;text-align: center;">' + thrownError + ': ' + xhr.responseText + '</p>');
				$("#save_btn").show();
			}
		});
		e.preventDefault();
	});
});

//save  new isqform
$(function () {
	$('#saveisqformNew').on('submit', function (e) {
		$('input[type="text"]').change(function () {
			this.value = $.trim(this.value);
		});
		e.preventDefault();
	});
});

//sortable
$(function () {
	$("#questions").sortable({
		handle: '.ques_priority , #addvalue_save_btn',
		update: function (e, ui) {
			change_priorty();
		}
	});
	$('div[id^="ques_options_"]').sortable({
		handle: '.op1',
		items: '> div:not(.addnewoption)',
		update: function (e, ui) {
			var attr_id = ui.item.attr('data-id');
			var res = document.querySelectorAll('*[name^="opt_prior' + attr_id + '"]');
			var status = document.querySelectorAll('*[id^="quesoptenable' + attr_id + '"]');
			var prior = 1;
			var prior_end = res.length;
			for (i = 0; i < res.length; i++) {
				if (status[i].value != 2) {
					res[i].value = prior;
					prior++;
				} else {
					res[i].value = prior_end;
					prior_end--;
				}
			}
		}
	});
});

// $('#select1').on('change', function() {


// });

function change_priorty() {
	var result = document.querySelectorAll('*[class^="ques_priority_val"]');
	var res = document.querySelectorAll('*[name^="quesprior"]');
	var qstatus = document.querySelectorAll('*[id^="cat_spec_status"]');
	isq_len = result.length;
	var prior = 1;
	var prior_end = isq_len;
	for (k = 0; k < result.length; k++) {

		if (qstatus[k].value != 2) {
			result[k].innerHTML = prior;
			res[k].value = prior;
			prior++;
		} else {
			result[k].innerHTML = prior_end;
			res[k].value = prior_end;
			prior_end--;
		}
	}
}

function change_priority_new() {
	var cnt = $("#questions .ques").length;
	var u = 0;
	for (i = 1; i <= cnt; i++) {
		if ($("#cat_spec_status" + i).val() != 2) {
			u++;
		}
	}
	u++;
	let v = u + 5;
	for (k = 1; k <= 5; k++) {
		let qstatus = $("#add_cat_spec_status" + k).val()
		if (qstatus != 2) {
			$("#add_quesprior" + k).val(u);
			document.getElementById("add_ques_priority_val" + k).innerHTML = u;
			u++;
		} else {
			$("#add_quesprior" + k).val(v);
			document.getElementById("add_ques_priority_val" + k).innerHTML = v;
			v--;
		}

	}
}

function sortableagain(q) {
	$('div[id^="ques_options_' + q + '"]').sortable({
		handle: '.op1',
		items: '> div:not(.addnewoption)',
		update: function (e, ui) {
			var attr_id = ui.item.attr('data-id');
			var res = document.querySelectorAll('*[name^="opt_prior' + attr_id + '"]');
			var status = document.querySelectorAll('*[id^="quesoptenable' + attr_id + '"]');
			var prior = 1;
			var prior_end = res.length;
			for (i = 0; i < res.length; i++) {
				if (status[i].value != 2) {
					res[i].value = prior;
					prior++;
				} else {
					res[i].value = prior_end;
					prior_end--;
				}
			}
		}
	});
}

function delete_isq(i) {
	if (!confirm("Confirm to Delete ISQ")) {
		return false;
	}
	$("#cat_spec_status" + i).val(2);
	$("#ques_" + i).hide("slow");
	change_priorty();
	change_priority_new();
}

function new_delete_isq(i) {
	if (!confirm("Confirm to Remove ISQ")) {
		return false;
	}
	$("#add_ques_" + i).hide("slow");
	$("#add_cat_spec_status" + i).val(2);
	change_priority_new();
	// auto_complete_isq(); 
}

function toggle_plus_button(i) {
	var opt_cnt = $('#total_opt' + i).val();
	var status_count = 0;
	for (j = 1; j <= 50; j++) {
		let ostatus = $('#quesoptenable' + i + '_' + j).val();
		if (ostatus == 1) {
			status_count++;
		}
	}
	if (status_count >= 4) {
		$('#addoption' + i).hide("slow");
		return false;
	} else {
		$('#addoption' + i).show("slow");
		return true;
	}

}

function new_toggle_plus_button(i, cnt) {
	var status_count = 0;
	for (j = 1; j <= 50; j++) {
		let ostatus = $('#add_quesoptenable' + i + '_' + j).val();
		if (ostatus == 1) {
			status_count++;
		}
	}
	if (status_count > 3) {
		$('#new_plusbtn' + i).hide("slow");
		return false;
	} else {
		$('#new_plusbtn' + i).show("slow");
		return true;
	}

}

function add_option(i) {
	var tmp_cnt = $('#total_opt' + i).val();
	tmp_cnt = parseInt(tmp_cnt) + 1;
	$('#total_opt' + i).val(tmp_cnt);
	var j = $("#ques_options_" + i + " > div").length - 1;
	if (j >= 50) {
		alert("More than 50 Options are not allowed");
		return false;
	}

	var m = i;
	var n = j + 1;

	var option = 'option' + m + '_' + n;
	var optionid = '#addoption' + i;
	var newoptionhtml = '<div class="option" id="' + option + '"  data-id="' + m + '">' +
		'<div class="op1"><img src="gifs/menu.gif"></img></div><div class="op2"><input type="text" name="' + option + '" value=""></div><div class="op3"><img src="gifs/bin.png" width="15px" height="18px" onclick="delete_option(' + m + ', ' + n + ')"></img></div>' +
		'<input type="hidden" class="opt_prior" name= "opt_prior' + m + '_' + n + '" value="' + n + '">' +
		'<input type="hidden" name="optionid' + m + '_' + n + '" value="0">' +
		'<input type="hidden" name="quesoptenable' + m + '_' + n + '" id="quesoptenable' + m + '_' + n + '" value="1">' +
		+'</div> ';
	$("input[name=option" + m + "_" + n + "]").focus();
	$(newoptionhtml).insertBefore(optionid);
	// $(optionid).hide();
	// $(optionid).show("slow");

	var qtype = $("input[name=questypename_" + i + "]:checked").val();
	if (qtype == 2 || qtype == 4) {
		toggle_plus_button(i)
		// if (toggle_plus_button(i) == false) {
		// 	alert("More than 4 options are not allowed in following question type\nMultiple Select\nRadio");
		// 	return false;
		// }
	}

}

function new_add_option(i) {
	var j = $("#add_ques_options_" + i + " > div").length - 1;
	if (j >= 50) {
		alert("More than 50 Options are not allowed");
		return false;
	}
	var m = i;
	var n = j + 1;
	var option = 'add_option' + m + '_' + n;
	var optionid = '#new_plusbtn' + i;
	var optionprior = 'add_opt_prior' + m + '_' + n;
	var newoptionhtml = '<div class="option" id="' + option + '" >' +
		'<input type="hidden" name="' + optionprior + '" value="' + n + '">' +
		'<input type="hidden" name="add_optionid' + m + '_' + n + '" value="">' +
		'<input type="hidden" name="add_quesoptenable' + m + '_' + n + '" id="add_quesoptenable' + m + '_' + n + '" value="1">' +
		'<div class="op1"><img src="gifs/menu.gif"></img></div><div class="op2"><input type="text" name="' + option + '" value=""></div><div class="op3"><img src="gifs/bin.png" width="15px" height="18px"  onclick="new_delete_option(' + m + ', ' + n + ')"></img></div></div> ';
	$(newoptionhtml).insertBefore(optionid);
	var qtype = $("input[name=add_questypename_" + i + "]:checked").val();
	if (qtype == 2 || qtype == 4) {
		new_toggle_plus_button(i, j + 1);
	}
}

function toggle_button() {
	var btntext = $("#add_new_ques").text();
	if (btntext == "Add New Isq") {
		btntext = "View Less";
		$("#add_new_ques").html(btntext);
		$("#add_new_ques").css({
			"background-color": "white",
			"color": "#006ecd",
			"border": "solid 2px #006ecd"
		});
		$("#add_question_list").slideDown("slow");
	} else {
		btntext = "Add New Isq";
		$("#add_new_ques").html(btntext);
		$("#add_new_ques").css({
			"background-color": "#006ecd",
			"color": "white",
			"border": "solid 2px #006ecd"
		});
		$("#add_question_list").slideUp("slow");
	}
}

function delete_option(i, j) {
	var count_options = 0;
	var qtype = $("input[name=questypename_" + i + "]:checked").val();
	var status1 = document.querySelectorAll('*[id^="quesoptenable' + i + '"]');
	isq_len1 = status1.length;
	for (p = 0; p < isq_len1; p++) {
		if (status1[p].value != 2) {
			count_options++;
		}
	}
	if (qtype != 1) {
		if (count_options <= 2) {
			alert("Question should have at least two options for type:\nRadio\nDropdown\nMultiple Select");
			return false;
		}
	}
	var opid = 'optionid' + i + '_' + j;
	if ($("input[name=" + opid + "]").val() == 0) {
		$("#option" + i + "_" + j).hide("slow");
	} else {
		$("#option" + i + "_" + j).hide("slow");
	}
	$("#quesoptenable" + i + "_" + j).val(2);
	var res = document.querySelectorAll('*[name^="opt_prior' + i + '"]');
	var status = document.querySelectorAll('*[id^="quesoptenable' + i + '"]');
	isq_len = res.length;
	var prior = 1;
	var prior_end = res.length;
	for (k = 0; k < isq_len; k++) {
		if (status[k].value != 2) {
			res[k].value = prior;
			prior++;
			count_options++;
		} else {
			res[k].value = prior_end;
			prior_end--;
		}
	}
	if (qtype == 2 || qtype == 4) {
		toggle_plus_button(i);
	}
}

function new_delete_option(i, j, l) {
	$("#add_option" + i + "_" + j).html('');
	$("#add_option" + i + "_" + j).hide("slow");
	$("#add_quesoptenable" + i + "_" + j).val(2);
	var qtype = $("input[name=add_questypename_" + i + "]:checked").val();
	if (qtype == 2 || qtype == 4) {
		new_toggle_plus_button(i, j);

	}
}
//validations
function checksubmit() {
	trim_all_input();
	var qlen = $("#questions .ques");
	var qdescArr = new Array();
	var priData = new Array();
	var IsQuantityUnit = IsQuantity = 0;
	for (k = 1; k <= qlen.length; k++) {
		var qtype = $("input[name=questypename_" + k + "]:checked").val();
		var qdesc = $("input[name=quesdesc" + k + "]").val();
		var qprior = $("input[name=quesprior" + k + "]").val();
		var qstatus = $("#cat_spec_status" + k).val();
		if ($("#cat_spec_status" + k).val() != 2) {
			qdescArr.push(qdesc.toUpperCase());
			if (qdesc == '') {
				alert("Isq Name " + k + " cannot be empty");
				$("input[name=quesdesc" + k + "]").focus();
				return false;
			}

			if (!(isNaN(qdesc))) {
				alert("Numeric ISQ is not allowed");
				$("input[name=quesdesc" + k + "]").focus();
				return false;
			}
			var priData = duplicacyCheck(qdescArr);
			if (priData.length != 0) {
				alert("Isq Name can not be same: " + qdesc);
				$("input[name=quesdesc" + k + "]").focus();
				return false;
			}
			if (qdesc.toUpperCase() == "QUANTITY UNIT" || qdesc.toUpperCase() == "APPROXIMATE ORDER VALUE" || qdesc.toUpperCase() == "CURRENCY") {
				if (qtype != 3) {
					alert("For the following Questions \nApproximate Order Value \nQuantity Unit \n Currency \n Only \'Dropdown\' Question type is allowed");
					$("input[name=option" + k + "_" + j + "]").focus();
					return false;
				}
			}
			if (qdesc.toUpperCase() == "QUANTITY UNIT") {
				IsQuantityUnit = 1;
				quantityunit_Prior = qprior;
			}
			if (qdesc.toUpperCase() == "QUANTITY") {
				IsQuantity = 1;
				quantity_Prior = qprior;
			}
			if (qdesc.indexOf(',') > -1) {
				alert("Comma(,) is not allowed in ISQ Name");
				$("input[name=option" + k + "_" + j + "]").focus();
				return false;
			}

		}
		var oplen = $('#total_opt' + k).val();
		oplen = parseInt(oplen);
		var opt_len = 0;
		var optdescArr = new Array();
		for (j = 1; j <= oplen; j++) {
			var odesc = $("input[name=option" + k + "_" + j + "]").val();
			var status = $('#quesoptenable' + k + '_' + j).val();
			if (status == 1 && qstatus == 1) {
				opt_len++;
				if (qdesc.toUpperCase() != "QUANTITY UNIT" && odesc.toUpperCase() == "OTHER" && qtype == 3) {
					alert("'Other' option not allowed in 'Dropdown' Type ISQ");
					$("input[name=add_option" + k + "_" + j + "]").focus();
					return false;
				}
				optdescArr.push(odesc.toUpperCase());
				var priData = duplicacyCheck(optdescArr);
				if (priData.length != 0) {
					alert("Duplicate Option Description is not allowed :" + odesc);
					$("input[name=option" + k + "_" + j + "]").focus();
					return false;
				}
				if (odesc == '' && status == 1 && qtype != 1) {
					alert("Option description can not be empty");
					$("input[name=option" + k + "_" + j + "]").focus();
					return false;
				}
				if (odesc.indexOf(',') > -1) {
					alert("Comma(,) not allowed in option description");
					return false;
				}
				if (odesc.toUpperCase() == "OTHER") {
					$("input[name=option" + k + "_" + j + "]").val("Other");
				}
				if (/^other/.test(odesc)) {
					alert("Use text \'Other\'");
					$("input[name=option" + k + "_" + j + "]").focus()
					return false;
				} else if (/^Others/.test(odesc)) {
					alert("Use text \'Other\'");
					$("input[name=option" + k + "_" + j + "]").focus()
					return false;
				} else if (/^Other\'s/.test(odesc)) {
					alert("Use text \'Other\'");
					$("input[name=option" + k + "_" + j + "]").focus()
					return false;
				}
				if (qtype == 1 && odesc.toUpperCase() == "OTHER") {
					alert("You cannot add \'Other\' option for Question type \'Text\'");
					$("input[name=option" + k + "_" + j + "]").focus();
					return false;
				}
				if (qdesc.toUpperCase() == "QUANTITY UNIT") {
					if (!(isNaN(odesc)) && status == 1) {
						alert("Numeric Option description is not allowed for Quantity Unit");
						$("input[name=option" + k + "_" + j + "]").focus();
						return false;
					}
				}
				if (qdesc.toUpperCase() == "QUANTITY" && qtype != 1) {
					if (status == 1) {
						alert("Question type should be \'Text\' for0 \'Quantity\' Isq");
						$("input[name=option" + k + "_" + j + "]").focus();
						return false;
					}
				}
			}
		}
		if (qtype == 2 || qtype == 4) {
			if (opt_len > 4) {
				alert("More than 4 options are not allowed in following question type\nMultiple Select\nRadio");
				return false;
			}
		}
	}
	if (IsQuantity == 0 && IsQuantityUnit == 1) {
		alert("Quantity unit cannot be updated without Quantity");
		return false;
	}
	if (IsQuantity == 1 && IsQuantityUnit == 1) {
		if (quantity_Prior > quantityunit_Prior) {
			alert("Quantity should come before Quantity Unit");
			return false;
		}
		if (quantityunit_Prior - quantity_Prior != 1) {
			alert("Quantity and Quantity Unit should be consecutive");
			return false;
		}
	}
	detect_change_after = $("#question_list").html();
	if ((!somethingChanged && detect_change == detect_change_after)) {
		alert("Nothing has been changed in the Form");
		return false;
	}
	// if (!somethingChanged_new) {
	// 	alert("Nothing has been changed in the Form");
	// 	return false;
	// }
	var cc = check_duplicat_isq();
	if (cc == true) {
		return false;
	}
	r1 = toggle_modal(1);
	if (!r1) {
		return false;
	}
}

function check_duplicat_isq() {
	var response = false;
	$.ajax({
		type: 'post',
		url: "/index.php?r=admin_marketplace/Isq/Check_existing_isq&mid=3504",
		async: false,
		data: $('#saveisqform').serialize(),
		beforeSend: function () {},
		success: function (result) {
			if (result != '') {
				alert(result);
				response = true;
			}
		}

	});
	return response;
}

function addchecksubmit() {
	var IsQuantityUnit = IsQuantity = 0;
	var validate = true;
	trim_all_input();
	var qlen = $("#add_questions .ques");
	var exising_ques_arr = new Array();
	var exising_ques = $("#questions .ques");
	var count_existing_ques = exising_ques.length + 1;
	for (i = 1; i <= exising_ques.length; i++) {
		var qstatus = $("#cat_spec_status" + i).val();
		if (qstatus == 1) {
			var existing_qdesc = $("input[name=quesdesc" + i + "]").val();
			exising_ques_arr.push(existing_qdesc.toUpperCase());
			if (existing_qdesc.toUpperCase() == "QUANTITY") {
				IsQuantity = 1;
				quantity_Prior = -1;
			}
		}
	}
	new_isq_arr = new Array();
	var check_count = qlen;
	var tot_added_ques = 0;
	for (k = 1; k <= 5; k++) {

		var qtype = $("input[name=add_questypename_" + k + "]:checked").val();
		var qdesc = $("input[name=add_quesdesc" + k + "]").val();
		var qprior = $("input[name=add_quesprior" + k + "]").val();
		let qstatus = $("#add_cat_spec_status" + k).val();
		if (qstatus == 1 && typeof qtype !== "undefined") {
			tot_added_ques++;
			if (qdesc == '' && typeof qdesc !== "undefined") {
				alert("Isq Name cannot be blank");
				$("input[name=add_quesdesc" + k + "]").focus();
				return false;
			}
			if (!(isNaN(qdesc))) {
				alert("Numeric ISQ is not allowed");
				$("input[name=add_quesdesc" + k + "]").focus();
				return false;
			}
			if (qdesc.indexOf(',') > -1) {
				alert("Comma(,) is not allowed in Isq Name");
				return false;
			}
			new_isq_arr.push(qdesc.toUpperCase());
			exising_ques_arr.push(qdesc.toUpperCase());
			var priData = duplicacyCheck(exising_ques_arr);
			if (priData.length != 0) {
				alert("Isq Name \'" + qdesc + "\' already exist");
				$("input[name=add_quesdesc" + k + "]").focus();
				return false;
			}
			if (qdesc.toUpperCase() == "QUANTITY UNIT" || qdesc.toUpperCase() == "APPROXIMATE ORDER VALUE" || qdesc.toUpperCase() == "CURRENCY") {
				if (qtype != 3) {
					alert("For the following Questions \nApproximate Order Value \nQuantity Unit \nCurrency \nOnly \'Dropdown\'Question type is allowed");
					$("input[name=add_option" + k + "_" + j + "]").focus();
					return false;
				}
			}
			if (qdesc.toUpperCase() == "QUANTITY UNIT") {
				IsQuantityUnit = 1;
				quantityunit_Prior = qprior;
			}
			if (qdesc.toUpperCase() == "QUANTITY") {
				IsQuantity = 1;
				quantity_Prior = qprior;
			}
			var optdescArr = new Array();
			var opt_len = 0;
			var options = document.querySelectorAll('*[id^="add_option' + k + '"]');
			for (var j = 1; j < 50; j++) {
				var odesc = $("input[name=add_option" + k + "_" + j + "]").val();
				var ostatus = $('#add_quesoptenable' + k + '_' + j).val();
				if (odesc != null && ostatus == 1) {
					opt_len++;
					if (qdesc.toUpperCase() != "QUANTITY UNIT" && odesc.toUpperCase() == "OTHER" && qtype == 3) {
						alert("'Other' option not allowed in 'Dropdown' Type ISQ");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					}
					optdescArr.push(odesc);

					var priData = duplicacyCheck(optdescArr);
					if (priData.length != 0) {
						alert("Duplicate Option Description is not allowed :" + odesc);
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					}

					if (odesc == '' && qtype != 1) {
						alert("Option description can not be empty");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					}

					if (odesc.indexOf(',') > -1) {
						alert("Comma(,) not allowed in option description");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					}
					if (odesc.toUpperCase() == "OTHER") {
						$("input[name=add_option" + k + "_" + j + "]").val("Other");
					}
					if (/^other/.test(odesc)) {
						alert("Use text \'Other\'");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					} else if (/^Others/.test(odesc)) {
						alert("Use text \'Other\'");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					} else if (/^Other\'s/.test(odesc)) {
						alert("Use text \'Other\'");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					}

					if (qtype == 1 && odesc.toUpperCase() == "OTHER") {
						alert("You cannot add \'Other\' option for Text type Question");
						$("input[name=add_option" + k + "_" + j + "]").focus();
						return false;
					}
					if (qdesc.toUpperCase() == "QUANTITY UNIT") {
						if (!(isNaN(odesc))) {
							alert("Numeric option description is not allowed for Quantity Unit");
							$("input[name=add_option" + k + "_" + j + "]").focus();
							return false;
						}
					}
					if (qdesc.toUpperCase() == "QUANTITY") {
						if (qtype != 1) {
							alert("Question type should be \'Text\' for\'Quantity\' Isq");
							$("input[name=add_option" + k + "_" + j + "]").focus();
							return false;
						}
					}
				}
			}
			if (qtype == 2 || qtype == 4) {
				if (opt_len > 4) {
					alert("More than 4 options are not allowed in following question type\nMultiple Select\nRadio");
					return false;
				}
			}
		} else {
			if (document.getElementById("add_ques_" + k) && qdesc != '' && qstatus == 1) {
				alert("Please Select Question type for ISQ");
				return false;
			}
		}
	}
	if (tot_added_ques == 0) {
		alert("Please Add atleast 1 ISQ");
		return false;
	}

	if (IsQuantity == 0 && IsQuantityUnit == 1) {
		alert("Quantity unit cannot be updated without Quantity");
		return false;
	}
	if (IsQuantity == 1 && IsQuantityUnit == 1) {
		if (quantity_Prior > quantityunit_Prior) {
			alert("Quantity should come before Quantity Unit");
			return false;
		}
		if (quantityunit_Prior - quantity_Prior != 1 && quantity_Prior != -1) {
			alert("Quantity and Quantity Unit should be consecutive");
			return false;
		}
	}
	let tmp_cnt = $("#total_ques").val();
	tmp_cnt = parseInt(tmp_cnt) + parseInt(tot_added_ques);
	$("#total_ques").val(tmp_cnt);
	if (validate) {
		var r = confirm("Click \'Ok\' to Add New Isq or\n\'Cancel\' to Change");
		if (!r) {
			return false;
		}

	} else {
		return false;
	}

	validate = add_isq_to_existing(tot_added_ques, count_existing_ques);
	change_priority_new();
	$("#no_isq").hide("slow");
	$("#saveisqform").show("slow");
	return false;


}

function duplicacyCheck(data) {
	var uniqueDataArr = new Array();
	data.forEach(function (element, index) {
		if (data.indexOf(element, index + 1) > -1) {
			if (uniqueDataArr.indexOf(element) === -1) {
				uniqueDataArr.push(element);
			}
		}
	});
	return uniqueDataArr;
}

function add_isq_to_existing(t, u) {
	let k = 1;
	for (i = 1; i <= 5; i++) {
		var qdesc = $("input[name=add_quesdesc" + i + "]").val();
		var qstatus = $("#add_cat_spec_status" + i).val();
		if (qstatus != 2 && qdesc != '') {
			var qtype = $("input[name=add_questypename_" + i + "]:checked").val();
			var qprior = $("input[name=add_quesprior" + i + "]").val();

			append_isq(u, k, qdesc, qtype, qprior, i);
			u++;
			k++;
		}
	}
	$("#add_question_list").html(originalState);
	autocompleteagain();
	change_priority_new();
	toggle_button();
	change_priorty();
	return false;
}

function append_isq(i, k, qdesc, qtype, qprior, a) {
	var options = document.querySelectorAll('*[id^="add_option' + k + '"]');
	total_opt = options.length;
	var tsel, rsel, dsel, mssel;
	tsel = rsel = dsel = mssel = plus_button = option_display = "";
	if (qtype == 1) {
		tsel = "checked";
		plus_button = "display:none;";
		option_display = 'style = "display:none;"';
	} else if (qtype == 2) {
		rsel = "checked";
	} else if (qtype == 3) {
		dsel = "checked";
	} else {
		mssel = "checked";
	}
	var qdiv = '' +
		'<div class="ques" id="ques_' + i + '">' +
		'<input type="hidden" class="quesprior" id="quesprior' + i + '" name="quesprior' + i + '" value="' + i + '">' +
		'<input type="hidden" name="cat_spec_status' + i + '" id="cat_spec_status' + i + '" value="1">' +
		'<input type="hidden" name="quesmasterid' + i + '" id="quesmasterid' + i + '" value="0">' +
		'<input type="hidden" name="supplier_prior' + i + '" id="supplier_prior' + i + '" value="0">' +
		'<input type="hidden" name="questype' + i + '" value="' + qtype + '">' +
		'<input type="hidden" name="total_opt' + i + '" id="total_opt' + i + '" value=' + total_opt + '>' +
		'<div class="ques_priority ui-sortable-handle" id="ques_priority' + i + '">' +
		'<div style=" padding:5px; border-radius:3px; background-color:#bfddf3" class="ques_priority_val" id="ques_priority_val' + i + '">' + i + '</div>' +
		'</div>' +
		'<div class="ques_description">' +
		'<div>' +
		'<span>' +
		'<input type="text" value="' + qdesc + '" name="quesdesc' + i + '">' +
		'</span>' +
		'</div>' +
		'</div>' +
		'<div class="ques_type">' +
		'<div>' +
		'<span style="margin-right:22px"><input type="radio" name="questypename_' + i + '" value="1" ' + tsel + ' onclick="return false;"></span>' +
		'<span style="font-size: 14px;font-weight: bolder;"> T</span>' +
		'</div>' +
		'<div>' +
		'<span style="margin-right:22px"><input type="radio" name="questypename_' + i + '" value="2" ' + rsel + ' onclick="return false;"> </span>' +
		'<span style="font-size: 14px;font-weight: bolder;">R</span>' +
		'</div>' +
		'<div>' +
		'<span style="margin-right:22px"><input type="radio" name="questypename_' + i + '" value="3" ' + dsel + ' onclick="return false;"> </span>' +
		'<span style="font-size: 14px;font-weight: bolder;">D</span>' +
		'</div>' +
		'<div>' +
		'<span style="margin-right:22px"><input type="radio" name="questypename_' + i + '" value="4" ' + mssel + ' onclick="return false;"></span>' +
		'<span style="font-size: 14px;font-weight: bolder;">MS</span>' +
		'</div>' +
		'</div>' +
		'<div class="ques_delete">' +
		'<img src="gifs/bin.png" width="24px" height="24px" onclick="delete_isq(' + i + ')">' +
		'</div>' +
		'<div class="ques_options ui-sortable" id="ques_options_' + i + '" ' + option_display + '>' +
		'';
	var p = 0;
	for (j = 1; j <= 50; j++) {
		var odesc = $("input[name=add_option" + a + "_" + j + "]").val();
		if (odesc != null) {
			p++
			qdiv += '' +
				'<div class="option" id="option' + i + '_' + p + '" data-id="' + i + '">' +
				'<div class="op1 ui-sortable-handle">' +
				'<img src="gifs/menu.gif">' +
				'</div>' +
				'<div class="op2">' +
				'<input type="text" name="option' + i + '_' + p + '" value="' + odesc + '" style="" >' +
				'</div>' +
				'<div class="op3">' +
				'<img src="gifs/bin.png" width="15px" height="18px" onclick="delete_option(' + i + ' , ' + p + ')">' +
				'</div>' +
				'<input type="hidden" class="opt_prior" name="opt_prior' + i + '_' + p + '" value="' + p + '">' +
				'<input type="hidden" name="optionid' + i + '_' + p + '" value="0">' +
				'<input type="hidden" name="quesoptenable' + i + '_' + p + '" id="quesoptenable' + i + '_' + p + '" value="1">' +
				'</div>' +
				'';
		}
	}
	qdiv += '' +
		'<div id="addoption' + i + '" style="font-size: 35px;color: #0065ca; ' + plus_button + '" class="addnewoption" onclick="add_option(' + i + ')">+</div>' +
		'</div>' +
		'</div>' +
		'';
	$("#questions").append(qdiv);
	// $("#ques_"+i).hide("fast");
	$("#ques_" + i).show("slow");
	sortableagain(i);
	toggle_plus_button(i);
	autocompleteagain();

}

function change_ques_type(t, i) {
	$("#add_questype" + i).val(t);
	var j = 0;
	if (t == 1) {
		let j = 1;
		var newoptionhtml = '' +
			'<div class="option" id="add_option' + i + '_' + j + '" style = "display:none;">' +
			'<input type="hidden" name="add_optionid' + i + '_' + j + '" value="">' +
			'<input type="hidden" name="add_opt_prior' + i + '_' + j + '" value="' + j + '">' +
			'<input type="hidden" name="add_quesoptenable' + i + '_' + j + '" id="add_quesoptenable' + i + '_' + j + '" value="1">' +
			'<div class="op1">' +
			'<img src="gifs/menu.gif"></img></div>' +
			'<div class="op2"><input type="text" name="add_option' + i + '_' + j + '" value="None" style="cursor: not-allowed;" readonly ></div>' +
			'<div class="op3">' +
			'<img src="gifs/bin.png" width="15px" height="18px" onclick="new_delete_option(' + i + ',' + j + ')"></img></div></div>'
		$("#add_ques_options_" + i).html(newoptionhtml);
	} else {
		var newoptionhtml = '';
		for (j = 1; j <= 2; j++) {
			newoptionhtml += '<div class="option" id="add_option' + i + '_' + j + '">';
			newoptionhtml += '' +
				'<input type="hidden" name="add_optionid' + i + '_' + j + '" value="">' +
				'<input type="hidden" name="add_opt_prior' + i + '_' + j + '"  value="' + j + '">' +
				'<input type="hidden" name="add_quesoptenable' + i + '_' + j + '" id="add_quesoptenable' + i + '_' + j + '" value="1">';
			newoptionhtml += '<div class="op1">' +
				'<img src="gifs/menu.gif"></img></div>' +
				'<div class="op2"><input type="text" name="add_option' + i + '_' + j + '" value=""></div>' +
				'<div class="op3">' +
				'<img src="gifs/bin.png" width="15px" height="18px" onclick="new_delete_option(' + i + ',' + j + ')"></img></div></div>';
		}
		newoptionhtml += '<div style="font-size: 35px;color: #0065ca;" class="addnewoption" id="new_plusbtn' + i + '" onclick="new_add_option(' + i + ')">+</div>';
		$("#add_ques_options_" + i).html(newoptionhtml);
	}
	$("#add_ques_options_" + i).show();
}

function trim_all_input() {
	$('input[type="text"]').change(function () {
		this.value = $.trim(this.value);
	});
}

function default_isq_autosuggest(i) {
	$("#add_ques_delete" + i).show("slow");
	var qdesc = $("input[name=add_quesdesc" + i + "]").val();
	if (qdesc.toUpperCase() == "QUANTITY UNIT") {
		$("input[name=add_questypename_" + i + "]")[2].checked = true;
		change_ques_type(3, i);
	}
	if (qdesc.toUpperCase() == "QUANTITY") {
		$("input[name=add_questypename_" + i + "]")[0].checked = true;
		change_ques_type(1, i);
	}
	if (qdesc.toUpperCase() == "APPROXIMATE ORDER VALUE") {
		var newoptionhtml = '';
		var arr = [0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300];
		for (j = 1; j <= 13; j++) {
			newoptionhtml += '<div class="option" id="add_option' + i + '_' + j + '">';
			newoptionhtml += '' +
				'<input type="hidden" name="add_optionid' + i + '_' + j + '" value="">' +
				'<input type="hidden" name="add_opt_prior' + i + '_' + j + '"  value="' + j + '">' +
				'<input type="hidden" name="add_quesoptenable' + i + '_' + j + '" id="add_quesoptenable' + i + '_' + j + '" value="1">';
			newoptionhtml += '<div class="op1">' +
				'<img src="gifs/menu.gif"></img></div>' +
				'<div class="op2"><input type="text" name="add_option' + i + '_' + j + '" value="' + arr[j] + '"></div>' +
				'<div class="op3">' +
				'<img src="gifs/bin.png" width="15px" height="18px" onclick="new_delete_option(' + i + ',' + j + ')"></img></div></div>';
		}
		$("#add_ques_options_" + i).html(newoptionhtml);
		$("#add_ques_options_" + i).show();
		$("input[name=add_questypename_" + i + "]")[2].checked = true;

	}
	if (qdesc.toUpperCase() == "CURRENCY") {
		$("input[name=add_questypename_" + i + "]")[2].checked = true;
		var newoptionhtml = '';
		var arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
		for (j = 1; j <= 13; j++) {
			newoptionhtml += '<div class="option" id="add_option' + i + '_' + j + '">';
			newoptionhtml += '' +
				'<input type="hidden" name="add_optionid' + i + '_' + j + '" value="">' +
				'<input type="hidden" name="add_opt_prior' + i + '_' + j + '"  value="' + j + '">' +
				'<input type="hidden" name="add_quesoptenable' + i + '_' + j + '" id="add_quesoptenable' + i + '_' + j + '" value="1">';

			newoptionhtml += '<div class="op1">' +
				'<img src="gifs/menu.gif"></img></div>' +
				'<div class="op2"><input type="text" name="add_option' + i + '_' + j + '" value="' + arr[j] + '"></div>' +
				'<div class="op3">' +
				'<img src="gifs/bin.png" width="15px" height="18px" onclick="new_delete_option(' + i + ',' + j + ')"></img></div></div>';
		}
		$("#add_ques_options_" + i).html(newoptionhtml);
		$("#add_ques_options_" + i).show();

	}

}

function docuploadWithName(empid, validationKey, url) {
	var fileUpload = event.target.files[0];
	var filename = fileUpload.name;
	if (filename.search(/^[\w\.\_\-]+$/) == -1) {
		alert('Doc name can contain only alphabets (a-z A-Z) , numbers (0-9) , underscore (_) or hiphen (-).\nFile name should not contain Spaces.');
		$("#file").val('');
		return false;
	} else if (filename.length > 65) {
		alert('Doc name cannot have more than 65 characters.');
		$("#file").val('');
		return false;
	}
	if (!(filename.match(/.(jpg|jpeg|png|doc|pdf|docx)$/i))) {
		alert('Only following file formats are allowed\n .jpg\n .jpeg\n .png\n .doc\n .pdf\n .docx');
		$("#file").val('');
		return false;
	}
	var imgtype = 'Default';
	if ((filename.match(/.(pdf|docx)$/i))) {
		imgtype = 'Doc';
	}
	savedoc(imgtype, empid, validationKey, url);
}

function savedoc(imgtype, empid, validationKey, url) {
	var opDiv = 'Document';
	var fileUpload = event.target.files[0];
	var filename = fileUpload.name;
	var imageName = 'Doc'
	var empId = empid;
	var validationKey = validationKey;
	var formdata = new FormData();
	formdata.append("IMAGE", fileUpload);
	formdata.append("IMAGE_NAME", imageName);
	if (imgtype == 'Doc') {
		formdata.append("IMAGE_ID", '');
	}
	formdata.append("MODID", 'GLADMIN');
	formdata.append("USR_ID", empId);
	formdata.append("IMAGE_TYPE", imgtype);
	formdata.append("UPLOADED_BY", empId);
	formdata.append("VALIDATION_KEY", validationKey);
	filename = filename.toLowerCase();
	$.ajax({
		type: "POST",
		url: url,
		contentType: "application/x-www-form-urlencoded",
		cache: false,
		contentType: false,
		processData: false,
		data: formdata,
		beforeSend: function () {
			$("#docuploaded").html("<span STYLE='font-size:10px; font-family:arial; text-align:center; color:#333333; margin-left:3px;'>Processing.....<br><IMG SRC='/gifs/loading2.gif' align='absmiddle'></span>");
		},
		success: function (response) {
			if (response.Code == 200 && response.Status == 'Success') {
				$('#' + opDiv).html('<b><a href=' + response.Data.AwsPath.Image_Original_Path + ' target="_blank">Document Link</a></b><input type="hidden" name=' + opDiv + ' value=' + response.Data.AwsPath.Image_Original_Path + ' id=' + opDiv + '>');;
				alert("Document Uploaded Successfully");
				$('#docurl').val(response.Data.AwsPath.Image_Original_Path);
				$('#docuploaded').html('<a href=' + response.Data.AwsPath.Image_Original_Path + ' target="_blank" style="font-size:14px;">Document</a>');
				$("#delete_doc").show();
			} else {
				alert('Upload Doc Service Failure.\n Error Msg:-' + response.Reason);
				$("#file").val('');
				// $("#docuploaded").html('<b>Upload Service Failed</b>');
			}
		},
		error: function (jqXHR, exception) {
			alert('Upload Doc Service Failure.Please Try again.');
			$("#file").val('');
			$("#docuploaded").html('<b>Upload Service Failed</b>');
		}
	});
}

function toggle_modal(a) {
	if (a == 1) {
		$("#myModal").show();
		return false;
	} else if (a == 2) {
		if ($("#save_comment").val() == '') {
			alert("Comment cannot be Empty");
			return false;
		}
		$("#myModal").hide();
		var r = confirm("Are you sure to Add & Save All\nClick OK to continue, or Cancel to Change");
		if (!r) {
			return false;
		} else {
			return true;
		}
	} else {
		$("#myModal").hide();
	}
}

function updateCountdown() {
	var len = $(".comment").val().length;
	var remaining = 3800 - parseInt(len);

	if(remaining ==0){
			$("#remaining").css("color", "red");
	}else{
		$("#remaining").css("color", "grey");
	}
	$('.countdown').text(remaining + ' characters remaining.');
	if (remaining <= 0) {
		alert("only 3800 characters are allowed.");
		return false;
	}
}

function delete_doc() {
	$("#delete_doc").hide("slow");
	$("#file").val("");
	$('#docuploaded').html("");
}

window.onclick = function (event) {
	var modal = document.getElementById("myModal");
	if (event.target == modal) {
		modal.style.display = "none";
	}
}