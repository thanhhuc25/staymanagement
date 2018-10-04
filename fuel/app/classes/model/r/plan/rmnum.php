<?php

class Model_R_Plan_Rmnum extends Model_Crud
{
  protected static $_properties = array(
    'HTL_ID',
    'PLN_ID',
    'TYPE_ID',
    'EXCEPTIONDAY',
    'EX_RMNUM',
    'STOP_FLG',
    'WEEK_STOP_RELEASE',
    'UP_DATE',
  );

  protected static $_table_name = 'r_plan_rmnums';

    public function get_one_rmnum($h_id, $p_id, $t_id, $date)
    {
        $query = DB::select()->from('r_plan_rmnums');
        $query->where('HTL_ID', '=', $h_id);
        $query->where('TYPE_ID', '=', $t_id);
        $query->and_where('PLN_ID', '=', $p_id);
        $query->and_where('EXCEPTIONDAY', '=', $date );

        $result = $query->execute()->as_array();
        return $result;
    }

    public function get_all_rmnum($h_id, $t_id)
    {
        $query = DB::select('PLN_ID', 'EXCEPTIONDAY', 'STOP_FLG')->from('r_plan_rmnums');
        $query->where('HTL_ID', '=', $h_id);
        $query->and_where('TYPE_ID', '=', $t_id);
        // $query->and_where('STOP_FLG', '=', '1');

        $result = $query->execute()->as_array();

        return $result;
    }

    public function update_rmnum($h_id, $p_id, $t_id, $date, $flg)
    {
        $query = DB::update('r_plan_rmnums');
        $query->value('STOP_FLG',$flg);
        $query->where('HTL_ID', '=', $h_id);
        $query->and_where('TYPE_ID', '=', $t_id);
        $query->and_where('PLN_ID', '=', $p_id);
        $query->and_where('EXCEPTIONDAY', '=', $date);

        $result = $query->execute();

    }

    public function update_rmnum_all($h_id, $t_id, $date, $flg)
    {
        $query = DB::update('r_plan_rmnums');
        $query->value('STOP_FLG',$flg);
        $query->where('HTL_ID', '=', $h_id);
        $query->and_where('TYPE_ID', '=', $t_id);
        // $query->and_where('PLN_ID', '=', $p_id);
        $query->and_where('EXCEPTIONDAY', '=', $date);

        $result = $query->execute();
    }

    public function insert_rmnum($h_id, $p_id, $t_id, $date, $flg)
    {
        $query=DB::insert('r_plan_rmnums')->set(array(
            'HTL_ID' => $h_id,
            'EXCEPTIONDAY' => $date,
            'TYPE_ID' => $t_id,
            'PLN_ID' => $p_id,
            // 'NUM',
            'STOP_FLG' => $flg,
          ));

        $result = $query->execute();

    }


    public function get_plan_rmnum_for_api($param)
    {
        $param['DayStart'] = date('Y-m-d', strtotime($param['DayStart']));
        $param['DayEnd'] = date('Y-m-d', strtotime($param['DayEnd']));

        /*---------------------------------------------------*/
        $param['DayStart'] = date('Y-m-d', strtotime('first day of ' . $param['DayStart']));
        $param['DayEnd'] = date('Y-m-d', strtotime('last day of ' . $param['DayEnd']));
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        /*---------------------------------------------------*/       


        $query = DB::select()->from('r_plan_rmnums');
        $query->where('HTL_ID', '=', $param['HTL_ID']);
        $query->and_where('TYPE_ID', '=', $param['HeyaID']);
        $query->and_where('PLN_ID', '=', $param['PlanID']);
        $query->and_where('EXCEPTIONDAY', 'between', array($param['DayStart'], $param['DayEnd']));
        $result = $query->execute()->as_array('EXCEPTIONDAY');

        return $result;
    }


    public function delete_pln_rm($h_id, $p_id, $t_id)
    {
        $query = DB::delete('r_plan_rmnums');
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


}// Class end