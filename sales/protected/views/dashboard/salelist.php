<?php
    $suffix = Yii::app()->params['envSuffix'];
      //城市
//    $sql = "select code,name from security$suffix.sec_city where name not in ('华南2','台中','台北','台南','桃園','澳門','瑞诺','长沙','香港','高雄','中国','华东','中央支援组','华南','华南1','华西/华北',)";
//    $rows = Yii::app()->db->createCommand($sql)->queryAll();
    $bj=array('code'=>'BJ',  'name'=>'北京');
    $cd=array('code'=>'CD',  'name'=>'成都');
    $cq=array('code'=>'CQ',  'name'=>'重庆');
    $dg=array('code'=>'DG',  'name'=>'东莞');
    $fs=array('code'=>'FS',  'name'=>'佛山');
    $fz=array('code'=>'FZ',  'name'=>'福州');
    $gz=array('code'=>'GZ',  'name'=>'广州');
    $hz=array('code'=>'HZ',  'name'=>'杭州');
    $nj=array('code'=>'NJ',  'name'=>'南京');
    $nn=array('code'=>'NN',  'name'=>'南宁');
    $sh=array('code'=>'SH',  'name'=>'上海');
    $sz=array('code'=>'SZ',  'name'=>'深圳');
    $tj=array('code'=>'TJ',  'name'=>'天津');
    $wh=array('code'=>'WH',  'name'=>'武汉');
    $wx=array('code'=>'WX',  'name'=>'无锡');
    $xa=array('code'=>'XA',  'name'=>'西安');
    $zh=array('code'=>'ZH',  'name'=>'珠海');
    $zs=array('code'=>'ZS',  'name'=>'中山');

$rows=array($bj,$cd,$cq,$dg,$fs,$fz,$gz,$hz,$nj,$nn,$sh,$sz,$tj,$wh,$wx,$xa,$zh,$zs);
    foreach ($rows as $a){
         //人数
        $sql1="select distinct  username FROM sal_visit  WHERE city='".$a['code']."'";
        $people = Yii::app()->db->createCommand($sql1)->queryAll();
        $peoples=count($people);
        //单数
        $sql2="select id from sal_visit where city='".$a['code']."' and  visit_obj like '%10%'";
        $sum = Yii::app()->db->createCommand($sql2)->queryAll();
        $sums=count($sum);
        //分数
        $sale=$sums/($peoples==0?1:$peoples);
        $sale=round($sale,2)*100;
        $sale=$sale."%";
        $model['city']=$a['name'];
        $model['renjun']=$sale;
        $arr[]=$model;
    }
$last_names = array_column($arr,'renjun');
array_multisort($last_names,SORT_DESC,$arr);


?>
<div class="box">

    <div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">  <h3 class="box-title">地区销售人均签单排行榜</h3></div>

        <table border="1" style="width: 49%;text-align: center;">
            <tr style="height: 35px"><td><b>排名</b></td><td><b>城市</b></td><td><b>人均签单比例</b></td>
            <?php for($i=0;$i<count($arr);$i++) {?>
                <tr> <?php if($i<(count($arr)/2)){?><td style="color:<?php if($i==0){echo '#FF0000';}if($i==1){echo '#871F78';}if($i==2){echo '#0000FF';}?>"  ><?php echo $i+1;?></td><td style="color:<?php if($i==0){echo '#FF0000';}if($i==1){echo '#871F78';}if($i==2){echo '#0000FF';}?>"><?php echo $arr[$i]['city'];?></td><td style="color:<?php if($i==0){echo '#FF0000';}if($i==1){echo '#871F78';}if($i==2){echo '#0000FF';}?>"><?php echo $arr[$i]['renjun'];}?></td>

               </tr>
            <?php }?>
        </table>
        <table  border="1" style="width: 49%;float: right;margin-top:-224px ;text-align: center;" >
            <tr style="height: 35px"><td><b>排名</b></td><td><b>城市</b></td><td><b>人均签单比例</b></td>
                <?php for($i=0;$i<count($arr);$i++) {?>
            <tr>
                <?php if($i>(count($arr)/2-1)){?>  <td><?php echo $i+1;?></td><td><?php echo $arr[$i]['city'];?></td><td><?php echo $arr[$i]['renjun'];}?></td>
            </tr>
            <?php }?>
        </table>
        <br>
        <div class="box-footer"><small>每出现签单时即时刷新数据</small></div>
    </div>
    <div>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</div>