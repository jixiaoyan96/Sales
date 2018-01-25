<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/14 0014
 * Time: 10:25
 */
header("Content-type: text/html; charset=utf-8");
 Class SalesController extends Controller{
     Public $selectDataFirst;
    Public $urlAjaxSelect;
    Public $arr;
     public function actionIndex($pageNum=0){
         $city=Yii::app()->user->city_allow();
         $model=new QuizList();
         if (isset($_POST['QuizList'])) {
             $model->attributes = $_POST['QuizList'];
         } else {
             $session = Yii::app()->session;
             if (isset($session['criteria_c02']) && !empty($session['criteria_c02'])) {
                 $criteria = $session['criteria_c02'];
                 $model->setCriteria($criteria);
             }
         }
         $model->determinePageNum($pageNum);
         $model->retrieveDataByPage($model->pageNum);
         $this->render('index',array('model'=>$model));
     }
     Public function actiondefault(){
         $connection = Yii::app()->db2;
         $transaction=$connection->beginTransaction();
         try {
             $employee_info_set="select id from employee_info_v WHERE 1=1";
             $employee_info_get=Yii::app()->db2->createCommand($employee_info_set)->queryAll();
             $employee_info_str="";
             for($i=0;$i<count($employee_info_get);$i++){
                 $employee_info_str.=$employee_info_get[$i]['id'].',';
             }
             $employee_info_str=trim($employee_info_str,',');
             $quiz_update_set="update sales set quiz_employee_id='$employee_info_str' WHERE id>0";
             Yii::app()->db2->createCommand($quiz_update_set)->execute();
             $transaction->commit();
             Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','all checked success'));
             $this->redirect(Yii::app()->createUrl('sales/index'));
         }
         catch(Exception $e) {
             $transaction->rollback();
             Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','all checked failed'));
             $this->redirect(Yii::app()->createUrl('sales/index'));
         }
     }
     Public function actionAjaxUrl(){
         $name=$_REQUEST['username'];
         $pwd=$_REQUEST['password'];
         $countSelect=$_REQUEST['selectCount'];
        var_dump("aa".$name.$pwd.$countSelect);
     }

            //进入新增页面
     Public function actionNew(){
         $model = new SalesForm('new');
         $this->render('form',array('model'=>$model,));
     }


     Public function actionSelectKindsFirst(){

     }
     public function actionView($index)
     {
         $model = new SalesForm('view');
         if (!$model->retrieveData($index)) {
             throw new CHttpException(404,'The requested page does not exist.');
         } else {
             $this->render('form',array('model'=>$model,));
         }
     }

     public function actionDelete()
     {
         $model = new SalesForm('delete');
         if (isset($_POST['QuizForm'])) {
             $model->attributes = $_POST['QuizForm'];
             if ($model->isOccupied($model->id)) {
                 Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','This record is already in use'));
                 $this->redirect(Yii::app()->createUrl('sales/edit',array('index'=>$model->id)));
             } else {
                 $model->saveData();
                 Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
                 $this->redirect(Yii::app()->createUrl('sales/index'));
             }
         }
//		$this->actionIndex();
     }

     Public function actionSave(){
         //var_dump($_REQUEST);die;
        // echo "<pre/>";
         $user_sellers_id='';
         $name=Yii::app()->user->name;
         if(!empty($name)){
             $sellers_set="select * from sellers_user_bind_v WHERE user_id='$name'";
             $sellers_get=Yii::app()->db2->createCommand($sellers_set)->queryAll();
             if(count($sellers_get)>0){
                 $user_sellers_id=$sellers_get[0]['sellers_id'];
             }
         }

         $visit_insert_id='';//增加的id  可以为visit service customer_info_id
         //销售员id
                     if (isset($_POST['SalesForm'])) {
                         $model = new SalesForm($_POST['SalesForm']['scenario']);
                         $model->attributes = $_POST['SalesForm'];
                         if ($model->validate()) {
                             $model->saveData();   //保存完客户主要的拜访信息  现在开始保存跟进明细 以及 详细的服务信息
                             //思路 先单独分别存入跟进记录  将具体信息存入时 读取具体的新增的跟进id $this->id = Yii::app()->db2->getLastInsertID();存入一个临时数组作为
                             $this_visit_insert_id=$model->id;  //本次存入的客户拜访数据

                             if((!empty($_REQUEST['first1'][0]))&&(!empty($_REQUEST['first2'][0]))){//首先判断第一条跟进记录是否符合要求 如果符合要求则存入 如果不符合则不存入 再查看其余跟进是否符合
                                 $first_visit_notes=$_REQUEST['first3'][0];  //第一次跟进备注
                                 $first_visit_date=$_REQUEST['first1'][0];  //第一次跟进日期
                                 $first_visit_definition=$_REQUEST['first2'][0]; //第一次跟进目的
                                 $first_visit_total=$_REQUEST['first4'][0]; //第一次跟进总额
                                 $insert_first_visit_info_set="
              Insert into visit_info (visit_customer_fid,visit_seller_fid,visit_notes,visit_service_money,visit_date,visit_definition)VALUES
              ('$this_visit_insert_id','$user_sellers_id','$first_visit_notes','$first_visit_total','$first_visit_date','$first_visit_definition')";
                                 Yii::app()->db2->createCommand($insert_first_visit_info_set)->execute();
                                 $visit_insert_id= Yii::app()->db2->getLastInsertID(); //第一次跟进的insert id
                                 if((!empty($_REQUEST['count1'][0]))&&(!empty($_REQUEST['count2'][0]))){  //判断第一次跟进的服务数据  服务类别与金额
                                    $first_visit_service_kinds_f=$_REQUEST['count1'][0]; //第一次跟进的第一次服务的类别
                                     $first_visit_service_money_f=$_REQUEST['count2'][0];//第一次跟进的第一次服务的金额
                                     $first_visit_service_count_f=$_REQUEST['count3'][0];//第一次跟进的第一次服务的数量
                                     $insert_first_visit_service_info_f_set="
                                     Insert into service_history (service_history_name,service_history_count,service_history_money,service_visit_pid)
                                     VALUES ('$first_visit_service_kinds_f','$first_visit_service_count_f','$first_visit_service_money_f','$visit_insert_id')
                                     ";
                                     Yii::app()->db2->createCommand($insert_first_visit_service_info_f_set)->execute();
                                     //echo '存入第一条跟进的第一个服务成功';die;
                                 }
                                $first_visit_service_more_count=count($_REQUEST['demo1']);
                                 if($first_visit_service_more_count>0) {
                                     //判断第一次跟进的在第一个服务之后的多条服务数据  服务类别与金额
                                     for ($a = 0; $a < count($_REQUEST['demo1']); $a++) {
                                         $first_visit_service_kinds_more = '';
                                         $first_visit_service_money_more = '';
                                         $first_visit_service_count_more = '';
                                         $first_visit_service_kinds_more = $_REQUEST['demo1'][$a];
                                         $first_visit_service_money_more = $_REQUEST['demo3'][$a];
                                         $first_visit_service_count_more = $_REQUEST['demo2'][$a];
                                         if (!empty($first_visit_service_kinds_more)) {
                                             $insert_first_visit_service_info_more_set = "
                                             Insert into service_history(service_history_name,service_history_count,service_history_money,service_visit_pid)
                                             VALUES ('$first_visit_service_kinds_more','$first_visit_service_count_more','$first_visit_service_money_more','$visit_insert_id')
                                             ";
                                             Yii::app()->db2->createCommand($insert_first_visit_service_info_more_set)->execute();
                                             continue;
                                         }

                                     }
                                 }
                             }

                             $more_second_visit_count=count($_REQUEST['sky1']);  //多条跟进的visit次数
                             //注意一点sky和day都是同样的数组长度
                             if($more_second_visit_count>0) { //每次跟进的数据存入
                                 for ($b = 0; $b < $more_second_visit_count; $b++) {
                                     //关于第一次之后的跟进的服务存入的思路:form表单里面第二次跟进 在后台处理时 应该为第0次跟进 form表单的第三跟进 在后台处理 应该为第1次
                                     //即 'serviceKinds'.$b+2.'[]' ***'serviceCounts'.$b+2.'[]'***'serviceMoney'.$b+2.'[]'
                                     $second_visit_date_info='';
                                     $second_visit_definition_info='';
                                     $second_visit_notes_info='';
                                     $second_visit_count_info='';
                                     $second_visit_date_info=$_REQUEST['sky1'][$b];  //跟进日期
                                     $second_visit_definition_info=$_REQUEST['sky2'][$b]; //跟进目的
                                     $second_visit_notes_info=$_REQUEST['sky3'][$b]; //跟进备注
                                     $second_visit_count_info=$_REQUEST['sky4'][$b];//跟进总额
                                     if(!empty($second_visit_date_info)){  //多条跟进数据对日期与跟进目的的判断
                                        $every_visit_insert_set_more="
Insert into visit_info (visit_customer_fid,visit_seller_fid,visit_notes,visit_service_money,visit_date,visit_definition)
VALUES ('$this_visit_insert_id','$user_sellers_id','$second_visit_notes_info','$second_visit_count_info','$second_visit_date_info','$second_visit_definition_info')";
                                         Yii::app()->db2->createCommand($every_visit_insert_set_more)->execute();  //存入第一次之后的每次跟进
                                         $every_insert_id='';
                                         $every_insert_id=Yii::app()->db2->getLastInsertID(); //第一次跟进之后每次跟进的存入数据的主键id
                                         $valueServiceKinds='';
                                         $valueServiceCount='';
                                         $valueServiceMoney='';
                                         $valueServiceMoney='serviceMoney'.($b+2);
                                         $valueServiceCount='serviceCounts'.($b+2);
                                         $valueServiceKinds='serviceKinds'.($b+2); //动态跟进服务的动态

                                         if(isset($_REQUEST[$valueServiceKinds])){  //判断每次动态跟进的服务
                                             for($c=0;$c<count($_REQUEST[$valueServiceKinds]);$c++){
                                                 $get_every_service_kinds=$_REQUEST[$valueServiceKinds][$c];   //服务类别
                                                 $get_every_service_money=$_REQUEST[$valueServiceMoney][$c];  //单次服务金额
                                                 $get_every_service_count=$_REQUEST[$valueServiceCount][$c]; //数量计数
                                                    if(!empty($get_every_service_kinds)){
                                                        $insert_every_service_set="
                                                        Insert into service_history (service_history_name,service_history_count,service_history_money,service_visit_pid)
                                                         VALUES
                                                         ('$get_every_service_kinds','$get_every_service_count','$get_every_service_money','$every_insert_id')
                                                        ";
                                                        Yii::app()->db2->createCommand($insert_every_service_set)->execute();
                                                        continue;
                                                    }
                                             }
                                         }
                                         $more_visit_service_kinds_set='';
                                         $more_visit_service_count_set='';
                                         $more_visit_service_money_set='';
                                         $more_visit_service_kinds_set=$_REQUEST['day1'][$b];
                                         $more_visit_service_count_set=$_REQUEST['day2'][$b];
                                         $more_visit_service_money_set=$_REQUEST['day3'][$b];
                                         $more_visit_service_info_first_set="
                                         Insert into service_history (service_history_name,service_history_count,service_history_money,service_visit_pid)
                                         VALUES ('$more_visit_service_kinds_set','$more_visit_service_count_set','$more_visit_service_money_set','$every_insert_id')
                                         ";
                                         Yii::app()->db2->createCommand($more_visit_service_info_first_set)->execute();
                                         continue;
                                     }
                                 }
                             }

                             Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Save Done'));
                             $this->redirect(Yii::app()->createUrl('sales/index'));

                           /*  Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Save Done'));
                             $this->redirect(Yii::app()->createUrl('sales/edit', array('index' => $model->id)));*/
                         } else {
                             //var_dump('2');die;
                             $message = CHtml::errorSummary($model);
                             Dialog::message(Yii::t('dialog', 'Validation Message'), $message);
                             $this->render('form', array('model' => $model,));
                         }
                     }
     }
     public function actionEdit($index)
     {
         $model = new SalesForm('edit');
         if (!$model->retrieveData($index)) {
             throw new CHttpException(404,'The requested page does not exist.');
         } else {
             $this->render('form',array('model'=>$model,));
         }
     }
     protected function performAjaxValidation($model)
     {
         if(isset($_POST['ajax']) && $_POST['ajax']==='code-form')
         {
             echo CActiveForm::validate($model);
             Yii::app()->end();
         }
     }
     public static function allowReadWrite() {
         return Yii::app()->user->validRWFunction('C02');
     }

     public static function allowReadOnly() {
         return Yii::app()->user->validFunction('C02');
     }

 }