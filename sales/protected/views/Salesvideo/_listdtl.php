<tr class='clickable-row' data-href='<?php echo $this->getLink('HK01', 'Salesvideo/edit', 'Salesvideo/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('HK01', 'Salesvideo/edit', 'Salesvideo/view', array('index'=>$this->record['id'])); ?></td>
	<td><?php echo $this->record['video_info_date']; ?></td>
	<td><?php echo $this->record['seller_notes']; ?></td>
	<td><?php echo $this->record['video_info_url']; ?></td>

