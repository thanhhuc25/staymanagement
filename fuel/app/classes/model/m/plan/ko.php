<?php

class Model_M_Plan_Ko extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'PLN_ID',
		'PLN_KO_NAME',
		'PLN_CAP_PC',
		'PLN_CAP_PC_LIGHT',
	);

	protected static $_table_name = 'm_plan_kos';


  public function delete_ko_one($h_id, $p_id)
  {
    $query = DB::delete('m_plan_kos');
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('PLN_ID', '=', $p_id);

    $result = $query->execute();
    return $result;
  }



  public function insert_ko($h_id, $p_id)
  {
    $query = DB::insert('m_plan_kos')->set(array(
      'HTL_ID' => $h_id,
      'PLN_ID' => $p_id
      ));

    $result = $query->execute();
    return $result;

  }


}
