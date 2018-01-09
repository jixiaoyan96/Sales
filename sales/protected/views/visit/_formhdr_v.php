<tr>
    <th>
        <?php echo TbHtml::label($this->getLabelName('services'), false); ?>
    </th>
    <th>
        <?php echo TbHtml::label($this->getLabelName('number'), false); ?>
    </th>
    <th>
        <?php echo TbHtml::label($this->getLabelName('amount'), false); ?>
    </th>
    <th>
        <?php echo Yii::app()->user->validRWFunction('T02') ?
            TbHtml::Button('+',array('id'=>'btnAddRow','title'=>Yii::t('misc','Add'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
            : '&nbsp;';
        ?>
    </th>
</tr>
