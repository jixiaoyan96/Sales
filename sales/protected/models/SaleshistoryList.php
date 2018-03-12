<?php
/**
 * Created by PhpStorm.
 * User: json
 * Date: 2018/1/27 0027
 * Time: 11:11
 */
header("Content-type: text/html; charset=utf-8");
class SaleshistoryList extends CListPageModel
{

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'order_customer_name' => Yii::t('quiz', 'order_customer_name'), //客户名字
            'order_customer_phone' => Yii::t('quiz', 'order_customer_phone'), //联系方式
            'order_customer_rural'=>Yii::t('quiz','order_customer_rural'), //客户区域
            'order_customer_street'=>Yii::t('quiz','order_customer_street'), //客户街道
            'order_info_date' => Yii::t('quiz', 'order_info_date'), //订货日期
            'order_customer_total_money' => Yii::t('quiz', 'order_customer_total_money'), //订货总额
        );
    }
    public function retrieveDataByPage($pageNum = 1)
    {
        $city = Yii::app()->user->city_allow();
        $sql1 = "select *
				from order_customer_info
				where 1=1 AND city in($city)";
        $sql2 = "select count(order_customer_info_id)
				from order_customer_info
				where 1=1 AND city in($city)";
        $clause = "";
        //searchField =>字段名   searchValue =>字段值  日期  名字 描述
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'", "\'", $this->searchValue);
            switch ($this->searchField) {
                case 'order_customer_name':
                    $clause .= General::getSqlConditionClause('order_customer_name', $svalue);
                    break;
                case 'order_customer_rural':
                    $clause .= General::getSqlConditionClause('order_customer_rural', $svalue);
                    break;
                case 'order_customer_street':
                    $clause .= General::getSqlConditionClause('order_customer_street', $svalue);
                    break;
                case 'order_customer_total_money':
                    $clause .= General::getSqlConditionClause('order_customer_total_money', $svalue);
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
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k => $record) {
                $this->attr[] = array(
                    'id' => $record['order_customer_info_id'],  //订单主键
                    'order_customer_name' => $record['order_customer_name'], //客户名字
                    'order_customer_rural' => $record['order_customer_rural'],//客户区域
                    'order_customer_street' => $record['order_customer_street'],//客户区域
                    'order_info_date' => $record['order_info_date'],//订货日期
                    'order_customer_total_money' => $record['order_customer_total_money'], //订货总额
                );
            }
            $session = Yii::app()->session;
            $session['criteria_c01'] = $this->getCriteria();
            return true;
        }
    }
}