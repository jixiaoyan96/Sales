$(function() {
    //banner下方图片悬浮切换
    $("#fault_list").find(".pic").children("img").hover(function() {
        var pic_hover = $(this).attr("data-hover");
        $(this).attr("src", pic_hover);
    }, function() {
        var pic_out = $(this).attr("data-out");
        $(this).attr("src", pic_out);
    })
    var arrow_top = 0;
    $("#cate-list-main").children("li").hover(function() {
        $(this).addClass("hover").siblings("li").removeClass("hover");
        $("#cate-list-sub").show();
        var index = $(this).index();
        $("#cate-list-sub-inner").children(".sub-item").hide();
        $("#cate-list-sub-inner").children(".sub-item").eq(index).show();
        $("#cate-list-sub").css({"width": "700px"})
        $("body").attr("is_hover", 1);

        arrow_top = 36 + 85 * index;
        $(".arrow-left").css({"top": arrow_top})
    }, function() {
        $("body").attr("is_hover", 0);
    })
    $("#cate-list-sub").hover(function() {
        $("body").attr("is_hover", 1);
    }, function() {
        $("body").attr("is_hover", 0);
    })
    $("#cats").hover(function() {
        var is_hover = $("body").attr("is_hover");
        if (is_hover == 0) {
            $("#cate-list-main").find(".hover").removeClass("hover");
            $("#cate-list-sub").animate({width: 0}, 400, function() {
                $("#cate-list-sub").hide();
            })
        }
    })

    $(".blur_area").hover(function() {
        $("body").attr('is_hover', 1);
    }, function() {
        $("body").attr('is_hover', 0);
    });
    $(".blur_area").blur(function() {
        if ($("body").attr("is_hover") == 0) {
//            photo_upload_close();
        }
    })
    //头部菜单悬浮
    $(".head_item_box").hover(function() {
        $(this).children(".head_box").show();
    }, function() {
        $(this).children(".head_box").fadeOut();
    })
    //发帖弹出层 标签切换
    $("#tags_head").find("li").hover(function() {
        $(this).addClass("current").siblings("li").removeClass("current");
        var index = $(this).index();
        $("#tags_contents").children(".item").hide();
        $("#tags_contents").children(".item").eq(index).show();
    })
    $("#tags_contents").find("li").click(function() {
        $(this).addClass("current").siblings("li").removeClass("current");
        $("#btn_tag_chose").text($(this).text());
        $("#tags_box_outside").hide();
    })
    //微博分类鼠标切换
    $("#weibo_cats_head").find("li").hover(function() {
        $(this).addClass("current").siblings("li").removeClass("current");
        var index = $(this).index();
        $('#weibo_cats_content').find("li").hide();
        $('#weibo_cats_content').find("li").eq(index).show();
    })
    $('#cats_type').hover(function() {
        $(this).find(".sub").css({"display": "block"});
        $(this).find(".arrow").removeClass("arrow-up").addClass("arrow-down");
    }, function() {
        $(this).find(".sub").hide();
        $(this).find(".arrow").addClass("arrow-up").removeClass("arrow-down");
    })
    $("#video_text").focus(function() {
        $(this).parents(".video_textarea_upload").addClass('clicked')
    }).blur(function() {
        $(this).parents(".video_textarea_upload").removeClass('clicked')
    })
    //图片轮播
    if ($('.scroll_horizontal').length > 0) {
        $('.scroll_horizontal').cxScroll({
            direction: 'left',
            step: 1,
            auto: false
        });
        $('.scroll_horizontal').find("li").click(function() {
            var src = $(this).attr("data-big");
            $(this).parents(".area_pic").find(".pic_big").find("img").attr("src", src)
        })
    }
    //评论输入框自适应
    $(".comment_content").textareaAutoHeight({maxHeight: 75});
})
function hide_card() {
    $("#card").hide()
}
function checkTextarea(obj) {
    var length = obj.val().length;
    var obj_publish = obj.parent().parent();
    if (length > 140) {
        obj_publish.find(".publish_words").html("已超出<span class='s_error'>" + (length - 140) + "</span>字").show();
        obj_publish.find(".btn").addClass("disabled");
    } else {
        obj_publish.find(".publish_words").html("还可以输入<span>" + (140 - length) + "</span>字").show();
        if (length == 0) {
            obj_publish.find(".btn").addClass("disabled");
        } else {
            obj_publish.find(".btn").removeClass("disabled");
        }
    }
}
function pic_upload_current(obj) {
    $(".pic_upload").removeClass("pic_upload_current");
    obj.addClass("pic_upload_current")
}

function post_add() {
    $("#post_box").modal();
    fadeout_div('#video_box_outside');
    photo_upload_close()
}
function hide_post_box() {
    $("#post_box").modal('hide');
    photo_upload_close();
}
function btn_tag_chose(obj) {
    var left = parseFloat(obj.offset().left) - 35;
    var top = parseFloat(obj.offset().top) + 42;
    $("#tags_box_outside").css({'left': left, 'top': top}).show();
}
function bgBlink(obj, type) {
    obj.animate({backgroundColor: '#CC0033'}, 150);
    obj.animate({backgroundColor: '#ffffff'}, 150, function() {
        obj.animate({backgroundColor: '#CC0033'}, 150, function() {
            obj.animate({backgroundColor: '#ffffff'}, 150, function() {

            });
        });
    });
}
function bgBlinkNone(obj, type) {
    obj.animate({backgroundColor: '#CC0033'}, 150, function() {
        obj.css("background", "none");
    });
}

