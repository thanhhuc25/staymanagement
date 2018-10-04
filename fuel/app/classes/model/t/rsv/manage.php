<?php

class Model_T_Rsv_Manage extends Model_Crud
{
  protected static $_properties = array(
    'HTL_ID',
    'RSV_NO',
    'UP_DATE',
  );

  protected static $_table_name = 't_rsv_manages';


    /*

        仮予約制が廃止になったので、予約番号を仮押さえするテーブルを作成。
        予約番号を仮押さえしておかないと、カード決済APIに影響が出る。


    */


    public function rsvno_check($h_id)
    {
        $array = array('0', '1');
		//$sql = "SELECT RSV_NO FROM t_rsvs WHERE HTL_ID =".$h_id." ORDER BY RSV_NO DESC LIMIT 1;";
        $sql = "SELECT RSV_NO FROM t_rsvs ORDER BY RSV_NO DESC LIMIT 1;";
        $query = DB::query($sql);
        $result = $query->execute()->as_array();

        if (count($result) == 0) {
            $array['0'] = '0';
        }else{
            $array['0'] = $result[0]['RSV_NO'];
        }

		//$sql = "SELECT RSV_NO FROM t_rsv_manages WHERE HTL_ID =".$h_id." ORDER BY RSV_NO DESC LIMIT 1;";
        $sql = "SELECT RSV_NO FROM t_rsv_manages ORDER BY RSV_NO DESC LIMIT 1;";
        $query = DB::query($sql);
        $result = $query->execute()->as_array();

        if (count($result) == 0) {
            $array['1'] = '0';
        }else{
            $array['1'] = $result[0]['RSV_NO'];
        }
        $max_rsv_no = max($array) + 1;

        $query = DB::insert('t_rsv_manages');
        $query->columns(array(
            'HTL_ID',
            'RSV_NO',
        ));

        $query->values(array(
            $h_id,
            $max_rsv_no,
        ));

        try {
            $query->execute();
        } catch (Exception $e) {
            return array('0' => '1', '1' => $e);
        }

        return array('0' => '0', '1' => $max_rsv_no);

    }

    // public function get_rsv_detail($h_id, $r_no)
    // {
    //     $query = DB::select('m_usrs.*', 't_rsv_manages.*')->from('t_rsv_manages');
    //     $query->where('t_rsv_manages.HTL_ID', '=', $h_id);
    //     $query->where('t_rsv_manages.RSV_NO', '=', $r_no);

    //     $query->join('t_rsvs', 'INNER');
    //     $query->on('t_rsvs.HTL_ID', '=', 't_rsv_manages.HTL_ID');
    //     $query->and_on('t_rsvs.RSV_NO', '=', 't_rsv_manages.RSV_NO');

    //     $result = $query->execute()->as_array();


    //     foreach ($result as $key => $value) {
    //         $result[$key]['STAYDATE'] = date('Y/m/d', strtotime($value['STAYDATE']));
    //     }

    //     return $result;

    // }


}
