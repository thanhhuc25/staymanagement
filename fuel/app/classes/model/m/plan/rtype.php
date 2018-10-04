<?php

class Model_M_Plan_Rtype extends Model_Crud
{
	protected static $_properties = array(
      'HTL_ID',
      'PLN_ID',
      'TYPE_ID',
      'RM_NUM',
      'PLN_MIN',
      'PLN_MAX',
      'PLN_MIN_CHARGE',
      'PLN_MAX_CHARGE',
      'PLN_CHG_PERSON1',
      'PLN_CHG_PERSON2',
      'PLN_CHG_PERSON3',
      'PLN_CHG_PERSON4',
      'PLN_CHG_PERSON5',
      'PLN_CHG_PERSON6',
      'PLN_FLG_WEEK0',
      'PLN_FLG_WEEK1',
      'PLN_FLG_WEEK2',
      'PLN_FLG_WEEK3',
      'PLN_FLG_WEEK4',
      'PLN_FLG_WEEK5',
      'PLN_FLG_WEEK6',
      'PLN_CHG_WEEK0',
      'PLN_CHG_WEEK1',
      'PLN_CHG_WEEK2',
      'PLN_CHG_WEEK3',
      'PLN_CHG_WEEK4',
      'PLN_CHG_WEEK5',
      'PLN_CHG_WEEK6',
      'PLN_FLG_CHILD1',
      'PLN_FLG_CHILD2',
      'PLN_FLG_CHILD3',
      'PLN_FLG_CHILD4',
      'PLN_FLG_CHILD5',
      'PLN_FLG_CHILD6',
      'PLN_VAL_CHILD1',
      'PLN_VAL_CHILD2',
      'PLN_VAL_CHILD3',
      'PLN_VAL_CHILD4',
      'PLN_VAL_CHILD5',
      'PLN_VAL_CHILD6',
      'PLN_CAL_CHILD1',
      'PLN_CAL_CHILD2',
      'PLN_CAL_CHILD3',
      'PLN_CAL_CHILD4',
      'PLN_CAL_CHILD5',
      'PLN_CAL_CHILD6',
      'PLN_CNT_CHILD1',
      'PLN_CNT_CHILD2',
      'PLN_CNT_CHILD3',
      'PLN_CNT_CHILD4',
      'PLN_CNT_CHILD5',
      'PLN_CNT_CHILD6',
      'DISP_ORDER',
      'UP_DATE',
	);

	protected static $_table_name = 'm_plan_rtypes';


