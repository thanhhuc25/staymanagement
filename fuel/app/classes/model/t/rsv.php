<?php

class Model_T_Rsv extends Model_Crud
{
  protected static $_properties = array(
    'HTL_ID',
    'RSV_NO',
    'SERIAL_NO',
    'PLN_ID',
    'PLN_NAME',
    'USR_ID',
    'ADJUST_TYPE',
    'PLN_CHG_TOTAL',
    'NUM_STAY',
    'NUM_ROOM',
    'NUM_MEMBER',
    'IN_DATE',
    'IN_DATE_TIME',
    'OUT_DATE',
    'RSV_BRK',
    'RSV_DIN',
    'RSV_DATE',
    'CANCEL_DATE',
    'RSV_STS',
    'CANCEL_PERSON',
    'CANCEL_PERSON_NAME',
    'CANCEL_TYPE',
    'CANCEL_REASON',
    'RSV_ETC',
    'RVC_FLG',
    'ORDER_CD',
    'CARD_BRAND_NAME',
    'UP_DATE',
    'COME_FLG',
    'PT_OWN',
    'PT_ADD_BASIC',
    'PT_ADD_FIRST',
    'PT_USE',
    'PT_FIXED',
    'MEMO',
  );

  protected static $_table_name = 't_rsvs';

  private $_partial_match_fields = array(
    'm_usrs.USR_NAME',
    'm_usrs.USR_MAIL',
    'm_plans.PLN_NAME',
    't_rsv_details.TYPE_NAME',
    );





  public function get_user_rsv($h_id, $user_id, $r_no)
  {
    $sql = "
        SELECT tr.*, trd.PLN_NUM_MAN, trd.PLN_NUM_WOMAN, trd.PLN_NUM_CHILD1, trd.PLN_NUM_CHILD2, trd.PLN_NUM_CHILD3, trd.PLN_NUM_CHILD4, trd.PLN_NUM_CHILD5, trd.PLN_NUM_CHILD6 ,
        tr.PLN_NAME, mp.CHECK_IN, mr.*, trd.TYPE_NAME, tr.ADJUST_TYPE as ADTYPE FROM t_rsvs tr
        INNER JOIN t_rsv_details trd
        ON trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
        INNER JOIN m_plans mp
        ON mp.HTL_ID = tr.HTL_ID AND mp.PLN_ID = trd.PLN_ID
        INNER JOIN m_rtypes mr
        ON mr.HTL_ID = trd.HTL_ID AND mr.TYPE_ID = trd.TYPE_ID
        WHERE tr.HTL_ID = ".$h_id."
        AND tr.RSV_STS = 1" ;
        // AND tr.USR_ID = ".$user_id;

    if ($user_id != null) {
        $sql .= " AND tr.USR_ID=".$user_id;
    }

    if ($r_no != null) {
        $sql .= " AND tr.RSV_NO=".$r_no;
    }

    $sql .=" GROUP BY tr.RSV_NO ORDER BY tr.RSV_NO DESC";

    $query = DB::query($sql);
    $result = $query->execute()->as_array();

    return $result;

  }


  public function get_rsv_no_member($r_no, $mail)
  {

   $sql = "
        SELECT tr.*, mp.PLN_NAME, mp.CHECK_IN, mr.*, tr.ADJUST_TYPE as ADTYPE, mu.USR_ID, mu.USR_NAME FROM t_rsvs tr
        INNER JOIN t_rsv_details trd
        ON trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
        INNER JOIN m_plans mp
        ON mp.HTL_ID = tr.HTL_ID AND mp.PLN_ID = trd.PLN_ID
        INNER JOIN m_rtypes mr
        ON mr.HTL_ID = trd.HTL_ID AND mr.TYPE_ID = trd.TYPE_ID
        INNER JOIN m_usrs mu
        ON mu.USR_ID = tr.USR_ID
        WHERE
         tr.RSV_STS = 1 
        AND mu.RANK_ID = 2
        AND tr.RSV_NO = '".$r_no."' 
        AND mu.USR_MAIL = '".$mail."'

        ;";


    $query = DB::query($sql);
    $result = $query->execute()->as_array();

    return $result;

    // $query = DB::select()->from('t_rsvs');
    // $query->where('t_rsvs.RSV_NO', '=', $r_no);
    // $query->and_where('m_usrs.USR_MAIL', '=', $mail);
    // $query->and_where('t_rsvs.RSV_STS', '=', '1');
    // $query->join('m_usrs','INNER');
    // $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');

    // $query = DB::query($sql);
    // $result = $query->execute()->as_array();

    // return $result;

  }




