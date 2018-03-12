<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/14 0014
 * Time: 11:05
 */
header("Content-type: text/html; charset=utf-8");
class VideoSellersList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'sellers_name' => Yii::t('quiz', 'sellers_name'),
            'user_id' => Yii::t('quiz', 'user_id'),
        );
    }

    public function retrieveDataByPage($pageNum = 1)
    {
        $name=Yii::app()->user->name;
        $user_sellers_id='';
            $sql1 = "select * from sellers_user_bind_v ";
            $sql2 = "select count(id) from sellers_user_bind_v";
        $clause = "";
        //searchField =>字段名   searchValue =>字段值  日期  名字 描述
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $value = str_replace("'", "\'", $this->searchValue);
            switch ($this->searchField) {
                case 'sellers_name':
                    $clause .= General::getSqlConditionClause('sellers_name', $value);
                    break;
                case 'user_id':
                    $clause .= General::getSqlConditionClause('user_id', $value);
                    break;
                    break;
            }
        }
        $order = "";
        if (!empty($this->orderField)) {
            $order .= " order by " . $this->orderField . " ";
            if ($this->orderType == 'D') $order .= "desc ";
        }

        $sql = $sql2 . $clause;
        $this->totalRow = Yii::app()->db2->createCommand($sql)->queryScalar();

        $sql = $sql1 . $clause . $order;
        $sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
        $records = Yii::app()->db2->createCommand($sql)->queryAll();

        // $list = array();
        $this->attr = array();
        if (count($records) > 0) {
            // $startrow = ($this->noOfItem != 0) ? ($this->pageNum - 1) * $this->noOfItem : 0;
            // $itemcnt = 0;
            foreach ($records as $k => $record) {
                //  if ($k >= $startrow && ($itemcnt <= $this->noOfItem || $this->noOfItem == 0)) {
                $this->attr[] = array(
                    'id' => $record['sellers_id'],
                    'sellers_name' => $record['sellers_name'],
                    'user_id' => $record['user_id'],
                );
                //  $itemcnt++;
//				}
                //   }
            }
            $session = Yii::app()->session;
            $session['criteria_c01'] = $this->getCriteria();
            return true;
        }

    }
}
?>