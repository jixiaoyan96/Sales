<?php
header("Content-type: text/html; charset=utf-8");
Class Quiz{

    /**
     * just for selecting the numbers
     */
    Public static function listReturn(){
        $list = array(0=>Yii::t('sales','question_count_choose'));
        $data=array();  //需求数组
        for($i=5;$i<101;$i++){
            $data[$i]['id']=$i;
            $data[$i]['value_count']=$i;
        }
        if (count($data) > 0) {
            foreach ($data as $row) {
                $list[$row['id']] = $row['value_count'];
            }
        }
        return $list;
    }

    /**
     * the kinds of sales
     */
    Public static function kindsReturn(){
        $list = array(0=>Yii::t('sales','quiz_kinds_choose'),1=>Yii::t('sales','forever'),2=>Yii::t('sales','temporary'));
        return $list;
    }

    /**
     * @param $employee_id
     * @param $quiz_id
     * @return mixed
     * 员工的历史查询页面
     */
    Public static function historyShow($employee_id,$quiz_id){
        $result=array();
        if(isset($quiz_id)&&isset($employee_id)){
            if(!empty($quiz_id)&&!empty($employee_id)) {
                $middle_employee_quiz_info_set = "select * from employee_correct_rate WHERE quiz_employee_id=$employee_id AND employee_correct_rate_info_id='$quiz_id'";
                $middle_employee_quiz_info_get = Yii::app()->db2->createCommand($middle_employee_quiz_info_set)->queryAll();
                $result=$middle_employee_quiz_info_get;
                return $result;
            }
            else{
                return $result;
            }
        }
        else{
            return $result;
        }
    }
/*
 * add info_id
 */
    Public static function SelectReturn($info_id){
        $list=array();
        if(!empty($info_id)){   //修改测验单员工
            $sql = "select id,employee_info_name from employee_info_v where 1=1";
            $data = Yii::app()->db2->createCommand($sql)->queryAll();
        }
        else{   //新增测验单员工
            $sql = "select id,employee_info_name from employee_info_v where 1=1";
            $data = Yii::app()->db2->createCommand($sql)->queryAll();
        }
        if (count($data) > 0) {
            foreach ($data as $row) {
                $list[$row['id']] = $row["employee_info_name"];
            }
        }
        return $list;
    }
    /**
     * @param array $id array pass  return the result of the querying
     * @return array
     */
    Public static function EmployeeIdGet($id){
        if(!empty($id)){
            $tableFuss=Yii::app()->params['jsonTableName'];
            $sql="select quiz_employee_id from blog$tableFuss.sales WHERE id=$id";
            $quizEmployeeId = Yii::app()->db2->createCommand($sql)->queryAll();  //set $date[0]['quiz_employee_id'] to get the value
            $data_employee_id_data_pass=$quizEmployeeId[0]['quiz_employee_id'];   //获取quiz表 关联的员工id 字符串  for instance string(9) "1,2,3,4,5"
            $newArrayString=explode(',',$data_employee_id_data_pass);
            if(is_array($newArrayString)){
                return $newArrayString;
            }
            else{
                $id=array();
                return "";
            }
        }
        else{
            return "";
        }
    }
    Public static function demoData(){
        $list = array(0=>Yii::t('sales','employee_name_show'));
        return $list;
    }

    /**
     * $wrongArr
     * 答错详情数组返回
     * 这里考虑一个情况,如果错的题被删掉 浏览数据将会报错 需要做一个判断
     */
    Public static function getWrongDetail($wrongArr){
        $detailAnswer=explode('-',$wrongArr);
        $outPutData=array();
        if(!empty($wrongArr)) {
            for ($k = 0; $k < count($detailAnswer); $k++) {
                $temporaryArr = array();
                $temporaryArr = explode('*', $detailAnswer[$k]);
                $temporaryStr = $temporaryArr[0];
                $wrongDataSet = "select * from test_exams WHERE id=$temporaryStr";
                $wrongDataGet = Yii::app()->db2->createCommand($wrongDataSet)->queryAll();
                if (count($wrongDataGet) > 0) {
                    $outPutData[$k]['id'] = $temporaryStr;
                    $outPutData[$k]['content'] = $wrongDataGet[0]['test_exams_contents'];
                    $outPutData[$k]['wrong_answer'] = $wrongDataGet[0][$temporaryArr[1]];
                    $outPutData[$k]['right_answer'] = $wrongDataGet[0]['test_exams_answer_right'];
                } else {
                    $outPutData[$k]['id'] = null;
                    $outPutData[$k]['content'] = "该测验题数据已经删除";
                    $outPutData[$k]['wrong_answer'] = "该测验题数据已经删除";
                    $outPutData[$k]['right_answer'] = "该测验题数据已经删除";
                }
            }
        }
        else{
            $outPutData[0]['id'] = null;
            $outPutData[0]['content'] = "你真厉害,本次测验没有错误";
            $outPutData[0]['wrong_answer'] = "";
            $outPutData[0]['right_answer'] = "";
        }
        //var_dump($outPutData);die;
        return $outPutData;
    }
    /**
     * @return array
     * 唯一标识id进入 判断quiz_employee_id
     * ①登录的员工是否有可以测验的权利=>判断未过期的测验单=>在these测验单中进行循环判断是否包含登录的员工的id=>输出结果(个别包含,但一定有值)
     * ②测验单的数据可能还有一种情况:当登录的员工没有被任何测验单授权测验时
     */
    Public static function QuestionsSelect(){
        $tableFuss=Yii::app()->params['jsonTableName'];
        $sql="select id,quiz_name,quiz_start_dt,quiz_employee_id,quiz_exams_id,quiz_end_dt from blog$tableFuss.sales WHERE 1=1 ";
        $select_quiz_result = Yii::app()->db2->createCommand($sql)->queryAll();
        $result=array();  //判断条件获取结果的测验单
        $nowTime=strtotime(date("Y-m-d H:i:s")); //当前时间
        $newResultForEmployee=array();
        $quiz_session_login_id=Yii::app()->user->name;
        $employee_middle_value_set="select * from employee_user_bind_v WHERE user_id='$quiz_session_login_id'";
        //var_dump($employee_middle_value_set);die;
        $employee_middle_value_get=Yii::app()->db2->createCommand($employee_middle_value_set)->queryAll();
        $employee_id_middle="";
        if(count($employee_middle_value_get)>0){
            $employee_id_middle=$employee_middle_value_get[0]['employee_id'];//员工主键获取
        }
        else{
            $list=array(0=>Yii::t('sales','sorry,you do not have the power to start quizing!'));//对不起,你未被授权可以参与测验
        }
        $list=array();
                for ($k = 0; $k < count($select_quiz_result); $k++) {   //外层(测验单能够在city授权输出的条件)走一次 内层(每个测验单的授权员工id)走一圈
                    if ($select_quiz_result[$k]['quiz_exams_id'] == 1) {
                        $result[] = $select_quiz_result[$k];
                    } else {   //短期验证
                        $quiz_time = strtotime($select_quiz_result[$k]['quiz_start_dt']);
                        $start_time = strtotime($select_quiz_result[$k]['quiz_end_dt']);
                        $dateShow = ceil(($nowTime - $quiz_time) / 86400);  //是否截止
                        $dateStart = ceil(($nowTime - $start_time) / 86400); //是否开始
                        if($dateStart>=0) {
                            if ($dateShow < 0) {  //未过期的测验单
                                $arrayEmployeeId = array();
                                $arrayEmployeeId = explode(",", $select_quiz_result[$k]['quiz_employee_id']);//测验单的可测验员工
                                $returnForEmployee = Quiz::arrDealForEmployee($employee_id_middle, $arrayEmployeeId);
                                if ($returnForEmployee) {//未过期且允许该员工测验的测验单
                                    $result[] = $select_quiz_result[$k];
                                }
                            }
                            }
                    }
                }
            if(count($result)==0){
                $list=array(0=>Yii::t('sales','sorry,none of the sales tests allows you to start quizing!'));//对不起,你未被任何测验单授权可以进行测验
            }
      /*
        else{
            $list=array(0=>Yii::t('sales','sorry,you do not have the power to start quizing!'));//对不起,你未被授权可以参与测验
        }*/
        if (count($result) > 0) {
            $list = array(0=>Yii::t('sales','Quiz_select_choose'));
            foreach ($result as $row) {
                $list[$row['id']] = $row['quiz_name'];
            }
        }
        return $list;
    }
    Public static function arrDealForEmployee($employee_id,$arrFor){
        $returnValue=false;
        for($countEm=0;$countEm<count($arrFor);$countEm++){
            if(intval($employee_id)===intval($arrFor[$countEm])){
                $returnValue=true;
                break;
            }
            else{
                $returnValue=false;
                continue;
            }
        }
        return $returnValue;
    }

    Public static function selectEmployee(){
        $list=array();
        $select_quiz_result=array();
        $select_quiz_result[0]=array('id'=>0,'showAnswer'=>'请选择测验单');
        if (count($select_quiz_result) > 0) {
            foreach ($select_quiz_result as $row) {
                $list[$row['id']] = $row['showAnswer'];
            }
        }
        return $list;
    }

    Public static function checkRadioDemo(){
        $list=array();
        $select_quiz_result=array();
        $select_quiz_result[0]=array('id'=>0,'showAnswer'=>'请选择测验单');
        if (count($select_quiz_result) > 0) {
            foreach ($select_quiz_result as $row) {
                $list[$row['id']] = $row['showAnswer'];
            }
        }
        return $list;

        }
    Public static function checkRadioValueGet($quiz_id,$employee_id){
        $test_exams_count_set="select * from sales WHERE id=$quiz_id";
        $test_exams_count_get=Yii::app()->db2->createCommand($test_exams_count_set)->queryAll();
        $test_exams_count_getValue=$test_exams_count_get[0]['quiz_exams_count']; //该测验单的admin后台出的题目条数
        $Wrong_Employee_Value_Set="select * from employee_middle_wrong_exams WHERE employee_middle_wrong_info_id=$employee_id";   //因为员工与题目的关系是多对多且为不重复 所以不能加入quiz_id该条件
        $Wrong_Employee_Value_Get = Yii::app()->db2->createCommand($Wrong_Employee_Value_Set)->queryAll();  //该员工的错题的所有集合
        $wrong_exams_id_str="";
        for($i=0;$i<count($Wrong_Employee_Value_Get);$i++){
            $wrong_exams_id_str.=$Wrong_Employee_Value_Get[$i]['employee_middle_test_exams_id'].',';
        }
        $wrong_exams_id_str=rtrim($wrong_exams_id_str,',');//该员工的错题id的所有集合
        $finalResult=array();
        if(!empty($employee_id)&&!empty($quiz_id)){
            if(count($Wrong_Employee_Value_Get)>1){  //错题大于一
                $wrong_exams_count=count($Wrong_Employee_Value_Get);
                $split_exams_count=floor($wrong_exams_count/2);
                $getTheCountValue=$test_exams_count_getValue-$split_exams_count;  //题库的选择数量 有可能为负数 当错题的一半数量向下取整的结果值大于或等于本次该测验单的数量时 那么随机出来的题目将全部为该员工做错过的题目
                if($getTheCountValue<=0){  //错题一半的向下取整大于或等于该次测验单数量 =>仅有错题库提供题目
                    $test_exams_id_set ="SELECT employee_middle_test_exams_id FROM employee_middle_wrong_exams WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM employee_middle_wrong_exams))) AND employee_middle_wrong_info_id=$employee_id  LIMIT $test_exams_count_getValue";
                    $test_exams_id_get = Yii::app()->db2->createCommand($test_exams_id_set)->queryAll(); //随机且包含错题的test_exam=>id合集  数量为该次测验单的题目数
                    $finalTestExamsStr="";
                    for($j=0;$j<count($test_exams_id_get);$j++){
                        $finalTestExamsStr.=$test_exams_id_get[$j]['employee_middle_test_exams_id'].',';
                    }
                    $finalTestExamsStr=rtrim($finalTestExamsStr,','); //得到本次测验的所有题目id
                    $finalTestExamsStrResultSet ="SELECT * FROM test_exams WHERE id IN ($finalTestExamsStr) order by rand() ";
                    $finalTestExamsStrResultGet = Yii::app()->db2->createCommand($finalTestExamsStrResultSet)->queryAll();  //完结:错题一半的向下取整大于或等于该次测验单数量时的题目集合
                    $finalResult=$finalTestExamsStrResultGet;
                }
                else{         //错题一半的向下取整小于该次测验单数量=>由错题和题库一起提供 即为错题的计算结果数量-本次测验的题目数量<-1(错题取值在1到题目数-1的开区间内)
                    $test_exams_id_set ="SELECT id FROM test_exams WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM test_exams))) AND id NOT IN ($wrong_exams_id_str) order by rand() LIMIT $getTheCountValue";
                    $test_exams_id_get = Yii::app()->db2->createCommand($test_exams_id_set)->queryAll(); //随机且不包含错题的test_exam=>id合集
                    //开始获取非错题的题目id结果集
                    $test_exams_final="";//得到本次测验的所有非错题的题目id
                    for($k=0;$k<count($test_exams_id_get);$k++){
                        $test_exams_final.=$test_exams_id_get[$k]['id'].',';
                    }
                    $test_exams_wrong_id_set ="SELECT employee_middle_test_exams_id FROM employee_middle_wrong_exams WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM employee_middle_wrong_exams))) AND employee_middle_wrong_info_id=$employee_id order by rand() LIMIT $split_exams_count";
                    $test_exams_wrong_id_get = Yii::app()->db2->createCommand($test_exams_wrong_id_set)->queryAll(); //错题的集合
                    for($l=0;$l<count($test_exams_wrong_id_get);$l++){
                        $test_exams_final.=$test_exams_wrong_id_get[$l]['employee_middle_test_exams_id'].',';
                    }
                    $test_exams_final=trim($test_exams_final,',');
                    $test_exams_final_arr=explode(',',$test_exams_final);
                    shuffle($test_exams_final_arr);
                    $upLow_test_examsId_get=implode($test_exams_final_arr,',');
                    $finalTestExamsStrResultSet ="SELECT * FROM test_exams WHERE id IN ($upLow_test_examsId_get)";
                    $finalTestExamsStrResultGet = Yii::app()->db2->createCommand($finalTestExamsStrResultSet)->queryAll();
                    $finalResult=$finalTestExamsStrResultGet;
                }
            }
            elseif(count($Wrong_Employee_Value_Get)==1){  //错题为1 PS:每次出的测验题目 至少应大于10题 所以这里不判断当测验题为1时
                $get_The_Count_Value_on=$test_exams_count_getValue-count($Wrong_Employee_Value_Get);  //题库非错题的题目数量
                $test_exams_id_set ="SELECT id FROM test_exams WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM test_exams))) AND id NOT IN ($wrong_exams_id_str) order by rand() LIMIT $get_The_Count_Value_on";
                $test_exams_id_get = Yii::app()->db2->createCommand($test_exams_id_set)->queryAll(); //随机且不包含错题的test_exam=>id合集
                $test_examsId_final_result="";
                for($m=0;$m<count($test_exams_id_get);$m++){
                    $test_examsId_final_result.=$test_exams_id_get[$m]['id'].',';
                }
                $test_examsId_final_result=trim($test_examsId_final_result,',').",".$wrong_exams_id_str; //获取本次测验的所有题目id
                $on_arr_test_exams=explode(',',$test_examsId_final_result);
                shuffle($on_arr_test_exams);
                $on_str_test_exams=implode($on_arr_test_exams,',');
                $TestExamsOnResultSet ="SELECT * FROM test_exams WHERE id IN ($on_str_test_exams)";
                $TestExamsOnResultGet = Yii::app()->db2->createCommand($TestExamsOnResultSet)->queryAll();
                $finalResult=$TestExamsOnResultGet;
            }
            else{   //错题为0
                $test_exams_id_none_set ="SELECT * FROM test_exams WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM test_exams)))  order by rand()  LIMIT $test_exams_count_getValue";
                $test_exams_id_none_get=Yii::app()->db2->createCommand($test_exams_id_none_set)->queryAll();
                $finalResult=$test_exams_id_none_get;
            }
        }
        else {
            $finalResult=array();
            $finalResult[0]=array('id'=>'0','test_exams_contents'=>'亲,您的参数神秘消失了!请及时通知技术人员!','test_exams_answer_right'=>'正解A','test_exams_answer_faultf'=>'错解B','test_exams_answer_faults'=>'错解C','test_exams_answer_faultt'=>'错解D');
        }
        return $finalResult;
    }
    //Sales
    //拜访类型
    Public static function getKinds(){
        $list = array(0=>Yii::t('quiz','visit kinds'));
        $data_set="select * from visit_definition WHERE 1=1";
        $data_get=Yii::app()->db2->createCommand($data_set)->queryAll();

            if (count($data_get) > 0) {
                foreach ($data_get as $row) {
                    $list[$row['visit_definition_id']] = $row['visit_definition_name'];
                }
            }
            return $list;
    }

    /*
     * 客户类型
     */
    Public static function customerKinds(){
        $list = array(0=>Yii::t('quiz','customer kinds'));
        $data_set="select * from customer_kinds WHERE 1=1";
        $data_get=Yii::app()->db2->createCommand($data_set)->queryAll();
        if (count($data_get) > 0) {
            foreach ($data_get as $row) {
                $list[$row['customer_kinds_id']] = $row['customer_kinds_name'];
            }
        }
        return $list;
    }

    /**
     * 关于sale edit动态修改visit,service 的数据返回方法
     */
    Public static function editSales($edit_id){
        $visit_info_set="SELECT * FROM visit_info WHERE visit_customer_fid=$edit_id;";
        $visit_info_get=Yii::app()->db2->createCommand($visit_info_set)->queryAll();//循环得出拜访详情数据
        $dataReturn=array();
        if(count($visit_info_get)>0){
            //var_dump($visit_info_get);die;
            for($i=0;$i<count($visit_info_get);$i++){
                    $visit_id='';
                    $visit_id=$visit_info_get[$i]['visit_info_id'];
                    $service_info_set="select * from service_history WHERE service_visit_pid='$visit_id'";
                    $service_info_get=Yii::app()->db2->createCommand($service_info_set)->queryAll();
                    $dataReturn[$i]['visit_info']=$visit_info_get[$i]; //拜访详情
                if(count($service_info_get)>0){
                    for($j=0;$j<count($service_info_get);$j++){
                        $dataReturn[$i]['visit_info']['service_info'][]=$service_info_get[$j]; //服务详情
                    }
                }
            }
        }
        //var_dump($dataReturn);die;
        return $dataReturn;
    }

    Public static function editNewSales($edit_id){
        $visit_info_set="SELECT * FROM visit_info WHERE visit_customer_fid=$edit_id;";
        $visit_info_get=Yii::app()->db2->createCommand($visit_info_set)->queryAll();//循环得出拜访详情数据
        $dataReturn=array();
        if(count($visit_info_get)>0){
            //var_dump($visit_info_get);die;
            for($i=0;$i<count($visit_info_get);$i++){
                $visit_id='';
                $visit_id=$visit_info_get[$i]['visit_info_id'];
                $service_info_set="select * from new_service_info WHERE new_visit_info_pid='$visit_id'";
                $service_info_get=Yii::app()->db2->createCommand($service_info_set)->queryAll();
                $dataReturn[$i]['visit_info']=$visit_info_get[$i]; //拜访详情
                if(count($service_info_get)>0){
                    for($j=0;$j<count($service_info_get);$j++){
                        $dataReturn[$i]['visit_info']['service_info'][]=$service_info_get[$j]; //服务详情
                    }
                }
            }
        }
        //var_dump($dataReturn);die;
        return $dataReturn;
    }
    Public static function visitDefinition(){
        $list = array(
            ''=>Yii::t('quiz','this_visit_definition'),
            '首次'=>Yii::t('quiz','first'),
            '报价'=>Yii::t('quiz','Quote'),
            '客诉'=>Yii::t('quiz','Customer Complaint'),
            '收款'=>Yii::t('quiz','Collect money'),
            '追款'=>Yii::t('quiz','Chase money'),
            '签单'=>Yii::t('quiz','Sign a single'),
            '续约'=>Yii::t('quiz','Renew'),
            '回访'=>Yii::t('quiz','Return visit'),
            '其他'=>Yii::t('quiz','other'),
            '更改项目'=>Yii::t('quiz','Change the project'),
            '拜访目的'=>Yii::t('quiz','Visit purpose'),
            '陌拜'=>Yii::t('quiz','Do not visit'),
            '日常跟进'=>Yii::t('quiz','Daily follow-up'),
            '客户资源'=>Yii::t('quiz','Customer Resources'),
        );
        return $list;
    }

    Public static function visit_history_name(){
        $list = array(
            ''=>Yii::t('quiz','Service type'),
            '清洁(马桶)'=>Yii::t('quiz','Clean (toilet)'),
            '清洁(尿斗)'=>Yii::t('quiz','Clean (Urinal)'),
            '清洁(水盆)'=>Yii::t('quiz','Clean (basin)'),
            '清洁(清新机)'=>Yii::t('quiz','Clean (fresh machine)'),
            '清洁(皂液机)'=>Yii::t('quiz','Cleaning (soap dispenser)'),
            '清洁(租赁机器)'=>Yii::t('quiz','Clean (lease machine)'),
            '灭虫(老鼠)'=>Yii::t('quiz','Exterminator (mouse)'),
            '灭虫(蟑螂)'=>Yii::t('quiz','Exterminator (cockroach)'),
            '灭虫(果蝇)'=>Yii::t('quiz','Pest Control (Drosophila)'),
            '灭虫(租灭蝇灯)'=>Yii::t('quiz','Exterminator (rent fly lamp)'),
            '灭虫(老鼠蟑螂)'=>Yii::t('quiz','Exterminator (mouse cockroach)'),
            '灭虫(老鼠果蝇)'=>Yii::t('quiz','Exterminator (Drosophila melanogaster)'),
            '灭虫(老鼠蟑螂果蝇)'=>Yii::t('quiz','Pest Control (Mouse Cockroach Fruit Fly)'),
            '灭虫(老鼠蟑螂+租灯)'=>Yii::t('quiz','Pest control (mouse cockroach + rent lamp)'),
            '灭虫(蟑螂果蝇+租灯)'=>Yii::t('quiz','Exterminator (cockroach fruit fly + rent lamp)'),
            '灭虫(老鼠蟑螂果蝇+租灯)'=>Yii::t('quiz','Mouse cockroach fruit fly + rent lamp'),
            '飘盈香(迷你机)'=>Yii::t('quiz','Floating Ying Hong (mini machine)'),
            '飘盈香(小机)'=>Yii::t('quiz','Wandering fragrance (small machine)'),
            '飘盈香(中机)'=>Yii::t('quiz','Plenty of fragrance (machine)'),
            '飘盈香(大机)'=>Yii::t('quiz','Plenty of fragrance (large machine)'),
            '甲醛(除甲醛)'=>Yii::t('quiz','Formaldehyde (except formaldehyde)'),
            '甲醛(AC30)'=>Yii::t('quiz','Formaldehyde (AC30)'),
            '甲醛(PR30)'=>Yii::t('quiz','Formaldehyde (PR30)'),
            '甲醛(迷你清洁炮)'=>Yii::t('quiz','Formaldehyde (mini clean gun)'),
        );
        return $list;
    }

    /**
     * @param $serviceKinds分类id
     * @param $visit_id跟进id
     *
     * @return string
     */
    public static function salesReturn($serviceKinds,$visit_id){
        $charInsert='';
        if($serviceKinds==0){ //清洁
            if(isset($_REQUEST['matong1'])){  //马桶
                if(isset($_REQUEST['matonginput'.$visit_id])){
                    $charInsert.='matong*'.$_REQUEST['matonginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['niaodou'.$visit_id])){  //尿斗
                if(isset($_REQUEST['niaodouinput'.$visit_id])){
                    $charInsert.='niaodou*'.$_REQUEST['niaodouinput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['shuipen'.$visit_id])){ //水盆
                if(isset($_REQUEST['shuipeninput'.$visit_id])){
                    $charInsert.='shuipen*'.$_REQUEST['shuipeninput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['qingxinji'.$visit_id])){  //清新机
                if(isset($_REQUEST['qingxinjiinput'.$visit_id])){
                    $charInsert.='qingxinji*'.$_REQUEST['qingxinjiinput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['zaoyeji'.$visit_id])){ //皂液机
                if(isset($_REQUEST['zaoyejiinput'.$visit_id])){
                    $charInsert.='zaoyeji*'.$_REQUEST['zaoyejiinput'.$visit_id].'-';
                }
            }
        }
        elseif($serviceKinds==1){  //租赁
            if(isset($_REQUEST['fengshanji'.$visit_id])){  //风扇机
                if(isset($_REQUEST['fengshanjiinput'.$visit_id])){
                    $charInsert.='fengshanji*'.$_REQUEST['fengshanji'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['TChaohua'.$visit_id])){  //TC豪华
                if(isset($_REQUEST['TChaohuainput'.$visit_id])){
                    $charInsert.='TChaohua*'.$_REQUEST['TChaohuainput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['shuixingpenji'.$visit_id])){ //水性喷机
                if(isset($_REQUEST['huixingpenjiinput'.$visit_id])){
                    $charInsert.='huixingpenji*'.$_REQUEST['huixingpenjiinput'].$visit_id.'-';
                }
            }
            if(isset($_REQUEST['yasuoxiangguan'.$visit_id])){  //压缩香罐
                if(isset($_REQUEST['yasuoxiangguaninput'.$visit_id])){
                    $charInsert.='yasuoxiangguan*'.$_REQUEST['yasuoxiangguaninput'.$visit_id].'-';
                }
            }
        }
        elseif($serviceKinds==2){  //灭虫
            if(isset($_REQUEST['laoshu'.$visit_id])){  //老鼠
                if(isset($_REQUEST['laoshuinput'.$visit_id])){
                    $charInsert.='laoshu*'.$_REQUEST['laoshu'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['zhanglang'.$visit_id])){  //蟑螂
                if(isset($_REQUEST['zhanglanginput'.$visit_id])){
                    $charInsert.='zhanglang*'.$_REQUEST['zhanglanginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['guoying'.$visit_id])){ //果蝇
                if(isset($_REQUEST['guoyinginput'.$visit_id])){
                    $charInsert.='guoying*'.$_REQUEST['guoyinginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['zumieyingdeng'.$visit_id])){  //租灭蝇灯
                if(isset($_REQUEST['zumieyingdenginput'.$visit_id])){
                    $charInsert.='zumieyingdeng*'.$_REQUEST['zumieyingdenginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['laoshuzhanglang'.$visit_id])){  //老鼠蟑螂
                if(isset($_REQUEST['laoshuzhanglanginput'.$visit_id])){
                    $charInsert.='laoshuzhanglang*'.$_REQUEST['laoshuzhanglanginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['laoshuguoying'.$visit_id])){  //老鼠果蝇
                if(isset($_REQUEST['laoshuguoyinginput'.$visit_id])){
                    $charInsert.='laoshuguoying*'.$_REQUEST['laoshuguoyinginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['zhanglangguoying'.$visit_id])){  //蟑螂果蝇
                if(isset($_REQUEST['zhanglangguoyinginput'.$visit_id])){
                    $charInsert.='zhanglangguoying*'.$_REQUEST['zhanglangguoyinginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['laoshuzhanglangguoying'.$visit_id])){  //老鼠蟑螂果蝇
                if(isset($_REQUEST['laoshuzhanglangguoyinginput'.$visit_id])){
                    $charInsert.='laoshuzhanglangguoying*'.$_REQUEST['laoshuzhanglangguoyinginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['laoshuzhanglangjiazudeng'.$visit_id])){  //老鼠蟑螂加租灯
                if(isset($_REQUEST['laoshuzhanglangjiazudenginput'.$visit_id])){
                    $charInsert.='laoshuzhanglangjiazudeng*'.$_REQUEST['laoshuzhanglangjiazudenginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['zhanglangguoyingjiazudeng'.$visit_id])){  //蟑螂果蝇加租灯
                if(isset($_REQUEST['zhanglangguoyingjiazudenginput'.$visit_id])){
                    $charInsert.='zhanglangguoyingjiazudeng*'.$_REQUEST['zhanglangguoyingjiazudenginput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['laoshuzhanglangguoyingjiazudeng'.$visit_id])){  //老鼠蟑螂果蝇加租灯
                if(isset($_REQUEST['laoshuzhanglangguoyingjiazudenginput'.$visit_id])){
                    $charInsert.='laoshuzhanglangguoyingjiazudeng*'.$_REQUEST['laoshuzhanglangguoyingjiazudenginput'.$visit_id].'-';
                }
            }
        }
        elseif($serviceKinds==3){  //飘盈香
            if(isset($_REQUEST['minixiaoji'.$visit_id])){  //迷你小机
                if(isset($_REQUEST['minixiaojiinput'.$visit_id])){
                    $charInsert.='minixiaoji*'.$_REQUEST['minixiaoji'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['xiaoji'.$visit_id])){  //小机
                if(isset($_REQUEST['xiaojiinput'.$visit_id])){
                    $charInsert.='xiaoji*'.$_REQUEST['xiaojiinput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['zhongji'.$visit_id])){ //中机
                if(isset($_REQUEST['zhongjiinput'.$visit_id])){
                    $charInsert.='zhongji*'.$_REQUEST['zhongjiinput'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['daji'.$visit_id])){  //大机
                if(isset($_REQUEST['dajiinput'.$visit_id])){
                    $charInsert.='daji*'.$_REQUEST['dajiinput'.$visit_id].'-';
                }
            }
        }
        elseif($serviceKinds==4){  //甲醛
            if(isset($_REQUEST['chujiaquan'.$visit_id])){  //除甲醛
                if(isset($_REQUEST['chujiaquaninput'.$visit_id])){
                    $charInsert.='chujiaquan*'.$_REQUEST['chujiaquan'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['AC30'.$visit_id])){  //AC30
                if(isset($_REQUEST['AC30input'.$visit_id])){
                    $charInsert.='AC30*'.$_REQUEST['AC30input'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['PR10'.$visit_id])){ //PR10
                if(isset($_REQUEST['PR10input'.$visit_id])){
                    $charInsert.='PR10*'.$_REQUEST['PR10input'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['miniqingjiepao'.$visit_id])){  //迷你清洁炮
                if(isset($_REQUEST['miniqingjiepaoinput'.$visit_id])){
                    $charInsert.='miniqingjiepao*'.$_REQUEST['miniqingjiepaoinput'.$visit_id].'-';
                }
            }
        }
        elseif($serviceKinds==5){  //纸品
            if(isset($_REQUEST['cashouzhi'.$visit_id])){  //擦手纸
                if(isset($_REQUEST['cashouzhiinput'.$visit_id])){
                    $charInsert.='cashouzhi*'.$_REQUEST['cashouzhi'.$visit_id].'-';
                }
            }
            if(isset($_REQUEST['dajuancezhi'.$visit_id])){  //大卷厕纸
                if(isset($_REQUEST['dajuancezhiinput'.$visit_id])){
                    $charInsert.='dajuancezhi*'.$_REQUEST['dajuancezhiinput'.$visit_id].'-';
                }
            }
        }
        return $charInsert;
    }

}
