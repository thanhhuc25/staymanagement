<?php

namespace Fuel\Migrations;

class Create_m_plans
{
	public function up()
	{
		\DBUtil::create_table('m_plans', array(
			'HTL_ID' => array('constraint' => 6, 'type' => 'smallint'),
			'PLN_ID' => array('constraint' => 6, 'type' => 'smallint'),
			'PLN_TYPE' => array('constraint' => 1, 'type' => 'char'),
			'PLN_NAME' => array('constraint' => 100, 'type' => 'varchar'),
			'TERM_ID_START' => array('constraint' => 4, 'type' => 'tinyint'),
			'TERM_ID_END' => array('constraint' => 4, 'type' => 'tinyint'),
			'PLAN_START' => array('type' => 'date'),
			'PLAN_END' => array('type' => 'date'),
			'USE_TIMESALE' => array('constraint' => 1, 'type' => 'tinyint'),
			'TIMESALE_START' => array('type' => 'tme'),
			'TIMESALE_END' => array('type' => 'tme'),
			'DISP_START' => array('type' => 'date'),
			'DISP_END' => array('type' => 'date'),
			'PLN_LIMIT_DAY' => array('constraint' => 4, 'type' => 'tinyint'),
			'PLN_LIMIT_TIME' => array('constraint' => 4, 'type' => 'tinyint'),
			'PLN_STAY_LOWER' => array('constraint' => 3, 'type' => 'tinyint'),
			'PLN_STAY_UPPER' => array('constraint' => 3, 'type' => 'tinyint'),
			'DAYTRIP' => array('constraint' => 1, 'type' => 'tinyint'),
			'PLN_ROOM_LOWER' => array('constraint' => 3, 'type' => 'tinyint'),
			'PLN_ROOM_UPPER' => array('constraint' => 3, 'type' => 'tinyint'),
			'ADJUST_TYPE' => array('constraint' => 6, 'type' => 'smallint'),
			'PLN_TAX' => array('constraint' => 1, 'type' => 'tinyint'),
			'ROOM_DISP_FLG' => array('constraint' => 1, 'type' => 'tinyint'),
			'MEAL_DELIV_FLG' => array('constraint' => 1, 'type' => 'tinyint'),
			'PLN_BRK' => array('constraint' => 6, 'type' => 'smallint'),
			'PLN_DIN' => array('constraint' => 6, 'type' => 'smallint'),
			'PLN_CAP_PC' => array('type' => 'text'),
			'PLN_CAP_PC_LIGHT' => array('type' => 'text'),
			'PLN_CAP_MOB' => array('type' => 'text'),
			'PLN_POINTS_FLG' => array('constraint' => 4, 'type' => 'tinyint'),
			'PLN_POINTS' => array('constraint' => 6, 'type' => 'smallint'),
			'PLN_USE_FLG' => array('constraint' => 4, 'type' => 'tinyint'),
			'CATEGORY_ID' => array('constraint' => 6, 'type' => 'smallint'),
			'CATEGORY2_ID' => array('constraint' => 6, 'type' => 'smallint'),
			'CATEGORY3_ID' => array('constraint' => 6, 'type' => 'smallint'),
			'RANK_ID' => array('constraint' => 6, 'type' => 'smallint'),
			'DISP_ORDER' => array('constraint' => 11, 'type' => 'int'),
			'UP_DATE' => array('type' => 'timestamp'),
			'EQUIPMENT' => array('constraint' => 1, 'type' => 'tinyint'),
			'JP_LANG_USE_FLG' => array('constraint' => 1, 'type' => 'tinyint'),
			'CHECK_IN' => array('type' => 'text'),
			'QUESTION' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('m_plans');
	}
}