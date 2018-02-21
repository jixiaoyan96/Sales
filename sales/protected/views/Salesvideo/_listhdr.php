<tr>
	<th></th>

	<th>
		<?php echo TbHtml::link($this->getLabelName('video_info_date').$this->drawOrderArrow('video_info_date'),'#',$this->createOrderLink('sales-list','video_info_date'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('seller_notes').$this->drawOrderArrow('seller_notes'),'#',$this->createOrderLink('sales-list','seller_notes'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('video_info_url').$this->drawOrderArrow('video_info_url'),'#',$this->createOrderLink('sales-list','video_info_url'))
		;
		?>
	</th>

</tr>
