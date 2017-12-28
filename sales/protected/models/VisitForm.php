<?php

class VisitForm extends CFormModel
{
	public $id;
	public $uname; //销售人
	public $type; //类型
	public $aim; //目的
	public $datatime;
	public $area; //区域
	public $road; //街道
	public $crtype; //客户类型
	public $crname; //客户名称
	public $sonname; //分店名字
	public $charge; //负责人
	public $phone;
	public $remarks; //备注
	public $city;
	public $detail = array(
			array('gname'=>1,
					'tgname'=>0,
					'gmoney'=>0,
					'goodagio'=>0,
					'money'=>0,
					'total'=>0,
			),
	);
	public $service = array();

	public function rules()
	{
		return array(
				array('id,uname,type,aim,datatime,area,road,crtype,crname,sonname,charge,phone,remarks','safe'),
				array('type,aim,datatime,area,road,crtype,crname,charge,phone','required'),
		);
	}

	public function tableName($table){
		return 'sa' . Yii::app()->params['myTabname'] . ".$table";
	}

	public function attributeLabels()
	{
		return array(
				'id'=>Yii::t('visit','ID'),
				'uname'=>Yii::t('visit','Visit Name'),
				'type'=>Yii::t('visit','Type'),
				'aim'=>Yii::t('visit','Aim'),
				'datatime'=>Yii::t('visit','Time'),
				'area'=>Yii::t('visit','Area'),
				'road'=>Yii::t('visit','Road'),
				'crtype'=>Yii::t('visit','Customer type'),
				'crname'=>Yii::t('visit','Customer name'),
				'sonname'=>Yii::t('visit','Name of branch store'),
				'charge'=>Yii::t('visit','Charge'),
				'phone'=>Yii::t('visit','Phone'),
				'remarks'=>Yii::t('visit','Remarks'),
				'services'=>Yii::t('visit','Use of services'),
				'amount'=>Yii::t('visit','Annual amount'),
				'number'=>Yii::t('visit','Number'),
				'of services'=>Yii::t('visit','Selection of services'),

		);
	}

	public function retrieveData($index)
	{
		$tabname = $this->tableName("sa_visit");
		$city = Yii::app()->user->city_allow();
		$sql = "SELECT * FROM $tabname WHERE  id = $index and city in ($city)	";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			foreach ($rows as $row)
			{
				$this->id = $row['id'];
				$this->uname = $row['uname'];
				$this->type = $row['type'];
				$this->datatime = General::toDate($row['datatime']);
				$this->aim = $row['aim'];
				$this->area = $row['area'];
				$this->road = $row['road'];
				$this->crtype = $row['crtype'];
				$this->crname = $row['crname'];
				$this->sonname = $row['sonname'];
				$this->charge = $row['charge'];
				$this->phone = $row['phone'];
				$this->remarks = $row['remarks'];
				$this->city = $row['city'];
				break;
			}
		}
		return true;
	}


	public function saveData()
	{
		$connection = Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try {
			$this->savevisit($connection);
			$transaction->commit();
		}
		catch(Exception $e) {
			$transaction->rollback();
			throw new CHttpException(404,'Cannot update.');
		}
	}


	protected function savevisit(&$connection)
	{
		$tabName = $this->tableName("sa_visit");
		$sql = '';
		switch ($this->scenario) {
			case 'delete':
				$sql = "delete from $tabName where id = :id";
				break;
			case 'new':
				$sql = "insert into $tabName(
					    uname, type, aim, area, road, crtype, crname, sonname, charge, phone, remarks, city
				  )values (
				  		:uname, :type, :aim, :area, :road, :crtype, :crname, :sonname, :charge, :phone, :remarks, :city
				  )";
				break;
			case 'edit':
				$sql = "update $tabName set
							uname = :uname,
							type = :type,
							aim = :aim,
							area = :area,
							road = :road,
							crtype = :crtype,
							crname = :crname,
							sonname = :sonname,
							charge = :charge,
							phone = :phone,
							remarks = :remarks
						where id = :id and city = :city
						";
				break;
		}


		$city = Yii::app()->user->city();
		$uid = Yii::app()->user->id;
		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$this->id,PDO::PARAM_INT);
		if (strpos($sql,':uname')!==false)
			$command->bindParam(':uname',$uid,PDO::PARAM_STR);
		if (strpos($sql,':type')!==false)
			$command->bindParam(':type',$this->type,PDO::PARAM_STR);
		if (strpos($sql,':aim')!==false)
			$command->bindParam(':aim',$this->aim,PDO::PARAM_STR);
		if (strpos($sql,':area')!==false)
			$command->bindParam(':area',$this->area,PDO::PARAM_STR);
		if (strpos($sql,':road')!==false)
			$command->bindParam(':road',$this->road,PDO::PARAM_STR);
		if (strpos($sql,':crtype')!==false)
			$command->bindParam(':crtype',$this->crtype,PDO::PARAM_STR);
		if (strpos($sql,':crname')!==false)
			$command->bindParam(':crname',$this->crname,PDO::PARAM_STR);
		if (strpos($sql,':sonname')!==false)
			$command->bindParam(':sonname',$this->sonname,PDO::PARAM_STR);
		if (strpos($sql,':charge')!==false)
			$command->bindParam(':charge',$this->charge,PDO::PARAM_STR);
		if (strpos($sql,':phone')!==false)
			$command->bindParam(':phone',$this->phone,PDO::PARAM_INT);
		if (strpos($sql,':remarks')!==false)
			$command->bindParam(':remarks',$this->remarks,PDO::PARAM_STR);
		if (strpos($sql,':city')!==false)
			$command->bindParam(':city',$city,PDO::PARAM_STR);
		$command->execute();
		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}
}
