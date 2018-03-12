<tr class='clickable-row' data-href='<?php echo $this->getLink('HK01', 'Salesvideo/edit', 'Salesvideo/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('HK01', 'Salesvideo/edit', 'Salesvideo/view', array('index'=>$this->record['id'])); ?></td>
	<td><?php echo $this->record['video_info_date']; ?></td>
	<td><?php echo $this->record['seller_notes']; ?></td>
	<td><?php echo $this->record['video_info_url']; ?>
	<td><?php echo $this->record['city_privileges'];?></td>
	<td><?php echo $this->record['video_info_directer_grades']; ?></td>
	<td><?php echo $this->record['video_info_manager_grades']; ?></td>
	<td><?php
		$temp=$this->record['video_info_statue'];
		if($temp==1){
			echo "第一部";
		}elseif($temp==2){
			echo "第二部";
		}elseif($temp==3){
			echo "第三部";
		}elseif($temp==4){
			echo "第四部";
		}elseif($temp==5){
			echo "第五部";
		}else{
			echo "未选择";
		}
		?></td>
	<td><?php echo $this->record['video_info_user_name'];?></td>

