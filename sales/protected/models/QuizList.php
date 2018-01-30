<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/14 0014
 * Time: 11:05
 */
header("Content-type: text/html; charset=utf-8");
class QuizList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'customer_name' => Yii::t('quiz', 'customer_name'),
            'customer_contact' => Yii::t('quiz', 'customer_contact'),
            'customer_contact_phone' => Yii::t('quiz', 'customer_contact_phone'),
            'customer_create_date' => Yii::t('quiz', 'customer_create_date'),
            'visit_definition_name' => Yii::t('quiz', 'visit_definition_name'),
            'customer_kinds_name' => Yii::t('quiz', 'customer_kinds_name'),
        );
    }

    public function retrieveDataByPage($pageNum = 1)
    {
        $name=Yii::app()->user->name;
        $user_sellers_id='';
        if(!empty($name)){
            $sellers_set="select * from sellers_user_bind_v WHERE user_id='$name'";
            $sellers_get=Yii::app()->db2->createCommand($sellers_set)->queryAll();
            if(count($sellers_get)>0){
                $user_sellers_id=$sellers_get[0]['sellers_id'];
            }
        }
        if(!empty($user_sellers_id)){
            $sql1 = "select a.customer_id,a.customer_name,a.customer_contact,a.customer_contact_phone,a.visit_kinds,a.customer_kinds,a.customer_create_date,b.visit_definition_name,c.customer_kinds_name
from sales.customer_info as a LEFT JOIN sales.visit_definition as b ON a.visit_kinds=b.visit_definition_id
LEFT JOIN sales.customer_kinds as c ON a.customer_kinds=c.customer_kinds_id
WHERE a.customer_create_sellers_id =$user_sellers_id ";
            $sql2 = "select count(a.customer_id)
from sales.customer_info as a LEFT JOIN sales.visit_definition as b ON a.visit_kinds=b.visit_definition_id
LEFT JOIN sales.customer_kinds as c ON a.customer_kinds=c.customer_kinds_id
WHERE a.customer_create_sellers_id =$user_sellers_id ";
        }
        else{
            $sql1 = "select a.cutomer_name,a.customer_contact
				from customer_info
				where 1=1 ";
            $sql2 = "select count(id)
				from customer_info
				where 1=1 ";
        }
        $clause = "";
        //searchField =>字段名   searchValue =>字段值  日期  名字 描述
        if (!empty($this->searchField) && !empty($this->searchValue)) {

            $svalue = str_replace("'", "\'", $this->searchValue);

            switch ($this->searchField) {
                case 'customer_name':
                    $clause .= General::getSqlConditionClause('customer_name', $svalue);
                    break;
                case 'customer_contact':
                    $clause .= General::getSqlConditionClause('customer_contact', $svalue);
                    break;
                case 'visit_definition_name':
                    $clause .= General::getSqlConditionClause('visit_definition_name', $svalue);
                    break;
                case 'customer_kinds_name':
                    $clause .= General::getSqlConditionClause('customer_kinds_name', $svalue);
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
                        'id' => $record['customer_id'],
                        'customer_name' => $record['customer_name'],
                        'customer_contact' => $record['customer_contact'],
                        'customer_contact_phone' => $record['customer_contact_phone'],
                        'customer_create_date' => $record['customer_create_date'],
                        'visit_definition_name' => $record['visit_definition_name'],
                        'customer_kinds_name' => $record['customer_kinds_name'],
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