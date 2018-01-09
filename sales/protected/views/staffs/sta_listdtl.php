<tr class='clickable-row' data-href='<?php echo $this->getLink('TB01', 'staffs/ulist', 'staffs/ulist', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('TB01', 'staffs/ulist', 'staffs/ulist', array('index'=>$this->record['id'])); ?></td>
<?php if (!Yii::app()->user->isSingleCity()) : ?>
	<td><?php echo $this->record['uname']; ?></td>
<?php endif ?>
	<td><?php echo $this->record['ucod']; ?></td>
	<td><?php echo $this->record['ujob']; ?></td>
	<td><?php echo $this->record['toe']; ?></td>
	<td>
		<?php if($this->record['state'] == 0){
			echo Yii::t('staffs','Job');
		}elseif($this->record['state'] == 1){
			echo Yii::t('staffs','Quit');
		}; ?>
	</td>
	<td><?php echo $this->record['city']; ?></td>
</tr>