function weibo_submit() {
    var content = $("#weibo_content").val();
    if (content == '' || content.length > 140) {
        bgBlink($("#weibo_content"));
        return;
    }
    var video_text = $("#video_text").val();
    var video_file = $("#video_file").val();
    var video_name = $("#video_name").val();
    //发布成功
    $("#send_succpic").show();
    setTimeout(function() {
        $("#send_succpic").hide()
    }, 3000);
    $("#weibo_content").val('');
    $(".publish_words").hide();
    var pics_path = "";
    $(".pics_path").each(function() {
        pics_path += $(this).val() + ",";
    })
    fadeout_div('#video_box_outside');
    photo_upload_close();
    console.log(pics_path);

}
function post_submit() {
    var content = $("#post_content").val();
    if (content == '' || content.length > 140) {
        bgBlink($("#post_content"));
        return;
    }
    var btn_tag_chose = $("#btn_tag_chose").text();
    if (btn_tag_chose == '选择标签') {
        bgBlink($("#chose_tags_tip"));
        return;
    }
}
function praise(obj, id) {
    var num = parseInt(obj.find(".praise_num").text());
    obj.find(".praise_num").text(num + 1);
    obj.addClass("current");
}
function comment_submit(obj, id) {
    var id = obj.parents(".comment_common").attr("data-id");
    var textarea = obj.parents(".comment_common").find("textarea");
    var content = textarea.val();
    var textarea_id = textarea.attr("id");
    if (content == '') {
        layer.tips('评论内容不能为空。', '#' + textarea_id, {
            tips: [1, '#0FA6D8'] //还可配置颜色
        });
        return;
    }
    if (content.length > 300) {
        layer.tips('评论内容过长。', '#' + textarea_id, {
            tips: [1, '#0FA6D8'] //还可配置颜色
        });
        return;
    }
    var pic = $(".preview").attr("src");
    console.log(textarea_id);
    if (content == textarea.attr("data-empty")) {
        layer.tips('评论内容不能为空。', '#' + textarea_id, {
            tips: [1, '#0FA6D8'] //还可配置颜色
        });
        return;
    }
    //成功提交评论
    $.post("common/comment.php", {id: id, content: content}, function(data) {
        textarea.val('').focus();
        photo_single_close();
        obj.addClass("disabled");
        obj.parents(".comments").find(".comment_lists").prepend(data);
    })
}
function checkCommentTextarea(obj) {
    var length = obj.val().length;
    var obj_publish = obj.parent().parent();
    if (length == 0) {
        obj_publish.find(".btn").addClass("disabled");
    } else {
        obj_publish.find(".btn").removeClass("disabled");
    }
}
function comment_del(obj) {
    var id = obj.parents(".comment_item").attr("data-id");
    layer.msg('确定要删除该回复吗', {
        time: 0 //不自动关闭
        , btn: ['确定', '取消']
        , yes: function(index) {
            obj.parents(".comment_item").remove();
            layer.close(index);
        }
    });
}
function comment_reply(obj) {
    var comment_item = obj.parents(".comment_item");
    comment_item.find(".comment_item_reply").slideToggle();
    var textarea = comment_item.find("textarea");
    var val = textarea.val();
    if (val == '') {
        var data_empty = "回复@cookie饼干君有毒:";
        textarea.val(data_empty).focus();
        textarea.attr("data-empty", data_empty)
    }
}
function replay_toggle(obj) {
    var obj_foot = obj.parents(".foot");
    if (obj.hasClass("current")) {
        obj.removeClass("current");
        obj_foot.find(".comments_lists_more").hide();
    } else {
        obj.addClass("current");
        obj_foot.find(".comments_lists_more").show();
    }
}
function attention_add(obj) {
    obj.addClass("attention_has").html("已关注")
}
function photo_upload_close() {
    $("#photo_upload_box_outside").fadeOut(500, function() {
        $(".li_upload").remove();
    })
}
function fadeout_div(id) {
    $(id).fadeOut();
}
function collect(obj, id) {
    obj.addClass("current").find(".collect_word").text("已收藏")
}
function show_info(obj) {
    obj.parents(".item").hide();
    obj.parents(".item").next(".edit_area").slideToggle();
}
function hide_info(obj) {
    obj.parents(".edit_area").hide();
    obj.parents(".edit_area").prev(".item").slideToggle();
}
function close_tag(obj) {
    obj.remove()
}
function subject_add() {
    var subject_name = $("#subject_name").val();
    if (subject_name == '') {
        alert("科目名称不能为空");
        return;
    }
    var item = "<a href='javascript:void(0);' onclick='close_tag($(this))'><span>" + subject_name + "</span><i></i></a>";
    $('#tags_arrow').append(item);
    $("#subject_name").val('');
}
function tags_add() {
    var tag_name = $("#tag_name").val();
    if (tag_name == '') {
        alert("标签名称不能为空");
        return;
    }
    var item = "<a href='javascript:void(0);' onclick='close_tag($(this))'><span>" + tag_name + "</span><i></i></a>";
    $('#tags_arrow2').append(item);
    $("#tag_name").val('');
}
function experience_edit(){
    
}
function attention_remove(obj){
    obj.parents(".item").remove();
}