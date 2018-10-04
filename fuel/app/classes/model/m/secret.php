<?php

class Model_M_Secret extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'PLN_ID',
		'SECRET_ID',
		'PLN_TYPE',
		'PLN_NAME',
		'PLN_RATE',
		'PLN_PASS',
		'PLN_CAP_PC',
		'PLN_USE_FLG',
		'UP_DATE',
		'SORT_NUM',
	);

	protected static $_table_name = 'm_secrets';



	public function get_plan_all($option, $htl_id, $plan_id)
	{
		if (!isset($option['sort'])) {
				$option['sort'] = 'ms.SORT_NUM';
		}
		if (!isset($option['sort_option'])) {
				$option['sort_option'] = 'DESC';
		}
		if (!isset($option['limit'])) {
				$option['limit'] = LIMIT_NUM;
		}		
		if (!isset($option['offset'])) {
				$option['offset'] = 0;
		}
		if (!isset($option['where'])) {
				$option['where'] = '';
		}

		$sql = "SELECT 
		ms.*
		FROM m_secrets ms
		WHERE ms.HTL_ID=".$htl_id." AND ms.PLN_ID=".$plan_id.$option['where']." ORDER BY ".$option['sort']. " ".$option['sort_option']." LIMIT ".$option['limit']." OFFSET ".$option['offset'].";";

		$query = DB::query($sql);
		$result =$query->execute()->as_array();
		return $result;
	}

	public function get_plan_one($htl_id, $plan_id, $secret_id)
	{
		$query = DB::query("
			SELECT *
			FROM m_secrets ms 
			WHERE ms.HTL_ID = ".$htl_id." AND ms.PLN_ID = ".$plan_id." AND ms.SECRET_ID = ".$secret_id."
			;
			");
		$result =$query->execute()->as_array();

		if (count($result) == 0) {
			return false;
		}
		return $result[0];
	}

	public function delete_plan($params)
	{
		$query = "DELETE FROM m_secrets WHERE ";

		foreach ($params as $key => $param) {
			if ($key == 0) {
				$query .= "(HTL_ID=".$param[0]." AND PLN_ID=".$param[1]." AND SECRET_ID=".$param[2].")";	
			}else{
				$query .= " OR (HTL_ID=".$param[0]." AND PLN_ID=".$param[1]." AND SECRET_ID=".$param[2].")";
			}
			
		}
		$query .=";";
		$dao = DB::query($query);
		$result =$dao->execute();
		return $result[0];

	}

	public function change_sort($param)
	{

		$query = DB::query("
				UPDATE m_secrets SET SORT_NUM=".$param['sort_val']." WHERE HTL_ID=".$param['htl_id']." AND PLN_ID=".$param['pln_id']." AND SECRET_ID=".$param['secret_id']."
				");
		$result =$query->execute();
	}



	public function plan_insert($htl_id, $plan_id)
	{
		$sql = "SELECT SECRET_ID FROM m_secrets WHERE HTL_ID = ".$htl_id." AND PLN_ID = ".$plan_id." ORDER BY SECRET_ID DESC LIMIT 1";

		$query = DB::query($sql);
		$result =$query->execute()->as_array();

		if (count($result) == 0) {
			$secret_id = 1;
		}else{
			$secret_id = $result[0]['SECRET_ID'] + 1;
		}

		$query = DB::insert('m_secrets')->set(array(
			'HTL_ID' => $htl_id,
			'PLN_ID' => $plan_id,
			'SECRET_ID' => $secret_id,
			'PLN_NAME' => '新規シークレットプラン',
			'PLN_USE_FLG' => '0',
		));

		$result = $query->execute();
		return $secret_id;
	}

	public function plan_save($param, $h_id, $p_id, $s_id)
	{
		$query = DB::update('m_secrets');

		$query->value('m_secrets.PLN_TYPE',$param['PLN_TYPE']);
		$query->value('m_secrets.PLN_NAME',$param['PLN_NAME']);
		$query->value('m_secrets.PLN_RATE',$param['PLN_RATE']);
		$query->value('m_secrets.PLN_PASS',$param['PLN_PASS']);
		$query->value('m_secrets.PLN_USE_FLG', $param['PLN_USE_FLG']);
		$query->value('m_secrets.PLN_CAP_PC',$param['PLN_CAP_PC']);

		$query->where('m_secrets.HTL_ID',$h_id);
		$query->and_where('m_secrets.PLN_ID',$p_id);
		$query->and_where('m_secrets.SECRET_ID',$s_id);

		$result = $query->execute();
		return $result;
	}


	public function change_sale_flg($flg, $params)
	{
		$query = "UPDATE m_secrets SET PLN_USE_FLG=".$flg." WHERE ";

		foreach ($params as $key => $param) {
			if ($key == 0) {
				$query .= "(HTL_ID=".$param[0]." AND PLN_ID=".$param[1]." AND SECRET_ID=".$param[2].")";	
			}else{
				$query .= " OR (HTL_ID=".$param[0]." AND PLN_ID=".$param[1]." AND SECRET_ID=".$param[2].")";
			}
		}

		$query .=";";
		$dao = DB::query($query);
		$result =$dao->execute();
	}

	public function get_count($option, $htl_id, $plan_id)
	{

		$query = "SELECT * FROM m_secrets WHERE HTL_ID=".$htl_id." AND PLN_ID=".$plan_id;

		if ($option != '') {
			$query .= $option;
		}

		$query .=";";
		$dao = DB::query($query);
		$result =$dao->execute();

		$num_rows = count($result);
		return $num_rows;
	}

}
