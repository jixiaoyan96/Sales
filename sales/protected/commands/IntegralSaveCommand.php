<?php
class IntegralSaveCommand extends CConsoleCommand
{
    public function run()
    {
        $month=date('m');
        $year=date('Y');
        $model = new IntegralForm('view');
        $sql="select * from sal_integral where year='$year' and month='$month'";
        $row = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($row as $id){
            $model->retrieveData($id['id']);
            $sql1="update sal_integral set point='".$model['cust_type_name']['point']."' where id='".$id['id']."'";
            $command=Yii::app()->db->createCommand($sql1)->execute();
        }
    }
}