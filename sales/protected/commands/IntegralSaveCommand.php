<?php
class IntegralSaveCommand extends CConsoleCommand
{
    public function run($args)
    {
        $date = empty($args) ? date("Y-m-d") : $args[0];
        $month = date("m", strtotime($date));
        $year = date("Y",strtotime($date));
        $model = new IntegralForm('view');
        $sql="select * from sal_integral where year='$year' and month='$month'";
        $row = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($row as $id){
            $model->retrieveData($id['id']);
            $sql1="update sal_integral set point='".$model['cust_type_name']['point']."',all_sum='".$model['cust_type_name']['all_sum']."' where id='".$id['id']."'";
            $command=Yii::app()->db->createCommand($sql1)->execute();
        }
    }
}