  public function get_all_rsv($h_id, $t_id, $year, $month)
  {

    $date1 = date('Y-m-d', strtotime($year.'-'.$month.'-1'));
    $date2 = date('Y-m-d', strtotime($year.'-'.$month.'-31'));
    $query = DB::select()->from('t_rsvs');
    // 
    $query->where('t_rsv_details.STAYDATE', 'between', array($date1, $date2));
    $query->and_where('t_rsvs.HTL_ID','=',$h_id);
    $query->and_where('t_rsvs.RSV_STS', '!=', '9');
    $query->and_where('t_rsv_details.TYPE_ID','=',$t_id);
    $query->join('t_rsv_details','INNER');
    $query->on('t_rsv_details.HTL_ID', '=', 't_rsvs.HTL_ID');
    $query->and_on('t_rsv_details.RSV_NO', '=', 't_rsvs.RSV_NO');
    $result = $query->execute()->as_array();
    return $result;


    //     $date1 = date('Y-m-d', strtotime($year.'-'.$month.'-1'));
    // $date2 = date('Y-m-d', strtotime($year.'-'.$month.'-31'));
    // $query = DB::select()->from('t_rsv_details');
    // // 
    // $query->where('STAYDATE', 'between', array($date1, $date2));
    // $query->and_where('HTL_ID','=',$h_id);
    // $query->and_where('TYPE_ID','=',$t_id);
    // // $query->join('t_rsv_details','INNER');
    // // $query->on('t_rsv_details.HTL_ID', '=', 't_rsvs.HTL_ID');
    // // $query->and_on('t_rsv_details.RSV_NO', '=', 't_rsvs.RSV_NO');
    // $result = $query->execute()->as_array();
    // return $result;

  }

  public function insert_rsv($param)
  {
    // $sql = "SELECT RSV_NO + 1 AS RSV_NO FROM t_rsvs WHERE HTL_ID =".$param['HTL_ID']." ORDER BY RSV_NO DESC LIMIT 1;";
    // $query = DB::query($sql);
    // $result = $query->execute()->as_array();

    // if (count($result) == 0) {
    //     $RSV_NO = '1';
    // }else{
    //     $RSV_NO = $result[0]['RSV_NO'];
    // }
    $RSV_NO = $param['RSV_NO'];
    $sql = "
            INSERT INTO t_rsvs (
            HTL_ID, 
            RSV_NO,
            SERIAL_NO,
            PLN_ID,
            PLN_NAME,
            USR_ID,
            ADJUST_TYPE,
            PLN_CHG_TOTAL,
            NUM_STAY,
            NUM_ROOM,
            IN_DATE,
            IN_DATE_TIME,
            OUT_DATE,
            RSV_DATE,
            RSV_STS,
            ORDER_CD,
            CARD_BRAND_NAME,
            PT_USE,
            PT_ADD_BASIC
            ) 
            
            VALUES (
            '".$param['HTL_ID']."',          /* HTL_ID */
            '".$RSV_NO."' ,                  /* RSV_NO */
            '".$param['SERIAL_NO']."',       /* SERIAL_NO */
            '".$param['PLN_ID']."',          /* PLN_ID */
            '".$param['PLN_NAME']."',        /* PLN_NAME */
            '".$param['USR_ID']."',          /* USR_ID */
            '".$param['ADJUST_TYPE']."',     /* ADJUST_TYPE */
            '".$param['PLN_CHG_TOTAL']."',   /* PLN_cHG_TOTAL */
            '".$param['NUM_STAY']."',        /* NUM_STAY */
            '".$param['NUM_ROOM']."',        /* NUM_ROOM */
            '".$param['IN_DATE']."',         /* IN_DATE */
            '".$param['IN_DATE_TIME']."',    /* IN_DATE_TIME */
            '".$param['OUT_DATE']."',        /* OUT_DATE */
            now(),                           /* RSV_DATE */
            '1',                             /* RSV_STS */
            '".$param['ORDER_CD']."',        /* ORDER_CD */
            '".$param['CARD_BRAND_NAME']."', /* CARD_BRAND_NAME */
            '".$param['PT_USE']."',          /* PT_USE */
            '".$param['PT_ADD_BASIC']."'     /* PT_ADD_BASIC */
           
    ); ";
    foreach ($param['RSVS'] as $key => $value) {
        for ($i=0; $i < $param['NUM_ROOM'] ; $i++) { 
            $sql .= "
                INSERT INTO t_rsv_details (
                    HTL_ID,
                    RSV_NO,
                    IN_DATE,
                    STAYDATE,
                    SEQ_ROOM,
                    TYPE_ID,
                    TYPE_NAME,
                    PLN_ID,
                    PLN_NUM_MAN,
                    PLN_NUM_WOMAN,
                    PLN_CHG
                )
                VALUES (
                '".$param['HTL_ID']."',       /* HTL_ID */
                '".$RSV_NO."' ,               /* RSV_NO */
                '".$param['IN_DATE_TIME']."', /* IN_DATE */
                '".$key."',                   /* STAYDATE */
                '".$i."',                     /* SEQ_ROOM */
                '".$param['TYPE_ID']."',      /* TYPE_ID */
                '".$param['TYPE_NAME']."',    /* TYPE_NAME */
                '".$param['PLN_ID']."',       /* PLN_ID */
                '".$param['PERSON_NUM1']."',  /* PLN_NUM_MAN */
                '".$param['PERSON_NUM2']."',  /* PLN_NUM_WOMAN */
                '".$value."'       
                );";
            }
    }
    $query = DB::query($sql);
    $result = $query->execute();

    return $RSV_NO;
  }

