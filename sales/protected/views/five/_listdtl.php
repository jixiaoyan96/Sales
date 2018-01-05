<tr class='clickable-row' data-href='<?php echo $this->getLink('T01', 'five/edit', 'five/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('T01', 'five/edit', 'five/view', array('index'=>$this->record['id'])); ?></td>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<td><?php echo $this->record['uname']; ?></td>
<?php endif ?>
	<td><?php echo $this->record['ucod']; ?></td>
	<td><?php echo $this->record['ujob']; ?></td>
	<td><?php echo $this->record['entrytime']; ?></td>
	<td><?php echo $this->record['city']; ?></td>
</tr>
