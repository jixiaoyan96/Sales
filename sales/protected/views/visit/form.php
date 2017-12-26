<?php
$this->pageTitle=Yii::app()->name . ' - Visit Form';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'visit-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('visit','Visit Form'); ?></strong>
	</h1>
</section>

<section class="content">
	<div class="box"><div class="box-body">
	<div class="btn-group" role="group">
		<?php 
			if ($model->scenario!='new' && $model->scenario!='view') {
				echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Another'), array(
					'submit'=>Yii::app()->createUrl('visit/new')));
			}
		?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('visit/index')));
		?>
		<?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Gps'), array(
				'submit'=>Yii::app()->createUrl('visit/gps')));
		?>
<?php if ($model->scenario!='view'): ?>
			<?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
				'submit'=>Yii::app()->createUrl('visit/save')));
			?>
<?php endif ?>
<?php if ($model->scenario=='edit'): ?>
	<?php echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
			'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
		);
	?>
<?php endif ?>
	</div>
	</div></div>

	<div class="box box-info">
		<div class="box-body">
			<?php echo $form->hiddenField($model, 'scenario'); ?>
			<?php echo $form->hiddenField($model, 'id'); ?>
			<div class="form-group">
				<?php echo $form->labelEx($model,'type',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-4">
					<?php echo $form->textField($model, 'type',
							array('size'=>30,'maxlength'=>500,'readonly'=>($model->scenario=='view'),
									'append'=>TbHtml::Button('<span class="fa fa-search"></span> '.Yii::t('visit','Type'),array('name'=>'btnistype','id'=>'btnistype','disabled'=>($model->scenario=='view')))
							)); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'aim',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-4">
					<?php echo $form->textField($model, 'aim',
							array('size'=>30,'maxlength'=>500,'readonly'=>($model->scenario=='view'),
									'append'=>TbHtml::Button('<span class="fa fa-search"></span> '.Yii::t('visit','Aim'),array('name'=>'btnaim','id'=>'btnaim','disabled'=>($model->scenario=='view')))
							)); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'datatime',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-3">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<?php echo $form->textField($model, 'datatime',
								array('class'=>'form-control pull-right','readonly'=>($model->scenario=='view'),));
						?>
					</div>
				</div>
			</div>
		</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'area',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-4">
				<?php echo $form->textField($model, 'area',
					array('maxlength'=>100,'readonly'=>($model->scenario=='view'))
				); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'road',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-5">
				<?php echo $form->textField($model, 'road',
					array('size'=>40,'maxlength'=>100,'readonly'=>($model->scenario=='view'))
				); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'crtype',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-4">
					<?php echo $form->textField($model, 'crtype',
							array('size'=>20,'maxlength'=>100,'readonly'=>($model->scenario=='view'),
									'append'=>TbHtml::Button('<span class="fa fa-search"></span> '.Yii::t('visit','Customer type'),array('name'=>'btntype','id'=>'btntype','disabled'=>($model->scenario=='view')))
							)); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'crname',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model, 'crname',
							array('maxlength'=>100,'readonly'=>($model->scenario=='view'))
					); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'sonname',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-5">
				<?php echo $form->textField($model, 'sonname',
					array('maxlength'=>255,'readonly'=>($model->scenario=='view'))
				); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'charge',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-5">
				<?php echo $form->textField($model, 'charge',
					array('maxlength'=>100,'readonly'=>($model->scenario=='view'))
				); ?>
				</div>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'phone',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model, 'phone',
							array('maxlength'=>100,'readonly'=>($model->scenario=='view'))
					); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'remarks',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-6">
					<?php echo $form->textArea($model, 'remarks',
							array('rows'=>2,'cols'=>50,'maxlength'=>1000,'readonly'=>($model->scenario=='view'))
					); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->renderPartial('//site/removedialog'); ?>
<?php $this->renderPartial('//site/lookup'); ?>

<?php
$js = Script::genLookupSearch();
Yii::app()->clientScript->registerScript('lookupSearch',$js,CClientScript::POS_READY);

$js = Script::genLookupButton('btntype', 'crtype', '', 'crtype');
Yii::app()->clientScript->registerScript('lookType',$js,CClientScript::POS_READY);

$js = Script::genLookupButton('btnistype', 'istype', '', 'type');
Yii::app()->clientScript->registerScript('lookIstype',$js,CClientScript::POS_READY);

$js = Script::genLookupButton('btnaim', 'aim', '', 'aim');
Yii::app()->clientScript->registerScript('lookAim',$js,CClientScript::POS_READY);

$js = Script::genDeleteData(Yii::app()->createUrl('visit/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);

$js = Script::genLookupSelect();
Yii::app()->clientScript->registerScript('lookupSelect',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);


if ($model->scenario!='view') {
	$js = Script::genDatePicker(array(
			'VisitForm_datatime',
	));
	Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}
?>





<?php $this->endWidget(); ?>