  public function delete_rsv($h_id, $r_no)
  {

    $query = DB::delete('t_rsvs');
    $query->where('HTL_ID', '=', $h_id);
    $query->where('RSV_NO', '=', $r_no);
    $result = $query->execute();

    $query = DB::delete('t_rsv_details');
    $query->where('HTL_ID', '=', $h_id);
    $query->where('RSV_NO', '=', $r_no);
    $result = $query->execute();

    return  $result;

  } 

  public function update_rsv($col, $val, $h_id, $r_no)
  {
    $query = DB::update('t_rsvs');
    $query->value($col, $val);
    if ($col == 'RSV_DATE') {
        $query->value('UP_DATE', $val);
    }
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('RSV_NO', '=', $r_no);

    $result = $query->execute();

    return $result;
  }



  public function get_count($where, $between)
  {
    $query = DB::select('t_rsvs.RSV_NO')->from('t_rsvs');

    foreach ($where as $key => $value) {
        if (in_array($key, $this->_partial_match_fields)) {
            $query->where(DB::expr($key.' COLLATE utf8_unicode_ci LIKE '.DB::escape('%'.$value.'%')));
        } else {
            $query->where($key, '=', $value);
        }
    }

    foreach ($between as $key => $value) {
        $query->where($key, 'between', array($value[0], $value[1]));
    }

    $query->join('t_rsv_details','INNER');
    $query->on('t_rsv_details.HTL_ID', '=', 't_rsvs.HTL_ID');
    $query->and_on('t_rsv_details.RSV_NO', '=', 't_rsvs.RSV_NO');

    $query->join('m_plans','INNER');
    $query->on('m_plans.HTL_ID', '=', 't_rsv_details.HTL_ID');
    $query->and_on('m_plans.PLN_ID', '=', 't_rsv_details.PLN_ID');

    $query->join('m_usrs','INNER');
    $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');

    $query->join('m_htls','INNER');
    $query->on('m_htls.HTL_ID', '=', 't_rsvs.HTL_ID');

    $query->group_by('t_rsvs.RSV_NO');

    $result = $query->execute()->as_array();
    return $result;
  }


