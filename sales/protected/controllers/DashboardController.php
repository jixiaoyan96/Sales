<?php

class DashboardController extends Controller
{
	public $interactive = false;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl - checksession', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('notify','salepeople'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionNotify($id=-1) {
		$rtn = array();
		if ($id >= 0) {
			$model = new Notification();
			$rtn = $model->getNewMessageById($id);
		}
		echo json_encode($rtn);
	}
	
public function actionSalepeople() {
    $suffix = Yii::app()->params['envSuffix'];
    $models=array();
    $sql="select distinct  a.username ,c.employee_name ,b.name  FROM sal_visit a 
          inner join hr$suffix.hr_binding c on a.username = c.user_id 
          inner join security$suffix.sec_city b on a.city = b.code 
          ";
    //人名
    $people = Yii::app()->db->createCommand($sql)->queryAll();

    foreach ($people as $a){
        $sql1="select id from sal_visit where username='".$a['username']."' and  visit_obj like '%10%'";
        $id = Yii::app()->db->createCommand($sql1)->queryAll();
        //区域
        $sql="select name from security$suffix.sec_city where code=(select region from security$suffix.sec_city where name='".$a['name']."')";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        //单数
        //$sums=count($id);
        $money=0;
        $moneys=0;
        foreach ($id as $b){
            $sql2="select field_id, field_value from sal_visit_info where field_id in ('svc_A7','svc_B6','svc_C7','svc_D6','svc_E7','svc_F4','svc_G3') and visit_id = '".$b['id']."'";
            $array = Yii::app()->db->createCommand($sql2)->queryAll();
            $summoney = 0;
            foreach($array as $item){
                $summoney += $item['field_value'];
            }
            //总金额
            $money+=$summoney;
        }
        $moneys+=$money;
        if(!empty($rows)){
            $model['quyu']=$rows[0]['name'];
        }else{
            $model['quyu']='空';
        }
        $model['name']=$a['employee_name'];
        $model['user']=$a['username'];
        $model['city']=$a['name'];;
        $model['money']=$moneys;
        $models[]=$model;
        $last_names = array_column($models,'money');
        array_multisort($last_names,SORT_DESC,$models);
        $models = array_slice($models, 0, 20);
	}
	
	echo json_encode($models);
}

}

?>