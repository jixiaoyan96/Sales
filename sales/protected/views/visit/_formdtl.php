<?php
if($this->model->scenario == 'view' || $this->model->scenario == 'edit' ){?>
<?php
$i=0;
foreach($this->model->offer as $k=>$v){?>
<tr>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('seats'),  $v['name'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
						'size'=>'7', 'maxlength'=>'10',
						'append'=>TbHtml::Button('<span class="fa fa-search"></span> '.Yii::t('visit','Selection of services'),array('name'=>'btnse','id'=>'btnse'))
						)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('number'),  $v['number'],
				array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
						'size'=>'7', 'maxlength'=>'10',)
		); ?>
	</td>
	<td>
		<?php echo TbHtml::textField($this->getFieldName('amount'), $v['money'],
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
	<?php $i++;   } ?>
<?php }else{?>
	<tr>
		<td>
			<?php echo TbHtml::textField($this->getFieldName('seats'),'请输入服务内容',
					array('readonly'=>!Yii::app()->user->validRWFunction('T02'),
							'size'=>'7', 'maxlength'=>'10',
							'append'=>TbHtml::Button('<span class="fa fa-search"></span> '.Yii::t('visit','Selection of services'),array('name'=>'btnse','id'=>'btnse'))
					)
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
