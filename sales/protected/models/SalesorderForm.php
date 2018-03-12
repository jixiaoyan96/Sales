<?php
/**
 * Created by PhpStorm.
 * User: json
 * Date: 2018/1/27 0027
 * Time: 11:12
 */
 header("Content-type: text/html; charset=utf-8");
class SalesorderForm extends CFormModel{
public $id;  //拜访主键
Public $order_customer_name;  //订单客户名
Public $order_info_date;  //生成订单订货日期
Public $order_customer_rural;  //区域
Public $order_customer_street; //地址
Public $city;
Public $order_customer_total_money;    //订货总额
Public $order_customer_phone;  //联系方式

/**
 * Declares customized attribute labels.
 * If not declared here, an attribute would have a label that is
 * the same as its name with the first letter in upper case.
 */
public function attributeLabels()
{
    return array(
        'order_customer_name'=>Yii::t('quiz','order_info_seller_name'),
        'order_customer_total_money'=>Yii::t('quiz','order_info_money_total'),
        'customer_name'=>Yii::t('quiz','customer_name'),
        'order_customer_rural'=>Yii::t('quiz','order_info_rural'),
        'order_info_date'=>Yii::t('quiz','order_info_date'),
        'order_customer_street'=>Yii::t('quiz','order_info_rural_location'),
        'order_customer_phone'=>Yii::t('quiz','order_customer_phone'),
    );
}
public function rules()
{
    return array(
        array('order_customer_total_money,order_customer_rural,order_customer_street,order_customer_name','required'),
        array('id,order_customer_phone,order_info_date','safe'),
    );
}

/**
 * @param $index
 * @return
 * index是关于对customer_info的主键的修改
 */
public function retrieveData($index)
{
    $this->id=$index;

    return true;
}

public function saveData()
{
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
    return true;

}
protected function saveUser(&$connection)
{
    $sql='';
    switch ($this->scenario) {
        case 'delete':
            $sql = "delete from order_customer_info where order_customer_info_id = :id";
            break;
        case 'new':
            $sql = "insert into order_customer_info(
						order_customer_info_id,order_customer_name,order_customer_phone,order_customer_rural,order_customer_street,order_customer_seller_id,order_customer_total_money,city,order_info_date) values (
						:id,:order_customer_name,:order_customer_phone,:order_customer_rural,:order_customer_street,:order_customer_seller_id,:order_customer_total_money,:city,:order_info_date)";
            break;
        case 'edit':
            $sql = "update order_customer_info set
					order_customer_name = :order_customer_name,
					order_customer_phone=:order_customer_phone,
					order_customer_rural=:order_customer_rural,
					order_customer_street=:order_customer_street,
					order_customer_seller_id=:order_customer_seller_id,
					order_customer_total_money=:order_customer_total_money,
					city=:city,
					where order_customer_info_id = :id";
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
    if (strpos($sql,':order_customer_seller_id')!==false)
        $command->bindParam(':order_customer_seller_id',$user_sellers_id,PDO::PARAM_STR);
    if (strpos($sql,':order_customer_name')!==false)
        $command->bindParam(':order_customer_name',$this->order_customer_name,PDO::PARAM_STR);
    if (strpos($sql,':order_customer_phone')!==false)
        $command->bindParam(':order_customer_phone',$this->order_customer_phone,PDO::PARAM_STR);
    if (strpos($sql,':order_customer_rural')!==false)
        $command->bindParam(':order_customer_rural',$this->order_customer_rural,PDO::PARAM_STR);
    if (strpos($sql,':order_customer_street')!==false)
        $command->bindParam(':order_customer_street',$this->order_customer_street,PDO::PARAM_STR);
    if (strpos($sql,':order_customer_total_money')!==false)
        $command->bindParam(':order_customer_total_money',$this->order_customer_total_money,PDO::PARAM_STR);
    if (strpos($sql,':order_info_date')!==false) {
        $order_info_date = General::toMyDate($this->order_info_date);
        $command->bindParam(':order_info_date',$order_info_date,PDO::PARAM_STR);}
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