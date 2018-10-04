<?php

class Model_M_Plan_Ch extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'PLN_ID',
		'PLN_CH_NAME',
		'PLN_CAP_PC',
		'PLN_CAP_PC_LIGHT',
	);

	protected static $_table_name = 'm_plan_chs';


  public function delete_ch_one($h_id, $p_id)
  {
    $query = DB::delete('m_plan_chs');
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('PLN_ID', '=', $p_id);

    $result = $query->execute();
    return $result;
  }



  public function insert_ch($h_id, $p_id)
  {
    $query = DB::insert('m_plan_chs')->set(array(
      'HTL_ID' => $h_id,
      'PLN_ID' => $p_id
      ));

    $result = $query->execute();
    return $result;

  }




}
