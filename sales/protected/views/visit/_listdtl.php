<tr class='clickable-row' data-href='<?php echo $this->getLink('T02', 'visit/edit', 'visit/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('T02', 'visit/edit', 'visit/view', array('index'=>$this->record['id'])); ?></td>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<td><?php echo $this->record['uname']; ?></td>
<?php endif ?>
	<td><?php echo $this->record['type']; ?></td>
	<td><?php echo $this->record['aim']; ?></td>
	<td><?php echo $this->record['datatime']; ?></td>
	<td><?php echo $this->record['crname']; ?></td>
	<td><?php echo $this->record['phone']; ?></td>
</tr>
