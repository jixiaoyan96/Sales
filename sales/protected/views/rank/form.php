<?php
$this->pageTitle=Yii::app()->name . ' - Performance Form';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'Performance-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('code','Target Form'); ?></strong>
	</h1>
</section>

<section class="content">

	<div class="box"><div class="box-body">
	<div class="btn-group" role="group">
<!--		--><?php //
//			if ($model->scenario!='new' && $model->scenario!='view') {
//				echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Another'), array(
//					'submit'=>Yii::app()->createUrl('custtype/new')));
//			}
//		?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('target/index')));
		?>
<?php if ($model->scenario!='view'): ?>
			<?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
				'submit'=>Yii::app()->createUrl('target/save')));
			?>
<?php endif ?>
<?php if ($model->scenario=='edit'): ?>
<!--	--><?php //echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
//			'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
//		);
//	?>
<?php endif ?>
	</div>
	</div></div>

	<div class="box box-info">
		<div class="box-body">
			<?php echo $form->hiddenField($model, 'scenario'); ?>
			<?php echo $form->hiddenField($model, 'id'); ?>

            <style type="text/css">
                .tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
                .tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left;}
                .tftable tr {background-color:#ffffff;}
                .tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
                .tftable tr:hover {background-color:#ffff99;}
            </style>

            <table class="tftable" border="1">
                <tr><th>当前段位</th><th>白银1段</th><th>当前赛季累计到上月分数</th><th>9230</th></tr>
                <tr><td>当月数据 ：</td><td></td><td>当月数据对应得分 ：</td><td></td></tr>
                <tr><td>销售每月平均每天拜访记录</td><td>9条</td><td>销售每月平均每天拜访记录分数</td><td>500</td></tr>
                <tr><td>销售每月IA，IB签单单数 (A)</td><td>23张</td><td>销售每月IA，IB签单得分</td><td>24156.00</td></tr>
                <tr><td>销售每月IA，IB签单金额</td><td>165000</td><td></td><td></td></tr>
                <tr><td>销售每月飘盈香签单单数 (B)</td><td>4张</td><td>销售每月飘盈香签单得分</td><td>11130.00</td></tr>
                <tr><td>销售每月飘盈香签单金额</td><td>35000</td><td></td><td></td></tr>
                <tr><td>销售每月产品（不包括洗地易）签单 (C)</td><td>8张</td><td>销售每月产品（不包括洗地易）签单得分</td><td>3146.4</td></tr>
                <tr><td>销售每月产品（不包括洗地易）签单金额</td><td>3800</td><td></td><td></td></tr>
                <tr><td>销售每月洗地易/甲醛签单单数 (D)</td><td>3张</td><td>销售每月洗地易/甲醛签单得分</td><td>1222</td></tr>
                <tr><td>销售每月洗地易/甲醛签单金额</td><td>2400</td><td></td><td></td></tr>
                <tr><td>每月销售龙虎榜销售排名</td><td>2</td><td>每月销售龙虎榜销售得分</td><td>2000</td></tr>
                <tr><td>每月销售龙虎榜城市人均签单量排名</td><td>4</td><td>每月销售龙虎榜城市人均签单量排名</td><td>0</td></tr>
                <tr><td>每月销售龙虎榜城市人均签单金额排名</td><td>19</td><td>每月销售龙虎榜城市人均签单金额排名</td><td>-2000</td></tr>
                <tr><td>地方销售人员/整体区比例</td><td>0.4</td><td>地方销售人员/整体区比例效果</td><td>0.7</td></tr>
                <tr><td>销售组别类型（餐饮组/商业组</td><td>餐饮组（或没分）</td><td>销售组别类型（餐饮组/商业组）效果</td><td>1</td></tr>
                <tr><td>销售岗位级别</td><td>1.2</td><td>销售每月平均每天拜访记录</td><td>0.9</td></tr>
                <tr><td>当月所有得分</td><td>12313 </td><td>当前赛季累计到今月应得分数</td><td>401694</td></tr>
                <tr><td>当月得分对应段位</td><td>白银1段</td><td>当前赛季累计到今月实得得分</td><td>401694</td></tr>
            </table>



            <!--			<div class="form-group">-->
<!--				--><?php //echo $form->labelEx($model,'employee_name',array('class'=>"col-sm-2 control-label")); ?>
<!--				<div class="col-sm-2">-->
<!--					--><?php //echo $form->textField($model, 'employee_name',
//						array('size'=>10,'maxlength'=>10,'readonly'=>('readonly'))
//					); ?>
<!--				</div>-->
<!--			</div>-->
<!---->
<!--            <div class="form-group">-->
<!--                --><?php //echo $form->labelEx($model,'sale_day',array('class'=>"col-sm-2 control-label")); ?>
<!--                <div class="col-sm-2">-->
<!--                    --><?php //echo $form->textField($model, 'sale_day',
//                        array('size'=>10,'maxlength'=>10,)
//                    ); ?>
<!--                </div>-->
<!--            </div>-->
		</div>
	</div>
</section>

<?php $this->renderPartial('//site/removedialog'); ?>

<?php
$js = Script::genDeleteData(Yii::app()->createUrl('target/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>


