<?php
header("Content-type: text/html; charset=utf-8");
class VideoForm extends CFormModel
{
    public $id;  //五部曲主键
    Public $video_info_url;  //五部曲地址
    Public $seller_notes; //销售备注
    Public $video_info_date; //五部曲日期
    Public $video_info_manager_grades; //五部曲总经理评价
    Public $video_info_directer_grades; //五部曲总监评价
    Public $video_info_statue; //五部曲进展状态
    Public $video_info_user_position; //五部曲职位
    Public $video_info_user_name; //五部曲姓名
    Public $video_primary;
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
            'video_play'=>Yii::t('quiz','video_play'),
            'video_info_manager_grades'=>Yii::t('quiz','video_info_manager_grades'),
            'video_info_directer_grades'=>Yii::t('quiz','video_info_directer_grades'),
            'video_info_statue'=>Yii::t('quiz','video_info_statue'),
            'video_info_user_position'=>Yii::t('quiz','video_info_user_position'),
            'video_info_user_name'=>Yii::t('quiz','video_info_user_name'),
            'video not exist....'=>Yii::t('quiz','video not exist....'),
            'video_primary'=>Yii::t("quiz","video_primary"),
        );
    }
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('seller_notes,video_info_date,video_primary','required'),
            array('id,video_info_manager_grades,video_info_directer_grades,video_info_statue,video_info_user_position,video_info_user_name','safe'),
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
                $this->video_info_date=$row['video_info_date'];
                $this->video_info_manager_grades = $row['video_info_manager_grades'];
                $this->video_info_directer_grades = $row['video_info_directer_grades'];
                $this->video_info_statue = $row['video_info_statue'];
                $this->video_info_user_position = $row['video_info_user_position'];
                $this->video_info_user_name = $row['video_info_user_name'];
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
                $sql = "update video_info set
					seller_notes=:seller_notes,
                    video_info_date=:video_info_date,
                    video_info_manager_grades=:video_info_manager_grades,
                    video_info_directer_grades=:video_info_directer_grades,
                    video_info_statue=:video_info_statue,
                    video_info_user_position=:video_info_user_position,
                    video_info_user_name=:video_info_user_name
					where video_info_id = :id";
                break;
            case 'edit':
                $sql = "update video_info set
					seller_notes=:seller_notes,
                    video_info_date=:video_info_date,
                    video_info_manager_grades=:video_info_manager_grades,
                    video_info_directer_grades=:video_info_directer_grades,
                    video_info_statue=:video_info_statue,
                    video_info_user_position=:video_info_user_position,
                    video_info_user_name=:video_info_user_name
					where video_info_id = :id";
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
        if (strpos($sql,':seller_notes')!==false)
            $command->bindParam(':seller_notes',$this->seller_notes,PDO::PARAM_STR);
        if (strpos($sql,':video_info_date')!==false)
            $command->bindParam(':video_info_date',$this->video_info_date,PDO::PARAM_STR);
        if (strpos($sql,':video_info_manager_grades')!==false)
            $command->bindParam(':video_info_manager_grades',$this->video_info_manager_grades,PDO::PARAM_STR);
        if (strpos($sql,':video_info_directer_grades')!==false)
            $command->bindParam(':video_info_directer_grades',$this->video_info_directer_grades,PDO::PARAM_STR);
        if (strpos($sql,':video_info_statue')!==false)
            $command->bindParam(':video_info_statue',$this->video_info_statue,PDO::PARAM_STR);
        if (strpos($sql,':video_info_user_position')!==false)
            $command->bindParam(':video_info_user_position',$this->video_info_user_position,PDO::PARAM_STR);
        if (strpos($sql,':video_info_user_name')!==false)
            $command->bindParam(':video_info_user_name',$this->video_info_user_name,PDO::PARAM_INT);
        $command->execute();
        if($this->scenario=='new'){
            $this->id=$this->video_primary;
        }
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
