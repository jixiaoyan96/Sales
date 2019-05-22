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
				'actions'=>array('notify'),
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
}

?>