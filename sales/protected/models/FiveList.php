<?php
class FiveList extends CListPageModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName($table)
    {
        return 'sa' . Yii::app()->params['myTabname'] . ".$table";
    }

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('visit','ID'),
            'uname'=>Yii::t('visit','Visit Name'),
            'type'=>Yii::t('visit','Type'),
            'aim'=>Yii::t('visit','Aim'),
            'datatime'=>Yii::t('visit','Time'),
            'area'=>Yii::t('visit','Area'),
            'road'=>Yii::t('visit','Road'),
            'crtype'=>Yii::t('visit','Customer type'),
            'crname'=>Yii::t('visit','Customer name'),
            'sonname'=>Yii::t('visit','Name of branch store'),
            'charge'=>Yii::t('visit','Charge'),
            'phone'=>Yii::t('visit','Phone'),
            'remarks'=>Yii::t('visit','Remarks'),
            'city'=>Yii::t('visit','City'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $uid = Yii::app()->user->id;
        $suffix = Yii::app()->params['envSuffix'];
        $city = Yii::app()->user->city_allow();
        $tabname = $this->tableName("sa_visit");
        $sql1 = "select a.id, a.uname, a.type, a.aim, a.datatime, a.area, a.road, a.crtype, a.crname, a.sonname,
                 a.charge, a.phone, a.remarks, a.city as city_name
				from $tabname a, security$suffix.sec_city b
				where a.city=b.code and  a.uname = '$uid'  and a.city in ($city)
			";
        $sql2 = "select count(id)
				from $tabname a, security$suffix.sec_city b
				where a.city=b.code and a.city in ($city)
			";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'name':
                    $clause .= General::getSqlConditionClause("a.name",$svalue);
                    break;
                case 'code':
                    $clause .= General::getSqlConditionClause("a.code",$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            $order .= " order by ".$this->orderField." ";
            if ($this->orderType=='D') $order .= "desc ";
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
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'uname'=>$record['uname'],
                    'type'=>$record['type'],
                    'aim'=>$record['aim'],
                    'datatime'=>$record['datatime'],
                    'area'=>$record['area'],
                    'road'=>$record['road'],
                    'crtype'=>$record['crtype'],
                    'crname'=>$record['crname'],
                    'sonname'=>$record['sonname'],
                    'charge'=>$record['charge'],
                    'phone'=>$record['phone'],
                    'remarks'=>$record['remarks'],
                    'city'=>$record['city_name'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['criteria_t01'] = $this->getCriteria();
        return true;
    }


}