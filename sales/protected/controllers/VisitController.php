<?php
header("Content-type: text/html; charset=utf-8");
class VisitController extends Controller
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
     * 拜访列表
    */
    public function actionIndex(){
        $model = new VisitList();
        $model->retrieveDataByPage();
        $this->render('index', array(
            'model'=>$model,
        ));
    }

    /**
    * 拜访详情(只读)
     */
    public function actionView($index)
    {
        $model = new VisitForm('view');
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
        $model = new VisitForm('new');
        $this->render('form',array('model'=>$model,));
    }

    /**
    *保存已经有的
     */
    public function actionSave()
    {
        if (isset($_POST['VisitForm'])) {
            $model = new VisitForm($_POST['VisitForm']['scenario']);
            $model->attributes = $_POST['VisitForm'];
            if ($model->validate()) {
                $model->saveData();
                if($_POST['VisitForm']['scenario']=='new'){
                    $model->seveoffer($_POST['VisitForm']['detail']);
                }
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('visit/edit',array('index'=>$model->id)));
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
        $model = new VisitForm('edit');
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
        $model = new VisitForm('delete');
        if (isset($_POST['VisitForm'])) {
            $model->attributes = $_POST['VisitForm'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
        $this->redirect(Yii::app()->createUrl('visit/index'));
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='visit-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionGps(){
        if (isset($_POST['VisitForm'])){
            $area = $_POST['VisitForm']['area'];
            $road = $_POST['VisitForm']['road'];
            $this->renderPartial('gps',
                array(
                    'area'=>$area,
                    'road'=>$road,));
        }else{
            throw new CHttpException(404,'The requested page does not exist.');
        }

    }


    public function actionoffer(){
        if(isset($_POST['VisitForm'])){
            $id = $_POST['VisitForm']['id'];
            $model = new VisitForm('new');
            $model->id = $id;
            $this->render('offer',array('model'=>$model));
        }
    }

    public function actionsaveoffer(){
        $model = new VisitForm('edit');
        if(isset($_POST['VisitForm'])){
            $post = $_POST['VisitForm']['detail'];
            $id = $_POST['VisitForm']['id'];
            $model->id = $id;
            $model->seveoffer($post);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('visit/edit',array('index'=>$id)));
        } else {
            $message = CHtml::errorSummary($model);
            Dialog::message(Yii::t('dialog', 'Validation Message'), $message);
            $this->render('form', array('model' => $model,));
        }
    }


}