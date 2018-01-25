<?php
$this->pageTitle=Yii::app()->name . ' - Customer Type Form';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'code-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('quiz','new sales dataAdd'); ?></strong>
    </h1>
    <!--
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Layout</a></li>
            <li class="active">Top Navigation</li>
        </ol>
    -->
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if ($model->scenario!='new' && $model->scenario!='view') {
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Another'), array(
                        'submit'=>Yii::app()->createUrl('sales/new')));
                }
                ?>
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('sales/index')));
                ?>
                <?php if ($model->scenario!='view'): ?>
                    <?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
                        'submit'=>Yii::app()->createUrl('sales/save')));
                    ?>
                <?php endif ?>
                <?php if ($model->scenario=='edit'): ?>
                    <?php echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
                            'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
                    );
                    ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="tempDiv"></div>
    <div class="box box-info">
        <div class="box-body">
            <?php echo $form->hiddenField($model, 'scenario'); ?>
            <?php echo $form->hiddenField($model, 'id'); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'customer_name',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'customer_name',
                        array('size'=>10,'maxlength'=>10,'id'=>'quiz_name','readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'customer_create_date',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php echo $form->textField($model, 'customer_create_date',
                            array('class'=>'form-control pull-right','readonly'=>($model->scenario=='view'),));
                        ?>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <?php echo $form->labelEx($model,'customer_second_name',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'customer_second_name',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'customer_help_count_date',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'customer_help_count_date',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
            </div>


            <div class="form-group">
                <?php echo $form->labelEx($model,'customer_contact',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'customer_contact',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'customer_contact_phone',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'customer_contact_phone',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
            </div>

            <!--  <script src="<?php /*echo Yii::app()->baseUrl;*/?>/js/jquery.js'"></script>-->
            <div class="form-group">
                <?php echo $form->labelEx($model,'visit_kinds',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model,'visit_kinds',Quiz::getKinds(),
                        array('disabled'=>!Yii::app()->user->validRWFunction('HK01'),'id'=>'select_questions_count')
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'customer_kinds',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model,'customer_kinds',Quiz::customerKinds(),
                        array('disabled'=>!Yii::app()->user->validRWFunction('HK01'),'id'=>'select_questions_count')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'customer_district',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'customer_district',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'),'id'=>'getCountValue2')
                    );?>
                </div>
                <?php echo $form->labelEx($model,'customer_street',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'customer_street',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'),'id'=>'getCountValue2')
                    );?>
                </div>
            </div>

            <div class="from-group">
                <?php echo $form->labelEx($model,'customer_notes',array('class'=>'col-sm-2 control-label'))?>
                <div class="col-sm-8">
                    <?php echo $form->textArea($model,'customer_notes',
                        array('size'=>'20', 'maxlength'=>'20','cols'=>'30','rows'=>'6')
                    ); ?>
                </div>
            </div>

            <?PHP /*$this->urlAjaxSelect=Yii::app()->createUrl('sales/AjaxUrl');*/?>
            <input type="hidden" id="urlGet" name="urlGet" value="<?php echo $this->urlAjaxSelect;?>"/>
            <?php echo $form->hiddenField($model, 'id'); ?>

            <?php echo $form->hiddenField($model, 'city',array('id'=>'getCountValue')); ?>
            <div class="form-group">
                <?php /*echo $form->labelEx($model,'city_privileges',array('class'=>"col-sm-2 control-label")); */?>
                <div class="col-sm-5">
                    <?php echo $form->hiddenField($model, 'city',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
            </div>


        </div>
    </div>
</section>
<script>
    $(function(){
        var AllDataCount=0;
        var demo=0;
        $('.innerbtn').click(function(){
            var data=$('.innerbtn').index(this);
            demo=data;
            console.log('当前为第'+demo+'个');
            $(this).next('.pop_box').slideDown('400');
        });

        $('.closepop').click(function(){
            //$(".tempDiv").find("input[name='serviceMoney[]']").attr('name','serviceMoney'+demo+'[]');
            //$('.pop_box').find("input[name=serviceMoney+demo+[]]");
            console.log(AllDataCount);
            $('.pop_box').slideUp('400');
        });

        $('.tbody1').on("click",".alonTr .innerbtn",function(){
            var data=$('.innerbtn').index(this);
            demo=data;
            console.log('当前为第'+demo+'个');
            $(this).next('.pop_box').slideDown('400');
        });

        $('.tbody1').on("click",".alonTr .closepop",function(){
            $('.pop_box').slideUp('400');
        });

// 新增表单
        var show_count = 10;  //至多跟进10次
        var count = 1;
        $(".AddTr").click(function () {

            var length = $(".tabInfo .tbody1>tr").length;
            //alert(length);
            if (length < show_count)
            {
                $(".model1 tbody .alonTr").clone().appendTo(".tabInfo .tbody1");
            }
        });


// 新增内件
        var show_count2 = 20;
        var count2 = 1;
        $(".addtr2").click(function () {
            var length = $(this).parent('.btn_a1').prev('.neijian').children('.tbody2 tr').length;
            //alert(length);
            if (length < show_count2)
            {
                $(".model2 tbody tr").clone().appendTo($(this).parent('.btn_a1').prev('.neijian').children('.tbody2'));
            }
        });

        // 动态的新增内件
        var show_count3 = 20;
        var count3 = 1;
        $(".tbody1").on("click",".dtadd",function () {
            //var SkyLength=document.getElementsByName("sky1[]").length;

            var length = $(".neijian .tbody2 tr").length;
            //alert(length);
            if (length < show_count3)
            {
                $(".tempDiv").html("");
                var divData=$('.model3 tbody tr').clone();
                //console.log(divData);
                $(".tempDiv").html(divData);
                $(".tempDiv").css({'width':"100%"});
                // $(".tempDiv").find("input").attr('name','值'+demo+'[]');

                $(".tempDiv").find("select[name='serviceKinds[]']").attr('name','serviceKinds'+demo+'[]');
                $(".tempDiv").find("input[name='serviceCounts[]']").attr('name','serviceCounts'+demo+'[]');
                $(".tempDiv").find("input[name='serviceMoney[]']").attr('name','serviceMoney'+demo+'[]');

                divData.appendTo($(this).parent('.btn_a1').prev('.neijian').children('.tbody2'));
                console.log('总计'+demo);
            }
        });
    });


    function deltr(opp) {
        var length = $(".tabInfo .tbody1>tr").length;
        //alert(length);
        if (length <= 1) {
            alert("至少保留一行表单");
        } else {
            $(opp).parent().parent().remove();//移除当前行

        }
    }
    // ----

    function deltr2(opp) {
        var length = $(this).parent('.btn_a1').prev('.neijian').children('.tbody2 tr').length;
        //alert(length);
        if (length <= 1) {
            alert("至少保留一行");
        } else {
            $(opp).parent().parent().remove();//移除当前行
        }
    }
    // ----

    function deltr3(opp) {
        var length = $('.neijian .tbody2 tr').length;
        //alert(length);
        if (length <= 1) {
            alert("至少保留一行");
        } else {
            $(opp).parent().parent().remove();//移除当前行

        }
    }
    // ----
</script>

<style>
    *{padding: 0px;margin: 0px;font-style: normal;list-style-type: none;text-decoration: none;font-family: "微软雅黑";font-size: 14px;border:0 none;line-height: 24px; }
    table .normTbe{table-layout: fixed;width: 100%;}
    input,button,select,textarea{outline: none;resize:none;padding: 3px 5px;border:1px solid #ddd;}
    input:focus,textarea:focus{border:1px solid #9ab6d6;}
    .whiteBg{background: #fff;}
    .normTbe{border:1px solid black; background-color:white;}
    .normTbe td,.normTbe th{border:1px solid black;padding: 15px;text-align: center;}
    .normTbe input{width: 80%;text-align: center;}
    .addData{width: 1140px;padding: 0 20px; margin: 0 auto;clear: both;}
    .pop_box {display: none;}
    .model2{display: none;}
    .model3{display: none;}
    .hideTr{background: #ddd;}
    .pop_box{position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 999;}
    .pop_box .bg{background: #000;opacity: 0.7;filter:alpha(opacity=70);position: absolute;top:0;left: 0;right: 0;bottom: 0;}
    .pop_box .contentP{position: relative;margin:0 auto;margin-top: 10%; background: #fff;width: 80%;}
    .pop_box .PTit{height: 45px;background: #eee;}
    .pop_box .PTit h3{line-height: 45px;float: left;padding-left: 15px;font-weight: normal;font-size: 16px;}
    .pop_box .PTit a{display: block;width: 45px;line-height: 45px;text-align: center;background: #ddd;float: right;font-size: 20px;}
    .pop_box .PTit a:hover{background: #50abfd;color: #fff;}
    .pop_box .textmian{padding: 15px;}
    .btn_a1{padding-top: 15px;}
    .btn_a1 a{display: inline-block;*display: inline;*zoom: 1;width: 120px;line-height: 45px;background: #50abfd;color: #fff;}
    .btn_a1 .addtr2,.btn_a1 .dtadd{background: #ff9900;}
    .tempDiv{width:0%;  height:0px;  border: 0px solid red}
</style>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  Yii::t('quiz','If you do not fill in the follow-up date and follow-up purpose, then this follow-up will not record deposited');?>
<div class="addData">
    <table cellspacing="0" cellpadding="0" border="0" class="normTbe model2">
        <tbody>
        <tr class="alonTr2"> <!--所有的跟进 第二条之后的服务都是demo1-->
            <td>
                <select name="demo1[]">
                    <option value="">选择服务</option>
                    <option value="清洁(马桶)">清洁(马桶)</option>
                    <option value="清洁(尿斗)">清洁(尿斗)</option>
                    <option value="清洁(水盆)">清洁(水盆)</option>
                    <option value="清洁(清新机)">清洁(清新机)</option>
                    <option value="清洁(皂液机)">清洁(皂液机)</option>
                    <option value="清洁(租赁机器)">清洁(租赁机器)</option>
                    <option value="灭虫(老鼠)">灭虫(老鼠)</option>
                    <option value="灭虫(蟑螂">灭虫(蟑螂)</option>
                    <option value="灭虫(果蝇)">灭虫(果蝇)</option>
                    <option value="灭虫(租灭蝇灯)">灭虫(租灭蝇灯)</option>
                    <option value="灭虫(老鼠蟑螂)">灭虫(老鼠蟑螂)</option>
                    <option value="灭虫(老鼠果蝇)">灭虫(老鼠果蝇)</option>
                    <option value="灭虫(老鼠蟑螂果蝇)">灭虫(老鼠蟑螂果蝇)</option>
                    <option value="灭虫(老鼠蟑螂+租灯)">灭虫(老鼠蟑螂+租灯)</option>
                    <option value="灭虫(蟑螂果蝇+租灯)">灭虫(蟑螂果蝇+租灯)</option>
                    <option value="灭虫(老鼠蟑螂果蝇+租灯)">灭虫(老鼠蟑螂果蝇+租灯)</option>
                    <option value="飘盈香(迷你机)">飘盈香(迷你机)</option>
                    <option value="飘盈香(小机)">飘盈香(小机)</option>
                    <option value="飘盈香(中机)">飘盈香(中机)</option>
                    <option value="飘盈香(大机)">飘盈香(大机)</option>
                    <option value="甲醛(除甲醛)">甲醛(除甲醛)</option>
                    <option value="甲醛(AC30)">甲醛(AC30)</option>
                    <option value="甲醛(PR30)">甲醛(PR30)</option>
                    <option value="甲醛(迷你清洁炮)">甲醛(迷你清洁炮)</option>
                </select>
            </td>
            <td><input type="text" name="demo2[]"/></td>
            <td><input type="text" name="demo3[]"/></td>
            <td><a class="text_a" href="javascript:;" onClick="deltr3(this)">删除</a></td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" class="normTbe model3">
        <tbody>
        <tr class="alonTr2"> <!--所有的跟进 第二条之后的动态增加的服务-->

            <td>
                <select name="serviceKinds[]">
                    <option value="">服务类别选择</option>
                    <option value="清洁(马桶)">清洁(马桶)</option>
                    <option value="清洁(尿斗)">清洁(尿斗)</option>
                    <option value="清洁(水盆)">清洁(水盆)</option>
                    <option value="清洁(清新机)">清洁(清新机)</option>
                    <option value="清洁(皂液机)">清洁(皂液机)</option>
                    <option value="清洁(租赁机器)">清洁(租赁机器)</option>
                    <option value="灭虫(老鼠)">灭虫(老鼠)</option>
                    <option value="灭虫(蟑螂">灭虫(蟑螂)</option>
                    <option value="灭虫(果蝇)">灭虫(果蝇)</option>
                    <option value="灭虫(租灭蝇灯)">灭虫(租灭蝇灯)</option>
                    <option value="灭虫(老鼠蟑螂)">灭虫(老鼠蟑螂)</option>
                    <option value="灭虫(老鼠果蝇)">灭虫(老鼠果蝇)</option>
                    <option value="灭虫(老鼠蟑螂果蝇)">灭虫(老鼠蟑螂果蝇)</option>
                    <option value="灭虫(老鼠蟑螂+租灯)">灭虫(老鼠蟑螂+租灯)</option>
                    <option value="灭虫(蟑螂果蝇+租灯)">灭虫(蟑螂果蝇+租灯)</option>
                    <option value="灭虫(老鼠蟑螂果蝇+租灯)">灭虫(老鼠蟑螂果蝇+租灯)</option>
                    <option value="飘盈香(迷你机)">飘盈香(迷你机)</option>
                    <option value="飘盈香(小机)">飘盈香(小机)</option>
                    <option value="飘盈香(中机)">飘盈香(中机)</option>
                    <option value="飘盈香(大机)">飘盈香(大机)</option>
                    <option value="甲醛(除甲醛)">甲醛(除甲醛)</option>
                    <option value="甲醛(AC30)">甲醛(AC30)</option>
                    <option value="甲醛(PR30)">甲醛(PR30)</option>
                    <option value="甲醛(迷你清洁炮)">甲醛(迷你清洁炮)</option>
                </select>
            </td>
            <td> <input type="text" name="serviceCounts[]"/></td>
            <td><input type="text" name="serviceMoney[]"/></td>
            <td><a class="text_a" href="javascript:;" onClick="deltr3(this)">删除</a></td>
        </tr>
        </tbody>
    </table>
    <table cellspacing="0" cellpadding="0" border="0" class="normTbe model1 hide">
        <tbody>
        <tr class="alonTr">  <!--第二层以及更多的跟进表单数据-->
            <td><input type="date" value="10" name="sky1[]"/></td>
            <td>
                <select name="sky2[]">
                    <option value="">本次跟进目的</option>
                    <option value="首次">首次</option>
                    <option value="报价">报价</option>
                    <option value="客诉">客诉</option>
                    <option value="收款">收款</option>
                    <option value="追款">追款</option>
                    <option value="签单">签单</option>
                    <option value="续约">续约</option>
                    <option value="回访">回访</option>
                    <option value="其他">其他</option>
                    <option value="更改项目">更改项目</option>
                    <option value="拜访目的">拜访目的</option>
                    <option value="陌拜">陌拜</option>
                    <option value="日常跟进">日常跟进</option>
                    <option value="客户资源">客户资源</option>
                    <option value="电话上门">电话上门</option>
                </select>
            </td>
            <td><input type="text" value="" placeholder="本次跟进备注" name="sky3[]"/></td>
            <td><input type="text" value="" placeholder="本次跟进总金额" name="sky4[]"/></td>

            <td>
                <a href="javascript:;" class="innerbtn">添加服务22</a>
                <div class="pop_box">
                    <div class="bg"></div>
                    <div class="contentP">
                        <div class="PTit">
                            <h3>内件商品信息</h3>
                            <a href="javascript:;" class="closepop">x</a>
                        </div>
                        <div class="textmian">
                            <table class="normTbe neijian" cellspacing="0" cellpadding="0" border="0";>
                                <thead>
                                <tr>
                                    <th>服务产品</th>
                                    <th>数量</th>
                                    <th>价格</th>
                                    <th>操作</th>
                                    <!--                                     <th>单价</th>
                                                                         <th>总价</th>
                                                                         <th>HSCODE</th>
                                                                         <th>产地</th>
                                                                         <th>操作</th>-->
                                </tr>
                                </thead>
                                <tbody class="tbody2">
                                <tr>  <!--动态跟进 每次的第一项服务都是 day1-->
                                    <td>
                                        <select name="day1[]">
                                            <option value="">服务类别</option>
                                            <option value="清洁(马桶)">清洁(马桶)</option>
                                            <option value="清洁(尿斗)">清洁(尿斗)</option>
                                            <option value="清洁(水盆)">清洁(水盆)</option>
                                            <option value="清洁(清新机)">清洁(清新机)</option>
                                            <option value="清洁(皂液机)">清洁(皂液机)</option>
                                            <option value="清洁(租赁机器)">清洁(租赁机器)</option>
                                            <option value="灭虫(老鼠)">灭虫(老鼠)</option>
                                            <option value="灭虫(蟑螂">灭虫(蟑螂)</option>
                                            <option value="灭虫(果蝇)">灭虫(果蝇)</option>
                                            <option value="灭虫(租灭蝇灯)">灭虫(租灭蝇灯)</option>
                                            <option value="灭虫(老鼠蟑螂)">灭虫(老鼠蟑螂)</option>
                                            <option value="灭虫(老鼠果蝇)">灭虫(老鼠果蝇)</option>
                                            <option value="灭虫(老鼠蟑螂果蝇)">灭虫(老鼠蟑螂果蝇)</option>
                                            <option value="灭虫(老鼠蟑螂+租灯)">灭虫(老鼠蟑螂+租灯)</option>
                                            <option value="灭虫(蟑螂果蝇+租灯)">灭虫(蟑螂果蝇+租灯)</option>
                                            <option value="灭虫(老鼠蟑螂果蝇+租灯)">灭虫(老鼠蟑螂果蝇+租灯)</option>
                                            <option value="飘盈香(迷你机)">飘盈香(迷你机)</option>
                                            <option value="飘盈香(小机)">飘盈香(小机)</option>
                                            <option value="飘盈香(中机)">飘盈香(中机)</option>
                                            <option value="飘盈香(大机)">飘盈香(大机)</option>
                                            <option value="甲醛(除甲醛)">甲醛(除甲醛)</option>
                                            <option value="甲醛(AC30)">甲醛(AC30)</option>
                                            <option value="甲醛(PR30)">甲醛(PR30)</option>
                                            <option value="甲醛(迷你清洁炮)">甲醛(迷你清洁炮)</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="day2[]"/></td>
                                    <td><input type="text" name="day3[]"/></td>
                                    <!--             <td><input type="text" name="day4[]"/></td>
                                                 <td><input type="text" name="day5[]"/></td>
                                                 <td><input type="text" name="day6[]"/></td>
                                                 <td><select name=""><option value="1">中国</option><option value="2">美国</option></select></td>-->
                                    <td><a class="text_a" href="javascript:;" onClick="deltr2(this)">删除</a></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="btn_a1">
                                <a class="dtadd" href="javascript:;">新增服务2-2</a> <a class="closepop" href="javascript:;">确定服务2-2</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br /><a class="text_a" href="javascript:;" onClick="deltr(this)">删除22</a>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="itemInfo">
        <table cellspacing="0" cellpadding="0" border="0" class="normTbe tabInfo">
            <thead>
            <tr>
                <th>本次跟进日期</th>
                <th>本次跟进目的</th>
                <th>本次跟进备注</th>
                <th>本次跟进总额</th>
                <th>操作</th>
            </tr>
            </thead>

            <tbody class="tbody1">
            <tr>  <!--第一层的表单拜访数据-->
                <td><input type="date" value="10" name="first1[]"/></td>
                <td><select name="first2[]">
                        <option value="">本次跟进目的</option>
                        <option value="首次">首次</option>
                        <option value="报价">报价</option>
                        <option value="客诉">客诉</option>
                        <option value="收款">收款</option>
                        <option value="追款">追款</option>
                        <option value="签单">签单</option>
                        <option value="续约">续约</option>
                        <option value="回访">回访</option>
                        <option value="其他">其他</option>
                        <option value="更改项目">更改项目</option>
                    </select></td>
                <td ><input type="text" value="" placeholder="本次跟进备注" name="first3[]"/></td>
                <td><input type="text" value="" placeholder="本次跟进总金额" name="first4[]"/></td>
                <td>
                    <a href="javascript:;" class="innerbtn">添加服务(1</a>
                    <div class="pop_box">
                        <div class="bg"></div>
                        <div class="contentP">
                            <div class="PTit">
                                <h3><?php echo Yii::t('quiz','Follow up service information')."(".Yii::t('quiz','If you do not select the service and fill in the service amount, no data will be stored').")";?></h3>
                                <a href="javascript:;" class="closepop">x</a>
                            </div>
                            <div class="textmian">
                                <table class="normTbe neijian" cellspacing="0" cellpadding="0" border="0";>
                                    <thead>
                                    <tr>
                                        <th>服务产品</th>
                                        <th>数量</th>
                                        <th>价格</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody2">
                                    <tr>  <!--第一个表单拜访的新增内件数据的第一条数据-->
                                        <td>
                                            <select name="count1[]">
                                                <option value="">服务类型选择</option>
                                                <option value="清洁(马桶)">清洁(马桶)</option>
                                                <option value="清洁(尿斗)">清洁(尿斗)</option>
                                                <option value="清洁(水盆)">清洁(水盆)</option>
                                                <option value="清洁(清新机)">清洁(清新机)</option>
                                                <option value="清洁(皂液机)">清洁(皂液机)</option>
                                                <option value="清洁(租赁机器)">清洁(租赁机器)</option>
                                                <option value="灭虫(老鼠)">灭虫(老鼠)</option>
                                                <option value="灭虫(蟑螂">灭虫(蟑螂)</option>
                                                <option value="灭虫(果蝇)">灭虫(果蝇)</option>
                                                <option value="灭虫(租灭蝇灯)">灭虫(租灭蝇灯)</option>
                                                <option value="灭虫(老鼠蟑螂)">灭虫(老鼠蟑螂)</option>
                                                <option value="灭虫(老鼠果蝇)">灭虫(老鼠果蝇)</option>
                                                <option value="灭虫(老鼠蟑螂果蝇)">灭虫(老鼠蟑螂果蝇)</option>
                                                <option value="灭虫(老鼠蟑螂+租灯)">灭虫(老鼠蟑螂+租灯)</option>
                                                <option value="灭虫(蟑螂果蝇+租灯)">灭虫(蟑螂果蝇+租灯)</option>
                                                <option value="灭虫(老鼠蟑螂果蝇+租灯)">灭虫(老鼠蟑螂果蝇+租灯)</option>
                                                <option value="飘盈香(迷你机)">飘盈香(迷你机)</option>
                                                <option value="飘盈香(小机)">飘盈香(小机)</option>
                                                <option value="飘盈香(中机)">飘盈香(中机)</option>
                                                <option value="飘盈香(大机)">飘盈香(大机)</option>
                                                <option value="甲醛(除甲醛)">甲醛(除甲醛)</option>
                                                <option value="甲醛(AC30)">甲醛(AC30)</option>
                                                <option value="甲醛(PR30)">甲醛(PR30)</option>
                                                <option value="甲醛(迷你清洁炮)">甲醛(迷你清洁炮)</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="count2[]"/></td>
                                        <td><input type="text" name="count3[]"/></td>
                                        <td><a class="text_a" href="javascript:;" onClick="deltr2(this)">删除</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="btn_a1">
                                    <a class="addtr2" href="javascript:;">新增服务1-1</a> <a class="closepop" href="javascript:;">确定服务1-1</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <a class="text_a" href="javascript:;" onClick="deltr(this)">删除(1</a>  <!--第一行的表单删除-->
                </td>
            </tr>
            </tbody>

        </table>
        <div class="copybtn">
            <a href="javascript:;" class="AddTr">新增</a>
            <a href="javascript:;" class="ture">确定</a>
        </div>
    </div>

</div><!-- itemInfo -->



<?php $this->renderPartial('//site/removedialog'); ?>
<?php
$js = "
$('#SalesForm_customer_create_date').on('change',function() {
	showRenewDate();
});
function showRenewDate() {
	var sdate = $('#StaffForm_ctrt_start_dt').val();
	var period = $('#StaffForm_ctrt_period').val();
	if (IsDate(sdate) && IsNumeric(period)) {
		var d = new Date(sdate);
		d.setMonth(d.getMonth() + Number(period));
		$('#StaffForm_ctrt_renew_dt').val(formatDate(d));
	}
	if (period=='') $('#StaffForm_ctrt_renew_dt').val('');
}

function formatDate(val) {
	var day = '00'+val.getDate();
	var month = '00'+(val.getMonth()+1);
	var year = val.getFullYear();
	return year + '/' + month.slice(-2) + '/' +day.slice(-2);
}

function IsDate(val) {
	var d = new Date(val);
	return (!isNaN(d.valueOf()));
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
";

$js = Script::genDeleteData(Yii::app()->createUrl('sales/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);

if ($model->scenario!='view') {
    $js = Script::genDatePicker(array(
        'SalesForm_customer_create_date',
    ));
    Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>
