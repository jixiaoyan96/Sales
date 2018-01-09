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
		<?php echo TbHtml::link($this->getLabelName('state').$this->drawOrderArrow('state'),'#',$this->createOrderLink('five-list','state'))
			;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('d_tm').$this->drawOrderArrow('d_tm'),'#',$this->createOrderLink('five-list','d_tm'))
			;
		?>
	</th>
</tr>
