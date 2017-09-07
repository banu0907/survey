/* 
 * 问卷设计制作辅助工具
 * 
 * banu@163.com
 */


var question_mark = "<div id=\"question-mark\"></div>";
var html_question_toolbar = "<div class=\"question-toolbar\">" +
    "<button class=\"btn btn-primary edit\" name=\"Edit\">编辑</button>" +
    "<button class=\"btn btn-default options\" name=\"Options\">选项</button>" +
    "<button class=\"btn btn-warning logic\" name=\"Logic\">逻辑</button>" +
    "<button class=\"btn btn-default move\" name=\"Move\">移动</button>" +
    "<button class=\"btn btn-default copy\" name=\"Copy\">复制</button>" +
    "<button class=\"btn btn-default delete\" name=\"Delete\">删除</button>" +
    "</div>";
// 当前问题编辑区域
var current_question;
var now_question = null;
var html_editQuestion = "<div id=\"editQuestion\">问题编辑区</div>";
// 编辑状态
var edit_status = "Edit";
// 页内弹出工具箱所属页（对象）
var popo_in_page;
// 问题条目前台展示区块
var question_surface;
// 前期设计临时调试用变量
var que_content;
// 网站应用根目录设置
if (typeof(app_url) === "undefined") {
    var app_url = "";
}

