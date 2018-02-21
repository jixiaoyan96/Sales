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

                <?php echo $form->labelEx($model,'order_info_date',array('class'=>"col-sm-2 control-label")); ?>

                <div class="col-sm-3">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php echo $form->textField($model, 'order_info_date',
                            array('class'=>'form-control pull-right','readonly'=>($model->scenario=='view'),'placeholder'=>'默认为当前时间'));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'order_info_seller_name',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'order_info_seller_name',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'order_info_money_total',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'order_info_money_total',
                        array('size'=>50,'maxlength'=>100,'id'=>'order_count_all','readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'order_info_rural',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'order_info_rural',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'order_info_rural_location',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model,'order_info_rural_location',
                        array('size'=>50,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
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

<a id="aa">点击打印第二部分内容</a>
<script>

    (function ($) {
        var printAreaCount = 0;
        $.fn.printArea = function () {
            var ele = $(this);
            var idPrefix = "printArea_";
            removePrintArea(idPrefix + printAreaCount);
            printAreaCount++;
            var iframeId = idPrefix + printAreaCount;
            var iframeStyle = 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;';
            iframe = document.createElement('IFRAME');
            $(iframe).attr({
                style: iframeStyle,
                id: iframeId
            });
            document.body.appendChild(iframe);
            var doc = iframe.contentWindow.document;
            $(document).find("link").filter(function () {
                return $(this).attr("rel").toLowerCase() == "stylesheet";
            }).each(
                function () {
                    doc.write('<link type="text/css" rel="stylesheet" href="'
                        + $(this).attr("href") + '" >');
                });
            doc.write('<div class="' + $(ele).attr("class") + '">' + $(ele).html()
                + '</div>');
            doc.close();
            var frameWindow = iframe.contentWindow;
            frameWindow.close();
            frameWindow.focus();
            frameWindow.print();
        };
        var removePrintArea = function (id) {
            $("iframe#" + id).remove();
        };
    })(jQuery);





    //在计算单个订单总价的同时 进行计算所有订单的价格的总和
    $(function(){
        $("#aa").click(function(){
            $(".addData").printArea();
        });
        function hello(){
            var total= $("input[class='totalCount']");
            var Count=0;
                for(var i=0;i<total.length;i++){
                    var temp=total.eq(i).val();
                    Count+=parseInt(temp);
                }
            $("#order_count_all").val(Count);
        }
        window.setInterval(function(){
            hello();
        }, 1000);
        timestamp =(new Date()).valueOf();
        $("#firstCodeGet").val(timestamp);
        var AllDataCount=0;
        var demo=0;
// 新增表单
        var show_count = 10;  //至多跟进10次
        var count = 1;
        $(".AddTr").click(function () {
            var length = $(".tabInfo .tbody1>tr").length;
            if (length < show_count)
            {
                timestampS =(new Date()).valueOf();
                $("#tempDiv").html();
                var aa=$(".model1 tbody .alonTr").clone();
                $("#tempDiv").html(aa);
                var valueG= aa.find("input[class='firstCodeGet2']");
                valueG.val(timestampS);
                aa.appendTo(".tabInfo .tbody1");
                $("#tempDiv").html();
            }
        });
        var timestamp =(new Date()).valueOf();
    });
    function deltr(opp){
        var length = $(".tabInfo .tbody1>tr").length;
        if (length <= 1) {
            alert("至少保留一行表单");
        } else {
            $(opp).parent().parent().remove();//移除当前行
        }
    }
    function firstTotal(temp){
       /* var valueG= $(temp).parent("td").prev("td").find("input[type='text']").val();
        var valueF= $(temp).parent("td").prev("td").prev("td").find("input[type='text']").val();
        var total=parseInt(obj)+parseInt(valueG)+parseInt(valueF);
        $(temp).parent("td").next("td").find("input[type='text']").val(total);*/
        var total=$(temp).parent("td").parent("tr").children("td").find("input[type='text']");
        var totalValue=0;
        totalValue=parseInt(total.eq(2).val())*parseInt(total.eq(4).val())-parseInt(total.eq(3).val());
        $(temp).parent("td").parent("tr").children("td").find("input[type='text']").eq(5).val(totalValue);
    }
</script>

<style>
table .normTbe{table-layout: fixed;width: 100%;}
    input:focus,textarea:focus{border:1px solid #9ab6d6;}
    .whiteBg{background: #fff;}
    .normTbe{border:1px solid black; background-color:white;}
    .normTbe td,.normTbe th{border:1px solid black;padding: 15px;text-align: center;}
    .normTbe input{width: 80%;text-align: center;}
    .addData{width: auto;padding: 0 20px; margin: 0 auto;clear: both;}
    .hideTr{background: #ddd;}
    .tempDiv{width:0%;  height:0px;  border: 0px solid red}
</style>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  Yii::t('quiz','please follow the rules to fill the field!');?>
<div class="addData">
    <table cellspacing="0" cellpadding="0" border="0" class="normTbe model1 hide">
        <tbody>
        <tr class="alonTr">  <!--第二层以及更多的跟进表单数据-->
            <td><input type="text" class="firstCodeGet2" value="" placeholder="订货编号" name="orderCode[]"/></td>
            <td ><input type="text" value="" placeholder="货品名字" name="orderName[]" /></td>
            <td><input type="text" value="0" placeholder="货品单价" onblur="firstTotal(this);" name="orderPrice[]" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
            <td><input type="text" value="0" placeholder="货品优惠" onblur="firstTotal(this);" name="orderFree[]" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
            <td ><input type="text" value="0" placeholder="货品数量" onblur="firstTotal(this);" name="orderCount[]" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
            <td><input type="text" class="totalCount" value="0" placeholder="货品总价" name="orderTotal[]" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
            <td>
                <br /><a class="text_a" href="javascript:;" onClick="deltr(this)">删除22</a>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="itemInfo">
        <table cellspacing="0" cellpadding="0" border="0" class="normTbe tabInfo">
            <thead>
            <tr>
                <th>订货编号</th>
                <th>货品名字</th>
                <th>货品单价</th>
                <th>货品优惠</th>
                <th>货品数量</th>
                <th>货品总价</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="tbody1">
            <tr>  <!--第一层的表单拜访数据-->
                <td><input type="text" id="firstCodeGet" value="" placeholder="订货编号" name="orderCode[]"/></td>
                <td ><input type="text" value="" placeholder="货品名字" name="orderName[]"/></td>
                <td><input type="text" value="0" placeholder="货品单价11" onblur="firstTotal(this);" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td><input type="text" value="0" placeholder="货品优惠" name="orderFree[]" onblur="firstTotal(this);" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td ><input type="text" value="0" placeholder="货品数量" name="orderCount[]" onblur="firstTotal(this);" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td><input class="totalCount" type="text" value="0" placeholder="货品总价" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" name="orderTotal[]"/></td>
                <td>
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
</div>

<?php $this->renderPartial('//site/removedialog'); ?>
<?php
$js = "
$('#SalesorderForm_order_info_date').on('change',function() {
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

$js = Script::genDeleteData(Yii::app()->createUrl('salesorder/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);

if ($model->scenario!='view') {
    $js = Script::genDatePicker(array(
        'SalesorderForm_order_info_date',
    ));
    Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>
