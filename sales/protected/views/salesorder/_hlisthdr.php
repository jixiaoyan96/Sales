<tr>
    <th>
        <?php echo TbHtml::label($this->getLabelName('order_customer_name'), false); ?>
    </th>
    <th>
        <?php echo TbHtml::label($this->getLabelName('order_customer_rural'), false); ?>
    </th>
    <th>
        <?php echo TbHtml::label($this->getLabelName('order_customer_street'), false); ?>
    </th>
    <th>
        <?php echo TbHtml::label($this->getLabelName('order_info_date'), false); ?>
    </th>
    <th>
        <?php echo TbHtml::label($this->getLabelName('order_customer_total_money'), false); ?>
    </th>
    <th>
        <?php echo Yii::app()->user->validRWFunction('A05') ?
            TbHtml::Button('+',array('id'=>'btnAddRow','title'=>Yii::t('misc','Add'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
            : '&nbsp;';
        ?>
    </th>
</tr>


