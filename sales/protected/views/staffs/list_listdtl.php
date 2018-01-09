<tr class='clickable-row' data-href='<?php echo $this->getLink('TB01', 'staffs/ulist', 'staffs/ulist', array('index'=>$this->record['listid']));?>'>
	<td><?php echo $this->drawEditButton('TB01', 'staffs/ulist', 'staffs/ulist', array('index'=>$this->record['listid'])); ?></td>
	<td><?php echo $this->record['listname']; ?></td>
	<td><?php $this->record['id']; ?></td>
</tr>
