<?php

class RankList extends CListPageModel
{
	public function attributeLabels()
	{
		return array(
            'year'=>Yii::t('code','Year'),
            'month'=>Yii::t('code','Month'),
            'city'=>Yii::t('sales','City'),
            'employee_name'=>Yii::t('sales','Employee_name'),
            'season'=>Yii::t('sales','Season'),
            'rank'=>Yii::t('sales','Rank'),
		);
	}

	public function searchColumns() {
		$search = array(
				'year'=>"a.year",
				'month'=>'a.month',
				'city'=>'b.name',
				'name'=>'c.employee_name',
		);
		return $search;
	}

	public function retrieveDataByPage($pageNum=1,$a)
	{
		$suffix = Yii::app()->params['envSuffix'];
        $citylist = Yii::app()->user->city_allow();
        $user = Yii::app()->user->id;
        $sql1 = "select a.* ,b.name as city_name,d.name as name
				from sal_rank	a
				left outer join security$suffix.sec_city b on a.city=b.code
				inner join  hr$suffix.hr_binding c on a.username = c.user_id		  
				inner join  hr$suffix.hr_employee d on c.employee_id = d.id  
					where a.city ='".$a['city']."' and a.season ='".$a['season']."'";
        $sql2 = "select count(a.id)
				from sal_rank	a
				left outer join security$suffix.sec_city b on a.city=b.code	
				inner join hr$suffix.hr_binding c on a.username = c.user_id	  
				inner join  hr$suffix.hr_employee d on c.employee_id = d.id  
			 where a.city ='".$a['city']."' and a.season ='".$a['season']."'";
		$clause = "";
		if (!empty($this->searchField) && (!empty($this->searchValue) || $this->isAdvancedSearch())) {
			if ($this->isAdvancedSearch()) {
				$clause = $this->buildSQLCriteria();
			} else {
				$svalue = str_replace("'","\'",$this->searchValue);
				$columns = $this->searchColumns();
				$clause .= General::getSqlConditionClause($columns[$this->searchField],$svalue);
			}
		}

		$order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by  b.name ";
                    break;
                case 'name':
                    $order .= " order by d.name ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        } else {
            $order = " order by id desc";
        }

		$sql = $sql2.$clause;
		$this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

		$sql = $sql1.$clause.$order;
		$sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
		$records = Yii::app()->db->createCommand($sql)->queryAll();

		$list = array();
		$this->attr = array();
		if (count($records) > 0) {
			foreach ($records as $k=>$record) {
                $sql_rank_name="select * from sal_level where start_fraction <='".$record['new_rank']."' and end_fraction >='".$record['new_rank']."'";
                $rank_name= Yii::app()->db->createCommand($sql_rank_name)->queryRow();
				$this->attr[] = array(
					'id'=>$record['id'],
					'month'=>date("m", strtotime($record['month'])),
					'city'=>$record['city_name'],
                    'employee_name'=>$record['name'],
                    'season'=>$record['season'],
                    'new_rank'=>$rank_name['level'],

                );
			}
		}
		$session = Yii::app()->session;
		$session[$this->criteriaName()] = $this->getCriteria();
		return true;
	}

}
