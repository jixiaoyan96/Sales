<tr class='clickable-row' data-href='<?php echo $this->getLink('T01', 'sales/edit', 'sales/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('T01', 'sales/edit', 'sales/view', array('index'=>$this->record['id'])); ?></td>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<td><?php echo $this->record['code']; ?></td>
<?php endif ?>
	<td><?php echo $this->record['name']; ?></td>
	<td><?php echo $this->record['region']; ?></td>
	<td><?php echo $this->record['time']; ?></td>
	<td><?php echo $this->record['goodid']; ?></td>
	<td><?php echo $this->record['money']; ?></td>
	<td><?php echo $this->record['lcu']; ?></td>
</tr>
