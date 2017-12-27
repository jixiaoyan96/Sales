<tr>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('seats'),  1,
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'7', 'maxlength'=>'10',
						'append'=>TbHtml::Button('<span class="fa fa-search"></span> '.Yii::t('visit','Selection of services'),array('name'=>'btnse','id'=>'btnse'))
						)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('tgname'),  1,
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('number'), 1,
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
</tr>
