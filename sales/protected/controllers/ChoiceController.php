<?php
header("Content-type: text/html; charset=utf-8");
class ChoiceController extends Controller
{
    /**
     * 订单列表
     */
    public function actionIndex($pageNum=0)
    {
        $model = new ChoiceList();
        if (isset($_POST['ChoiceList'])) {
            $model->attributes = $_POST['ChoiceList'];
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

    public function actionsublist($pageNum=0)
    {
        $model = new ChoiceList();
        if (isset($_POST['ChoiceForm'])) {
            $model->attributes = $_POST['ChoiceForm'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['criteria_t01']) && !empty($session['criteria_t01'])) {
                $criteria = $session['criteria_t01'];
                $model->setCriteria($criteria);
            }
        }
        $id = $_POST['ChoiceForm']['id'];
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPages($model->pageNum,$id);
        $this->render('index',array('model'=>$model));
    }


    public function actionView($index)
    {
        $model = new ChoiceForm('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }


    public function actionNew()
    {
        $model = new ChoiceForm('new');
        $model->typeid = 1;
        $model->pid = 0;
        $this->render('form',array('model'=>$model));
    }

    public function actionNewsub()
    {
        $model = new ChoiceForm('new');
        $model->typeid = 2;
        $model->pid = $_POST['ChoiceForm']['id'];
        $this->render('subform',array('model'=>$model));
    }

    /**
     *保存已经有的
     */
    public function actionSave()
    {
        if (isset($_POST['ChoiceForm'])) {
            $model = new ChoiceForm($_POST['ChoiceForm']['scenario']);
            $model->attributes = $_POST['ChoiceForm'];
            if ($model->validate()) {
                $model->saveData();
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('choice/edit',array('index'=>$model->id)));
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
        $model = new ChoiceForm('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }


    /**
     *删除一条
     */
    public function actionDelete()
    {
        $model = new ChoiceForm('delete');
        if (isset($_POST['ChoiceForm'])) {
            $model->attributes = $_POST['ChoiceForm'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
        $this->redirect(Yii::app()->createUrl('choice/index'));
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='sales-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }





}