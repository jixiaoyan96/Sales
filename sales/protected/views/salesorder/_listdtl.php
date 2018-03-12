<tr class='clickable-row' data-href='<?php echo $this->getLink('HK01', 'salesorder/view', 'salesorder/view', array('index'=>$this->record['id']));?>'>
	<td><?php echo $this->drawEditButton('HK01', 'salesorder/view', 'salesorder/view', array('index'=>$this->record['id'])); ?></td>
	<td><?php echo $this->record['order_info_code_number']; ?></td>
	<td><?php echo $this->record['order_customer_name']; ?></td>
	<td><?php echo $this->record['order_info_rural']; ?></td>
	<td><?php echo $this->record['order_info_date']; ?></td>
	<td><?php echo $this->record['order_goods_code_number']; ?></td>
	<td><?php echo $this->record['order_info_money_total']; ?></td>
	<td><?php echo $this->record['order_info_seller_name']; ?></td>
</tr>


