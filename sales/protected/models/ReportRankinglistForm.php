<?php
/* Reimbursement Form */

class ReportRankinglistForm extends CReportForm
{
    public $staffs;
    public $staffs_desc;

    protected function labelsEx() {
        return array(
            'staffs'=>Yii::t('report','Staffs'),
            'date'=>Yii::t('report','Date'),
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
        $this->city = '';
        $this->fields = 'start_dt,end_dt,staffs,staffs_desc';
        $this->start_dt = date("Y/m/d");
        $this->end_dt = date("Y/m/d");
        $this->five = array();
        $this->date="";
        $this->staffs = '';
        $this->month="";
        $this->year="";
        $this->staffs_desc = Yii::t('misc','All');
    }

    public function retrieveDatas($model){
        $start_date = '2017-01-01'; // 自动为00:00:00 时分秒
        $end_date = date("Y-m-d");
        $start_arr = explode("-", $start_date);
        $end_arr = explode("-", $end_date);
        $start_year = intval($start_arr[0]);
        $start_month = intval($start_arr[1]);
        $end_year = intval($end_arr[0]);
        $end_month = intval($end_arr[1]);
        $diff_year = $end_year-$start_year;
        $year_arr=[];
        for($year=$end_year;$year>=$start_year;$year--){
            $year_arr[] = $year;
        }
        $this->date=$year_arr;
    }

    public function salepeople($start,$end) {
        $suffix = Yii::app()->params['envSuffix'];
        $models = array();
       // $time= date('Y-m-d', strtotime(date('Y-m-01') ));
        $sql = "select a.city, a.username, sum(convert(b.field_value, decimal(12,2))) as money
				from sal_visit a force index (idx_visit_02), sal_visit_info b
				where a.id=b.visit_id and b.field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7') 
				and a.visit_dt >= '$start'and a.visit_dt <= '$end' and  a.visit_obj like '%10%'
				group by a.city, a.username
			";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($records as $record) {
            $temp = array();
            $temp['user']=$record['username'];
            $temp['money']=$record['money'];


            $sql = "select name from hr$suffix.hr_employee where id=(SELECT employee_id from hr$suffix.hr_binding WHERE user_id='".$record['username']."')";
            $row = Yii::app()->db->createCommand($sql)->queryRow();
            $temp['name']= $row!==false ? $row['name'] : $record['username'];

            $sql = "select a.name as city_name, b.name as region_name 
					from security$suffix.sec_city a
					left outer join security$suffix.sec_city b on a.region=b.code
					where a.code='".$record['city']."'
				";
            $row = Yii::app()->db->createCommand($sql)->queryRow();
            $temp['city'] = $row!==false ? $row['city_name'] : $record['city'];
            $temp['quyu'] = $row!==false ? str_replace(array('1','2','3','4','5','6','7','8','9','0'),'',$row['region_name']) : '空';
            $sql_rank="select now_score from sal_rank where month>= '$start' and month<= '$end' and username='".$record['username']."'";
            $rank = Yii::app()->db->createCommand($sql_rank)->queryRow();
            $sql = "select * from sal_level where start_fraction <='" . $rank['now_score'] . "' and end_fraction >='" . $rank['now_score'] . "'";
            $rank_name = Yii::app()->db->createCommand($sql)->queryRow();
            $temp['level'] = $rank_name['level'];
            $temp['rank'] = $rank['now_score'];
            $models[] = $temp;
        }
        $last_names = array_column($models,'money');
        array_multisort($last_names,SORT_DESC,$models);
        $models = array_slice($models, 0, 20);

        return $models;
    }

    public function salelist($start,$end) {
        $suffix = Yii::app()->params['envSuffix'];
        $models = array();
        $cities = General::getCityListWithNoDescendant();
       // $time= date('Y-m-d', strtotime(date('Y-m-01') ));
        foreach ($cities as $code=>$name) {
            $sum_arr = array();
            if (strpos("/'CS'/'H-N'/'HK'/'TC'/'ZS1'/'TP'/'TY'/'KS'/'TN'/'XM'/'KH'/'ZY'/'MO'/'RN'/'MY'/'WL'/'HN1'/","'".$code."'")===false) {
                $sql = "select a.name as city_name, b.name as region_name 
						from security$suffix.sec_city a
						left outer join security$suffix.sec_city b on a.region=b.code
						where a.code='$code'
					";
                $row = Yii::app()->db->createCommand($sql)->queryRow();
                $temp = $row!==false ? str_replace(array('1','2','3','4','5','6','7','8','9','0'),'',$row['region_name']) : '空';

                //人数
                $sql1="select distinct  username FROM sal_visit  WHERE city='$code' and visit_dt >='".$start."' and visit_dt <='".$end."'";
                $people = Yii::app()->db->createCommand($sql1)->queryAll();
                $peoples=count($people);
                if(!empty($people)){
                    //总单数
                    $sql2="select id from sal_visit where city='$code' and  visit_obj like '%10%' and visit_dt >='".$start."'and visit_dt <='".$end."'";
                    $sum = Yii::app()->db->createCommand($sql2)->queryAll();
                    foreach ($sum as $id){
                        $sqlid="select count(visit_id) as sum from  sal_visit_info where field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') and field_value>'0' and visit_id='".$id['id']."'";
                        $arr = Yii::app()->db->createCommand($sqlid)->queryRow();
                        $sum_arr[]=$arr['sum'];
                    }
                    $sums=array_sum($sum_arr);
                    //人均签单数
                    $sale=$sums/($peoples==0?1:$peoples);
                }else{
                    $sale=0;
                }
                $sale=round($sale,2);
                $models[$code] = array('city'=>$name, 'renjun'=>$sale, 'quyu'=>$temp,'people'=>$peoples);

            }
        }
        foreach ($models as $key=>$item) {
            $result[] = $item;
        }

        $arraycol = array_column($result,'renjun');
        array_multisort($arraycol,SORT_DESC,$result);
//print_r('<pre>');
//print_r($models);
        return $result;
    }

