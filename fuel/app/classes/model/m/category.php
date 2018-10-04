<?php

class Model_M_Category extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'CATEGORY_ID',
		'CATEGORY_NAME',
		'CATEGORY_DISP',
		'CATEGORY_ETC',
		'CATEGORY_USE_FLG',
		'UP_DATE',
	);

	protected static $_table_name = 'm_categorys';
	// protected static $_primary_key = array('HTL_ID', 'CATEGORY_ID');

	/**
	*
	*
	*
	**/
	public function update_flg($params, $h_id, $p_id)
	{
		$query = DB::select()->from('m_plans');
		$query->where('HTL_ID' ,'=' ,$h_id);
		$query->and_where('PLN_ID', '=', $p_id);
		$result = $query->execute()->as_array();


		$query2 = DB::update('m_categorys');
		$query2->value('CATEGORY_USE_FLG', '0');
		$query2->where_open();
		$query2->where('HTL_ID', '=', $h_id);
		$query2->and_where('CATEGORY_ID', '=', $result[0]['CATEGORY_ID']);
		$query2->where_close();
		$query2->or_where_open();
		$query2->where('HTL_ID', '=', $h_id);
		$query2->and_where('CATEGORY_ID', '=', $result[0]['CATEGORY2_ID']);
		$query2->where_close();
		$query2->or_where_open();
		$query2->where('HTL_ID', '=', $h_id);
		$query2->and_where('CATEGORY_ID', '=', $result[0]['CATEGORY3_ID']);
		$query2->where_close();
		$result = $query2->execute();
	

		if (count($params)>=1) {
			$query3 = DB::update('m_categorys');
			$query3->value('CATEGORY_USE_FLG', '1');
			foreach ($params as $key => $param) {
				if ($key == 0) {
					$query3->where_open();
				}else{
					$query3->or_where_open();
				}

				$query3->where('HTL_ID', '=', $h_id);
				$query3->and_where('CATEGORY_ID', '=', $param['CATEGORY_ID']);
				$query3->where_close();

			}
			
			$result = $query3->execute();
		}
	}


	public function get_category($h_id)
	{
		$query = DB::select()->from('m_categorys');
		$query->where('HTL_ID' ,'=' ,$h_id);
		$query->and_where('CATEGORY_USE_FLG', '=', '1');
		$result = $query->execute()->as_array();
		return $result;
	}

	public function get_using_category($h_id, $la)
	{
		if ($la == 'en') {
			$select = "m_category_ens.CATEGORY_NAME";
		}else if ($la == 'ch') {
			$select = "m_category_chs.CATEGORY_NAME";
		}else if ($la == 'tw') {
			$select = "m_category_chhs.CATEGORY_NAME";
		}else if ($la == 'ko') {
			$select = "m_category_kos.CATEGORY_NAME";
		}else{
			$select = "m_categorys.CATEGORY_NAME";
		}

		$query = DB::select($select, 'm_categorys.CATEGORY_ID')->from('m_categorys');
		if ($la == 'en') {
		  $query->join('m_category_ens', 'INNER');
		  $query->on('m_category_ens.HTL_ID', '=', 'm_categorys.HTL_ID');
		  $query->on('m_category_ens.CATEGORY_ID', '=', 'm_categorys.CATEGORY_ID');
		}else if ($la == 'ch') {
		  $query->join('m_category_chs', 'INNER');
		  $query->on('m_category_chs.HTL_ID', '=', 'm_categorys.HTL_ID');
		  $query->on('m_category_chs.CATEGORY_ID', '=', 'm_categorys.CATEGORY_ID');
		}else if ($la == 'tw') {
		  $query->join('m_category_chhs', 'INNER');
		  $query->on('m_category_chhs.HTL_ID', '=', 'm_categorys.HTL_ID');
		  $query->on('m_category_chhs.CATEGORY_ID', '=', 'm_categorys.CATEGORY_ID');
		}else if ($la == 'ko') {
		  $query->join('m_category_kos', 'INNER');
		  $query->on('m_category_kos.HTL_ID', '=', 'm_categorys.HTL_ID');
		  $query->on('m_category_kos.CATEGORY_ID', '=', 'm_categorys.CATEGORY_ID');
		}

		$query->where('m_categorys.HTL_ID' ,'=' ,$h_id);
		$query->and_where('m_categorys.CATEGORY_USE_FLG', '=', '1');
		$result = $query->execute()->as_array();
		return $result;
	}

	public function get_all_category_data($h_id)
	{
		$sql = "
				SELECT 
					mc.HTL_ID, mc.CATEGORY_ID, mc.CATEGORY_DISP,
					CASE WHEN mc.CATEGORY_USE_FLG = 1 THEN 'checked' ELSE '' END AS 'USE_FLG',
					mc.CATEGORY_NAME   AS 'JA_NAME', mc.CATEGORY_USE_FLG   AS 'JA_USE_FLG',
					mce.CATEGORY_NAME  AS 'EN_NAME', mce.CATEGORY_USE_FLG  AS 'EN_USE_FLG',
					mck.CATEGORY_NAME  AS 'KO_NAME', mck.CATEGORY_USE_FLG  AS 'KO_USE_FLG',
					mcc.CATEGORY_NAME  AS 'CH_NAME', mcc.CATEGORY_USE_FLG  AS 'CH_USE_FLG',
					mchh.CATEGORY_NAME AS 'TW_NAME', mchh.CATEGORY_USE_FLG AS 'TW_USE_FLG'
				FROM m_categorys mc
				INNER JOIN m_category_ens mce
				ON mce.HTL_ID = mc.HTL_ID AND mce.CATEGORY_ID = mc.CATEGORY_ID

				INNER JOIN m_category_kos mck
				ON mck.HTL_ID = mc.HTL_ID AND mck.CATEGORY_ID = mc.CATEGORY_ID

				INNER JOIN m_category_chs mcc
				ON mcc.HTL_ID = mc.HTL_ID AND mcc.CATEGORY_ID = mc.CATEGORY_ID

				INNER JOIN m_category_chhs mchh
				ON mchh.HTL_ID = mc.HTL_ID AND mchh.CATEGORY_ID = mc.CATEGORY_ID

				WHERE mc.HTL_ID = ".$h_id.";
		";

		$query = DB::query($sql);
		$result = $query->execute()->as_array();

		return $result;
	}


	public function all_delete_category($h_id, $c_id)
	{
		$sql = "DELETE ja, en, ch, tw, ko FROM m_categorys ja 
						LEFT JOIN m_category_ens en ON en.HTL_ID = ja.HTL_ID AND en.CATEGORY_ID = ja.CATEGORY_ID
						LEFT JOIN m_category_chs ch ON ch.HTL_ID = ja.HTL_ID AND ch.CATEGORY_ID = ja.CATEGORY_ID
						LEFT JOIN m_category_chhs tw ON tw.HTL_ID = ja.HTL_ID AND tw.CATEGORY_ID = ja.CATEGORY_ID
						LEFT JOIN m_category_kos ko ON ko.HTL_ID = ja.HTL_ID AND ko.CATEGORY_ID = ja.CATEGORY_ID
						WHERE ja.HTL_ID = ".$h_id." AND ja.CATEGORY_ID = ".$c_id.";";

		$query = DB::query($sql);

		$result = $query->execute();
		return $result;
	}

	public function get_count_id($h_id)
	{
		$sql = "SELECT DISTINCT CATEGORY_ID FROM m_categorys WHERE HTL_ID = ".$h_id." ORDER BY CATEGORY_ID DESC LIMIT 1;";

		$query = DB::query($sql);
		$result = $query->execute()->as_array();

		if (count($result) == 0) {
			return 1;
		}
		return $result[0]['CATEGORY_ID'] + 1;
	}



	public function update_category($h_id, $c_id, $kbn, $val)
	{

		if ($kbn == 'ja' || $kbn == 'flg') {
			$query = DB::update('m_categorys');
		}else if ($kbn == 'en') {
			$query = DB::update('m_category_ens');
		}else if ($kbn == 'ch') {
			$query = DB::update('m_category_chs');
		}else if ($kbn == 'tw') {
			$query = DB::update('m_category_chhs');
		}else if ($kbn == 'ko') {
			$query = DB::update('m_category_kos');
		}



		if ($kbn != 'flg') {
			$query->value('CATEGORY_NAME', $val);
		}else{
			$query->value('CATEGORY_USE_FLG', $val);
		}

		$query->where('HTL_ID', '=', $h_id);
		$query->and_where('CATEGORY_ID', '=', $c_id);

		try {
			$result = $query->execute();
		} catch (Exception $e) {
			$result = 'update error';
		}

		return $result;
	}
}