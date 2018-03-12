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
        <strong><?php echo Yii::t('quiz','Sales info List'); ?></strong>
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
                if (Yii::app()->user->validRWFunction('HK01'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Sales video Record'), array(
                        'submit'=>Yii::app()->createUrl('Salesvideo/new'),
                    ));
                ?>
            </div>
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('HK07'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','lookThrough sellers video'), array(
                        'submit'=>Yii::app()->createUrl('Salesvideo/sellersIndex'),
                    ));
                ?>
            </div>
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('HK01'))
                    echo TbHtml::button('<span class="fa fa-file-o">当前员工的入职时间:</span> '.Quiz::StartWorkDate(), array(
                        'submit'=>'#')
                    );
                ?>
            </div>
        </div>
    </div>
    <?php $this->widget('ext.layout.QuizStartWidget', array(
        'title'=>Yii::t('quiz','sales video List'),
        'model'=>$model,
        'viewhdr'=>'//Salesvideo/_listhdr',
        'viewdtl'=>'//Salesvideo/_listdtl',
    ));

    ?>
   <!-- --><?php /*$this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('quiz','sales video List'),
        'model'=>$model,
        'viewhdr'=>'//Salesvideo/_listhdr',
        'viewdtl'=>'//Salesvideo/_listdtl',
        'gridsize'=>'24',
        'height'=>'600',
        'search'=>array(
            'video_info_date',
            'seller_notes',
        ),
    ));
    */?>
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

<?php
$js = "
$('#startDate,#endDate').on('change',function() {
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

if ($model->scenario!='view') {
    $js = Script::genDatePicker(array(
        'startDate',
        'endDate',
    ));
    Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}

?>

