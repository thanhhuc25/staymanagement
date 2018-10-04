<?php

class Model_M_Rtype_Roomamount extends Model_Crud
{
	protected static $_properties = array(
    'HTL_ID',
    'SETTING_DAY',
    'TYPE_ID',
    'NUM',
    'STOP_FLG',
	);

	protected static $_table_name = 'm_rtype_roomamounts';


  public function get_all_rmamount($h_id, $t_id)
  {
      $query = DB::select()->from('m_rtype_roomamounts');
      $query->where('HTL_ID', '=', $h_id);
      $query->and_where('TYPE_ID', '=', $t_id);
      // $query->and_where('STOP_FLG', '=', '1');

      $result = $query->execute()->as_array();

      return $result;
  }


  public function get_one_rmamount($h_id, $t_id, $date)
  {
      $query = DB::select('m_rtype_roomamounts.*','m_rtypes.RM_NUM')->from('m_rtype_roomamounts');
      $query->where('m_rtype_roomamounts.HTL_ID', '=', $h_id);
      $query->and_where('m_rtype_roomamounts.TYPE_ID', '=', $t_id);
      $query->and_where('m_rtype_roomamounts.SETTING_DAY', '=', $date);
      $query->join('m_rtypes','INNER');
      $query->on('m_rtypes.HTL_ID', '=', 'm_rtype_roomamounts.HTL_ID');
      $query->and_on('m_rtypes.TYPE_ID', '=', 'm_rtype_roomamounts.TYPE_ID');

      $result = $query->execute()->as_array();
      return $result;
  }


  /* neppan004で使用 */
  public function get_one_rmamount_for_neppan($h_id, $p_id, $t_id, $date)
  {
      $sql = "
        SELECT
        mrr.SETTING_DAY, mrr.STOP_FLG, mrr.NUM,
        mr.RM_NUM,
        (SELECT COUNT(tr.RSV_NO) 
                FROM t_rsvs tr LEFT JOIN t_rsv_details trd ON trd.HTL_ID = tr.HTL_ID AND trd.RSV_NO = tr.RSV_NO
                WHERE trd.TYPE_ID = mr.TYPE_ID AND trd.STAYDATE = '".$date."' AND tr.RSV_STS != 9) AS `URIAGE` ";
      if ($p_id != null) {
        $sql .= " , rpr.STOP_FLG";
      }

      $sql .= "
        FROM m_rtypes mr
        LEFT JOIN m_rtype_roomamounts mrr
        ON mrr.HTL_ID = mr.HTL_ID AND mrr.TYPE_ID = mr.TYPE_ID AND mrr.SETTING_DAY = '".$date."'";

      if ($p_id != null) {
        $sql .= "
          LEFT JOIN r_plan_rmnums rpr
          ON rpr.HTL_ID = mr.HTL_ID AND rpr.TYPE_ID = mr.TYPE_ID AND rpr.EXCEPTIONDAY = '".$date."' AND rpr.PLN_ID = ".$p_id."
          INNER JOIN m_plans mp
          ON mp.HTL_ID = mr.HTL_ID AND mp.PLN_ID = ".$p_id;
      }

      $sql .= "
        WHERE mr.HTL_ID = ".$h_id." AND mr.TYPE_ID = ".$t_id.";
      ";

      $query = DB::query($sql);
      $result = $query->execute()->as_array();

      if (count($result) == 0) {
        return 'no data';
      }

      if ($result[0]['SETTING_DAY'] == null) {
        $result[0]['flg'] = 'insert';
        $result[0]['STOP_FLG'] = 0;
        $result[0]['NUM'] = 0;
      }else{
        $result[0]['flg'] = 'update';
      }


      return $result[0];
  }



  public function update_rmamount($h_id, $t_id, $date, $flg, $num)
  {
      $query = DB::update('m_rtype_roomamounts');
      if ($flg == null) {
        $query->value('NUM',$num);
      }else{
        $query->value('STOP_FLG',$flg);
      }
      
      $query->where('HTL_ID', '=', $h_id);
      $query->and_where('TYPE_ID', '=', $t_id);
      $query->and_where('SETTING_DAY', '=', $date);

      $result = $query->execute();

  }

  public function insert_rmamount($h_id, $t_id, $date, $flg, $num)
  {
      $query=DB::insert('m_rtype_roomamounts')->set(array(
          'HTL_ID' => $h_id,
          'SETTING_DAY' => $date,
          'TYPE_ID' => $t_id,
          'NUM' => $num,
          'STOP_FLG' => $flg,
        ));

      $result = $query->execute();

  }

  public function delete_roomamount($h_id, $t_id)
  {
    $query = DB::delete('m_rtype_roomamounts');
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('TYPE_ID', '=', $t_id);

    $result = $query->execute();
    return $result;
  }

}

