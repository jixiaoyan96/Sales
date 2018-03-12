<?php
/**
 * Created by PhpStorm.
 * User: json
 * Date: 2018/1/27 0027
 * Time: 11:08
 */
header("Content-type: text/html; charset=utf-8");
Class SalesorderController extends Controller{
    Public $urlAjaxSelect;
    Public $arr;
    public function actionIndex($pageNum=0){
        $model=new SalesorderList();
        if (isset($_POST['SalesorderList'])) {
            $model->attributes = $_POST['SalesorderList'];
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
            $quiz_update_set="update quiz set quiz_employee_id='$employee_info_str' WHERE id>0";
            Yii::app()->db2->createCommand($quiz_update_set)->execute();
            $transaction->commit();
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','all checked success'));
            $this->redirect(Yii::app()->createUrl('quiz/index'));
        }
        catch(Exception $e) {
            $transaction->rollback();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','all checked failed'));
            $this->redirect(Yii::app()->createUrl('quiz/index'));
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
        $model = new SalesorderForm('new');
        $this->render('form',array('model'=>$model,));
    }

    public function actionView($index)
    {
        $model = new SalesorderForm('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('detail',array('model'=>$model,));
        }
    }

    public function actionDelete()
    {
        $model = new SalesorderForm('delete');
        if (isset($_POST['SalesorderForm'])) {
            $model->attributes = $_POST['SalesorderForm'];
            if ($model->isOccupied($model->id)) {
                Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','This record is already in use'));
                $this->redirect(Yii::app()->createUrl('Salesorder/edit',array('index'=>$model->id)));
            } else {
                $delete_id=isset($_REQUEST['SalesorderForm']['id'])?$_REQUEST['SalesorderForm']['id']:1;
                $order_detail_id_set="select * from order_customer_info WHERE order_customer_info_id='$delete_id'";
                $order_detail_id_get=Yii::app()->db2->createCommand($order_detail_id_set)->queryAll();
                if(count($order_detail_id_get)>0){
                    $gt_id_string=isset($order_detail_id_get[0]['order_detail'])?$order_detail_id_get[0]['order_detail']:0;
                    if($gt_id_string!=0){
                            $string_all=explode(',',$gt_id_string);
                            if(count($string_all)>0){
                                for($i=0;$i<count($string_all);$i++){
                                    $id=$string_all[$i]; //细节主键
                                    $order_detail_operation_set="delete from order_info WHERE order_info_id='$id'";
                                    Yii::app()->db2->createCommand($order_detail_operation_set)->execute();
                                }
                            }
                    }
                }

                $model->saveData();
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
                $this->redirect(Yii::app()->createUrl('Salesorder/index'));
            }
        }
    }

    /**
     * 客户总订单历史列表页面
     */
    public function actionprintIndex($pageNum=0){
        $model=new SaleshistoryList();
        if (isset($_POST['SaleshistoryList'])) {
            $model->attributes = $_POST['SaleshistoryList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['criteria_c02']) && !empty($session['criteria_c02'])) {
                $criteria = $session['criteria_c02'];
                $model->setCriteria($criteria);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('indexh',array('model'=>$model));
    }
    /**
     * @throws CHttpExceptiona
     * 货品数据 订单编码:orderCode  订单货物名:orderName  货物单价:orderPrice
     *          总优惠:orderFree    订单货物总数量:orderCount  订单总价:orderTotal
     *
     * SalesorderForm 数据:scenario=>new  id=>String  order_info_date=>'####/##/##' order_info_seller_name=>''
     *                      order_info_money_total=>int  order_info_rural=>String  order_info_rural_location=>String
     */

    Public function actionSave(){
        if (isset($_POST['SalesorderForm'])) {
            $model = new SalesorderForm($_POST['SalesorderForm']['scenario']);
            $model->attributes = $_POST['SalesorderForm'];
            if ($model->validate()) {
                $model->saveData();
                $main_info_insert_id=Yii::app()->db2->getLastInsertID();
                $uid = Yii::app()->user->id; //登录账号
                $city = Yii::app()->user->city();  //所属地区
                $name=Yii::app()->user->name; //登录账号
                $user_sellers_id='';
                if(!empty($name)){
                    $sellers_set="select * from sellers_user_bind_v WHERE user_id='$name'";
                    $sellers_get=Yii::app()->db2->createCommand($sellers_set)->queryAll();
                    if(count($sellers_get)>0){
                        $user_sellers_id=isset($sellers_get[0]['sellers_id'])?$sellers_get[0]['sellers_id']:0;  //销售员主键
                        $user_sellers_name=isset($sellers_get[0]['sellers_name'])?$sellers_get[0]['sellers_name']:0;  //销售员姓名
                    }
                }
                //开始对订单数据进行处理
                $orderCode=isset($_REQUEST['orderCode'])?$_REQUEST['orderCode']:array();  //订单编码
                $orderName=isset($_REQUEST['orderName'])?$_REQUEST['orderName']:array();  //订货名
                $orderPrice=isset($_REQUEST['orderPrice'])?$_REQUEST['orderPrice']:array(); //订货单价
                $orderFree=isset($_REQUEST['orderFree'])?$_REQUEST['orderFree']:array();  //订单优惠
                $orderCount=isset($_REQUEST['orderCount'])?$_REQUEST['orderCount']:array();  //订货数量
                $orderTotal=isset($_REQUEST['orderTotal'])?$_REQUEST['orderTotal']:array();  //订单总额
                $temp_insert_id='';//用于暂时存储订货id的值
                $model_insert_id=isset($model->id)?$model->id:0; //存入的主要信息主键
                $main_info_set="select * from order_customer_info WHERE order_customer_info_id='$model_insert_id'";
                $main_info_get=Yii::app()->db2->createCommand($main_info_set)->queryAll();
                if(count($main_info_get)>0){
                    $customer_name=isset($main_info_get[0]['order_customer_name'])?$main_info_get[0]['order_customer_name']:0;   //客户名
                    $customer_rural=isset($main_info_get[0]['order_customer_rural'])?$main_info_get[0]['order_customer_rural']:0;  //区域
                    $customer_street=isset($main_info_get[0]['order_customer_street'])?$main_info_get[0]['order_customer_street']:0; //街道
                    $customer_date=isset($main_info_get[0]['order_info_date'])?$main_info_get[0]['order_info_date']:0;  //日期
                }
                for($i=1;$i<count($orderCode);$i++){
                    $codeTemp=isset($orderCode[$i])?$orderCode[$i]:0; //订单编码
                    $nameTemp=isset($orderName[$i])?$orderName[$i]:0; //订货名
                    $priceTemp=isset($orderPrice[$i])?$orderPrice[$i]:0; //订货单价
                    $freeTemp=isset($orderFree[$i])?$orderFree[$i]:0;  //订单优惠
                    $countTemp=isset($orderCount[$i])?$orderCount[$i]:0;  //订货数量
                    $totalTemp=isset($orderTotal[$i])?$orderTotal[$i]:0;  //订单总额
                    $sql_set="insert into order_info (seller_id,order_info_seller_name,order_info_customer_pid,order_customer_name,order_info_rural,order_info_rural_location
                    ,order_info_code_number,order_info_money_total,order_info_date,order_goods_code_number,order_per_price,order_free,order_count,city)VALUES
                    ('$user_sellers_id','$user_sellers_name','$model_insert_id','$customer_name','$customer_rural','$customer_street','$codeTemp','$totalTemp','$customer_date','$nameTemp','$priceTemp','$freeTemp','$countTemp','$city')";
                    Yii::app()->db2->createCommand($sql_set)->execute();
                    $temp_insert_id.= Yii::app()->db2->getLastInsertID().',';
                }
                $temp_insert_id=trim($temp_insert_id,',');
                $index = $model->id;
                $customer_info_set="update order_customer_info set order_detail='$temp_insert_id' WHERE order_customer_info_id='$index'";
                Yii::app()->db2->createCommand($customer_info_set)->execute();

                if (!$model->retrieveData($index)) {
                    throw new CHttpException(404,'The requested page does not exist.');
                }
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('Salesorder/print',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model,));
            }
        }
    }

    /**
     * @param $index
     * @throws CHttpException
     * 下单统一入口
     */
    public function actionPrint($index){

        $model = new SalesorderForm('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('print',array('model'=>$model,));
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