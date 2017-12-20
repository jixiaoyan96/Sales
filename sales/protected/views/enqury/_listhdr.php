<tr>
	<th></th>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('oid').$this->drawOrderArrow('oid'),'#',$this->createOrderLink('sales-list','oid'))
			;
		?>
	</th>
<?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('crname').$this->drawOrderArrow('crname'),'#',$this->createOrderLink('sales-list','crname'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('money').$this->drawOrderArrow('money'),'#',$this->createOrderLink('sales-list','money'))
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
