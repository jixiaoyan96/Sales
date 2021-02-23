<?php
class RanklSaveCommand extends CConsoleCommand
{
    //销售段位分数保存
    public function run($args)
    {
        $date = empty($args) ? date("Y-m-d") : $args[0];
        $start = date("Y-m-01", strtotime($date));
        $end = date("Y-m-31",strtotime($date));
        $model = new RankForm('view');
        $sql="select * from sal_rank  where month>='$start' and month<='$end'";
        $row = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($row as $id){
            $model->retrieveData($id['id']);
            $sql1="update sal_rank set new_rank='".$model['now_all']."' where id='".$id['id']."'";
            $command=Yii::app()->db->createCommand($sql1)->execute();
        }
    }
}