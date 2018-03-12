<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/14 0014
 * Time: 10:25
 */
header("Content-type: text/html; charset=utf-8");
Class SalesvideoController extends Controller{
    Public $urlAjaxSelect;
    Public $arr;
    public function actionIndex($pageNum=0){
       // var_dump($_REQUEST);die;
        $model=new VideoList();
        if (isset($_POST['VideoList'])) {
            $model->attributes = $_POST['VideoList'];
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

    Public function actionAjaxUrl(){
        $name=$_REQUEST['username'];
        $pwd=$_REQUEST['password'];
        $countSelect=$_REQUEST['selectCount'];
        var_dump("aa".$name.$pwd.$countSelect);
    }
    Public function actionNew(){

        $model = new VideoForm('new');
        $this->render('form',array('model'=>$model,));
    }

    public function actionView($index)
    {
        $model = new VideoForm('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('edit',array('model'=>$model,));
        }
    }

    public function actionVideoAjax(){
        $typeArr = array("3gp","mp4","jpg", "png", "gif", "jpeg", "mov", "gears", "html5", "html4", "silverlight", "flash"); //允许上传文件格式
       $userName=Yii::app()->user->name;
        $baseUrl=Yii::app()->baseUrl; //拼接的路径
        $city=Yii::app()->user->city(); //地区权限
        $date=date('Y-m-d',time());//上传时间
        $demo=$userName;
        $path="upload/".$demo."/";
        $notes='备注信息';
        $user_pid_set="select * from sellers_user_bind_v WHERE user_id='$userName'";
        $user_pid_get=Yii::app()->db2->createCommand($user_pid_set)->queryAll();
        $pid_user=0;
        $name_user='';
        $name_position='';
        if(count($user_pid_get)>0){
            $pid_user=$user_pid_get[0]['sellers_id']; //获取id
            $name_user=isset($user_pid_get[0]['sellers_name'])?$user_pid_get[0]['sellers_name']:'无姓名'; //销售员姓名
            $name_position=isset($user_pid_get[0]['user_position'])?$user_pid_get[0]['user_position']:'无职位';//销售员职位
        }else{
            $pid_user=2;
        }
        if (!file_exists($path)){
            mkdir ($path,0777,true);
        }
        if (isset($_POST)) {
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            if (empty($name)) {
                echo json_encode(array("error" => "您还未选择文件"));
                exit;
            }
            $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
            if (!in_array($type, $typeArr)) {
            echo json_encode(array("error" => "清上传指定类型的文件！","type"=>"types"));
            exit;
        }
            if ($size > (50000 * 1024)) { //上传大小
                echo json_encode(array("error" => "文件大小已超过50000KB！","type"=>"size"));
                exit;
            }
            $pic_name = time() . rand(10000, 99999) . "." . $type; //文件名称
            $pic_url = $path . $pic_name;  //上传后图片路径+名称
            $saveUrl=$baseUrl.'/'.$pic_url;   //存入的文件路径
            $video_info_set="insert into video_info (video_info_url,seller_pid,seller_notes,city_privileges,video_info_date,video_info_statue,video_info_manager_grades,video_info_directer_grades,video_info_user_name,video_info_user_position)VALUES('$saveUrl','$pid_user','$notes','$city','$date','1','0','0','$name_user','$name_position')";
            Yii::app()->db2->createCommand($video_info_set)->execute();
            $video_insert_id=Yii::app()->db2->getLastInsertID();
            if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
                echo json_encode(array("error" => "0", "pic" => $pic_url, "name" => $pic_name,"id"=>$video_insert_id,'url'=>$saveUrl));
            } else {
                echo json_encode(array("error" => "上传有误，请检查服务器配置！","type"=>"config"));
            }
        }
    }
    public function actionDelete()
    {
        $model = new VideoForm('delete');
        if (isset($_POST['VideoForm'])) {
            $model->attributes = $_POST['VideoForm'];
            if ($model->isOccupied($model->id)) {
                Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','This record is already in use'));
                $this->redirect(Yii::app()->createUrl('Salesvideo/edit',array('index'=>$model->id)));
            } else {
                $id=isset($_REQUEST['VideoForm']['id'])?$_REQUEST['VideoForm']['id']:0;
                $del_file_set="select video_info_url from video_info where video_info_id='$id'";
                $del_file_get=Yii::app()->db2->createCommand($del_file_set)->queryAll();
                if(count($del_file_get)>0){
                  $ar=  str_replace('/','\\',$del_file_get[0]['video_info_url']);
                  if(file_exists($_SERVER['DOCUMENT_ROOT'].$ar)){
                      unlink($_SERVER['DOCUMENT_ROOT'].$ar);
                  }
                }
                $model->saveData();
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
                $this->redirect(Yii::app()->createUrl('Salesvideo/index'));
            }
        }
    }
    public function actionClick(){
        Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','video save done'));
        $this->redirect(Yii::app()->createUrl('Salesvideo/index'));
    }
    /*
     * 销售员历史
     */
    public function actionsellersIndex($pageNum=0){

        $model=new VideoSellersList();
        if (isset($_POST['VideoSellersList'])) {
            $model->attributes = $_POST['VideoSellersList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['criteria_c02']) && !empty($session['criteria_c02'])) {
                $criteria = $session['criteria_c02'];
                $model->setCriteria($criteria);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('sellers',array('model'=>$model));
    }
    Public function actionSaveNew(){
        if (isset($_POST['VideoForm'])){
            $model = new VideoForm($_POST['VideoForm']['scenario']);
            $model->attributes = $_POST['VideoForm'];
            if ($model->validate()) {
                $model->id=$model->video_primary;
                $model->saveData();
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('salesvideo/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model,));
            }
        }
    }
    //点击保存后  跳转到表单页面 且有提交的保存数据
    Public function actionSave(){

        if (isset($_POST['VideoForm'])){
            $model = new VideoForm($_POST['VideoForm']['scenario']);
            $model->video_primary=0;
            $model->attributes = $_POST['VideoForm'];
            if ($model->validate()) {
                $model->saveData();
                //$model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('salesvideo/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->redirect(Yii::app()->createUrl('salesvideo/edit',array('index'=>$model->id)));
            }
        }
    }
    public function actionEdit($index)
    {
        $model = new VideoForm('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('edit',array('model'=>$model,));
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
