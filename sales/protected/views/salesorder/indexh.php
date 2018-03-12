<?php
$this->pageTitle=Yii::app()->name . ' - Nature';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'code-list',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('quiz','Sales customer order history list'); ?></strong>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('HK01'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('quiz','Add sales order'), array(
                        'submit'=>Yii::app()->createUrl('Salesorder/new'),
                    ));
                ?>
            </div>
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('HK01'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('quiz','browse order history'), array(
                        'submit'=>Yii::app()->createUrl('Salesorder/Index'),
                    ));
                ?>
            </div>
        </div>
    </div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('quiz','Sales customer order history list'),
        'model'=>$model,
        'viewhdr'=>'//salesorder/_hlisthdr',
        'viewdtl'=>'//salesorder/_hlistdtl',
        'gridsize'=>'24',
        'height'=>'600',
        'search'=>array(
            'order_customer_name',
            'order_customer_rural',
            'order_customer_street',
            'order_customer_total_money'
        ),
    ));
    ?>
</section>
<?php
echo $form->hiddenField($model,'pageNum');
echo $form->hiddenField($model,'totalRow');
echo $form->hiddenField($model,'orderField');
echo $form->hiddenField($model,'orderType');
?>
<?php $this->endWidget(); ?>

<?php
$js = Script::genTableRowClick();
Yii::app()->clientScript->registerScript('rowClick',$js,CClientScript::POS_READY);
?>
