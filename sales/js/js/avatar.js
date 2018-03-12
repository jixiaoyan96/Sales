$(function() {

    //所有头像绑定ajax获取名片
    var ajaxGetCard;
    var timeout;

    $(document).delegate('.avatar,.ThinkBox-wrapper', 'mouseenter', function(event) {
        //延迟执行鼠标移除事件
        clearTimeout(timeout);
        var ele = $(this);
        var user_id = ele.attr('user_id');
        if (user_id == undefined) {
            return false;
        }
        var avatar_height = parseFloat(ele.find("img").css("height"))+16;
//        console.log(avatar_height);
        //获取当前元素的位置,计算弹出框位置
        var ele_l = ele.offset().left;
        var ele_t = ele.offset().top;
        var x = ele_l + 0;
        var y = ele_t+avatar_height;

        //如果已经加载过了，则直接显示
        var card = ele.find('.card-box');
        if (card.html() != null) {
            box = $.ThinkBox(
                    card.get(0).outerHTML,
                    {
                        'fixed': false,
                        'center': false,
                        'unload': true,
                        'close': '',
                        'dataEle': '',
                        'style': '',
                        'x': x,
                        'y': y,
                        'modal': false
                    }
            );
        } else {
            ajaxGetCard = $.get('avatar.php', {'uid': user_id},
            function(data) {
                box = $.ThinkBox(
                        data,
                        {
                            'fixed': false,
                            'onload': true,
                            'center': false,
                            'close': '',
                            'dataEle': '',
                            'style': '',
                            'x': x,
                            'y': y,
                            'modal': false
                        }
                );
                ele.append(data);
                ele.find('.card-box').hide();
            });
        }
        event.stopPropagation();
    }).delegate('.avatar,.ThinkBox-wrapper', 'mouseleave', function(event) {
        var user_id = $(this).attr('user_id');
        if (user_id == undefined && $(this).attr('class') != 'ThinkBox-wrapper ThinkBox-') {
            return false;
        }
        ajaxGetCard.abort();
        //延迟执行鼠标移除事件
        timeout = setTimeout("$('.ThinkBox-wrapper').remove();", 30);
        event.stopPropagation();
    });
})