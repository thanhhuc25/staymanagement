<?php

namespace Fuel\Migrations;

class Create_m_co_logins
{
	public function up()
	{
		\DBUtil::create_table('m_co_logins', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'HTL_ID' => array('constraint' => 6, 'type' => 'varchar'),
			'CO_ID' => array('constraint' => 10, 'type' => 'smallint'),
			'CO_NAME' => array('constraint' => 100, 'type' => 'varchar'),
			'CO_NAME_KANA' => array('constraint' => 100, 'type' => 'varchar'),
			'LOGIN_ID' => array('constraint' => 12, 'type' => 'varchar'),
			'LOGIN_PWD' => array('constraint' => 12, 'type' => 'varchar'),
			'RANK_ID' => array('constraint' => 6, 'type' => 'varchar'),
			'ZIP_CD' => array('constraint' => 10, 'type' => 'varchar'),
			'PREF_CD' => array('constraint' => 6, 'type' => 'varchar'),
			'CO_ADR1' => array('constraint' => 45, 'type' => 'varchar'),
			'CO_ADR２' => array('constraint' => 45, 'type' => 'varchar'),
			'CO_TEL' => array('constraint' => 15, 'type' => 'varchar'),
			'CO_FAX' => array('constraint' => 15, 'type' => 'varchar'),
			'CO_MAIL' => array('constraint' => 45, 'type' => 'varchar'),
			'MEMO' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('m_co_logins');
	}
}