<?php
class ChoiceList extends CListPageModel
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
            'id'=>Yii::t('choice','ID'),
            'name'=>Yii::t('choice','Name'),
            'typeid'=>Yii::t('choice','Type ID'),
            'pid'=>Yii::t('choice','Aim'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $tabname = $this->tableName("sa_type");
        $sql = "select *
				from $tabname
				where typeid = 1
			";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record) {
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'name'=>$record['name'],
                    'typeid'=>$record['typeid'],
                    'pid'=>$record['pid'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['criteria_t01'] = $this->getCriteria();
        return true;
    }


    public function retrieveDataByPages($pageNum=1,$id)
    {
        $tabname = $this->tableName("sa_type");
        $sql = "select *
				from $tabname
				where pid = $id
			";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record) {
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'name'=>$record['name'],
                    'typeid'=>$record['typeid'],
                    'pid'=>$record['pid'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['criteria_t01'] = $this->getCriteria();
        return true;
    }

}