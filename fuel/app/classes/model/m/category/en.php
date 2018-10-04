<?php

class Model_M_Category_En extends Model_Crud
{
	protected static $_properties = array(
		'HTL_ID',
		'CATEGORY_ID',
		'CATEGORY_NAME',
		'CATEGORY_DISP',
		'CATEGORY_ETC',
		'CATEGORY_USE_FLG',
		'UP_DATE',
	);

	protected static $_table_name = 'm_category_ens';
	// protected static $_primary_key = array('HTL_ID', 'CATEGORY_ID');
	

}