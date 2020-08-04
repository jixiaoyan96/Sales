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
        $i=0;
        foreach ($this->cust_type_name['canpin'] as &$value){//产品的
            $sum_c=array();
            $sum_s=array();
            $sql1="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."' and a.cust_type_name='".$value['id']."' and a.status_dt>='$startime' and status_dt<='$endtime' and a.status='N'";
            $service = Yii::app()->db->createCommand($sql1)->queryAll();
            if(!empty($service)){
                foreach ($service as $arr){
              $arr['company_name']=str_replace("'","''",$arr['company_name']);
                    if($value['conditions']==3||$value['conditions']==4||$value['conditions']==5){
                        $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'  and status='N'";
                        $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                        if(!empty($m)&&count($m)==1){
                            $sum_c[]= $arr['pieces'];
                            if(($arr['pieces']>$value['toplimit'])&&$value['toplimit']!=0){
                                $sum_s[]=$value['toplimit'];
                            }else{
                                $sum_s[]=$arr['pieces'];
                            }
                            $value['list'][]=$m;
                        }else{
                            $sum_c[]=0;
                            $sum_s[]=0;
                        }
                    }elseif($value['conditions']==2){
                        $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'  and status='N'";
                        $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                        if(!empty($m)&&count($m)==1){
                            $sum_c[]= 1;
                            $sum_s[]=1;
                            $value['list'][]=$m;
                        }else{
                            $sum_c[]=0;
                            $sum_s[]=0;
                        }
                    }elseif($value['conditions']==1){
                        $sum_c[]= $arr['pieces'];
                        if(($arr['pieces']>$value['toplimit'])&&$value['toplimit']!=0){
                            $sum_s[]=$value['toplimit'];
                        }else{
                            $sum_s[]=$arr['pieces'];
                        }
                        $value['list'][$i][]=$arr;
                        $i=$i+1;
                    }
                }
                $value['number']=array_sum($sum_c);//数量
                $value['sum']=array_sum($sum_s)*$value['fraction'];
            }else{
                $value['number']=0;
                $value['sum']=0;
            }

        }
        $f=0;
        foreach ($this->cust_type_name['fuwu'] as &$value){//服务的
            $sum_f=array();
            $sum_ff=array();
            $sql1="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."' and a.cust_type_name='".$value['id']."' and a.status_dt>='$startime' and a.status_dt<='$endtime' and (a.status='N' or a.status='A' or a.status='C')";
            $service = Yii::app()->db->createCommand($sql1)->queryAll();
            if(!empty($service)){
                foreach ($service as $arr){
                    $arr['company_name']=str_replace("'","''",$arr['company_name']);
                    if($value['conditions']==3||$value['conditions']==4||$value['conditions']==5){
                        if($arr['status']=='N'){
                            $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'  and status='N'";
                            $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                            if(!empty($m)&&count($m)==1){
                                $sum_f[]= $arr['pieces'];
                                if(($arr['pieces']>$value['toplimit'])&&$value['toplimit']!=0){
                                    $sum_ff[]=$value['toplimit'];
                                }else{
                                    $sum_ff[]=$arr['pieces'];
                                }
                                $value['list'][]=$m;
                            }else{
                                $sum_f[]=0;
                                $sum_ff[]=0;
                            }
                        }
                    }elseif($value['conditions']==2){
                        if($arr['status']=='N'){
                            $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'  and status='N'";
                            $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                            if(!empty($m)&&count($m)==1){
                                $sum_f[]= 1;
                                $value['list'][]=$m;
                                $sum_ff[]=1;
                            }else{
                                $sum_f[]=0;
                                $sum_ff[]=0;
                            }
                        }
                    }elseif($value['conditions']==1){
                        if($arr['status']=='N'){
                            $sum_f[]= $arr['pieces'];
                            if(($arr['pieces']>$value['toplimit'])&&$value['toplimit']!=0){
                                $sum_ff[]=$value['toplimit'];
                            }else{
                                $sum_ff[]=$arr['pieces'];
                            }
                            $value['list'][$f][]=$arr;
                        }
                        if($arr['status']=='A'){
                            $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'  and status='N'";
                            $m = Yii::app()->db->createCommand($sql_calculation)->queryRow();
                            if(!empty($m)){
                                if(($arr['pieces']>$value['toplimit'])&&$value['toplimit']!=0){
                                    $v=$value['toplimit'];
                                }else{
                                    $v=$arr['pieces'];
                                }
                                $a=$v-$m['pieces'];
                                if($a>0){
                                    $sum_f[]=$a;
                                    $sum_ff[]=$a;
                                    $value['list'][$f][]=$arr;
                                }
                            }
                        }
                        if($arr['status']=='C'){
                            $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."'  and (status='N' or status='A') order by  id desc";
                            $m = Yii::app()->db->createCommand($sql_calculation)->queryRow();
                            if(!empty($m)){
                                if(($arr['pieces']>$value['toplimit'])&&$value['toplimit']!=0){
                                    $v=$value['toplimit'];
                                }else{
                                    $v=$arr['pieces'];
                                }
                                $a=$v-$m['pieces'];
                                if($a>0){
                                    $sum_f[]=$a;
                                    $sum_ff[]=$a;
                                    $value['list'][$f][]=$arr;
                                }
                            }
                        }

                        $f=$f+1;
                    }
                }

                $value['number']=array_sum($sum_f);//数量
                $value['sum']=array_sum($sum_ff)*$value['fraction'];
            }else{
                $value['number']=0;
                $value['sum']=0;
            }
//            print_r('<pre>');
//            print_r($arr);
        }