  public function get_list($where, $between, $order, $limit, $offset)
  {
    $query = DB::select(
        'm_htls.HTL_NAME',
        't_rsvs.HTL_ID',
        't_rsvs.RSV_NO',
        'm_usrs.USR_NAME',
        'm_usrs.USR_ID',
        't_rsv_details.TYPE_NAME',
        't_rsvs.IN_DATE',
        't_rsvs.IN_DATE_TIME',
        't_rsvs.OUT_DATE',
        't_rsvs.ORDER_CD',
        't_rsvs.NUM_STAY',
        't_rsvs.NUM_ROOM',
        't_rsvs.RSV_STS',        
        't_rsvs.RSV_DATE',
        't_rsvs.UP_DATE',
        't_rsvs.COME_FLG',
        't_rsvs.ADJUST_TYPE',
        'm_plans.PLN_NAME',
        't_rsvs.PT_USE',
        't_rsvs.PT_ADD_BASIC',
        't_rsvs.PLN_CHG_TOTAL')->from('t_rsvs');

    foreach ($where as $key => $value) {
        if (in_array($key, $this->_partial_match_fields)) {
            $query->where(DB::expr($key.' COLLATE utf8_unicode_ci LIKE '.DB::escape('%'.$value.'%')));
        } else {
            $query->where($key, '=', $value);
        }
    }
    foreach ($between as $key => $value) {
        $query->where($key, 'between', array($value[0], $value[1]));
    }

    $query->join('t_rsv_details','INNER');
    $query->on('t_rsv_details.HTL_ID', '=', 't_rsvs.HTL_ID');
    $query->and_on('t_rsv_details.RSV_NO', '=', 't_rsvs.RSV_NO');

    $query->join('m_plans','INNER');
    $query->on('m_plans.HTL_ID', '=', 't_rsv_details.HTL_ID');
    $query->and_on('m_plans.PLN_ID', '=', 't_rsv_details.PLN_ID');

    $query->join('m_usrs','INNER');
    $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');

    $query->join('m_htls','INNER');
    $query->on('m_htls.HTL_ID', '=', 't_rsvs.HTL_ID');

    if ($order != null) {
        $query->order_by($order['colname'], $order['value']);
    }else{
        $query->order_by('t_rsvs.RSV_NO', 'DESC');
    }
    $query->group_by('t_rsvs.RSV_NO');

    if ($limit != null) {
        $query->limit($limit);
    }
    if ($offset != null) {
        $query->offset($offset);
    }

    $result = $query->execute()->as_array();
    foreach ($result as $key => $value) {
            $result[$key]['CHECK_FLG'] = '0';
        if ($value['RSV_STS'] == '1') {
            $result[$key]['STATUS'] = '予約確定';
            if ( date('Y-m-d', strtotime($value['IN_DATE'])) <= date('Y-m-d') && $value['COME_FLG'] === '0') {
              $result[$key]['CHECK_FLG'] = '1';
            }else if ( $value['COME_FLG'] === '9') {
              $result[$key]['CHECK_FLG'] = '9';
              // $result[$key]['STATUS'] = 'NO_SHOW';
            }else if ($value['COME_FLG'] === '1') {
              // $result[$key]['STATUS'] = '来客済み';
              $result[$key]['CHECK_FLG'] = '2';
            }
        }else if($value['RSV_STS'] == '0'){
            $result[$key]['STATUS'] = '仮予約';
        }else if($value['RSV_STS'] == '9'){
            $result[$key]['STATUS'] = 'キャンセル';
        }else{  
            $result[$key]['STATUS'] = 'error';
        }

        if ($value['ADJUST_TYPE'] == '1') {
            $result[$key]['ADJUST_TYPE_NAME'] = 'フロント決済';
        }else if($value['ADJUST_TYPE'] == '2'){
            $result[$key]['ADJUST_TYPE_NAME'] = 'カード決済';
        }else{
            $result[$key]['ADJUST_TYPE_NAME'] = 'error';
        }
        $result[$key]['URL'] = 'admin/reserve/detail/'.$value['HTL_ID'].EXPLODE.$value['RSV_NO'];
    }

    return $result;
  }


