<?php
/* Reimbursement Form */

class ReportVisitForm extends CReportForm
{
	public $staffs;
	public $staffs_desc;
	
	protected function labelsEx() {
		return array(
				'staffs'=>Yii::t('report','Staffs'),
			);
	}
	
	protected function rulesEx() {
        return array(
            array('staffs, staffs_desc','safe'),
        );
	}
	
	protected function queueItemEx() {
		return array(
				'STAFFS'=>$this->staffs,
				'STAFFSDESC'=>$this->staffs_desc,
			);
	}
	
	public function init() {
		$this->id = 'RptFive';
		$this->name = Yii::t('app','Five Steps');
		$this->format = 'EXCEL';
		$this->city = "";
        $this->cityname ="";
		$this->fields = 'start_dt,end_dt,staffs,staffs_desc';
		$this->start_dt = date("Y/m/d");
        $this->end_dt = date("Y/m/d");
        $this->staffs = '';
        $this->bumen = '';
        $this->sale = '';
		$this->staffs_desc = Yii::t('misc','All');
	}

	public function city(){
        $suffix = Yii::app()->params['envSuffix'];
        $model = new City();
        $city=Yii::app()->user->city();
        $records=$model->getDescendant($city);
        array_unshift($records,$city);
        $cityname=array();
        foreach ($records as $k) {
            $sql = "select name from security$suffix.sec_city where code='" . $k . "'";
            $name = Yii::app()->db->createCommand($sql)->queryAll();
            $cityname[]=$name[0]['name'];
        }
        $city=array_combine($records,$cityname);
        return $city;
    }

    public function saleman(){
        $suffix = Yii::app()->params['envSuffix'];
        $city=Yii::app()->user->city();
        $sql="select code,name from hr$suffix.hr_employee WHERE  position in (SELECT id FROM hr$suffix.hr_dept where dept_class='sales') AND staff_status = 0 AND city='".$city."'";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        $sql = "select approver_type, username from account$suffix.acc_approver where city='$city' and (approver_type='regionMgr' or approver_type='regionSuper')";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        //print_r("<pre/>");
        $sql1="select employee_name from hr$suffix.hr_binding WHERE  user_id = '".$rows[0]['username']."'";
        $name = Yii::app()->db->createCommand($sql1)->queryAll();
        $sql2="select employee_name from hr$suffix.hr_binding WHERE  user_id = '".$rows[1]['username']."'";
        $names = Yii::app()->db->createCommand($sql2)->queryAll();
        if(!empty($rows)){
            $arr[] = $name[0]['employee_name'];
        }
        if(!empty($rows)){
            $arr[] = $names[0]['employee_name'];
        }
        $a=General::dedupToEmailList($arr);
        $sql3="select code,name from hr$suffix.hr_employee WHERE name='".$a[0]."'";
        $zhuguan = Yii::app()->db->createCommand($sql3)->queryAll();
        if(!empty($a[1])){
            $sql4="select code,name from hr$suffix.hr_employee WHERE name='".$a[1]."'";
            $jinli = Yii::app()->db->createCommand($sql4)->queryAll();
        }
        if(empty($jinli)){
            $records=array_merge($records,$zhuguan);
        }else{
            $records=array_merge($records,$zhuguan,$jinli);
        }
      //  print_r($records);
        return $records;
    }

