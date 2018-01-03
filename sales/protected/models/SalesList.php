<?php
class SalesList extends CListPageModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName($name)
    {
        return "$name";
    }

    public function attributeLabels()
    {
        return array(
            'code'=>Yii::t('sales','Code'),
            'name'=>Yii::t('sales','Name'),
            'time'=>Yii::t('sales','Time'),
            'address'=>Yii::t('sales','Address'),
            'money'=>Yii::t('sales','Money'),
            'lcu'=>Yii::t('sales','Lcu'),
            'city'=>Yii::t('sales','City'),
            'region'=>Yii::t('sales','Region'),
            'status'=>Yii::t('sales','Status'),
            'goodid'=>Yii::t('sales','Goodid'),
            'goodnumber'=>Yii::t('sales','Goodnumber'),
            'goodmoney'=>Yii::t('sales','Goodidmoney'),
            'goodagio'=>Yii::t('sales','Goodagio'),
            'gname'=>Yii::t('sales','Gname'),
            'service'=>Yii::t('sales','Service content'),
            'Use of goods'=>Yii::t('sales','Use of goods'),
            'Goods Number'=>Yii::t('sales','Goods Number'),
            'Goods Price'=>Yii::t('sales','Goods Price'),
            'Use of services'=>Yii::t('sales','Use of services'),
            'Total'=>Yii::t('sales','Total'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $suffix = Yii::app()->params['envSuffix'];
        $city = Yii::app()->user->city_allow();
        $tabname = $this->tableName("sa_order");
        $sql1 = "select a.id, a.code, a.name, a.time, a.money, a.lcu, a.address, a.region, a.city as city_name
				from $tabname a, security$suffix.sec_city b
				where a.city=b.code and a.city in ($city)
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

        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record) {
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'code'=>$record['code'],
                    'name'=>$record['name'],
                    'time'=>$record['time'],
                    'money'=>$record['money'],
                    'lcu'=>$record['lcu'],
                    'address'=>$record['address'],
                    'city'=>$record['city_name'],
                    'region'=>$record['region'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['criteria_t01'] = $this->getCriteria();
        return true;
    }


}