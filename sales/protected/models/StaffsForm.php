<?php

class FiveForm extends CFormModel
{
	public $id;
	public $cid;
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
	public $url; //文件地址
	public $uid; //文件地址
	public $file; //文件上传
	public $service = array();

	public function rules()
	{
		return array(
				array('id,uname,ucod,ujob,state,s_state,mrscore,drscore,d_tm,url,uid,file','safe'),
				array('uname','required'),
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
				'ujob'=>Yii::t('five','User Job'),
				'entrytime'=>Yii::t('five','Entry Time'),
				'd_tm'=>Yii::t('five','To Update Time'),
				's_state'=>Yii::t('five','This State'),
				'mrscore'=>Yii::t('five','General manager score'),
				'drscore'=>Yii::t('five','Director scoring'),
				'upf'=>Yii::t('five','Update File'),
		);
	}

	public function retrieveData($index)
	{
		$One = $this->tableName("sa_five");
		$Tow = $this->tableName("sa_five_news");
		$city = Yii::app()->user->city_allow();
		$sql = "SELECT a.id, a.uname,a.ucod,a.ujob,a.city,b.*, b.state as s_state, b.id as cid
				FROM  $One a
				INNER JOIN $Tow b
				ON b.uid = a.id
				WHERE  b.id = $index and a.city in ($city)";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			foreach ($rows as $row)
			{
				$this->id = $row['id'];
				$this->cid = $row['cid'];
				$this->url = $row['url'];
				$this->uname = $row['uname'];
				$this->ucod = $row['ucod'];
				$this->ujob = $row['ujob'];
				$this->d_tm = General::toDate($row['uptime']);
				$this->s_state = $row['s_state'];
				$this->city = $row['city'];
				$this->uid = $row['uid'];
				$this->mrscore = $row['mrscore'];
				$this->drscore = $row['drscore'];
				break;
			}
		}
		return true;
	}

	public function select(){
		$id = Yii::app()->user->id;
		$sql = "select * from sa_five WHERE uname = '$id'";
		$rows = Yii::app()->db->createCommand($sql)->queryall();
		foreach($rows as $k=>$v){
			$this->uname = $v['uname'];
			$this->ucod = $v['ucod'];
			$this->ujob = $v['ujob'];
			$this->uid = $v['id'];
		}
		return true;
	}


	public function saveData()
	{
		if($this->scenario !='delete'){
			$this->File();
		}
		$connection = Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try {
			$this->savefive($connection);
			$transaction->commit();
		}
		catch(Exception $e) {
			$transaction->rollback();
			throw new CHttpException(404,'Cannot update.');
		}
	}

	protected function savefive(&$connection)
	{
		$tabName = $this->tableName("sa_five_news");
		$sql = '';
		switch ($this->scenario) {
			case 'delete':
				$sql = "delete from $tabName where id = id";
				break;
			case 'new':
				$sql = "insert into $tabName(
					    uid, url, state, mrscore, drscore, luu, uptime
				  )values (
				  		:uid, :url, :state, :mrscore, :drscore, :luu, :uptime
				  )";
				break;
			case 'edit':
				$sql = "update $tabName set
							uid = :uid,
							url = :url,
							state = :state,
							mrscore = :mrscore,
							drscore = :drscore,
							luu = :luu
						where id = :id
						";
				break;
		}
		$luu = Yii::app()->user->id;
		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$this->id,PDO::PARAM_INT);
		if (strpos($sql,':uid')!==false)
			$command->bindParam(':uid',$this->uid,PDO::PARAM_INT);
		if (strpos($sql,':url')!==false)
			$command->bindParam(':url',$this->url,PDO::PARAM_STR);
		if (strpos($sql,':state')!==false)
			$command->bindParam(':state',$this->s_state,PDO::PARAM_INT);
		if (strpos($sql,':mrscore')!==false)
			$command->bindParam(':mrscore',$this->mrscore,PDO::PARAM_INT);
		if (strpos($sql,':drscore')!==false)
			$command->bindParam(':drscore',$this->drscore,PDO::PARAM_INT);
		if (strpos($sql,':luu')!==false)
			$command->bindParam(':luu',$luu,PDO::PARAM_STR);
		if($this->scenario == 'new'){
			if (strpos($sql,':uptime')!==false)
				$tIme = General::toMyDate($this->d_tm);
			$command->bindParam(':uptime',$tIme,PDO::PARAM_INT);
		}
		$command->execute();
		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}

	public function File(){
		$attach = CUploadedFile::getInstanceByName('FiveForm[file]');
		$retValue = "OK";
		if($attach->size > 10*1024*1024){
			$retValue = Yii::t('five','File size more than 10MB, please reupload files less than 10MB');
		}elseif($attach->type != 'audio/mp3'){
			$retValue = Yii::t('five','File upload types do not conform, please upload legitimate Mp4 format video or MP3 audio');
		}else{
			file_get_contents($attach->tempName);
			$name = Yii::app()->basePath.'/upload/'.$attach->name;
			$attach->saveAs($name);
			$this->url = $name;
		}
		if($retValue == "OK"){
			return true;
		}else{
			return $retValue;
		}

	}


}
