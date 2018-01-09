<?php
header("Content-type: text/html; charset=utf-8");
class StaffsController extends Controller
{
    public function filters()
    {
        return array(
            'enforceRegisteredStation',
            'enforceSessionExpiration',
            'enforceNoConcurrentLogin',
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * 人员列表
     */
    public function actionIndex($pageNum=0)
    {
        $model = new StaffsList();
        if (isset($_POST['FiveList'])) {
            $model->attributes = $_POST['FiveList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['criteria_t01']) && !empty($session['criteria_t01'])) {
                $criteria = $session['criteria_t01'];
                $model->setCriteria($criteria);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }


    //人员分类列表
    public function actionulist($pageNum=0)
    {
        $model = new StaffsList();
        if (isset($_POST['StaffsList'])) {
            $model->attributes = $_POST['StaffsList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['criteria_t01']) && !empty($session['criteria_t01'])) {
                $criteria = $session['criteria_t01'];
                $model->setCriteria($criteria);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPages($model->pageNum);
        $this->render('list',array('model'=>$model));
    }

    //中转控制器
    public function actionTransfer(){
        if (isset($_POST['StaffsList'])){

        }else{
            throw new CHttpException(404,'The requested page does not exist.');
        }

    }


    /**
     * 拜访详情(只读)
     */
    public function actionView($index)
    {
        $model = new FiveForm('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model,));
        }
    }

    /**
     *添加一条新的
     */
    public function actionNew()
    {
        $model = new FiveForm('new');
        $model->select();
        $this->render('form',array('model'=>$model,));
    }

    /**
     *保存已经有的
     */
    public function actionSave()
    {
        if (isset($_POST['FiveForm'])) {
            $model = new FiveForm($_POST['FiveForm']['scenario']);
            $model->attributes = $_POST['FiveForm'];
            if ($model->validate()) {
                $model->saveData();
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('Five/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog', 'Validation Message'), $message);
                $this->render('form', array('model' => $model,));
            }
        }
    }

    /**
     *修改一条
     */
    public function actionEdit($index)
    {
        $model = new FiveForm('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model,));
        }
    }

    /**
     *删除一条
     */
    public function actionDelete()
    {
        $model = new FiveForm('delete');
        if (isset($_POST['FiveForm'])) {
            $model->attributes = $_POST['FiveForm'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
        $this->redirect(Yii::app()->createUrl('Five/index'));
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='visit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    //下载
    public function actiondownfile()
    {
        $url = $_POST['FiveForm']['url'];
        $name = trim(strrchr($url, '/'),'/');

        $file=fopen($url,"r");
        header("Content-Type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".filesize($url));
        header("Content-Disposition: attachment; filename=$name");
        echo fread($file,filesize($url));
        fclose($file);
    }



}