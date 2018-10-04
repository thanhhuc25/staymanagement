<?php

class Model_M_Co_Login extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'CO_ID',
		'CO_NAME',
		'CO_NAME_KANA',
		'LOGIN_ID',
		'LOGIN_PWD',
		'RANK_ID',
		'ZIP_CD',
		'PREF_CD',
		'CO_ADR1',
		'CO_ADR２',
		'CO_TEL',
		'CO_FAX',
		'CO_MAIL',
		'MEMO',
	);


	protected static $_table_name = 'm_co_logins';


	public function get_user($data)
	{
		$user = Model_M_Co_Login::find_one_by('LOGIN_ID', $data);

		if ($user == null) {
			return null;
		}else{
			return $user;
		}
	}

}
