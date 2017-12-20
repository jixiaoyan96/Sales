<tr>
	<th>
		<?php echo TbHtml::label($this->getLabelName('Use of services'), false); ?>
	</th>
	<th>
		<?php echo TbHtml::label($this->getLabelName('Use of goods'), false); ?>
	</th>
	<th>
		<?php echo TbHtml::label($this->getLabelName('Goods Number'), false); ?>
	</th>
	<th>
		<?php echo TbHtml::label($this->getLabelName('Goods Price'), false); ?>
	</th>
	<th>
		<?php echo TbHtml::label($this->getLabelName('Goodagio'), false); ?>
	</th>
	<th>
		<?php echo TbHtml::label($this->getLabelName('Total'), false); ?>
	</th>
	<th>
		<?php echo Yii::app()->user->validRWFunction('T01') ?
				TbHtml::Button('+',array('id'=>'btnAddRow','title'=>Yii::t('misc','Add'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
				: '&nbsp;';
		?>
	</th>
</tr>
