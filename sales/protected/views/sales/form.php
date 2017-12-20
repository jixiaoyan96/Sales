<?php
$this->pageTitle=Yii::app()->name . ' - sales Form';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'sales-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('sales','Sales Form'); ?></strong>
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
		<?php 
			if ($model->scenario!='new' && $model->scenario!='view') {
				echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Another'), array(
					'submit'=>Yii::app()->createUrl('sales/new')));
			}
		?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('sales/index')));
		?>

		<?php echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Print'), array(
				'submit'=>Yii::app()->createUrl('sales/print')));
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
	<div class="box box-info">
		<div class="box-body">
			<?php echo $form->hiddenField($model, 'scenario'); ?>
			<?php echo $form->hiddenField($model, 'id'); ?>
			<?php echo CHtml::hiddenField('dtltemplate'); ?>
			<div class="form-group">
				<?php echo  $form->labelEx($model,'code',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model, 'code',
							array('size'=>40,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
					); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'time',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-3">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<?php echo $form->textField($model, 'time',
								array('class'=>'form-control pull-right','readonly'=>($model->scenario=='view'),));
						?>
					</div>
				</div>
			</div>
		</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'name',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
				<?php echo $form->textField($model, 'name',
					array('size'=>40,'maxlength'=>250,'readonly'=>($model->scenario=='view'))
				); ?>
				</div>
			</div>
		<div class="form-group">
			<?php echo $form->labelEx($model,'region',array('class'=>"col-sm-2 control-label")); ?>
			<div class="col-sm-7">
				<?php echo $form->textField($model, 'region',
						array('size'=>40,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
				); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model,'address',array('class'=>"col-sm-2 control-label")); ?>
			<div class="col-sm-7">
				<?php echo $form->textField($model, 'address',
						array('size'=>40,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
				); ?>
			</div>
		</div>
		<div class="box">
			<div class="box-body table-responsive">
				<legend><?php echo Yii::t('sales','Good list'); ?></legend>
				<?php $this->widget('ext.layout.TableView2Widget', array(
						'model'=>$model,
						'attribute'=>'detail',
						'viewhdr'=>'//sales/_formhdr',
						'viewdtl'=>'//sales/_formdtl',
						'gridsize'=>'24',
						'height'=>'200',
				));
				?>
			</div>
		</div>
</section>

<?php $this->renderPartial('//site/removedialog'); ?>

<?php
$js = Script::genDeleteData(Yii::app()->createUrl('sales/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);




if ($model->scenario!='view') {
	$js = "
$('table').on('click','#btnDelRow', function() {
	$(this).closest('tr').find('[id*=\"_uflag\"]').val('D');
	$(this).closest('tr').hide();
});
	";
	Yii::app()->clientScript->registerScript('removeRow', $js, CClientScript::POS_READY);

	$js = "
$(document).ready(function(){
	var ct = $('#tblDetail tr').eq(1).html();
	$('#dtltemplate').attr('value',ct);
	$('.deadline').datepicker({autoclose: true, format: 'yyyy/mm/dd'});
});

$('#btnAddRow').on('click',function() {
	var r = $('#tblDetail tr').length;
	if (r>0) {
		var nid = '';
		var ct = $('#dtltemplate').val();
		$('#tblDetail tbody:last').append('<tr>'+ct+'</tr>');
		$('#tblDetail tr').eq(-1).find('[id*=\"LogisticForm_\"]').each(function(index) {
			var id = $(this).attr('id');
			var name = $(this).attr('name');

			var oi = 0;
			var ni = r;
			id = id.replace('_'+oi.toString()+'_', '_'+ni.toString()+'_');
			$(this).attr('id',id);
			name = name.replace('['+oi.toString()+']', '['+ni.toString()+']');
			$(this).attr('name',name);
			if (id.indexOf('_id') != -1) $(this).attr('value','0');
			if (id.indexOf('_logid') != -1) $(this).attr('value','0');
			if (id.indexOf('_task') != -1) {
				$(this).attr('value','0');
				nid = id;
			}
			if (id.indexOf('_qty') != -1) $(this).attr('value','');
			if (id.indexOf('_finish') != -1) $(this).attr('value','N');
			if (id.indexOf('_deadline') != -1) {
				$(this).attr('value','');
				$(this).datepicker({autoclose: true, format: 'yyyy/mm/dd'});
			}
		});
		if (nid != '') {
			var topos = $('#'+nid).position().top;
			$('#tbl_detail').scrollTop(topos);
		}
	}
});
	";
	Yii::app()->clientScript->registerScript('addRow', $js, CClientScript::POS_READY);

}
if ($model->scenario!='view') {
	$js = Script::genDatePicker(array(
			'SalesForm_time',
			'SalesForm_deadline',
	));
	Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}
?>

<?php $this->endWidget(); ?>

