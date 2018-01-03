<?php

class VisitForm extends CFormModel
{
	public $id;
	public $uname; //销售人
	public $type; //类型
	public $aim; //目的
	public $area; //区域
	public $road; //街道
	public $crtype; //客户类型
	public $crname; //客户名称
	public $sonname; //分店名字
	public $charge; //负责人
	public $phone;
	public $remarks; //备注
	public $city;
	public $offer;
	public $luu;//最后改变用户名
	public $lcd;//生成时间
	public $lud;//最后改变时间
	public $detail = array(
			array('seats'=>'输入服务内容',
					'number'=>0,
					'amount'=>0,
			),
	);
	public $service = array();

	public function rules()
	{
		return array(
				array('id,uname,type,aim,luu,lcd,lud,area,road,crtype,crname,sonname,charge,phone,remarks','safe'),
				array('type,aim,lcd,area,road,crtype,crname,charge,phone','required'),
		);
	}

	public function tableName($table){
		return  "$table";
	}

	public function attributeLabels()
	{
		return array(
				'id'=>Yii::t('visit','ID'),
				'uname'=>Yii::t('visit','Visit Name'),
				'type'=>Yii::t('visit','Type'),
				'aim'=>Yii::t('visit','Aim'),
				'lcd'=>Yii::t('visit','Time'),
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
		$sql = "SELECT *
				FROM $tabname
				WHERE  id = $index and city in ($city)";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			foreach ($rows as $row)
			{
				$this->id = $row['id'];
				$this->uname = $row['uname'];
				$this->type = $row['type'];
				$this->lcd = General::toDate($row['lcd']);
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
		$this->select();
		return true;
	}


	public function select(){
		$tabOne = $this->tableName("sa_visit_offer");
		$pid = $this->id;
		$sql = "SELECT *
				FROM $tabOne
				WHERE visitid = $pid";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$this->offer = $rows;
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
					    uname, type, aim, area, road, crtype, crname, sonname, charge, phone, remarks, city ,lcd, luu
				  )values (
				  		:uname, :type, :aim, :area, :road, :crtype, :crname, :sonname, :charge, :phone, :remarks, :city, :lcd, :luu
				  )";
				break;
			case 'edit':
				$sql = "update $tabName set
							type = :type,
							aim = :aim,
							area = :area,
							road = :road,
							crtype = :crtype,
							crname = :crname,
							sonname = :sonname,
							charge = :charge,
							phone = :phone,
							remarks = :remarks,
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
			$command->bindParam(':phone',$this->phone,PDO::PARAM_STR);
		if (strpos($sql,':remarks')!==false)
			$command->bindParam(':remarks',$this->remarks,PDO::PARAM_STR);
		if (strpos($sql,':city')!==false)
			$command->bindParam(':city',$city,PDO::PARAM_STR);
		if (strpos($sql,':luu')!==false)
			$command->bindParam(':luu',$uid,PDO::PARAM_STR);
		if($this->scenario!='delete'){
			if (strpos($sql,':lcd')!==false)
				$tIme = General::toMyDate($this->lcd);
			$command->bindParam(':lcd',$tIme,PDO::PARAM_INT);
		}
		$command->execute();
		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}

	public function seveoffer($arr){
		$connection = Yii::app()->db;
		if($this->scenario=='edit'){
			$this->deletOne($connection);
		}
		$transaction=$connection->beginTransaction();
		try {
			$this->saveoffers($connection,$arr);
			$transaction->commit();
		}
		catch(Exception $e) {
			$transaction->rollback();
			throw new CHttpException(404,'Cannot update.');
		}
	}

	public function saveoffers($connection,$array){
		switch ($this->scenario){
			case 'edit':
				$tabName = $this->tableName("sa_visit_offer");
				foreach ($array as $k => $v) {
					$sql = "insert into $tabName(
							visitid, name, number, money
						) values (
							:visitid, :name, :number, :money
						)";
					$command = $connection->createCommand($sql);
					if (strpos($sql, ':name') !== false)
						$command->bindParam(':name', $v['seats'], PDO::PARAM_STR);
					if (strpos($sql, ':visitid') !== false)
						$command->bindParam(':visitid', $this->id, PDO::PARAM_INT);
					if (strpos($sql, ':number') !== false)
						$command->bindParam(':number', $v['number'], PDO::PARAM_INT);
					if (strpos($sql, ':money') !== false)
						$command->bindParam(':money', $v['amount'], PDO::PARAM_INT);
					$command->execute();
				}
				return true;
				break;

			case 'new':
				foreach ($array as $k => $v) {
					$tabName = $this->tableName("sa_visit_offer");
					$sql = "insert into $tabName(
							visitid, name, number, money
						) values (
							:visitid, :name, :number, :money
						)";
					$command = $connection->createCommand($sql);
					if (strpos($sql, ':name') !== false)
						$command->bindParam(':name', $v['seats'], PDO::PARAM_STR);
					if (strpos($sql, ':visitid') !== false)
						$command->bindParam(':visitid', $this->id, PDO::PARAM_INT);
					if (strpos($sql, ':number') !== false)
						$command->bindParam(':number', $v['number'], PDO::PARAM_INT);
					if (strpos($sql, ':money') !== false)
						$command->bindParam(':money', $v['amount'], PDO::PARAM_INT);
					$command->execute();
				}
				return true;
				break;
		}
	}


	public function deletOne($connection){
		$tabName = $this->tableName("sa_visit_offer");
		$oNe = "delete from $tabName where visitid = :visitid";
		$command=$connection->createCommand($oNe);
		if (strpos($oNe,':visitid')!==false)
			$command->bindParam(':visitid',$this->id,PDO::PARAM_INT);
		$command->execute();
		return true;
	}






}
