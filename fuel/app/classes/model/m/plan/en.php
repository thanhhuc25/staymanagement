<?php

class Model_M_Plan_En extends Model_Crud
{
	protected static $_properties = array(
    'HTL_ID',
    'PLN_ID',
    'PLN_EN_NAME',
    'PLN_CAP_PC',
    'PLN_CAP_PC_LIGHT',
    'EN_PLAN_USE_FLG',
    'CH_PLAN_USE_FLG',
    'CHH_PLAN_USE_FLG',
    'KO_PLAN_USE_FLG',
	);

	protected static $_table_name = 'm_plan_ens';




    public function delete_en_one($h_id, $p_id)
    {
        $query = DB::delete('m_plan_ens');
        $query->where('HTL_ID', '=', $h_id);
        $query->and_where('PLN_ID', '=', $p_id);

        $result = $query->execute();
        return $result;
    }


    public function insert_en($h_id, $p_id)
    {
        $query = DB::insert('m_plan_ens')->set(array(
          'HTL_ID' => $h_id,
          'PLN_ID' => $p_id
          ));

        $result = $query->execute();
        return $result;

    }

}