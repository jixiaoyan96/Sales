<tr class='clickable-row' data-href='<?php echo $this->getLink('T01', 'choice/edit', 'choice/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('T01', 'choice/edit', 'choice/view', array('index'=>$this->record['id'])); ?></td>
	<td><?php echo $this->record['id']; ?></td>
	<td><?php echo $this->record['name']; ?></td>
</tr>
