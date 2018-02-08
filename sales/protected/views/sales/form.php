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
                    array('size'=>'20', 'maxlength'=>'50','cols'=>'30','rows'=>'6')
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




<style>
    *{padding: 0px;margin: 0px;font-style: normal;list-style-type: none;text-decoration: none;border:0 none; }
    input,button,select,textarea{outline: none;resize:none;padding: 3px 5px;border:1px solid #ddd;}
    input:focus,textarea:focus{border:1px solid #9ab6d6;}
    .whiteBg{background: #fff;}
    .normTbe{border:1px solid black; background-color:white;}
    .normTbe td,.normTbe th{border:1px solid black;padding: 15px;text-align: center;}
    .normTbe input{width: 80%;text-align: center;}
    .addData{width: auto;padding: 0 20px; margin: 0 auto;clear: both;}
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
                <td >
                    <select name="count1[]">
                        <option value="7">选择服务大类</option>
                        <option value='0'>清洁</option>
                        <option value='1'>租赁机器</option>
                        <option value='2'>灭虫</option>
                        <option value='3'>飘盈香</option>
                        <option value='4'>甲醛</option>
                        <option value='5'>纸品</option>
                        <option value='6'>一次性售卖</option>
                    </select>
                </td>
                <td id="temporary"><input type="text" name="demo2[]"/></td>
                <td><input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " ng-pattern="/[^a-zA-Z]/" name="demo3[]"/></td>
                <td><a class="text_a" href="javascript:;" onClick="deltr3(this)">删除1-2</a></td>
            </tr>
            </tbody>
        </table>
    <table cellspacing="0" cellpadding="0" border="0" class="normTbe model3">
        <tbody>
        <tr class="alonTr2"> <!--所有的跟进 第二条之后的动态增加的服务-->

            <td>
                <select name="serviceKinds[]">
                    <option value="7">选择服务大类</option>
                    <option value='0'>清洁</option>
                    <option value='1'>租赁机器</option>
                    <option value='2'>灭虫</option>
                    <option value='3'>飘盈香</option>
                    <option value='4'>甲醛</option>
                    <option value='5'>纸品</option>
                    <option value='6'>一次性售卖</option>
                </select>
            </td>
           <td> <input type="text" name="serviceCounts[]" value="0"/></td>
            <td><input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " ng-pattern="/[^a-zA-Z]/" name="serviceMoney[]"/></td>
            <td><a class="text_a" href="javascript:;" onClick="deltr3(this)">删除1-3</a></td><!--动态跟进的动态服务删除-->
        </tr>
        </tbody>
    </table>
        <table cellspacing="0" cellpadding="0" border="0" class="normTbe model1 hide">
            <tbody>
            <tr class="alonTr">  <!--第二层以及更多的跟进表单数据-->
                <td><input value="" type="date" name="sky1[]" class='form-control pull-right '/></td>
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
                <td><input type="text" value=""  placeholder="" name="sky4[]"/></td>
                <td>
                    <a href="javascript:;" class="innerbtn">添加服务1-2</a><!--动态跟进的动态服务添加-->
                    <div class="pop_box">
                        <div class="bg"></div>
                        <div class="contentP">
                            <!--<div class="PTit">
                                <h3>内件商品信息</h3>
                                <a href="javascript:;" class="closepop">x</a>
                            </div>-->
                            <div class="textmian">
                                <table class="normTbe neijian" cellspacing="0" cellpadding="0" border="0";>
                                    <thead>
                                    <tr>
                                        <th>服务产品</th>
                                        <th>数量</th>
                                        <th>价格(人民币)</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody2">
                                    <tr>  <!--动态跟进 每次的第一项服务都是 day1-->
                                        <td>
                                            <select name="day1[]" onchange="show_subSecond(this.options[this.options.selectedIndex].value)">
                                                <option value='7'>选择服务大类</option>
                                                <option value='0'>清洁</option>
                                                <option value='1'>租赁机器</option>
                                                <option value='2'>灭虫</option>
                                                <option value='3'>飘盈香</option>
                                                <option value='4'>甲醛</option>
                                                <option value='5'>纸品</option>
                                                <option value='6'>一次性售卖</option>
                                            </select>
                                        </td>
                                        <td class="runIdFirst"><input type="text" name="day2[]" value="0"/></td>
                                        <td><input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " ng-pattern="/[^a-zA-Z]/" name="day3[]"/></td>
                                        <td><a class="text_a" href="javascript:;" onClick="deltr2(this)">删除1-1</a></td>
                                    </tr>

                                    </tbody>
                                </table>
                                <div class="btn_a1">
                                    <a class="dtadd" href="javascript:;">新增服务222</a> <a class="closepop" href="javascript:;">确定服务222</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br /><a class="text_a" href="javascript:;" onClick="deltr(this)">删除</a>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="table-responsive" >
            <table cellspacing="0" cellpadding="0" border="0" class="class normTbe tabInfo " >
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
                    <td><input value="" name="first1[]" id="first1" class='form-control pull-right'/></td>
                    <td>
                        <select name="first2[]">
                            <option value="">本次11跟进目的</option>
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
                        </select>
                    </td>
                    <td ><input type="text" value="" placeholder="本次跟进备注" name="first3[]"/></td>
                    <td><input type="text" value=""  placeholder="" name="first4[]" id="firstCountMoney"/></td>
                    <td>
                        <a href="javascript:;" class="innerbtn">添加服务1-1</a>
                        <div class="pop_box">
                            <div class="bg"></div>
                            <div class="contentP">
                                <div class="PTit">
                                    <h3><?php echo Yii::t('quiz','Follow up service information')."(".Yii::t('quiz','If you do not select the service and fill in the service amount, no data will be stored').")";?></h3>
                                    <!--<a href="javascript:;" class="closepop">x</a>-->
                                </div>
                                <div class="textmian">
                                    <table class="normTbe neijian" cellspacing="0" cellpadding="0" border="0";>
                                        <thead>
                                        <tr>
                                            <th>服务大类选择</th>
                                            <th>数量</th>
                                            <th>价格(人民币)</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody2">
                                        <tr>  <!--第一个表单拜访的新增内件数据的第一条数据-->
                                            <td>
                                              <select name="count1[]" onchange="show_sub(this.options[this.options.selectedIndex].value)">
                                                  <option value="7">选择服务大类</option>
                                                  <option value='0'>清洁</option>
                                                  <option value='1'>租赁机器</option>
                                                  <option value='2'>灭虫</option>
                                                  <option value='3'>飘盈香</option>
                                                  <option value='4'>甲醛</option>
                                                  <option value='5'>纸品</option>
                                                  <option value='6'>一次性售卖</option>
                                              </select>
                                            </td>
                                            <script type="text/javascript">
                                                function show_sub(pin){
                                                    var html='';
                                                    if(pin==0){
                                                        html="<input type='checkbox' style='width: 30px;' name='matong1' value='1'>马桶<input style='width: 60px;' name='matonginput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='niaodou1' value='1'>尿斗<input style='width: 60px;' name='niaodouinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='shuipen1' value='1'>水盆<input style='width: 60px;' name='shuipeninput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='qingxinji1' value='1'>清新机<input style='width: 60px;' name='qingxinjiinput1' value='' placeholder='数量'/><br/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='zaoyeji1' value='1'>皂液机<input style='width: 60px;' name='zaoyejiinput1' value='' placeholder='数量'/>";
                                                    }
                                                    else if(pin==1){
                                                         html="<input type='checkbox' style='width: 30px;' name='fengshanji1' value='1'>风扇机<input style='width: 60px;' name='fengshanjiinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='TChaohua1' value='1'>TC豪华<input style='width: 60px;' name='TChaohuainput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='shuixingpenji1' value='1'>水性喷机<input style='width: 60px;' name='shuixingpenjiinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='yasuoxiangguan1' value='1'>压缩香罐<input style='width: 60px;' name='yasuoxiangguaninput1' value='' placeholder='数量'/>"
                                                    }
                                                    else if(pin==2){
                                                        html=
                                                            "<input type='checkbox' style='width: 30px;' name='laoshu1' value='1'>老鼠<input style='width: 60px;' name='laoshuinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='zhanglang1' value='1'>蟑螂<input style='width: 60px;' name='zhanglanginput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='guoying1' value='1'>果蝇<input style='width: 60px;' name='guoyinginput1' value='' placeholder='数量'/>"
                                                            +
                                                            "<input type='checkbox' style='width: 30px;' name='zumieyingdeng1' value='1'>租灭蝇灯<input style='width: 60px;' name='zumieyingdenginput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglang1' value='1'>老鼠蟑螂<input style='width: 60px;' name='laoshuzhanglanginput1' value='' placeholder='数量'/>"
                                                            +
                                                            "<input type='checkbox' style='width: 30px;' name='laoshuguoying1' value='1'>老鼠果蝇<input style='width: 60px;' name='laoshuguoyinginput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='zhanglangguoying1' value='1'>蟑螂果蝇<input style='width: 60px;' name='zhanglangguoyinginput1' value='' placeholder='数量'/>"
                                                            +
                                                            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangguoying1' value='1'>老鼠蟑螂果蝇<input style='width: 60px;' name='laoshuzhanglangguoyinginput1' value='' placeholder='数量'/><br/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangjiazudeng1' value='1'>老鼠蟑螂+租灯<input style='width: 60px;' name='laoshuzhanglangjiazudenginput1' value='' placeholder='数量'/>"
                                                            +
                                                            "<input type='checkbox' style='width: 30px;' name='zhanglangguoyingjiazudeng1' value='1'>蟑螂果蝇+租灯<input style='width: 60px;' name='zhanglangguoyingjiazudenginput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangguoyingjiazudeng1' value='1'>老鼠蟑螂果蝇+租灯<input style='width: 60px;' name='laoshuzhanglangguoyingjiazudenginput1' value='' placeholder='数量'/>"
                                                    }
                                                    else if(pin==3){
                                                        html="<input type='checkbox' style='width: 30px;' name='minixiaoji1' value='1'>迷你小机<input style='width: 60px;' name='minixiaojiinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='xiaoji1' value='1'>小机<input style='width: 60px;' name='xiaojiinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='zhongji1' value='1'>中机<input style='width: 60px;' name='zhongjiinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='daji1' value='1'>大机<input style='width: 60px;' name='dajiinput1' value='' placeholder='数量'/>"
                                                    }
                                                    else if(pin==4){
                                                        html="<input type='checkbox' style='width: 30px;' name='chujiaquan1' value='1'>除甲醛<input style='width: 60px;' name='chujiaquaninput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='AC301' value='1'>AC30<input style='width: 60px;' name='AC30input1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='PR101' value='1'>PR10<input style='width: 60px;' name='PR10input1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='miniqingjiepao1' value='1'>迷你清洁炮<input style='width: 60px;' name='miniqingjiepaoinput1' value='' placeholder='数量'/>"
                                                    }
                                                    else if(pin==5){
                                                        html="<input type='checkbox' style='width: 30px;' name='cashouzhi1' value='1'>擦手纸<input style='width: 60px;' name='cashouzhiinput1' value='' placeholder='数量'/>" +
                                                            "<input type='checkbox' style='width: 30px;' name='dajuancezhi1' value='1'>大卷厕纸<input style='width: 60px;' name='dajuancezhiinput1' value='' placeholder='数量'/>"
                                                    }
                                                    else if(pin==6){
                                                        html="<input type='checkbox' style='width: 30px;' name='wupin' value='1'>物品<input style='width: 60px;' name='' value='' placeholder='数量'/>"
                                                    }
                                                    else if(pin==7){
                                                        html="<div></div>";
                                                    }
                                                   $("#FirstVisitServiceValue").html(html);
                                                }
                                                </script>
                                            <td id="FirstVisitServiceValue"></td>
                                            <td><input type="text" onkeyup="value=value.replace(/[^\d]/g,'') " ng-pattern="/[^a-zA-Z]/" id="firstServiceCountMOney" name="count3[]"/></td>
                                            <td><a class="text_a" href="javascript:;" onClick="deltr2(this)">删除1-1</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="btn_a1">
                                        <a class="addtr2" href="javascript:;">新增服务1-2</a> <a class="closepop" href="javascript:;">确定服务1-2</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                       <!-- <a class="text_a" href="javascript:;" onClick="deltr(this)">删除</a>-->  <!--第一行的表单删除-->
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="copybtn">
                <a href="javascript:;" class="AddTr">动态新增跟进</a>
                <a href="javascript:;" class="ture">确定</a>
            </div>
        </div>
</div><!-- itemInfo -->

<script type="text/javascript">
    var AllDataCount=0;
    var demo=0; //当前第几个跟进
        var count = 1;  //跟进数量  全局跟进变量由count来计数
        var count2 = 1; //计数 为当前第几个服务进行修改 (第一次跟进的数据)
        //清洁
        var qingjie="<input type='checkbox' style='width: 30px;' name='matong' value='1'>马桶<input style='width:60px;' name='matonginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='niaodou' value='1'>尿斗<input style='width:60px;' name='niaodouinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='shuipen' value='1'>水盆<input style='width:60px;' name='shuipeninput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='qingxinji' value='1'>清新机<input style='width:60px;' name='qingxinjiinput' value='' placeholder='数量'/><br/>" +
            "<input type='checkbox' style='width: 30px;' name='zaoyeji' value='1'>皂液机<input style='width:60px;' name='zaoyejiinput' value='' placeholder='数量'/>";
        //租赁
        var   zulin="<input type='checkbox' style='width: 30px;' name='fengshanji' value='1'>风扇机<input style='width:60px;' name='fengshanjiinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='TChaohua' value='1'>TC豪华<input style='width:60px;' name='TChaohuainput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='shuixingpenji' value='1'>水性喷机<input style='width:60px;' name='shuixingpenjiinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='yasuoxiangguan' value='1'>压缩香罐<input style='width:60px;' name='yasuoxiangguaninput' value='' placeholder='数量'/>";
        //灭虫
        var miechong=
            "<input type='checkbox' style='width: 30px;' name='laoshu' value='1'>老鼠<input style='width:60p" +
            "x;' name='laoshuinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='zhanglang' value='1'>蟑螂<input style='width: 60px;' name='zhanglanginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='guoying' value='1'>果蝇<input style='width: 60px;' name='guoyinginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='zumieyingdeng' value='1'>租灭蝇灯<input style='width: 60px;' name='zumieyingdenginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglang' value='1'>老鼠蟑螂<input style='width: 60px;' name='laoshuzhanglanginput' value='' placeholder='数量'/><br/>"+
            "<input type='checkbox' style='width: 30px;' name='laoshuguoying' value='1'>老鼠果蝇<input style='width: 60px;' name='laoshuguoyinginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='zhanglangguoying' value='1'>蟑螂果蝇<input style='width: 60px;' name='zhanglangguoyinginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangguoying' value='1'>老鼠蟑螂果蝇<input style='width: 60px;' name='zhanglanginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangjiazudeng' value='1'>老鼠蟑螂+租灯<input style='width: 60px;' name='laoshuzhanglangjiazudenginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='zhanglangguoyingjiazudeng' value='1'>蟑螂果蝇+租灯<input style='width: 60px;' name='zhanglangguoyingjiazudenginput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangguoyingjiazudeng' value='1'>老鼠蟑螂果蝇+租灯<input style='width: 60px;' name='laoshuzhanglangguoyingjiazudenginput' value='' placeholder='数量'/>";
        //飘盈香
        var piaoyingxiang="<input type='checkbox' style='width: 30px;' name='minixiaoji' value='1'>迷你小机<input style='width: 60px;' name='minixiaojiinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='xiaoji' value='1'>小机<input style='width: 60px;' name='xiaojiinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='zhongji' value='1'>中机<input style='width: 60px;' name='zhongjiinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='daji' value='1'>大机<input style='width: 60px;' name='dajiinput' value='' placeholder='数量'/>";
        //甲醛
        var jiaquan="<input type='checkbox' style='width: 30px;' name='chujiaquan' value='1'>除甲醛<input style='width: 60px;' name='chujiaquaninput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='AC30' value='1'>AC30<input style='width: 60px;' name='AC30input' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='PR10' value='1'>PR10<input style='width: 60px;' name='PR10input' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='miniqingjiepao' value='1'>迷你清洁炮<input style='width: 60px;' name='miniqingjiepaoinput' value='' placeholder='数量'/>";
        //厕纸
        var zhipin="<input type='checkbox' style='width: 30px;' name='cashouzhi' value='1'>擦手纸<input style='width: 60px;' name='fengshanjiinput' value='' placeholder='数量'/>" +
            "<input type='checkbox' style='width: 30px;' name='dajuancezhi' value='1'>大卷厕纸<input style='width: 60px;' name='dajuancezhiinput' value='' placeholder='数量'/>";


        $('.innerbtn').click(function(){
            var data=$('.innerbtn').index(this);
            demo=data;
            console.log('当前为第'+count+'个');  //第一个跟进的数据下拉服务
            $(this).next('.pop_box').slideDown('400');
        });

        $('.closepop').click(function(){
            var aa=$(this).parent(".btn_a1");
            var bb=aa.prev("table");
            var cc=bb.find("input[type='text']");
            var total=0;
           // console.log(total);
           console.log('执行1');
            cc.each(  //循环input数组
                function (){
                    var input =$(this);  //循环每一个input元素
                    console.log(input.val());
                    total=total+parseInt(input.val());  //查看循环中的每一个input的id
                }
            );
           // console.log(total);
            var CountAll=parseInt(aa)+parseInt(bb);
            $("#firstCountMoney").val(total);
            $('.pop_box').slideUp('400');
        });

        $('.tbody1').on("click",".alonTr .innerbtn",function(){  //动态跟进的服务动态添加
            var data=$('.innerbtn').index(this);
            demo=data;
            $(this).next('.pop_box').find("td[class='runIdFirst']").attr('class',"runIdFirst"+demo);
            //.find("input[name='demo2[]']").attr('name','checkbox'+count2);  //checkbox接收的div
            console.log('当前为第'+demo+'个动态的服务添加');  //动态跟进的数据下拉服务
            $(this).next('.pop_box').slideDown('400');
        });
        $('.tbody1').on("click",".alonTr .closepop",function(){
            var aa=$(this).parent(".btn_a1");
            var bb=aa.prev("table");
            var cc=bb.find("input[type='text']");
            var total=0;
            console.log('执行2');
            // console.log('执行1');
            cc.each(  //循环input数组
                function (){
                    var input =$(this);  //循环每一个input元素
                    console.log(input.val()+"数据");
                    total=parseInt(total)+parseInt(input.val());  //查看循环中的每一个input的id
                }
            );
            console.log(total);
            var inputName="moneyShow"+demo;
            document.getElementById("moneyShow"+demo).value=total;

            console.log("当前需要修改的inputId为:"+inputName+"总价值为:"+total);
            $('.pop_box').slideUp('400');
        });

// 新增跟进
        var show_count = 10;  //至多跟进10次

        $(".AddTr").click(function () {
            var length = $(".tabInfo .tbody1>tr").length;
            //alert(length);
            if (length < show_count)
            {
                $(".tempDiv").html("");
                count++; //增加一次跟进  当前第多少个serviceKinds个visit
                console.log("当前为第"+count+"个动态跟进");
                //$(".model1 tbody .alonTr").clone().appendTo(".tabInfo .tbody1");  //动态新增跟进
                var divData= $(".model1 tbody .alonTr").clone();
                $(".tempDiv").html(divData);//暂存tr的 div
                $(".tempDiv").find("input[name='sky4[]']").attr('id','moneyShow'+count);
                $(".tempDiv").find("input[name='sky4[]']").attr('name','moneyVisit'+count);
                divData.appendTo(".tabInfo .tbody1");  //动态新增跟进
            }
            else{
                alert("目前单客户只能增加十个跟进");
            }
        });

// 新增内件
        var show_count2 = 20;
        $(".addtr2").click(function (){
            var length = $(this).parent('.btn_a1').prev('.neijian').children('.tbody2 tr').length;
            if (length < show_count2)
            {
                //存入钱的input name值为moneyVisit+demo
                count2++;  //显示当前是第几个服务跟进
                $(".tempDiv").html(""); //暂存tr的 div
                var divData= $(".model2 tbody tr").clone();
                $(".tempDiv").html(divData);//暂存tr的 div
                var selectName='firstVisitserviceValue'+count2;  //第一次跟进的所有服务数据修改
                $(".tempDiv").find("select[name='count1[]']").attr('name',selectName);  //隐藏option  style="visibility:hidden"
                console.log(count2);
                /*for(var i=0;i<4;i++){隐藏已经选择option
                 $(".tempDiv").find("option[value="+'i'+"]").remove();
                 }*/
                $(".tempDiv").find("input[name='demo2[]']").attr('name','checkbox'+count2);  //checkbox接收的div
                var temporary=$(".tempDiv tr td:eq(1)");
                temporary.html("<input type='text' value='0' name='show1'/>");
                temporary.attr('name','serviceTd'+count2+'');
                $(".tempDiv").find("select[name="+selectName+"]").change(function(){
                    //this.value =>表示onchange的
                    console.log('数据服务'+this.value);
                    if(this.value==0){        //清洁  第一次跟进的服务添加
                        temporary.html(qingjie);
                        temporary.find("input[name='matong']").attr('name','matong'+demo);
                        temporary.find("input[name='niaodou']").attr('name','niaodou'+demo);
                        temporary.find("input[name='shuipen']").attr('name','shuipen'+demo);
                        temporary.find("input[name='qingxinji']").attr('name','qingxinji'+demo);
                        temporary.find("input[name='zaoyeji']").attr('name','zaoyeji'+demo);

                        temporary.find("input[name='matonginput']").attr('name','matonginput'+demo);
                        temporary.find("input[name='niaodouinput']").attr('name','niaodouinput'+demo);
                        temporary.find("input[name='shuipeninput']").attr('name','shuipeninput'+demo);
                        temporary.find("input[name='qingxinjiinput']").attr('name','qingxinjiinput'+demo);
                        temporary.find("input[name='zaoyejiinput']").attr('name','zaoyejiinput'+demo);
                    }else if(this.value==1){ //租赁
                        temporary.html(zulin);
                        temporary.find("input[name='fengshanji']").attr('name','fengshanji'+demo);
                        temporary.find("input[name='TChaohua']").attr('name','TChaohua'+demo);
                        temporary.find("input[name='shuixingpenji']").attr('name','shuixingpenji'+demo);
                        temporary.find("input[name='yasuoxiangguan']").attr('name','yasuoxiangguan'+demo);

                        temporary.find("input[name='fengshanjiinput']").attr('name','fengshanji'+demo);
                        temporary.find("input[name='TChaohuainput']").attr('name','TChaohuainput'+demo);
                        temporary.find("input[name='shuixingpenjiinput']").attr('name','shuixingpenjiinput'+demo);
                        temporary.find("input[name='yasuoxiangguaninput']").attr('name','yasuoxiangguaninput'+demo);
                    }else if(this.value==2){ //灭虫
                        temporary.html(miechong);
                        temporary.find("input[name='laoshu']").attr('name','laoshu'+demo);
                        temporary.find("input[name='zhanglang']").attr('name','zhanglang'+demo);
                        temporary.find("input[name='guoying']").attr('name','guoying'+demo);
                        temporary.find("input[name='zumieyingdeng']").attr('name','zumieyingdeng'+demo);
                        temporary.find("input[name='laoshuzhanglang']").attr('name','laoshuzhanglang'+demo);
                        temporary.find("input[name='laoshuguoying']").attr('name','laoshuguoying'+demo);
                        temporary.find("input[name='zhanglangguoying']").attr('name','zhanglangguoying'+demo);
                        temporary.find("input[name='laoshuzhanglangguoying']").attr('name','laoshuzhanglangguoying'+demo);
                        temporary.find("input[name='laoshuzhanglangjiazudeng']").attr('name','laoshuzhanglangjiazudeng'+demo);
                        temporary.find("input[name='zhanglangguoyingjiazudeng']").attr('name','zhanglangguoyingjiazudeng'+demo);
                        temporary.find("input[name='laoshuzhanglangguoyingjiazudeng']").attr('name','laoshuzhanglangguoyingjiazudeng'+demo);

                        temporary.find("input[name='laoshuinput']").attr('name','laoshuinput'+demo);
                        temporary.find("input[name='zhanglanginput']").attr('name','zhanglanginput'+demo);
                        temporary.find("input[name='guoyinginput']").attr('name','guoyinginput'+demo);
                        temporary.find("input[name='zumieyingdenginput']").attr('name','zumieyingdenginput'+demo);
                        temporary.find("input[name='laoshuzhanglanginput']").attr('name','laoshuzhanglanginput'+demo);
                        temporary.find("input[name='laoshuguoyinginput']").attr('name','laoshuguoyinginput'+demo);
                        temporary.find("input[name='zhanglangguoyinginput']").attr('name','zhanglangguoyinginput'+demo);
                        temporary.find("input[name='laoshuzhanglangguoyinginput']").attr('name','laoshuzhanglangguoyinginput'+demo);
                        temporary.find("input[name='laoshuzhanglangjiazudenginput']").attr('name','laoshuzhanglangjiazudenginput'+demo);
                        temporary.find("input[name='zhanglangguoyingjiazudenginput']").attr('name','zhanglangguoyingjiazudenginput'+demo);
                        temporary.find("input[name='laoshuzhanglangguoyingjiazudenginput']").attr('name','laoshuzhanglangguoyingjiazudenginput'+demo);
                    }else if(this.value==3){ //飘盈香
                        temporary.html(piaoyingxiang);
                        temporary.find("input[name='minixiaoji']").attr('name','minixiaoji'+demo);
                        temporary.find("input[name='xiaoji']").attr('name','xiaoji'+demo);
                        temporary.find("input[name='zhongji']").attr('name','zhongji'+demo);
                        temporary.find("input[name='daji']").attr('name','daji'+demo);

                        temporary.find("input[name='minixiaojiinput']").attr('name','minixiaojiinput'+demo);
                        temporary.find("input[name='xiaojiinput']").attr('name','xiaojiinput'+demo);
                        temporary.find("input[name='zhongjiinput']").attr('name','zhongjiinput'+demo);
                        temporary.find("input[name='dajiinput']").attr('name','dajiinput'+demo);
                    }else if(this.value==4){  //甲醛
                        temporary.html(jiaquan);
                        temporary.find("input[name='chujiaquan']").attr('name','chujiaquan'+demo);
                        temporary.find("input[name='AC30']").attr('name','AC30'+demo);
                        temporary.find("input[name='PR10']").attr('name','PR10'+demo);
                        temporary.find("input[name='miniqingjiepao']").attr('name','miniqingjiepao'+demo);

                        temporary.find("input[name='chujiaquaninput']").attr('name','chujiaquaninput'+demo);
                        temporary.find("input[name='AC30input']").attr('name','AC30input'+demo);
                        temporary.find("input[name='PR10input']").attr('name','PR10input'+demo);
                        temporary.find("input[name='miniqingjiepaoinput']").attr('name','miniqingjiepaoinput'+demo);
                    }else if(this.value==5){  //纸品
                        temporary.html(zhipin);
                        temporary.find("input[name='cashouzhi']").attr('name','cashouzhi'+demo);
                        temporary.find("input[name='dajuancezhi']").attr('name','dajuancezhi'+demo);

                        temporary.find("input[name='cashouzhiinput']").attr('name','cashouzhiinput'+demo);
                        temporary.find("input[name='dajuancezhiinput']").attr('name','dajuancezhiinput'+demo);
                    }else if(this.value==6){  //一次性售卖
                        temporary.html();
                    }
                });
                divData.appendTo($(this).parent('.btn_a1').prev('.neijian').children('.tbody2'));  //第一次跟进的>=2的服务细节
                //$(".tempDiv").html("");//暂存tr的 div
                console.log("第一次跟进的第"+count2+"条服务修改");
                $(".tempDiv").html("");
            }
        });
        function setHtml(obj){
            $(".tempDiv tr td:eq(1)").html('<input type="text" value="0" />');
        }
        // 动态跟进的新增动态服务
        var show_count3 = 20;
        var count3 = 1;
        $(".tbody1").on("click",".dtadd",function (){
            // demo值为最新的跟进次序值
            //var SkyLength=document.getElementsByName("sky1[]").length;
            var length = $(".neijian .tbody2 tr").length;
            //alert(length);
            if (length < show_count3)
            {

                //console.log("动态新增第"+length+"条");
                $(".tempDiv").html(""); //暂存数据的div
                var divData=$('.model3 tbody tr').clone();
                $(".tempDiv").html(divData);
                $(".tempDiv").css({'width':"100%"});
                var temporary=$(".tempDiv tr td:eq(1)"); //第二个td的html 属性获取
               $(".tempDiv").find("input[name='demo2[]']").attr('name','checkbox'+count2);  //checkbox接收的div
              $(".tempDiv").find("select[name='serviceKinds[]']").attr('name','serviceKinds'+demo+'[]');  //第一个多选框
                var selectNameValue='serviceKinds'+demo+'[]';
                $(".tempDiv").find("select[name='"+selectNameValue+"']").change(function(){  //动态修改
                    if(this.value==0){        //清洁
                        temporary.html(qingjie);
                        temporary.find("input[name='matonginput']").attr('name','matonginput'+demo);
                        temporary.find("input[name='niaodouinput']").attr('name','niaodouinput'+demo);
                        temporary.find("input[name='shuipeninput']").attr('name','shuipeninput'+demo);
                        temporary.find("input[name='qingxinjiinput']").attr('name','qingxinjiinput'+demo);
                        temporary.find("input[name='zaoyejiinput']").attr('name','zaoyejiinput'+demo);

                        temporary.find("input[name='matong']").attr('name','matong'+demo);
                        temporary.find("input[name='niaodou']").attr('name','niaodou'+demo);
                        temporary.find("input[name='shuipen']").attr('name','shuipen'+demo);
                        temporary.find("input[name='qingxinji']").attr('name','qingxinji'+demo);
                        temporary.find("input[name='zaoyeji']").attr('name','zaoyeji'+demo);
                    }else if(this.value==1){ //租赁
                        temporary.html(zulin);
                        temporary.find("input[name='fengshanji']").attr('name','fengshanji'+demo);
                        temporary.find("input[name='TChaohua']").attr('name','TChaohua'+demo);
                        temporary.find("input[name='shuixingpenji']").attr('name','shuixingpenji'+demo);
                        temporary.find("input[name='yasuoxiangguan']").attr('name','yasuoxiangguan'+demo);

                        temporary.find("input[name='fengshanjiinput']").attr('name','fengshanjiinput'+demo);
                        temporary.find("input[name='TChaohuainput']").attr('name','TChaohuainput'+demo);
                        temporary.find("input[name='shuixingpenjiinput']").attr('name','shuixingpenjiinput'+demo);
                        temporary.find("input[name='yasuoxiangguaninput']").attr('name','yasuoxiangguaninput'+demo);
                    }else if(this.value==2){ //灭虫
                        temporary.html(miechong);
                        temporary.find("input[name='laoshu']").attr('name','laoshu'+demo);
                        temporary.find("input[name='zhanglang']").attr('name','zhanglang'+demo);
                        temporary.find("input[name='guoying']").attr('name','guoying'+demo);
                        temporary.find("input[name='zumieyingdeng']").attr('name','zumieyingdeng'+demo);
                        temporary.find("input[name='laoshuzhanglang']").attr('name','laoshuzhanglang'+demo);
                        temporary.find("input[name='laoshuguoying']").attr('name','laoshuguoying'+demo);
                        temporary.find("input[name='zhanglangguoying']").attr('name','zhanglangguoying'+demo);
                        temporary.find("input[name='laoshuzhanglangguoying']").attr('name','laoshuzhanglangguoying'+demo);
                        temporary.find("input[name='laoshuzhanglangjiazudeng']").attr('name','laoshuzhanglangjiazudeng'+demo);
                        temporary.find("input[name='zhanglangguoyingjiazudeng']").attr('name','zhanglangguoyingjiazudeng'+demo);
                        temporary.find("input[name='laoshuzhanglangguoyingjiazudeng']").attr('name','laoshuzhanglangguoyingjiazudeng'+demo);

                        temporary.find("input[name='laoshuinput']").attr('name','laoshuinput'+demo);
                        temporary.find("input[name='zhanglanginput']").attr('name','zhanglanginput'+demo);
                        temporary.find("input[name='guoyinginput']").attr('name','guoyinginput'+demo);
                        temporary.find("input[name='zumieyingdenginput']").attr('name','zumieyingdenginput'+demo);
                        temporary.find("input[name='laoshuzhanglanginput']").attr('name','laoshuzhanglanginput'+demo);
                        temporary.find("input[name='laoshuguoyinginput']").attr('name','laoshuguoyinginput'+demo);
                        temporary.find("input[name='zhanglangguoyinginput']").attr('name','zhanglangguoyinginput'+demo);
                        temporary.find("input[name='laoshuzhanglangguoyinginput']").attr('name','laoshuzhanglangguoyinginput'+demo);
                        temporary.find("input[name='laoshuzhanglangjiazudenginput']").attr('name','laoshuzhanglangjiazudenginput'+demo);
                        temporary.find("input[name='zhanglangguoyingjiazudenginput']").attr('name','zhanglangguoyingjiazudenginput'+demo);
                        temporary.find("input[name='laoshuzhanglangguoyingjiazudenginput']").attr('name','laoshuzhanglangguoyingjiazudenginput'+demo);
                    }else if(this.value==3){ //飘盈香
                        temporary.html(piaoyingxiang);
                        temporary.find("input[name='minixiaoji']").attr('name','minixiaoji'+demo);
                        temporary.find("input[name='xiaoji']").attr('name','xiaoji'+demo);
                        temporary.find("input[name='zhongji']").attr('name','zhongji'+demo);
                        temporary.find("input[name='daji']").attr('name','daji'+demo);

                        temporary.find("input[name='minixiaojiinput']").attr('name','minixiaojiinput'+demo);
                        temporary.find("input[name='xiaojiinput']").attr('name','xiaojiinput'+demo);
                        temporary.find("input[name='zhongjiinput']").attr('name','zhongjiinput'+demo);
                        temporary.find("input[name='dajiinput']").attr('name','dajiinput'+demo);
                    }else if(this.value==4){  //甲醛
                        temporary.html(jiaquan);
                        temporary.find("input[name='chujiaquan']").attr('name','chujiaquan'+demo);
                        temporary.find("input[name='AC30']").attr('name','AC30'+demo);
                        temporary.find("input[name='PR10']").attr('name','PR10'+demo);
                        temporary.find("input[name='miniqingjiepao']").attr('name','shuipen'+demo);

                        temporary.find("input[name='chujiaquaninput']").attr('name','chujiaquaninput'+demo);
                        temporary.find("input[name='AC30input']").attr('name','AC30input'+demo);
                        temporary.find("input[name='PR10input']").attr('name','PR10input'+demo);
                        temporary.find("input[name='miniqingjiepaoinput']").attr('name','miniqingjiepaoinput'+demo);
                    }else if(this.value==5){  //纸品
                        temporary.html(zhipin);
                        temporary.find("input[name='cashouzhi']").attr('name','cashouzhi'+demo);
                        temporary.find("input[name='dajuancezhi']").attr('name','dajuancezhi'+demo);

                        temporary.find("input[name='cashouzhiinput']").attr('name','cashouzhiinput'+demo);
                        temporary.find("input[name='dajuancezhiinput']").attr('name','dajuancezhiinput'+demo);
                    }else if(this.value==6){  //一次性售卖
                        temporary.html("");
                    }
                });
                $(".tempDiv").find("input[name='serviceCounts[]']").attr('name','serviceCounts'+demo+'[]');  //第二个input 框
                $(".tempDiv").find("input[name='serviceMoney[]']").attr('name','serviceMoney'+demo+'[]');   //第三个input框
                divData.appendTo($(this).parent('.btn_a1').prev('.neijian').children('.tbody2'));
                $(".tempDiv").html(""); //暂存数据的div
                $(".tempDiv").html(""); //清空暂存的div
                //console.log('总计'+demo);
            }
        });
        function deltr(opp) {  //删除动态新增的跟进
            var length = $(".tabInfo .tbody1>tr").length;
            //alert(length);
            if (length <= 1) {
                alert("至少保留一行表单");
            } else {
                count--;
                $(opp).parent().parent().remove();//移除当前行
            }
        }

        function deltr2(opp) {
            var length = $(this).parent('.btn_a1').prev('.neijian').children('.tbody2 tr').length;
            //alert(length);
            if (length <= 1) {
                alert("至少保留一行");
            } else {
                $(opp).parent().parent().remove();//移除当前行
            }
        }


        function deltr3(opp) {
            var length = $('.neijian .tbody2 tr').length;
            //alert(length);
            if (length <= 1) {
                alert("至少保留一行");
            } else {
                count2--;
                $(opp).parent().parent().remove();//移除当前行

            }
        }

        function show_subSecond(pin){
            console.log(pin);
            var classValue="runIdFirst"+demo;
          var whileHtml=  $("."+classValue+"").html(html);
            var html='';
            if(pin==0){
                html="<input type='checkbox' style='width: 30px;' name='matong' value='1'>马桶<input style='width: 60px;' name='matonginput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='niaodou' value='1'>尿斗<input style='width: 60px;' name='niaodouinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='datashuipen' value='1'>水盆<input style='width: 60px;' name='datashuipeninput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='qingxin' value='1'>清新机<input style='width: 60px;' name='qingxininput' value='' placeholder='数量'/><br/>" +
                    "<input type='checkbox' style='width: 30px;' name='dzaoye' value='1'>皂液机<input style='width: 60px;' name='dzaoyeinput' value='' placeholder='数量'/>";
                whileHtml=  $("."+classValue+"").html(html);
                whileHtml.find("input[name='matonginput']").attr('name','matonginput'+demo);
                whileHtml.find("input[name='niaodouinput']").attr('name','niaodouinput'+demo);
                whileHtml.find("input[name='shuipeninput']").attr('name','shuipeninput'+demo);
                whileHtml.find("input[name='qingxinjiinput']").attr('name','qingxinjiinput'+demo);
                whileHtml.find("input[name='zaoyejiinput']").attr('name','zaoyejiinput'+demo);

                whileHtml.find("input[name='matong']").attr('name','matong'+demo);
                whileHtml.find("input[name='niaodou']").attr('name','niaodou'+demo);
                whileHtml.find("input[name='shuipen']").attr('name','shuipen'+demo);
                whileHtml.find("input[name='qingxinji']").attr('name','qingxinji'+demo);
                whileHtml.find("input[name='zaoyeji']").attr('name','zaoyeji'+demo);

            }
            else if(pin==1){
                html="<input type='checkbox' style='width: 30px;' name='fengshanji' value='1'>风扇机<input style='width: 60px;' name='fengshanjiinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='TChaohua' value='1'>TC豪华<input style='width: 60px;' name='TChaohuainput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='shuixingpenji' value='1'>水性喷机<input style='width: 60px;' name='shuixingpenjiinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='yasuoxiangguan' value='1'>压缩香罐<input style='width: 60px;' name='yasuoxiangguaninput' value='' placeholder='数量'/>"
                whileHtml=  $("."+classValue+"").html(html);
                whileHtml.find("input[name='fengshanji']").attr('name','fengshanji'+demo);
                whileHtml.find("input[name='TChaohua']").attr('name','TChaohua'+demo);
                whileHtml.find("input[name='shuixingpenji']").attr('name','shuixingpenji'+demo);
                whileHtml.find("input[name='yasuoxiangguan']").attr('name','yasuoxiangguan'+demo);

                whileHtml.find("input[name='fengshanjiinput']").attr('name','fengshanjiinput'+demo);
                whileHtml.find("input[name='TChaohuainput']").attr('name','TChaohuainput'+demo);
                whileHtml.find("input[name='shuixingpenjiinput']").attr('name','shuixingpenjiinput'+demo);
                whileHtml.find("input[name='yasuoxiangguaninput']").attr('name','yasuoxiangguaninput'+demo);

            }
            else if(pin==2){
                html="<input type='checkbox' style='width: 30px;' name='laoshu' value='1'>老鼠<input style='width: 60px;' name='laoshuinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='zhanglang' value='1'>蟑螂<input style='width: 60px;' name='zhanglanginput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='guoying' value='1'>果蝇<input style='width: 60px;' name='guoyinginput' value='' placeholder='数量'/>"
                    +
                    "<input type='checkbox' style='width: 30px;' name='zumieyingdeng' value='1'>租灭蝇灯<input style='width: 60px;' name='zumieyingdenginput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='laoshuzhanglang' value='1'>老鼠蟑螂<input style='width: 60px;' name='laoshuzhanglanginput' value='' placeholder='数量'/>"
                    +
                    "<input type='checkbox' style='width: 30px;' name='laoshuguoying' value='1'>老鼠果蝇<input style='width: 60px;' name='laoshuguoyinginput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='zhanglangguoying' value='1'>蟑螂果蝇<input style='width: 60px;' name='zhanglangguoyinginput' value='' placeholder='数量'/>"
                    +
                    "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangguoying' value='1'>老鼠蟑螂果蝇<input style='width: 60px;' name='laoshuzhanglangguoyinginput' value='' placeholder='数量'/><br/>" +
                    "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangjiazudeng' value='1'>老鼠蟑螂+租灯<input style='width: 60px;' name='laoshuzhanglangjiazudenginput' value='' placeholder='数量'/>"
                    +
                    "<input type='checkbox' style='width: 30px;' name='zhanglangguoyingjiazudeng' value='1'>蟑螂果蝇+租灯<input style='width: 60px;' name='zhanglangguoyingjiazudenginput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='laoshuzhanglangguoyingjiazudeng' value='1'>老鼠蟑螂果蝇+租灯<input style='width: 60px;' name='laoshuzhanglangguoyingjiazudenginput' value='' placeholder='数量'/>"
                whileHtml=  $("."+classValue+"").html(html);
                whileHtml.find("input[name='laoshu']").attr('name','laoshu'+demo);
                whileHtml.find("input[name='zhanglang']").attr('name','zhanglang'+demo);
                whileHtml.find("input[name='guoying']").attr('name','guoying'+demo);
                whileHtml.find("input[name='zumieyingdeng']").attr('name','zumieyingdeng'+demo);
                whileHtml.find("input[name='laoshuzhanglang']").attr('name','laoshuzhanglang'+demo);
                whileHtml.find("input[name='laoshuguoying']").attr('name','laoshuguoying'+demo);
                whileHtml.find("input[name='zhanglangguoying']").attr('name','zhanglangguoying'+demo);
                whileHtml.find("input[name='laoshuzhanglangguoying']").attr('name','laoshuzhanglangguoying'+demo);
                whileHtml.find("input[name='laoshuzhanglangjiazudeng']").attr('name','laoshuzhanglangjiazudeng'+demo);
                whileHtml.find("input[name='zhanglangguoyingjiazudeng']").attr('name','zhanglangguoyingjiazudeng'+demo);
                whileHtml.find("input[name='laoshuzhanglangguoyingjiazudeng']").attr('name','laoshuzhanglangguoyingjiazudeng'+demo);

                whileHtml.find("input[name='laoshuinput']").attr('name','laoshuinput'+demo);
                whileHtml.find("input[name='zhanglanginput']").attr('name','zhanglanginput'+demo);
                whileHtml.find("input[name='guoyinginput']").attr('name','guoyinginput'+demo);
                whileHtml.find("input[name='zumieyingdenginput']").attr('name','zumieyingdenginput'+demo);
                whileHtml.find("input[name='laoshuzhanglanginput']").attr('name','laoshuzhanglanginput'+demo);
                whileHtml.find("input[name='laoshuguoyinginput']").attr('name','laoshuguoyinginput'+demo);
                whileHtml.find("input[name='zhanglangguoyinginput']").attr('name','zhanglangguoyinginput'+demo);
                whileHtml.find("input[name='laoshuzhanglangguoyinginput']").attr('name','laoshuzhanglangguoyinginput'+demo);
                whileHtml.find("input[name='laoshuzhanglangjiazudenginput']").attr('name','laoshuzhanglangjiazudenginput'+demo);
                whileHtml.find("input[name='zhanglangguoyingjiazudenginput']").attr('name','zhanglangguoyingjiazudenginput'+demo);
                whileHtml.find("input[name='laoshuzhanglangguoyingjiazudenginput']").attr('name','laoshuzhanglangguoyingjiazudenginput'+demo);


            }
            else if(pin==3){
                html="<input type='checkbox' style='width: 30px;' name='minixiaoji' value='1'>迷你小机<input style='width: 60px;' name='minixiaojiinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='xiaoji' value='1'>小机<input style='width: 60px;' name='xiaojiinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='zhongji' value='1'>中机<input style='width: 60px;' name='zhongjiinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='daji' value='1'>大机<input style='width: 60px;' name='dajiinput' value='' placeholder='数量'/>"
                whileHtml=  $("."+classValue+"").html(html);
                whileHtml.find("input[name='minixiaoji']").attr('name','minixiaoji'+demo);
                whileHtml.find("input[name='xiaoji']").attr('name','xiaoji'+demo);
                whileHtml.find("input[name='zhongji']").attr('name','zhongji'+demo);
                whileHtml.find("input[name='daji']").attr('name','daji'+demo);

                whileHtml.find("input[name='minixiaojiinput']").attr('name','minixiaojiinput'+demo);
                whileHtml.find("input[name='xiaojiinput']").attr('name','xiaojiinput'+demo);
                whileHtml.find("input[name='zhongjiinput']").attr('name','zhongjiinput'+demo);
                whileHtml.find("input[name='dajiinput']").attr('name','dajiinput'+demo);

            }
            else if(pin==4){
                html="<input type='checkbox' style='width: 30px;' name='chujiaquan' value='1'>除甲醛<input style='width: 60px;' name='chujiaquaninput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='AC30' value='1'>AC30<input style='width: 60px;' name='AC30input' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='PR10' value='1'>PR10<input style='width: 60px;' name='PR10input' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='miniqingjiepao' value='1'>迷你清洁炮<input style='width: 60px;' name='miniqingjiepaoinput' value='' placeholder='数量'/>"
                whileHtml=  $("."+classValue+"").html(html);
                whileHtml.find("input[name='chujiaquan']").attr('name','chujiaquan'+demo);
                whileHtml.find("input[name='AC30']").attr('name','AC30'+demo);
                whileHtml.find("input[name='PR10']").attr('name','PR10'+demo);
                whileHtml.find("input[name='miniqingjiepao']").attr('name','shuipen'+demo);

                whileHtml.find("input[name='chujiaquaninput']").attr('name','chujiaquaninput'+demo);
                whileHtml.find("input[name='AC30input']").attr('name','AC30input'+demo);
                whileHtml.find("input[name='PR10input']").attr('name','PR10input'+demo);
                whileHtml.find("input[name='miniqingjiepaoinput']").attr('name','miniqingjiepaoinput'+demo);

            }
            else if(pin==5){
                html="<input type='checkbox' style='width: 30px;' name='cashouzhi' value='1'>擦手纸<input style='width: 60px;' name='cashouzhiinput' value='' placeholder='数量'/>" +
                    "<input type='checkbox' style='width: 30px;' name='dajuancezhi' value='1'>大卷厕纸<input style='width: 60px;' name='dajuancezhiinput' value='' placeholder='数量'/>"
                whileHtml=  $("."+classValue+"").html(html);
                whileHtml.find("input[name='cashouzhi']").attr('name','cashouzhi'+demo);
                whileHtml.find("input[name='dajuancezhi']").attr('name','dajuancezhi'+demo);

                whileHtml.find("input[name='cashouzhiinput']").attr('name','cashouzhiinput'+demo);
                whileHtml.find("input[name='dajuancezhiinput']").attr('name','dajuancezhiinput'+demo);

            }
            else if(pin==6){
                html="<input type='checkbox' style='width: 30px;' name='wupin' value='1'>物品<input style='width: 60px;' name='' value='' placeholder='数量'/>"
            }
            else if(pin==7){
                html="<div></div>";
            }
            console.log();

        }

</script>


<?php $this->renderPartial('//site/removedialog'); ?>
<?php
$js = "
$('#SalesForm_customer_create_date,#first1').on('change',function() {
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


function IsDate(val) {
	var d = new Date(val);
	return (!isNaN(d.valueOf()));
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
function formatDate(val) {
	var day = '00'+val.getDate();
	var month = '00'+(val.getMonth()+1);
	var year = val.getFullYear();
	return year + '/' + month.slice(-2) + '/' +day.slice(-2);
}
}
";

$js = Script::genDeleteData(Yii::app()->createUrl('sales/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);

if ($model->scenario!='view') {
    $js = Script::genDatePicker(array(
        'SalesForm_customer_create_date',
        'first1',
    ));
    Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>
