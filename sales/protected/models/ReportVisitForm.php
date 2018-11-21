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
        $this->all = '';
        $this->one = '';
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

    public function fenxis($model){
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
        $arr['mobai']=$this->shuls($mobai,$records,'visit_type_name','陌拜');
        $arr['richanggengjin']=$this->shuls($richanggengjin,$records,'visit_type_name','日常跟进');
        $arr['kehuziyuan']=$this->shuls($kehuziyuan,$records,'visit_type_name','客户资源');
        $arr['dianhuashangmen']=$this->shuls($dianhuashangmen,$records,'visit_type_name','电话上门');
        $arr['shouci']=$this->shuls($shouci,$records,'visit_obj_name','首次');
        $arr['huifang']=$this->shuls($huifang,$records,'visit_obj_name','回访');
        $arr['zengjiaxiangmu']=$this->shuls($zengjiaxiangmu,$records,'visit_obj_name','增加项目');
        $arr['tingfuwu']=$this->shuls($tingfuwu,$records,'visit_obj_name','停服务');
        $arr['jianjia']=$this->shuls($jianjia,$records,'visit_obj_name','减价');
        $arr['keshu']=$this->shuls($keshu,$records,'visit_obj_name','客诉');
        $arr['baojia']=$this->shuls($baojia,$records,'visit_obj_name','报价');
        $arr['jiuke']=$this->shuls($jiuke,$records,'visit_obj_name','救客');
        $arr['genghuanxiangmu']=$this->shuls($genghuanxiangmu,$records,'visit_obj_name','更换项目');
        $arr['qiandan']=$this->shuls($qiandan,$records,'visit_obj_name','签单');
        $arr['xuyue']=$this->shuls($xuyue,$records,'visit_obj_name','续约');
        $arr['zuikuan']=$this->shuls($zuikuan,$records,'visit_obj_name','追款');
        $arr['qitaa']=$this->shuls($qitaa,$records,'visit_obj_name','其他');

        $arr['dongbeicai']=$this->shuls($dongbeicai,$records,'cust_type_name','东北/西北菜');
        $arr['kafeiting']=$this->shuls($kefeiting,$records,'cust_type_name','咖啡厅');
        $arr['xiaochi']=$this->shuls($xiaochi,$records,'cust_type_name','小吃快餐');
        $arr['chuancai']=$this->shuls($chuancai,$records,'cust_type_name','川湘菜');
        $arr['riliao']=$this->shuls($riliao,$records,'cust_type_name','日韩料理');
        $arr['taiguocai']=$this->shuls($taiguocai,$records,'cust_type_name','泰国菜');
        $arr['zejiangcai']=$this->shuls($zejiangcai,$records,'cust_type_name','浙江菜');
        $arr['qingzhencai']=$this->shuls($qingzhencai,$records,'cust_type_name','清真菜');
        $arr['huoguo']=$this->shuls($huoguo,$records,'cust_type_name','火锅');
        $arr['saokao']=$this->shuls($shaokao,$records,'cust_type_name','烧烤');
        $arr['yuecai']=$this->shuls($yuecai,$records,'cust_type_name','粤菜');
        $arr['zizhu']=$this->shuls($zizhu,$records,'cust_type_name','自助餐');
        $arr['chacanting']=$this->shuls($chacanting,$records,'cust_type_name','茶餐厅');
        $arr['xican']=$this->shuls($xican,$records,'cust_type_name','西餐');
        $arr['yuenancai']=$this->shuls($yuenancai,$records,'cust_type_name','越南菜');
        $arr['mianbao']=$this->shuls($mianbao,$records,'cust_type_name','面包甜点');
        $arr['yingping']=$this->shuls($yingping,$records,'cust_type_name','饮品店');
        $arr['qitab']=$this->shuls($qitab,$records,'cust_type_name','其他');
        $arr['sisdian']=$this->shuls($sisdian,$records,'cust_type_name','4S店');
        $arr['ktv']=$this->shuls($ktv,$records,'cust_type_name','KTV');
        $arr['meifa']=$this->shuls($ktv,$records,'cust_type_name','美发');
        $arr['tiyuguan']=$this->shuls($tiyuguan,$records,'cust_type_name','体育馆');
        $arr['bianlidian']=$this->shuls($bianlidian,$records,'cust_type_name','便利店');
        $arr['julebu']=$this->shuls($julebu,$records,'cust_type_name','俱乐部');
        $arr['jianshenhuisuo']=$this->shuls($jianshenhuisuo,$records,'cust_type_name','健身/舞蹈会所');
        $arr['qitac']=$this->shuls($qitac,$records,'cust_type_name','其他');
        $arr['xiezilou']=$this->shuls($xiezilou,$records,'cust_type_name','写字楼');
        $arr['yiyuan']=$this->shuls($yiyuan,$records,'cust_type_name','医院');
        $arr['peixunjigou']=$this->shuls($peixunjigou,$records,'cust_type_name','培训机构');
        $arr['xuexiao']=$this->shuls($xuexiao,$records,'cust_type_name','学校');
        $arr['gongcang']=$this->shuls($gongcang,$records,'cust_type_name','工厂');
        $arr['yinglou']=$this->shuls($yinglou,$records,'cust_type_name','影楼');
        $arr['yingyuan']=$this->shuls($yingyuan,$records,'cust_type_name','影院');
        $arr['fangdican']=$this->shuls($fangdican,$records,'cust_type_name','房地产');
        $arr['shuiliao']=$this->shuls($shuiliao,$records,'cust_type_name','水疗会所');
        $arr['youyong']=$this->shuls($youyong,$records,'cust_type_name','游泳馆');
        $arr['wuye']=$this->shuls($wuye,$records,'cust_type_name','物业');
        $arr['wangba']=$this->shuls($wangba,$records,'cust_type_name','网吧');
        $arr['yinhang']=$this->shuls($yinhang,$records,'cust_type_name','银行');
        $arr['chaoshi']=$this->shuls($chaoshi,$records,'cust_type_name','超市');
        $arr['jiuba']=$this->shuls($jiuba,$records,'cust_type_name','酒吧');
        $arr['jiudian']=$this->shuls($jiudian,$records,'cust_type_name','酒店');

        for($i=0;$i<count($record);$i++){
            array_push($record[$i],$this->shuls($jiudian,$records,'district_name',$record[$i]['name']));

        }
        $meney=$this->moneys($records);
        $arr['address']=$record;
        $arr['money']=$meney;
//        print_r('<pre/>');
//        print_r($records);
        return $arr;

    }


    public function fenxiones($model){
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

            $arr['mobai']=$this->shuls($a,$records,'visit_type_name','陌拜');
            $arr['richanggengjin']=$this->shuls($a,$records,'visit_type_name','日常跟进');
            $arr['kehuziyuan']=$this->shuls($a,$records,'visit_type_name','客户资源');
            $arr['dianhuashangmen']=$this->shuls($a,$records,'visit_type_name','电话上门');
            $arr['shouci']=$this->shuls($a,$records,'visit_obj_name','首次');
            $arr['huifang']=$this->shuls($a,$records,'visit_obj_name','回访');
            $arr['zengjiaxiangmu']=$this->shuls($a,$records,'visit_obj_name','增加项目');
            $arr['tingfuwu']=$this->shuls($a,$records,'visit_obj_name','停服务');
            $arr['jianjia']=$this->shuls($a,$records,'visit_obj_name','减价');
            $arr['keshu']=$this->shuls($a,$records,'visit_obj_name','客诉');
            $arr['baojia']=$this->shuls($a,$records,'visit_obj_name','报价');
            $arr['jiuke']=$this->shuls($a,$records,'visit_obj_name','救客');
            $arr['genghuanxiangmu']=$this->shuls($a,$records,'visit_obj_name','更换项目');
            $arr['qiandan']=$this->shuls($a,$records,'visit_obj_name','签单');
            $arr['xuyue']=$this->shuls($a,$records,'visit_obj_name','续约');
            $arr['zuikuan']=$this->shuls($a,$records,'visit_obj_name','追款');
            $arr['qitaa']=$this->shuls($a,$records,'visit_obj_name','其他');

            $arr['dongbeicai']=$this->shuls($a,$records,'cust_type_name','东北/西北菜');
            $arr['kafeiting']=$this->shuls($a,$records,'cust_type_name','咖啡厅');
            $arr['xiaochi']=$this->shuls($a,$records,'cust_type_name','小吃快餐');
            $arr['chuancai']=$this->shuls($a,$records,'cust_type_name','川湘菜');
            $arr['riliao']=$this->shuls($a,$records,'cust_type_name','日韩料理');
            $arr['taiguocai']=$this->shuls($a,$records,'cust_type_name','泰国菜');
            $arr['zejiangcai']=$this->shuls($a,$records,'cust_type_name','浙江菜');
            $arr['qingzhencai']=$this->shuls($a,$records,'cust_type_name','清真菜');
            $arr['huoguo']=$this->shuls($a,$records,'cust_type_name','火锅');
            $arr['saokao']=$this->shuls($a,$records,'cust_type_name','烧烤');
            $arr['yuecai']=$this->shuls($a,$records,'cust_type_name','粤菜');
            $arr['zizhu']=$this->shuls($a,$records,'cust_type_name','自助餐');
            $arr['chacanting']=$this->shuls($a,$records,'cust_type_name','茶餐厅');
            $arr['xican']=$this->shuls($a,$records,'cust_type_name','西餐');
            $arr['yuenancai']=$this->shuls($a,$records,'cust_type_name','越南菜');
            $arr['mianbao']=$this->shuls($a,$records,'cust_type_name','面包甜点');
            $arr['yingping']=$this->shuls($a,$records,'cust_type_name','饮品店');
            $arr['qitab']=$this->shuls($a,$records,'cust_type_name','其他');
            $arr['sisdian']=$this->shuls($a,$records,'cust_type_name','4S店');
            $arr['ktv']=$this->shuls($a,$records,'cust_type_name','KTV');
            $arr['meifa']=$this->shuls($a,$records,'cust_type_name','美发');
            $arr['tiyuguan']=$this->shuls($a,$records,'cust_type_name','体育馆');
            $arr['bianlidian']=$this->shuls($a,$records,'cust_type_name','便利店');
            $arr['julebu']=$this->shuls($a,$records,'cust_type_name','俱乐部');
            $arr['jianshenhuisuo']=$this->shuls($a,$records,'cust_type_name','健身/舞蹈会所');
            $arr['qitac']=$this->shuls($a,$records,'cust_type_name','其他');
            $arr['xiezilou']=$this->shuls($a,$records,'cust_type_name','写字楼');
            $arr['yiyuan']=$this->shuls($a,$records,'cust_type_name','医院');
            $arr['peixunjigou']=$this->shuls($a,$records,'cust_type_name','培训机构');
            $arr['xuexiao']=$this->shuls($a,$records,'cust_type_name','学校');
            $arr['gongcang']=$this->shuls($a,$records,'cust_type_name','工厂');
            $arr['yinglou']=$this->shuls($a,$records,'cust_type_name','影楼');
            $arr['yingyuan']=$this->shuls($a,$records,'cust_type_name','影院');
            $arr['fangdican']=$this->shuls($a,$records,'cust_type_name','房地产');
            $arr['shuiliao']=$this->shuls($a,$records,'cust_type_name','水疗会所');
            $arr['youyong']=$this->shuls($a,$records,'cust_type_name','游泳馆');
            $arr['wuye']=$this->shuls($a,$records,'cust_type_name','物业');
            $arr['wangba']=$this->shuls($a,$records,'cust_type_name','网吧');
            $arr['yinhang']=$this->shuls($a,$records,'cust_type_name','银行');
            $arr['chaoshi']=$this->shuls($a,$records,'cust_type_name','超市');
            $arr['jiuba']=$this->shuls($a,$records,'cust_type_name','酒吧');
            $arr['jiudian']=$this->shuls($a,$records,'cust_type_name','酒店');
            $sql1 = "select name
				from sal_cust_district
				where city='".$model['city']."' ";
            $record = Yii::app()->db->createCommand($sql1)->queryAll();
            for($i=0;$i<count($record);$i++){
                array_push($record[$i],$this->shuls($a,$records,'district_name',$record[$i]['name']));
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

    public function shuls($sum,$records,$name,$names){
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
        $messz['sum']=$sum;
        $messz['money']=$money;
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

    public function retrieveDatas($model){
        Yii::$enableIncludePath = false;
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        //spl_autoload_unregister(array('YiiBase','autoload'));
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel;
        $objReader  = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath.'/commands/template/sale.xlsx';
        $objPHPExcel = $objReader->load($path);
//        print_r("<pre>");
//        print_r($model);
        if(!empty($model['all'])){
            $i=3;
            $ex=$i;
            $i1=$i+1;
            $i2=$i+2;
            $i3=$i+3;
            $i4=$i+4;
            $i5=$i+5;
            $i6=$i+6;
            $i7=$i+7;
            $i8=$i+8;
            $i9=$i+9;
            $i10=$i+10;
            $i11=$i+11;
            $i12=$i+12;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,'部门总数据') ;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i1,'签单总金额：'.$model['all']['money']['money'].'签单总数'.$model['all']['money']['sum']) ;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':V'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i1.':V'.$i1);
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(25);
            $objPHPExcel->getActiveSheet()->getRowDimension($i1)->setRowHeight(25);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i2,'拜访类型') ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i2,'陌拜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i2,$model['all']['mobai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i2,$model['all']['mobai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i2,'日常跟进') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i2,$model['all']['richanggengjin']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i2,$model['all']['richanggengjin']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i2,'客户资源') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i2,$model['all']['kehuziyuan']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i2,$model['all']['kehuziyuan']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i2,'电话上门') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i2,$model['all']['dianhuashangmen']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i2,$model['all']['dianhuashangmen']['money']) ;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i3,'拜访目的') ;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i3.':A'.$i4);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i3,'首次') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i3,$model['all']['shouci']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i3,$model['all']['shouci']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i3,'客诉') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i3,$model['all']['keshu']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i3,$model['all']['keshu']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i3,'续约') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i3,$model['all']['xuyue']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i3,$model['all']['xuyue']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i3,'回访') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i3,$model['all']['huifang']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i3,$model['all']['huifang']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i3,'报价') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i3,$model['all']['baojia']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i3,$model['all']['baojia']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i3,'追款') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i3,$model['all']['zuikuan']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i3,$model['all']['zuikuan']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i3,'减价') ;
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i3,$model['all']['jianjia']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i3,$model['all']['jianjia']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i4,'停服务') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i4,$model['all']['tingfuwu']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i4,$model['all']['tingfuwu']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i4,'更换项目') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i4,$model['all']['genghuanxiangmu']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i4,$model['all']['genghuanxiangmu']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i4,'增加项目') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i4,$model['all']['zengjiaxiangmu']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i4,$model['all']['zengjiaxiangmu']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i4,'救客') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i4,$model['all']['jiuke']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i4,$model['all']['jiuke']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i4,'其他') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i4,$model['all']['qitaa']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i4,$model['all']['qitaa']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i4,'签单') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i4,$model['all']['qiandan']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i4,$model['all']['qiandan']['money']) ;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i5,'客服类别（餐饮）') ;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i5.':A'.$i7);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i5,'东/西北菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i5,$model['all']['dongbeicai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i5,$model['all']['dongbeicai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i5,'泰国菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i5,$model['all']['taiguocai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i5,$model['all']['taiguocai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i5,'粤菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i5,$model['all']['yuecai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i5,$model['all']['yuecai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i5,'面包甜点') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i5,$model['all']['mianbao']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i5,$model['all']['mianbao']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i5,'川湘菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i5,$model['all']['chuancai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i5,$model['all']['chuancai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i5,'火锅') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i5,$model['all']['huoguo']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i5,$model['all']['huoguo']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i5,'西餐') ;
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i5,$model['all']['xican']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i5,$model['all']['xican']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i6,'咖啡厅') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i6,$model['all']['kafeiting']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i6,$model['all']['kafeiting']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i6,'浙江菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i6,$model['all']['zejiangcai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i6,$model['all']['zejiangcai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i6,'自助餐') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i6,$model['all']['zizhu']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i6,$model['all']['zizhu']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i6,'饮品店') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i6,$model['all']['yingping']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i6,$model['all']['yingping']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i6,'日韩料理') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i6,$model['all']['riliao']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i6,$model['all']['riliao']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i6,'烧烤') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i6,$model['all']['saokao']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i6,$model['all']['saokao']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i6,'越南菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i6,$model['all']['yuenancai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i6,$model['all']['yuenancai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i7,'小吃快餐') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i7,$model['all']['xiaochi']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i7,$model['all']['xiaochi']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i7,'清真菜') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i7,$model['all']['qingzhencai']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i7,$model['all']['qingzhencai']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i7,'茶餐厅') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i7,$model['all']['chacanting']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i7,$model['all']['chacanting']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i7,'其他') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i7,$model['all']['qitab']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i7,$model['all']['qitab']['money']) ;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i8,'客服类别（非餐饮）') ;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i8.':A'.$i11);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i8,'4S店') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i8,$model['all']['sisdian']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i8,$model['all']['sisdian']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i8,'健身会所') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i8,$model['all']['jianshenhuisuo']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i8,$model['all']['jianshenhuisuo']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i8,'房地产') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i8,$model['all']['fangdican']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i8,$model['all']['fangdican']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i8,'美容/发馆') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i8,$model['all']['meifa']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i8,$model['all']['meifa']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i8,'银行') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i8,$model['all']['yinhang']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i8,$model['all']['yinhang']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i8,'俱乐部') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i8,$model['all']['julebu']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i8,$model['all']['julebu']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i8,'培训机构') ;
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i8,$model['all']['peixunjigou']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i8,$model['all']['peixunjigou']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i9,'KTV') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i9,$model['all']['ktv']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i9,$model['all']['ktv']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i9,'其他') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i9,$model['all']['qitac']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i9,$model['all']['qitac']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i9,'学校') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i9,$model['all']['xuexiao']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i9,$model['all']['xuexiao']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i9,'水疗会所') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i9,$model['all']['shuiliao']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i9,$model['all']['shuiliao']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i9,'超市') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i9,$model['all']['chaoshi']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i9,$model['all']['chaoshi']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i9,'网吧') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i9,$model['all']['wangba']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i9,$model['all']['wangba']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i9,'影院') ;
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i9,$model['all']['yingyuan']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i9,$model['all']['yingyuan']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i10,'体育馆') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i10,$model['all']['tiyuguan']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i10,$model['all']['tiyuguan']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i10,'写字楼') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i10,$model['all']['xiezilou']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i10,$model['all']['xiezilou']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i10,'工厂') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i10,$model['all']['gongcang']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i10,$model['all']['gongcang']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i10,'游泳馆') ;
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i10,$model['all']['youyong']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i10,$model['all']['youyong']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i10,'酒吧') ;
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i10,$model['all']['jiuba']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i10,$model['all']['jiuba']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i10,'物业') ;
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i10,$model['all']['wuye']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i10,$model['all']['wuye']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i10,'酒店') ;
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i10,$model['all']['jiudian']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i10,$model['all']['jiudian']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i11,'便利店') ;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i11,$model['all']['bianlidian']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i11,$model['all']['bianlidian']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i11,'医院') ;
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i11,$model['all']['yiyuan']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i11,$model['all']['yiyuan']['money']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i11,'影楼') ;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i11,$model['all']['yinglou']['sum']) ;
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i11,$model['all']['yinglou']['money']) ;

