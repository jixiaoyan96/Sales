<?php
class ReportController extends Controller
{
    protected static $actions = array(
        'five'=>'HB02',
        'visit'=>'HA01',
        'city'=>'HA01',
        'fenxi'=>'HA01',
        'overtimelist'=>'YB02',
        'pennantexlist'=>'YB05',
        'pennantculist'=>'YB06',
        'leavelist'=>'YB03',
    );

    public function filters()
    {
        return array(
            'enforceRegisteredStation',
            'enforceSessionExpiration',
            'enforceNoConcurrentLogin',
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        $act = array();
        foreach ($this->action as $key=>$value) { $act[] = $key; }
        return array(
            array('allow',
                'actions'=>$act,
                'expression'=>array('ReportController','allowExecute'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionFive() {
        $model = new ReportH02Form;
        if (isset($_POST['ReportH02Form'])) {
            $model->attributes = $_POST['ReportH02Form'];

            if ($model->validate()) {
                $model->addQueueItem();
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Report submitted. Please go to Report Manager to retrieve the output.'));
            }
             else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
            }
        }
        $this->render('form_y02',array('model'=>$model));
    }

    public function actionVisit() {
        $model = new ReportVisitForm;
        if (isset($_POST['ReportVisitForm'])) {
            $model->attributes = $_POST['ReportVisitForm'];

        }
        $city=$model->city();
        $saleman=$model->saleman();
//print_r($saleman);
        $this->render('form_visit',array('model'=>$model,'city'=>$city,'saleman'=>$saleman));
    }

    public function actionCity(){
        $city=$_POST['txt'];
        $suffix = Yii::app()->params['envSuffix'];
        $sql="select code,name from hr$suffix.hr_employee WHERE  position in (SELECT id FROM hr$suffix.hr_dept where dept_class='sales') AND staff_status = 0 AND city='".$city."'";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
//        echo "<pre>";
//        print_r($records);
//        echo "</pre>";
//        die;
        echo (json_encode($records,JSON_UNESCAPED_UNICODE));

    }

    public function actionFenxi(){
        $model = new ReportVisitForm;
        $fenxi=$_POST['ReportVisitForm'];
        if($fenxi['bumen']=='yes'){
            $arr=$model->fenxi($fenxi);
        }else{
            $arr=array();
        }
        //print_r('<pre/>');
        if(!empty($fenxi['sale'])){
            $one=$model->fenxione($fenxi);
        }else{
            $one=array();
        }
       //print_r($fenxi);
        $this->render('fenxi',array('model'=>$model,'arr'=>$arr,'one'=>$one));
    }

    public static function allowExecute() {
        return Yii::app()->user->validFunction(self::$actions[Yii::app()->controller->action->id]);
    }
}
?>