$(function() {

    // -------------------------
    //  Ajax状态显示
    // ------------------------
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ajaxStart(function() {
        $("#action-status-info").show();
    });
    $(document).ajaxStop(function() {
        $("#action-status-info").hide();
    });

    //===================================================================
    // 工具箱
    //-------------------------------------------------------------------

    // 选中缩略图
    var html_theme_selected = "<div class=\"label label-primary\" id=\"theme_selected\">" +
        "<i class=\"fa fa-check\"></span>" +
        "</div>";

    $("#theme_box .thumbnail").click(function() {
        $("#theme_selected").remove();
        $(this).append(html_theme_selected);
    });

    // 弹出工具提示

    $("#survey_create_body").webuiPopover({
        placement: "auto-right",
        container: "body",
        width: "20em",
        trigger: "hover",
        selector: ".fa-question-circle",
        closeable: true
    });

    $("#survey_toolbox .list-group-item a , #editSurveyTitle .fa-question-circle").webuiPopover({
        placement: "auto-right",
        container: "body",
        width: "20em",
        trigger: "hover",
        closeable: true
    });

    // 新增问题工具弹出框
    var popo_in_btn;
    $("#survey_workspace").on("click", ".addnew_question_box", function() {
        popo_in_btn = $(this);
        popo_in_page = $(this).parents(".survey-page");
        console.log("current page id: " + popo_in_page.attr("id"));
        $(this).webuiPopover({
            placement: 'auto-bottom',
            container: "body",
            trigger: "manual",
            cache: true,
            closeable: true,
            type: "async",
            url: "block_page_builder_tip.html"
        });
        $(this).webuiPopover("show");
    });


    //-------------------------------------------------------------------
    // 工具列浮动到固定位置
    //-------------------------------------------------------------------
    var windowHeight = $(window).height();
    $("#survey_toolbox .panel ul.list-group").css("max-height", windowHeight - 500);
    var st_fix_stat = 0; //工具列浮动状态，1为浮动。
    // 获取父级容器的宽度和左坐标
    var headHeight = $("body > div:nth-child(n-1)").height() + $("#head_toolbar").height() + 10;
    var pageID_in_win = $('.survey-page').eq(0).attr('id');
    $(window).scroll(function() {
        var toolbar_pos = $("#survey_toolbar").parent().offset();
        var toolbar_width = $("#survey_toolbar").width();
        if ($(this).scrollTop() > headHeight) {
            $("#survey_toolbar").addClass("toolbar_fix").css("width", toolbar_width).css("left", toolbar_pos.left + 15);
            st_fix_stat = 1;
            // 顶部浮动菜栏   
            $("#head_toolbar h2").show();
            $("#head_toolbar").addClass("head_toolbar_fix");
            $("#survey_toolbox .panel ul.list-group").css("max-height", windowHeight - 400);
        } else {
            $("#survey_toolbar").removeClass("toolbar_fix").css("width", "auto").css("left", "auto");
            st_fix_stat = 0;
            $("#head_toolbar h2").hide();
            $("#head_toolbar").removeClass("head_toolbar_fix");
            $("#survey_toolbox .panel ul.list-group").css("max-height", windowHeight - 500);
        }
        // ---------------------------------------------
        // 检测各页块在窗口内是否可视
        $(".survey-page").each(function(i, e) {
            pageID_in_win = $(this).attr('id');
            var pageBox = $(this).offset();
            // if (pageBox.top >= $(window).scrollTop() && pageBox.top < ($(window).scrollTop() + $(window).height())) {
            if (pageBox.top >= $(window).scrollTop() && pageBox.top < ($(window).scrollTop() + ($(window).height() / 3))) {
                // console.log('#' + pageID_in_win + ' 在可视范围');
                return false;
            }
        });
        // 突出显示当前页面块
        $("#" + pageID_in_win).children(".panel").css("box-shadow", "0px 2px 10px #7F007F");
        $("#" + pageID_in_win).siblings().children(".panel").css("box-shadow", "0px 2px 10px #000000");
    });

    // 通过鼠标位置来修正视口内可见页块
    $(".survey-page").hover(function() {
        pageID_in_win = $(this).prop("id");
        console.log('mouse in window: ' + pageID_in_win);
        // 突出显示当前页面块
        $(this).children(".panel").css("box-shadow", "0px 2px 10px #7F007F");
        $(this).siblings().children(".panel").css("box-shadow", "0px 2px 10px #000000");
    });

    // 考虑窗口大小改变因素
    $(window).resize(function() {
        var toolbar_pos = $("#survey_toolbar").parent().offset();
        var toolbar_width = $("#survey_toolbar").width();
        if (st_fix_stat === 1) {
            $("#survey_toolbar").css("width", toolbar_width).css("left", toolbar_pos.left);
        }
        windowHeight = $(window).height();
        $("#survey_toolbox .panel ul.list-group").css("max-height", windowHeight - 500);
    });


    /* ==================================================================
     *     页号、题号重新生成、重置
     *-------------------------------------------------------------------
     */
    pageNumReset();

    /**
     * 页号重置
     * @param  {[type]} save2db 是否存入后台数据库
     * @return {[type]}   [description]
     */
    function pageNumReset() {
        var save2db = arguments[0] ? arguments[0] : 1;
        var pageId = [];
        $(".survey-page").each(function(i, e) {
            // element == this
            var page_id = $(this).prop("id").match(/\d+/);
            pageId.push(page_id[0]);
            var page_num = i + 1;
            $(this).find(".pagePosition").text(page_num);
        });
        var pageIdList = pageId.join(',');
        if (save2db === 1) {
            $.ajax({
                type: "POST",
                url: app_url + "/surveypages/sort",
                data: {
                    "pageidlist": pageIdList
                },
                dataType: "json",
                success: function(response) {

                }
            });
        }
    }

    questionNumReset();

    /**
     * 题号重置 ， 同时传递问题id值序列给后台
     * @param  {[type]} save2db 是否存入后台数据库
     * @return {[type]}   [description]
     */
    function questionNumReset() {
        var save2db = arguments[0] ? arguments[0] : 1;
        var idSortNum = [];
        var page_num_at = [];
        $(".question-row").each(function(i, e) {
            // element == this
            var question_num = i + 1;
            $(this).find(".question-number").text(question_num);
            var question_id = $(this).prop("id");
            idSortNum.push(question_id);
            var page_id_at = $(this).parents(".survey-page").prop("id").match(/\d+/);
            var page_num = page_id_at[0];
            page_num_at.push(page_num);
        });
        var idSortList = idSortNum.join(',');
        var pageList = page_num_at.join(',');
        if (save2db === 1) {
            $.ajax({
                url: app_url + '/questions/sort',
                type: 'POST',
                dataType: 'json',
                data: {
                    idlist: idSortList,
                    pagelist: pageList
                },
            });
        }

    }

    //===================================================================
    // 问题预览状态下的操作
    //-------------------------------------------------------------------
    // 鼠标移过时加覆盖层（蒙板层），避免表单交互操作。同时加工具条
    $("#survey_workspace").on("mouseenter", ".question-row", function() {

        if ($(this).find("fieldset").length > 0) {

            $("#question-mark").remove();
            $(this).append(question_mark)
                .append(html_question_toolbar);
            $("#question-mark").css("height", $(this).height())
                .css("width", $(this).width());
        }

    }).on("mouseleave", ".question-row", function() {
        if ($(this).find("fieldset").length > 0) {
            $("#question-mark , .question-toolbar").remove();
            //            console.log("移除蒙板");
        } else {

        }
    });

    //------------------------------------------------------------------
    // 问题点击进入编辑状态
    //------------------------------------------------------------------
    // 点击问题蒙板
    $("#survey_workspace").on("click", "#question-mark", function() {
        //start_editQuestion($(this)); console.log("执行动作之最开始");
        //先判断有无尚未完成关闭的编辑区
        if ($("#question-Edit").length > 0) {
            // 将当前点击对象暂存在 now_question 
            now_question = $(this).parents(".question-row");
            // 调用保存功能，保存之前未关闭的问题区
            saveQuestion();
            // alert("之前问题尚未保存");
        } else {
            // 调入当前问题编辑区块
            now_question = null;
            current_question = $(this).parents(".question-row");
            var edit_qid = current_question.attr("id");
            console.log("点击编辑：" + edit_qid);
            load_editQuestion(edit_qid);

        }

        return false;
    });


    // function start_editQuestion(click_mark) { // }


    //-----------------------------------------------------------------
    // 问题工具条上的按钮添加行为
    $("#survey_workspace").on("click", ".question-toolbar button", function() {
        edit_status = $(this).attr("name");
        var edit_qid = $(this).parents(".question-row").attr("id");
        console.log("点击了编辑 " + edit_qid + " 按钮状态 " + edit_status);
        if (edit_status === "Delete") {
            delQuestion(edit_qid);
        } else {
            $("#" + edit_qid + " #question-mark").click();
        }
        return false;
    });



    //------------------------------------------------------------------
    /**
     * 调入问题编辑界面
     * 
     * @param {any} edit_qid  问题ID
     */
    function load_editQuestion(edit_qid) {
        console.log("进入编辑函数内 " + edit_qid);
        $("#action-status").text("准备编辑 问题ID：" + edit_qid + " ...");
        // var querow_num = $("#" + edit_qid + " .question-number").text();
        // var querow_body = $("#" + edit_qid + " .question-body").html();
        // var querow_title = $("#" + edit_qid + " h4>span:last").text();
        // var querow_class = $("#" + edit_qid).attr("data-question-class");
        $("#" + edit_qid + " fieldset").remove();
        $(" .question-toolbar , #question-mark").remove();
        $.ajax({
            type: "POST",
            url: app_url + "/questions/edit",
            data: {
                que_id: edit_qid,
            },
            success: function(q_data) {
                // html_editQuestion = q_data;
                $("#" + edit_qid).html(q_data).attr("draggable", "false");
                console.log("激活标签页 #question-" + edit_status);
                $("a[href=\"#question-" + edit_status + "\"]").click();
            },
            dataType: "html"
        });
    }


    //------------------------------------------------------------------
    // 点击保存按钮
    $("#survey_workspace").on("click", ".save", function() {
        // 调入保存操作
        current_question = $(this).parents(".question-row");
        saveQuestion();
        return false;
    });
    // 点击取消按钮（两种情况：1.新建的问题直接删除。2.已有问题调用原存储数据。）
    $("#survey_workspace").on("click", ".cancel", function() {
        cancelQuestion();
        return false;
    });

    // ---------------------------------------------------------
    /**
     *  保存问题操作
     * 
     * @returns 
     */
    function saveQuestion() {
        var save_qid = current_question.attr("id");
        console.log("进入保存函数：" + save_qid);
        $("#action-status").text("正在保存 问题ID：" + save_qid + " ...");
        var page_id = $("#" + save_qid).parents(".survey-page").prop('id');
        var page_id_num = page_id.match(/pageid-(\d+)/);
        var survey_page_id = page_id_num[1];
        var querow_title = $("#" + save_qid + " #editTitle").html();
        var querow_type = $("#" + save_qid).attr("data-question-class");
        // var querow_body = $("#" + save_qid + " #que_content").html();
        var querow = baler(querow_type);
        // current_question.html(question_surface);
        // 问题必答选项
        var querow_required;
        var editReqtext = "";
        if ($('#toggleReq').prop('checked')) {
            querow_required = 1;
            editReqtext = $("#editReqtext").val();
        } else {
            querow_required = 0;
        }
        // 问题答项随机排列选项
        var sortRadio = "";
        var editLast = 0;
        if ($("#editRand").prop("checked")) {
            sortRadio = $("input[name=\"sortRadio\"]:checked").val();
            if ($("#editLast").prop("checked")) {
                editLast = 1;
            };
        }

        // 根据 问题ID 判断是 新建 还是 修改
        if (/^\d+$/.test(save_qid)) {
            var pro_url = app_url + "/questions/update";
        } else {
            var pro_url = app_url + "/questions/store";
        };

        $.ajax({
            type: "POST",
            url: pro_url,
            data: {
                que_id: save_qid,
                survey_id: survey_id,
                survey_page_id: survey_page_id,
                que_type: querow_type,
                que_title: querow_title,
                que_body: querow['text'],
                que_req: querow_required,
                que_red_text: editReqtext,
                item_ran: sortRadio,
                item_last: editLast,
            },
            dataType: "html",
            success: function(q_data) {
                $("#" + save_qid).html(q_data);
                $("#" + save_qid).children('div').unwrap();
                questionNumReset(1);
                // 调入所点击问题区的编辑界面，如果有 now_question 的话
                if (now_question !== null) {
                    var edit_qid = now_question.attr("id");
                    current_question = now_question;
                    now_question = null;
                    load_editQuestion(edit_qid);
                }
            }
        });


        return false;
    }

    /**
     * 取消问题操作
     * 
     */
    function cancelQuestion() {
        var cancel_qid = $("#question-Edit").parents(".question-row").attr("id");
        console.log("编辑取消操作： " + cancel_qid);
        if (/^\d+$/.test(cancel_qid)) {

            $.ajax({
                type: "GET",
                url: app_url + "/questions/" + cancel_qid,
                dataType: "html",
                success: function(data) {
                    $("#" + cancel_qid).html(data);
                    $("#" + cancel_qid).children('div').unwrap();
                    questionNumReset(2);
                }
            });
        } else {
            $("#" + cancel_qid).remove();
            questionNumReset(2);
        };
    }

    /**
     * 校检问题
     * 
     */
    function verifQuestion() {

    }

    /**
     * 删除问题
     * 
     * @param {any} del_id 
     */
    function delQuestion(del_id) {
        $("#action-status").text("正在删除 问题ID：" + del_id + " ...");
        $.ajax({
            url: app_url + '/questions/destroy',
            type: 'POST',
            dataType: 'html',
            data: {
                id: del_id
            },
            success: function(d_data) {
                if (d_data) {
                    console.log("已删除" + del_id);
                    $("#" + del_id).remove();
                    $("#deletedQuestionBox ul").prepend(d_data);
                    $('#restoreQuestions .label-info').text(function(i, text) {
                        return Number(text) + 1;
                    });
                    questionNumReset(1);
                }
            }
        });

    }


    //    ----------------------------------------
    //  📃 页面操作
    // ------------------------------------------------
    var new_prev_page; //添加新页面的参照位置——前一页
    //添加新页面
    $("#survey_workspace").on("click", ".survey-page-new", function() {
        new_prev_page = $(this).parent();
        var cur_page_sort_num = $.trim(new_prev_page.find(".pageNumber .pagePosition").text());
        var page_sort_num = parseInt(cur_page_sort_num) + 1;
        addNewPage(page_sort_num);
    });

    /**
     * 新添问卷页面
     * 
     */
    function addNewPage(page_sort_num) {
        var result;
        $("#action-status").text("正在新建页面 ...");

        $.ajax({
            type: "POST",
            url: app_url + "/surveypages",
            data: {
                "survey_id": survey_id,
                "page_num": page_sort_num
            },
            success: function(p_data) {
                new_prev_page.after(p_data);
                pageLinkNav();
                pageNumReset();
            },
            dataType: "html"
        });
    }



    //===================================================================
    //   👆🔧   问题工具拖放建立 
    // -------------------------------------------------------------
    var qdi = document.getElementById("q_drag_icon");
    $("#bqc li").on("dragstart", function(e) {
        var qdi_icon = $(this).children("a").html();
        //        console.log(typeof (qdi_icon ));
        qdi_icon = qdi_icon.replace(/<button.*/gm, "");
        console.log(qdi_icon);
        $("#q_drag_icon").html(qdi_icon);
        var q_name = $(this).children("a").attr("class");
        console.log("开始拖工具控件：" + q_name);
        e.originalEvent.dataTransfer.setData("text/plain", q_name);
        e.originalEvent.dataTransfer.setDragImage(qdi, 150, 50);
        //        e.originalEvent.dataTransfer.setDragImage(document.getElementById("q_drag_icon"), 50, 50);
    });

    // ---------------------------  问题拖动排序位置  ---------------------------------
    $("#survey_workspace").on("dragstart", ".question-row", function(e) {
        console.log("开始拖问题块" + $(this).attr("id"));
        // 先判断有无ID，如无，则加上
        var qr_id_name = Math.ceil(Math.random() * 100000);
        if ($(this).attr("id") === undefined) {
            $(this).attr("id", qr_id_name);
        } else {
            qr_id_name = $(this).attr("id");
        }
        console.log("开始拖问题：" + qr_id_name);
        e.originalEvent.dataTransfer.setData("text/plain", qr_id_name);
    });


    var ins_pos_pre = "\n<li class=\"ins_pos_pre_box\">插入位置预览</li>\n";
    //问题区块前面加入预览后位移标志
    var v_cut_move_tag = 0;
    $("#survey_workspace").on("dragover", ".question-row", function(e) {
        e.originalEvent.preventDefault();
        //        var d = $(this).html();
        //        console.log(d);
        // 计算鼠标坐标与放位目标的距离和方向
        var mouse_y = e.pageY;
        var qr_pos_y = $(this).offset();
        var qr_height = $(this).outerHeight();
        var v_cut = qr_pos_y.top + qr_height / 2;
        //        console.log("上边：" + qr_pos_y.top + " 高：" + qr_height + " 放置分界点：" + v_cut + " mouse_Y:" + mouse_y);
        if (v_cut_move_tag === 1) {
            v_cut = +$(".ins_pos_pre_box").outerHeight();
        }
        if ($(".ins_pos_pre_box").length === 0) {
            if (mouse_y > v_cut) {
                $(this).after(ins_pos_pre);
            } else {
                $(this).before(ins_pos_pre);
                v_cut_move_tag = 1;
            }
        }
    }).on("dragleave", function(e) {
        e.originalEvent.preventDefault();
        $(".ins_pos_pre_box").remove();
        v_cut_move_tag = 0;
    });;

    // $("#survey_workspace").on("dragenter", ".question-row", function (e) {
    //     e.originalEvent.preventDefault();
    // });

    //  💣 DROP 鼠标放置
    $("#survey_workspace").on("drop", ".survey-page-body", function(e) {
        // e.originalEvent.preventDefault();
        // e.originalEvent.stopPropagation();
        var q_name = e.originalEvent.dataTransfer.getData("text/plain");
        console.info("新建问题类型：" + q_name);

        // --------------------------------------------------------
        // 👩 放置新建问题
        if (/^[a-z]+$/.test(q_name)) {
            var que_temp_id = "create_" + Math.ceil(Math.random() * 100000);
            $.ajax({
                type: "POST",
                url: app_url + "/questions/create",
                data: {
                    "que_id": que_temp_id,
                    "que_class": q_name
                },
                dataType: "html",
                success: function(n_data) {
                    console.log("call sun page");
                    $(".ins_pos_pre_box").html(n_data);
                    $("#" + que_temp_id).unwrap();
                    questionNumReset(2);
                }
            });

            // --------------------------------------------------------
            // 👧 放置移动问题
        } else if (/^\d+$/.test(q_name)) {
            if ($(this).attr("id") !== q_name) {
                //                console.log("移动完成操作");
                $("#" + q_name).insertAfter(".ins_pos_pre_box");
                $(".ins_pos_pre_box").remove();
            } else {
                $(".ins_pos_pre_box").remove();
            }
            questionNumReset(1);

            // --------------------------------------------------------
            // 👸 放置还原已删除问题
        } else if (/^deleted-\d+$/.test(q_name)) {
            console.log("拖放还原操作： " + q_name);
            var deleteID = q_name.match(/\d+/g)[0];

            $.ajax({
                type: "POST",
                url: app_url + "/questions/undel",
                data: {
                    id: deleteID
                },
                dataType: "html",
                success: function(data) {
                    $(".ins_pos_pre_box").html(data);
                    $("#" + deleteID).unwrap();
                    $("#deleted-" + deleteID).remove();
                    $('#restoreQuestions .label-info').text(function(i, text) {
                        return Number(text) - 1;
                    });
                    questionNumReset(1);
                }
            });

        }

        // e.originalEvent.dataTransfer.clearData("text/plain");
        e.originalEvent.preventDefault();
        e.originalEvent.stopPropagation();
    });

    // -------------------------     在空页中放入问题控件     ---------------------
    $("#survey_workspace").on("dragover", ".survey-page-body", function(e) {
        e.originalEvent.preventDefault();
        if ($(this).find(".question-row").length < 1) {
            if ($(".ins_pos_pre_box").length < 1) {
                var qr_id_name = "create_" + Math.ceil(Math.random() * 100000);
                $(this).append(ins_pos_pre);
            }
        }
    }).on("dragleave", function(e) {
        e.originalEvent.preventDefault();
        $(".ins_pos_pre_box").remove();

    });

    // =================================================================
    //    🥁  问题控件单击建立
    // -----------------------------------------------------------------
    $("#bqc li").click(function() {
        var que_class = $(this).children("a").attr("class");
        console.log("点击了 " + que_class);
        // 检测当前可见页块，计算可视区内的百分比
        console.log("当前可见页块: " + pageID_in_win);
        // 新建问题
        var que_temp_id = "create_" + Math.ceil(Math.random() * 100000);
        $.ajax({
            type: "POST",
            url: app_url + "/questions/create",
            data: {
                "que_id": que_temp_id,
                "que_class": que_class
            },
            dataType: "html",
            success: function(n_data) {
                $("#" + pageID_in_win + " .survey-page-body").append(n_data);
                questionNumReset(2);
                ScrollToDiv(que_temp_id);
            }
        });
        return false;
    });

    $("body").on("click", ".page_builder_tip li", function() {
        var que_class = $(this).children("a").attr("class");
        console.log("点击了 " + que_class);
        // var page_obj = $(this).parents(".survey-page");
        console.log("所属页 " + popo_in_page.attr("id"));
        // 关闭页内弹出工具栏菜单
        popo_in_btn.webuiPopover("hide");
        // 新建问题
        var que_temp_id = Math.ceil(Math.random() * 100000);
        $.ajax({
            type: "POST",
            url: "./ajax/question_edit.php",
            data: {
                "que_id": que_temp_id,
                "que_class": que_class
            },
            dataType: "json",
            success: function(n_data) {
                popo_in_page.find(".survey-page-body").append(n_data.html);
                questionNumReset();
            }
        });
        return false;
    });

    $("#survey_workspace").on("click", ".question-body-new button", function() {
        console.log("new que btn");
        var btn_in_page = $(this).parents(".survey-page");
        // 新建问题
        var que_temp_id = "create_" + Math.ceil(Math.random() * 100000);
        $.ajax({
            type: "POST",
            url: app_url + "/questions/create",
            data: {
                "que_id": que_temp_id,
                "que_class": "qmc"
            },
            dataType: "html",
            success: function(n_data) {
                btn_in_page.find(".survey-page-body").append(n_data);
                questionNumReset(2);
            }
        });
        return false;
    });

    // -------------------------------------------------------
    //   回收站：还原删除问题操作
    //--------------------------------------------------------
    $("#deletedQuestions").click(function() {
        if ($("#deletedQuestionList").is(":hidden")) {
            var delquelistHeight = $("#survey_toolbox").height();
            $("#deletedQuestionList").height(delquelistHeight).show();
            $("#restoreQuestions").addClass("restore");
        } else {
            $("#deletedQuestionList").hide();
            $("#restoreQuestions").removeClass("restore");
        }
    });
    // 关闭回收站按钮
    $("#deletedQuestionList h4 i[class*=\"fa-remove\"]").click(function() {
        $("#deletedQuestionList").hide();
        $("#restoreQuestions").removeClass("restore");
    });
    // 拖放还原问题开始
    $("#deletedQuestionList").on("dragstart", "li", function(e) {
        var deleteID = $(this).prop("id");
        $("#q_drag_icon").html("已删除的问题");
        e.originalEvent.dataTransfer.setDragImage(qdi, 150, 50);
        console.log("undel: " + deleteID);
        e.originalEvent.dataTransfer.setData("text/plain", deleteID);
    });

    // 单击还原删除问题
    $("#deletedQuestionList").on("click", "li", function(e) {
        var deleteID = $(this).prop("id");
        var renewID = deleteID.match(/\d+/)[0];
        $.ajax({
            url: app_url + '/questions/undel',
            type: 'POST',
            dataType: 'html',
            data: { id: renewID },
            success: function(data) {
                $("#" + pageID_in_win + " .survey-page-body").append(data);
                $('#restoreQuestions .label-info').text(function(i, text) {
                    return Number(text) - 1;
                });
                $("#" + deleteID).remove();
                questionNumReset(1);
                ScrollToDiv(renewID);
            }
        });

    });

    // =============================================================
    //  📄  页面逻辑 
    // ------------------------------------------------------------
    $("#survey_workspace").on("click", ".menu-logic li", function() {
        var mli = $(this).index();
        var logic_in_pageID = $(this).parents(".survey-page").attr("id");
        var logic_pageID = logic_in_pageID.match(/\d+/)[0];

        // 清空上次生成的选项列表
        $("#pageSkipTarget option").each(function(i) {
            var page_link = $(this).val();
            if (/^\d+$/.test(page_link)) {
                $(this).remove();
            }
        });
        // #pageSkipTarget 选择页码选项生成
        var pageLinkList = "";
        var pageRandomList = "";
        $(".survey-page").each(function(i) {
            var p_i = i + 1;
            var p_link = $(this).prop("id").match(/\d+/)[0];
            if (p_link !== logic_pageID) {
                pageLinkList += "<option value = \"" + p_link + "\"";
                pageLinkList += ">第" + p_i + "页</option>\n";
            }
            var page_title = $(this).find("h2>span").text();
            // 随机选取问题列表
            pageRandomList += "<label>";
            pageRandomList += "<input type=\"checkbox\" name=\"randomizePage\" id=\"pageRandomOption-" + p_link + "\" value=\"" + p_link + "\">";
            pageRandomList += " 页" + p_i;
            if (page_title !== "+ 新增页面标题") {
                pageRandomList += "：" + page_title;
            }
            pageRandomList += "</label>\n";
        });

        $("#pageSkipTarget option[value=\"description\"]").after(pageLinkList);
        $("#pageRandomList").html(pageRandomList);
        var page_pos = $("#" + logic_in_pageID).find(".pagePosition").eq(0).text();
        $("#questionsAffectedAll + .notranslate").text(page_pos);

        // ajax读取页面信息 ， 同时设置初始选项
        $.ajax({
            type: "GET",
            url: app_url + "/surveypages/" + logic_pageID + "/edit",
            dataType: "json",
            success: function(data) {
                // console.log(data);
                console.log("id: " + data.surveypage.id);
                var page_logic = data.surveypage.page_logic;
                var question_random = data.surveypage.question_random;
                var page_random = data.surveypage.page_random;
                if (page_logic) {
                    $("#pageSkipTarget").val(page_logic);
                };
                if (question_random) {
                    // $("input[name=\"questionRandom\"]").val(question_random);
                };
                if (page_random) {
                    // $("input[pageRandom]").val(page_random);
                };

            }
        });

        // 选取问题列表
        var questionRandomList = "";
        $("#" + logic_in_pageID + " .question-row").each(function(i) {
            var que_id = $(this).prop("id");
            var que_pos = $(this).find(".question-number").text();
            var que_title = $(this).find("h4>span:last").text();
            questionRandomList += "<label>";
            questionRandomList += "<input type=\"checkbox\" name=\"randomizeQuestion\" id=\"randomizeQuestion_" + que_id + "\" value=\"" + que_id + "\">";
            questionRandomList += " 问题" + que_pos + ". " + que_title;
            questionRandomList += "</label>";
        });
        $("#questionRandomList").html(questionRandomList);

        console.log("显示页面逻辑面板 " + logic_in_pageID);
        $("#pageLogicContainer").insertAfter("#" + logic_in_pageID + " .pageControls").show();
        $("#pageLogicContainer .nav-tabs li a").eq(mli).click();
        // return false;
    });

    // 问题随机出现子选项显示
    $("input[name=\"questionRandom\"]").click(function() {
        // console.log($("input[name=\"questionRandom\"]:checked").val());
        if ($(this).val() === "none") {
            $("#questionsAffectedControls").hide();
        } else {
            $("#questionsAffectedControls").show();
        }
    });

    $("#questionsAffectedAll").click(function() {
        $("#questionRandomList").hide();
    });
    $("#questionsAffectedList").click(function() {
        $("#questionRandomList").show();
    });

    // 随意显示页面选项显示
    $("input[name=\"pageRandom\"]").click(function() {
        if ($(this).val() === "none") {
            $("#pagesAffectedControls").hide();
        } else {
            $("#pagesAffectedControls").show();
        };
    });

    $("#pagesAffectedAll").click(function() {
        $("#pageRandomList").hide();
    });
    $("#pagesAffectedList").click(function() {
        $("#pageRandomList").show();
    });


    // 保存选项
    $("#plc-btn-apply").click(function() {
        var logic_pageID = $(this).parents(".survey-page").attr("id").match(/\d+/)[0];
        var pageSkipTarget = $("#pageSkipTarget").val();
        var questionRandom = $("input[name=\"questionRandom\"]:checked").val();
        var pageRandom = $("input[name=\"pageRandom\"]:checked").val();
        // console.log(pageSkipTarget + " " + questionRandom + " " + pageRandom);
        $.ajax({
            type: "POST",
            url: app_url + "/surveypages/" + logic_pageID,
            data: {
                _method: "PUT",
                page_logic: pageSkipTarget,
                questionRandom: questionRandom,
                pageRandom: pageRandom
            },
            dataType: "json",
            success: function(l_data) {
                if (l_data === true) {
                    console.log(l_data);
                    $("#pageLogicContainer").hide();
                }
            }
        });
    });
    // 取消
    $("#plc-btn-cancel").click(function() {
        $("#pageLogicContainer").hide();
    });


    // ------------------------------------------------------------
    //  📄 页面其他操作
    // ------------------------------------------------------------
    var more_action;
    var more_in_pageID;
    var more_in_pageNUM;
    $("#survey_workspace").on("click", ".menu-more_actions li", function() {
        more_in_pageID = $(this).parents(".survey-page").attr("id");
        console.log("显示其他页面操作面板 ID： " + more_in_pageID);
        more_action = $(this).attr("class");
        more_in_pageNUM = $(".survey-page").index($("#" + more_in_pageID)) + 1;
        $("#pagePosition").text(more_in_pageNUM);
        // #pageAction_pageList 页面列表生成
        var pageLinkList = "";
        $(".survey-page").each(function(i) {
            var p_i = i + 1;
            var p_link = $(this).prop("id");
            pageLinkList += "<option value = \"" + p_link + "\"";
            if (p_link === more_in_pageID) {
                pageLinkList += " selected=\"selected\" ";
            }
            pageLinkList += ">第" + p_i + "页</option>\n";
        });
        $(".copyPage #pageAction_pageList , .movePage #pageAction_pageList").html(pageLinkList);

        // ----------------------------------------------------
        // ٩(●˙▿˙●)۶…⋆ฺ 复制页面
        if (more_action === "copy_page") {
            $("#pageActionContainer").insertAfter("#" + more_in_pageID + " .pageControls")
                .show();
            $("#pageActionContainer .copyPage").show().siblings("span,div").hide();
        }

        // ----------------------------------------------------
        // (ᵒ̴̶̷ωᵒ̴̶̷*•ू)​)੭ु⁾ 移动页面
        if (more_action === "move_page") {
            $("#pageActionContainer").insertAfter("#" + more_in_pageID + " .pageControls")
                .show();
            $("#pageActionContainer .movePage").show().siblings("span,div").hide();

        }

        // ----------------------------------------------------
        // 💁 编辑页面资讯
        if (more_action === "edit_page") {
            $("#" + more_in_pageID + " h2").click();
        }

        // ----------------------------------------------------
        // 💇 要编辑问题
        if (more_action === "require_qs") {

        }

        // ----------------------------------------------------
        // 🙆 删除页面
        if (more_action === "delete_page") {

            $("#pageActionContainer").insertAfter("#" + more_in_pageID + " .pageControls")
                .show();
            $("#pageActionContainer .deletePage").show().siblings("span,div").hide();
            if ($("#" + more_in_pageID).prev().length < 1) {
                $("#pageActionContainer .deletePage label:nth-child(2)").hide();
            };
            if ($("#" + more_in_pageID).next().length < 1) {
                $("#pageActionContainer .deletePage label:nth-child(3)").hide();
            };
        }

    });

    $("#pac-btn-apply").click(function() {
        var pageID_src = $(this).parents(".survey-page").prop("id");
        var pageNum_src = pageID_src.match(/\d+/)[0];
        var pageNum_tar; // 目的地问题ID
        var queMvId = [];
        $("#" + pageID_src + " .question-row").each(function(i, querow) {
            queMvId.push($(this).prop('id'));
        });
        var queMvIdList = queMvId.join(',');
        console.log("影响问题的Id列表: " + queMvIdList);
        // ----------------------------------------------------
        // 🙅 复制页面  
        if (more_action === "copy_page") {
            var pageAction_pageList = $("#pageActionContainer  .panel-body > .copyPage > #pageAction_pageList").val();
            var pageAction_relativePos = $("#pageActionContainer  .panel-body > .copyPage > #pageAction_relativePos").val();
            $.ajax({
                type: "POST",
                url: "./ajax/page_create.php",
                data: {
                    pageNum_src: pageNum_src
                },
                dataType: "json",
                success: function(data) {
                    if (pageAction_relativePos === "after") {
                        $("#" + pageAction_pageList).after(data.html);
                    } else if (pageAction_relativePos === "before") {
                        $("#" + pageAction_pageList).before(data.html);
                    }
                    $("#pageActionContainer").hide();
                    pageNumReset();
                }
            });
        }

        // ----------------------------------------------------
        // 🤦 移动页面        
        if (more_action === "move_page") {
            var pageAction_pageList = $("#pageActionContainer  .panel-body > .movePage > #pageAction_pageList").val();
            var pageAction_relativePos = $("#pageActionContainer  .panel-body > .movePage > #pageAction_relativePos").val();

            if (pageAction_relativePos === "after") {
                $("#" + pageID_src).insertAfter("#" + pageAction_pageList);
            } else if (pageAction_relativePos === "before") {
                $("#" + pageID_src).insertBefore("#" + pageAction_pageList);
            }
            $("#pageActionContainer").hide();
            pageNumReset();
        }

        // ----------------------------------------------------
        // 🙆 删除页面      
        if (more_action === "delete_page") {
            var deletePageQuestions = $("input[name=\"deletePageQuestions\"]:checked").val();
            $("#pageActionContainer").hide();
            // 防止操作面板被删
            $("#pageLogicContainer , #pageActionContainer").insertAfter("#footer");
            if (deletePageQuestions === "delete") {
                $("#" + pageID_src + " .question-row").remove();
            } else if (deletePageQuestions === "before") {
                var page_before = $("#" + pageID_src).prev().prop("id");
                pageNum_tar = page_before.match(/\d+/)[0];
                $("#" + pageID_src + " .question-row").appendTo("#" + page_before + " .survey-page-body");
            } else if (deletePageQuestions === "after") {
                var page_after = $("#" + pageID_src).next().prop("id");
                pageNum_tar = page_after.match(/\d+/)[0];
                $("#" + pageID_src + " .question-row").appendTo("#" + page_after + " .survey-page-body");
            }
            questionNumReset();
            $("#" + pageID_src).remove();
            pageNumReset();
            $.ajax({
                type: "POST",
                url: app_url + "/surveypages/" + pageNum_src,
                data: {
                    "_method": "DELETE",
                    "delpageque": deletePageQuestions
                },
                dataType: "html",
                success: function(htmldata) {
                    $("#deletedQuestionBox").prepend(htmldata);
                }
            });
        }

        console.log("pageAction_pageList: " + pageAction_pageList + "\n pageAction_relativePos: " + pageAction_relativePos + "\n deletePageQuestions: " + deletePageQuestions);

        // 保存页面顺序和问题顺序
        //...
        pageActionReset();
        pageLinkNav();
    });

    $("#pac-btn-cancel").click(function() {
        $("#pageActionContainer").hide();
        pageActionReset();
    });

    /**
     *  页面操作选项复位
     * 
     */
    function pageActionReset() {
        $("#pageActionContainer  .panel-body > .copyPage > #pageAction_pageList").val(more_in_pageNUM);
        $("#pageActionContainer  .panel-body > .copyPage > #pageAction_relativePos").val("after");
        $("#pageActionContainer  .panel-body > .movePage > #pageAction_pageList").val(more_in_pageNUM);
        $("#pageActionContainer  .panel-body > .movePage > #pageAction_relativePos").val("after");
        $("#pageActionContainer .deletePage label").show();
        $("input[name=\"deletePageQuestions\"][value=\"delete\"]").prop("checked", "checked");

    }


    // ===================================
    // 编辑问卷标题
    // -----------------------------------
    $("body").on("click", ".survey_title , .survey-page-head", function() {
        var surveyTitle = $(".survey_title").eq(0).text();
        surveyTitle = $.trim(surveyTitle);
        $("#surveyTitle").val(surveyTitle);
        var current_surveyTitleAlignment = $(".survey-page-head h1").attr("class");
        if (current_surveyTitleAlignment === "text-center") {
            $("#surveyTitleAlignment option[value=\"center\"]").attr("selected", true);
        } else {
            $("#surveyTitleAlignment option[value=\"left\"]").attr("selected", true);
        }
        $("#modal-survey-title").modal("show");
    });

    $("#save-survey-title").click(function() {
        var surveyTitle = $("#surveyTitle").val();
        var surveyTitleAlignment = $("#surveyTitleAlignment").val();
        console.log("surveyTitle: " + surveyTitle + " surveyTitleAlignment: " + surveyTitleAlignment);

        $.ajax({
            type: "POST",
            url: app_url + "/surveys/" + survey_id,
            data: {
                _method: "PUT",
                surveyTitle: surveyTitle,
                surveyTitleAlignment: surveyTitleAlignment
            },
            dataType: "json",
            success: function(data) {
                if (data === true) {
                    $(".survey-page-head h1").removeClass();
                    if (surveyTitleAlignment === "center") {
                        $(".survey-page-head h1").addClass("text-center");
                    }
                    $(".survey_title h2 , .survey-page-head h1").html(surveyTitle);
                    $("#modal-survey-title").modal("hide");
                }
            }
        });

    });

    // ---------------------------------------------
    // 编辑页面标题和描述
    var current_page;
    $("#survey_workspace").on("click", "h2,h3", function() {
        current_page = $(this).parents(".survey-page");
        var pageTitle = current_page.find("h2>span").html();
        // pageTitle = $.trim(pageTitle.replace(/<button.*/gm, ""));
        if (/^\+/.test(pageTitle)) {
            pageTitle = "";
        }
        var pageSubtitle = current_page.find("h3>span").html();
        // pageSubtitle = $.trim(pageSubtitle.replace(/<button.*/gm, ""));
        $("#pageTitle").val(pageTitle);
        $("#pageSubtitle").html(pageSubtitle);

        $("#modal-page-title").modal("show");
    });
    $("#save-page-title").click(function() {
        var current_pageID = current_page.attr("id").match(/\d+/)[0];
        var pageTitle = $("#pageTitle").val();
        var pageSubtitle = $("#pageSubtitle").html();
        console.log("pageTitle: " + pageTitle + " pageSubtitle: " + pageSubtitle);
        $.ajax({
            type: "POST",
            url: app_url + "/surveypages/" + current_pageID,
            data: {
                _method: "PUT",
                page_title: pageTitle,
                page_description: pageSubtitle
            },
            dataType: "json",
            success: function(data) {
                if (data === true) {
                    current_page.find("h2>span").html(pageTitle);
                    current_page.find("h3>span").html(pageSubtitle);
                    $("#modal-page-title").modal("hide");
                    pageLinkNav();
                }
            }
        });
    });

    // ===================================
    //  页号导航和页面跳转
    // ----------------------------------
    pageLinkNav();

    /**
     * 页码导航页码动态生成
     * 
     */
    function pageLinkNav() {
        var pageLinkList = "";
        $(".page-list-menu").html("");
        $(".survey-page").each(function(i) {
            // console.log(i);
            // console.log($(this).prop("id"));
            var h = i + 1;
            $(this).find(".pagePosition").text(h);
            pageLinkList += "<li><a data-action=\"" + $(this).prop("id") + "\">第" + h + "页";
            var page_title = $(this).find("h2>span").text();
            if (/^\s*[^\+]/.test(page_title)) {
                pageLinkList += ": " + page_title;
            }
            pageLinkList += "</a></li>\n";

        });
        console.log(pageLinkList);
        $(".page-list-menu").html(pageLinkList);
        // 上下页按钮状态
        $(".menu-previous , .menu-next").attr("disabled", false);
        $(".menu-previous:first , .menu-next:last").attr("disabled", true);
    }

    // 跳页
    $("#survey_workspace").on("click", ".page-list-menu>li", function() {
        var page_go = $(this).children("a").attr("data-action");
        console.log(page_go);
        ScrollToDiv(page_go);
    });
    // 上一页
    $("#survey_workspace").on("click", ".menu-previous", function() {
        var page_pre = $(this).parents(".survey-page").prev().prop("id");
        if (page_pre !== undefined) {
            ScrollToDiv(page_pre);
        }
    });
    // 下一页
    $("#survey_workspace").on("click", ".menu-next", function() {
        var page_next = $(this).parents(".survey-page").next().prop("id");
        if (page_next !== undefined) {
            ScrollToDiv(page_next);
        }
    });

    /**
     *  页面滚动到指定DIV
     * 
     * @param {String} id 页面元素ID
     */
    function ScrollToDiv(id) {
        $("html,body").stop(true);
        $("html,body").animate({
            scrollTop: $("#" + id).offset().top
        }, 1000);
    }

    /* ==================================================
     *  标志上传、编辑、删除
     * ---------------------------------------------------
     */
    $("#survey_workspace").on("click", ".addLogohere", function() {
        $("#modal-addImageDialog").modal("show");
    })

    $("#save-top-logo").click(function() {
        // body
        $(".top-logo-section").show();
        $("#modal-addImageDialog").modal("hide");
    });

    $("#survey_workspace").on("click", ".removeLogo", function() {
        // body
        $(".top-logo-section").hide();
    });
    $("#survey_workspace").on("click", ".editLogo", function() {
        // body
        $("a[href=\"#collapseFour\"]").click();
        $("#logoMasterToggle").click();
    });

    /*
     * 问卷页脚导航用户设置
     */
    $("#survey_workspace").on("click", ".survey-page-submit", function() {
        console.log('问卷页脚导航用户设置');
    });

    /*
     * 页脚注隐藏设置
     */
    $("#survey_workspace").on("click", ".survey-footer", function() {
        console.log("隐藏脚注");
    })


    // =================================================================================
    //      问题和答案子项编辑操作
    // ---------------------------------------------------------------------------------
    // 增加选项
    $("#survey_workspace").on("click", "tr .add", function() {
        var curren_th = $(this).parents("tr");
        curren_th.clone().insertAfter(curren_th).find(".input").html("");
        return false;
    });

    // 删除选项
    $("#survey_workspace").on("click", "tr .delete", function() {
        $(this).parents("tr").remove();
        return false;
    });

    // ====================================================================
    // 问题类型切换
    $("#survey_workspace").on("click", "#change-type li>a", function() {
        console.log($(this).text());
        // # code...
        return false;
    });

    // ----------------------------------
    // 问题编辑界面
    // --------------
    // 矩阵评分表 qmx

    $("#survey_workspace").on("click", "#editNA", function() {
        if ($(this).prop("checked") === true) {
            $("#editNALabel").removeClass('hide');
        } else {
            $("#editNALabel").addClass("hide");
        }
    });

    $("#survey_workspace").on("click", "#editWeighted", function() {
        if ($(this).prop("checked") === true) {
            $(".weightValue").show();
        } else {
            $(".weightValue").hide();
        };
    });

});


