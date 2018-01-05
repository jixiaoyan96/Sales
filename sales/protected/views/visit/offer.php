<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'visit-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('visit/index')));
                ?>
                 <?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
                        'submit'=>Yii::app()->createUrl('visit/saveoffer')));
                    ?>
            </div>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-body">
            <?php echo $form->hiddenField($model,'id'); ?>
            <?php echo CHtml::hiddenField('dtltemplate'); ?>
    <div class="box">
        <div class="box-body table-responsive">
            <legend><?php echo Yii::t('visit','Visit Offer'); ?></legend>
            <?php $this->widget('ext.layout.TableView2Widget', array(
                'model'=>$model,
                'attribute'=>'detail',
                'viewhdr'=>'//visit/_formhdr',
                'viewdtl'=>'//visit/_formdtl',
                'gridsize'=>'24',
                'height'=>'200',
            ));
            ?>
        </div>
    </div>
</div>
</div>

<?php $this->renderPartial('//site/removedialog'); ?>
<?php $this->renderPartial('//site/lookup'); ?>

    <?php
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
		$('#tblDetail tr').eq(-1).find('[id*=\"VisitForm_\"]').each(function(index) {
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
    ?>
<?php $this->endWidget(); ?>
