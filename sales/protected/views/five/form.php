<?php
$this->pageTitle=Yii::app()->name . ' - five Form';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'five-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'htmlOptions'=>array('enctype'=>'multipart/form-data'),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('five','Five Form'); ?></strong>
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
					'submit'=>Yii::app()->createUrl('five/new')));
			}
		?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('five/list')));
		?>
<?php if ($model->scenario!='view'): ?>
			<?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
				'submit'=>Yii::app()->createUrl('five/save')));
			?>
<?php endif ?>
<?php if ($model->scenario=='edit'): ?>
	<?php echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
			'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
		);
	?>
<?php endif ?>
		<?php if ($model->scenario!='new'): ?>
		<?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Download'), array(
				'submit'=>Yii::app()->createUrl('five/downfile')));
		?>
		<?php endif ?>
	</div>
	</div>
	</div>
	<div class="box box-info">
		<div class="box-body">
			<?php echo $form->hiddenField($model, 'scenario'); ?>
			<?php echo $form->hiddenField($model, 'id'); ?>
			<?php echo $form->hiddenField($model, 'url'); ?>
			<?php echo $form->hiddenField($model, 'uid'); ?>
			<?php echo $form->hiddenField($model, 'ucod'); ?>
			<?php echo $form->hiddenField($model, 'ujob'); ?>
			<div class="form-group">
				<?php echo $form->labelEx($model,'uname',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model, 'uname',
							array('maxlength'=>100,'readonly'=>!Yii::app()->user->validRWFunction('T08'),)
					); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'ucod',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-2">
				<?php echo $form->textField($model, 'ucod',
					array('size'=>8,'maxlength'=>20,'readonly'=>true,));
				?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'ujob',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
				<?php echo $form->textField($model, 'ujob',
					array('size'=>40,'maxlength'=>250,'readonly'=>true)
				); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'s_state',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
					<?php echo $form->dropDownList($model, 's_state',
							array('1'=>1,
									'2'=>2,
									'3'=>3,
									'4'=>4,
									'5'=>5,
									)
					); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'d_tm',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
				<?php echo $form->textField($model, 'd_tm',
					array('size'=>40,'maxlength'=>500,'readonly'=>($model->scenario=='view'))
				); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'mrscore',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-5">
				<?php echo $form->textField($model, 'mrscore',
					array('maxlength'=>100,'readonly'=>!Yii::app()->user->validRWFunction('T08'))
				); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'drscore',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
				<?php echo $form->textField($model, 'drscore',
					array('size'=>40,'maxlength'=>100,'readonly'=>!Yii::app()->user->validRWFunction('T09'))
				); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'upf',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-7">
					<?php echo $form->FileField($model,'file'); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->renderPartial('//site/removedialog'); ?>

<?php
$js = Script::genDeleteData(Yii::app()->createUrl('five/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);

if ($model->scenario!='view') {
	$js = Script::genDatePicker(array(
			'FiveForm_d_tm',
	));
	Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}

?>



<?php $this->endWidget(); ?>