    public function fenxi($model){
	    $start_dt=str_replace("/","-",$model['start_dt']);
        $end_dt=str_replace("/","-",$model['end_dt']);
        $suffix = Yii::app()->params['envSuffix'];
        $sql = "select a.*, b.name as city_name, concat(f.code,' - ',f.name) as staff,  
				d.name as visit_type_name, g.name as cust_type_name,
				h.name as district_name, VisitObjDesc(a.visit_obj) as visit_obj_name, i.cust_vip
				from sal_visit a 
				inner join hr$suffix.hr_binding c on a.username = c.user_id 
				inner join hr$suffix.hr_employee f on c.employee_id = f.id
				inner join sal_visit_type d on a.visit_type = d.id
				inner join sal_cust_type g on a.cust_type = g.id
				inner join sal_cust_district h on a.district = h.id
				left outer join security$suffix.sec_city b on a.city=b.code
				left outer join sal_custstar i on a.username=i.username and a.cust_name=i.cust_name
				where a.city='".$model['city']."' and visit_dt<='".$end_dt."' and visit_dt>='".$start_dt."'  
			";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        $sql1 = "select name
				from sal_cust_district
				where city='".$model['city']."' ";
        $record = Yii::app()->db->createCommand($sql1)->queryAll();
        $arr=array();
        $mobai=0;
        $richanggengjin=0;
        $kehuziyuan=0;
        $dianhuashangmen=0;
        $shouci=0;
        $huifang=0;
        $zengjiaxiangmu=0;
        $tingfuwu=0;
        $jianjia=0;
        $keshu=0;
        $baojia=0;
        $jiuke=0;
        $genghuanxiangmu=0;
        $qiandan=0;
        $xuyue=0;
        $zuikuan=0;
        $qitaa=0;
        $dongbeicai=0;
        $kefeiting=0;
        $xiaochi=0;
        $chuancai=0;
        $riliao=0;
        $taiguocai=0;
        $zejiangcai=0;
        $qingzhencai=0;
        $huoguo=0;
        $shaokao=0;
        $yuecai=0;
        $zizhu=0;
        $chacanting=0;
        $xican=0;
        $yuenancai=0;
        $mianbao=0;
        $yingping=0;
        $qitab=0;
        $sisdian=0;
        $ktv=0;
        $tiyuguan=0;
        $bianlidian=0;
        $julebu=0;
        $jianshenhuisuo=0;
        $qitac=0;
        $xiezilou=0;
        $yiyuan=0;
        $peixunjigou=0;
        $fangdican=0;
        $xuexiao=0;
        $gongcang=0;
        $yinglou=0;
        $yingyuan=0;
        $shuiliao=0;
        $youyong=0;
        $wuye=0;
        $wangba=0;
        $yinhang=0;
        $chaoshi=0;
        $jiuba=0;
        $jiudian=0;
        $arr['mobai']=$this->shul($mobai,$records,'visit_type_name','陌拜');
        $arr['richanggengjin']=$this->shul($richanggengjin,$records,'visit_type_name','日常跟进');
        $arr['kehuziyuan']=$this->shul($kehuziyuan,$records,'visit_type_name','客户资源');
        $arr['dianhuashangmen']=$this->shul($dianhuashangmen,$records,'visit_type_name','电话上门');
        $arr['shouci']=$this->shul($shouci,$records,'visit_obj_name','首次');
        $arr['huifang']=$this->shul($huifang,$records,'visit_obj_name','回访');
        $arr['zengjiaxiangmu']=$this->shul($zengjiaxiangmu,$records,'visit_obj_name','增加项目');
        $arr['tingfuwu']=$this->shul($tingfuwu,$records,'visit_obj_name','停服务');
        $arr['jianjia']=$this->shul($jianjia,$records,'visit_obj_name','减价');
        $arr['keshu']=$this->shul($keshu,$records,'visit_obj_name','客诉');
        $arr['baojia']=$this->shul($baojia,$records,'visit_obj_name','报价');
        $arr['jiuke']=$this->shul($jiuke,$records,'visit_obj_name','救客');
        $arr['genghuanxiangmu']=$this->shul($genghuanxiangmu,$records,'visit_obj_name','更换项目');
        $arr['qiandan']=$this->shul($qiandan,$records,'visit_obj_name','签单');
        $arr['xuyue']=$this->shul($xuyue,$records,'visit_obj_name','续约');
        $arr['zuikuan']=$this->shul($zuikuan,$records,'visit_obj_name','追款');
        $arr['qitaa']=$this->shul($qitaa,$records,'visit_obj_name','其他');

        $arr['dongbeicai']=$this->shul($dongbeicai,$records,'cust_type_name','东北/西北菜');
        $arr['kafeiting']=$this->shul($kefeiting,$records,'cust_type_name','咖啡厅');
        $arr['xiaochi']=$this->shul($xiaochi,$records,'cust_type_name','小吃快餐');
        $arr['chuancai']=$this->shul($chuancai,$records,'cust_type_name','川湘菜');
        $arr['riliao']=$this->shul($riliao,$records,'cust_type_name','日韩料理');
        $arr['taiguocai']=$this->shul($taiguocai,$records,'cust_type_name','泰国菜');
        $arr['zejiangcai']=$this->shul($zejiangcai,$records,'cust_type_name','浙江菜');
        $arr['qingzhencai']=$this->shul($qingzhencai,$records,'cust_type_name','清真菜');
        $arr['huoguo']=$this->shul($huoguo,$records,'cust_type_name','火锅');
        $arr['saokao']=$this->shul($shaokao,$records,'cust_type_name','烧烤');
        $arr['yuecai']=$this->shul($yuecai,$records,'cust_type_name','粤菜');
        $arr['zizhu']=$this->shul($zizhu,$records,'cust_type_name','自助餐');
        $arr['chacanting']=$this->shul($chacanting,$records,'cust_type_name','茶餐厅');
        $arr['xican']=$this->shul($xican,$records,'cust_type_name','西餐');
        $arr['yuenancai']=$this->shul($yuenancai,$records,'cust_type_name','越南菜');
        $arr['mianbao']=$this->shul($mianbao,$records,'cust_type_name','面包甜点');
        $arr['yingping']=$this->shul($yingping,$records,'cust_type_name','饮品店');
        $arr['qitab']=$this->shul($qitab,$records,'cust_type_name','其他');
        $arr['sisdian']=$this->shul($sisdian,$records,'cust_type_name','4S店');
        $arr['ktv']=$this->shul($ktv,$records,'cust_type_name','KTV');
        $arr['meifa']=$this->shul($ktv,$records,'cust_type_name','美发');
        $arr['tiyuguan']=$this->shul($tiyuguan,$records,'cust_type_name','体育馆');
        $arr['bianlidian']=$this->shul($bianlidian,$records,'cust_type_name','便利店');
        $arr['julebu']=$this->shul($julebu,$records,'cust_type_name','俱乐部');
        $arr['jianshenhuisuo']=$this->shul($jianshenhuisuo,$records,'cust_type_name','健身/舞蹈会所');
        $arr['qitac']=$this->shul($qitac,$records,'cust_type_name','其他');
        $arr['xiezilou']=$this->shul($xiezilou,$records,'cust_type_name','写字楼');
        $arr['yiyuan']=$this->shul($yiyuan,$records,'cust_type_name','医院');
        $arr['peixunjigou']=$this->shul($peixunjigou,$records,'cust_type_name','培训机构');
        $arr['xuexiao']=$this->shul($xuexiao,$records,'cust_type_name','学校');
        $arr['gongcang']=$this->shul($gongcang,$records,'cust_type_name','工厂');
        $arr['yinglou']=$this->shul($yinglou,$records,'cust_type_name','影楼');
        $arr['yingyuan']=$this->shul($yingyuan,$records,'cust_type_name','影院');
        $arr['fangdican']=$this->shul($fangdican,$records,'cust_type_name','房地产');
        $arr['shuiliao']=$this->shul($shuiliao,$records,'cust_type_name','水疗会所');
        $arr['youyong']=$this->shul($youyong,$records,'cust_type_name','游泳馆');
        $arr['wuye']=$this->shul($wuye,$records,'cust_type_name','物业');
        $arr['wangba']=$this->shul($wangba,$records,'cust_type_name','网吧');
        $arr['yinhang']=$this->shul($yinhang,$records,'cust_type_name','银行');
        $arr['chaoshi']=$this->shul($chaoshi,$records,'cust_type_name','超市');
        $arr['jiuba']=$this->shul($jiuba,$records,'cust_type_name','酒吧');
        $arr['jiudian']=$this->shul($jiudian,$records,'cust_type_name','酒店');

        for($i=0;$i<count($record);$i++){
            array_push($record[$i],$this->shul($jiudian,$records,'district_name',$record[$i]['name']));

        }
        $meney=$this->moneys($records);
        $arr['address']=$record;
        $arr['money']=$meney;
//        print_r('<pre/>');
//        print_r($records);
        return $arr;

    }

