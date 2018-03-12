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
        <strong><?php echo Yii::t('quiz','order data print'); ?></strong>
    </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="btn-group" role="group">
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('salesorder/index')));
                ?>
<!--     <?php /*if ($model->scenario!='view'): */?>
                    <?php /*echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
                        'submit'=>Yii::app()->createUrl('salesorder/save')));
                    */?>-->
                <?php /*endif */?>
                <?php if ($model->scenario=='edit'): ?>
                    <?php echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
                            'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
                    ); ?>
              <?php endif ?>
            </div>
        </div>
    </div>
    <script>
        function preview(oper)
        {
            if (oper <10)
            {
                bdhtml=window.document.body.innerHTML;//获取当前页的html代码
                sprnstr="<!–startprint"+oper+"–>";//设置打印开始区域
                eprnstr="<!–endprint"+oper+"–>";//设置打印结束区域
                prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18);//从开始代码向后取html
                prnhtmlprnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
                window.document.body.innerHTML=prnhtml;
                window.print();
                window.document.body.innerHTML=bdhtml;
            } else {
                window.print();
            }
        }
    </script>
    <input id="btnPrint" type="button" value="打印" onclick="javascript:window.print();" />
    <input id="btnPrint" type="button" value="打印预览" onclick="preview(1);"/>
    <!–startprint1–>
    <div class="box box-info">
        <div class="box-body">
            <?php echo $form->hiddenField($model, 'scenario'); ?>
            <?php echo $form->hiddenField($model, 'id'); ?>
        </div>
        <?php
        $dataReturn=Quiz::printData($model->id);
        echo "<table class='table table-bordered'>";
        echo "<tr><td colspan='2'>客户姓名:".$dataReturn['mainData']['order_customer_name']."</td> <td colspan='2'>下单区域、街道:".$dataReturn['mainData']['order_customer_rural'].','.$dataReturn['mainData']['order_customer_street']."</td>
        <td>下单总额:".$dataReturn['mainData']['order_customer_total_money']."</td><td>下单日期:".$dataReturn['mainData']['order_info_date']."</td></tr>";
        echo "<tr> <td>序列</td><td>订单编号</td> <td>订货编号</td> <td>订货数量</td> <td>订货单价</td> <td>订单优惠</td> <td>订单总额</td></tr>";
        if(count($dataReturn['order_info'])>0){
            for($i=0;$i<count($dataReturn['order_info']);$i++){
                echo "<tr><td>".($i+1)."</td><td>".$dataReturn['order_info'][$i]['order_info_code_number']."</td> <td>".$dataReturn['order_info'][$i]['order_goods_code_number']."</td>
                <td>".$dataReturn['order_info'][$i]['order_count']."</td> <td>".$dataReturn['order_info'][$i]['order_per_price']."</td>
                 <td>".$dataReturn['order_info'][$i]['order_free']."</td> <td>".$dataReturn['order_info'][$i]['order_info_money_total']."</td></tr>";
            }
        }else{
            echo "<tr> <td colspan='7'>该客户本次没有下单记录</td></tr>";
        }
        echo "<tr> <td colspan='7'>一共".$dataReturn['length']."条</td></tr>";

        echo "</table>";
        ?>
    </div>
    <!–endprint1–>
</section>

<?php $this->renderPartial('//site/removedialog');
$js = Script::genDeleteData(Yii::app()->createUrl('salesorder/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>
