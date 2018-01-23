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
         echo "<pre/>";
        var_dump($_REQUEST);die;
                     if (isset($_POST['QuizForm'])) {
                         $model = new SalesForm($_POST['QuizForm']['scenario']);
                         $model->attributes = $_POST['QuizForm'];
                         if ($model->validate()) {
                             $model->saveData();
                             Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Save Done'));
                             $this->redirect(Yii::app()->createUrl('sales/edit', array('index' => $model->id)));
                         } else {
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