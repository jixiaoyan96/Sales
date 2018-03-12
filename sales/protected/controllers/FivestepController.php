<?php

class FivestepController extends Controller 
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('pass','fail'),
				'expression'=>array('FivestepController','allowApproval'),
			),
			array('allow', 
				'actions'=>array('new','edit','delete','save','submit'),
				'expression'=>array('FivestepController','allowGeneralUse'),
			),
			array('allow', 
				'actions'=>array('index','view'),
				'expression'=>array('FivestepController','allowReadOnly'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($pageNum=0) 
	{
		$model = new FivestepList;
		if (isset($_POST['FivestepList'])) {
			$model->attributes = $_POST['FivestepList'];
		} else {
			$session = Yii::app()->session;
			if (isset($session['criteria_hk03']) && !empty($session['criteria_hk03'])) {
				$criteria = $session['criteria_hk03'];
				$model->setCriteria($criteria);
			}
		}
		$model->determinePageNum($pageNum);
		$model->retrieveDataByPage($model->pageNum);
		$this->render('index',array('model'=>$model));
	}

	public function actionPass() {
		if (isset($_POST['FivestepForm'])) {
			$model = new FivestepForm($_POST['FivestepForm']['scenario']);
			$model->attributes = $_POST['FivestepForm'];
			if ($model->validate()) {
				if ($model->status=='P') {
					$model->status = 'C';
					$model->saveData();
				}
				Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
				$this->redirect(Yii::app()->createUrl('fivestep/view',array('index'=>$model->id)));
			} else {
				$message = CHtml::errorSummary($model);
				Dialog::message(Yii::t('dialog','Validation Message'), $message);
				$this->render('form',array('model'=>$model,));
			}
		}
	}

	public function actionFail() {
		if (isset($_POST['FivestepForm'])) {
			$model = new FivestepForm($_POST['FivestepForm']['scenario']);
			$model->attributes = $_POST['FivestepForm'];
			if ($model->validate()) {
				if ($model->status=='P') {
					$model->status = 'F';
					$model->saveData();
				}
				Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
				$this->redirect(Yii::app()->createUrl('fivestep/view',array('index'=>$model->id)));
			} else {
				$message = CHtml::errorSummary($model);
				Dialog::message(Yii::t('dialog','Validation Message'), $message);
				$this->render('form',array('model'=>$model,));
			}
		}
	}

	public function actionSubmit() {
		if (isset($_POST['FivestepForm'])) {
			$model = new FivestepForm($_POST['FivestepForm']['scenario']);
			$model->attributes = $_POST['FivestepForm'];
			if ($model->validate()) {
				if ($model->status!='F' && $model->status!='C') {
					$model->status = 'P'
					$model->saveData();
				}
				Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
				$this->redirect(Yii::app()->createUrl('fivestep/view',array('index'=>$model->id)));
			} else {
				$message = CHtml::errorSummary($model);
				Dialog::message(Yii::t('dialog','Validation Message'), $message);
				$this->render('form',array('model'=>$model,));
			}
		}
	}

	public function actionSave()
	{
		if (isset($_POST['FivestepForm'])) {
			$model = new FivestepForm($_POST['FivestepForm']['scenario']);
			$model->attributes = $_POST['FivestepForm'];
			if ($model->validate()) {
				$model->saveData();
				Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
				$this->redirect(Yii::app()->createUrl('fivestep/edit',array('index'=>$model->id)));
			} else {
				$message = CHtml::errorSummary($model);
				Dialog::message(Yii::t('dialog','Validation Message'), $message);
				$this->render('form',array('model'=>$model,));
			}
		}
	}

	public function actionView($index)
	{
		$model = new FivestepForm('view');
		if (!$model->retrieveData($index)) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('form',array('model'=>$model,));
		}
	}
	
	public function actionNew()
	{
		$model = new FivestepForm('new');
		$this->render('form',array('model'=>$model,));
	}
	
	public function actionEdit($index)
	{
		$model = new FivestepForm('edit');
		if (!$model->retrieveData($index)) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('form',array('model'=>$model,));
		}
	}
	
	public function actionDelete()
	{
		$model = new FivestepForm('delete');
		if (isset($_POST['FivestepForm'])) {
			$model->attributes = $_POST['FivestepForm'];
			if ($model->status=='D') $model->saveData();
			Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
			$this->redirect(Yii::app()->createUrl('fivestep/index'));
		}
	}
	
	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('HK03');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('HK03');
	}

	public static function allowApproval() {
		return Yii::app()->user->validFunction('CN01') && $this->allowReadWrite();
	}
	
	public static function allowGenralUse() {
		return !Yii::app()->user->validFunction('CN01') && $this->allowReadWrite();
	}
}
