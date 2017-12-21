<?php
header("Content-type: text/html; charset=utf-8");
class SalesController extends Controller
{
    /**
     * 订单列表
    */

    public function actionIndex($pageNum=0)
    {
        $model = new SalesList();
        if (isset($_POST['SalesList'])) {
            $model->attributes = $_POST['SalesList'];
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


    /**
    * 订单详情(只读)
     */
    public function actionView($index)
    {
        $model = new SalesForm('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }

    /**
    *添加一条新的
     */
    public function actionNew()
    {
        $model = new SalesForm('new');
        $model->select();
        $this->render('form',array('model'=>$model));
    }

    /**
    *保存已经有的
     */
    public function actionSave()
    {

        if (isset($_POST['SalesForm'])) {
            $s = $_POST['SalesForm']['detail'];
            $sum=0;
            foreach($s as $k=>$v){
                $sum+=$v['total'];
            }
            $model = new SalesForm($_POST['SalesForm']['scenario']);
            $model->attributes = $_POST['SalesForm'];
            if ($model->validate()) {
                $model->saveData($sum);
                $model->savegood($_POST['SalesForm']['detail']);
//				$model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('sales/edit',array('index'=>$model->id)));
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
        $model = new SalesForm('edit');
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
        $model = new SalesForm('delete');
        if (isset($_POST['SalesForm'])) {
            $model->attributes = $_POST['SalesForm'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
        $this->redirect(Yii::app()->createUrl('sales/index'));
    }

    public function actionTwo(){
        $model = new SalesForm();
        $id = isset($_GET['id']) ? $_GET['id'] : 250;
        $area = $model->getSecond($id);
        $arr_area = array_column($area, 'gname', 'goodid');
        //对获取到的转JSON格式
        header('Content-type: application/json');
        echo CJSON::encode($arr_area);
        Yii::app()->end();
    }

    public function actiongetMoney(){
        $model = new SalesForm();
        $id = isset($_GET['id']) ? $_GET['id'] :"";
        $money = $model->getmoney($id);
        header('Content-type: application/json');
        echo CJSON::encode($money);
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