    public function fenxione($model){
        $start_dt=str_replace("/","-",$model['start_dt']);
        $end_dt=str_replace("/","-",$model['end_dt']);
        $suffix = Yii::app()->params['envSuffix'];
        $a=0;
        foreach ($model['sale'] as $v) {
            $sql = "select a.*, b.name as city_name, concat(f.code,' - ',f.name) as staff,  
				d.name as visit_type_name, g.name as cust_type_name,
				h.name as district_name, VisitObjDesc(a.visit_obj) as visit_obj_name, i.cust_vip
				from sal_visit a 
				inner join hr$suffix.hr_binding c on a.username = c.user_id 
				inner join hr$suffix.hr_employee f on c.employee_id = f.id
				inner join sal_visit_type d on a.visit_type = d.id
				inner join sal_cust_type g on a.cust_type = g.id
				inner join sal_cust_district h on a.district = h.id
				left outer join security$suffix.sec_city b on a.city=b.code
				left outer join sal_custstar i on a.username=i.username and a.cust_name=i.cust_name
				where a.city='" . $model['city'] . "' and visit_dt<='" . $end_dt . "' and visit_dt>='" . $start_dt . "' and  f.name='".$v."'";
            $records = Yii::app()->db->createCommand($sql)->queryAll();

                $arr['mobai']=$this->shul($a,$records,'visit_type_name','陌拜');
                $arr['richanggengjin']=$this->shul($a,$records,'visit_type_name','日常跟进');
                $arr['kehuziyuan']=$this->shul($a,$records,'visit_type_name','客户资源');
                $arr['dianhuashangmen']=$this->shul($a,$records,'visit_type_name','电话上门');
                $arr['shouci']=$this->shul($a,$records,'visit_obj_name','首次');
                $arr['huifang']=$this->shul($a,$records,'visit_obj_name','回访');
                $arr['zengjiaxiangmu']=$this->shul($a,$records,'visit_obj_name','增加项目');
                $arr['tingfuwu']=$this->shul($a,$records,'visit_obj_name','停服务');
                $arr['jianjia']=$this->shul($a,$records,'visit_obj_name','减价');
                $arr['keshu']=$this->shul($a,$records,'visit_obj_name','客诉');
                $arr['baojia']=$this->shul($a,$records,'visit_obj_name','报价');
                $arr['jiuke']=$this->shul($a,$records,'visit_obj_name','救客');
                $arr['genghuanxiangmu']=$this->shul($a,$records,'visit_obj_name','更换项目');
                $arr['qiandan']=$this->shul($a,$records,'visit_obj_name','签单');
                $arr['xuyue']=$this->shul($a,$records,'visit_obj_name','续约');
                $arr['zuikuan']=$this->shul($a,$records,'visit_obj_name','追款');
                $arr['qitaa']=$this->shul($a,$records,'visit_obj_name','其他');

                $arr['dongbeicai']=$this->shul($a,$records,'cust_type_name','东北/西北菜');
                $arr['kafeiting']=$this->shul($a,$records,'cust_type_name','咖啡厅');
                $arr['xiaochi']=$this->shul($a,$records,'cust_type_name','小吃快餐');
                $arr['chuancai']=$this->shul($a,$records,'cust_type_name','川湘菜');
                $arr['riliao']=$this->shul($a,$records,'cust_type_name','日韩料理');
                $arr['taiguocai']=$this->shul($a,$records,'cust_type_name','泰国菜');
                $arr['zejiangcai']=$this->shul($a,$records,'cust_type_name','浙江菜');
                $arr['qingzhencai']=$this->shul($a,$records,'cust_type_name','清真菜');
                $arr['huoguo']=$this->shul($a,$records,'cust_type_name','火锅');
                $arr['saokao']=$this->shul($a,$records,'cust_type_name','烧烤');
                $arr['yuecai']=$this->shul($a,$records,'cust_type_name','粤菜');
                $arr['zizhu']=$this->shul($a,$records,'cust_type_name','自助餐');
                $arr['chacanting']=$this->shul($a,$records,'cust_type_name','茶餐厅');
                $arr['xican']=$this->shul($a,$records,'cust_type_name','西餐');
                $arr['yuenancai']=$this->shul($a,$records,'cust_type_name','越南菜');
                $arr['mianbao']=$this->shul($a,$records,'cust_type_name','面包甜点');
                $arr['yingping']=$this->shul($a,$records,'cust_type_name','饮品店');
                $arr['qitab']=$this->shul($a,$records,'cust_type_name','其他');
                $arr['sisdian']=$this->shul($a,$records,'cust_type_name','4S店');
                $arr['ktv']=$this->shul($a,$records,'cust_type_name','KTV');
                $arr['meifa']=$this->shul($a,$records,'cust_type_name','美发');
                $arr['tiyuguan']=$this->shul($a,$records,'cust_type_name','体育馆');
                $arr['bianlidian']=$this->shul($a,$records,'cust_type_name','便利店');
                $arr['julebu']=$this->shul($a,$records,'cust_type_name','俱乐部');
                $arr['jianshenhuisuo']=$this->shul($a,$records,'cust_type_name','健身/舞蹈会所');
                $arr['qitac']=$this->shul($a,$records,'cust_type_name','其他');
                $arr['xiezilou']=$this->shul($a,$records,'cust_type_name','写字楼');
                $arr['yiyuan']=$this->shul($a,$records,'cust_type_name','医院');
                $arr['peixunjigou']=$this->shul($a,$records,'cust_type_name','培训机构');
                $arr['xuexiao']=$this->shul($a,$records,'cust_type_name','学校');
                $arr['gongcang']=$this->shul($a,$records,'cust_type_name','工厂');
                $arr['yinglou']=$this->shul($a,$records,'cust_type_name','影楼');
                $arr['yingyuan']=$this->shul($a,$records,'cust_type_name','影院');
                $arr['fangdican']=$this->shul($a,$records,'cust_type_name','房地产');
                $arr['shuiliao']=$this->shul($a,$records,'cust_type_name','水疗会所');
                $arr['youyong']=$this->shul($a,$records,'cust_type_name','游泳馆');
                $arr['wuye']=$this->shul($a,$records,'cust_type_name','物业');
                $arr['wangba']=$this->shul($a,$records,'cust_type_name','网吧');
                $arr['yinhang']=$this->shul($a,$records,'cust_type_name','银行');
                $arr['chaoshi']=$this->shul($a,$records,'cust_type_name','超市');
                $arr['jiuba']=$this->shul($a,$records,'cust_type_name','酒吧');
                $arr['jiudian']=$this->shul($a,$records,'cust_type_name','酒店');
                $sql1 = "select name
				from sal_cust_district
				where city='".$model['city']."' ";
                $record = Yii::app()->db->createCommand($sql1)->queryAll();
                for($i=0;$i<count($record);$i++){
                    array_push($record[$i],$this->shul($a,$records,'district_name',$record[$i]['name']));
                }
                $meney=$this->moneys($records);
                $arr['address']=$record;
                $arr['money']=$meney;
                $arr['name']=$v;
            $att[]=$arr;

        }

        //foreach ()
//        print_r('<pre/>');
      //  print_r($records);
        return $att;
    }

