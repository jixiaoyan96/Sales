<tr>
	<th></th>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('type').$this->drawOrderArrow('type'),'#',$this->createOrderLink('visit-list','type'))
			;
		?>
	</th>
<?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('aim').$this->drawOrderArrow('aim'),'#',$this->createOrderLink('visit-list','aim'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('datatime').$this->drawOrderArrow('datatime'),'#',$this->createOrderLink('visit-list','datatime'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('crname').$this->drawOrderArrow('crname'),'#',$this->createOrderLink('visit-list','crname'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('phone').$this->drawOrderArrow('phone'),'#',$this->createOrderLink('visit-list','phone'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('city').$this->drawOrderArrow('city'),'#',$this->createOrderLink('visit-list','city'))
			;
		?>
	</th>
</tr>
