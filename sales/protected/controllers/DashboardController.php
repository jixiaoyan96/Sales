<?php

class DashboardController extends Controller
{
	public $interactive = false;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl - checksession', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('notify','salepeople','Salelist','Salelists'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionNotify($id=-1) {
		$rtn = array();
		if ($id >= 0) {
			$model = new Notification();
			$rtn = $model->getNewMessageById($id);
		}
		echo json_encode($rtn);
	}
	
public function actionSalepeople() {
    $suffix = Yii::app()->params['envSuffix'];
    $models=array();
    $time= date('Y-m-d', strtotime(date('Y-m-01') ));
    $sql="select distinct  a.username ,c.employee_name ,b.name  FROM sal_visit a 
          inner join hr$suffix.hr_binding c on a.username = c.user_id 
          inner join security$suffix.sec_city b on a.city = b.code 
          where a.lud >='2019-06-01'
          ";
    //人名
    $people = Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($people as $a){
        $sql1="select id from sal_visit where username='".$a['username']."' and  visit_obj like '%10%' and lud >='".$time."'";
        $id = Yii::app()->db->createCommand($sql1)->queryAll();
        //区域
        $sql="select name from security$suffix.sec_city where code=(select region from security$suffix.sec_city where name='".$a['name']."')";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        //单数
        //$sums=count($id);
        $money=0;
        $moneys=0;
        foreach ($id as $b){
            $sql2="select field_id, field_value from sal_visit_info where field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') and visit_id = '".$b['id']."'";
            $array = Yii::app()->db->createCommand($sql2)->queryAll();
            $summoney = 0;
            foreach($array as $item){
                $summoney += $item['field_value'];
            }
            //总金额
            $money+=$summoney;
        }
        $moneys+=$money;
        if(!empty($rows)){
            $model['quyu']=preg_replace('|[0-9a-zA-Z/]+|','',$rows[0]['name']);
        }else{
            $model['quyu']='空';
        }
        $model['name']=$a['employee_name'];
        $model['user']=$a['username'];
        $model['city']=$a['name'];;
        $model['money']=$moneys;
        $models[]=$model;
        $last_names = array_column($models,'money');
        array_multisort($last_names,SORT_DESC,$models);
        $models = array_slice($models, 0, 20);
	}

	echo json_encode($models);
}

    public function actionSalelist() {
        $suffix = Yii::app()->params['envSuffix'];
        $time= date('Y-m-d', strtotime(date('Y-m-01') ));
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
            //区域
            $sql="select name from security$suffix.sec_city where code=(select region from security$suffix.sec_city where code='".$a['code']."')";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            //人数
            $sql1="select distinct  username FROM sal_visit  WHERE city='".$a['code']."'and lud >='".$time."'";
            $people = Yii::app()->db->createCommand($sql1)->queryAll();
            $peoples=count($people);
            //总单数
            $sql2="select id from sal_visit where city='".$a['code']."' and  visit_obj like '%10%' and lud >='".$time."'";
            $sum = Yii::app()->db->createCommand($sql2)->queryAll();
            $sums=count($sum);
            //人均签单数
            $sale=$sums/($peoples==0?1:$peoples);
            $sale=round($sale,2);
            //人均签单金额
            $money=0;
            foreach ($sum as $b){
                $sql3="select field_id, field_value from sal_visit_info where field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') and visit_id = '".$b['id']."'";
                $array = Yii::app()->db->createCommand($sql3)->queryAll();
                $summoney = 0;
                foreach($array as $item){
                    $summoney += $item['field_value'];
                }
                //总金额
                $money+=$summoney;

            }
            $money=$money/($peoples==0?1:$peoples);
            $money=round($money,2);
            $model['city']=$a['name'];
            $model['renjun']=$sale;
            $model['money']=$money;
            if(!empty($rows)){
                $model['quyu']=preg_replace('|[0-9a-zA-Z/]+|','',$rows[0]['name']);
            }else{
                $model['quyu']='空';
            }
            $arr[]=$model;
            $arrs[]=$model;
        }

        $last_names = array_column($arr,'renjun');
        array_multisort($last_names,SORT_DESC,$arr);
        echo json_encode($arr);
    }


    public function actionSalelists() {
        $time= date('Y-m-d', strtotime(date('Y-m-01') ));
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
            //区域
            $sql="select name from security$suffix.sec_city where code=(select region from security$suffix.sec_city where code='".$a['code']."')";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            //人数
            $sql1="select distinct  username FROM sal_visit  WHERE city='".$a['code']."' and lud >='".$time."'";
            $people = Yii::app()->db->createCommand($sql1)->queryAll();
            $peoples=count($people);
            //总单数
            $sql2="select id from sal_visit where city='".$a['code']."' and  visit_obj like '%10%' and lud >='".$time."'";
            $sum = Yii::app()->db->createCommand($sql2)->queryAll();
            $sums=count($sum);
            //人均签单数
            $sale=$sums/($peoples==0?1:$peoples);
            $sale=round($sale,2);
            //人均签单金额
            $money=0;
            foreach ($sum as $b){
                $sql3="select field_id, field_value from sal_visit_info where field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') and visit_id = '".$b['id']."'";
                $array = Yii::app()->db->createCommand($sql3)->queryAll();
                $summoney = 0;
                foreach($array as $item){
                    $summoney += $item['field_value'];
                }
                //总金额
                $money+=$summoney;

            }
            $money=$money/($peoples==0?1:$peoples);
            $money=round($money,2);
            $model['city']=$a['name'];
            $model['renjun']=$sale;
            $model['money']=$money;
            if(!empty($rows)){
                $model['quyu']=preg_replace('|[0-9a-zA-Z/]+|','',$rows[0]['name']);
            }else{
                $model['quyu']='空';
            }
            $arr[]=$model;
        }

        $last_names = array_column($arr,'money');
        array_multisort($last_names,SORT_DESC,$arr);
        echo json_encode($arr);
    }

}

?>