    public function shul($sum,$records,$name,$names){
        for($i=0;$i<count($records);$i++){
            if(strpos($records[$i][$name],$names)!==false&&(strpos($records[$i]['visit_obj_name'],'签单')!==false||strpos($records[$i]['visit_obj_name'],'续约')!==false)){
                $sum=$sum+1;
                $sql="select * from sal_visit_info where visit_id = '".$records[$i]['id']."'";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($rows as $v){
                    $arr[$v['field_id']]=$v['field_value'];
                }
                if(empty($arr['svc_A7'])){
                    $arr['svc_A7']=0;
                }
                if(empty($arr['svc_B6'])){
                    $arr['svc_B6']=0;
                }
                if(empty($arr['svc_C7'])){
                    $arr['svc_C7']=0;
                }
                if(empty($arr['svc_D6'])){
                    $arr['svc_A7']=0;
                }
                if(empty($arr['svc_E7'])){
                    $arr['svc_E7']=0;
                }
                if(empty($arr['svc_F4'])){
                    $arr['svc_F4']=0;
                }
                if(empty($arr['svc_G3'])){
                    $arr['svc_G3']=0;
                }
                $moneyone[]=$arr['svc_A7']+$arr['svc_B6']+$arr['svc_C7']+$arr['svc_D6']+$arr['svc_E7']+$arr['svc_F4']+$arr['svc_G3'];
            }
        }
        if(!empty($moneyone)){
            $money=array_sum($moneyone);
        }else{
            $money=0;
        }
        $messz=$sum."/".$money;
        return $messz;
    }

