<?php

class FiveForm extends CFormModel
{
	public $id;
	public $uname; //销售人
	public $ucod; //销售人编号
	public $ujob; //销售人岗位
	public $state; //已完成的阶段
	public $entrytime; //入职时间
	public $s_state; //当前阶段
	public $mrscore; //总经理评分
	public $drscore; //总监评分
	public $city; //总监评分
	public $d_tm; //生成时间
	public $service = array();

	public function rules()
	{
		return array(
				array('id,uname,ucod,ujob,state,s_state,mrscore,drscore','safe'),
				array('type,aim,datatime,area,road,crtype,crname,charge,phone','required'),
		);
	}

	public function tableName($table){
		return "$table";
	}

	public function attributeLabels()
	{
		return array(
				'id'=>Yii::t('five','ID'),
				'uname'=>Yii::t('five','User Name'),
				'ucod'=>Yii::t('five','User Code'),
				'ujob'=>Yii::t('five','Operating Post'),
				'state'=>Yii::t('five','Complete State'),
				'entrytime'=>Yii::t('five','Entry Time'),
				's_state'=>Yii::t('five','This State'),
				'mrscore'=>Yii::t('five','General manager score'),
				'drscore'=>Yii::t('five','Director scoring'),
		);
	}


	public function retrieveData($index)
	{
		$One = $this->tableName("sa_five");
		$Tow = $this->tableName("sa_five_news");
		$city = Yii::app()->user->city_allow();
		$sql = "SELECT a.id, a.uname,a.ucod,a.ujob,b.state,a.city,b.mrscore,b.drscore,b.uptime
				FROM  $One a
				INNER JOIN $Tow b
				ON b.uid = a.id
				WHERE  a.id = $index and a.city in ($city)";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			foreach ($rows as $row)
			{
				$this->id = $row['id'];
				$this->uname = $row['uname'];
				$this->ucod = $row['ucod'];
				$this->ujob = $row['ujob'];
				$this->d_tm = General::toDate($row['uptime']);
				$this->s_state = $row['state'];
				$this->city = $row['city'];
				$this->mrscore = $row['mrscore'];
				$this->drscore = $row['drscore'];
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
					    uname, type, aim, area, road, crtype, crname, sonname, charge, phone, remarks, city ,datatime
				  )values (
				  		:uname, :type, :aim, :area, :road, :crtype, :crname, :sonname, :charge, :phone, :remarks, :city, :datatime
				  )";
				break;
			case 'edit':
				$sql = "update $tabName set
							uname = :uname,
							type = :type,
							aim = :aim,
							area = :area,
							road = :road,
							datatime = :datatime,
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
		if($this->scenario!='delete'){
			if (strpos($sql,':datatime')!==false)
				$tIme = General::toMyDate($this->datatime);
			$command->bindParam(':datatime',$tIme,PDO::PARAM_INT);
		}
		$command->execute();
		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}




}
