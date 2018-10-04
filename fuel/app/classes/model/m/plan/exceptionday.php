<?php

class Model_M_Plan_Exceptionday extends Model_Crud
{
	protected static $_properties = array(
    'HTL_ID',
    'PLN_ID',
    'TYPE_ID',
    // 'TARIFF_ID',
    'EXCEPTIONDAY',
    'PLN_CHG_EXCEPTION',
    'PLN_CHG_EXCEPTION1',
    'PLN_CHG_EXCEPTION2',
    'PLN_CHG_EXCEPTION3',
    'PLN_CHG_EXCEPTION4',
    'PLN_CHG_EXCEPTION5',
    'PLN_CHG_EXCEPTION6',
    'NUM',
    'UP_DATE',
	);

	protected static $_table_name = 'm_plan_exceptiondays';

    public function get_one_exday($h_id, $p_id, $t_id, $date)
    {
        $query = DB::select()->from('m_plan_exceptiondays');
        $query->where('HTL_ID', '=', $h_id);
        $query->where('TYPE_ID', '=', $t_id);
        $query->and_where('PLN_ID', '=', $p_id);
        $query->and_where('EXCEPTIONDAY', '=', $date );

        $result = $query->execute()->as_array();
        return $result;
    }



    public function get_exceptionday($h_id, $p_id, $s, $e)
    {
        $query = DB::select()->from('m_plan_exceptiondays');
        $query->where('EXCEPTIONDAY', 'between', array($s, $e));
        $query->and_where('HTL_ID', $h_id);
        $query->and_where('PLN_ID', $p_id);
        $result = $query->execute()->as_array();

        return $result;
    }


    public function insert_exceptionday($h_id, $p_id, $t_id, $date, $num, $price)
    {       

        $sql = "INSERT INTO m_plan_exceptiondays(HTL_ID, PLN_ID, TYPE_ID, EXCEPTIONDAY, PLN_CHG_EXCEPTION".$num.") 
                SELECT HTL_ID, PLN_ID, TYPE_ID, '".$date."', ".$price." - PLN_CHG_PERSON".$num." FROM m_plan_rtypes
                WHERE HTL_ID=".$h_id." AND PLN_ID=".$p_id." AND TYPE_ID=".$t_id.";
        ";

        $result = DB::query($sql)->execute();
        return $result;
    }



    public function update_exceptionday($h_id, $p_id, $t_id, $date, $num, $price)
    {

        $sql = "UPDATE m_plan_exceptiondays AS mpe SET PLN_CHG_EXCEPTION".$num."= 
        (SELECT ".$price."- PLN_CHG_PERSON".$num." FROM m_plan_rtypes mpr WHERE mpr.HTL_ID = mpe.HTL_ID AND mpr.PLN_ID = mpe.PLN_ID AND mpr.TYPE_ID = mpe.TYPE_ID ) 
        WHERE mpe.HTL_ID=".$h_id." AND mpe.PLN_ID=".$p_id." AND mpe.TYPE_ID=".$t_id." AND mpe.EXCEPTIONDAY='".$date."';
        ";

        $result = DB::query($sql)->execute();
    }