//            区域的
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i12,'区域') ;
            $a=$i12;
            for($o=1;$o<count($model['all']['address']);$o++){
                if($o%7==1){
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i12,$model['all']['address'][$o][0]['money']) ;
                }
                if($o%7==2){
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i12,$model['all']['address'][$o][0]['money']) ;
                }
                if($o%7==3){
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i12,$model['all']['address'][$o][0]['money']) ;
                }
                if($o%7==4){
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$i12,$model['all']['address'][$o][0]['money']) ;
                }
                if($o%7==5){
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$i12,$model['all']['address'][$o][0]['money']) ;
                }
                if($o%7==6){
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i12,$model['all']['address'][$o][0]['money']) ;
                }
                if($o%7==0){
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i12,$model['all']['address'][$o]['name']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$i12,$model['all']['address'][$o][0]['sum']) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$i12,$model['all']['address'][$o][0]['money']) ;
                    $i12=$i12+1;
                }
            }
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':A'.$i12);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        //'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                        'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                        'color' => array('argb' => '0xCC000000'),
                    ),
                ),
            );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$ex.':V'.$i12)->applyFromArray($styleArray);
        }
        if(!empty($model['one'])){
            if(!empty($model['all'])){
                $i=21;
            }else{
                $i=3;
            }

            foreach ($model['one'] as $arr){
                $ex=$i;
                $i1=$i+1;
                $i2=$i+2;
                $i3=$i+3;
                $i4=$i+4;
                $i5=$i+5;
                $i6=$i+6;
                $i7=$i+7;
                $i8=$i+8;
                $i9=$i+9;
                $i10=$i+10;
                $i11=$i+11;
                $i12=$i+12;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$arr['name']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i1,'签单总金额：'.$arr['money']['money'].'签单总数'.$arr['money']['sum']) ;
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':V'.$i);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$i1.':V'.$i1);
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(25);
                $objPHPExcel->getActiveSheet()->getRowDimension($i1)->setRowHeight(25);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i2,'拜访类型') ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i2,'陌拜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i2,$arr['mobai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i2,$arr['mobai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i2,'日常跟进') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i2,$arr['richanggengjin']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i2,$arr['richanggengjin']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i2,'客户资源') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i2,$arr['kehuziyuan']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i2,$arr['kehuziyuan']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i2,'电话上门') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i2,$arr['dianhuashangmen']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i2,$arr['dianhuashangmen']['money']) ;

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i3,'拜访目的') ;
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$i3.':A'.$i4);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i3,'首次') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i3,$arr['shouci']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i3,$arr['shouci']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i3,'客诉') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i3,$arr['keshu']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i3,$arr['keshu']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i3,'续约') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i3,$arr['xuyue']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i3,$arr['xuyue']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i3,'回访') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i3,$arr['huifang']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i3,$arr['huifang']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i3,'报价') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i3,$arr['baojia']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i3,$arr['baojia']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i3,'追款') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i3,$arr['zuikuan']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i3,$arr['zuikuan']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i3,'减价') ;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i3,$arr['jianjia']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i3,$arr['jianjia']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i4,'停服务') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i4,$arr['tingfuwu']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i4,$arr['tingfuwu']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i4,'更换项目') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i4,$arr['genghuanxiangmu']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i4,$arr['genghuanxiangmu']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i4,'增加项目') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i4,$arr['zengjiaxiangmu']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i4,$arr['zengjiaxiangmu']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i4,'救客') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i4,$arr['jiuke']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i4,$arr['jiuke']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i4,'其他') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i4,$arr['qitaa']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i4,$arr['qitaa']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i4,'签单') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i4,$arr['qiandan']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i4,$arr['qiandan']['money']) ;

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i5,'客服类别（餐饮）') ;
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$i5.':A'.$i7);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i5,'东/西北菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i5,$arr['dongbeicai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i5,$arr['dongbeicai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i5,'泰国菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i5,$arr['taiguocai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i5,$arr['taiguocai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i5,'粤菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i5,$arr['yuecai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i5,$arr['yuecai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i5,'面包甜点') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i5,$arr['mianbao']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i5,$arr['mianbao']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i5,'川湘菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i5,$arr['chuancai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i5,$arr['chuancai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i5,'火锅') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i5,$arr['huoguo']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i5,$arr['huoguo']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i5,'西餐') ;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i5,$arr['xican']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i5,$arr['xican']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i6,'咖啡厅') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i6,$arr['kafeiting']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i6,$arr['kafeiting']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i6,'浙江菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i6,$arr['zejiangcai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i6,$arr['zejiangcai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i6,'自助餐') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i6,$arr['zizhu']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i6,$arr['zizhu']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i6,'饮品店') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i6,$arr['yingping']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i6,$arr['yingping']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i6,'日韩料理') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i6,$arr['riliao']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i6,$arr['riliao']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i6,'烧烤') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i6,$arr['saokao']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i6,$arr['saokao']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i6,'越南菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i6,$arr['yuenancai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i6,$arr['yuenancai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i7,'小吃快餐') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i7,$arr['xiaochi']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i7,$arr['xiaochi']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i7,'清真菜') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i7,$arr['qingzhencai']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i7,$arr['qingzhencai']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i7,'茶餐厅') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i7,$arr['chacanting']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i7,$arr['chacanting']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i7,'其他') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i7,$arr['qitab']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i7,$arr['qitab']['money']) ;

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i8,'客服类别（非餐饮）') ;
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$i8.':A'.$i11);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i8,'4S店') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i8,$arr['sisdian']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i8,$arr['sisdian']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i8,'健身会所') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i8,$arr['jianshenhuisuo']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i8,$arr['jianshenhuisuo']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i8,'房地产') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i8,$arr['fangdican']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i8,$arr['fangdican']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i8,'美容/发馆') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i8,$arr['meifa']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i8,$arr['meifa']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i8,'银行') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i8,$arr['yinhang']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i8,$arr['yinhang']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i8,'俱乐部') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i8,$arr['julebu']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i8,$arr['julebu']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i8,'培训机构') ;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i8,$arr['peixunjigou']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i8,$arr['peixunjigou']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i9,'KTV') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i9,$arr['ktv']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i9,$arr['ktv']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i9,'其他') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i9,$arr['qitac']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i9,$arr['qitac']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i9,'学校') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i9,$arr['xuexiao']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i9,$arr['xuexiao']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i9,'水疗会所') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i9,$arr['shuiliao']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i9,$arr['shuiliao']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i9,'超市') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i9,$arr['chaoshi']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i9,$arr['chaoshi']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i9,'网吧') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i9,$arr['wangba']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i9,$arr['wangba']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i9,'影院') ;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i9,$arr['yingyuan']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i9,$arr['yingyuan']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i10,'体育馆') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i10,$arr['tiyuguan']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i10,$arr['tiyuguan']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i10,'写字楼') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i10,$arr['xiezilou']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i10,$arr['xiezilou']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i10,'工厂') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i10,$arr['gongcang']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i10,$arr['gongcang']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i10,'游泳馆') ;
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i10,$arr['youyong']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i10,$arr['youyong']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i10,'酒吧') ;
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i10,$arr['jiuba']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i10,$arr['jiuba']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i10,'物业') ;
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$i10,$arr['wuye']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$i10,$arr['wuye']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$i10,'酒店') ;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$i10,$arr['jiudian']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$i10,$arr['jiudian']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i11,'便利店') ;
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i11,$arr['bianlidian']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i11,$arr['bianlidian']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i11,'医院') ;
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i11,$arr['yiyuan']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i11,$arr['yiyuan']['money']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i11,'影楼') ;
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i11,$arr['yinglou']['sum']) ;
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i11,$arr['yinglou']['money']) ;

