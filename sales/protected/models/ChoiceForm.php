<?php

class ChoiceForm extends CFormModel
{
	public $id;
	public $name;
	public $typeid;
	public $pid;
	public $service = array();
	public function rules()
	{
		return array(
				array('id,name,typeid,pid','safe'),
				array('name','required'),
		);
	}

	public function tableName($table){
		return  "$table";
	}

	public function attributeLabels()
	{
		return array(
				'id'=>Yii::t('choice','ID'),
				'name'=>Yii::t('choice','Type Name'),
				'typeid'=>Yii::t('choice','Type ID'),
				'pid'=>Yii::t('choice','Aim'),
		);
	}


	public function retrieveData($index)
	{
		$tabname = $this->tableName("sa_type");
		$sql = "SELECT *
				FROM $tabname
				WHERE  id = $index";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			foreach ($rows as $row)
			{
				$this->id = $row['id'];
				$this->name = $row['name'];
				$this->typeid = $row['typeid'];
				$this->pid = $row['pid'];
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
			$this->savetypes($connection);
			$transaction->commit();
		}
		catch(Exception $e) {
			$transaction->rollback();
			throw new CHttpException(404,'Cannot update.');
		}
	}

	protected function savetypes(&$connection)
	{
		$tabName = $this->tableName("sa_type");
		$sql = '';
		switch ($this->scenario) {
			case 'delete':
				$sql = "delete from $tabName where id = :id";
				break;
			case 'new':
				$sql = "insert into $tabName(
					    name,typeid,pid
				  )values(
						:name,:typeid,:pid
				  )";
				break;
			case 'edit':
				$sql = "update $tabName set
							name = :name
							where id = :id";
				break;
		}
		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$this->id,PDO::PARAM_INT);
		if (strpos($sql,':name')!==false)
			$command->bindParam(':name',$this->name,PDO::PARAM_STR);
		if (strpos($sql,':typeid')!==false)
			$command->bindParam(':typeid',$this->typeid,PDO::PARAM_INT);
		if (strpos($sql,':pid')!==false)
			$command->bindParam(':pid',$this->pid,PDO::PARAM_INT);
		$command->execute();
		if ($this->scenario=='new')
			$this->id = Yii::app()->db->getLastInsertID();
		return true;
	}




}
