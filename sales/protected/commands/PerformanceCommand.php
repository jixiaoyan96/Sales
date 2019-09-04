<?php
class PerformanceCommand extends CConsoleCommand
{
    public function run()
    {
        $month=date('m');
        $year=date('Y');
        $day=date('d');
        if($day=='01'){
            $suffix = Yii::app()->params['envSuffix'];
            $sql="select a.code
				from security$suffix.sec_city a left outer join security$suffix.sec_city b on a.code=b.region 
				where b.code is null 
				order by a.code";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $city = $row['code'];
                    $uid = 'admin';
                    $sql = "insert into sales$suffix.sal_performance(city, year, month, sum, lcu, luu) 
				values('$city', '$year', '$month', '0', '$uid', '$uid')
			";
                    $command=Yii::app()->db->createCommand($sql)->execute();
                }
            }
        }

    }
}