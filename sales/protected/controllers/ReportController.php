<?php
class ReportController extends Controller
{
    protected static $actions = array(
        'five'=>'HB02',
        'visit'=>'HA01',
        'city'=>'HA01',
        'fenxi'=>'HA01',
        'xiazai'=>'HA01',
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
        $this->render('form_visit',array('model'=>$model,'city'=>$city,'saleman'=>$saleman));
    }

    public function actionCity(){
        $city=$_POST['txt'];
        $suffix = Yii::app()->params['envSuffix'];
        $sql="select code,name from hr$suffix.hr_employee WHERE  position in (SELECT id FROM hr$suffix.hr_dept where dept_class='sales') AND staff_status = 0 AND city='".$city."'";
        $records = Yii::app()->db->createCommand($sql)->queryAll();

        $sql = "select approver_type, username from account$suffix.acc_approver where city='$city' and (approver_type='regionMgr' or approver_type='regionSuper')";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        //print_r("<pre/>");
        $sql1="select employee_name from hr$suffix.hr_binding WHERE  user_id = '".$rows[0]['username']."'";
        $name = Yii::app()->db->createCommand($sql1)->queryAll();
        $sql2="select employee_name from hr$suffix.hr_binding WHERE  user_id = '".$rows[1]['username']."'";
        $names = Yii::app()->db->createCommand($sql2)->queryAll();
        if(!empty($rows)){
            $arr[] = $name[0]['employee_name'];
        }
        if(!empty($rows)){
            $arr[] = $names[0]['employee_name'];
        }
        $a=General::dedupToEmailList($arr);
        $sql3="select code,name from hr$suffix.hr_employee WHERE name='".$a[0]."'";
        $zhuguan = Yii::app()->db->createCommand($sql3)->queryAll();
        if(!empty($a[1])){
            $sql4="select code,name from hr$suffix.hr_employee WHERE name='".$a[1]."'";
            $jinli = Yii::app()->db->createCommand($sql4)->queryAll();
        }
        if(empty($jinli)){
            $records=array_merge($records,$zhuguan);
        }else{
            $records=array_merge($records,$zhuguan,$jinli);
        }
        echo (json_encode($records,JSON_UNESCAPED_UNICODE));

    }

    public function actionFenxi(){
        $model = new ReportVisitForm;
        $fenxi=$_POST['ReportVisitForm'];
        if($fenxi['bumen']=='yes'){
            $model['all']=$model->fenxi($fenxi);
        }else{
            $model['all']=array();
        }
        //print_r('<pre/>');
        if(!empty($fenxi['sale'])){
            $model['one']=$model->fenxione($fenxi);
        }else{
            $model['one']=array();
        }
//        print_r('<pre/>');
       //print_r($fenxi);
        $this->render('fenxi',array('model'=>$model,'fenxi'=>$fenxi));
    }

    public function actionXiaZai(){
        $model = new ReportVisitForm;
        $arr = $_POST['RptFive'];
        if($arr['bumen']=='yes'){
            $model['all']=$model->fenxi($arr);
        }else{
            $model['all']=array();
        }

        if(!empty($arr['sale'])){
            $model['one']=$model->fenxione($arr);
        }else{
            $model['one']=array();
        }
        $model->retrieveDatas($model);
//        print_r('<pre/>');
//        print_r($model);
    }

    public static function allowExecute() {
        return Yii::app()->user->validFunction(self::$actions[Yii::app()->controller->action->id]);
    }
}
?>