    public function salelists($start,$end) {
        $suffix = Yii::app()->params['envSuffix'];
        $models = array();
        $cities = General::getCityListWithNoDescendant();
     //   $time= date('Y-m-d', strtotime(date('Y-m-01') ));
        foreach ($cities as $code=>$name) {
            if (strpos("/'CS'/'H-N'/'HK'/'TC'/'ZS1'/'TP'/'TY'/'KS'/'TN'/'XM'/'KH'/'ZY'/'MO'/'RN'/'MY'/'WL'/'HN1'/","'".$code."'")===false) {
                $sql = "select a.name as city_name, b.name as region_name 
						from security$suffix.sec_city a
						left outer join security$suffix.sec_city b on a.region=b.code
						where a.code='$code'
					";
                $row = Yii::app()->db->createCommand($sql)->queryRow();
                $temp = $row!==false ? str_replace(array('1','2','3','4','5','6','7','8','9','0'),'',$row['region_name']) : '空';

                //人数
                $sql1="select distinct  username FROM sal_visit  WHERE city='$code' and visit_dt >='".$start."'and visit_dt <='".$end."'";
                $people = Yii::app()->db->createCommand($sql1)->queryAll();
                $peoples=count($people);
                //总单数
                $sql2="select id from sal_visit where city='$code' and  visit_obj like '%10%' and visit_dt >='".$start."'and visit_dt <='".$end."'";
                $sum = Yii::app()->db->createCommand($sql2)->queryAll();
                $sums=count($sum);
                //人均签单数
                $sale=$sums/($peoples==0?1:$peoples);
                $sale=round($sale,2);

                //总金额
                $money=0;
                foreach ($sum as $b){
                    $sql3="select field_id, field_value from sal_visit_info where field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7') and visit_id = '".$b['id']."'";
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
                $models[$code] = array('city'=>$name, 'money'=>$money, 'quyu'=>$temp,'people'=>$peoples);
            }
        }
        foreach ($models as $key=>$item) {
            $result[] = $item;
        }

        $arraycol = array_column($result,'money');
        array_multisort($arraycol,SORT_DESC,$result);
//print_r('<pre>');
//print_r($result);
        return $result;
    }

    public function Ranklist($start,$end){
        $suffix = Yii::app()->params['envSuffix'];
        $models = array();
        $sql = "select a.city, a.username,a.now_score,c.name
				from sal_rank  a
				left outer join  hr$suffix.hr_binding b on a.username=b.user_id
				left outer join  hr$suffix.hr_employee c on b.employee_id=c.id
				where 
				a.month >= '$start' and  a.month <= '$end' 
                order by a.now_score desc
			";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($records as $record) {
            if (strpos("/'CS'/'H-N'/'HK'/'TC'/'ZS1'/'TP'/'TY'/'KS'/'TN'/'XM'/'ZY'/'MO'/'RN'/'MY'/'WL'/'HN2'/'JMS'/'RW'/'HN1'/'HXHB'/'HD'/'HN'/'HD1'/'CN'/'HX'/'HB'/","'".$record['city']."'")===false) {
                $temp = array();
                $temp['user'] = $record['username'];
//            $sql = "select name from hr$suffix.hr_employee where id=(SELECT employee_id from hr$suffix.hr_binding WHERE user_id='".$record['username']."')";
//            $row = Yii::app()->db->createCommand($sql)->queryRow();
//            $temp['name']= $row!==false ? $row['name'] : $record['username'];
                $temp['name'] = $record['name'];
                $temp['rank'] = $record['now_score'];
                $sql = "select a.name as city_name, b.name as region_name 
					from security$suffix.sec_city a
					left outer join security$suffix.sec_city b on a.region=b.code
					where a.code='" . $record['city'] . "'
				";
                $row = Yii::app()->db->createCommand($sql)->queryRow();
                $temp['city'] = $row !== false ? $row['city_name'] : $record['city'];
                $temp['quyu'] = $row !== false ? str_replace(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'), '', $row['region_name']) : '空';

                $sql = "select * from sal_level where start_fraction <='" . $record['now_score'] . "' and end_fraction >='" . $record['now_score'] . "'";
                $rank_name = Yii::app()->db->createCommand($sql)->queryRow();
                $temp['level'] = $rank_name['level'];
                $models[] = $temp;
            }
        }
        //print_r();exit()
        $last_names = array_column($models,'rank');
        array_multisort($last_names,SORT_DESC,$models);
        $models = array_slice($models, 0, 20);
        return $models;
    }

}
