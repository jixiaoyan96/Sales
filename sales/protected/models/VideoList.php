<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/14 0014
 * Time: 11:05
 */
header("Content-type: text/html; charset=utf-8");
class VideoList extends CListPageModel
{
    public $startDate='';
    public $endDate='';
    public $name='';
    public $step='';
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'video_info_date' => Yii::t('quiz', 'video_info_date'),
            'seller_notes' => Yii::t('quiz', 'seller_notes'),
            'video_info_url' => Yii::t('quiz', 'video_info_url'),
            'video_info_directer_grades'=>Yii::t('quiz','video_info_directer_grades'),
            'video_info_manager_grades'=>Yii::t('quiz','video_info_manager_grades'),
            'video_info_statue'=>Yii::t('quiz','video_info_statue'),
            'city_privileges'=>Yii::t('quiz','city_privileges'),
            'video_info_user_name'=>Yii::t('quiz','video_info_user_name'),
        );
    }

    public function retrieveDataByPage($pageNum = 1)
    {
        $city = Yii::app()->user->city_allow();
        $temp=isset($_REQUEST['historyId'])?$_REQUEST['historyId']:0;
        if($temp!=0){
            $sql1 = "select * from video_info WHERE seller_pid ='$temp'";
            $sql2 = "select count(video_info_id) from video_info WHERE seller_pid ='$temp' AND city_privileges in($city)";
        }else{ //查看销售员列表
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
                $sql1 = "select * from video_info WHERE seller_pid ='$user_sellers_id'";
                $sql2 = "select count(video_info_id) from video_info WHERE seller_pid ='$user_sellers_id' AND city_privileges in($city)";
            }
            else{
                $sql1 = "select *from video_info where 1=1 AND city_privileges in($city)";
                $sql2 = "select count(id)from video_info where 1=1 ";
            }
        }
        $clause = "";
        //searchField =>字段名   searchValue =>字段值  日期  名字 描述
        if (!empty($this->searchField) && !empty($this->searchValue)){
            $value = str_replace("'", "\'", $this->searchValue);
            switch ($this->searchField) {
                case 'video_info_date':
                    $clause .= General::getSqlConditionClause('video_info_date', $value);
                    break;
                case 'sellers_notes':
                    $clause .= General::getSqlConditionClause('sellers_notes', $value);
                    break;
            }
        }
        $order = " order by video_info_id desc";
       /*if (!empty($this->orderField)){
            $order .= " order by " . $this->orderField . " ";
            if ($this->orderType == 'D') $order .= "desc ";
        }*/
        if(!empty($_REQUEST['startDate'])){
            $startDate=$_REQUEST['startDate'];
            $clause.="AND video_info_date >=date('$startDate')";
            $this->startDate=$startDate;
        }
        if(!empty($_REQUEST['endDate'])){
            $endDate=$_REQUEST['endDate'];
            $this->endDate=$endDate;
            $clause.="AND video_info_date <=date('$endDate')";
        }
        if(!empty($_REQUEST['employeeName'])){
            $employeeName=$_REQUEST['employeeName'];
            $this->name=$employeeName;
            $clause.="AND video_info_user_name ='$employeeName'";
        }
        if(!empty($_REQUEST['video_step'])){
            $video_step=$_REQUEST['video_step'];
            $this->step=$video_step;
            $clause.="AND video_info_statue ='$video_step'";
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
                        'id' => $record['video_info_id'],
                        'video_info_date' => $record['video_info_date'],  //五部曲日期
                        'seller_notes' => $record['seller_notes'],  //五部曲备注
                        'video_info_url'=>$record['video_info_url'], //地址
                        'video_info_directer_grades'=>$record['video_info_directer_grades'], //总监评分
                        'video_info_manager_grades'=>$record['video_info_manager_grades'], //总经理评分
                        'video_info_statue'=>$record['video_info_statue'], //为第几部曲
                        'city_privileges'=>$record['city_privileges'],
                        'video_info_user_name'=>$record['video_info_user_name'],
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