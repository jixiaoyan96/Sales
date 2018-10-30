<?php
$this->pageTitle=Yii::app()->name . ' - Sales Visit Form';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'visit-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('sales','Sales Visit Form'); ?></strong>
    </h1>
</section>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
                    'submit'=>Yii::app()->createUrl('report/visit')));
                ?>

            </div>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-body">
            <?php
            echo $form->hiddenField($model, 'scenario');
            echo $form->hiddenField($model, 'id');
            echo $form->hiddenField($model, 'city');
            ?>
            <style type="text/css">
                .tftable {font-size:12px;color:#333333;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
                .tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align: center;}
                .tftable tr {background-color:#d4e3e5;}
                .tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
                .tftable tr:hover {background-color:#ffffff;}
            </style>
            <style type="text/css">
                .tftable1 {font-size:12px;color:#333333;border-width: 1px;border-color: #9dcc7a;border-collapse: collapse;}
                .tftable1 th {font-size:12px;background-color:#abd28e;border-width: 1px;padding: 8px;border-style: solid;border-color: #9dcc7a;text-align:center;}
                .tftable1 tr {background-color:#bedda7;}
                .tftable1 td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #9dcc7a;}
                .tftable1 tr:hover {background-color:#ffffff;}
            </style>
            <style type="text/css">
                .tftable2 {font-size:12px;color:#333333;border-width: 1px;border-color: #a9a9a9;border-collapse: collapse;}
                .tftable2 th {font-size:12px;background-color:#b8b8b8;border-width: 1px;padding: 8px;border-style: solid;border-color: #a9a9a9;text-align:center;}
                .tftable2 tr {background-color:#cdcdcd;}
                .tftable2 td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #a9a9a9;}
                .tftable2 tr:hover {background-color:#ffffff;}
            </style>
            <style type="text/css">
                .tftable3 {font-size:12px;color:#333333;border-width: 1px;border-color: #ebab3a;border-collapse: collapse;}
                .tftable3 th {font-size:12px;background-color:#e6983b;border-width: 1px;padding: 8px;border-style: solid;border-color: #ebab3a;text-align:center    ;}
                .tftable3 tr {background-color:#f0c169;}
                .tftable3 td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #ebab3a;}
                .tftable3 tr:hover {background-color:#ffffff;}
            </style>
            <?php if(!empty($arr)){?>
            <div>
                <h3>部门总数据</h3>
                <h4><b>签单总金额:<?php echo $arr['money'];?> </b></h4>

                <table class="tftable" border="1">
                    <tr><th rowspan="5" width="100">拜访类型</th><th width="70">陌拜</th><td width="50"><?php echo $arr['mobai'];?>个</td><th width="70">日常跟进</th><td width="50"><?php echo $arr['richanggengjin'];?>个</td><th width="70">客户资源</th><td width="50"><?php echo $arr['kehuziyuan'];?>个</td><th width="70">电话上门</th><td width="50"><?php echo $arr['dianhuashangmen'];?>个</td></tr>
                </table>

                <table class="tftable1" border="1">
                    <tr><th rowspan="2" width="100">拜访目的</th><th width="70">首次</th><td width="50"><?php echo $arr['shouci'];?>个</td><th width="70">客诉</th><td width="50"><?php echo $arr['keshu'];?>个</td><th width="70">续约</th><td width="50"><?php echo $arr['xuyue'];?>个</td><th  width="70">回访</th><td width="50"><?php echo $arr['huifang'];?>个</td><th  width="70">报价</th><td width="50"><?php echo $arr['baojia'];?>个</td><th  width="70">追款</th><td width="50"><?php echo $arr['zuikuan'];?>个</td><th  width="70">减价</th><td width="50"><?php echo $arr['jianjia'];?>个</td></tr>
                    <tr><th>停服务</th><td><?php echo $arr['tingfuwu'];?>个</td><th>更换项目</th><td><?php echo $arr['genghuanxiangmu'];?>个</td><th>增加项目</th><td><?php echo $arr['zengjiaxiangmu'];?>个</td><th>救客</th><td><?php echo $arr['jiuke'];?>个</td><th>其他</th><td><?php echo $arr['qitaa'];?>个</td><th>签单</th><td><?php echo $arr['qiandan'];?>个</td></tr>
                </table>

                <table class="tftable2" border="1">
                    <tr><th rowspan="4" width="100">区域</th><?php for($i=0;$i<count($arr['address']);$i++){?><th width="70"><?php echo $arr['address'][$i]['name'];?></th><td width="50"><?php echo $arr['address'][$i]['0'];?></td><?php if($i==6||$i==13||$i==19||$i==27){ echo "</tr>";}?><?php }?>
                    <tr></tr>
                </table>

                <table class="tftable3" border="1">
                    <tr><th rowspan="3" width="100">客服类别（餐饮）</th><th width="70">东/西北菜</th><td width="50"><?php echo $arr['dongbeicai'];?>个</td><th width="70">泰国菜</th><td width="50"><?php echo $arr['taiguocai'];?>个</td><th width="70">粤菜</th><td width="50"><?php echo $arr['yuecai'];?>个</td><th width="70">面包甜点</th><td width="50"><?php echo $arr['mianbao'];?>个</td><th width="70">川湘菜</th><td width="50"><?php echo $arr['chuancai'];?>个</td><th width="70">火锅</th><td width="50"><?php echo $arr['huoguo'];?>个</td><th width="70">西餐</th><td width="50"><?php echo $arr['xican'];?>个</td></tr>
                    <tr><th>咖啡厅</th><td><?php echo $arr['kafeiting'];?>个</td><th>浙江菜</th><td><?php echo $arr['zejiangcai'];?>个</td><th>自助餐</th><td><?php echo $arr['zizhu'];?>个</td><th>饮品店</th><td><?php echo $arr['yingping'];?>个</td><th>日韩料理</th><td><?php echo $arr['riliao'];?>个</td><th>烧烤</th><td><?php echo $arr['saokao'];?>个</td><th>越南菜</th><td><?php echo $arr['yuenancai'];?>个</td></tr>
                    <tr><th>小吃快餐</th><td><?php echo $arr['xiaochi'];?>个</td><th>清真菜</th><td><?php echo $arr['qingzhencai'];?>个</td><th>茶餐厅</th><td><?php echo $arr['chacanting'];?>个</td><th>其他</th><td><?php echo $arr['qitab'];?>个</td></tr>
                    <tr><th rowspan="5" width="100">客服类别（非餐饮）</th><th>4S店</th><td><?php echo $arr['sisdian'];?>个</td><th>健身会所</th><td><?php echo $arr['jianshenhuisuo'];?>个</td><th>房地产</th><td><?php echo $arr['fangdican'];?>个</td><th>美容/发馆</th><td><?php echo $arr['meifa'];?>个</td><th width="70">银行</th width="70"><td>xx个</td><th width="70">俱乐部</th><td><?php echo $arr['julebu'];?>个</td><th width="70">培训机构</th><td><?php echo $arr['peixunjigou'];?>个</td> </tr>
                    <tr><th>KTV</th><td><?php echo $arr['ktv'];?>个</td><th>其他</th><td><?php echo $arr['qitac'];?>个</td><th>学校</th><td><?php echo $arr['xuexiao'];?>个</td><th>水疗会所</th><td><?php echo $arr['shuiliao'];?>个</td><th>超市</th><td><?php echo $arr['chaoshi'];?>个</td><th width="70">网吧</th><td><?php echo $arr['wangba'];?>个</td><th width="70">影院</th><td><?php echo $arr['yingyuan'];?>个</td></tr>
                    <tr><th>体育馆</th><td><?php echo $arr['tiyuguan'];?>个</td><th>写字楼</th><td><?php echo $arr['xiezilou'];?>个</td><th>工厂</th><td><?php echo $arr['gongcang'];?>个</td><th>游泳馆</th><td><?php echo $arr['youyong'];?>个</td><th>酒吧</th><td><?php echo $arr['jiuba'];?>个</td><th>物业</th><td><?php echo $arr['wuye'];?>个</td><th>酒店</th><td><?php echo $arr['jiudian'];?>个</td></tr>
                    <tr><th>便利店</th><td><?php echo $arr['bianlidian'];?>个</td><th>医院</th><td><?php echo $arr['yiyuan'];?>个</td><th>影楼</th><td><?php echo $arr['yinglou'];?>个</td></tr>

                </table>
            </div>
            <?php }?>
            <?php if(!empty($one)){ foreach ($one as $arr){?>
            <div>
                <h3><?php echo $arr['name'];?>的数据</h3>
                <h4><b>签单总金额：<?php echo $arr['money'];?> </b></h4>

                <table class="tftable" border="1">
                    <tr><th rowspan="5" width="100">拜访类型</th><th width="70">陌拜</th><td width="50"><?php echo $arr['mobai'];?>个</td><th width="70">日常跟进</th><td width="50"><?php echo $arr['richanggengjin'];?>个</td><th width="70">客户资源</th><td width="50"><?php echo $arr['kehuziyuan'];?>个</td><th width="70">电话上门</th><td width="50"><?php echo $arr['dianhuashangmen'];?>个</td></tr>
                </table>
                <table class="tftable1" border="1">
                    <tr><th rowspan="2" width="100">拜访目的</th><th width="70">首次</th><td width="50"><?php echo $arr['shouci'];?>个</td><th width="70">客诉</th><td width="50"><?php echo $arr['keshu'];?>个</td><th width="70">续约</th><td width="50"><?php echo $arr['xuyue'];?>个</td><th  width="70">回访</th><td width="50"><?php echo $arr['huifang'];?>个</td><th  width="70">报价</th><td width="50"><?php echo $arr['baojia'];?>个</td><th  width="70">追款</th><td width="50"><?php echo $arr['zuikuan'];?>个</td><th  width="70">减价</th><td width="50"><?php echo $arr['jianjia'];?>个</td></tr>
                    <tr><th>停服务</th><td><?php echo $arr['tingfuwu'];?>个</td><th>更换项目</th><td><?php echo $arr['genghuanxiangmu'];?>个</td><th>增加项目</th><td><?php echo $arr['zengjiaxiangmu'];?>个</td><th>救客</th><td><?php echo $arr['jiuke'];?>个</td><th>其他</th><td><?php echo $arr['qitaa'];?>个</td><th>签单</th><td><?php echo $arr['qiandan'];?>个</td></tr>
                </table>
                <table class="tftable2" border="1">
                    <tr><th rowspan="4" width="100">区域</th><?php for($i=0;$i<count($arr['address']);$i++){?><th width="70"><?php echo $arr['address'][$i]['name'];?></th><td width="50"><?php echo $arr['address'][$i]['0'];?></td><?php if($i==6||$i==13||$i==19||$i==27){ echo "</tr>";}?><?php }?>
                    <tr></tr>
                </table>
                <table class="tftable3" border="1">
                    <tr><th rowspan="3" width="100">客服类别（餐饮）</th><th width="70">东/西北菜</th><td width="50"><?php echo $arr['dongbeicai'];?>个</td><th width="70">泰国菜</th><td width="50"><?php echo $arr['taiguocai'];?>个</td><th width="70">粤菜</th><td width="50"><?php echo $arr['yuecai'];?>个</td><th width="70">面包甜点</th><td width="50"><?php echo $arr['mianbao'];?>个</td><th width="70">川湘菜</th><td width="50"><?php echo $arr['chuancai'];?>个</td><th width="70">火锅</th><td width="50"><?php echo $arr['huoguo'];?>个</td><th width="70">西餐</th><td width="50"><?php echo $arr['xican'];?>个</td></tr>
                    <tr><th>咖啡厅</th><td><?php echo $arr['kafeiting'];?>个</td><th>浙江菜</th><td><?php echo $arr['zejiangcai'];?>个</td><th>自助餐</th><td><?php echo $arr['zizhu'];?>个</td><th>饮品店</th><td><?php echo $arr['yingping'];?>个</td><th>日韩料理</th><td><?php echo $arr['riliao'];?>个</td><th>烧烤</th><td><?php echo $arr['saokao'];?>个</td><th>越南菜</th><td><?php echo $arr['yuenancai'];?>个</td></tr>
                    <tr><th>小吃快餐</th><td><?php echo $arr['xiaochi'];?>个</td><th>清真菜</th><td><?php echo $arr['qingzhencai'];?>个</td><th>茶餐厅</th><td><?php echo $arr['chacanting'];?>个</td><th>其他</th><td><?php echo $arr['qitab'];?>个</td></tr>
                    <tr><th rowspan="5" width="100">客服类别（非餐饮）</th><th>4S店</th><td><?php echo $arr['sisdian'];?>个</td><th>健身会所</th><td><?php echo $arr['jianshenhuisuo'];?>个</td><th>房地产</th><td><?php echo $arr['fangdican'];?>个</td><th>美容/发馆</th><td><?php echo $arr['meifa'];?>个</td><th width="70">银行</th width="70"><td>xx个</td><th width="70">俱乐部</th><td><?php echo $arr['julebu'];?>个</td><th width="70">培训机构</th><td><?php echo $arr['peixunjigou'];?>个</td> </tr>
                    <tr><th>KTV</th><td><?php echo $arr['ktv'];?>个</td><th>其他</th><td><?php echo $arr['qitac'];?>个</td><th>学校</th><td><?php echo $arr['xuexiao'];?>个</td><th>水疗会所</th><td><?php echo $arr['shuiliao'];?>个</td><th>超市</th><td><?php echo $arr['chaoshi'];?>个</td><th width="70">网吧</th><td><?php echo $arr['wangba'];?>个</td><th width="70">影院</th><td><?php echo $arr['yingyuan'];?>个</td></tr>
                    <tr><th>体育馆</th><td><?php echo $arr['tiyuguan'];?>个</td><th>写字楼</th><td><?php echo $arr['xiezilou'];?>个</td><th>工厂</th><td><?php echo $arr['gongcang'];?>个</td><th>游泳馆</th><td><?php echo $arr['youyong'];?>个</td><th>酒吧</th><td><?php echo $arr['jiuba'];?>个</td><th>物业</th><td><?php echo $arr['wuye'];?>个</td><th>酒店</th><td><?php echo $arr['jiudian'];?>个</td></tr>
                    <tr><th>便利店</th><td><?php echo $arr['bianlidian'];?>个</td><th>医院</th><td><?php echo $arr['yiyuan'];?>个</td><th>影楼</th><td><?php echo $arr['yinglou'];?>个</td></tr>
                </table>
            </div>
            <?php } } ?>
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