  public function get_plan_allrtype($h_id, $p_id)
  {
    $query = DB::query("
      SELECT 
      mpr.HTL_ID, mpr.PLN_ID, mpr.TYPE_ID, mpr.PLN_MIN, mpr.PLN_MAX, mpr.PLN_CHG_PERSON1, mpr.PLN_CHG_PERSON2, mpr.PLN_CHG_PERSON3, mpr.PLN_CHG_PERSON4, mpr.PLN_CHG_PERSON5, mpr.PLN_CHG_PERSON6,
      mr.TYPE_NAME, mr.CAP_MIN, mr.CAP_MAX

      FROM m_plan_rtypes mpr
      INNER JOIN m_rtypes mr ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
     
      WHERE mpr.HTL_ID = ".$h_id." AND mpr.PLN_ID = ".$p_id."
      ;");

    $result = $query->execute()->as_array();
    // if (count($result) == 0) {
    //   Response::redirect('price');
    // }
    return $result;
  
  }




  /*neppan002で使用  */
  public function get_allplan_allrtype($h_id)
  {
    $query = DB::select()->from('m_plan_rtypes');

    $query->join('m_plans', 'INNER');
    $query->on('m_plans.HTL_ID', '=', 'm_plan_rtypes.HTL_ID');
    $query->and_on('m_plans.PLN_ID', '=', 'm_plan_rtypes.PLN_ID');

    $query->join('m_rtypes', 'INNER');
    $query->on('m_rtypes.HTL_ID', '=', 'm_plan_rtypes.HTL_ID');
    $query->and_on('m_rtypes.TYPE_ID', '=', 'm_plan_rtypes.TYPE_ID');

    $query->where('m_plan_rtypes.HTL_ID', '=', $h_id);

    $result = $query->execute()->as_array();
    return $result;
  }



  public function get_unuse_rtype($h_id, $p_id)
  {
    $sql = "SELECT  TYPE_NAME, CONCAT(HTL_ID,'_',TYPE_ID)as HtlTypeID FROM m_rtypes WHERE  HTL_ID=".$h_id;
    if ($p_id != null) {
     $sql .= " AND TYPE_ID NOT IN( SELECT Distinct(TYPE_ID) FROM m_plan_rtypes WHERE HTL_ID = ".$h_id." AND PLN_ID = ".$p_id." );";
    }

    $query = DB::query($sql);
    $result = $query->execute()->as_array();

    return $result;
  }

  /* tema010で使用 */
  public function get_allplan_rtype($h_id, $t_id)
  {
      $query = DB::select()->from('m_plan_rtypes');
      $query->where('m_plan_rtypes.HTL_ID', '=', $h_id);
      $query->and_where('m_plan_rtypes.TYPE_ID', '=', $t_id);
      $query->join('m_rtypes','INNER');
      $query->on('m_rtypes.HTL_ID', '=', 'm_plan_rtypes.HTL_ID');
      $query->and_on('m_rtypes.TYPE_ID', '=', 'm_plan_rtypes.TYPE_ID');

      $query->join('m_plans','INNER');
      $query->on('m_plans.HTL_ID', '=', 'm_plan_rtypes.HTL_ID');
      $query->and_on('m_plans.PLN_ID', '=', 'm_plan_rtypes.PLN_ID');

      $result = $query->execute()->as_array();
      return $result;
  }



  public function get_use_rtype($h_id, $p_id)
  {
      $query = DB::select()->from('m_plan_rtypes');
      $query->where('m_plan_rtypes.HTL_ID', '=', $h_id);
      $query->and_where('m_plan_rtypes.PLN_ID', '=', $p_id);
      $query->join('m_rtypes','INNER');
      $query->on('m_rtypes.HTL_ID', '=', 'm_plan_rtypes.HTL_ID');
      $query->and_on('m_rtypes.TYPE_ID', '=', 'm_plan_rtypes.TYPE_ID');

      $result = $query->execute()->as_array();
      return $result;
  }


  public function get_plan_rtype($h_id, $p_id, $t_id, $date, $language)
  {   
      $sql = "
          SELECT * FROM m_plan_rtypes mpr
          INNER JOIN m_plans mp 
          ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID
          INNER JOIN m_rtypes mr
          ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID

          LEFT JOIN m_plan_exceptiondays mpe
          ON mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.EXCEPTIONDAY = '".$date."' 

          [JOIN LANGUAGE]
          WHERE mpr.HTL_ID = ".$h_id."
          AND mpr.PLN_ID = ".$p_id."
          AND mpr.TYPE_ID = ".$t_id."
          ;
      ";

    if ($language == 'en') {
      $opt1 = "*, mp_en.PLN_EN_NAME AS 'PLN_NAME', mp_en.PLN_CAP_PC_LIGHT, mr_en.TYPE_NAME ";
      $opt2 = " INNER JOIN m_plan_ens  mp_en ON mp_en.HTL_ID = mp.HTL_ID AND mp_en.PLN_ID = mp.PLN_ID 
                INNER JOIN m_rtype_ens mr_en ON mr_en.HTL_ID = mp.HTL_ID AND mr_en.TYPE_ID = mr.TYPE_ID ";
    }else if ($language == 'ch') {
      $opt1 = "*, mp_ch.PLN_CH_NAME AS 'PLN_NAME', mp_ch.PLN_CAP_PC_LIGHT, mr_ch.TYPE_NAME ";
      $opt2 = " INNER JOIN m_plan_chs  mp_ch ON mp_ch.HTL_ID = mp.HTL_ID AND mp_ch.PLN_ID = mp.PLN_ID 
                INNER JOIN m_rtype_chs mr_ch ON mr_ch.HTL_ID = mp.HTL_ID AND mr_ch.TYPE_ID = mr.TYPE_ID ";
    }else if ($language == 'tw') {
      $opt1 = "*, mp_tw.PLN_CHH_NAME AS 'PLN_NAME', mp_tw.PLN_CAP_PC_LIGHT, mr_tw.TYPE_ID ";
      $opt2 = " INNER JOIN m_plan_chhs mp_tw ON mp_tw.HTL_ID = mp.HTL_ID AND mp_tw.PLN_ID = mp.PLN_ID 
                INNER JOIN m_rtype_chhs mr_tw ON mr_tw.HTL_ID = mp.HTL_ID AND mr_tw.TYPE_ID = mr.TYPE_ID ";
    }else if ($language == 'ko') {
      $opt1 = "*, mp_ko.PLN_KO_NAME AS 'PLN_NAME', mp_ko.PLN_CAP_PC_LIGHT, mr_ko.TYPE_ID ";
      $opt2 = " INNER JOIN m_plan_kos  mp_ko ON mp_ko.HTL_ID = mp.HTL_ID AND mp_ko.PLN_ID = mp.PLN_ID 
                INNER JOIN m_rtype_kos mr_ko ON mr_ko.HTL_ID = mp.HTL_ID AND mr_ko.TYPE_ID = mr.TYPE_ID ";
    }else{
      $opt1 = "*";
      $opt2 = "";
    }

    $sql = str_replace(array('*' , '[JOIN LANGUAGE]'), array($opt1,$opt2), $sql);


      $query = DB::query($sql);

      $result = $query->execute()->as_array();

      if (count($result) == 0) {
        return 0;
      }


      return $result[0];
  }

  public function get_zaiko()
  {
    $query = DB::query("
      SELECT 
      mpr.PLN_ID, mpr.HTL_ID,
      mr.HTL_ID, mr.TYPE_ID, mr.TYPE_NAME, mr.CAP_MIN, mr.CAP_MAX, 
      mpe.EXCEPTIONDAY, mpe.PLN_CHG_EXCEPTION1, mpe.PLN_CHG_EXCEPTION2, mpe.PLN_CHG_EXCEPTION3, mpe.PLN_CHG_EXCEPTION4, mpe.PLN_CHG_EXCEPTION5, mpe.PLN_CHG_EXCEPTION6, mpe.NUM

      FROM m_plan_rtypes mpr
      INNER JOIN m_rtypes mr ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
      LEFT JOIN m_plan_exceptiondays mpe
      ON mpe.HTL_ID = mpr.HTL_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.PLN_ID = mpr.PLN_ID

            
      WHERE mpr.HTL_ID = ".$htl_id." AND mpr.PLN_ID = ".$p_id."
      ;");

    $result = $query->execute()->as_array();
    if (count($result) == 0) {
      Response::redirect('price');
    }
    return $result;
  
  }


  /*

  フロント　プラン詳細画面のプランのカレンダー表示に使用する、1日毎にデータを取得する。

  */
  public function get_plan_rtype_one_price_stock($param)
  {
    $sql = "
      SELECT 
      mp.PLN_LIMIT_DAY, mp.PLN_LIMIT_TIME, mp.PLAN_START, mp.PLAN_END, mp.DISP_START, mp.DISP_END,
      tr.RSV_STS,
      mr.RM_NUM,
      mpr.PLN_MIN, mpr.PLN_MAX, mpr.PLN_CHG_PERSON1,mpr.PLN_CHG_PERSON2,mpr.PLN_CHG_PERSON3,mpr.PLN_CHG_PERSON4,mpr.PLN_CHG_PERSON5,mpr.PLN_CHG_PERSON6,
      mpe.PLN_CHG_EXCEPTION1,mpe.PLN_CHG_EXCEPTION2,mpe.PLN_CHG_EXCEPTION3,mpe.PLN_CHG_EXCEPTION4,mpe.PLN_CHG_EXCEPTION5,mpe.PLN_CHG_EXCEPTION6,
      mrrm.STOP_FLG as 'MRRM_STOPFLG',mrrm.NUM as 'ZOUGEN_NUM',
      rpr.STOP_FLG as 'RPR_STOPSLG'
      from m_plan_rtypes mpr

      INNER JOIN m_plans mp
      ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID

      INNER JOIN m_rtypes mr 
      ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID


      left join m_rtype_roomamounts mrrm
      on mrrm.HTL_ID = mpr.HTL_ID AND mrrm.TYPE_ID = mpr.TYPE_ID  AND mrrm.SETTING_DAY = '".$param['DATE']."'

      left join m_plan_exceptiondays mpe 
      on mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.EXCEPTIONDAY = '".$param['DATE']."'

      left join r_plan_rmnums rpr
      on rpr.HTL_ID = mpr.HTL_ID AND rpr.PLN_ID = mpr.PLN_ID AND rpr.TYPE_ID = mpr.TYPE_ID AND rpr.EXCEPTIONDAY = '".$param['DATE']."'

      left join t_rsv_details trd 
      on trd.HTL_ID = mpr.HTL_ID AND trd.TYPE_ID = mpr.TYPE_ID AND trd.STAYDATE = '".$param['DATE']."'

      left join t_rsvs tr
      ON tr.HTL_ID = mpr.HTL_ID AND tr.RSV_NO = trd.RSV_NO 

      WHERE mpr.HTL_ID = ".$param['HTL_ID']."
      AND   mpr.PLN_ID = ".$param['PLN_ID']."
      AND  mpr.TYPE_ID = ".$param['TYPE_ID']."
      ;
      ";


      $query = DB::query($sql);
      $result = $query->execute()->as_array();

      if (count($result) == 0) {
        return 0;
      }

      $count = 0;
      $data = array();
      foreach ($result as $key => $value) {
        if ($value['RSV_STS'] != null && $value['RSV_STS'] != 9) {
          $count++;
        }
      }

      $data['payment'] = $result[0]['PLN_CHG_PERSON'.$param['NUM']] + $result[0]['PLN_CHG_EXCEPTION'.$param['NUM']];
      $data['stock'] = $result[0]['RM_NUM'] + $result[0]['ZOUGEN_NUM'] -$count;
      if ($data['stock'] > 9) {
        $data['mark'] = '○';
      }else if($data['stock'] > 0){
        $data['mark'] = $data['stock'];
      }else{
        $data['mark'] = '×';
      }
      

      if ($result[0]['RPR_STOPSLG'] === '0') {
        $data['stopflg'] = 0;
      }elseif ($result[0]['RPR_STOPSLG'] === '1') {
        $data['stopflg'] = 1;
        $data['mark'] = '-';
      }else{
        if ($result[0]['MRRM_STOPFLG'] === '1') {
         $data['stopflg'] = 1;
         $data['mark'] = '-';
        }else{
          $data['stopflg'] = 0;
        }
      }

      if (!$result[0]['PLN_LIMIT_DAY']){
        $data['closing_day'] = 1;
      }else{
        $data['closing_day'] = $result[0]['PLN_LIMIT_DAY'] * -1;
      }
      if ($result[0]['PLN_LIMIT_TIME'] != null) {
        $data['closing_time'] = $result[0]['PLN_LIMIT_TIME'] - ($result[0]['PLN_LIMIT_DAY'] ? 0 : 24);
      }


      if ($data['payment'] == 0) {
        $data['stopflg'] = 1;
        $data['mark'] = '-';
      }


      if ($result[0]['PLAN_START']  >  $param['DATE'] ||
          $result[0]['PLAN_END']    <  $param['DATE'] ||
          $result[0]['DISP_START']  >  $param['DATE'] ||
          $result[0]['DISP_END']    <  $param['DATE']  ) {
        $data['stopflg'] = 1;
        $data['mark'] = '-';
      }

      return $data;
  }


  public function get_plan_rtype_for_api($param)
  {

    $param['DayStart'] = date('Y-m-d', strtotime($param['DayStart']));
    $param['DayEnd'] = date('Y-m-d', strtotime($param['DayEnd']));

    /*---------------------------------------------------*/
    $param['DayStart'] = date('Y-m-d', strtotime('first day of ' . $param['DayStart']));
    $param['DayEnd'] = date('Y-m-d', strtotime('last day of ' . $param['DayEnd']));
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    /*---------------------------------------------------*/


    $basic_data = Model_M_Plan_Rtype::find_one_by(array(
        'HTL_ID'  => $param['HTL_ID'],
        'PLN_ID'  => $param['PlanID'],
        'TYPE_ID' => $param['HeyaID'],
    ));

    $plan_data = Model_M_Plan::find_one_by(array(
        'HTL_ID'  => $param['HTL_ID'],
        'PLN_ID'  => $param['PlanID'],
    ));

    $rtype_data = Model_M_Rtype::find_one_by(array(
        'HTL_ID'  => $param['HTL_ID'],
        'TYPE_ID' => $param['HeyaID'],
    ));

    if(!$basic_data || !$plan_data || !$rtype_data ){
      return 0;
    }

    if ($plan_data['PLN_USE_FLG'] == 1 && $rtype_data['RM_USE_FLG'] == 1) {
      $st = '0';
    }else{
      $st = '1';
    }

    $result_data = array('PLN_STATUS' => $st, 'PRICE_TYPE' => '0');
    for ($i=$param['DayStart']; $i <= $param['DayEnd']; $i++) {  // for1 
      $flg = 'OP';

      $day_data = Model_M_Plan_Exceptionday::find_one_by(array(
        'HTL_ID'       => $param['HTL_ID'],
        'PLN_ID'       => $param['PlanID'],
        'TYPE_ID'      => $param['HeyaID'],
        'EXCEPTIONDAY' => $i,
      ));

      $pay_info = array(
        '0' => $basic_data['PLN_CHG_PERSON1'],
        '1' => $basic_data['PLN_CHG_PERSON2'],
        '2' => $basic_data['PLN_CHG_PERSON3'],
        '3' => $basic_data['PLN_CHG_PERSON4'],
        '4' => $basic_data['PLN_CHG_PERSON5'],
        '5' => $basic_data['PLN_CHG_PERSON6'],
      );

      if($day_data){
        $pay_info[0] += $day_data['PLN_CHG_EXCEPTION1'];
        $pay_info[1] += $day_data['PLN_CHG_EXCEPTION2'];
        $pay_info[2] += $day_data['PLN_CHG_EXCEPTION3'];
        $pay_info[3] += $day_data['PLN_CHG_EXCEPTION4'];
        $pay_info[4] += $day_data['PLN_CHG_EXCEPTION5'];
        $pay_info[5] += $day_data['PLN_CHG_EXCEPTION6'];
      }

      $stock_info = $this->get_zaiko_one_day(
        $param['HTL_ID'],
        $param['PlanID'],
        $param['HeyaID'],
        $i
      );

      if($stock_info == 0){
        $flg = 'CL';
      }
      if($stock_info['ZOUGEN_NUM'] == null){
        $stock_info['ZOUGEN_NUM'] = 0;
      }

      if( ($stock_info['RM_NUM'] + $stock_info['ZOUGEN_NUM'] - $stock_info['URIAGE']) <= 0 ||
          $stock_info['PLN_USE_FLG'] == '0' ||
          $stock_info['RM_USE_FLG'] == '0' 
        ){  
        $flg = 'CL';
      }

      if($stock_info['RPR_STOP_FLG'] === '0'){
        // 何もしない (flg=OPだった場合保持)
      }elseif($stock_info['RPR_STOP_FLG'] == '1'){
        $flg = 'CL';
      }else{
        if($stock_info['MRR_STOP_FLG'] == '1'){
          $flg = 'CL';        
        }      
      }

      if($i < $yesterday){
        $flg = 'CL';
      }

      // if($i == $yesterday && $plan_data['PLN_LIMIT_TIME'] != null && $plan_data['PLN_LIMIT_TIME'] != '' && $flg == 'OP'){
      //   $now = date('H:i');
      //   $limit = $plan_data['PLN_LIMIT_TIME'] - 24;
      //   $limit_time = date('H:i', strtotime($limit.':00'));
      //   if($now < $limit_time){
      //     // 何もしない (flg=OPだった場合保持)
      //   }
      if($plan_data['PLN_LIMIT_TIME'] != null && $plan_data['PLN_LIMIT_TIME'] != ''){
        $now = date('Y-m-d H:i');
        $closing_day = !$plan_data['PLN_LIMIT_DAY'] ? 1 : ($plan_data['PLN_LIMIT_DAY'] * -1);
        $closing_time = $plan_data['PLN_LIMIT_TIME'] - ($plan_data['PLN_LIMIT_DAY'] ? 0 : 24);
        $limit = date('Y-m-d', strtotime($i.' '.$closing_day.' day')).' '.date('H:i', strtotime($closing_time.':00'));
        if($limit < $now){
          $flg = 'CL';
        } else {
          $flg = 'OP';
        }
      }elseif($i == $yesterday){
        $flg = 'CL';
      }

     
      $day = substr($i, -2);
      $result_data += array($day.'_status' => $flg);

      for ($n=intval($basic_data['PLN_MIN']); $n <= intval($basic_data['PLN_MAX']); $n++) { // for2
        $col_num = $day.'_NUM_'.$n;
        $col_price = $day.'_price_'.$n;

        $result_data += array(
          $col_num   => $n,
          $col_price => $pay_info[$n - 1],
          );      
      }// for2 end
    }// for1 end

    return $result_data;
  }




  public function get_zaiko_one_day($h_id, $p_id, $t_id, $date)
  {
    $sql = "
        SELECT 
        mp.PLN_USE_FLG,
        mr.RM_USE_FLG,
        mr.RM_NUM,
        mrr.SETTING_DAY as `MRR_SETTING_DAY`,
        mrr.NUM as `ZOUGEN_NUM`,
        mrr.STOP_FLG as `MRR_STOP_FLG`,
        rpr.EXCEPTIONDAY as `RPR_EXDAY`,
        rpr.STOP_FLG as `RPR_STOP_FLG`,
        
        (select count(tr.RSV_NO) 
        from t_rsvs tr left join t_rsv_details trd on trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
        where trd.HTL_ID = mpr.HTL_ID AND trd.TYPE_ID = mr.TYPE_ID AND trd.STAYDATE = '".$date."' AND tr.RSV_STS != 9) as `URIAGE`
        
        
        FROM m_plan_rtypes mpr
        INNER JOIN m_plans mp
        ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID
        INNER JOIN m_rtypes mr
        ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
        
        LEFT JOIN m_rtype_roomamounts mrr
        ON mrr.HTL_ID = mpr.HTL_ID AND mrr.TYPE_ID = mpr.TYPE_ID AND mrr.SETTING_DAY = '".$date."' 
        LEFT JOIN r_plan_rmnums rpr
        ON rpr.HTL_ID = mpr.HTL_ID AND rpr.PLN_ID = mpr.PLN_ID AND rpr.TYPE_ID = mpr.TYPE_ID AND rpr.EXCEPTIONDAY = '".$date."'
        
        WHERE mpr.HTL_ID = ".$h_id." AND mpr.TYPE_ID = ".$t_id." AND mpr.PLN_ID = ".$p_id." AND mp.DISP_START <= '".$date."' AND mp.DISP_END >= '".$date."' AND mp.PLAN_START <= '".$date."' AND mp.PLAN_END >= '".$date."'
;";
    $query = DB::query($sql);
    $result = $query->execute()->as_array();
    
    if (count($result) == 0) {
      return 0;
    }

    return $result[0];
  }


  /* neppan003 で使用 */
  public function get_zaiko_one_day_noplanid($h_id, $t_id, $date)
  {
    $sql = "
        SELECT 
        mr.RM_USE_FLG,
        mr.RM_NUM,
        mrr.SETTING_DAY as `MRR_SETTING_DAY`,
        mrr.NUM as `ZOUGEN_NUM`,
        mrr.STOP_FLG as `MRR_STOP_FLG`,

        (select count(tr.RSV_NO) 
        from t_rsvs tr left join t_rsv_details trd on trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
        where trd.HTL_ID = mr.HTL_ID AND trd.TYPE_ID = mr.TYPE_ID AND trd.STAYDATE = '".$date."' AND tr.RSV_STS != 9) as `URIAGE`
        
        FROM m_rtypes mr

        LEFT JOIN m_rtype_roomamounts mrr
        ON mrr.HTL_ID = mr.HTL_ID AND mrr.TYPE_ID = mr.TYPE_ID AND mrr.SETTING_DAY = '".$date."' 

        WHERE mr.HTL_ID = ".$h_id." AND mr.TYPE_ID = ".$t_id."
;";

    $query = DB::query($sql);
    $result = $query->execute()->as_array();
    
    if (count($result) == 0) {
      return 0;
    }

    return $result[0];
  }



  public function update_price_neppan006($params, $h_id, $p_id, $t_id, $date)
  {

    $sql = "
      SELECT * FROM m_plan_rtypes mpr
      LEFT JOIN m_plan_exceptiondays mpe
      ON mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.EXCEPTIONDAY = '".$date."'
      WHERE mpr.HTL_ID = ".$h_id." AND mpr.PLN_ID = ".$p_id." AND mpr.TYPE_ID = ".$t_id.";";
    $query = DB::query($sql);
    $data = $query->execute()->as_array();

    if (count($data) == 0) {
      return 'no data';
    }


    if ($data['0']['EXCEPTIONDAY'] != null) {
      $val = array(
        'PLN_CHG_EXCEPTION1' => $data['0']['PLN_CHG_EXCEPTION1'],
        'PLN_CHG_EXCEPTION2' => $data['0']['PLN_CHG_EXCEPTION2'],
        'PLN_CHG_EXCEPTION3' => $data['0']['PLN_CHG_EXCEPTION3'],
        'PLN_CHG_EXCEPTION4' => $data['0']['PLN_CHG_EXCEPTION4'],
        'PLN_CHG_EXCEPTION5' => $data['0']['PLN_CHG_EXCEPTION5'],
        'PLN_CHG_EXCEPTION6' => $data['0']['PLN_CHG_EXCEPTION6'],
        );
      $e_query = DB::update('m_plan_exceptiondays');
    }else{
      $val = array(
        'HTL_ID' => $h_id,
        'PLN_ID' => $p_id,
        'TYPE_ID'=> $t_id,
        'PLN_CHG_EXCEPTION1' => 0,
        'PLN_CHG_EXCEPTION2' => 0,
        'PLN_CHG_EXCEPTION3' => 0,
        'PLN_CHG_EXCEPTION4' => 0,
        'PLN_CHG_EXCEPTION5' => 0,
        'PLN_CHG_EXCEPTION6' => 0,
        'EXCEPTIONDAY' => $date,
        );      
      $e_query = DB::insert('m_plan_exceptiondays');
    }



    $query = DB::update('m_plan_rtypes');

    foreach ($params as $key => $param) {
      if (isset($param['RegularPrice']) && $param['RegularPrice'] != null) {
        if ($param['RateTypeCode'] == '01') {
          $query->value('PLN_CHG_PERSON1', $param['RegularPrice']);
        }else if ($param['RateTypeCode'] == '02') {
          $query->value('PLN_CHG_PERSON2', $param['RegularPrice']);
        }else if ($param['RateTypeCode'] == '03') {
          $query->value('PLN_CHG_PERSON3', $param['RegularPrice']);
        }else if ($param['RateTypeCode'] == '04') {
          $query->value('PLN_CHG_PERSON4', $param['RegularPrice']);
        }else if ($param['RateTypeCode'] == '05') {
          $query->value('PLN_CHG_PERSON5', $param['RegularPrice']);
        }else if ($param['RateTypeCode'] == '06') {
          $query->value('PLN_CHG_PERSON6', $param['RegularPrice']);
        }
      }

      if ($param['RateTypeCode'] == '01') {
        $val['PLN_CHG_EXCEPTION1'] = $param['Price'] - $data['0']['PLN_CHG_PERSON1'];
      }else if ($param['RateTypeCode'] == '02') {
        $val['PLN_CHG_EXCEPTION2'] = $param['Price'] - $data['0']['PLN_CHG_PERSON2'];
      }else if ($param['RateTypeCode'] == '03') {
        $val['PLN_CHG_EXCEPTION3'] = $param['Price'] - $data['0']['PLN_CHG_PERSON3'];
      }else if ($param['RateTypeCode'] == '04') {
        $val['PLN_CHG_EXCEPTION4'] = $param['Price'] - $data['0']['PLN_CHG_PERSON4'];
      }else if ($param['RateTypeCode'] == '05') {
        $val['PLN_CHG_EXCEPTION5'] = $param['Price'] - $data['0']['PLN_CHG_PERSON5'];
      }else if ($param['RateTypeCode'] == '06') {
        $val['PLN_CHG_EXCEPTION6'] = $param['Price'] - $data['0']['PLN_CHG_PERSON6'];
      }

    }
    $query->where('HTL_ID', '=',  $h_id);
    $query->and_where('PLN_ID', '=', $p_id);
    $query->and_where('TYPE_ID', '=', $t_id);
    if (isset($param['RegularPrice']) && $param['RegularPrice'] != null) {
      $result = $query->execute();
    }
    


    if ($data['0']['EXCEPTIONDAY'] != null) {
      $e_query->set($val);
      $e_query->where('HTL_ID', '=', $h_id);
      $e_query->and_where('PLN_ID', '=', $p_id);
      $e_query->and_where('TYPE_ID', '=', $t_id);
      $e_query->and_where('EXCEPTIONDAY', '=', $date);
    }else{
      $e_query->set($val);
    }

    $result = $e_query->execute();

    return 0;
  }





//   /* 部屋IDに紐づくプランの取得 */
//   public function get_plan_all($h_id, $t_id)
//   {
//     $sql = "
// SELECT 
//  (SELECT MIN( mpr.PLN_CHG_PERSON".$num." + mpe.PLN_CHG_EXCEPTION".$num." )
//   FROM m_plan_exceptiondays mpe WHERE mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.EXCEPTIONDAY BETWEEN '' AND '2017-02-28'
//   )  as payment
// , 

// FROM m_plan_rtypes mpr
// INNER JOIN m_plans mp
// ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID
// INNER JOIN m_rtypes mr
// ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID

// WHERE mr.TYPE_ID = 1;



//     ";




//   }




  public function get_zaiko_for_api($param)
  {
    $param['DayStart'] = date('Y-m-d', strtotime($param['DayStart']));
    $param['DayEnd'] = date('Y-m-d', strtotime($param['DayEnd']));

    /*---------------------------------------------------*/
    $param['DayStart'] = date('Y-m-d', strtotime('first day of ' . $param['DayStart']));
    $param['DayEnd'] = date('Y-m-d', strtotime('last day of ' . $param['DayEnd']));
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    /*---------------------------------------------------*/       
    $sql = "
          SELECT *

          FROM m_plan_rtypes mpr 
          INNER JOIN m_rtypes mr
          ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
           
          LEFT JOIN t_rsv_details trd 
          on trd.HTL_ID = mpr.HTL_ID AND trd.TYPE_ID = mpr.TYPE_ID AND trd.PLN_ID = mpr.PLN_ID  AND trd.STAYDATE BETWEEN '".$param['DayStart']."' AND '".$param['DayEnd']."'

          LEFT JOIN m_rtype_roomamounts mrr 
          ON mrr.HTL_ID = mpr.HTL_ID AND mrr.TYPE_ID = mpr.TYPE_ID AND mrr.SETTING_DAY BETWEEN '".$param['DayStart']."' AND '".$param['DayEnd']."'


          LEFT JOIN t_rsvs tr 
          ON tr.HTL_ID = trd.HTL_ID AND tr.RSV_NO = trd.RSV_NO
          
          WHERE mpr.HTL_ID = ".$param['HTL_ID']." AND mpr.TYPE_ID = ".$param['HeyaID']."


    ;";

    $query = DB::query($sql);
    $result = $query->execute()->as_array();

    if (count($result) == 0) {
      return 0;
    }

    $stock_list = array();
    $rsv_list = array();

    foreach ($result as $key => $value) {
      if (!isset($stock_list[$value['SETTING_DAY']])) {
        $stock_list[$value['SETTING_DAY']] = array(
          'num' => $value['NUM'] + $value['RM_NUM'],
          'stop_flg' => $value['STOP_FLG'],
          );
      }

      if (!isset($rsv_list[$value['STAYDATE']])) {
        if ($value['RSV_STS'] == '1') {
            $rsv_list[$value['STAYDATE']] = array(
                $value['RSV_NO'] = $value['RSV_NO'],
              );
          }
      }else{
        if (!isset( $rsv_list[$value['STAYDATE']][$value['RSV_NO']]  )) {
          if ($value['RSV_STS'] == '1') {
            $rsv_list[$value['STAYDATE']] += array(
               $value['RSV_NO'] = $value['RSV_NO'],
            );
          }
        }
      }
    }

    $day = array();
    for ($i=$param['DayStart']; $i <= $param['DayEnd']; $i++) { 
      if (isset( $stock_list[$i]) && isset($rsv_list[$i])) {
        $day[$i]['stock'] = $stock_list[$i]['num'] - count($rsv_list[$i]);
        $day[$i]['flg'] = $stock_list[$i]['stop_flg'];
      }elseif (isset( $stock_list[$i]) && !isset($rsv_list[$i])) {
        $day[$i]['stock'] = $stock_list[$i]['num'];
        $day[$i]['flg'] = $stock_list[$i]['stop_flg'];
      }elseif (!isset( $stock_list[$i]) && isset($rsv_list[$i])) {
        $day[$i]['stock'] = $result[0]['RM_NUM'] - count($rsv_list[$i]);
        $day[$i]['flg'] = '0';
      }else{
        $day[$i]['stock'] = $result[0]['RM_NUM'];
        $day[$i]['flg'] = '0'; 
      }
    }

    return  $day;
  }


  /*

    りんかーん　料金取得APIで使用


  */
  public function get_tariff_information($h_id, $p_id, $t_id, $date)
  {
    $sql = "
        SELECT 
        mpr.*,
        mp.PLAN_START, mp.PLAN_END, mp.DISP_START, mp.DISP_END, mp.PLN_LIMIT_TIME,mp.PLN_USE_FLG,
        mr.RM_USE_FLG,
        mpe.PLN_CHG_EXCEPTION1,mpe.PLN_CHG_EXCEPTION2,mpe.PLN_CHG_EXCEPTION3,mpe.PLN_CHG_EXCEPTION4,mpe.PLN_CHG_EXCEPTION5,mpe.PLN_CHG_EXCEPTION6,
        rpr.STOP_FLG AS 'RPR_STOP_FLG',
        mrr.STOP_FLG AS 'MRR_STOP_FLG',
        mrrm.NUM    AS 'ZOUGEN_NUM',
        (SELECT COUNT(tr.RSV_NO) 
                FROM t_rsvs tr LEFT JOIN t_rsv_details trd on trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
                WHERE trd.HTL_ID = mpr.HTL_ID AND trd.TYPE_ID = mpr.TYPE_ID AND trd.STAYDATE = '".$date."' AND tr.RSV_STS != 9) AS `URIAGE`
        
        FROM m_plan_rtypes mpr
        
        INNER JOIN m_plans mp 
        ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID
        
        INNER JOIN m_rtypes mr
        ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
        
        LEFT JOIN m_plan_exceptiondays mpe
        ON mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.EXCEPTIONDAY = '".$date."'
        
        LEFT JOIN r_plan_rmnums rpr
        ON rpr.HTL_ID = mpr.HTL_ID AND rpr.PLN_ID = mpr.PLN_ID AND rpr.TYPE_ID = rpr.TYPE_ID AND rpr.EXCEPTIONDAY = '".$date."'
        
        LEFT JOIN m_rtype_roomamounts mrr
        ON mrr.HTL_ID = mpr.HTL_ID AND mrr.TYPE_ID = mpr.TYPE_ID AND mrr.SETTING_DAY = '".$date."'

        LEFT JOIN m_rtype_roomamounts mrrm
        ON mrrm.HTL_ID = mpr.HTL_ID AND mrrm.TYPE_ID = mpr.TYPE_ID  AND mrrm.SETTING_DAY = '".$date."'
        
        WHERE mpr.HTL_ID = ".$h_id." AND mpr.PLN_ID = ".$p_id." AND mpr.TYPE_ID = ".$t_id;

    $query = DB::query($sql);

    $result = $query->execute()->as_array();

    if (count($result) == 0) {
      return 'no data';
    }

    $flg = '0';
    if ($result[0]['RM_USE_FLG'] == '0' || $result[0]['PLN_USE_FLG'] == '0' || $result[0]['RPR_STOP_FLG'] == '1') {
      $flg = '1';
    }else{
      if ($result[0]['DISP_START'] <= $date && $result[0]['DISP_END'] >= $date && $result[0]['PLAN_START'] <= $date && $result[0]['PLAN_END'] >= $date && $result[0]['MRR_STOP_FLG'] != '1') {
        $flg = '0';
      }else{
        $flg = '1';
      }
    }
    $result[0]['ONSALE_FLG'] = $flg;


    /*
        0 : 通常

        1 : 販売不可(手仕舞い)
    */
    $flg = '1';
    if ($date == date('Y-m-d', strtotime('-1 day')) && $result[0]['PLN_LIMIT_TIME'] != null && $result[0]['PLN_LIMIT_TIME'] != '') {
       $ct = $result[0]['PLN_LIMIT_TIME'] - 24;
       if (date('H') < $ct) {
         $flg = '0';
       }
    }else if ($date >= date('Y-m-d')) {
      $flg = '0';
    }

    if ($result[0]['RM_NUM'] + $result[0]['ZOUGEN_NUM'] - $result[0]['URIAGE'] > 0) {
      $flg = '0';
    }else{
      $flg = '1';
    }

    $result[0]['TEJIMAI'] = $flg;
    
    return  $result[0];
  }


  /*
    リンカーンAPIで使用
    
  */
  public function get_pay_info($h_id, $p_id, $t_id, $date)
  {
    $sql = "
        SELECT 
        mp.*,        
        rpr.EXCEPTIONDAY AS 'RPR_DAY' , rpr.STOP_FLG,
        (select count(tr.RSV_NO) 
            from t_rsvs tr left join t_rsv_details trd on trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
            where trd.HTL_ID = mpr.HTL_ID AND trd.TYPE_ID = mpr.TYPE_ID AND trd.STAYDATE = '".$date."' AND tr.RSV_STS != 9) as `URIAGE`
        
        FROM m_plan_rtypes mpr
        
        LEFT JOIN m_plans mp
        ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID 

        LEFT JOIN r_plan_rmnums rpr
        ON rpr.HTL_ID = mpr.HTL_ID AND rpr.PLN_ID = mpr.PLN_ID AND rpr.TYPE_ID = mpr.TYPE_ID AND rpr.EXCEPTIONDAY = '".$date."'
        
        WHERE mpr.HTL_ID = ".$h_id." AND mpr.PLN_ID = ".$p_id." AND mpr.TYPE_ID = ".$t_id." 
    ";


    $query = DB::query($sql);

    try {
      $result = $query->execute()->as_array();
    } catch (Exception $e) {
      $result = __FUNCTION__ .' : SELECT ERROR';
    }

    if (isset($result[0])) {
      $result = $result[0];
    }
    return $result;

  }



  public function get_plan_rtype_for_neppan($h_id, $p_id, $t_id, $s, $e)
  {
    $sql = "
      SELECT mpr.*, mpe.* FROM m_plan_rtypes mpr
      INNER JOIN m_plans mp ON mp.HTL_ID = mpr.HTL_ID AND mp.PLN_ID = mpr.PLN_ID
      INNER JOIN m_rtypes mr ON mr.HTL_ID = mpr.HTL_ID AND mr.TYPE_ID = mpr.TYPE_ID
      LEFT JOIN m_plan_exceptiondays mpe ON mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.EXCEPTIONDAY BETWEEN '".$s."' AND '".$e."'
      WHERE mpr.HTL_ID = ".$h_id." AND mpr.PLN_ID = ".$p_id." AND mpr.TYPE_ID = ".$t_id.";
    ";

    $query = DB::query($sql);
    $result = $query->execute()->as_array();

    return $result;
  }





  public function insert_pln_rtype($h_id, $p_id, $t_id, $min, $max)
  {
    $query = DB::insert('m_plan_rtypes')->set(array(
          'HTL_ID' => $h_id,
          'PLN_ID' => $p_id,
          'TYPE_ID'=> $t_id,
          'PLN_MIN'=> $min,
          'PLN_MAX'=> $max, 
      ));
    $result = $query->execute();
    return $result;
  }


  public function update_pln_rtype($h_id, $p_id, $t_id, $name, $val)
  { 
    $query = DB::update('m_plan_rtypes');
    $query->value($name, $val);
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('PLN_ID', '=', $p_id);
    $query->and_where('TYPE_ID', '=', $t_id);


    $result = $query->execute();

    return $result;
  }

  public function delete_pln_rtype($h_id, $p_id, $t_id)
  { 
    $query = DB::delete('m_plan_rtypes');
    $query->where('HTL_ID', '=', $h_id);
    if ($p_id != null) {
      $query->and_where('PLN_ID', '=', $p_id);
    }
    if ($t_id != null) {
      $query->and_where('TYPE_ID', '=', $t_id);
    }

    if ($p_id == null && $t_id == null) {
      return 0;
    }

    $result = $query->execute();

    return $result;
  }


}