  /*

    tema201で使用


  */
  public function get_rsv_for_api($param)
  {

    $query = $this->tema_query201($param['Shubetsu']);

    if ($param['Shubetsu'] == '1') {

        $query->where('t_rsv_details.STAYDATE', 'between', array($param['DayStart'],$param['DayEnd']));
        $query->group_by('t_rsvs.RSV_NO');


    }else{
        $query->where('t_rsvs.UP_DATE', 'between', array($param['DayStart'],$param['DayEnd']." 23:59:59"));
    }
    $query->where('t_rsvs.RSV_STS', '!=', '0');
    $query->and_where('m_usrs.USR_ID', '!=', '999999999');
    $query->where('t_rsvs.HTL_ID', '=', $param['HTL_ID']);

    $result = $query->execute()->as_array();
    if (count($result) == 0) {
        return 0;
    }

    if ($param['Shubetsu'] == '1') {
       $result = $this->get_rsv_for_api2($result);
    }
        
    $rsv_data = array();
    foreach ($result as $key => $value) {
        // if (isset($rsv_data[$value['HTL_ID'].'_'.$value['RSV_NO']][$value['STAYDATE']])) {
            // $rsv_data[$value['HTL_ID'].'_'.$value['RSV_NO']][$value['STAYDATE']][$value['SEQ_ROOM']] = $value['SEQ_ROOM'];
        // }else{
            $rsv_data['ID'.$value['HTL_ID'].'_'.$value['RSV_NO']]['info'] = $value;            
            $rsv_data['ID'.$value['HTL_ID'].'_'.$value['RSV_NO']]['days'][$value['STAYDATE']][$value['SEQ_ROOM']] = $value['PLN_NUM_MAN'].'_'.$value['PLN_NUM_WOMAN'].'_'.$value['PLN_CHG'].'_'.$value['PLN_NUM_CHILD1'].'_'.$value['PLN_NUM_CHILD2'].'_'.$value['PLN_NUM_CHILD3'].'_'.$value['PLN_NUM_CHILD4'].'_'.$value['PLN_NUM_CHILD5'].'_'.$value['PLN_NUM_CHILD6'].'_'.$value['PLN_CHG_CHILD1'].'_'.$value['PLN_CHG_CHILD2'].'_'.$value['PLN_CHG_CHILD3'].'_'.$value['PLN_CHG_CHILD4'].'_'.$value['PLN_CHG_CHILD5'].'_'.$value['PLN_CHG_CHILD6'];
            $rsv_data['ID'.$value['HTL_ID'].'_'.$value['RSV_NO']]['rm_betsu'][$value['STAYDATE']] = $value['PLN_NUM_MAN'].'_'.$value['PLN_NUM_WOMAN'].'_'.$value['PLN_CHG'].'_'.$value['PLN_NUM_CHILD1'].'_'.$value['PLN_NUM_CHILD2'].'_'.$value['PLN_NUM_CHILD3'].'_'.$value['PLN_NUM_CHILD4'].'_'.$value['PLN_NUM_CHILD5'].'_'.$value['PLN_NUM_CHILD6'].'_'.$value['PLN_CHG_CHILD1'].'_'.$value['PLN_CHG_CHILD2'].'_'.$value['PLN_CHG_CHILD3'].'_'.$value['PLN_CHG_CHILD4'].'_'.$value['PLN_CHG_CHILD5'].'_'.$value['PLN_CHG_CHILD6'];
        // }
    }


    return $rsv_data;

  }


  private function get_rsv_for_api2($param)
  {
    $query = $this->tema_query201('2');

    foreach ($param as $key => $value) {
        $query->or_where('t_rsvs.RSV_NO', '=' , $value['RSV_NO']);
    }
    $result = $query->execute()->as_array();
    return $result;
  }