    public function moneys($records){
        $suffix = Yii::app()->params['envSuffix'];
        $a=0;
        for($i=0;$i<count($records);$i++){
	        if(strpos($records[$i]['visit_obj_name'],'签单')!==false||strpos($records[$i]['visit_obj_name'],'续约')!==false){
	            $sql="select * from sal_visit_info where visit_id = '".$records[$i]['id']."'";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
               foreach ($rows as $v){
                   $arr[$v['field_id']]=$v['field_value'];
               }
                if(empty($arr['svc_A7'])){
                    $arr['svc_A7']=0;
                }
                if(empty($arr['svc_B6'])){
                    $arr['svc_B6']=0;
                }
                if(empty($arr['svc_C7'])){
                    $arr['svc_C7']=0;
                }
                if(empty($arr['svc_D6'])){
                    $arr['svc_A7']=0;
                }
                if(empty($arr['svc_E7'])){
                    $arr['svc_E7']=0;
                }
                if(empty($arr['svc_F4'])){
                    $arr['svc_F4']=0;
                }
                if(empty($arr['svc_G3'])){
                    $arr['svc_G3']=0;
                }
                $sum[]=$arr['svc_A7']+$arr['svc_B6']+$arr['svc_C7']+$arr['svc_D6']+$arr['svc_E7']+$arr['svc_F4']+$arr['svc_G3'];
               $a=$a+1;
            }
        }
        if(!empty($sum)){
            $money['money']=array_sum($sum);
            $money['sum']=$a;
        }else{
            $money['money']=0;
            $money['sum']=0;
        }
        return $money;
    }

