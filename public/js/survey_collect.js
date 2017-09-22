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

	// 多次回覆
	$("input[name=\"allow_multiple_responses\"]").click(function () {
		var allow_multiple_responses = val2num($(this).val()) ;
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
		var instant_results = val2num($(this).val());
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
		var cutoff_date = val2num($(this).val());
		if(cutoff_date){
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
					cutoff_date: cutoff_date
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

	$("#cutoff_datepicker").change(function () {
		var cutoff_date = $(this).val();
		console.log('时间输入已改变' + cutoff_date);

	});

	// 回复数量上限
	$("input[name=\"max-responses\"]").click(function () {
		var max_responses = val2num( $(this).val() );
		if (max_responses) {
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
	});

	// IP 限制
	$("input[name=\"ipaccess\"]").click(function () {
		var ipaccess = $(this).val();
		
	});



});

/**
 * 字符类型的逻辑值转为数字
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