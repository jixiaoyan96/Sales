var wait = 120;//倒计时120秒
var intervalId;//定时
var i = wait;//倒计时递减 1
function exit() {
    $("#getMobileCode").text(i + "秒后重新发送").addClass("disabled");
    i = i - 1;
    if (i <= -1) {
        clearInterval(intervalId);
        $("#getMobileCode").removeAttr("disabled");
        $("#getMobileCode").text("发送验证码").removeClass("disabled");
    }
}
function getMobileCode() {
    if ($("#getMobileCode").hasClass('disabled')) {
        return;
    }
    var phone = $("#phone").val();
    if (phone == '') {
        showTipLoginBox("请输入手机号！");
        return;
    }
    var phone_pattern = /^1[3|4|5|7|8][0-9]{9}$/;
    if (!phone_pattern.test(phone)) {
        showTipLoginBox("手机号有误！");
        return;
    }

    $.post("sitemap.php", {phone: phone}, function(data) {
        i = wait;
        $("#getMobileCode").text("发送成功");
        intervalId = setInterval("exit()", 1000);
    })
}
function showTipLoginBox(words) {
    $("#error_tip").html('<i class="icon_error_tip"></i>' + words).show();
}
function showAgreement() {
    $.post("common/agreement.php", {}, function(data) {
        $("#windown_box").html(data);
        $("#box_modal").modal("show");
    })
}
function reg_submit() {
    var phone = $.trim($("#phone").val());
    var pwd = $.trim($("#pwd").val());
    var pwd2 = $.trim($("#pwd2").val());
    var code = $.trim($("#code").val());
    var phone_pattern = /^1[3|4|5|7|8][0-9]{9}$/;
    if (phone == '') {
        showTipLoginBox("请输入手机号");
        return false;
    }
    if (!phone_pattern.test(phone)) {
        showTipLoginBox("请输入正确的手机号");
        return false;
    }

    if (pwd == '') {
        showTipLoginBox("请输入密码");
        return false;
    }
    if (pwd.length < 6) {
        showTipLoginBox("密码长度应在6-16个字符范围内");
        return false;
    }
    if (pwd != pwd2) {
        showTipLoginBox("两次输入的密码不一致");
        return false;
    }
    if (code.length != 4) {
        showTipLoginBox("验证码长度有误");
        return false;
    }
    var agreement = $("#agreement").prop("checked");
    if (agreement == false) {
        showTipLoginBox("请阅读并同意注册协议");
        return false;
    }
    $("#error_tip").hide();

    return false;
}
function login_submit() {
    var phone = $.trim($("#phone").val());
    var pwd = $.trim($("#pwd").val());
    var phone_pattern = /^1[3|4|5|7|8][0-9]{9}$/;
    if (phone == '') {
        showTipLoginBox("请输入手机号");
        return false;
    }
    if (!phone_pattern.test(phone)) {
         showTipLoginBox("请输入正确的手机号");
        return false;
    }
    if (pwd == '') {
        showTipLoginBox("请输入密码");
        return false;
    }

}
function forget_submit() {
    var phone = $.trim($("#phone").val());
    var pwd = $.trim($("#pwd").val());
    var pwd2 = $.trim($("#pwd2").val());
    var code = $.trim($("#code").val());
    var phone_pattern = /^1[3|4|5|7|8][0-9]{9}$/;
    if (phone == '') {
        showTipLoginBox("请输入手机号");
        return false;
    }
    if (!phone_pattern.test(phone)) {
        showTipLoginBox("请输入正确的手机号");
        return false;
    }

    if (pwd == '') {
        showTipLoginBox("请输入密码");
        return false;
    }
    if (pwd.length < 6) {
        showTipLoginBox("密码长度应在6-16个字符范围内");
        return false;
    }
    if (pwd != pwd2) {
        showTipLoginBox("两次输入的密码不一致");
        return false;
    }
    if (code.length != 4) {
        showTipLoginBox("验证码长度有误");
        return false;
    }
    var agreement = $("#agreement").prop("checked");
    if (agreement == false) {
        showTipLoginBox("请阅读并同意注册协议");
        return false;
    }
    $("#error_tip").hide();

    return false;
}