// ====================================================================
// 
/**
 * 问题输入数据分组打包输出，便于Ajax提交
 * @param  {string} question_type [问题类型]
 * @return {array} exportData    [输出数组]
 */
function baler(question_type) {
    var inputText = []; // 问题条目数组
    var inputText2 = [];
    var inputLogic = []; // 逻辑数组
    var inputOption = []; // 选项数组
    var exportData = []; // 本函数输出数组
    var outText;
    var outOption;
    var outLogic;

    /* --------------------------
     *   单选、多选
     */
    if (question_type === 'qmc') {
        $("#question-Edit tbody .input").each(function() {
            inputText.push($.trim($(this).html()));
        });
        outText = inputText.join('¶');
        if ($("#question-Edit #mcq").prop('checked')) {
            outText += '§mcp';
        }
    }
    /* ----------------------------
     *   距阵评分表
     */
    if (question_type === "qmx") {
        // 计算“行”
        var row = [];
        var rows;
        if ($("#switchToSRRS").prop("checked") === false) {
            $("#rows .choiceText").each(function() {
                row.push($.trim($(this).children(".input").html()));
            });
            rows = row.join("¶");
        }
        // 计算列
        var col = [];
        var cols;
        $(".column").each(function() {
            var choiceText = $(this).find(".choiceText .input").html();
            var weightValue = $(this).find(".weightValue input").val();
            col.push($.trim(choiceText) + "¦" + weightValue);
        });
        cols = col.join("¶");
        // 附加选项
        var exopt = [];
        if( $("#switchToSRRS").prop("checked") ){
            exopt.push("switchToSRRS");
        }
        if ($("#toggleMultipleChoice").prop("checked") === true) {
            exopt.push("multipleChoice");
        }
        if ($("#editWeighted").prop("checked")) {
            exopt.push("editWeighted");
        }
        if ($("#editNA").prop("checked")) {
            var editNALabel = $("#editNALabel").html();
            exopt.push("editNA¦" + editNALabel);
        }
        if ($("#editForcedRanking").prop("checked")) {
            exopt.push("editForcedRanking");
        }
        if ($("#toggleOtherField").prop("checked")) {
            var otherAmount = $("input[name=\"otherAmount\"]:checked").val();
            var otherLabel = $("#otherLabel").html();
            exopt.push("otherField¦" + otherAmount + "¦" + otherLabel);
        }
        var exopts = exopt.join("¶");
        outText = "[row]" + rows + "§" + "[col]" + cols + "§" + exopts;
    };

    // ------------------------------------------------
    // 选项标签页
    if ($('#toggleReq').prop('checked')) {
        inputOption.push("required");
    }
    outOption = inputOption.join('|');

    // -------------------------------------------
    // 逻辑标签页

    exportData['text'] = outText;
    exportData['option'] = outOption;
    exportData['logic'] = outLogic;
    return exportData;
}