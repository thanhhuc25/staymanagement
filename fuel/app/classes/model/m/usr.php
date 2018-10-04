<?php

class Model_M_Usr extends Model_Crud
{
	protected static $_properties = array(
		'USR_ID',
		'USR_NAME',
		'USR_KANA',
		'USR_SEI',
		'USR_MEI',
    'KANA_SEI',
    'KANA_MEI',
		'INF_TYPE',
		'ORG_NAME',
		'ORG_KANA',
		'ZIP_CD',
		'USR_PREF_CD',
		'USR_ADR1',
		'USR_ADR2',
		'USR_TEL',
		'USR_FAX',
		'USR_EM_TEL',
		'USR_SEX',
		'USR_BIRTH',
		'USR_DISP_FLG',
		'MAG_ALLOW',
		'UP_DATE',
		'USR_PWD',
		'CO_ID',
		'RANK_ID',
		'USR_MAIL',
    'USR_MAIL2',
    'USR_MAIL3',
		'USR_POINTS',
		'REG_DATE',
		'MEMO',
	);

	protected static $_table_name = 'm_usrs';
	protected static $_primary_key = 'USR_ID';

	public function get_user_one($mail_address)
	{
		$query = DB::select()->from('m_usrs');
		$query->where('USR_MAIL', '=', $mail_address);
    $query->and_where('RANK_ID','=','1');
		$result = $query->execute()->as_array();

		if (count($result)==0) {
			return 1;
		}else{
			return $result[0];
		}
	}


	public function insert_user($param)
	{
		$query = DB::insert('m_usrs')->set(array(
       'USR_NAME' => $param['USR_NAME'],
       'USR_KANA' => $param['USR_KANA'],
       'USR_SEI' => $param['USR_SEI'],
       'USR_MEI' => $param['USR_MEI'],
       'KANA_SEI' => $param['KANA_SEI'],
       'KANA_MEI' => $param['KANA_MEI'],
       // 'INF_TYPE' => $param[''],
       'ZIP_CD' => $param['ZIP_CD'],
       // 'USR_PREF_C' => $param[''],
       'USR_ADR1' => $param['USR_ADR1'],
       'USR_ADR2' => $param['USR_ADR2'],
       'USR_TEL' => $param['USR_TEL'],
       'USR_FAX' => $param['USR_FAX'],
       'USR_SEX' => $param['USR_SEX'],
       'USR_BIRTH' => $param['USR_BIRTH'],
       // 'MAG_ALLOW' => $param['MAG_ALLOW'],
       // 'USR_PWD' => $param['USR_PWD'],
       'RANK_ID' => $param['RANK_ID'],
       'USR_MAIL' => $param['USR_MAIL'],
       // 'USR_POINTS' => $param[''],
			));
		$result = $query->execute();
		return $result;
	}


  public function update_user($param)
  {
    $query = DB::update('m_usrs');

    if(isset($param['USR_NAME'])){
      $query->value('USR_NAME', $param['USR_NAME']);
    }
    if(isset($param['USR_KANA'])){
      $query->value('USR_KANA', $param['USR_KANA']);
    }
    if(isset($param['USR_SEI'])){
      $query->value('USR_SEI', $param['USR_SEI']);
    }
    if(isset($param['USR_MEI'])){
      $query->value('USR_MEI', $param['USR_MEI']);
    }
    if(isset($param['KANA_SEI'])){
      $query->value('KANA_SEI', $param['KANA_SEI']);
    }
    if(isset($param['KANA_MEI'])){
      $query->value('KANA_MEI', $param['KANA_MEI']);
    }
    if(isset($param['ZIP_CD'])){
      $query->value('ZIP_CD', $param['ZIP_CD']);
    }
    if(isset($param['USR_ADR1'])){
      $query->value('USR_ADR1', $param['USR_ADR1']);
    }
    if(isset($param['USR_ADR2'])){
      $query->value('USR_ADR2', $param['USR_ADR2']);
    }
    if(isset($param['USR_TEL'])){
      $query->value('USR_TEL', $param['USR_TEL']);
    }
    if(isset($param['USR_FAX'])){
      $query->value('USR_FAX', $param['USR_FAX']);
    }
    if(isset($param['USR_SEX'])){
      $query->value('USR_SEX', $param['USR_SEX']);
    }
    if(isset($param['USR_BIRTH'])){
      $query->value('USR_BIRTH', $param['USR_BIRTH']);
    }
    if(isset($param['MAG_ALLOW'])){
      $query->value('MAG_ALLOW', $param['MAG_ALLOW']);
    }
    if(isset($param['USR_PWD'])){
      $query->value('USR_PWD', $param['USR_PWD']);
    }
    if(isset($param['RANK_ID'])){
      $query->value('RANK_ID', $param['RANK_ID']);
    }
    if(isset($param['USR_MAIL'])){
      $query->value('USR_MAIL', $param['USR_MAIL']);
    }
    // if(isset($param['USR_MAIL2'])){
    //   $query->value('USR_MAIL2', $param['USR_MAIL2']);
    // }
    // if(isset($param['USR_MAIL3'])){
    //   $query->value('USR_MAIL3', $param['USR_MAIL3']);
    // }


    $query->where('USR_ID','=', $param['USR_ID']);
    $result =$query->execute();

    return $result;


  }
	

}//Class
