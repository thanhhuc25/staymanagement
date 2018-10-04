<?php

class Model_M_Credit extends Model_Crud
{
	protected static $_properties = array(
		'CRE_ID',
		'HTL_ID',
		'USR_ID',
		'CRE_CARD_CD',
		'CRE_NAME',
		'CRE_COMPANY_NAME',
    'CRE_MONTH',
    'CRE_YEAR',
	);

	protected static $_table_name = 'm_credits';
  protected static $_primary_key = 'CRE_ID';



}