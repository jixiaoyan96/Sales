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
     Public $selectData;
     Public $editUrl;
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
         if (isset($_POST['SalesForm'])) {
             $model->attributes = $_POST['SalesForm'];
             if ($model->isOccupied($model->id)) {
                 Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','This record is already in use'));
                 $this->redirect(Yii::app()->createUrl('sales/edit',array('index'=>$model->id)));
             } else {
                 $model->saveData();
                 $name=Yii::app()->user->name;
                 $user_sellers_id='';
                 if(!empty($name)){
                     $sellers_set="select * from sellers_user_bind_v WHERE user_id='$name'";
                     $sellers_get=Yii::app()->db2->createCommand($sellers_set)->queryAll();
                     if(count($sellers_get)>0){
                         $user_sellers_id=$sellers_get[0]['sellers_id']; //sellers_id
                     }
                 }
                 $customer_id=$model->id;   //customer_id
                 if($customer_id&&$user_sellers_id){
                     $visit_id='';  //暂存visit_info主键
                     $select_visit_id_set="select visit_info_id from visit_info WHERE visit_customer_fid='$customer_id' AND visit_seller_fid='$user_sellers_id'";
                     $select_visit_id_get=Yii::app()->db2->createCommand($select_visit_id_set)->queryAll();
                     if(count($select_visit_id_get)>0){
                         for($k=0;$k<count($select_visit_id_get);$k++){
                             $visit_id.=$select_visit_id_get[$k]['visit_info_id'].',';
                         }
                         $visit_id=rtrim($visit_id,',');//该拜访下的所有visit_id字符串集合
                         $delete_customer_visit_service_info="delete from new_service_info WHERE new_visit_info_pid IN ('$visit_id')";
                         Yii::app()->db2->createCommand($delete_customer_visit_service_info)->execute();//删除service_history
                         $delete_customer_visit_info="delete from visit_info WHERE visit_customer_fid='$customer_id' AND visit_seller_fid='$user_sellers_id'";
                         Yii::app()->db2->createCommand($delete_customer_visit_info)->execute();  //删除visit_info
                     }
                 }
                 Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
                 $this->redirect(Yii::app()->createUrl('sales/index'));
             }
         }
     }

     /**
      * @throws CHttpException
      *   <option value="7">选择服务大类</option>
     <option value='0'>清洁</option>
     <option value='1'>租赁机器</option>
     <option value='2'>灭虫</option>
     <option value='3'>飘盈香</option>
     <option value='4'>甲醛</option>
     <option value='5'>纸品</option>
     <option value='6'>一次性售卖</option>
      */
     Public function actionSave(){
        // echo "<pre/>";
     /*    if(isset($_REQUEST['SalesForm']['id'])){ //关于修改的数据处理
             $edit_customer_info_id=$_REQUEST['SalesForm']['id']; //客户主键
             $edit_customer_visit_info_set="SELECT * FROM visit_info WHERE visit_customer_fid='$edit_customer_info_id'";
             $edit_customer_visit_info_get=Yii::app()->db2->createCommand($edit_customer_visit_info_set)->queryAll(); //跟进数据详情
             if(count($edit_customer_visit_info_get)>0) {
                 $temporary_visit_id='visitNotes'.$edit_customer_visit_info_get[0]['visit_info_id']; //一个临时的visit_info_id值 判断是否有修改
                 if(isset($_REQUEST[$temporary_visit_id])){ //进入修改数据详情
                     for ($k = 0; $k < count($edit_customer_visit_info_get); $k++){  //循环跟进数据
                         $delete_visit_id=$edit_customer_visit_info_get[$k]['visit_info_id'];  //动态跟进主键
                         $delete_visit='delete'.$edit_customer_visit_info_get[$k]['visit_info_id']; //动态跟进删除多选框
                         $edit_visit_notes=$edit_customer_visit_info_get[$k]['visit_notes']; //动态跟进的总备注
                                if(isset($_REQUEST[$delete_visit])){ //如果删除则==1 如果没有删除 则!isset
                                    $edit_delete_visit_sql_set="delete from visit_info WHERE visit_info_id='$delete_visit_id'";
                                    Yii::app()->db2->createCommand($edit_delete_visit_sql_set)->execute();
                                    $edit_delete_service_history_set="delete from service_history WHERE service_visit_pid='$delete_visit_id'";
                                    Yii::app()->db2->createCommand($edit_delete_service_history_set)->execute();
                                }
                         else{ 
                            // 如果没有删除跟进记录 则需要进行visit和service_history的数据修改
                                $visit_info_store=array(); //跟进的每条数据
                                $visit_every_notes='';//跟进的备注
                             $visit_every_money=''; //跟进的总额
                             $visit_every_definition='';//跟进的目的
                             $visit_every_definition='visit_definition'.$delete_visit_id;
                             $visit_every_money='countMoney'.$delete_visit_id;
                             $visit_every_notes='visitNotes'.$delete_visit_id;
                             $visit_info_store=$edit_customer_visit_info_get[$k];//临时保存跟进的数据
                             if(isset($_REQUEST[$visit_every_definition])&&isset($_REQUEST[$visit_every_money])&&isset($_REQUEST[$visit_every_notes])){ //判断是否可以进行修改visit数据
                                    $update_visit_info="update visit_info set visit_notes='$_REQUEST[$visit_every_notes]',
                                                      visit_service_money='$_REQUEST[$visit_every_money]',
                                                      visit_definition='$_REQUEST[$visit_every_definition]' WHERE visit_info_id='$delete_visit_id'";
                                 Yii::app()->db2->createCommand($update_visit_info)->execute();
                             }
                             $service_data_edit_set="select * from service_history WHERE service_visit_pid=$delete_visit_id";
                             $service_data_edit_get=Yii::app()->db2->createCommand($service_data_edit_set)->queryAll();
                             if(count($service_data_edit_get)>0) {
                                 for ($y=0;$y<count($service_data_edit_get);$y++) {
                                     $service_every_money = '';//跟进的每次服务金额
                                     $service_every_count = '';//跟进的每次服务数量
                                     $service_every_name = '';//跟进的每次服务类别
                                     $service_history_id_edit=$service_data_edit_get[$y]['service_history_id'];
                                     $service_every_name = 'service_history_name'.$service_history_id_edit;
                                     $service_every_count = 'service_history_count'.$service_history_id_edit;
                                     $service_every_money = 'service_history_money'.$service_history_id_edit;
                                     if(isset($_REQUEST[$service_every_money])&&isset($_REQUEST[$service_every_count])&&isset($_REQUEST[$service_every_name])){ //判断是否可以进行修改visit数据
                                         $update_service_info="update service_history set service_history_name='$_REQUEST[$service_every_name]',
                                                      service_history_count='$_REQUEST[$service_every_count]',
                                                      service_history_money='$_REQUEST[$service_every_money]' WHERE service_history_id='$service_history_id_edit'";
                                         Yii::app()->db2->createCommand($update_service_info)->execute();
                                     }
                                 }
                             }
                         }
                     }
                 }
             }
         }*/
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
                                   $this_visit_insert_id=$model->id;  //本次存入的客户拜访数据
                             if((!empty($_REQUEST['first1'][0]))&&(!empty($_REQUEST['first2'][0]))){ //先判断第一条跟进记录是否符合要求 如果符合要求则存入 如果不符合则不存入 再查看其余跟进是否符合
                                 $first_visit_notes=$_REQUEST['first3'][0];  //第一次跟进备注
                                 $first_visit_date=$_REQUEST['first1'][0];  //第一次跟进日期
                                 $first_visit_definition=$_REQUEST['first2'][0]; //第一次跟进目的
                                 $first_visit_total=isset($_REQUEST['first4'][0])?$_REQUEST['first4'][0]:0; ; //第一次跟进总额
                                 $insert_first_visit_info_set="
              Insert into visit_info (visit_customer_fid,visit_seller_fid,visit_notes,visit_service_money,visit_date,visit_definition)VALUES
              ('$this_visit_insert_id','$user_sellers_id','$first_visit_notes','$first_visit_total','$first_visit_date','$first_visit_definition')";
                                 Yii::app()->db2->createCommand($insert_first_visit_info_set)->execute(); //存入第一次跟进主要信息
                                 $insert_first_visit_info_set_id=Yii::app()->db2->getLastInsertID(); //存入第一次跟进的id
                                $fiest_visit_service_char_insert='';//第一次跟进的所有服务的结果拼接值
                                 $charInsert=''; //获取类别和数量的结果集(第一次跟进的第一次服务)
                                 if(isset($_REQUEST['count1'][1])){  //判断是否有第一次跟进的第一次服务
                                        if($_REQUEST['count1'][1]<=5){ //是否符合选择的参数
                                            $visit_service_id=$_REQUEST['count1'][1]; //select获取的大类值
                                            $visit_service_money=isset($_REQUEST['count3'][0])?$_REQUEST['count3'][0]:1; //服务的金额
                                            $charInsert=Quiz::salesReturn($visit_service_id,1,1); //第一个1 表示第几次跟进 第二个1 表示 第几次服务  所以目前是第一次跟进的第一个服务
                                            $first_visit_service_char_insert=$charInsert;
                                            $insert_service_char_set="Insert into new_service_info(new_services_kind,new_visit_info_pid,new_service_money,new_services_kinds)VALUES
                                            ('$visit_service_id','$insert_first_visit_info_set_id','$visit_service_money','$first_visit_service_char_insert')";
                                            Yii::app()->db2->createCommand($insert_service_char_set)->execute();
                                        }
                                 }
                                 $charMoreFirst=''; //第一次跟进之后的服务增加
                                 for($i=2;$i<15;$i++){  //第一次跟进的服务跟进只能是7次或以下 即第一次加上剩余的六次服务 所以以第二次开始为列
                                        if(isset($_REQUEST['firstVisitserviceValue'.$i])){  //是否可选
                                            $selectMore=$_REQUEST['firstVisitserviceValue'.$i]; //服务大类
                                            $charInsert=Quiz::salesReturn($selectMore,1,$i);
                                            $charMoreFirst=$charInsert;     //获取字符串
                                            $moneyGet=isset($_REQUEST['demo3-1'.'-'.$i])?$_REQUEST['demo3-1'.'-'.$i]:1;//获取金额
                                            $insert_service_char_set="Insert into new_service_info(new_services_kind,new_visit_info_pid,new_service_money,new_services_kinds)VALUES
                                            ('$selectMore','$insert_first_visit_info_set_id','$moneyGet','$charMoreFirst')";
                                            Yii::app()->db2->createCommand($insert_service_char_set)->execute();
                                            $charMoreFirst='';
                                        }
                                     else{
                                         continue;
                                     }
                                 }
                             }
                             $more_second_visit_count=count($_REQUEST['sky1']);  //多条跟进的visit次数
                             //注意一点:sky和day都是同样的数组长度 且均为0下标不管

                             if($more_second_visit_count>0) {  //每次跟进的数据存入
                                 for ($b = 1; $b < $more_second_visit_count; $b++) {
                                     $s=$b+1; //$s是对前端的一种计数 显示的映射值 对跟进的计数n
                                     //关于第一次之后的跟进的服务存入的思路:form表单里面第二次跟进 在后台处理时 应该为第0次跟进 form表单的第三跟进 在后台处理 应该为第1次
                                     //即 'serviceKinds'.$b+2.'[]' ***'serviceCounts'.$b+2.'[]'***'serviceMoney'.$b+2.'[]'
                                     $second_visit_date_info='';
                                     $second_visit_definition_info='';
                                     $second_visit_notes_info='';
                                     $second_visit_count_info='';
                                     $second_visit_date_info=$_REQUEST['sky1'][$b];  //跟进日期
                                     $second_visit_definition_info=$_REQUEST['sky2'][$b]; //跟进目的
                                     $second_visit_notes_info=$_REQUEST['sky3'][$b]; //跟进备注
                                     $second_visit_count_info=isset($_REQUEST['moneyVisit'.$s])?$_REQUEST['moneyVisit'.$s]:1;//跟进总额
                                     if(!empty($second_visit_date_info)){  //多条跟进数据对日期与跟进目的的判断  进行多条跟进
                                        $every_visit_insert_set_more="
Insert into visit_info (visit_customer_fid,visit_seller_fid,visit_notes,visit_service_money,visit_date,visit_definition)
VALUES ('$this_visit_insert_id','$user_sellers_id','$second_visit_notes_info','$second_visit_count_info','$second_visit_date_info','$second_visit_definition_info')";
                                         Yii::app()->db2->createCommand($every_visit_insert_set_more)->execute();  //存入第一次之后的每次跟进
                                         $every_insert_id='';
                                         $every_insert_id=Yii::app()->db2->getLastInsertID(); //第一次跟进之后每次跟进的存入数据的主键id
                                         //存入>=2的每次跟进的第一条服务
                                         $every_first_service_kinds_choose='';
                                         if(isset($_REQUEST['day1'][$b])){  //存入动态跟进的第一条服务
                                             $more_visit_service_kinds_set=$_REQUEST['day1'][$b];  //选择的大类主id
                                             $money_get_more=$_REQUEST['day3'][$b];  //服务金额
                                             $every_first_service_kinds_choose=Quiz::salesReturn($more_visit_service_kinds_set,$s,1);

                                             $insert_service_char_every_set="Insert into new_service_info(new_services_kind,new_visit_info_pid,new_service_money,new_services_kinds)VALUES
                                            ($more_visit_service_kinds_set,'$every_insert_id','$money_get_more','$every_first_service_kinds_choose')";
                                             Yii::app()->db2->createCommand($insert_service_char_every_set)->execute();
                                         }
                                         $every_first_service_kinds_choose='';
                                                 for ($j = 0; $j < 10; $j++) {
                                                     if(isset($_REQUEST['serviceKinds'.$s.'-'.$j])){  //判断是否有该跟进下的服务选项  $b为第几个跟进的计数排序
                                                     $more_char_insert = '';
                                                     $service_money_get=isset($_REQUEST['serviceMoney'.$s.'-'.$j])?$_REQUEST['serviceMoney'.$s.'-'.$j]:1;
                                                     $kinds_choose_id=$_REQUEST['serviceKinds'.$s.'-'.$j]; //服务大类
                                                     $more_char_insert=Quiz::salesReturn($kinds_choose_id,$s,$j);  //服务详情
                                                     $insert_service_char_set="Insert into new_service_info(new_services_kind,new_visit_info_pid,new_service_money,new_services_kinds)VALUES
                                            ('$kinds_choose_id','$every_insert_id','$service_money_get','$more_char_insert')";
                                                     Yii::app()->db2->createCommand($insert_service_char_set)->execute();
                                                 }
                                             }
                                     }
                                     else{

                                         continue;
                                     }
                                 }

                            /* Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Save Done'));
                             $this->redirect(Yii::app()->createUrl('sales/index'));*/
                            Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Save Done'));
                             $this->redirect(Yii::app()->createUrl('sales/edit', array('index' => $model->id)));
                         } else {
                             //var_dump('2');die;
                             $message = CHtml::errorSummary($model);
                             Dialog::message(Yii::t('dialog', 'Validation Message'), $message);
                             $this->render('form', array('model' => $model,));
                         }
                     }
     }
     }
     public function actionEdit($index)
     {
         //var_dump($_REQUEST);die;
         $model = new SalesForm('edit');
         if (!$model->retrieveData($index)) {
             throw new CHttpException(404,'The requested page does not exist.');
         } else {
             $this->render('edit',array('model'=>$model,));
         }
     }
     public function actionServiceDetailShow(){
         $Id=isset($_REQUEST['ValueId'])?$_REQUEST['ValueId']:0;
         $service_info_detail_set="select * from new_service_info WHERE new_visit_info_pid ='$Id'";
         $service_info_detail_get=Yii::app()->db2->createCommand($service_info_detail_set)->queryAll();
         $dataArray=array();
        if(count($service_info_detail_get)>0){
            for($i=0;$i<count($service_info_detail_get);$i++){
                    $charShowKind=Quiz::returnChinese($service_info_detail_get[$i]['new_services_kind']);
                    $service_info_detail_get[$i]['new_services_kind']=$charShowKind; //存入返回的服务类型
                    $kindsArray=array();//存入需要翻译的数据
                    $charKindsShow=rtrim($service_info_detail_get[$i]['new_services_kinds'],'-');
                    $getData='';  //关于服务数据获取  服务名,数量/服务名,数量
                    $kindsArray=explode('-', $charKindsShow);//0=>服务*数量,1=>服务*数量
                    if(count($kindsArray)>0){
                    for($k=0;$k<count($kindsArray);$k++){
                                $tempArray=array(); //暂时存入服务 0=>类型名,1=>类型数量
                               $tempArray=explode('*',$kindsArray[$k]);
                               $tempArray=Quiz::transLationWords($tempArray); //0=>类型名,1=>类型数量
                               $getData.=$tempArray[0].','.$tempArray[1].'/';
                    }
                }
                $service_info_detail_get[$i]['new_services_kinds']=$getData;
            }
        }
        echo json_encode($service_info_detail_get);
     }

         public function actionServiceDetailEdit(){
             $value=$_REQUEST['ValueCount'];
             $Id=$_REQUEST['id'];
             $serviceMoneySet="select new_service_money from new_service_info WHERE new_service_info_id='$Id'";
             $serviceMoneyGet=Yii::app()->db2->createCommand($serviceMoneySet)->queryAll();
             if(count($serviceMoneyGet)>0){
                 if($value==$serviceMoneyGet[0]['new_service_money']){
                     echo '1';
                 }
             else{
                     $visit_count=0;
                     $serviceUpdateSet="update new_service_info set new_service_money='$value' WHERE new_service_info_id='$Id'";
                     Yii::app()->db2->createCommand($serviceUpdateSet)->execute();
                     $service_each_set="select new_visit_info_pid from new_service_info WHERE new_service_info_id='$Id'";
                     $service_each_get=Yii::app()->db2->createCommand($service_each_set)->queryAll();
                     $visit_id=$service_each_get[0]['new_visit_info_pid']; //获取visit_id
                     $visit_each_set="select new_service_money from new_service_info WHERE new_visit_info_pid='$visit_id'";
                     $visit_each_get=Yii::app()->db2->createCommand($visit_each_set)->queryAll();
                     if(count($visit_each_get)>0){
                         for($i=0;$i<count($visit_each_get);$i++){
                            $visit_count+=intval($visit_each_get[$i]['new_service_money']);
                         }
                     }
                     if($visit_count!=0){
                         $visit_money_set="update visit_info set visit_service_money='$visit_count' WHERE visit_info_id='$visit_id'";
                         Yii::app()->db2->createCommand($visit_money_set)->execute();
                     }
                     echo '2';
                 }
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