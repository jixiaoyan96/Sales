<?php
class RankCommand extends CConsoleCommand
{
    public function run($args)
    {
        $date = empty($args) ? date("Y-m-d") : $args[0];
        $month = date("Y-m-d", strtotime($date));
        $suffix = Yii::app()->params['envSuffix'];
        $sql_season="select season from sales$suffix.sal_season order by id desc";
        $season_s = Yii::app()->db->createCommand($sql_season)->queryScalar();
        $sql="select a.code
            from security$suffix.sec_city a left outer join security$suffix.sec_city b on a.code=b.region 
            where b.code is null 
            order by a.code";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $city = $row['code'];
                    //查找所有参与的销售
                    $sql1 = "select a.*			
				from security$suffix.sec_user a  
				left outer join security$suffix.sec_city b on a.city=b.code 			  
				left outer join security$suffix.sec_user_access c on a.username=c.username 	
				left outer join hr$suffix.hr_binding d  on a.username=d.user_id
				left outer join hr$suffix.hr_employee e  on d.employee_id=e.id		
                left outer join hr$suffix.hr_dept f  on e.position=f.id 	
				where a.city='$city'  and c.system_id='sal'  and c.a_read_write like '%HK01%'  and a.status='A'  and  (f.manager_type ='1' or f.manager_type ='2')
			";
                    $rows = Yii::app()->db->createCommand($sql1)->queryAll();
                    foreach ($rows as $records){
                      //  $city = $records['city'];
                        //判断是否为新入职的，空是新的、、最新赛季分数
                        $span="select * from sales$suffix.sal_rank where city='$city' and  username='".$records['username']."' order by id desc";
                        $rankfraction = Yii::app()->db->createCommand($span)->queryRow();
                        //入职时间積分
                        $sql_entry_time="select a.* from hr$suffix.hr_employee a left outer join hr$suffix.hr_binding b on a.id=b.employee_id where b.user_id='".$records['username']."'";
                        $entry_time = Yii::app()->db->createCommand($sql_entry_time)->queryRow();
                        $time1 = date("Y-m-d", strtotime("$date -1 month"));
                        $time2 = date("Y-m-d", strtotime("$date -3 month"));
                        if($time2>=$entry_time['entry_time']){
                            $ruzhi=2500;
                        }elseif($time2<$entry_time['entry_time']&&$entry_time['entry_time']<=$time1){
                            $ruzhi=1000;
                        }else{
                            $ruzhi=0;
                        }
                        //老员工五部曲分数
                        $sql_five="select * from sales$suffix.sal_fivestep where username='".$records['username']."' and rec_dt<=$month ";
                        $retern= Yii::app()->db->createCommand($sql_five)->queryAll();
                        if(empty($retern)){
                            $five=0;
                        }else{
                            $five=4500;
                        }
                        $rank=0;
                       if(empty($rankfraction)){
                           $rank=$rank+$ruzhi+$five;
                           //第几赛季，具体时间，用户，城市，初始分数或上赛季分数，当前赛季分数
                           $sql = "insert into sales$suffix.sal_rank(season, month, username, city,rank,new_rank) 
				                  values('$season_s', '$month', '".$records['username']."', '$city','$rank','1')
			                        ";
                           $command=Yii::app()->db->createCommand($sql)->execute();
                       }else{
                           $sql="select * from sales$suffix.sal_rank where season='".$rankfraction['season']."' and username='".$records['username']."' and city='$city'";
                           $season = Yii::app()->db->createCommand($sql)->queryAll();
                           if(count($season)==1){
                               $sql2 = "insert into sales$suffix.sal_rank(season, month, username, city,rank,new_rank) 
				                  values('$season_s', '$month', '".$records['username']."', '$city','".$rankfraction['new_rank']."','2')
			                        ";
                               $command=Yii::app()->db->createCommand($sql2)->execute();
                           }else{
                               $sql1="select * from sales$suffix.sal_level where start_fraction<='".$rankfraction['new_rank']."' and end_fraction>='".$rankfraction['new_rank']."'";
                               $record=Yii::app()->db->createCommand($sql1)->queryRow();
                               if(empty($record)){
                                   $record['new_fraction']=0;
                               }elseif($rankfraction['new_rank']<20000){
                                   $record['new_fraction']=$rankfraction['new_rank'];
                               }
                               $sql2 = "insert into sales$suffix.sal_rank(season, month, username, city,rank,new_rank) 
				                  values('$season_s', '$month', '".$records['username']."', '$city','".$record['new_fraction']."','3')
			                        ";
                               $command=Yii::app()->db->createCommand($sql2)->execute();
                           }
                       }
                    }
                }
            }
    }
}