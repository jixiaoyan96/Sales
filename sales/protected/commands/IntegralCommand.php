<?php
class IntegralCommand extends CConsoleCommand
{
    public function run($args)
    {
        $date = empty($args) ? date("Y-m-d") : $args[0];
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));
        $suffix = Yii::app()->params['envSuffix'];
        $sql="select a.code
				from security$suffix.sec_city a left outer join security$suffix.sec_city b on a.code=b.region 
				where b.code is null 
				order by a.code";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $city = $row['code'];
                $sql1="select b.user_id from hr$suffix.hr_employee a
                      inner join hr$suffix.hr_binding b on a.id=b.employee_id 
                      inner join hr$suffix.hr_dept c on a.position=c.id 
                      where  a.city='$city'  and (c.manager_type ='1' or c.manager_type ='2') and a.staff_status='0'
";
                $row = Yii::app()->db->createCommand($sql1)->queryAll();
                $sql2="select username from sales$suffix.sal_integral where year='$year' and month='$month' and  city='$city'";
                $arr = Yii::app()->db->createCommand($sql2)->queryAll();
                $color = array_udiff($row,$arr,create_function(
                        '$a,$b','return strcmp(implode("",$a),implode("",$b));')
                );
                if(!empty($color)){
                    foreach ($color as $sale){
                        $sql = "insert into sales$suffix.sal_integral(city, year, month, username) 
				values('$city', '$year', '$month', '".$sale['user_id']."')
			";
                        $command=Yii::app()->db->createCommand($sql)->execute();
                    }
                }

            }
        }
    }
}