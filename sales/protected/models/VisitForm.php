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
	public $service = array();

	public function rules()
	{
		return array(
				array('id,uname,type,aim,datatime,area,road,crtype,crname,sonname,phone,remarks','safe'),
				array('name,code,lcu','required'),
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
		);
	}


	public function validateCode($attribute, $params) {
		$code = $this->$attribute;
		$city = Yii::app()->user->city();
		if (!empty($code)) {
			switch ($this->scenario) {
				case 'new':
					if (Sales::model()->exists('code=? and city=?',array($code,$city))) {
						$this->addError($attribute, Yii::t('supplier','Code')." '".$code."' ".Yii::t('app','already used'));
					}
					break;
				case 'edit':
					if (Sales::model()->exists('code=? and city=? and id<>?',array($code,$city,$this->id))) {
						$this->addError($attribute, Yii::t('supplier','Code')." '".$code."' ".Yii::t('app','already used'));
					}
					break;
			}
		}
	}

	public function retrieveData($index)
	{
		$tabname = $this->tableName("sa_visit");
		$city = Yii::app()->user->city_allow();
		$sql = "SELECT * FROM $tabname WHERE  id = $index and city in ($city);
				";

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
			$this->savesales($connection);
			$transaction->commit();
		}
		catch(Exception $e) {
			$transaction->rollback();
			throw new CHttpException(404,'Cannot update.');
		}
	}


	protected function savesales(&$connection)
	{
		$tabName = $this->tableName();
		$sql = '';
		switch ($this->scenario) {
			case 'delete':
				$sql = "delete from $tabName where id = :id and city = :city";
				break;
			case 'new':
				$sql = "insert into $tabName(
							code, name, time, money, lcu, address, city
						) values (
							:code, :name, :time, :money, :lcu, :address, :city
						)";
				break;
			case 'edit':
				$sql = "update $tabName set
							code = :code,
							name = :name,
							time = :time,
							money = :money,
							lcu = :lcu,
							address = :address,
							city = :city
						where id = :id and city = :city
						";
				break;
		}

		$city = Yii::app()->user->city();
		$uid = Yii::app()->user->id;

		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$this->id,PDO::PARAM_INT);
		if (strpos($sql,':code')!==false)
			$command->bindParam(':code',$this->code,PDO::PARAM_STR);
		if (strpos($sql,':name')!==false)
			$command->bindParam(':name',$this->name,PDO::PARAM_STR);
		if (strpos($sql,':money')!==false)
			$command->bindParam(':money',$this->money,PDO::PARAM_STR);
		if (strpos($sql,':time')!==false)
			$Ctime = General::toMyDate($this->time);
			$command->bindParam(':time',$Ctime,PDO::PARAM_STR);
		if (strpos($sql,':lcu')!==false)
			$command->bindParam(':lcu',$uid,PDO::PARAM_STR);
		if (strpos($sql,':address')!==false)
			$command->bindParam(':address',$this->address,PDO::PARAM_INT);
		if (strpos($sql,':city')!==false)
			$command->bindParam(':city',$city,PDO::PARAM_STR);
		$command->execute();

		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}
}
