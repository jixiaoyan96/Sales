<?php
header("Content-type: text/html; charset=utf-8");
class SalesForm extends CFormModel
{
    public $id;  //拜访主键
    Public $customer_name;  //拜访客户名
    Public $customer_second_name; //拜访客户分店名
    Public $customer_help_count_date; //辅助统计日期
    public $customer_contact;  //联系人
    public $customer_contact_phone;  //联系方式
    Public $customer_create_date;  //生成拜访客户的日期
    Public $visit_kinds;   //拜访目的
    Public $customer_kinds;  //客户类型
    Public $customer_create_sellers_id; //拜访的销售员信息外键
    Public $customer_district;  //地区
    Public $customer_street;   //街道
    Public $customer_notes;    //拜访主要备注
    Public $city;
    //Public $scenario;
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'customer_name'=>Yii::t('quiz','customer_name'),
            'customer_contact'=>Yii::t('quiz','customer_contact'),
            'customer_contact_phone'=>Yii::t('quiz','customer_contact_phone'),
            'customer_create_date'=>Yii::t('quiz','customer_create_date'),
            'visit_kinds'=>Yii::t('quiz','visit_kinds'),
            'customer_kinds'=>Yii::t('quiz','customer_kinds'),
            'customer_create_sellers_id'=>Yii::t('quiz','customer_create_sellers_id'),
            'customer_district'=>Yii::t('quiz','customer_district'),
            'customer_street'=>Yii::t('quiz','customer_street'),
            'customer_notes'=>Yii::t('quiz','customer_notes'),
            'city'=>Yii::t('quiz','city'),
            'customer_second_name'=>Yii::t('quiz','customer_second_name'),
            'customer_help_count_date'=>Yii::t('quiz','customer_help_count_date'),
        );
    }
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('customer_contact,customer_name,customer_contact_phone,customer_notes','required'),
            array('id,customer_help_count_date,customer_second_name,customer_district,customer_create_date,customer_street,customer_kinds,visit_kinds,customer_create_sellers_id','safe'),
            );
    }

    /**
     * @param $index
     * @return
     * index是关于对customer_info的主键的修改
     */
    public function retrieveData($index)
    {
        $sql = "select * from customer_info where customer_id=$index";
        //var_dump($sql);die;
        $rows = Yii::app()->db2->createCommand($sql)->queryAll();

        if (count($rows) > 0)
        {
            foreach ($rows as $row)
            {
                $this->id = $row['customer_id'];
                $this->customer_name = $row['customer_name'];
                $this->customer_contact = $row['customer_contact'];
                $this->customer_contact_phone = $row['customer_contact_phone'];
                $this->customer_notes = $row['customer_notes'];
                $this->customer_district = $row['customer_district'];
                $this->customer_create_date = General::toDate($row['customer_create_date']);
                $this->customer_street = $row['customer_street'];
                $this->customer_kinds=$row['customer_kinds'];
                $this->visit_kinds=$row['visit_kinds'];
                $this->customer_create_sellers_id=$row['customer_create_sellers_id'];
                $this->customer_second_name=$row['customer_second_name'];
                $this->customer_help_count_date=$row['customer_help_count_date'];
                break;
            }
        }
        return true;
    }

    public function saveData()
    {

     /*   if($this->scenario=='new'||$this->scenario=='delete'){*/
            $connection = Yii::app()->db2;
            $transaction=$connection->beginTransaction();
            try {
                $this->saveUser($connection);
                $transaction->commit();
            }
            catch(Exception $e) {
                $transaction->rollback();
                throw new CHttpException(404,'Cannot update.');
            }
            /* }
             elseif($this->scenario=='edit'){
                 $user_sellers_id='';
                 $name=Yii::app()->user->name;
                 if(!empty($name)){
                     $sellers_set="select * from sellers_user_bind_v WHERE user_id='$name'";
                     $sellers_get=Yii::app()->db2->createCommand($sellers_set)->queryAll();
                     if(count($sellers_get)>0){
                         $user_sellers_id=$sellers_get[0]['sellers_id'];
                     }
                 }
                 $city = Yii::app()->user->city();
                 $update_sql="update customer_info set
                         customer_create_sellers_id = '$user_sellers_id',
                         visit_kinds = '$this->visit_kinds',
                         customer_kinds='$this->customer_kinds',
                         customer_notes='$this->customer_notes',
                         customer_name='$this->customer_name',
                         customer_create_date='$this->customer_create_date',
                         customer_second_name='$this->customer_second_name',
                         customer_help_count_date='$this->customer_help_count_date',
                         customer_contact='$this->customer_contact',
                         customer_contact_phone='$this->customer_contact_phone',
                         customer_district='$this->customer_district',
                         customer_street='$this->customer_street',
                         city='$city'
                         where customer_id = '$this->id'";
                 Yii::app()->db2->createCommand($update_sql)->execute();
                 return true;
             }*/
    }

    protected function saveUser(&$connection)
    {
        //SalesForm 客户名称:customer_name   拜访日期 customer_create_date  客户分店名:customer_second_name   客户辅助拜访日期:customer_help_count_date
        //客户联系人:customer_contact   客户联系方式:customer_contact_phone  客户地区:customer_district   客户街道:customer_street  客户总备注:customer_notes 城市权限:city
        //var_dump($_REQUEST['SalesForm']);
        //$this->scenario='new';

        $sql='';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from customer_info where customer_id = :id";
                break;
            case 'new':
                $sql = "insert into customer_info(
						customer_create_sellers_id,visit_kinds,customer_kinds,customer_notes,customer_name,customer_create_date,customer_second_name,customer_help_count_date,customer_contact,customer_contact_phone,customer_district,customer_street,city) values (
						:customer_create_sellers_id,:visit_kinds,:customer_kinds,:customer_notes,:customer_name,:customer_create_date,:customer_second_name,:customer_help_count_date,:customer_contact,:customer_contact_phone,:customer_district,:customer_street,:city)";
                break;
            case 'edit':
                $sql = "update customer_info set
					customer_create_sellers_id = :customer_create_sellers_id,
					visit_kinds = :visit_kinds,
					customer_kinds=:customer_kinds,
					customer_notes=:customer_notes,
					customer_name=:customer_name,
					customer_create_date=:customer_create_date,
					customer_second_name=:customer_second_name,
					customer_help_count_date=:customer_help_count_date,
					customer_contact=:customer_contact,
					customer_contact_phone=:customer_contact_phone,
					customer_district=:customer_district,
					customer_street=:customer_street,
					city=:city
					where customer_id = :id";
                break;
        }
        $uid = Yii::app()->user->id;
        $city = Yii::app()->user->city();
        $name=Yii::app()->user->name;
        $user_sellers_id='';
        if(!empty($name)){
            $sellers_set="select * from sellers_user_bind_v WHERE user_id='$name'";
            $sellers_get=Yii::app()->db2->createCommand($sellers_set)->queryAll();
            if(count($sellers_get)>0){
                $user_sellers_id=$sellers_get[0]['sellers_id'];
            }
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':customer_create_sellers_id')!==false)
            $command->bindParam(':customer_create_sellers_id',$user_sellers_id,PDO::PARAM_STR);
        if (strpos($sql,':customer_name')!==false)
            $command->bindParam(':customer_name',$this->customer_name,PDO::PARAM_STR);
        if (strpos($sql,':customer_kinds')!==false)
            $command->bindParam(':customer_kinds',$this->customer_kinds,PDO::PARAM_STR);
        if (strpos($sql,':visit_kinds')!==false)
            $command->bindParam(':visit_kinds',$this->visit_kinds,PDO::PARAM_STR);
        if (strpos($sql,':customer_second_name')!==false)
            $command->bindParam(':customer_second_name',$this->customer_second_name,PDO::PARAM_STR);
        if (strpos($sql,':customer_create_date')!==false) {
            $customer_create_date = General::toMyDate($this->customer_create_date);
            $command->bindParam(':customer_create_date',$customer_create_date,PDO::PARAM_STR);}
        if (strpos($sql,':customer_notes')!==false)
            $command->bindParam(':customer_notes',$this->customer_notes,PDO::PARAM_STR);
        if (strpos($sql,':customer_help_count_date')!==false)
            $command->bindParam(':customer_help_count_date',$this->customer_help_count_date,PDO::PARAM_STR);
        if (strpos($sql,':customer_contact')!==false)
            $command->bindParam(':customer_contact',$this->customer_contact,PDO::PARAM_INT);
        if (strpos($sql,':customer_contact_phone')!==false)
            $command->bindParam(':customer_contact_phone',$this->customer_contact_phone,PDO::PARAM_STR );
        if (strpos($sql,':customer_district')!==false)
            $command->bindParam(':customer_district',$this->customer_district,PDO::PARAM_STR);
        if (strpos($sql,':customer_street')!==false)
            $command->bindParam(':customer_street',$this->customer_street,PDO::PARAM_STR);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',$city,PDO::PARAM_STR);
            $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db2->getLastInsertID();
        return true;
    }

    public function isOccupied($index) {
        $rtn = false;
        $sql = "select a.id from swo_service a where a.cust_type=".$index." limit 1";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $rtn = true;
            break;
        }
        return $rtn;
    }
}
