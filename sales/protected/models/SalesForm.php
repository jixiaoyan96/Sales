<?php
header("Content-type: text/html; charset=utf-8");
class SalesForm extends CFormModel
{
    public $id;  //拜访主键
    Public $customer_name;  //拜访客户名
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
        );
    }

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('customer_contact,customer_name,customer_contact_phone,customer_notes','required'),
            array('id,customer_district,customer_create_date,customer_street,customer_kinds,visit_kinds,customer_create_sellers_id','safe'),
            );
    }
    public function retrieveData($index)
    {
        $sql = "select * from sales where id=$index";
        //var_dump($sql);die;
        $rows = Yii::app()->db2->createCommand($sql)->queryAll();
        if (count($rows) > 0)
        {
            foreach ($rows as $row)
            {
                $this->id = $row['id'];
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
        if($_REQUEST['QuizForm']['quiz_exams_id']==1){  //1=>forever 0=>temporary 2=>none
            $_REQUEST['QuizForm']['quiz_start_dt']="";
            $_REQUEST['QuizForm']['quiz_end_dt']="";
            $this->quiz_start_dt='';
            $this->quiz_end_dt='';
        }
        if(isset($_REQUEST['quiz_employee_id'])){
            $_REQUEST['quiz_employee_id']=implode(',',$_REQUEST['quiz_employee_id']);
        }
        else{
            $_REQUEST['quiz_employee_id']='';
        }
        if(isset($_REQUEST['quiz_exams_id'])){
            $_REQUEST['QuizForm']['quiz_exams_id']=$_REQUEST['quiz_exams_id'];
        }
        else{
            $_REQUEST['QuizForm']['quiz_exams_id']=0;
        }
        //$this->count_questions=$_REQUEST['count_questions'];
        $this->quiz_exams_id=$_REQUEST['QuizForm']['quiz_exams_id'];
        //$_REQUEST['QuizForm']['quiz_exams_id']=$_REQUEST['quiz_exams_id'];
        $_REQUEST['QuizForm']['quiz_employee_id']=$_REQUEST['quiz_employee_id'];
        $this->quiz_employee_id=$_REQUEST['QuizForm']['quiz_employee_id'];
        $tableFuss=Yii::app()->params['jsonTableName'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from blog$tableFuss.sales where id = :id";
                break;
            case 'new':
                $sql = "insert into blog$tableFuss.sales(
						quiz_date, quiz_name,city_privileges,quiz_correct_rate,quiz_exams_id,quiz_exams_count,quiz_employee_id,quiz_start_dt,quiz_end_dt) values (
						:quiz_date, :quiz_name,:city_privileges,:quiz_correct_rate,:quiz_exams_id,:quiz_exams_count,:quiz_employee_id,:quiz_start_dt,:quiz_end_dt)";
                break;
            case 'edit':
                $sql = "update blog$tableFuss.sales set
					quiz_date = :quiz_date,
					quiz_name = :quiz_name,
					quiz_exams_count=:quiz_exams_count,
					quiz_employee_id=:quiz_employee_id,
					quiz_exams_id=:quiz_exams_id,
					quiz_correct_rate=:quiz_correct_rate,
					city_privileges=:city_privileges,
					quiz_start_dt=:quiz_start_dt,
					quiz_end_dt=:quiz_end_dt
					where id = :id";
                break;
        }
        $uid = Yii::app()->user->id;
        $city = Yii::app()->user->city();
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':quiz_date')!==false)
            $command->bindParam(':quiz_date',$this->quiz_date,PDO::PARAM_STR);
        if (strpos($sql,':quiz_name')!==false)
            $command->bindParam(':quiz_name',$this->quiz_name,PDO::PARAM_STR);


        if (strpos($sql,':quiz_start_dt')!==false) {
            $quizDate = General::toMyDate($this->quiz_start_dt);
            $command->bindParam(':quiz_start_dt',$quizDate,PDO::PARAM_STR);
        }
        if (strpos($sql,':quiz_end_dt')!==false) {
            $quizDateS = General::toMyDate($this->quiz_end_dt);
            $command->bindParam(':quiz_end_dt',$quizDateS,PDO::PARAM_STR);
        }

        if (strpos($sql,':city_privileges')!==false)
            $command->bindParam(':city_privileges',$city,PDO::PARAM_STR);
        if (strpos($sql,':quiz_exams_count')!==false)
            $command->bindParam(':quiz_exams_count',$this->quiz_exams_count,PDO::PARAM_INT);
        if (strpos($sql,':quiz_employee_id')!==false)
            $command->bindParam(':quiz_employee_id',$this->quiz_employee_id,PDO::PARAM_STR );
        if (strpos($sql,':quiz_exams_id')!==false)
            $command->bindParam(':quiz_exams_id',$this->quiz_exams_id,PDO::PARAM_STR);
        if (strpos($sql,':quiz_correct_rate')!==false)
            $command->bindParam(':quiz_correct_rate',$this->quiz_correct_rate,PDO::PARAM_STR);

            $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
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
