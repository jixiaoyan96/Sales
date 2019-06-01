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
	
<<<<<<< HEAD
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
=======
	public function actionSalepeople() {
		$suffix = Yii::app()->params['envSuffix'];
		$models = array();
		$time= date('Y-m-d', strtotime(date('Y-m-01') ));
		$sql = "select a.city, a.username, sum(convert(b.field_value, decimal(12,2))) as money
				from sal_visit a force index (idx_visit_02), sal_visit_info b
				where a.id=b.visit_id and b.field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') 
				and a.visit_dt > '$time' and  a.visit_obj like '%10%'
				group by a.city, a.username
			";
		$records = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($records as $record) {
			$temp = array();
			$temp['user']=$record['username'];
			$temp['money']=$record['money'];
>>>>>>> b8cedcd41a0a5c597505f618e36a74b2c23530eb

			$sql = "select employee_name from hr$suffix.hr_binding where user_id='".$record['username']."'";
			$row = Yii::app()->db->createCommand($sql)->queryRow();
			$temp['name']= $row!==false ? $row['employee_name'] : $record['username'];
		
			$sql = "select a.name as city_name, b.name as region_name 
					from security$suffix.sec_city a
					left outer join security$suffix.sec_city b on a.region=b.code
					where a.code='".$record['city']."'
				";
			$row = Yii::app()->db->createCommand($sql)->queryRow();
			$temp['city'] = $row!==false ? $row['city_name'] : $record['city'];
			$temp['quyu'] = $row!==false ? str_replace(array('1','2','3','4','5','6','7','8','9','0'),'',$row['region_name']) : '空';

			$models[] = $temp;
		}
		$last_names = array_column($models,'money');
		array_multisort($last_names,SORT_DESC,$models);
		$models = array_slice($models, 0, 20);

<<<<<<< HEAD
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
=======
		echo json_encode($models);
	}
>>>>>>> b8cedcd41a0a5c597505f618e36a74b2c23530eb

    public function actionSalelist() {
		$suffix = Yii::app()->params['envSuffix'];
		$models = array();
		$cities = General::getCityListWithNoDescendant();
		foreach ($cities as $code=>$name) {
			if (strpos('/CS/H-N/HK/TC/TP/ZS1/TY/KS/TN/XM//KH/ZY/MO/RN/MY/',$code)===false) {
				$sql = "select a.name as city_name, b.name as region_name 
						from security$suffix.sec_city a
						left outer join security$suffix.sec_city b on a.region=b.code
						where a.code='$code'
					";
				$row = Yii::app()->db->createCommand($sql)->queryRow();
				$temp = $row!==false ? str_replace(array('1','2','3','4','5','6','7','8','9','0'),'',$row['region_name']) : '空';
				$models[$code] = array('city'=>$name, 'renjun'=>0, 'quyu'=>$temp);
			}
		}

		$time= date('Y-m-d', strtotime(date('Y-m-01') ));
		$sql = "select a.city, a.username, count(a.username) as renjun
				from sal_visit a force index (idx_visit_02), sal_visit_info b
				where a.id=b.visit_id and b.field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') 
				and a.visit_dt > '$time' and  a.visit_obj like '%10%'
				group by a.city, a.username 
			";
		$records = Yii::app()->db->createCommand($sql)->queryAll();
		$lastcity = '';
		$num = 0;
		$cnt = 0;
		foreach ($records as $record) {
			if (strpos('/CS/H-N/HK/TC/TP/ZS1/TY/KS/TN/XM//KH/ZY/MO/RN/MY/',$record['city'])===false) {
				if ($lastcity!=$record['city']) {
					if ($lastcity!='') {
						$models[$record['city']]['renjun'] = round($cnt/($num==0?1:$num), 2);
					}
					$num = 0;
					$cnt = 0;
					$lastcity = $record['city'];
				}
				$num++;
				$cnt += $record['renjun'];
			}
		}
		
		$result = array();
		foreach ($models as $key=>$item) {
			$result[] = $item;
		}
		
        $arraycol = array_column($result,'renjun');
        array_multisort($arraycol,SORT_DESC,$result);
        echo json_encode($result);
    }

    public function actionSalelists() {
<<<<<<< HEAD
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
=======
		$suffix = Yii::app()->params['envSuffix'];
		$models = array();
		$cities = General::getCityListWithNoDescendant();
		foreach ($cities as $code=>$name) {
			if (strpos('/CS/H-N/HK/TC/TP/ZS1/TY/KS/TN/XM/KH/ZY/MO/RN/MY/',$code)===false) {
				$sql = "select a.name as city_name, b.name as region_name 
						from security$suffix.sec_city a
						left outer join security$suffix.sec_city b on a.region=b.code
						where a.code='$code'
					";
				$row = Yii::app()->db->createCommand($sql)->queryRow();
				$temp = $row!==false ? str_replace(array('1','2','3','4','5','6','7','8','9','0'),'',$row['region_name']) : '空';
				$models[$code] = array('city'=>$name, 'money'=>number_format((float)0, 2, '.', ''), 'quyu'=>$temp);
			}
		}
>>>>>>> b8cedcd41a0a5c597505f618e36a74b2c23530eb

		$time= date('Y-m-d', strtotime(date('Y-m-01') ));
		$sql = "select a.city, a.username, sum(convert(b.field_value, decimal(12,2))) as money
				from sal_visit a force index (idx_visit_02), sal_visit_info b
				where a.id=b.visit_id and b.field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') 
				and a.visit_dt > '$time' and  a.visit_obj like '%10%'
				group by a.city, a.username 
			";
		$records = Yii::app()->db->createCommand($sql)->queryAll();
		$lastcity = '';
		$num = 0;
		$amt = 0;
		foreach ($records as $record) {
			if (strpos('/CS/H-N/HK/TC/TP/ZS1/TY/KS/TN/XM//KH/ZY/MO/RN/MY/',$record['city'])===false) {
				if ($lastcity!=$record['city']) {
					if ($lastcity!='') {
						$tmp = $amt/($num==0?1:$num);
						$models[$record['city']]['money'] = number_format((float)$tmp, 2, '.', '');
					}
					$num = 0;
					$amt = 0;
					$lastcity = $record['city'];
				}
			}
			$num++;
			$amt += $record['money'];
		}
		
		$result = array();
		foreach ($models as $key=>$item) {
			$result[] = $item;
		}
		
        $arraycol = array_column($result,'money');
        array_multisort($arraycol,SORT_DESC,$result);
        echo json_encode($result);
    }
}

?>