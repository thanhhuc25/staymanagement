<?php

class Model_M_Rtype_Chh extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'TYPE_ID',
		'TYPE_NAME',
		'RM_USE_FLG',
		'UP_DATE',
	);

	protected static $_table_name = 'm_rtype_chhs';

  public function delete_chh_one($h_id, $t_id)
  {
    $query = DB::delete('m_rtype_chhs');
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('TYPE_ID', '=', $t_id);

    $result = $query->execute();
    return $result;
  }



  public function insert_chh($h_id, $t_id)
  {
    $query = DB::insert('m_rtype_chhs')->set(array(
      'HTL_ID' => $h_id,
      'TYPE_ID' => $t_id
      ));

    $result = $query->execute();
    return $result;

  }

}
