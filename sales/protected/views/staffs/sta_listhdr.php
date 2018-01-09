<tr>
	<th></th>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('uname').$this->drawOrderArrow('uname'),'#',$this->createOrderLink('staffs-list','uname'))
			;
		?>
	</th>
<?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('ucod').$this->drawOrderArrow('ucod'),'#',$this->createOrderLink('staffs-list','ucod'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('ujob').$this->drawOrderArrow('ujob'),'#',$this->createOrderLink('staffs-list','ujob'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('toe').$this->drawOrderArrow('toe'),'#',$this->createOrderLink('staffs-list','toe'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('state').$this->drawOrderArrow('state'),'#',$this->createOrderLink('staffs-list','state'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('city').$this->drawOrderArrow('city'),'#',$this->createOrderLink('staffs-list','city'))
			;
		?>
	</th>
</tr>