  private function tema_query201($flg)
  {
    if ($flg == '1') {
      $query = DB::select('t_rsvs.RSV_NO')->from('t_rsvs');
    }else{
      $query = DB::select(
                  'm_usrs.USR_NAME',
                  'm_usrs.USR_KANA',
                  'm_usrs.USR_ADR1',
                  'm_usrs.USR_ADR2',
                  'm_usrs.USR_TEL',
                  'm_usrs.USR_FAX',
                  'm_usrs.USR_EM_TEL',
                  'm_usrs.USR_SEX',
                  'm_usrs.USR_MAIL',
                  
                  't_rsvs.HTL_ID',
                  't_rsvs.RSV_NO',
                  't_rsvs.SERIAL_NO',
                  't_rsvs.PLN_ID',
                  't_rsvs.PLN_NAME',
                  't_rsvs.USR_ID',
                  't_rsvs.ADJUST_TYPE',
                  't_rsvs.PLN_CHG_TOTAL',
                  't_rsvs.NUM_STAY',
                  't_rsvs.NUM_ROOM',
                  't_rsvs.NUM_MEMBER',
                  't_rsvs.IN_DATE',
                  't_rsvs.IN_DATE_TIME',
                  't_rsvs.OUT_DATE',
                  't_rsvs.RSV_BRK',
                  't_rsvs.RSV_DIN',
                  't_rsvs.RSV_DATE',
                  't_rsvs.CANCEL_DATE',
                  't_rsvs.RSV_STS',
                  't_rsvs.CANCEL_PERSON',
                  't_rsvs.CANCEL_PERSON_NAME',
                  't_rsvs.CANCEL_TYPE',
                  't_rsvs.CANCEL_REASON',
                  't_rsvs.RSV_ETC',
                  't_rsvs.ORDER_CD',
                  't_rsvs.CARD_BRAND_NAME',
                  't_rsvs.UP_DATE',
                  't_rsvs.PT_ADD_BASIC',
                  't_rsvs.PT_USE',
                  't_rsvs.PT_FIXED',
                  't_rsvs.MEMO',
                  
                  't_rsv_details.STAYDATE',
                  't_rsv_details.SEQ_ROOM',
                  't_rsv_details.TYPE_ID',
                  't_rsv_details.TYPE_NAME',
                  't_rsv_details.PLN_NUM_MAN',
                  't_rsv_details.PLN_NUM_WOMAN',
                  't_rsv_details.PLN_NUM_CHILD1',
                  't_rsv_details.PLN_NUM_CHILD2',
                  't_rsv_details.PLN_NUM_CHILD3',
                  't_rsv_details.PLN_NUM_CHILD4',
                  't_rsv_details.PLN_NUM_CHILD5',
                  't_rsv_details.PLN_NUM_CHILD6',
                  't_rsv_details.PLN_CHG',
                  't_rsv_details.PLN_CHG_MAN',
                  't_rsv_details.PLN_CHG_WOMAN',
                  't_rsv_details.PLN_CHG_CHILD1',
                  't_rsv_details.PLN_CHG_CHILD2',
                  't_rsv_details.PLN_CHG_CHILD3',
                  't_rsv_details.PLN_CHG_CHILD4',
                  't_rsv_details.PLN_CHG_CHILD5',
                  't_rsv_details.PLN_CHG_CHILD6',
                  
                  'm_htls.HTL_NAME',
                  'm_htls.HTL_PREF_CD',
                  'm_htls.HTL_ADR1',
                  'm_htls.HTL_ADR2',
                  'm_htls.HTL_TEL',
                  'm_htls.HTL_MAIL'
          )->from('t_rsvs');
    }


    $query->join('t_rsv_details', 'INNER');
    $query->on('t_rsv_details.HTL_ID', '=', 't_rsvs.HTL_ID');
    $query->and_on('t_rsv_details.RSV_NO', '=', 't_rsvs.RSV_NO');

    $query->join('m_usrs', 'INNER');
    $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');

    $query->join('m_htls', 'INNER');
    $query->on('m_htls.HTL_ID', '=', 't_rsvs.HTL_ID');


    return $query;
  }


  public function get_rsv_for_neppan007($s, $e, $where1, $where2)
  {
    $sql = "SELECT * FROM t_rsvs ";

    if ($where1 == '0') {
      $sql .= " WHERE USR_ID != 999999999 ";
    }else if ($where1 == '1') {
      $sql .= " WHERE RSV_STS = 1 OR RSV_STS = 0 AND USR_ID != 999999999 ";
    }else if ($where1 == '3') {
      $sql .= " WHERE RSV_STS = 1 OR RSV_STS = 0 AND RSV_DATE != UP_DATE AND USR_ID != 999999999 ";
    }else if ($where1 == '4') {
      $sql .= " RSV_STS = 9 AND USR_ID != 999999999 ";
    }

    if ($where1 == '0') {
      if ($where2 == '0') {
        $sql .= " AND IN_DATE BETWEEN '".$s."' AND '".$e."' ";
      }else if ($where2 == '1') {
        $sql .= " AND RSV_DATE BETWEEN '".$s."' AND '".$e."' ";
      }else if ($where2 == '2') {
        $sql .= " AND UP_DATE != RSV_DATE AND IN_DATE BETWEEN '".$s."' AND '".$e."' ";
      }else if ($where2 == '3') {
        $sql .= " AND RSV_STS = 9 AND UP_DATE BETWEEN '".$s."' AND '".$e."' ";
      }
    }


    $query = DB::query($sql);
    $result = $query->execute()->as_array();

    return $result;

  }



  public function get_rsv_one($h_id, $r_no)
  {
    $query = DB::select()->from('t_rsvs');

    $query->where('t_rsvs.HTL_ID', '=', $h_id);
    $query->where('t_rsvs.RSV_NO', '=', $r_no);

    // $query->join('t_rsv_details', 'INNER');
    // $query->on('t_rsv_details.RSV_NO', '=', 't_rsvs.RSV_NO');
    // $query->and_on('t_rsv_details.HTL_ID', '=', 't_rsvs.HTL_ID');

    $query->join('m_usrs', 'INNER');
    $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');

    $result = $query->execute()->as_array();
    return $result;
  }


}
