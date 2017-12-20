<tr>
	<th></th>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('code').$this->drawOrderArrow('code'),'#',$this->createOrderLink('sales-list','code'))
			;
		?>
	</th>
<?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('name').$this->drawOrderArrow('name'),'#',$this->createOrderLink('sales-list','name'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('region').$this->drawOrderArrow('region'),'#',$this->createOrderLink('sales-list','region'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('time').$this->drawOrderArrow('time'),'#',$this->createOrderLink('sales-list','time'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('goodid').$this->drawOrderArrow('goodid'),'#',$this->createOrderLink('sales-list','goodid'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('money').$this->drawOrderArrow('money'),'#',$this->createOrderLink('sales-list','money'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('lcu').$this->drawOrderArrow('lcu'),'#',$this->createOrderLink('sales-list','lcu'))
		;
		?>
	</th>
</tr>
