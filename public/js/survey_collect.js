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
				// body...
			}
		});
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
	}else {
		return 0;
	}
}