<?php
/**
 * Created by PhpStorm.
 * User: json
 * Date: 2018/1/27 0027
 * Time: 11:11
 */
header("Content-type: text/html; charset=utf-8");
class SalesorderList extends CListPageModel
{

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {

        return array(
            'order_info_code_number' => Yii::t('quiz', 'order_info_code_number'),//订单编号
            'order_customer_name' => Yii::t('quiz', 'order_customer_name'),//客户名字
            'order_info_rural' => Yii::t('quiz', 'order_info_rural'),//客户区域
            'order_info_date' => Yii::t('quiz', 'order_info_date'),//订货日期
            'order_goods_code_number' => Yii::t('quiz', 'order_goods_code_number'),//订货编号
            'order_info_money_total' => Yii::t('quiz', 'order_info_money_total'),//订货总额
            'order_info_seller_name' => Yii::t('quiz', 'order_info_seller_name'),//销售员姓名
        );
    }
    public function retrieveDataByPage($pageNum = 1)
    {
        $sql1 = "select *
				from order_info
				where 1=1 ";
        $sql2 = "select count(order_info_id)
				from order_info
				where 1=1 ";
        $clause = "";

        //searchField =>字段名   searchValue =>字段值  日期  名字 描述
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'", "\'", $this->searchValue);
            switch ($this->searchField) {
                case 'quiz_date':
                    $clause .= General::getSqlConditionClause('quiz_date', $svalue);
                    break;
                case 'quiz_name':
                    $clause .= General::getSqlConditionClause('quiz_name', $svalue);
                    break;
                case 'quiz_correct_rate':
                    $clause .= General::getSqlConditionClause('quiz_correct_rate', $svalue);
                    break;
                case 'quiz_start_dt':
                    $clause .= General::getSqlConditionClause('quiz_start_dt', $svalue);
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
                    'id' => $record['order_info_id'],  //订单主键
                    'order_info_code_number' => $record['order_info_code_number'], //订单编号
                    'order_customer_name' => $record['order_customer_name'], //客户名字
                    'order_info_rural' => $record['order_info_rural'],//客户区域
                    'order_info_date' => $record['order_info_date'],//订货日期
                    'order_goods_code_number' => $record['order_goods_code_number'], //订货编号
                    'order_info_money_total' => $record['order_info_money_total'], //订货总额
                    'order_info_seller_name' => $record['order_info_seller_name'],//销售员姓名
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