//        exit();exit
        //装机
        $sql_zj="select * from swoper$suffix.swo_service a
               inner join hr$suffix.hr_employee b on a.salesman=concat(b.name, ' (', b.code, ')')
               inner join hr$suffix.hr_binding c on b.id=c.employee_id 
               where c.user_id='".$row['username']."'  and a.status_dt>='$startime' and a.status_dt<='$endtime' and a.amt_install<>0 and (a.cust_type=1 or a.cust_type=2) and a.status='N'";
        $service = Yii::app()->db->createCommand($sql_zj)->queryAll();
        if(!empty($service)){
            foreach ($service as $arr){
          $arr['company_name']=str_replace("'","''",$arr['company_name']);
                $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."'  and salesman='".$arr['salesman']."' and amt_install<>0  and cust_type='".$arr['cust_type']."'  and status='N'";
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum_z[]=1;
                    $this->cust_type_name['zhuangji']['list'][]=$m;
                }else{
                    $sum_z[]=0;
                }
            }
            $v=array_sum($sum_z);//数量
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
               where c.user_id='".$row['username']."'  and a.status_dt>='$startime' and a.status_dt<='$endtime' and a.status='N'";
        $service = Yii::app()->db->createCommand($sql_ys)->queryAll();
        if(!empty($service)){
            foreach ($service as $arr){
          $arr['company_name']=str_replace("'","''",$arr['company_name']);
                if(empty($arr['cust_type_name'])){
                    $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type='".$arr['cust_type']."' and salesman='".$arr['salesman']."' and  prepay_month>=3 and prepay_month <6   and status='N'";

                }else{
                    $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."' and  prepay_month>=3 and prepay_month <6   and status='N'";
                }
               $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum_y3[]=1;
                    $this->cust_type_name['yushou3']['list'][]=$m;
                }else{
                    $sum_y3[]=0;
                }
            }
            $v=array_sum($sum_y3);//数量
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
          $arr['company_name']=str_replace("'","''",$arr['company_name']);
                if(empty($arr['cust_type_name'])){
                    $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type='".$arr['cust_type']."' and salesman='".$arr['salesman']."' and  prepay_month>=6 and prepay_month <12   and status='N'";

                }else{
                    $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."' and  prepay_month>=6 and prepay_month <12   and status='N'";
                }
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum_y6[]=1;
                    $this->cust_type_name['yushou6']['list'][]=$m;
                }else{
                    $sum_y6[]=0;
                }
            }
            $v=array_sum($sum_y6);//数量
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
          $arr['company_name']=str_replace("'","''",$arr['company_name']);
                if(empty($arr['cust_type_name'])){
                    $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type='".$arr['cust_type']."' and salesman='".$arr['salesman']."' and  prepay_month >=12   and status='N'";

                }else{
                    $sql_calculation="select * from swoper$suffix.swo_service where company_name='".$arr['company_name']."' and cust_type_name='".$arr['cust_type_name']."' and salesman='".$arr['salesman']."' and  prepay_month >=12   and status='N'";
                }
                $m = Yii::app()->db->createCommand($sql_calculation)->queryAll();
                if(!empty($m)&&count($m)==1){
                    $sum_y12[]=1;
                    $this->cust_type_name['yushou12']['list'][]=$m;
                }else{
                    $sum_y12[]=0;
                }
            }
            $v=array_sum($sum_y12);//数量
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
               where username='".$row['username']."'  and visit_dt>='$startime' and visit_dt<='$endtime' and  shift is null ";
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
            $this->cust_type_name['baifang20']['fraction']=2;
        }else{
            $this->cust_type_name['baifang20']['sum']=0;
            $this->cust_type_name['baifang20']['number']=0;
            $this->cust_type_name['baifang20']['fraction']=2;
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
        $sql="select * from hr$suffix.hr_binding  where user_id='".$row['username']."' ";
        $name = Yii::app()->db->createCommand($sql)->queryRow();
        $this->name=$name['employee_name'];
		return true;
	}

	public function downEx($model){
        Yii::$enableIncludePath = false;
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        spl_autoload_unregister(array('YiiBase','autoload'));
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel;
        $objReader  = PHPExcel_IOFactory::createReader('Excel2007');
        $path = Yii::app()->basePath.'/commands/template/integral.xlsx';

        $objPHPExcel = $objReader->load($path);
        $i=16;
        $objActSheet=$objPHPExcel->setActiveSheetIndex(0);
        foreach ($model['cust_type_name']['canpin'] as $arr ){
            $i=$i+1;
            $objWorksheet = $objActSheet;
            $objWorksheet->insertNewRowBefore($i + 1, 1);
            $objActSheet->setCellValue('A'.$i, $arr['cust_type_name']) ;
            $objActSheet->setCellValue('B'.$i, $this->getCustTypeName($arr['cust_type_id'])) ;
            $objActSheet->setCellValue('D'.$i, $this->getConditionsName($arr['conditions'])) ;
            $objActSheet->setCellValue('E'.$i, $arr['fraction']) ;
            $objActSheet->setCellValue('F'.$i, $arr['number']) ;
            $objActSheet->setCellValue('G'.$i, $arr['sum']) ;
            if($arr['toplimit']!=0){
                $toplimit= "上限为".$arr['toplimit']."(上限为0时，表示没有限制)" ;
            }else{
                $toplimit="";
            }
            $objActSheet->setCellValue('H'.$i, $toplimit) ;
        }
        $i=$i+2;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['canpin_sum']) ;
        $i=$i+2;
        foreach ($model['cust_type_name']['fuwu'] as $arr ){
            $i=$i+1;
            $objWorksheet = $objActSheet;
            $objWorksheet->insertNewRowBefore($i + 1, 1);
            $objActSheet->setCellValue('A'.$i, $arr['cust_type_name']) ;
            $objActSheet->setCellValue('B'.$i, $this->getCustTypeName($arr['cust_type_id'])) ;
            $objActSheet->setCellValue('D'.$i, $this->getConditionsName($arr['conditions'])) ;
            $objActSheet->setCellValue('E'.$i, $arr['fraction']) ;
            $objActSheet->setCellValue('F'.$i, $arr['number']) ;
            $objActSheet->setCellValue('G'.$i, $arr['sum']) ;
            if($arr['toplimit']!=0){
                $toplimit= "上限为".$arr['toplimit']."(上限为0时，表示没有限制)" ;
            }else{
                $toplimit="";
            }
            $objActSheet->setCellValue('H'.$i, $toplimit) ;
        }
        $i=$i+2;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['fuwu_sum']) ;
        $i=$i+3;
        $objActSheet->setCellValue('F'.$i, $model['cust_type_name']['zhuangji']['number']) ;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['zhuangji']['sum']) ;
        $i=$i+1;
        $objActSheet->setCellValue('F'.$i, $model['cust_type_name']['yushou3']['number']) ;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['yushou3']['sum']) ;
        $i=$i+1;
        $objActSheet->setCellValue('F'.$i, $model['cust_type_name']['yushou6']['number']) ;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['yushou6']['sum']) ;
        $i=$i+1;
        $objActSheet->setCellValue('F'.$i, $model['cust_type_name']['yushou12']['number']) ;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['yushou12']['sum']) ;
        $i=$i+1;
        $objActSheet->setCellValue('F'.$i, $model['cust_type_name']['baifang15']['number']) ;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['baifang15']['sum']) ;
        $i=$i+1;
        $objActSheet->setCellValue('F'.$i, $model['cust_type_name']['baifang20']['number']) ;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['baifang20']['sum']) ;
        $i=$i+1;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['qita_sum']) ;
        $i=$i+3;
        $objActSheet->setCellValue('G'.$i, $model['cust_type_name']['all_sum']) ;
        $i=$i+1;
        $point=$model['cust_type_name']['point']*100;
        $objActSheet->setCellValue('G'.$i, $point."%") ;
        //$objPHPExcel->createSheet();//新增页
        $objPHPExcel->getSheet(1)->setTitle('详情列表');
        $objPHPExcel->getSheet(0)->setTitle('积分表单');
        $objActSheet=$objPHPExcel->setActiveSheetIndex(1);
        //$objActSheet->setCellValue('A2', '啊沙雕哈市的你看的') ;
        $o=2;
        $objActSheet->setCellValue('A'.$o,'产品') ;
        foreach ($model['cust_type_name']['canpin'] as $arr ){
            if(!empty($arr['list'])){
                foreach ($arr['list'] as $list){
                    $o=$o+1;
                    $objActSheet->setCellValue('B'.$o,$this->getStatusName($list[0]['status'])) ;
                    $objActSheet->setCellValue('C'.$o,	date_format(date_create($list[0]['status_dt']),"Y/m/d")) ;
                    $objActSheet->setCellValue('D'.$o,date_format(date_create($list[0]['first_dt']),"Y/m/d")) ;
                    $objActSheet->setCellValue('E'.$o,$list[0]['company_name']) ;
                    $objActSheet->setCellValue('F'.$o,$this->getCustTypeName($list[0]['cust_type'])) ;
                    $objActSheet->setCellValue('G'.$o,$this->getCustTypeNamec($list[0]['cust_type_name'])) ;
                    $objActSheet->setCellValue('H'.$o,$list[0]['pieces']) ;
                    $objActSheet->setCellValue('I'.$o,$list[0]['amt_install']) ;
                    $objActSheet->setCellValue('J'.$o,$list[0]['salesman']) ;
                    $objActSheet->setCellValue('K'.$o,$list[0]['prepay_month']) ;
                }
            }

        }
        $o=$o+1;
        $objActSheet->setCellValue('A'.$o,'服务') ;
        foreach ($model['cust_type_name']['fuwu'] as $arr ){
            if(!empty($arr['list'])){
                foreach ($arr['list'] as $list){
                    $o=$o+1;
                    $objActSheet->setCellValue('B'.$o,$this->getStatusName($list[0]['status'])) ;
                    $objActSheet->setCellValue('C'.$o,	date_format(date_create($list[0]['status_dt']),"Y/m/d")) ;
                    $objActSheet->setCellValue('D'.$o,date_format(date_create($list[0]['first_dt']),"Y/m/d")) ;
                    $objActSheet->setCellValue('E'.$o,$list[0]['company_name']) ;
                    $objActSheet->setCellValue('F'.$o,$this->getCustTypeName($list[0]['cust_type'])) ;
                    $objActSheet->setCellValue('G'.$o,$this->getCustTypeNamec($list[0]['cust_type_name'])) ;
                    $objActSheet->setCellValue('H'.$o,$list[0]['pieces']) ;
                    $objActSheet->setCellValue('I'.$o,$list[0]['amt_install']) ;
                    $objActSheet->setCellValue('J'.$o,$list[0]['salesman']) ;
                    $objActSheet->setCellValue('K'.$o,$list[0]['prepay_month']) ;
                }
            }

        }
        $o=$o+1;
        $objActSheet->setCellValue('A'.$o,'装机') ;
        if(!empty($this->cust_type_name['zhuangji']['list'])){
            foreach ($this->cust_type_name['zhuangji']['list'] as $list){
                $o=$o+1;
                $objActSheet->setCellValue('B'.$o,$this->getStatusName($list[0]['status'])) ;
                $objActSheet->setCellValue('C'.$o,	date_format(date_create($list[0]['status_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('D'.$o,date_format(date_create($list[0]['first_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('E'.$o,$list[0]['company_name']) ;
                $objActSheet->setCellValue('F'.$o,$this->getCustTypeName($list[0]['cust_type'])) ;
                $objActSheet->setCellValue('G'.$o,$this->getCustTypeNamec($list[0]['cust_type_name'])) ;
                $objActSheet->setCellValue('H'.$o,$list[0]['pieces']) ;
                $objActSheet->setCellValue('I'.$o,$list[0]['amt_install']) ;
                $objActSheet->setCellValue('J'.$o,$list[0]['salesman']) ;
                $objActSheet->setCellValue('K'.$o,$list[0]['prepay_month']) ;
            }
        }
        $o=$o+1;
        $objActSheet->setCellValue('A'.$o,'预收') ;
        if(!empty($this->cust_type_name['yushou3']['list'])){
            foreach ($this->cust_type_name['yushou3']['list'] as $list){
                $o=$o+1;
                $objActSheet->setCellValue('B'.$o,$this->getStatusName($list[0]['status'])) ;
                $objActSheet->setCellValue('C'.$o,	date_format(date_create($list[0]['status_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('D'.$o,date_format(date_create($list[0]['first_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('E'.$o,$list[0]['company_name']) ;
                $objActSheet->setCellValue('F'.$o,$this->getCustTypeName($list[0]['cust_type'])) ;
                $objActSheet->setCellValue('G'.$o,$this->getCustTypeNamec($list[0]['cust_type_name'])) ;
                $objActSheet->setCellValue('H'.$o,$list[0]['pieces']) ;
                $objActSheet->setCellValue('I'.$o,$list[0]['amt_install']) ;
                $objActSheet->setCellValue('J'.$o,$list[0]['salesman']) ;
                $objActSheet->setCellValue('K'.$o,$list[0]['prepay_month']) ;
            }
        }
        if(!empty($this->cust_type_name['yushou6']['list'])){
            foreach ($this->cust_type_name['yushou6']['list'] as $list){
                $o=$o+1;
                $objActSheet->setCellValue('B'.$o,$this->getStatusName($list[0]['status'])) ;
                $objActSheet->setCellValue('C'.$o,	date_format(date_create($list[0]['status_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('D'.$o,date_format(date_create($list[0]['first_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('E'.$o,$list[0]['company_name']) ;
                $objActSheet->setCellValue('F'.$o,$this->getCustTypeName($list[0]['cust_type'])) ;
                $objActSheet->setCellValue('G'.$o,$this->getCustTypeNamec($list[0]['cust_type_name'])) ;
                $objActSheet->setCellValue('H'.$o,$list[0]['pieces']) ;
                $objActSheet->setCellValue('I'.$o,$list[0]['amt_install']) ;
                $objActSheet->setCellValue('J'.$o,$list[0]['salesman']) ;
                $objActSheet->setCellValue('K'.$o,$list[0]['prepay_month']) ;
            }
        }
        if(!empty($this->cust_type_name['yushou12']['list'])){
            foreach ($this->cust_type_name['yushou12']['list'] as $list){
                $o=$o+1;
                $objActSheet->setCellValue('B'.$o,$this->getStatusName($list[0]['status'])) ;
                $objActSheet->setCellValue('C'.$o,	date_format(date_create($list[0]['status_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('D'.$o,date_format(date_create($list[0]['first_dt']),"Y/m/d")) ;
                $objActSheet->setCellValue('E'.$o,$list[0]['company_name']) ;
                $objActSheet->setCellValue('F'.$o,$this->getCustTypeName($list[0]['cust_type'])) ;
                $objActSheet->setCellValue('G'.$o,$this->getCustTypeNamec($list[0]['cust_type_name'])) ;
                $objActSheet->setCellValue('H'.$o,$list[0]['pieces']) ;
                $objActSheet->setCellValue('I'.$o,$list[0]['amt_install']) ;
                $objActSheet->setCellValue('J'.$o,$list[0]['salesman']) ;
                $objActSheet->setCellValue('K'.$o,$list[0]['prepay_month']) ;
            }
        }
        $objPHPExcel->setActiveSheetIndex(0);
//        print_r("<pre>");
//        print_r($model);
//        exit();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_start();
        $objWriter->save('php://output');
        $output = ob_get_clean();
        spl_autoload_register(array('YiiBase','autoload'));
        $time=time();
        $str="templates/month_".$time.".xlsx";
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


    public function cust_type_name($id){

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

    public function  getCustTypeNamec($a){
        $suffix = Yii::app()->params['envSuffix'];
        $sql = "select cust_type_name from swoper$suffix.swo_customer_type_twoname where id='$a'";
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

    public function  getStatusName($a){
        if($a=='N'){
            $row='新增';
        }elseif ($a=='C'){
            $row='续约';
        }elseif ($a=='A'){
            $row='更改';
        }elseif ($a=='S'){
            $row='暂停';
        }elseif ($a=='R'){
            $row='恢复';
        }elseif ($a=='T'){
            $row='终止';
        }

        return $row;
    }


    public function isReadAll() {
        return Yii::app()->user->validFunction('CN09');
    }
}
