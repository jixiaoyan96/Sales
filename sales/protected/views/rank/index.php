<?php
$this->pageTitle=Yii::app()->name . ' - rank';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'rank-form',
    'action'=>Yii::app()->createUrl('rank/index_s'),
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('report','Sales Rank'); ?></strong>
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
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php echo TbHtml::button(Yii::t('misc','Submit'), array(
                    'submit'=>Yii::app()->createUrl('rank/index_s')));
                ?>
            </div>
        </div></div>
    <div class="box box-info">
        <div class="box-body">
            <!--			--><?php //echo $form->hiddenField($model, 'id'); ?>
            <!--			--><?php //echo $form->hiddenField($model, 'name'); ?>
            <!--			--><?php //echo $form->hiddenField($model, 'fields'); ?>
            <!--			--><?php //echo $form->hiddenField($model, 'form'); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'city',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'city',
                        $city,
                        array('disabled'=>($model->scenario=='view'))
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'season',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->dropDownList($model, 'season',
                        $season,
                        array('disabled'=>($model->scenario=='view'))
                    ); ?>
                </div>
            </div>


        </div>
    </div>
</section>

<?php
$url=Yii::app()->createUrl('report/city');
$js = <<<EOF

EOF;
?>
<?php
Yii::app()->clientScript->registerScript('changestyle',$js,CClientScript::POS_READY);
$js = Script::genLookupSearchEx();
Yii::app()->clientScript->registerScript('lookupSearch',$js,CClientScript::POS_READY);

$js = Script::genLookupButtonEx('btnStaff', 'staff', 'staffs', 'staffs_desc',
    array(),
    true
);
Yii::app()->clientScript->registerScript('lookupStaffs',$js,CClientScript::POS_READY);

$js = Script::genLookupSelect();
Yii::app()->clientScript->registerScript('lookupSelect',$js,CClientScript::POS_READY);

$js = Script::genDatePicker(array(
    'ReportXS01Form_start_dt',
    'ReportXS01Form_end_dt',
));
Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>

</div><!-- form -->

