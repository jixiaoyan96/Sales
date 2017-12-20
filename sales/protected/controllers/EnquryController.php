<?php
class EnquryController extends Controller
{
    /**
     * 五部曲列表
    */
    public function actionIndex(){
        $model = new SalesList();
        $model->retrieveDataByPage();
        $this->render('index', array(
            'model'=>$model,
        ));
    }

    /**
    * 五部曲详情(只读)
     */
    public function actionView($index)
    {
        $model = new SalesForm('view');
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
        $model = new SalesForm('new');
        $this->render('form',array('model'=>$model,));
    }

    /**
    *保存已经有的
     */
    public function actionSave()
    {

        if (isset($_POST['SalesForm'])) {
            $model = new SalesForm($_POST['SalesForm']['scenario']);
            $model->attributes = $_POST['SalesForm'];
            if ($model->validate()) {
                $model->saveData();
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
            $this->render('form',array('model'=>$model,));
        }
    }

    /**
     *删除一条
    */
    public function actionDelete()
    {
        $model = new SalesForm('delete');
        if (isset($_POST['SupplierForm'])) {
            $model->attributes = $_POST['SupplierForm'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('supplier/index'));
    }





}