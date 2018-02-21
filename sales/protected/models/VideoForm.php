<?php
header("Content-type: text/html; charset=utf-8");
class VideoForm extends CFormModel
{
    public $id;  //五部曲主键
    Public $video_info_url;  //五部曲地址
    Public $seller_notes; //销售备注
    Public $video_info_date; //五部曲日期
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
            'seller_notes'=>Yii::t('quiz','seller_notes'),
            'video_info_date'=>Yii::t('quiz','video_info_date'),
        );
    }
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('seller_notes','required'),
            array('id','safe'),
        );
    }
    /**
     * @param $index
     * @return
     * index是关于对customer_info的主键的修改
     */
    public function retrieveData($index)
    {
        $sql = "select * from video_info where video_info_id='$index'";
        //var_dump($sql);die;
        $rows = Yii::app()->db2->createCommand($sql)->queryAll();

        if (count($rows) > 0)
        {
            foreach ($rows as $row)
            {
                $this->id = $row['video_info_id'];
                $this->seller_notes = $row['seller_notes'];
                $this->video_info_url = $row['video_info_url'];

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

    }

    protected function saveUser(&$connection)
    {
        $sql='';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from video_info where video_info_id = :id";
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
