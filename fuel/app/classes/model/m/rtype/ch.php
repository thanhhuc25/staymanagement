<?php

class Model_M_Rtype_Ch extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'TYPE_ID',
		'TYPE_NAME',
		'RM_USE_FLG',
		'UP_DATE',
	);

	protected static $_table_name = 'm_rtype_chs';

  public function delete_ch_one($h_id, $t_id)
  {
    $query = DB::delete('m_rtype_chs');
    $query->where('HTL_ID', '=', $h_id);
    $query->and_where('TYPE_ID', '=', $t_id);

    $result = $query->execute();
    return $result;
  }



  public function insert_ch($h_id, $t_id)
  {
    $query = DB::insert('m_rtype_chs')->set(array(
      'HTL_ID' => $h_id,
      'TYPE_ID' => $t_id
      ));

    $result = $query->execute();
    return $result;

  }

}
