<?php
class FiveList extends CListPageModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName($table)
    {
        return "$table";
    }

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('five','ID'),
            'uname'=>Yii::t('five','User Name'),
            'ucod'=>Yii::t('five','User Code'),
            'ujob'=>Yii::t('five','User Job'),
            'entrytime'=>Yii::t('five','Entry Time'),
            'city'=>Yii::t('five','City'),

        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $uid = Yii::app()->user->id;
        $suffix = Yii::app()->params['envSuffix'];
        $city = Yii::app()->user->city_allow();
        $tabname = $this->tableName("sa_five");
        $sql1 = "select a.id, a.ucod,a.uname, a.entrytime, a.ujob, a.city as city_name
				from $tabname a, security$suffix.sec_city b
				where a.city=b.code and  a.uname = '$uid' and a.city in ($city)
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
                    'ucod'=>$record['ucod'],
                    'ujob'=>$record['ujob'],
                    'entrytime'=>$record['entrytime'],
                    'city'=>$record['city_name'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['criteria_t01'] = $this->getCriteria();
        return true;
    }


}