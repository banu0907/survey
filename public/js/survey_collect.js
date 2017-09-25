$(function () {
    // -------------------------
    //  Ajax状态显示
    // ------------------------
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
/*    
    $(document).ajaxStart(function() {
        $("#action-status-info").show();
    });
    $(document).ajaxStop(function() {
        $("#action-status-info").hide();
    });
*/



	$("#start_time").ECalendar({
			 type:"time",
			 stamp:false,
			 skin:5,
			 format:"yyyy年mm月dd日 hh时ii分",
			 callback:function(v,e)
			 {
				 // $(".callback span").html(v)
				 console.log(v+ "\n"+e);
			 }
	});

	// 多次回覆
	$("input[name=\"allow_multiple_responses\"]").click(function () {
		var allow_multiple_responses = $(this).val() ;
		console.log(allow_multiple_responses);
		// alert(allow_multiple_responses);
		$.ajax({
			url: app_url + '/collect/' + survey_id,
			type: 'POST',
			dataType: 'json',
			data: {
				allow_multiple_responses: allow_multiple_responses
			},
			success: function (data) {
				console.log("返回："+data);
				if (data == true) {
					$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
				}else {
					alert("更新设置失败");
				};
			}
		});
		
	});

	// 回复编辑
	$("input[name=\"edit-responses\"]").click(function() {
		var edit_responses = $(this).val();
		$.ajax({
			url: app_url + '/collect/' + survey_id,
			type: 'POST',
			dataType: 'json',
			data: {
				edit_responses: edit_responses
			},
			success: function (data) {
				if (data == true) {
					$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
				} else {
					alert("更新设置失败");
				};
			}
		});
	});

	// 匿名回覆
	$("input[name=\"make-anonymous\"]").click(function () {
		var make_anonymous = $(this).val();
		$.ajax({
			url: app_url + '/collect/' + survey_id,
			type: 'POST',
			dataType: 'json',
			data: {
				make_anonymous: make_anonymous
			},
			success:function(data){
				if (data == true) {
					$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
				} else {
					alert("更新设置失败");
				};
			}
		});
		
	});


	// 即时结果
	$("input[name=\"instant-results\"]").click(function () {
		var instant_results = $(this).val();
		$.ajax({
			url: app_url + '/collect/' + survey_id,
			type: 'POST',
			dataType: 'json',
			data: {
				instant_results: instant_results
			},
			success:function(data){
				if (data == true) {
					$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
				} else {
					alert("更新设置失败");
				};
			}
		});
	});

	// 截止日期与时间
	$("input[name=\"cutoff-date\"]").click(function () {
		var cutoff_date = $(this).val();
		if(cutoff_date === "true" ){
			$("#cutoff-input").show();
			// console.log('show');
		} else {
			$("#cutoff-input").hide();
			// console.log('hide');
			$.ajax({
				url: app_url + '/collect/' + survey_id,
				type: 'POST',
				dataType: 'json',
				data: {
					end_time: cutoff_date
				},
				success:function(data){
					if (data == true) {
						$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
					} else {
						alert("更新设置失败");
					};
				}
			});
		}
	});


	// 日期控件
	var end_time;
	$("#cutoff_datepicker").ECalendar({
			 type:"time",
			 stamp:false,
			 skin:5,
			 format:"yyyy-mm-dd hh:ii",
			 callback:function(v,e)
			 {
				 console.log(v+ "\n"+e);
				end_time = String(v);
				$.ajax({
					url: app_url + '/collect/' + survey_id,
					type: 'POST',
					dataType: 'json',
					data: {
						end_time: end_time
					},
					success:function(data){
						if (data == true) {
							$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
						} else {
							alert("更新设置失败");
						};
					}
				});
			 }
	});

	// $("#cutoff_datepicker").change(function () {
	// 	var cutoff_date = $(this).val();
	// 	console.log('时间输入已改变' + cutoff_date);

	// });

	// 回复数量上限
	$("input[name=\"max-responses\"]").click(function () {
		var max_responses = $(this).val();
		if (max_responses === "true") {
			$("#max-responses-input").show();
		} else {
			$("#max-responses-input").hide();
			$.ajax({
				url: app_url + '/collect/' + survey_id,
				type: 'POST',
				dataType: 'json',
				data: {
					max_responses: max_responses
				},
				success:function(data){
					if (data == true) {
						$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
					} else {
						alert("更新设置失败");
					};
				}
			});
		}
	});

	$("#max-response-count").change(function () {
		var max_responses = $(this).val();
		console.log('回复数量上限已改变：' + max_responses);
		$.ajax({
			url: app_url + '/collect/' + survey_id,
			type: 'POST',
			dataType: 'json',
			data: {
				max_responses: max_responses
			},
			success:function(data){
				if (data == true) {
					$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
				} else {
					alert("更新设置失败");
				};
			}
		});
	});

	// IP 限制
	$("input[name=\"ipaccess\"]").click(function () {
		var ipaccess = $(this).val();
		if (ipaccess === "blacklist") {
			$("#ip-b").show();
			$("#ip-w").hide();
		} else if (ipaccess === "whitelist") {
			$("#ip-w").show();
			$("#ip-b").hide();
		} else {
			$("#ip-b,#ip-w").hide();
			$.ajax({
				url: app_url + '/collect/' + survey_id,
				type: 'POST',
				dataType: 'json',
				data: {
					ipaccess: "false"
				},
				success:function(data){
					if (data == true) {
						$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
					} else {
						alert("更新设置失败");
					};
				}
			});
		}
	});

	$(".ip-list").change(function () {
		var ip_list = $(this).val();
		var ipaccess = $(this).prop("name");
		$.ajax({
			url: app_url + '/collect/' + survey_id,
			type: 'POST',
			dataType: 'json',
			data: {
				ipaccess: ipaccess,
				ip_list: ip_list
			},
			success:function(data){
				if (data == true) {
					$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
				} else {
					alert("更新设置失败");
				};
			}
		});

	});


	// 疗程式问卷设置
	$("input[name=\"course\"]").click(function () {
		var course = $(this).val();
		if (course === "true") {
			$("#treatment").show();
		} else {
			$("#treatment").hide();
			$.ajax({
				url: app_url + '/collect/' + survey_id,
				type: 'POST',
				dataType: 'json',
				data: {
					course: course
				},
				success:function(data){
					if (data == true) {
						$("#collect_up_info").show("slow").animate({opacity:"toggle"},2000);
					} else {
						alert("更新设置失败");
					};
				}
			});
		}
	});

	var total_days = 0;
	$("#total_days").change(function () {
		total_days = Number($(this).val());
		if ( /^\d+$/.test(total_days) && total_days>0 ) {
			alert(total_days);
		} else {
			total_days = 0;
		};
	});

	$("#frequency").change(function () {
		var frequency = Number($(this).val());
		if( /^\d+$/.test(frequency) && frequency<total_days && total_days>0 ) {
			alert(frequency);
		}
	});

	$("input[name=\"initial\"]").click(function () {
		var initial = $(this).val();
		if(initial === "custom"){
			$("#custom_time").show();
		} else {
			$("#custom_time").hide();
		}
	});

	$("#start_time").change(function() {
		var start_time = $(this).val();
		alert(start_time);
	});

});

/**
 * 字符类型的逻辑值转为数字真假值
 * @param  {String} val [description]
 * @return {Number}     [description]
 */
function val2num (val) {
	if(val === "true"){
		return 1;
	} else {
		return 0;
	}
}