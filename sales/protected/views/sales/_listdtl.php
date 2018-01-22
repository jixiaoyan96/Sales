<tr class='clickable-row' data-href='<?php echo $this->getLink('HK01', 'sales/edit', 'sales/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('HK01', 'sales/edit', 'sales/view', array('index'=>$this->record['id'])); ?></td>
	<td><?php echo $this->record['customer_name']; ?></td>
	<td><?php echo $this->record['customer_contact']; ?></td>
	<td><?php echo $this->record['customer_contact_phone']; ?></td>
	<td><?php echo $this->record['customer_create_date']; ?></td>
	<td><?php echo $this->record['visit_definition_name']; ?></td>
	<td><?php echo $this->record['customer_kinds_name']; ?></td>
</tr>


