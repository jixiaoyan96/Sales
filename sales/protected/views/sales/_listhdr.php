<tr>
	<th></th>

	<th>
		<?php echo TbHtml::link($this->getLabelName('customer_name').$this->drawOrderArrow('customer_name'),'#',$this->createOrderLink('sales-list','customer_name'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('customer_contact').$this->drawOrderArrow('customer_contact'),'#',$this->createOrderLink('sales-list','customer_contact'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('customer_contact_phone').$this->drawOrderArrow('customer_contact_phone'),'#',$this->createOrderLink('sales-list','customer_contact_phone'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('customer_create_date').$this->drawOrderArrow('customer_create_date'),'#',$this->createOrderLink('sales-list','customer_create_date'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('visit_definition_name').$this->drawOrderArrow('visit_definition_name'),'#',$this->createOrderLink('sales-list','visit_definition_name'))
		;
		?>
	</th>
	<th>
		<?php echo TbHtml::link($this->getLabelName('customer_kinds_name').$this->drawOrderArrow('customer_kinds_name'),'#',$this->createOrderLink('sales-list','customer_kinds_name'))
		;
		?>
	</th>
</tr>
