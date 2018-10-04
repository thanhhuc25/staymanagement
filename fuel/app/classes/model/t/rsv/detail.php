<?php

class Model_T_Rsv_Detail extends Model_Crud
{
  protected static $_properties = array(
    'HTL_ID',
    'RSV_NO',
    'IN_DATE',
    'STAYDATE',
    'SEQ_ROOM',
    'TYPE_ID',
    'TYPE_NAME',
    'PLN_ID',
    'PLN_NUM_MAN',
    'PLN_NUM_WOMAN',
    'PLN_NUM_CHILD1',
    'PLN_NUM_CHILD2',
    'PLN_NUM_CHILD3',
    'PLN_NUM_CHILD4',
    'PLN_NUM_CHILD5',
    'PLN_NUM_CHILD6',
    'PLN_CHG_MAN',
    'PLN_CHG_WOMAN',
    'PLN_CHG_CHILD1',
    'PLN_CHG_CHILD2',
    'PLN_CHG_CHILD3',
    'PLN_CHG_CHILD4',
    'PLN_CHG_CHILD5',
    'PLN_CHG_CHILD6',
    'RVC_FLG',
    'UP_DATE',
  );

  protected static $_table_name = 't_rsv_details';


    public function get_rsv_detail($h_id, $r_no)
    {
        $query = DB::select('m_usrs.*', 't_rsv_details.*')->from('t_rsv_details');
        $query->where('t_rsv_details.HTL_ID', '=', $h_id);
        $query->where('t_rsv_details.RSV_NO', '=', $r_no);

        $query->join('t_rsvs', 'INNER');
        $query->on('t_rsvs.HTL_ID', '=', 't_rsv_details.HTL_ID');
        $query->and_on('t_rsvs.RSV_NO', '=', 't_rsv_details.RSV_NO');

        $query->join('m_usrs', 'INNER');
        $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');
        // $query->group_by('t_rsv_details.SEQ_ROOM');

        $result = $query->execute()->as_array();


        foreach ($result as $key => $value) {
            $result[$key]['STAYDATE'] = date('Y/m/d', strtotime($value['STAYDATE']));
        }

        return $result;

    }


    public function get_rsv_detail_neppan($h_id, $r_no)
    {
        $query = DB::select(
            't_rsv_details.*',
            't_rsvs.*',
            'm_plans.PLN_NAME',
            'm_plans.PLN_ID',
            'm_rtypes.*',
            'm_htls.HTL_NAME',
            'm_htls.HTL_NNAME',
            'm_usrs.*',
            array('t_rsvs.IN_DATE','rsvsIN_DATE'), 
            array('t_rsv_details.IN_DATE','rsv_detailsIN_DATE'))->from('t_rsv_details'
            );
        $query->join('t_rsvs', 'INNER');
        $query->on('t_rsvs.HTL_ID', '=', 't_rsv_details.HTL_ID');
        $query->and_on('t_rsvs.RSV_NO', '=', 't_rsv_details.RSV_NO');

        $query->join('m_htls', 'INNER');
        $query->on('m_htls.HTL_ID', '=', 't_rsv_details.HTL_ID');
        
        $query->join('m_usrs', 'INNER');
        $query->on('m_usrs.USR_ID', '=', 't_rsvs.USR_ID');

        $query->join('m_plans', 'INNER');
        $query->on('m_plans.HTL_ID', '=', 't_rsv_details.HTL_ID');
        $query->and_on('m_plans.PLN_ID', '=' , 't_rsv_details.PLN_ID');

        $query->join('m_rtypes', 'INNER');
        $query->on('m_rtypes.HTL_ID', '=', 't_rsv_details.HTL_ID');
        $query->and_on('m_rtypes.TYPE_ID', '=' , 't_rsv_details.TYPE_ID');

        $query->where('t_rsv_details.HTL_ID', '=', $h_id);
        $query->and_where('t_rsv_details.RSV_NO', '=', $r_no);

        $result = $query->execute()->as_array();

        if (count($result) == 0) {
            return 0;
        }

        $rsv_data = array();
        $rsv_data2 = array();
        $basic_info = array();
        foreach ($result as $key => $value) {
            $rsv_data[ $value['STAYDATE'] ][ $value['SEQ_ROOM'] ] = $value;
            $rsv_data2[ $value['TYPE_ID'] ][ $value['STAYDATE'] ] = $value;
            if ( $basic_info == null ) {
                $basic_info = $value;
            }
        }


        return array($basic_info, $rsv_data2);
    }

}