    public function moneyone($records){
        $suffix = Yii::app()->params['envSuffix'];
        for($i=0;$i<count($records);$i++){
            if(strpos($records[$i]['visit_obj_name'],'签单')!==false){
                $sql="select * from sal_visit_info where visit_id = '".$records[$i]['id']."'";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                foreach ($rows as $v){
                    $arr[$v['field_id']]=$v['field_value'];
                }
                if(empty($arr['svc_A7'])){
                    $arr['svc_A7']=0;
                }
                if(empty($arr['svc_B6'])){
                    $arr['svc_B6']=0;
                }
                if(empty($arr['svc_C7'])){
                    $arr['svc_C7']=0;
                }
                if(empty($arr['svc_D6'])){
                    $arr['svc_A7']=0;
                }
                if(empty($arr['svc_E7'])){
                    $arr['svc_E7']=0;
                }
                if(empty($arr['svc_F4'])){
                    $arr['svc_F4']=0;
                }
                if(empty($arr['svc_G3'])){
                    $arr['svc_G3']=0;
                }
                $sum[]=$arr['svc_A7']+$arr['svc_B6']+$arr['svc_C7']+$arr['svc_D6']+$arr['svc_E7']+$arr['svc_F4']+$arr['svc_G3'];
            }
        }
        if(!empty($sum)){
            $money=array_sum($sum);
        }else{
            $money=0;
        }
        return $money;
    }
}
