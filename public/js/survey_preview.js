$(function() {
    //	点击表格单元格选中选项
    $("td").click(function() {
        $(this).children("input[type=\"radio\"],input[type=\"checkbox\"]").prop("checked",function (i,checkval) {
        	return !checkval;
        });
    });
    $(".checkbox").click(function() {
        $(this).find("label>input[type=\"radio\"],label>input[type=\"checkbox\"]").prop("checked", function (i,checkval) {
        	return !checkval;
        });
    });
    //	给导航按钮加上链接
    $(".next-button").click(function() {
        console.log("点击了下一页");
        $(this).parents(".survey-page").next().show().siblings().hide();
        $(window).scrollTop(0);
    });

    $(".prev-button").click(function() {
        $(this).parents(".survey-page").prev().show().siblings().hide();
        $(window).scrollTop(0);
    });

    $(".done-button").click(function() {
        $("#survey_box").hide();
        $("#endPreview").show();
    });

    $("#resetSurvey").click(function() {
        $("#endPreview").hide();
        $("#survey_box,.survey-page:first-child").show();

        $(".survey-page:nth-child(n+2)").hide();
        $(window).scrollTop(0);
    });

    $("#closePreview").click(function() {
        $("#preview_window", window.parent.document).hide();
    });
});