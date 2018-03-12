<tr>
    <th></th>

    <th>
        <?php echo TbHtml::link($this->getLabelName('sellers_name').$this->drawOrderArrow('sellers_name'),'#',$this->createOrderLink('sales-list','sellers_name'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('user_id').$this->drawOrderArrow('user_id'),'#',$this->createOrderLink('sales-list','user_id'))
        ;
        ?>
    </th>

</tr>
