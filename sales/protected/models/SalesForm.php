<?php

class SalesForm extends CFormModel
{
	public $id;
	public $code;
	public $name;
	public $money;
	public $address;
	public $lcu;
	public $time;
	public $city;
	public $goodid;
	public $goodnumber;
	public $goodmoney;
	public $goodagio;
	public $region;
	public $status;
	public $title;
	public $gname;
	public $good;
	public $detail = array(
			array('gname'=>1,
					'logid'=>0,
					'task'=>0,
					'qty'=>'',
					'deadline'=>'',
					'finish'=>'N',
					'uflag'=>'N',
			),
	);
	public $service = array();

	public function rules()
	{
		return array(
				array('id,code,name,money,address,lcu,time,city,region','safe'),
				array('name','required'),
		);
	}

	public function tableName()
	{
		return 'sa' . Yii::app()->params['myTabname'] . '.sa_order';
	}

	public function tableNames($table){
		return 'sa' . Yii::app()->params['myTabname'] . ".$table";
	}

	public function attributeLabels()
	{
		return array(
				'code'=>Yii::t('sales','Code'),
				'name'=>Yii::t('sales','Name'),
				'time'=>Yii::t('sales','Time'),
				'address'=>Yii::t('sales','Address'),
				'money'=>Yii::t('sales','Money'),
				'lcu'=>Yii::t('sales','Lcu'),
				'city'=>Yii::t('sales','City'),
				'region'=>Yii::t('sales','Region'),
				'status'=>Yii::t('sales','Status'),
				'goodid'=>Yii::t('sales','Goodid'),
				'goodnumber'=>Yii::t('sales','Goodnumber'),
				'goodmoney'=>Yii::t('sales','Goodidmoney'),
				'goodagio'=>Yii::t('sales','Goodagio'),
				'gname'=>Yii::t('sales','Gname'),
				'service'=>Yii::t('sales','Service content'),
				'Use of goods'=>Yii::t('sales','Use of goods'),
				'Goods Number'=>Yii::t('sales','Goods Number'),
				'Goods Price'=>Yii::t('sales','Goods Price'),
		);
	}


	public function getcode(){
		$code = "";
		$code = $this->getrand();
		$time = time();
		$uid = Yii::app()->user->id;
		$iscode = $time.$code.$uid;
		return $iscode;

	}

	public function getSecond($id){
		$tab = $this->tableNames("sa_good");
		$sql = "SELECT goodid,gname FROM $tab WHERE pid = $id";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		return $rows;
	}

	public function getrand(){
		$chars_array = array(
				"0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
				"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
				"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
				"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
				"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
				"S", "T", "U", "V", "W", "X", "Y", "Z",
		);
		$charsLen = count($chars_array) - 1;

		$outputstr = "";
		for ($i=0; $i<4; $i++)
		{
			$outputstr .= $chars_array[mt_rand(0, $charsLen)];
		}
		return $outputstr;
	}

	public function select(){
		$tab = $this->tableNames("sa_good");
		$sql = "SELECT goodid,gname,gmoney,pid FROM $tab WHERE pid != 0";
		$sqlt = "SELECT goodid,gname,gmoney,pid FROM $tab WHERE goodid <= 5";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$res = Yii::app()->db->createCommand($sqlt)->queryAll();
		$this->title = $res;
		$this->good = $rows;
		return true;

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
		$tabname = $this->tableName();
		$tabone = $this->tableNames("sa_good");
		$tabtwo = $this->tableNames("sa_order_good");
		$city = Yii::app()->user->city_allow();
		$sql = "SELECT a.id, a.code, a.name, a.time, a.money, a.lcu, b.goodid, a.address, a.region, c.gname, a.city, a.status,
				a.goodagio
				FROM $tabname a
				INNER JOIN $tabtwo b
				ON a.code = b.orderid
				INNER JOIN $tabone c
				ON b.goodid = c.goodid
				WHERE a.id = $index and a.city in ($city)
				";

		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			foreach ($rows as $row)
			{
				$this->id = $row['id'];
				$this->code = $row['code'];
				$this->name = $row['name'];
				$this->time = General::toDate($row['time']);
				$this->money = $row['money'];
				$this->lcu = $row['lcu'];
				$this->address = $row['address'];
				$this->city = $row['city'];
				$this->gname = $row['gname'];
				$this->region = $row['region'];
				$this->status = $row['status'];
				$this->goodid = $row['goodid'];
				$this->goodagio = $row['goodagio'];
				break;
			}
		}
		$this->select();
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
							code, name, time, money, lcu, address, city, region
						) values (
							:code, :name, :time, :money, :lcu, :address, :city, :region
						)";
				break;
			case 'edit':
				$sql = "update $tabName set
							name = :name,
							time = :time,
							money = :money,
							lcu = :lcu,
							region = :region,
							address = :address,
							city = :city
						where id = :id and city = :city
						";
				break;
		}


		$city = Yii::app()->user->city();
		$uid = Yii::app()->user->id;
		$code = $this->getcode();


		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$this->id,PDO::PARAM_INT);
		if (strpos($sql,':code')!==false)
			$command->bindParam(':code',$code,PDO::PARAM_STR);
		if (strpos($sql,':name')!==false)
			$command->bindParam(':name',$this->name,PDO::PARAM_STR);
		if (strpos($sql,':money')!==false)
			$command->bindParam(':money',$this->money,PDO::PARAM_STR);
		if (strpos($sql,':time')!==false)
			$Ctime = General::toMyDate($this->time);
			$command->bindParam(':time',$Ctime,PDO::PARAM_STR);
		if (strpos($sql,':lcu')!==false)
			$command->bindParam(':lcu',$uid,PDO::PARAM_STR);
		if (strpos($sql,':region')!==false)
			$command->bindParam(':region',$this->region,PDO::PARAM_STR);
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