//            区域的
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i12,'区域');
                $a=$i12;
                for($o=1;$o<count($arr['address']);$o++){
                    if($o%7==1){
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i12,$arr['address'][$o][0]['money']) ;
                    }
                    if($o%7==2){
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('F'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$i12,$arr['address'][$o][0]['money']) ;
                    }
                    if($o%7==3){
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$i12,$arr['address'][$o][0]['money']) ;
                    }
                    if($o%7==4){
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('M'.$i12,$arr['address'][$o][0]['money']) ;
                    }
                    if($o%7==5){
                        $objPHPExcel->getActiveSheet()->setCellValue('N'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('O'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('P'.$i12,$arr['address'][$o][0]['money']) ;
                    }
                    if($o%7==6){
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$i12,$arr['address'][$o][0]['money']) ;
                    }
                    if($o%7==0){
                        $objPHPExcel->getActiveSheet()->setCellValue('T'.$i12,$arr['address'][$o]['name']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('U'.$i12,$arr['address'][$o][0]['sum']) ;
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$i12,$arr['address'][$o][0]['money']) ;
                        $i12=$i12+1;
                    }
                }
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$a.':A'.$i12);
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            //'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
                            'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
                            'color' => array('argb' => '0xCC000000'),
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A'.$ex.':V'.$i12)->applyFromArray($styleArray);
                $i=$i+18;
            }
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_start();
        $objWriter->save('php://output');
        $output = ob_get_clean();
        spl_autoload_register(array('YiiBase','autoload'));
        $time=time();
        $str="templates/sale_".$time.".xlsx";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$str.'"');
        header("Content-Transfer-Encoding:binary");
        echo $output;
    }
}
