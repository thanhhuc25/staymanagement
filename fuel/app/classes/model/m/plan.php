<?php

class Model_M_Plan extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'PLN_ID',
		'PLN_TYPE',
		'PLN_NAME',
		'TERM_ID_START',
		'TERM_ID_END',
		'PLAN_START',
		'PLAN_END',
		'USE_TIMESALE',
		'TIMESALE_START',
		'TIMESALE_END',
		'DISP_START',
		'DISP_END',
		'PLN_LIMIT_DAY',
		'PLN_LIMIT_TIME',
		'PLN_STAY_LOWER',
		'PLN_STAY_UPPER',
		'DAYTRIP',
		'PLN_ROOM_LOWER',
		'PLN_ROOM_UPPER',
		'ADJUST_TYPE',
		'PLN_TAX',
		'ROOM_DISP_FLG',
		'MEAL_DELIV_FLG',
		'PLN_BRK',
		'PLN_DIN',
		'PLN_CAP_PC',
		'PLN_CAP_PC_LIGHT',
		'PLN_CAP_MOB',
		'PLN_POINTS_FLG',
		'PLN_POINTS',
		'PLN_USE_FLG',
		'CATEGORY_ID',
		'CATEGORY2_ID',
		'CATEGORY3_ID',
		'RANK_ID',
		'DISP_ORDER',
		'UP_DATE',
		'EQUIPMENT',
		'JP_LANG_USE_FLG',
		'CHECK_IN',
		'QUESTION',
		'SORT_NUM',
	);

	protected static $_table_name = 'm_plans';



	public function get_plan_all($option, $htl_id)
	{
		// if ($option == null) {
		// 	$option['sort'] = 'HTL_ID';
		// 	$option['sort_option'] = 'DESC';
		// 	$option['limit'] = 0;
		// 	$option['limit_end'] = 10;
		// }

		if (!isset($option['sort'])) {
				$option['sort'] = 'mp.PLAN_START';
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
		mp.*,
		CASE 
		WHEN en.PLN_EN_NAME != '' THEN 1 ELSE 0 END AS 'en_flg',

		CASE 
		WHEN ch.PLN_CH_NAME != '' THEN 1 ELSE 0 END AS 'ch_flg',

		CASE 
		WHEN chh.PLN_CHH_NAME != '' THEN 1 ELSE 0 END AS 'chh_flg',

		CASE 
		WHEN ko.PLN_KO_NAME != '' THEN 1 ELSE 0 END AS 'ko_flg'


		FROM m_plans mp
		LEFT JOIN m_plan_ens en
		ON en.HTL_ID = mp.HTL_ID AND en.PLN_ID = mp.PLN_ID
		LEFT JOIN m_plan_chs ch
		ON ch.HTL_ID = mp.HTL_ID AND ch.PLN_ID = mp.PLN_ID
		LEFT JOIN m_plan_chhs chh 
		ON chh.HTL_ID = mp.HTL_ID AND chh.PLN_ID = mp.PLN_ID
		LEFT JOIN m_plan_kos ko
		ON ko.HTL_ID = mp.HTL_ID AND ko.PLN_ID = mp.PLN_ID
		
		WHERE mp.HTL_ID=".$htl_id.$option['where']." ORDER BY ".$option['sort']. " ".$option['sort_option']." LIMIT ".$option['limit']." OFFSET ".$option['offset'].";";



		$query = DB::query($sql);
		$result =$query->execute()->as_array();
		return $result;
	}


	public function get_plan_frontlist($htl_id, $num, $start, $end, $gender, $stay, $room_num , $flg, $rtype_param, $language, $page, $category_id)
	{
		if (!$sort = Session::get('sort_front_plan')) {
		$sort['id'] = '1';
		$sort['sql'] =  " ORDER BY PAYMENT ASC";
		Session::set('sort_front_plan',$sort);
		}

		$staynum = $stay -1; 
		if ($flg == 1) {
			$end = date('Y-m-d', strtotime($start." +". $staynum ." day"));
		}
		$sql = "SELECT 
			(CASE  
				WHEN mpr.PLN_CHG_PERSON".$num." + mpe.PLN_CHG_EXCEPTION".$num." >= 0 
				THEN mpr.PLN_CHG_PERSON".$num." + mpe.PLN_CHG_EXCEPTION".$num." 
				ELSE  mpr.PLN_CHG_PERSON".$num." 
			END) as PAYMENT , mpr.PLN_CHG_PERSON".$num." as basicPay,                
      		mpe.EXCEPTIONDAY as MPDAY,
			mp.SORT_NUM,

			mp.CATEGORY_ID,mp.CATEGORY2_ID,mp.CATEGORY3_ID,mp.CATEGORY4_ID,
			mp.CATEGORY5_ID,mp.CATEGORY6_ID,mp.CATEGORY7_ID,mp.CATEGORY8_ID,
			mp.HTL_ID, mp.PLN_ID, mpr.TYPE_ID, mp.PLN_NAME, mp.PLN_CAP_PC_LIGHT, mr.TYPE_NAME, mpr.PLN_CHG_PERSON1, mpr.PLN_CHG_PERSON2, mpr.PLN_CHG_PERSON3, mpr.PLN_CHG_PERSON4, mpr.PLN_CHG_PERSON5, mpr.PLN_CHG_PERSON6 ,
			mr.RM_OPTION
			from m_plans mp
			INNER JOIN m_plan_rtypes mpr
			ON mpr.HTL_ID = mp.HTL_ID AND mpr.PLN_ID = mp.PLN_ID
			INNER JOIN m_rtypes mr
			ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
			LEFT JOIN m_plan_exceptiondays mpe
			ON mpe.HTL_ID = mpr.HTL_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.EXCEPTIONDAY BETWEEN '".$start."' AND '".$end."'

			[JOIN LANGUAGE]
			[JOIN LANGUAGE2]

			WHERE mp.HTL_ID = ".$htl_id."
			/*basic*/
			AND mp.PLN_USE_FLG = 1 
			AND mp.DISP_START <= CURDATE() AND mp.DISP_END >= CURDATE()
			AND mr.RM_USE_FLG = 1
			AND mpr.PLN_CHG_PERSON".$num." != 0
			/*option*/
			/*AND mp.PLAN_START <= '".$start."' AND mp.PLAN_END >= '".$start."'*/
			AND mp.PLAN_START <= '".$end."' AND mp.PLAN_END >= '".$start."'

			AND mpr.PLN_MIN <= ".$num." AND mpr.PLN_MAX >= ".$num."
			AND mp.PLN_STAY_LOWER <= ".$stay."  AND mp.PLN_STAY_UPPER >= ".$stay."

			[CATEGORY]
			";

		if ($gender == '2') {
			$sql .= " AND mr.GENDER_FLG = 2 ";
		}

		if ($rtype_param != null) {
			$sql .= " AND mr.TYPE_ID =".$rtype_param['TYPE_ID'];
			$sql .= " AND mp.PLN_ID !=".$rtype_param['PLN_ID'];
		}

		$sql .= $sort['sql'];

		$sql .= ";";

	
		if ($language == 'en') {
			$opt1 = " mp_en.PLN_EN_NAME AS 'PLN_NAME', mp_en.PLN_CAP_PC_LIGHT, ";
			$opt2 = " INNER JOIN m_plan_ens  mp_en ON mp_en.HTL_ID = mp.HTL_ID AND mp_en.PLN_ID = mp.PLN_ID AND mp_en.PLN_EN_NAME != '' ";
			$opt3 = " mr_en.TYPE_NAME, ";
			$opt4 = " INNER JOIN m_rtype_ens mr_en ON mr_en.HTL_ID = mp.HTL_ID AND mr_en.TYPE_ID = mr.TYPE_ID ";
		}else if ($language == 'ch') {
			$opt1 = " mp_ch.PLN_CH_NAME AS 'PLN_NAME', mp_ch.PLN_CAP_PC_LIGHT, ";
			$opt2 = " INNER JOIN m_plan_chs  mp_ch ON mp_ch.HTL_ID = mp.HTL_ID AND mp_ch.PLN_ID = mp.PLN_ID  AND mp_ch.PLN_CH_NAME != '' ";
			$opt3 = " mr_ch.TYPE_NAME, ";
			$opt4 = " INNER JOIN m_rtype_chs mr_ch ON mr_ch.HTL_ID = mp.HTL_ID AND mr_ch.TYPE_ID = mr.TYPE_ID ";
		}else if ($language == 'tw') {
			$opt1 = " mp_tw.PLN_CHH_NAME AS 'PLN_NAME', mp_tw.PLN_CAP_PC_LIGHT, ";
  			$opt2 = " INNER JOIN m_plan_chhs mp_tw ON mp_tw.HTL_ID = mp.HTL_ID AND mp_tw.PLN_ID = mp.PLN_ID AND mp_tw.PLN_CHH_NAME != '' ";
			$opt3 = " mr_tw.TYPE_NAME, ";
			$opt4 = " INNER JOIN m_rtype_chhs mr_tw ON mr_tw.HTL_ID = mp.HTL_ID AND mr_tw.TYPE_ID = mr.TYPE_ID ";
		}else if ($language == 'ko') {
			$opt1 = " mp_ko.PLN_KO_NAME AS 'PLN_NAME', mp_ko.PLN_CAP_PC_LIGHT, ";
			$opt2 = " INNER JOIN m_plan_kos  mp_ko ON mp_ko.HTL_ID = mp.HTL_ID AND mp_ko.PLN_ID = mp.PLN_ID  AND mp_ko.PLN_KO_NAME != '' ";
			$opt3 = " mr_ko.TYPE_NAME, ";
			$opt4 = " INNER JOIN m_rtype_kos mr_ko ON mr_ko.HTL_ID = mp.HTL_ID AND mr_ko.TYPE_ID = mr.TYPE_ID ";
		}else{
			$opt1 = "mp.PLN_NAME, mp.PLN_CAP_PC_LIGHT,";
			$opt2 = "";
			$opt3 = " mr.TYPE_NAME, ";
			$opt4 = "";
		}

		if ($category_id != null) {
			$opt5 = " AND (mp.CATEGORY_ID  = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY2_ID = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY3_ID = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY4_ID = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY5_ID = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY6_ID = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY7_ID = ".$category_id; 
			$opt5 .= "  OR mp.CATEGORY8_ID = ".$category_id;
			$opt5 .= ") "; 		
		}else{
			$opt5 = "";
		}

		$sql = str_replace(array('mp.PLN_NAME, mp.PLN_CAP_PC_LIGHT,' , '[JOIN LANGUAGE]', 'mr.TYPE_NAME,', '[JOIN LANGUAGE2]', '[CATEGORY]'), array($opt1,$opt2,$opt3,$opt4,$opt5), $sql);

		$query = DB::query($sql);
		$result = $query->execute()->as_array();
		//error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($sql, true) . "\n");

		$plan_data = array();
		$rsv_list = array();
   		$payment_list = array();
    	$payment_sum_list = array();

		foreach ($result as $key => $value) {
			$payment_sum_list[$value['PLN_ID']][$value['TYPE_ID']]['BASIC'] = $value['basicPay'];
			if ($value['MPDAY'] != null && $value['MPDAY'] != '') {
				$payment_sum_list[$value['PLN_ID']][$value['TYPE_ID']][$value['MPDAY']] = $value['PAYMENT'];
			}

			if ($value['PAYMENT'] == null || $value['PAYMENT'] == '') {
				$payment = $value['basicPay'];
			}else{
				$payment = $value['PAYMENT'];
			}

			/* プランデータのリストを作成。各プランの配列の中に部屋タイプリストを格納 */
			if (isset($plan_data[$value['PLN_ID']])) {
				$plan_data[$value['PLN_ID']]['RTYPES'][$value['TYPE_ID']] = array(
					'TYPE_ID' => $value['TYPE_ID'],
					'TYPE_NAME' => $value['TYPE_NAME'],
					'PAYMENT' => $payment,
					'RM_OPTION' => $value['RM_OPTION'],
					);
			
			
				if ($plan_data[$value['PLN_ID']]['RTYPES'][$value['TYPE_ID']]['PAYMENT'] > $value['PAYMENT'] && $value['PAYMENT']!=null && $value['PAYMENT'] != '') {
					$plan_data[$value['PLN_ID']]['RTYPES'][$value['TYPE_ID']]['PAYMENT'] = $value['PAYMENT'];
				}
			}else{
				$plan_data[$value['PLN_ID']] = $value;
				$plan_data[$value['PLN_ID']]['RTYPES'][$value['TYPE_ID']] = array(
					'TYPE_ID' => $value['TYPE_ID'],
					'TYPE_NAME' => $value['TYPE_NAME'],
					'PAYMENT' => $payment,
					'RM_OPTION' => $value['RM_OPTION'],
					);

				$plan_data[$value['PLN_ID']]['RTYPES'][$value['TYPE_ID']]['PAYMENT'] = $value['PAYMENT'];
			}

				
			if ($value['MPDAY'] != null && $payment != 0) 	{
				$payment_list[$value['PLN_ID']][$value['TYPE_ID']][$value['MPDAY']] = $payment;
			}
			$payment_list[$value['PLN_ID']][$value['TYPE_ID']]['BASIC_PAY'] = $value['basicPay'];
		} //foreach end


		if ($flg == 1) { //宿泊日が決まっている場合
			$date = date('Y-m-d', strtotime($start." +".$stay." day"));
			$check_flg = 1;
		}else { //未定の場合
			$date = date('Y-m-d' ,strtotime("+1 day"));
			// $date2 = date('Y-m-d', strtotime($end));
			$diff2 = (strtotime($end) - strtotime($start)) / ( 60 * 60 * 24);
			$check_flg = 2;
		}

		$diff = (strtotime($date) - strtotime($start)) / ( 60 * 60 * 24);
		$stock = Model_M_Plan_Rtype::forge();
		$cnt = 0;
		/*すべてのプラン ・ 部屋から在庫が確保出来るかチェックする　*/
		foreach ($plan_data as $key => $value) {
			$cnt ++;
				
			foreach ($value['RTYPES'] as $k => $val) {
				/*宿泊日分ループする　*/
				if ($flg == 0) {
					for ($s=0; $s < $diff2; $s++) { 
						  $period = date('Y-m-d', strtotime($start . '+' . $s . 'days'));

						  $stock_data = $stock->get_zaiko_one_day($value['HTL_ID'],$value['PLN_ID'],$value['TYPE_ID'],$period);
							if ($stock_data['RPR_STOP_FLG'] === '0') { 
								$cnt_flg = 0;
							}else if($stock_data['RPR_STOP_FLG'] === '1'){
								$cnt_flg = 1;
							}else{
								if ($stock_data['MRR_STOP_FLG'] != '1') { // null or 0
									$cnt_flg = 0;
								}else{
									$cnt_flg = 1;
								}
							}

							if ($cnt_flg == 0) {
								$zaiko = $stock_data['RM_NUM'] + $stock_data['ZOUGEN_NUM'] - $stock_data['URIAGE'];
							}else{
								$zaiko = 0;
							}

						  if ($zaiko > 0 && $zaiko >= $room_num) {
						  	$plan_data[$key]['RTYPES'][$k]['STOP_FLG'] = 0;
							if (isset($payment_list[$key][$k][$period])) {
								// unset($payment_list[$key][$k][$period]);
								if (count($payment_list[$key][$k]) >= ($diff + 1) ) {  
								//1ヶ月分の変動料金＋基本料金　の料金データがあれば基本料金を抜いて最小料金を求める	
									unset($payment_list[$key][$k]['BASIC_PAY']);
								}
								$plan_data[$key]['RTYPES'][$k]['PAYMENT'] = min(array_values($payment_list[$key][$k]));
                			}
						  }else{
						  	if ( !isset( $plan_data[$key]['RTYPES'][$k]['STOP_FLG'] ) || $plan_data[$key]['RTYPES'][$k]['STOP_FLG'] == 1  ) {
						  		$plan_data[$key]['RTYPES'][$k]['STOP_FLG'] = 1;
						  	}
						  }
					}
				}else{
					$sum = 0;
					for($i = 0; $i < $diff; $i++) {
					  	$period = date('Y-m-d', strtotime($start . '+' . $i . 'days'));
					  	if (isset($payment_sum_list[$key][$k][$period])) {
							if($payment_sum_list[$key][$k][$period] == 0){
								$plan_data[$key]['RTYPES'][$k]['STOP_FLG'] = 1;
							}
					  		$sum += $payment_sum_list[$key][$k][$period];
					  	}else{
					  		$sum += $payment_sum_list[$key][$k]['BASIC'];
					  	}

						$stock_data = $stock->get_zaiko_one_day($value['HTL_ID'],$value['PLN_ID'],$k,$period);

						if ($stock_data['RPR_STOP_FLG'] === '0') { 
							$cnt_flg = 0;
						}else if($stock_data['RPR_STOP_FLG'] === '1'){
							$cnt_flg = 1;
						}else{
							if ($stock_data['MRR_STOP_FLG'] != '1') { // null or 0
								$cnt_flg = 0;
							}else{
								$cnt_flg = 1;
							}
						}

						if ($cnt_flg == 0) {
							$zaiko = $stock_data['RM_NUM'] + $stock_data['ZOUGEN_NUM'] - $stock_data['URIAGE'];
						}else{
							$zaiko = 0;
							$plan_data[$key]['RTYPES'][$k]['STOP_FLG'] = 1;
						}

						if ($zaiko <= 0 || $zaiko < $room_num ) {			//必要部屋数より下回る場合フラグを立てる
					  		$plan_data[$key]['RTYPES'][$k]['STOP_FLG'] = 1;
					  	}else{
					  		if ( !isset( $plan_data[$key]['RTYPES'][$k]['STOP_FLG'] ) || $plan_data[$key]['RTYPES'][$k]['STOP_FLG'] == 0  ) {
								$plan_data[$key]['RTYPES'][$k]['STOP_FLG'] = 0;
					  		}
					  	}
					}
					$plan_data[$key]['RTYPES'][$k]['TOTAL_PAY'] = $sum;
				}
				if (isset( $plan_data[$key]['RTYPES'][$k]['STOP_FLG'] ) && $plan_data[$key]['RTYPES'][$k]['STOP_FLG'] == 1 ) {			//フラグが立っている部屋を削除
					unset($plan_data[$key]['RTYPES'][$k]);
				}
			}
		}
		
		return $plan_data;
	}



	public function get_plan_one($htl_id, $pln_id)
	{
		$query = DB::query("
			SELECT *,
			mp.PLN_CAP_PC_LIGHT as JP_CAP_PC_LIGHT,
			mpe.PLN_CAP_PC_LIGHT as EN_CAP_PC_LIGHT,
			mpc.PLN_CAP_PC_LIGHT as CH_CAP_PC_LIGHT,
			mpcc.PLN_CAP_PC_LIGHT as CHH_CAP_PC_LIGHT,
			mpk.PLN_CAP_PC_LIGHT as KO_CAP_PC_LIGHT,
			mp.CATEGORY_ID as CATEGORY_ID1,
			mc.CATEGORY_NAME as CATEGORY_NAME1,
			mc.CATEGORY_USE_FLG as CATEGORY_FLG1,
			mc2.CATEGORY_NAME as CATEGORY_NAME2,
			mc2.CATEGORY_USE_FLG as CATEGORY_FLG2,
			mc3.CATEGORY_NAME as CATEGORY_NAME3,
			mc3.CATEGORY_USE_FLG as CATEGORY_FLG3

			FROM m_plans mp 
			LEFT JOIN m_plan_chs mpc ON mp.HTL_ID = mpc.HTL_ID AND mp.PLN_ID = mpc.PLN_ID 
			LEFT JOIN m_plan_chhs mpcc ON mp.HTL_ID = mpcc.HTL_ID AND mp.PLN_ID = mpcc.PLN_ID
			LEFT JOIN m_plan_ens mpe ON mp.HTL_ID = mpe.HTL_ID AND mp.PLN_ID = mpe.PLN_ID
			LEFT JOIN m_plan_kos mpk ON mp.HTL_ID = mpk.HTL_ID AND mp.PLN_ID = mpk.PLN_ID
			LEFT JOIN m_plan_exceptiondays mpex ON mp.HTL_ID = mpex.HTL_ID AND mp.PLN_ID = mpex.PLN_ID
			LEFT JOIN m_categorys mc ON mc.CATEGORY_ID = mp.CATEGORY_ID AND mc.HTL_ID = mp.HTL_ID AND mc.CATEGORY_USE_FLG = '1'
			LEFT JOIN m_categorys mc2 ON mc2.CATEGORY_ID = mp.CATEGORY2_ID AND mc2.HTL_ID = mp.HTL_ID	AND mc2.CATEGORY_USE_FLG = '1'			
			LEFT JOIN m_categorys mc3 ON mc3.CATEGORY_ID = mp.CATEGORY3_id AND mc3.HTL_ID = mp.HTL_ID AND mc3.CATEGORY_USE_FLG = '1'

			WHERE mp.HTL_ID = ".$htl_id." AND mp.PLN_ID = ".$pln_id."
			;
			");
		$result =$query->execute()->as_array();

		if (count($result) == 0) {
			Response::redirect('plan');
		}
		return $result[0];
	}



	public function delete_plan($params)
	{
		$query = "DELETE FROM m_plans WHERE ";

		foreach ($params as $key => $param) {
			if ($key == 0) {
				$query .= "(HTL_ID=".$param[0]." AND PLN_ID=".$param[1].")";	
			}else{
				$query .= " OR (HTL_ID=".$param[0]." AND PLN_ID=".$param[1].")";
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
				UPDATE m_plans SET SORT_NUM=".$param['sort_val']." WHERE HTL_ID=".$param['htl_id']." AND PLN_ID=".$param['pln_id']."
				");
		$result =$query->execute();
	}



	public function plan_insert($htl_id)
	{

		$sql = "SELECT PLN_ID FROM m_plans WHERE HTL_ID = ".$htl_id." ORDER BY PLN_ID DESC LIMIT 1";

		$query = DB::query($sql);
		$result =$query->execute()->as_array();

		if (count($result) == 0) {
			$pln_id = 1;
		}else{
			$pln_id = $result[0]['PLN_ID'] + 1;
		}


		$query = DB::insert('m_plans')->set(array(
				'HTL_ID' => $htl_id,
				'PLN_ID' => $pln_id,
				'PLN_NAME' => '新規プラン',
				// 'PLAN_START' => $param['PLAN_START'],
				// 'PLAN_END' => $param['PLAN_END'],
				// 'DISP_START' => $param['DISP_START'],
				// 'DISP_END' => $param['DISP_END'],
				// 'PLN_STAY_LOWER' => $param['PLN_STAY_LOWER'],
				// 'PLN_STAY_UPPER' => $param['PLN_STAY_UPPER'],
				// 'PLN_CAP_PC_LIGHT' => $param['PLN_CAP_PC_LIGHT'],
				// 'PLN_LIMIT_TIME' => $param['PLN_LIMIT_TIME'],
				// 'CATEGORY_ID' => $param['CATEGORY_ID'],
				// 'CATEGORY2_ID' => $param['CATEGORY2_ID'],
				// 'CATEGORY3_ID' => $param['CATEGORY3_ID'],
				'PLN_USE_FLG' => '0',
				// 'CHECK_IN' => $param['CHECK_IN'],

				// 'PLN_NAME' => $param['PLN_NAME'],
				// 'PLAN_START' => $param['PLAN_START'],
				// 'PLAN_END' => $param['PLAN_END'],
				// 'DISP_START' => $param['DISP_START'],
				// 'DISP_END' => $param['DISP_END'],
				// 'PLN_STAY_LOWER' => $param['PLN_STAY_LOWER'],
				// 'PLN_STAY_UPPER' => $param['PLN_STAY_UPPER'],
				// 'PLN_CAP_PC_LIGHT' => $param['PLN_CAP_PC_LIGHT'],
				// 'PLN_LIMIT_TIME' => $param['PLN_LIMIT_TIME'],
				// 'CATEGORY_ID' => $param['CATEGORY_ID'],
				// 'CATEGORY2_ID' => $param['CATEGORY2_ID'],
				// 'CATEGORY3_ID' => $param['CATEGORY3_ID'],
				// 'PLN_USE_FLG' => $param['PLN_USE_FLG'],
				// 'CHECK_IN' => $param['CHECK_IN'],
			));

			$result = $query->execute();
			return $pln_id;
	}

	public function plan_save($param, $h_id, $p_id)
	{
		$query = DB::update('m_plans');
		
		$query->join('m_plan_kos', 'left');
		$query->on('m_plan_kos.HTL_ID', '=', 'm_plans.HTL_ID');
		$query->on('m_plan_kos.PLN_ID', '=', 'm_plans.PLN_ID');
		
		$query->join('m_plan_ens', 'left');
		$query->on('m_plan_ens.HTL_ID', '=', 'm_plans.HTL_ID');
		$query->on('m_plan_ens.PLN_ID', '=', 'm_plans.PLN_ID');
		
		$query->join('m_plan_chs', 'left');
		$query->on('m_plan_chs.HTL_ID', '=', 'm_plans.HTL_ID');
		$query->on('m_plan_chs.PLN_ID', '=', 'm_plans.PLN_ID');

		$query->join('m_plan_chhs', 'left');
		$query->on('m_plan_chhs.HTL_ID', '=', 'm_plans.HTL_ID');
		$query->on('m_plan_chhs.PLN_ID', '=', 'm_plans.PLN_ID');

		$query->value('m_plans.PLN_NAME',$param['PLN_NAME']);
		$query->value('m_plans.PLAN_START',$param['PLAN_START']);
		$query->value('m_plans.PLAN_END',$param['PLAN_END']);
		$query->value('m_plans.DISP_START',$param['DISP_START']);
		$query->value('m_plans.DISP_END',$param['DISP_END']);
		$query->value('m_plans.PLN_USE_FLG', $param['PLN_USE_FLG']);
		$query->value('m_plans.PLN_STAY_LOWER',$param['PLN_STAY_LOWER']);
		$query->value('m_plans.PLN_STAY_UPPER',$param['PLN_STAY_UPPER']);
		$query->value('m_plans.PLN_CAP_PC_LIGHT',$param['PLN_CAP_PC_LIGHT']);
		$query->value('m_plans.PLN_LIMIT_TIME',$param['PLN_LIMIT_TIME']);
		$query->value('m_plans.PLN_LIMIT_DAY',$param['PLN_LIMIT_DAY']);
		$query->value('m_plans.CATEGORY_ID',$param['CATEGORY_ID']);
		$query->value('m_plans.CATEGORY2_ID',$param['CATEGORY2_ID']);
		$query->value('m_plans.CATEGORY3_ID',$param['CATEGORY3_ID']);						
		$query->value('m_plans.CATEGORY4_ID',$param['CATEGORY4_ID']);						
		$query->value('m_plans.CATEGORY5_ID',$param['CATEGORY5_ID']);						
		$query->value('m_plans.CATEGORY6_ID',$param['CATEGORY6_ID']);						
		$query->value('m_plans.CATEGORY7_ID',$param['CATEGORY7_ID']);						
		$query->value('m_plans.CATEGORY8_ID',$param['CATEGORY8_ID']);						
		$query->value('m_plans.CHECK_IN',$param['CHECK_IN']);

		$query->value('m_plan_kos.PLN_KO_NAME', $param['PLN_NAME_KO']);
		$query->value('m_plan_ens.PLN_EN_NAME', $param['PLN_NAME_EN']);
		$query->value('m_plan_chs.PLN_CH_NAME', $param['PLN_NAME_CH']);
		$query->value('m_plan_chhs.PLN_CHH_NAME', $param['PLN_NAME_CHH']);

		$query->value('m_plan_kos.PLN_CAP_PC_LIGHT', $param['PLN_CAP_PC_LIGHT_KO']);
		$query->value('m_plan_ens.PLN_CAP_PC_LIGHT', $param['PLN_CAP_PC_LIGHT_EN']);
		$query->value('m_plan_chs.PLN_CAP_PC_LIGHT', $param['PLN_CAP_PC_LIGHT_CH']);
		$query->value('m_plan_chhs.PLN_CAP_PC_LIGHT', $param['PLN_CAP_PC_LIGHT_CHH']);
		$query->where('m_plans.HTL_ID',$h_id);
		$query->and_where('m_plans.PLN_ID',$p_id);

		$result = $query->execute();
		return $result;
	}


	public function change_sale_flg($flg, $params)
	{
		$query = "UPDATE m_plans SET PLN_USE_FLG=".$flg." WHERE ";

		foreach ($params as $key => $param) {
			if ($key == 0) {
				$query .= "(HTL_ID=".$param[0]." AND PLN_ID=".$param[1].")";	
			}else{
				$query .= " OR (HTL_ID=".$param[0]." AND PLN_ID=".$param[1].")";
			}
			
		}

		$query .=";";
		$dao = DB::query($query);
		$result =$dao->execute();
	}

	public function get_count($option, $htl_id)
	{

		$query = "SELECT * FROM m_plans WHERE HTL_ID=".$htl_id;

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
