<tr class='clickable-row' data-href='<?php echo $this->getLink('T02', 'visit/edit', 'visit/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('T02', 'visit/edit', 'visit/view', array('index'=>$this->record['id'])); ?></td>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<td><?php echo $this->record['oid']; ?></td>
<?php endif ?>
	<td><?php echo $this->record['crname']; ?></td>
	<td><?php echo $this->record['money']; ?></td>
	<td><?php echo $this->record['username']; ?></td>
	<td><?php echo $this->record['craddress']; ?></td>
	<td><?php echo $this->record['city']; ?></td>
</tr>
