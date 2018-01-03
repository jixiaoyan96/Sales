<tr class='clickable-row' data-href='<?php echo $this->getLink('T02', 'visit/edit', 'visit/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('T02', 'visit/edit', 'visit/view', array('index'=>$this->record['id'])); ?></td>
	<td><?php echo $this->record['type']; ?></td>
	<td><?php echo $this->record['aim']; ?></td>
	<td><?php echo $this->record['lcd']; ?></td>
	<td><?php echo $this->record['crname']; ?></td>
	<td><?php echo $this->record['phone']; ?></td>
	<td><?php echo $this->record['city']; ?></td>
</tr>
