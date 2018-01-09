<?php
class StaffsList extends CListPageModel
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
            'state'=>Yii::t('five','This State'),
            'ujob'=>Yii::t('five','User Job'),
            'city'=>Yii::t('five','City'),
            'toe'=>Yii::t('staffs','Time of entry'),

        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
       if(Yii::app()->user->validRWFunction('TB02')){
            $city = Yii::app()->user->city_allow();
           $tabname = $this->tableName("sales.sa_staff");
           $sql1 = "select *
				from $tabname
				where city in ($city)
			";
           $sql2 = "select count(id)
				from $tabname
				where city in ($city)
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
                       'toe'=>$record['toe'],
                       'state'=>$record['state'],
                       'city'=>$record['city'],
                   );
               }
           }
           $session = Yii::app()->session;
           $session['criteria_t01'] = $this->getCriteria();
           return true;
        }else{
            $city = Yii::app()->user->city;
            $tabname = $this->tableName("sales.sa_staff");
            $sql1 = "select *
				from $tabname
				where city = '$city'
			";
            $sql2 = "select count(id)
				from $tabname
				where city = '$city'
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
                        'toe'=>$record['toe'],
                        'state'=>$record['state'],
                        'city'=>$record['city'],
                    );
                }
            }
            $session = Yii::app()->session;
            $session['criteria_t01'] = $this->getCriteria();
            return true;
        }
    }


    public function retrieveDataByPages()
    {
        $sql = "SELECT  *  FROM sales.sa_staffs_list";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record){
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'listname'=>$record['listname'],
                    'listid'=>$record['listid'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['criteria_t01'] = $this->getCriteria();
        return true;
    }



}