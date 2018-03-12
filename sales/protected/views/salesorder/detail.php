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
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="btn-group" role="group">
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('salesorder/index')));
                ?>
                <!--                <?php /*if ($model->scenario!='view'): */?>
                    <?php /*echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
                        'submit'=>Yii::app()->createUrl('salesorder/save')));
                    */?>
                <?php /*endif */?>
                <?php /*if ($model->scenario=='edit'): */?>
                    --><?php /*echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
                            'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
                    );
                    */?>
                <!--  --><?php /*endif */?>
            </div>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-body">
            <?php echo $form->hiddenField($model,'scenario'); ?>
            <?php echo $form->hiddenField($model,'id'); ?>
        </div>
        <input id="btnPrint" type="button" value="打印" onclick="javascript:window.print();" />
        <input id="btnPrint" type="button" value="打印预览" onclick="preview(1);"/>
        <?php $dataR=Quiz::printDetail($model->id);
                    echo "<table class='table table-bordered'>";
                    if(isset($dataR)&&!empty($dataR)){
                        echo "<tr><td colspan='5'>订单信息</td></tr>";
                        echo "<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>";
                    }
                    echo "</table>";
        ?>
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
</section>

<?php $this->renderPartial('//site/removedialog');

$js = Script::genDeleteData(Yii::app()->createUrl('salesorder/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

?>

<?php $this->endWidget(); ?>
