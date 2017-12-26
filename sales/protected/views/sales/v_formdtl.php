<?php
$i=0;
foreach($this->model->good as $k=>$v){?>
<tr>
	<td>
		<?php echo TbHtml::textField($this->getFieldNames('goods',$i), $v['gname'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldNames('number',$i), $v['number'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldNames('price',$i), $v['gmoney'],
			array('readonly'=>true,
				'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldNames('goodagio',$i), $v['goodagio'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldNames('ismony',$i), $v['ismony'],
				array('readonly'=>true,
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
</tr>

<?php $i++;  } ?>