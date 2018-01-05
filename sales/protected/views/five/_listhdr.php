<tr>
	<th></th>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('uname').$this->drawOrderArrow('uname'),'#',$this->createOrderLink('five-list','uname'))
			;
		?>
	</th>
<?php endif ?>
	<th>
		<?php echo TbHtml::link($this->getLabelName('ucod').$this->drawOrderArrow('ucod'),'#',$this->createOrderLink('five-list','ucod'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('ujob').$this->drawOrderArrow('ujob'),'#',$this->createOrderLink('five-list','ujob'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('entrytime').$this->drawOrderArrow('entrytime'),'#',$this->createOrderLink('five-list','entrytime'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('city').$this->drawOrderArrow('city'),'#',$this->createOrderLink('five-list','city'))
			;
		?>
	</th>
</tr>
