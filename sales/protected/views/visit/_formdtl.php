<?php
if($this->model->scenario == 'view' || $this->model->scenario == 'edit' ){?>
<tr>
	<td>
		<?php echo TbHtml::dropDownList($this->getFieldName('goodsid'),$this->record['goodsid'],General::getTowlist(),
				array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('nmr'), $this->record['nmr'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('money'), $this->record['money'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
	<?php
	echo Yii::app()->user->validRWFunction('T02')
			? TbHtml::Button('-',array('id'=>'btnDelRow','title'=>Yii::t('misc','Delete'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
			: '&nbsp;';
	?>
	<?php echo CHtml::hiddenField($this->getFieldName('uflag'),$this->record['uflag']); ?>
	<?php echo CHtml::hiddenField($this->getFieldName('id'),$this->record['id']); ?>
	</td>
</tr>
<?php }else{?>
	<tr>
		<td>
			<?php echo TbHtml::dropDownList($this->getFieldName('gname'),  1,General::getGoodsList(),
					array('class'=>'setOne')
			); ?>
		</td>
		<td>
			<?php echo TbHtml::dropDownList($this->getFieldName('goodsid'),  1,array(
					'Please'=>Yii::t('sales','Please choose')
			),
					array('class'=>'setZwo')
			); ?>
		</td>
		<td>
			<?php echo TbHtml::textField($this->getFieldName('nmr'),0,
					array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
							'size'=>'7', 'maxlength'=>'10',)
			); ?>
		</td>
		<td>
			<?php echo TbHtml::textField($this->getFieldName('money'),0,
					array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
							'size'=>'7', 'maxlength'=>'10',)
			); ?>
		</td>
		<td>
			<?php
			echo Yii::app()->user->validRWFunction('T02')
					? TbHtml::Button('-',array('id'=>'btnDelRow','title'=>Yii::t('misc','Delete'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
					: '&nbsp;';
			?>
			<?php echo CHtml::hiddenField($this->getFieldName('uflag'),$this->record['uflag']); ?>
			<?php echo CHtml::hiddenField($this->getFieldName('id'),$this->record['id']); ?>
		</td>
	</tr>
<?php } ?>
<script>
	window.setInterval(bang, 2000);
	function bang(){
		var r = 0;
		var r = $('#tblDetail tr').length;
		if(r >= 3){
			r = r-1;
		}else{
			r = r-2
		}
		var id = '#'+'VisitForm_detail_'+r+'_gname';
		var sid = '#'+'VisitForm_detail_'+r+'_goodsid';
		$(id).unbind();
		$(document).ready(function(){
			$(id).change(function() {
				$.get("<?php echo Yii::app()->createUrl('sales/two'); ?>",
						{ sid: $(id).val()},
						function(data){
							console.dir(data);
							var options = '';
							for(i in data){
								options += "<option value=" + i+ ">" + data[i] + "</option>"; //遍历赋值
							}
							$(sid).html(options);
						});
			})
		});
	}
</script>