<tr>
	<td>
		<?php echo TbHtml::dropDownList($this->getFieldName('gname'),  1,General::getGoodsList(),
								array('class'=>'setOne')
		); ?>
	</td>
	<td>
		<?php echo TbHtml::dropDownList($this->getFieldName('tgname'),  1,General::getGoodsList(),
								array('class'=>'setZwo')
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('number'), 1,
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('gmoney'), $this->record['gmoney'],
			array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
				'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('goodagio'), $this->record['goodagio'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('total'), $this->record['total'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T01'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php 
			echo Yii::app()->user->validRWFunction('T01')
				? TbHtml::Button('-',array('id'=>'btnDelRow','title'=>Yii::t('misc','Delete'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
				: '&nbsp;';
		?>

	</td>
</tr>
<script type="text/javascript">
	window.setInterval(bang, 3000);
	function bang(){
		var r = 0;
		var r = $('#tblDetail tr').length;
		r = r-2
		var id = '#'+'SalesForm_detail_'+r+'_gname';
		var sid = '#'+'SalesForm_detail_'+r+'_tgname';
		$(document).ready(function(){
			$(id).change(function() {
				$.get("<?php echo Yii::app()->createUrl('sales/two'); ?>", //获取地区的URL
						{ id: $(id).val()},
						function(data){
							var options = '';
							for(i in data){
								options += "<option value=" + i+ ">" + data[i] + "</option>"; //遍历赋值
							}
							$(sid).html(options); // 数据插入到地区下拉表！
						});
			})
		});
	}
</script>