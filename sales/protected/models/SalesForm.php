<?php

class SalesForm extends CFormModel
{
	public $id;
	public $code;
	public $name;
	public $money;
	public $address;
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
	public $titid;
	public $sum;
	public $lcu; //下单名字
	public $luu;//最后改变用户名
	public $lcd;//生成时间
	public $lud;//最后改变时间
	public $detail = array(
			array('gname'=>1,
					'tgname'=>0,
					'gmoney'=>0,
					'goodagio'=>0,
					'number'=>0,
					'money'=>0,
					'total'=>0,
					'uflag'=>'N',
					'id'=>0,
			),
	);
	public $service = array();

	public function rules()
	{
		return array(
				array('id,detail,code,name,money,address,lcu,luu,lcd,lud,city,region','safe'),
				array('name','required'),
				array('code','validateCode'),
		);
	}


	public function tableName()
	{
		return 'sa_order';
	}

	public function tableNames($table){
		return "$table";
	}

	public function attributeLabels()
	{
		return array(
				'code'=>Yii::t('sales','Code'),
				'name'=>Yii::t('sales','Name'),
				'time'=>Yii::t('sales','Order Time'),
				'ltime'=>Yii::t('sales','Last Update Time'),
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
				'Use of services'=>Yii::t('sales','Use of services'),
				'Total'=>Yii::t('sales','Total'),
				'Goodagio'=>Yii::t('sales','Goodagio'),
				'Order Total'=>Yii::t('sales','Order Total'),
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
		$tab = $this->tableNames("sa_goods_v");
		$sql = "SELECT id,name FROM $tab WHERE classify_id = $id";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		return $rows;
	}

	public function getmoney($id){
		$tab = $this->tableNames("sa_goods_v");
		$sql = "SELECT price FROM $tab WHERE id = $id";
		$rows = Yii::app()->db->createCommand($sql)->query();
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
		$tab = $this->tableNames("sa_order_good");
		$tabn = $this->tableNames("sa_goods_v");
		$order = $this->code;
		$sql = "SELECT a.*, b.name as gname, b.price as gmoney
				FROM $tab a
				INNER JOIN $tabn b
				ON a.goodid = b.id
				WHERE a.orderid = '$order'";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0) {
			$this->detail = array();
			foreach ($rows as $row) {
				$temp = array();
				$temp['id'] = $row['id'];
				$temp['tgname'] = $row['goodid'];
				$temp['orderid'] = $row['orderid'];
				$temp['number'] = $row['number'];
				$temp['gmoney'] = $row['gmoney'];
				$temp['total'] = $row['ismony'];
				$temp['goodagio'] = $row['goodagio'];
				$temp['uflag'] = 'N';
				$temp['gname'] = $row['vid'];
				$this->detail[] = $temp;
			}
		}
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
		$tabone = $this->tableNames("sa_order_good");
		$tabtwo = $this->tableNames("sa_goods_v");
		$city = Yii::app()->user->city_allow();
		$sql = "SELECT a.id, a.code, a.name, a.lcd, a.money, a.lcu, b.goodid, a.address, a.region, c.name as gname, a.city, a.status
				FROM $tabname a
				INNER JOIN $tabone b
				ON a.code = b.orderid
				INNER JOIN $tabtwo c
				ON b.goodid = c.id
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
				$this->lcd = General::toDate($row['lcd']);
				$this->money = $row['money'];
				$this->lcu = $row['lcu'];
				$this->address = $row['address'];
				$this->city = $row['city'];
				$this->gname = $row['gname'];
				$this->region = $row['region'];
				$this->status = $row['status'];
				$this->goodid = $row['goodid'];
				break;
			}
		}

		$this->select();
		return true;
	}
	public function savesum($sum=0){
		$this->sum = $sum;
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
				$sql = "delete from $tabName where id = :id";
				break;
			case 'new':
				$sql = "insert into $tabName(
							code, name, lcd, money, lcu, address, city, region,luu
						) values (
							:code, :name, :lcd, :money, :lcu, :address, :city, :region, :luu
						)";
				break;
			case 'edit':
				$sql = "update $tabName set
							name = :name,
							luu = :luu,
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
		$this->code = $code;
		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$this->id,PDO::PARAM_INT);
		if (strpos($sql,':code')!==false)
			$command->bindParam(':code',$code,PDO::PARAM_STR);
		if (strpos($sql,':name')!==false)
			$command->bindParam(':name',$this->name,PDO::PARAM_STR);
		if (strpos($sql,':money')!==false)
			$command->bindParam(':money',$this->sum,PDO::PARAM_STR);
		if (strpos($sql,':lcu')!==false)
			$command->bindParam(':lcu',$uid,PDO::PARAM_STR);
		if (strpos($sql,':luu')!==false)
			$command->bindParam(':luu',$uid,PDO::PARAM_STR);
		if (strpos($sql,':region')!==false)
			$command->bindParam(':region',$this->region,PDO::PARAM_STR);
		if (strpos($sql,':address')!==false)
			$command->bindParam(':address',$this->address,PDO::PARAM_INT);
		if($this->scenario!='delete'){
			if (strpos($sql,':lcd')!==false)
				$tIme = General::toMyDate($this->lcd);
			$command->bindParam(':lcd',$tIme,PDO::PARAM_INT);
		}
		if (strpos($sql,':city')!==false)
			$command->bindParam(':city',$city,PDO::PARAM_STR);
			$command->execute();
		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}


	public function savegood($array){
		$connection = Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try {
			$this->savegoods($connection,$array);
			$transaction->commit();
		}
		catch(Exception $e) {
			$transaction->rollback();
			throw new CHttpException(404,'Cannot update.');
		}
	}

	public function savegoods($connection){
		foreach ($this->detail as $v) {
			$sql = '';
			switch ($this->scenario) {
				case 'delete':
					$sql = "delete from sa_order_good where id = :id";
					break;
				case 'new':
					if ($v['uflag']=='Y') {
						$sql = "insert into sa_order_good(
									goodid, orderid, number, ismony, vid
								) values (
									:goodid, :orderid, :number, :ismony, :vid
								)";
					}
					break;
				case 'edit':
					switch ($v['uflag']) {
						case 'D':
							$sql = "delete from sa_order_good where id = :id";
							break;
						case 'Y':
							$sql = ($v['id']==0)
									?
									"insert into sa_order_good(
									goodid, orderid, number, ismony, vid
								) values (
									:goodid, :orderid, :number, :ismony, :vid
								)
									"
									:
									"update sa_order_good set
										goodsid = :goodsid,
										number = :number,
										ismony = :ismony
										vid = :vid
									where id = :id
									";
							break;
					}
					break;
			}
			if ($sql != '') {
				$command = $connection->createCommand($sql);
				if (strpos($sql, ':id') !== false)
					$command->bindParam(':id', $v['id'], PDO::PARAM_STR);
				if (strpos($sql, ':goodid') !== false)
					$command->bindParam(':goodid', $v['tgname'], PDO::PARAM_STR);
				if (strpos($sql, ':orderid') !== false)
					$command->bindParam(':orderid', $this->code, PDO::PARAM_STR);
				if (strpos($sql, ':number') !== false)
					$command->bindParam(':number', $v['number'], PDO::PARAM_STR);
				if (strpos($sql, ':ismony') !== false)
					$command->bindParam(':ismony', $v['total'], PDO::PARAM_STR);
				if (strpos($sql, ':vid') !== false)
					$command->bindParam(':vid', $v['gname'], PDO::PARAM_INT);
				$command->execute();
			}
		}
		return true;
	}






}