    /*
        tema036で使用
    */
    public function get_ins_up_for_api($h_id, $p_id, $t_id, $date, $param)
    {
        $sql = "
            SELECT * FROM m_plan_rtypes mpr
            LEFT JOIN m_plan_exceptiondays mpe
            ON mpe.HTL_ID = mpr.HTL_ID AND mpe.PLN_ID = mpr.PLN_ID AND mpe.TYPE_ID = mpr.TYPE_ID AND mpe.EXCEPTIONDAY = '".$date."'

            WHERE mpr.HTL_ID = ".$h_id." AND mpr.PLN_ID = ".$p_id." AND mpr.TYPE_ID = ".$t_id."
        ";

        $query = DB::query($sql);
        $result = $query->execute()->as_array();

        if (count($result) == 0) {
           return 9;
        }


        if ($result[0]['EXCEPTIONDAY'] == null) {
            $query = DB::insert('m_plan_exceptiondays');
            $values = array(
                'HTL_ID' => $h_id,
                'PLN_ID' => $p_id,
                'TYPE_ID' => $t_id,
                'EXCEPTIONDAY' => $date,
                );
    
            if (isset($param['1'])) {
                $values['PLN_CHG_EXCEPTION1'] = $param['1'] - $result[0]['PLN_CHG_PERSON1'];
            }

            if (isset($param['2'])) {
                $values['PLN_CHG_EXCEPTION2'] = $param['2'] - $result[0]['PLN_CHG_PERSON2'];
            }

            if (isset($param['3'])) {
                $values['PLN_CHG_EXCEPTION3'] = $param['3'] - $result[0]['PLN_CHG_PERSON3'];
            }

            if (isset($param['4'])) {
                $values['PLN_CHG_EXCEPTION4'] = $param['4'] - $result[0]['PLN_CHG_PERSON4'];
            }

            if (isset($param['5'])) {
                $values['PLN_CHG_EXCEPTION5'] = $param['5'] - $result[0]['PLN_CHG_PERSON5'];
            }

            if (isset($param['6'])) {
                $values['PLN_CHG_EXCEPTION6'] = $param['6'] - $result[0]['PLN_CHG_PERSON6'];
            }

            $query->set($values);

            $result = $query->execute();
        }else{
            $query = DB::update('m_plan_exceptiondays');

            if (isset($param['1'])) {
                $query->value('PLN_CHG_EXCEPTION1',$param['1'] - $result[0]['PLN_CHG_PERSON1']);
            }

            if (isset($param['2'])) {
                $query->value('PLN_CHG_EXCEPTION2',$param['2'] - $result[0]['PLN_CHG_PERSON2']);
            }

            if (isset($param['3'])) {
                $query->value('PLN_CHG_EXCEPTION3',$param['3'] - $result[0]['PLN_CHG_PERSON3']);
            }

            if (isset($param['4'])) {
                $query->value('PLN_CHG_EXCEPTION4',$param['4'] - $result[0]['PLN_CHG_PERSON4']);
            }

            if (isset($param['5'])) {
                $query->value('PLN_CHG_EXCEPTION5',$param['5'] - $result[0]['PLN_CHG_PERSON5']);
            }

            if (isset($param['6'])) {
                $query->value('PLN_CHG_EXCEPTION6',$param['6'] - $result[0]['PLN_CHG_PERSON6']);
            }

            $query->where('HTL_ID', '=', $h_id);
            $query->and_where('PLN_ID', '=', $p_id);
            $query->and_where('TYPE_ID', '=', $t_id);
            $query->and_where('EXCEPTIONDAY', '=', $date);

            $result = $query->execute();
        }


        return $result;
    }



    public function delete_exceptionday($h_id, $p_id, $t_id)
    {
        $query = DB::delete('m_plan_exceptiondays');
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


    // public function get_all_exday($h_id, $t_id)
    // {
    //     $query = DB::select('PLN_ID', 'EXCEPTIONDAY', 'STOP_FLG')->from('m_plan_exceptiondays');
    //     $query->where('HTL_ID', '=', $h_id);
    //     $query->and_where('TYPE_ID', '=', $t_id);
    //     // $query->and_where('STOP_FLG', '=', '1');

    //     $result = $query->execute()->as_array();

    //     return $result;
    // }

    // public function update_pex($h_id, $p_id, $t_id, $date, $flg)
    // {
    //     $query = DB::update('m_plan_exceptiondays');
    //     $query->value('STOP_FLG',$flg);
    //     $query->where('HTL_ID', '=', $h_id);
    //     $query->and_where('TYPE_ID', '=', $t_id);
    //     $query->and_where('PLN_ID', '=', $p_id);
    //     $query->and_where('EXCEPTIONDAY', '=', $date);

    //     $result = $query->execute();

    // }

    // public function update_pex_all($h_id, $t_id, $date, $flg)
    // {
    //     $query = DB::update('m_plan_exceptiondays');
    //     $query->value('STOP_FLG',$flg);
    //     $query->where('HTL_ID', '=', $h_id);
    //     $query->and_where('TYPE_ID', '=', $t_id);
    //     // $query->and_where('PLN_ID', '=', $p_id);
    //     $query->and_where('EXCEPTIONDAY', '=', $date);

    //     $result = $query->execute();
    // }

    // public function insert_pex($h_id, $p_id, $t_id, $date, $flg)
    // {
    //     $query=DB::insert('m_plan_exceptiondays')->set(array(
    //         'HTL_ID' => $h_id,
    //         'EXCEPTIONDAY' => $date,
    //         'TYPE_ID' => $t_id,
    //         'PLN_ID' => $p_id,
    //         // 'NUM',
    //         'STOP_FLG' => $flg,
    //       ));

    //     $result = $query->execute();

    // }
}