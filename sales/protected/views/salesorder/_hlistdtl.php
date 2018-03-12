<tr class='clickable-row' data-href='<?php echo $this->getLink('HK01', 'salesorder/print', 'salesorder/print', array('index'=>$this->record['id']));?>'>
    <td><?php echo $this->drawEditButton('HK01', 'salesorder/print', 'salesorder/print', array('index'=>$this->record['id'])); ?></td>
    <td><?php echo $this->record['order_customer_name']; ?></td>
    <td><?php echo $this->record['order_customer_rural']; ?></td>
    <td><?php echo $this->record['order_customer_street']; ?></td>
    <td><?php echo $this->record['order_info_date']; ?></td>
    <td><?php echo $this->record['order_customer_total_money']; ?></td>
</tr>