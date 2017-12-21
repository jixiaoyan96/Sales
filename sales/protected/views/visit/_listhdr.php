<tr>
	<th></th>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('type').$this->drawOrderArrow('type'),'#',$this->createOrderLink('sales-list','type'))
			;
		?>
	</th>
<?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('aim').$this->drawOrderArrow('aim'),'#',$this->createOrderLink('sales-list','aim'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('datatime').$this->drawOrderArrow('datatime'),'#',$this->createOrderLink('sales-list','datatime'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('username').$this->drawOrderArrow('username'),'#',$this->createOrderLink('sales-list','username'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('craddress').$this->drawOrderArrow('craddress'),'#',$this->createOrderLink('sales-list','craddress'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('city').$this->drawOrderArrow('city'),'#',$this->createOrderLink('sales-list','city'))
			;
		?>
	</th>
</tr>
