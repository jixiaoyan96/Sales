<tr>
	<td>
		<?php echo TbHtml::dropDownList($this->getFieldName('gname'),  1,General::getGoodsList(),
								array('class'=>'setOne')
		); ?>
	</td>
	<td>
		<?php echo TbHtml::dropDownList($this->getFieldName('tgname'),  1,General::getTowlist(),
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
			array('readonly'=>true,
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
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10','class'=>'isgoods',)
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
	window.setInterval(bang, 2000);
	window.setInterval(ismo, 2000);
	window.setInterval(istot, 2000);
	window.setInterval(discount, 2000);
	var totmony = 0;
	function bang(){
		var r = 0;
		var r = $('#tblDetail tr').length;
		if(r >= 3){
			r = r-1;
		}else{
			r = r-2
		}
		var id = '#'+'SalesForm_detail_'+r+'_gname';
		var sid = '#'+'SalesForm_detail_'+r+'_tgname';
		$(id).unbind();
		$(document).ready(function(){
			$(id).change(function() {
				$.get("<?php echo Yii::app()->createUrl('sales/two'); ?>",
						{ id: $(id).val()},
						function(data){
							var options = '';
							for(i in data){
								options += "<option value=" + i+ ">" + data[i] + "</option>"; //遍历赋值
							}
							$(sid).html(options);
						});
			})
		});
	}
function ismo(){
	var r = 0;
	var r = $('#tblDetail tr').length;
	if(r >= 3){
		r = r-1;
	}else{
		r = r-2
	}
	var sid = '#'+'SalesForm_detail_'+r+'_tgname';
	var did = '#'+'SalesForm_detail_'+r+'_gmoney';
	var zid = '#'+'SalesForm_detail_'+r+'_total';
	$(sid).unbind();
	$(document).ready(function(){
		$(sid).change(function() {
			$.get("<?php echo Yii::app()->createUrl('sales/getmoney'); ?>",
					{ id: $(sid).val()},
					function(data){
						$(did).val(data[0]['gmoney']);
						$(zid).val(data[0]['gmoney']);
					});
		})
	});
}
	function istot(){
		var r = 0;
		var r = $('#tblDetail tr').length;
		if(r >= 3){
			r = r-1;
		}else{
			r = r-2
		}
		var sid = '#'+'SalesForm_detail_'+r+'_number';
		var did = '#'+'SalesForm_detail_'+r+'_gmoney';
		var zid = '#'+'SalesForm_detail_'+r+'_total';
		$(sid).unbind();
		$(document).ready(function(){
			$(sid).change(function() {
				var num = $(sid).val();
				var mon = $(did).val();
				var tot = num * mon;
				$(zid).val(tot);
			})
		});
	}
	function discount(){
		var r = 0;
		var r = $('#tblDetail tr').length;
		if(r >= 3){
			r = r-1;
		}else{
			r = r-2
		}
		var sid = '#'+'SalesForm_detail_'+r+'_goodagio';
		var did = '#'+'SalesForm_detail_'+r+'_gmoney';
		var mo = '#'+'SalesForm_detail_'+r+'_number';
		var zid = '#'+'SalesForm_detail_'+r+'_total';
		$(sid).unbind();
		$(document).ready(function(){
			$(sid).change(function() {
				var dis = $(sid).val(); //折扣的值
				var num = $(mo).val();	//数量
				var mon = $(did).val();	//原价
				var row = mon - dis   //折扣后的值
				var tot = num * row;	//折扣的总价
				$(zid).val(tot);
				totmony += tot;
				good();
			})
		});
	}


	function good(){
		var inputArr = $('.isgood');
		//3.循环处理input,并定义结果集
		var result = [];
		inputArr.each(function(){
			//4.将每个input的值放进结果集
			result.push($(this).val());
		});
		//5.打印结果
		console.log(result);
	}



</script>