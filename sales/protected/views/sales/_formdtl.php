<tr>
	<td>
		<?php echo TbHtml::dropDownList($this->getFieldName('gname'),  1, General::getGoodsList(),
								array('disabled'=>!Yii::app()->user->validRWFunction('T01'))
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('qty'), $this->record['qty'],
			array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
				'size'=>'10', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('qty'), $this->record['qty'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'10', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php 
			echo Yii::app()->user->validRWFunction('T01')
				? TbHtml::Button('-',array('id'=>'btnDelRow','title'=>Yii::t('misc','Delete'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
				: '&nbsp;';
		?>
		<?php echo CHtml::hiddenField($this->getFieldName('uflag'),$this->record['uflag']); ?>
		<?php echo CHtml::hiddenField($this->getFieldName('logid'),$this->record['logid']); ?>

	</td>
</tr>
