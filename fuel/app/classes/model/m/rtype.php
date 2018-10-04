<?php

class Model_M_Rtype extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'TYPE_ID',
		'TYPE_NAME',
		'RM_NUM',
		'CAP_MIN',
		'CAP_MAX',
		'RM_TYPE',
		'RM_OPTION',
		'EX_BED',
		'GENDER_FLG',
		'RM_CAP_PC',
		'RM_CAP_PC_LIGHT',
		'RM_CAP_MOB',
		'RM_USE_FLG',
		'UP_DATE',
		'DISP_ORDER',
	);

	protected static $_table_name = 'm_rtypes';


	public function get_room_all($option, $h_id)
	{

		if (!isset($option['sort'])) {
				$option['sort'] = 'DISP_ORDER';
		}
		if (!isset($option['sort_option'])) {
				$option['sort_option'] = 'ASC';
		}
		if (!isset($option['limit'])) {
				$option['limit'] = LIMIT_NUM;
		}		
		if (!isset($option['offset'])) {
				$option['offset'] = 0;
		}
		

		$sql = "SELECT * FROM m_rtypes WHERE HTL_ID =".$h_id." ORDER BY ".$option['sort']. " ".$option['sort_option']." LIMIT ".$option['limit']." OFFSET ".$option['offset'].";";

		$query = DB::query($sql);
		$result =$query->execute()->as_array();
		return $result;
	}

	public function get_room_one($h_id, $t_id)
	{
		$query = DB::query("
			SELECT mr.*,
			mrc.TYPE_NAME as TYPE_NAME_CH,
			mrch.TYPE_NAME as TYPE_NAME_CHH,
			mre.TYPE_NAME as TYPE_NAME_EN,
			mrk.TYPE_NAME as TYPE_NAME_KO

			FROM m_rtypes mr 
			LEFT JOIN m_rtype_chs mrc ON mrc.HTL_ID = mr.HTL_ID AND mrc.TYPE_ID = mr.TYPE_ID
			LEFT JOIN m_rtype_chhs mrch ON mrch.HTL_ID = mr.HTL_ID AND mrch.TYPE_ID = mr.TYPE_ID
			LEFT JOIN m_rtype_ens mre ON mre.HTL_ID = mr.HTL_ID AND mre.TYPE_ID = mr.TYPE_ID
			LEFT JOIN m_rtype_kos mrk ON mrk.HTL_ID = mr.HTL_ID AND mrk.TYPE_ID = mr.TYPE_ID


			WHERE mr.HTL_ID = ".$h_id." AND mr.TYPE_ID = ".$t_id."
			;");
		$result =$query->execute()->as_array();

		if (count($result) == 0) {
			Response::redirect('room');
		}
		return $result[0];

	}


	public function get_allplan_rtype($htl_id, $type_id)
	{
		$query = DB::query("
			SELECT * FROM m_rtypes mr
			
			INNER JOIN m_plan_rtypes mpr 
			ON mpr.HTL_ID = mr.HTL_ID AND mpr.TYPE_ID = mr.TYPE_ID
			INNER JOIN m_plans mp
			ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID

			WHERE mr.HTL_ID=".$htl_id." AND mr.TYPE_ID=".$type_id."
			;");


		$result = $query->execute()->as_array();
		return $result;

	}


	public function insert_rtype($param, $h_id)
	{

		$sql = "SELECT TYPE_ID FROM m_rtypes WHERE HTL_ID = ".$h_id." ORDER BY TYPE_ID DESC LIMIT 1";

		$query = DB::query($sql);
		$result =$query->execute()->as_array();

		if (count($result) == 0) {
			$t_id = 1;
		}else{
			$t_id = $result[0]['TYPE_ID'] + 1;
		}


		$query = DB::insert('m_rtypes')->set(array(
				'HTL_ID' => $h_id,
				'TYPE_ID' => $t_id,
				'TYPE_NAME' => '新規部屋タイプ',
				'RM_NUM' => '1',
				'CAP_MIN' => '1',
				'CAP_MAX' => '1',
				'RM_USE_FLG' => '0',
				// 'RM_OPTION' => $param['RM_OPTION'],

				// 'TYPE_NAME' => $param['TYPE_NAME'],
				// 'RM_NUM' => $param['RM_NUM'],
				// 'CAP_MIN' => $param['CAP_MIN'],
				// 'CAP_MAX' => $param['CAP_MAX'],
				// 'RM_USE_FLG' => $param['RM_USE_FLG'],
				// 'RM_OPTION' => $param['RM_OPTION'],
			))->execute();

		return $t_id;
	}


	public function update_rtype($param, $h_id, $t_id)
	{
		$query = DB::update('m_rtypes');
		$query->join('m_rtype_ens', 'left');
		$query->on('m_rtype_ens.HTL_ID', '=', 'm_rtypes.HTL_ID');
		$query->on('m_rtype_ens.TYPE_ID', '=', 'm_rtypes.TYPE_ID');

		$query->join('m_rtype_kos', 'left');
		$query->on('m_rtype_kos.HTL_ID', '=', 'm_rtypes.HTL_ID');
		$query->on('m_rtype_kos.TYPE_ID', '=', 'm_rtypes.TYPE_ID');

		$query->join('m_rtype_chs', 'left');
		$query->on('m_rtype_chs.HTL_ID', '=', 'm_rtypes.HTL_ID');
		$query->on('m_rtype_chs.TYPE_ID', '=', 'm_rtypes.TYPE_ID');

		$query->join('m_rtype_chhs', 'left');
		$query->on('m_rtype_chhs.HTL_ID', '=', 'm_rtypes.HTL_ID');
		$query->on('m_rtype_chhs.TYPE_ID', '=', 'm_rtypes.TYPE_ID');


		$query->value('m_rtypes.TYPE_NAME', $param['TYPE_NAME']);
		$query->value('m_rtypes.RM_NUM', $param['RM_NUM']);
		$query->value('m_rtypes.CAP_MIN', $param['CAP_MIN']);
		$query->value('m_rtypes.CAP_MAX', $param['CAP_MAX']);
		$query->value('m_rtypes.RM_USE_FLG', $param['RM_USE_FLG']);
		$query->value('m_rtypes.RM_OPTION', $param['RM_OPTION']);
		$query->value('m_rtypes.GENDER_FLG', $param['GENDER_FLG']);

		$query->value('m_rtype_ens.TYPE_NAME', $param['TYPE_NAME_EN']);
		$query->value('m_rtype_chs.TYPE_NAME', $param['TYPE_NAME_CH']);
		$query->value('m_rtype_chhs.TYPE_NAME', $param['TYPE_NAME_CHH']);
		$query->value('m_rtype_kos.TYPE_NAME', $param['TYPE_NAME_KO']);

		$query->where('m_rtypes.HTL_ID', $h_id);
		$query->where('m_rtypes.TYPE_ID', $t_id);

		$query->execute();

	}

	public function change_sale_flg($flg, $h_id, $t_id)
	{
		$query = DB::update('m_rtypes');
		$query->value('RM_USE_FLG',$flg);

		$query->where('HTL_ID',$h_id);
		$query->where('TYPE_ID',$t_id);

		$query->execute();
	}

 	public function change_disp_order($num, $h_id, $t_id)
	{
		$query = DB::update('m_rtypes');
		$query->value('DISP_ORDER',$num);

		$query->where('HTL_ID',$h_id);
		$query->where('TYPE_ID',$t_id);

		$query->execute();
	}

	public function delete_room($h_id, $t_id)
	{
		$query = DB::delete('m_rtypes');
		$query->where('HTL_ID', '=', $h_id);
		$query->and_where('TYPE_ID', '=', $t_id);

		$query->execute();
	}

	public function get_count($htl_id)
	{

		$query = "SELECT * FROM m_rtypes WHERE HTL_ID =".$htl_id;

		$dao = DB::query($query);
		$result =$dao->execute();

		$num_rows = count($result);
		return $num_rows;
	}


	/*
	 *
	 *		
	 *		手間いらすAPIで使用
	 *
	 *
	 */
	public function get_rtype_status($param)
	{
		$param['DayStart'] = date('Y-m-d', strtotime($param['DayStart']));
		$param['DayEnd'] = date('Y-m-d', strtotime($param['DayEnd']));

		/*---------------------------------------------------*/
		$param['DayStart'] = date('Y-m-d', strtotime('first day of ' . $param['DayStart']));
		$param['DayEnd'] = date('Y-m-d', strtotime('last day of ' . $param['DayEnd']));
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		/*---------------------------------------------------*/


		$sql = "SELECT mr.RM_NUM, CASE mr.RM_USE_FLG WHEN 1 THEN 0 WHEN 0 THEN 1 END AS `SALE_STATUS` 
						FROM m_rtypes mr 
						WHERE mr.HTL_ID = '".$param['HTL_ID']."' AND mr.TYPE_ID = '".$param['HeyaID']."' ;"; 


		$query = DB::query($sql);
		$result = $query->execute()->as_array();

		if (count($result) == 0) {
			return 0;
		}

		$stock_list = array('status' => $result[0]['SALE_STATUS']);
		$basic_stock = $result[0]['RM_NUM'];
		$daily_stock=array();
		$daily_rsv_stock = array();


		$b_sql = "SELECT COUNT(*) AS R_COUNT, 
				(SELECT CONCAT(mrr.NUM , '_' ,mrr.STOP_FLG) FROM m_rtype_roomamounts mrr WHERE mrr.HTL_ID = [HTL_ID] AND mrr.TYPE_ID = [TYPE_ID] AND mrr.SETTING_DAY = '[DAY]') 
				AS MRR_INFO
				FROM t_rsv_details trd INNER JOIN t_rsvs tr ON tr.HTL_ID = trd.HTL_ID AND tr.RSV_NO = trd.RSV_NO 
				WHERE trd.HTL_ID = [HTL_ID] AND trd.TYPE_ID = [TYPE_ID] AND tr.RSV_STS = 1 AND trd.STAYDATE = '[DAY]' ;";


		/*指定の日付分データを用意*/
		for ($i=$param['DayStart']; $i <= $param['DayEnd']; $i++) { 
			$ds_num = 0; $dsr_num = 0; $flg = 'OP';
			$sql = str_replace(array('[DAY]', '[TYPE_ID]', '[HTL_ID]'), array($i,$param['HeyaID'], $param['HTL_ID']), $b_sql);
			$query = DB::query($sql);
			$result = $query->execute()->as_array();

			if(count($result) == 0){
				return 0;
			}
			
			if($result[0]['MRR_INFO'] != null){
				$mrrs = explode(EXPLODE, $result[0]['MRR_INFO']);
			}else{
				$mrrs = array('0' => '0', '1' => '0');
			}
			$ds_num   = $mrrs[0];
			$stop_flg = $mrrs[1];
			$dsr_num  = $result[0]['R_COUNT'];


			if($stop_flg != '0'){
				$flg = 'CL';
			}
			$day = substr($i, -2);
			if (($basic_stock+ $ds_num - $dsr_num ) <= 0) {
				$flg = 'CL';
			}
			if ($i < date('Y-m-d')) {	
				$flg = 'CL';
			}	
			

			$stock_list += array(
				$day.'_status' 	=> $flg,
				$day.'_stock' 	=> $basic_stock+ $ds_num - $dsr_num,
				$day.'_reserve' => $dsr_num,
				);
		}	

		return $stock_list;
	}



	/*
		tema030で使用
	*/
	public function get_stock_for_api($h_id, $t_id, $date)
	{
		$sql = "
				SELECT 
					mr.RM_NUM, mr.RM_USE_FLG,
					mrrm.SETTING_DAY, mrrm.NUM, mrrm.STOP_FLG,
					(SELECT count(*) FROM t_rsv_details trd 
						LEFT JOIN t_rsvs tr ON  tr.HTL_ID = trd.HTL_ID  AND tr.RSV_NO = trd.RSV_NO 
						WHERE trd.HTL_ID = mr.HTL_ID AND trd.TYPE_ID = mr.TYPE_ID AND tr.RSV_STS != 9 AND trd.STAYDATE = '".$date."' ) AS 'SALED_NUM'
		
				FROM m_rtypes mr
				LEFT JOIN m_rtype_roomamounts mrrm
				ON mrrm.HTL_ID = mr.HTL_ID AND mrrm.TYPE_ID = mr.TYPE_ID 
				AND mrrm.SETTING_DAY = '".$date."'
		
				WHERE mr.HTL_ID = ".$h_id." AND mr.TYPE_ID = ".$t_id.";
		";

		$query = DB::query($sql);
		$result = $query->execute()->as_array();


		if (count($result) == 0) {
			return 0;
		}
		return $result[0];

	}

	/*
	
		tema030で使用
	*/
  public function lincoln($h_id, $t_id, $date)
  {
    $sql = "
      SELECT mr.RM_TYPE,mr.RM_NUM,mrr.NUM AS 'ZOGEN',mrr.STOP_FLG AS 'MRR_STOP_FLG',
      (SELECT COUNT(tr.RSV_NO) 
              FROM t_rsvs tr LEFT JOIN t_rsv_details trd on trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
              WHERE trd.HTL_ID = mr.HTL_ID AND trd.TYPE_ID = mr.TYPE_ID AND trd.STAYDATE = '".$date."' AND tr.RSV_STS != 9) AS `URIAGE`
      
      FROM m_rtypes mr
      
      LEFT JOIN m_rtype_roomamounts mrr
      ON mrr.HTL_ID = mr.HTL_ID AND mrr.TYPE_ID = mr.TYPE_ID AND mrr.SETTING_DAY = '".$date."'
      
      WHERE mr.HTL_ID = ".$h_id." AND mr.TYPE_ID = ".$t_id;
     
     $query = DB::query($sql);

     $result = $query->execute()->as_array();

     return $result;
  }

}// end Class
