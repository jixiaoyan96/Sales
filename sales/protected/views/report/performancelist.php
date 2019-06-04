<?php
$this->pageTitle=Yii::app()->name . ' - performance Form';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'performance-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('sales','Sales Performance Form'); ?></strong>
    </h1>
</section>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('report/performance')));
                ?>
            </div>

            <div class="btn-group pull-right" role="group">
                <?php echo TbHtml::button('<span class="fa fa-download"></span> '.Yii::t('misc','Xiazai'), array(
                    'submit'=>Yii::app()->createUrl('report/xiazai')));
                ?>
            </div>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-body">
            <?php
//            echo $form->hiddenField($model, 'scenario');
//            echo $form->hiddenField($model, 'id');
//            echo $form->hiddenField($model, 'city');
//            ?>
<!--            <input type="text" name="RptFive[city]" value="--><?php //echo $fenxi['city']?><!--" style="display:none"/>-->
<!--            <input type="text" name="RptFive[start_dt]" value="--><?php //echo $fenxi['start_dt']?><!--" style="display:none"/>-->
<!--            <input type="text" name="RptFive[end_dt]" value="--><?php //echo $fenxi['end_dt']?><!--" style="display:none"/>-->
<!--            <input type="text" name="RptFive[bumen]" value="--><?php //echo $fenxi['bumen']?><!--" style="display:none"/>-->

            <table class="table table-bordered small">
              <tbody>
                <tr>
                    <td style="width: 9%;"><b>人名</b></td><td style="width: 9%;"><b>城市</b></td style="width: 9%;"><td><b>单数</b></td><td style="width: 9%;"><b>金额</b></td><td style="background-color: #9acfea;width: 9%;"><b>清洁</b></td><td style="background-color: #9acfea;width: 9%;"><b>纸品</b></td><td style="background-color: #9acfea;width: 9%;"><b>灭虫</b></td><td style="background-color: #9acfea;width: 9%;"><b>甲醛</b></td><td style="background-color: #9acfea;width: 9%;"><b>飘盈香</b></td><td style="background-color: #9acfea;width: 9%;"><b>租赁机器</b></td><td style="background-color: #9acfea;width: 9%;"><b>一次性售卖</b></td>
                </tr>
                <tr>
                    <td>xxxx</td> <td>xxxx</td> <td>xxxx</td> <td>xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td>
                </tr>
                <tr>
                    <td>xxxx</td> <td>xxxx</td> <td>xxxx</td> <td>xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td> <td style="background-color: #9acfea">xxxx</td>
                </tr>
              </tbody>
            </table>

        </div>
    </div>



</section>



<?php
$js = Script::genDeleteData(Yii::app()->createUrl('visit/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>


