<?php
header("Content-type: text/html; charset=utf-8");
class FiveController extends Controller
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
     * 五部列表
    */
    public function actionIndex(){
        $model = new FiveList();
        $model->retrieveDataByPage();
        $this->render('index', array(
            'model'=>$model,
        ));
    }

    /**
    * 五部详情(只读)
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


}