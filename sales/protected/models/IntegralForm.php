<?php

class IntegralForm extends CFormModel
{
	/* User Fields */
	public $id;
	public $name;
	public $cust_type_name=array();
	public $type_group;
	public $city;
    public $sum;
    public $sums;
    public $year;
    public $month;

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>Yii::t('code','Description'),
			'rpt_type'=>Yii::t('code','Report Category'),
			'city'=>Yii::t('sales','City'),
			'type_group'=>Yii::t('code','Type'),
            'sum'=>Yii::t('code','Sum'),
            'sums'=>Yii::t('code','Sums'),
            'year'=>Yii::t('code','Year'),
            'month'=>Yii::t('code','Month'),

		);
	}

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('','required'),
			array('id,rpt_type,sums,','safe'),
		);
	}

	public function retrieveData($index)
	{
		$city = Yii::app()->user->city();
        $suffix = Yii::app()->params['envSuffix'];
        $this->cust_type_name['canpin']=$this->custTypeNameA(9);//产品买卖
        $this->cust_type_name['fuwu']=$this->custTypeNameB(9);//产品买卖之外的全部
        $sql="select * from sal_integral where id='$index'";
        $row = Yii::app()->db->createCommand($sql)->queryRow();
        $startime=$row['year']."-".$row['month']."-01";
        $endtime=$row['year']."-".$row['month']."-31";
        $this->id=$index;
        $this->year=$row['year'];
        $this->month=$row['month'];
        foreach ($this->cust_type_name['canpin'] as &$value){//产品的
            $sum_c=array();
            $sql1="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."' and a.cust_type_name='".$value['id']."' and a.status_dt>='$startime' and status_dt<='$endtime'";
            $service = Yii::app()->db->createCommand($sql1)->queryAll();
            if(!empty($service)){
                foreach ($service as $arr){
                    if($value['conditions']==3||$value['conditions']==4||$value['conditions']==5){
                        $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'";
                        $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                        if(!empty($m)&&count($m)==1){
                            $sum_c[]= $arr['pieces'];
                        }else{
                            $sum_c[]=0;
                        }
                    }elseif($value['conditions']==2){
                        $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'";
                        $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                        if(!empty($m)&&count($m)==1){
                            $sum_c[]= 1;
                        }else{
                            $sum_c[]=0;
                        }
                    }elseif($value['conditions']==1){
                        $sum_c[]= $arr['pieces'];
                    }
                }
                $value['number']=array_sum($sum_c);//数量
                if((array_sum($sum_c)>$value['toplimit'])&&$value['toplimit']!=0){
                    $value['sum']=$value['toplimit']*$value['fraction'];
                }else{
                    $value['sum']=$value['number']*$value['fraction'];
                }
            }else{
                $value['number']=0;
                $value['sum']=0;
            }
        }
        foreach ($this->cust_type_name['fuwu'] as &$value){//服务的
            $sum_f=array();
            $sql1="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."' and a.cust_type_name='".$value['id']."' and a.status_dt>='$startime' and a.status_dt<='$endtime'";
            $service = Yii::app()->db->createCommand($sql1)->queryAll();
            if(!empty($service)){
                foreach ($service as $arr){
                    if($value['conditions']==3||$value['conditions']==4||$value['conditions']==5){
                        $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'";
                        $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                        if(!empty($m)&&count($m)==1){
                            $sum_f[]= $arr['pieces'];
                        }else{
                            $sum_f[]=0;
                        }
                    }elseif($value['conditions']==2){
                        $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'";
                        $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                        if(!empty($m)&&count($m)==1){
                            $sum_f[]= 1;
                        }else{
                            $sum_f[]=0;
                        }
                    }elseif($value['conditions']==1){
                        $sum_f[]= $arr['pieces'];
                    }
                }
                $value['number']=array_sum($sum_f);//数量
                if((array_sum($sum_f)>$value['toplimit'])&&$value['toplimit']!=0){
                    $value['sum']=$value['toplimit']*$value['fraction'];
                }else{
                    $value['sum']=$value['number']*$value['fraction'];
                }
            }else{
                $value['number']=0;
                $value['sum']=0;
            }
        }
        //装机
        $sql_zj="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."'  and a.status_dt>='$startime' and a.status_dt<='$endtime'";
        $service = Yii::app()->db->createCommand($sql_zj)->queryAll();
        if(!empty($service)){
            foreach ($service as $arr){
                $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'";
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum[]=1;
                }else{
                    $sum[]=0;
                }
            }
            $v=array_sum($sum);//数量
            $this->cust_type_name['zhuangji']['sum']=$v*1;
            $this->cust_type_name['zhuangji']['number']=$v;
            $this->cust_type_name['zhuangji']['fraction']=1;//分数
        }else{
            $this->cust_type_name['zhuangji']['sum']=0;
            $this->cust_type_name['zhuangji']['number']=0;
            $this->cust_type_name['zhuangji']['fraction']=1;
        }
        //预收3
        $sql_ys="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."'  and a.status_dt>='$startime' and a.status_dt<='$endtime'";
        $service = Yii::app()->db->createCommand($sql_ys)->queryAll();
        if(!empty($service)){
            foreach ($service as $arr){
                $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."' and  prepay_month>0 and prepay_month <6 ";
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum[]=1;
                }else{
                    $sum[]=0;
                }
            }
            $v=array_sum($sum);//数量
            $this->cust_type_name['yushou3']['sum']=$v*2;
            $this->cust_type_name['yushou3']['number']=$v;
            $this->cust_type_name['yushou3']['fraction']=2;
        }else{
            $this->cust_type_name['yushou3']['sum']=0;
            $this->cust_type_name['yushou3']['number']=0;
            $this->cust_type_name['yushou3']['fraction']=2;
        }
        //预收6
        if(!empty($service)){
            foreach ($service as $arr){
                $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."' and  prepay_month>=6 and prepay_month <12 ";
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum[]=1;
                }else{
                    $sum[]=0;
                }
            }
            $v=array_sum($sum);//数量
            $this->cust_type_name['yushou6']['sum']=$v*3;
            $this->cust_type_name['yushou6']['number']=$v;
            $this->cust_type_name['yushou6']['fraction']=3;
        }else{
            $this->cust_type_name['yushou6']['sum']=0;
            $this->cust_type_name['yushou6']['number']=0;
            $this->cust_type_name['yushou6']['fraction']=3;
        }
        //预收12
        if(!empty($service)){
            foreach ($service as $arr){
                $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."' and  prepay_month >=12 ";
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum[]=1;
                }else{
                    $sum[]=0;
                }
            }
            $v=array_sum($sum);//数量
            $this->cust_type_name['yushou12']['sum']=$v*5;
            $this->cust_type_name['yushou12']['number']=$v;
            $this->cust_type_name['yushou12']['fraction']=5;
        }else{
            $this->cust_type_name['yushou12']['sum']=0;
            $this->cust_type_name['yushou12']['number']=0;
            $this->cust_type_name['yushou12']['fraction']=5;
        }
        //拜访15
        $sql_bf="select * from sal_visit       
               where username='".$row['username']."'  and visit_dt>='$startime' and visit_dt<='$endtime'";
        $bf = Yii::app()->db->createCommand($sql_bf)->queryAll();
        if(!empty($bf)&&(count($bf)/$row['sale_day'])>15){
            $this->cust_type_name['baifang15']['sum']=1;
            $this->cust_type_name['baifang15']['number']=1;
            $this->cust_type_name['baifang15']['fraction']=1;
        }else{
            $this->cust_type_name['baifang15']['sum']=0;
            $this->cust_type_name['baifang15']['number']=0;
            $this->cust_type_name['baifang15']['fraction']=1;
        }

        //拜访20
        if(!empty($bf)&&(count($bf)/$row['sale_day'])>20){
            $this->cust_type_name['baifang20']['sum']=2;
            $this->cust_type_name['baifang20']['number']=1;
            $this->cust_type_name['baifang20']['fraction']=1;
        }else{
            $this->cust_type_name['baifang20']['sum']=0;
            $this->cust_type_name['baifang20']['number']=0;
            $this->cust_type_name['baifang20']['fraction']=1;
        }

        $this->cust_type_name['canpin_sum']=array_sum(array_map(create_function('$val', 'return $val["sum"];'), $this->cust_type_name['canpin']));
        $this->cust_type_name['fuwu_sum']=array_sum(array_map(create_function('$val', 'return $val["sum"];'), $this->cust_type_name['fuwu']));
        $this->cust_type_name['qita_sum']=$this->cust_type_name['zhuangji']['sum']+ $this->cust_type_name['yushou3']['sum']+ $this->cust_type_name['yushou6']['sum']+ $this->cust_type_name['yushou12']['sum']+$this->cust_type_name['baifang15']['sum']+ $this->cust_type_name['baifang20']['sum'];
        $this->cust_type_name['all_sum']= $this->cust_type_name['canpin_sum']+ $this->cust_type_name['fuwu_sum']+ $this->cust_type_name['qita_sum'];
        if(count($bf)<200&&(count($bf)/10)<$row['sale_day']){
            $this->cust_type_name['all_sum']=0;
        }
        if($this->cust_type_name['all_sum']<= 10){
            $this->cust_type_name['point']=-0.01;
        }elseif ($this->cust_type_name['all_sum']<= 20){
            $this->cust_type_name['point']=-0.005;
        }elseif ($this->cust_type_name['all_sum']<= 30){
            $this->cust_type_name['point']=0;
        }elseif ($this->cust_type_name['all_sum']<= 80){
            $this->cust_type_name['point']=0.01;
        }elseif ($this->cust_type_name['all_sum']> 80){
            $this->cust_type_name['point']=0.02;
        }
		return true;
	}

	public function subtotal($moddl,$row){
        $suffix = Yii::app()->params['envSuffix'];

    }

	public function custTypeNameA($id){
        $suffix = Yii::app()->params['envSuffix'];
        $sql = "select * from swoper$suffix.swo_customer_type_twoname where cust_type_id='$id'";
        $row = Yii::app()->db->createCommand($sql)->queryAll();
        return $row;
    }

    public function custTypeNameB($id){
        $suffix = Yii::app()->params['envSuffix'];
        $sql = "select * from swoper$suffix.swo_customer_type_twoname where cust_type_id!='$id'";
        $row = Yii::app()->db->createCommand($sql)->queryAll();
        return $row;
    }
	
     public function  getCustTypeName($a){
         $suffix = Yii::app()->params['envSuffix'];
         $sql = "select description from swoper$suffix.swo_customer_type where id='$a'";
         $row = Yii::app()->db->createCommand($sql)->queryScalar();
         return $row;
     }

    public function  getConditionsName($a){
	   if($a==1){
           $row='每个';
       }elseif ($a==2){
	       $row='每个新客户';
       }elseif ($a==3){
           $row='每新客户订购一包';
       }elseif ($a==4){
           $row='每个新客户每桶';
       }elseif ($a==5){
           $row='每个新客户每箱';
       }elseif ($a==6){
           $row='每月';
       }
       if(empty($a)){
           $row='每个';
       }
        return $row;
    }


    public function isReadAll() {
        return Yii::app()->user->validFunction('CN09');
    }
}
