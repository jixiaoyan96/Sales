<?php
if($this->model->scenario == 'view' || $this->model->scenario == 'edit' ){?>
<?php
$i=0;
foreach($this->model->offer as $k=>$v){?>
<tr>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('seats'),  $v['name'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('number'),  $v['nmr'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('amount'), $v['money'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
</tr>
	<?php $i++;   } ?>
<?php }else{?>
	<tr>
		<td>
			<?php echo TbHtml::dropDownList($this->getFieldName('gname'),  1,General::getGoodsList(),
					array('class'=>'setOne')
			); ?>
		</td>
		<td>
			<?php echo TbHtml::dropDownList($this->getFieldName('seats'),  1,array(
					'Please'=>Yii::t('sales','Please choose')
			),
					array('class'=>'setZwo')
			); ?>
		</td>
		<td>
			<?php echo TbHtml::textField($this->getFieldName('number'),0,
					array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
							'size'=>'7', 'maxlength'=>'10',)
			); ?>
		</td>
		<td>
			<?php echo TbHtml::textField($this->getFieldName('amount'),0,
					array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
							'size'=>'7', 'maxlength'=>'10',)
			); ?>
		</td>
		<td>
			<?php
			echo Yii::app()->user->validRWFunction('T02')
					? TbHtml::Button('-',array('id'=>'btnDelRow','title'=>Yii::t('misc','Delete'),'size'=>TbHtml::BUTTON_SIZE_SMALL))
					: '&nbsp;';
			?>
		</td>
	</tr>
<?php } ?>

<script>
	window.setInterval(bang, 2000);
	function bang(){
		var r = 0;
		var r = $('#tblDetail tr').length;
		if(r >= 3){
			r = r-1;
		}else{
			r = r-2
		}
		var id = '#'+'VisitForm_detail_'+r+'_gname';
		var sid = '#'+'VisitForm_detail_'+r+'_seats';
		$(id).unbind();
		$(document).ready(function(){
			$(id).change(function() {
				$.get("<?php echo Yii::app()->createUrl('sales/two'); ?>",
						{ sid: $(id).val()},
						function(data){
							console.dir(data);
							var options = '';
							for(i in data){
								options += "<option value=" + i+ ">" + data[i] + "</option>"; //遍历赋值
							}
							$(sid).html(options);
						});
			})
		});
	}
</script>