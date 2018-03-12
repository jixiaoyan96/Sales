<?php

class FivestepList extends CListPageModel
{
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(	
			'lcd'=>Yii::t('sales','Creation Date'),
			'status'=>Yii::t('sales','Status'),
			'filename'=>Yii::t('sales','File'),
		);
	}
	
	public function retrieveDataByPage($pageNum=1)
	{
		$suffix = Yii::app()->params['envSuffix'];
		$city = Yii::app()->user->city_allow();
		$user = Yii::app()->user->id;
		$sql1 = "select a.*, b.name as city_name, c.sellers_name
				from sal_fivestep a 
				inner join sellers_user_bind_v c on a.username=c.user_id
				left outer join security$suffix.sec_city b on a.city=b.code
				where a.city in ('$citylist')
			";
		$sql2 = "select count(a.id)
				from sal_fivestep a 
				inner join sellers_user_bind_v c on a.username=c.user_id
				left outer join security$suffix.sec_city b on a.city=b.code
				where a.city in ('$citylist')
			";
		if (!Yii::app()->user->validFunction('CN01')) {
			$x = " and a.username='$user' ";
			$sql1 .= $x;
			$sql2 .= $x;
		}
		$clause = "";
		if (!empty($this->searchField) && !empty($this->searchValue)) {
			$svalue = str_replace("'","\'",$this->searchValue);
			switch ($this->searchField) {
				case 'sellers_name':
					$clause .= General::getSqlConditionClause('c.sellers_name',$svalue);
					break;
				case 'status':
					$field = "(select case a.status when 'P' then '".this->getStatusDesc('P')."' 
							when 'D' then '".this->getStatusDesc('D')."' 
							when 'F' then '".this->getStatusDesc('F')."' 
							when 'C' then '".this->getStatusDesc('C')."' 
						end) ";
					$clause .= General::getSqlConditionClause($field,$svalue);
					break;
				case 'city_name':
					$clause .= General::getSqlConditionClause('b.name',$svalue);
					break;
			}
		}
		
		$order = "";
		if (!empty($this->orderField)) {
			switch ($this->orderField) {
				case 'city_name': $orderf = 'b.name'; break;
				default: $orderf = $this->orderField; break;
			}
			$order .= " order by ".$orderf." ";
			if ($this->orderType=='D') $order .= "desc ";
		}

		$sql = $sql2.$clause;
		$this->totalRow = Yii::app()->db2->createCommand($sql)->queryScalar();
		
		$sql = $sql1.$clause.$order;
		$sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
		$records = Yii::app()->db->createCommand($sql)->queryAll();
		
		$list = array();
		$this->attr = array();
		if (count($records) > 0) {
			foreach ($records as $k=>$record) {
				$this->attr[] = array(
					'id'=>$record['id'],
					'username'=>$record['username'],
					'sellers_name'=>$record['sellers_name'],
					'filename'=>$record['filename'],
					'status'=>$this->getStatusDesc(record['status']),
					'city_name'=>$record['city_name'],
					'city'=>$record['city'],
					'lcd'=>$record['lcd'],
					'step'=>$record['step'],
				);
			}
		}
		$session = Yii::app()->session;
		$session['criteria_hk03'] = $this->getCriteria();
		return true;
	}

	public function getStatusDesc($code) {
		switch ($code) {
			case 'P': $rtn = Yii::t('sales','Pending'); break;
			case 'D': $rtn = Yii::t('sales','Draft'); break;
			case 'F': $rtn = Yii::t('sales','Fail'); break; 
			case 'C': $rtn = Yii::t('sales','Success'); break;
			default: $rtn = '';
		}
		return $rtn;
	}
}
