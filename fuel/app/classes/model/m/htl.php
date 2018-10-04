<?php

class Model_M_Htl extends Model_Crud
{
	protected static $_properties = array(
    'HTL_ID',
    'GRP_ID',
    'AREA_NAME',
    'HTL_TYPE',
    'HTL_NAME',
    'HTL_NNAME',
    'HTL_RNAME',
    'HTL_HEADER_TAG',
    'HTL_FOOTER_TAG',
    'HTL_ZIP',
    'HTL_PREF_CD',
    'HTL_ADR1',
    'HTL_ADR2',
    'HTL_TEL',
    'HTL_FAX',
    'HTL_MAIL',
    'IN_TIME',
    'IN_TIME_LIMIT',
    'CHECK_USE_FLG',
    'OUT_TIME',
    'DISPLAY_MODE',
    'RESULT_COUNT',
    'RTYPE_DISP_MODE',
    'CATE_DISP_MODE',
    'CAUTION_DISP_MODE',
    'STAY_RULE_MODE',
    'STAY_RULE',
    'STAY_RULE_URL',
    'RTN_URL',
    'RTN_MO_URL',
    'RTN_URL',
    'CO_CATEGORY_NAME',
    'DISP_VAC',
    'DISP_TERM',
    'REVAC_FLG',
    'CAL_TYPE',
    'LANG_USE_FLG',
    'LANG_SELECT_FLG',
    'CP_USE_FLG',
    'PS_USE_FLG',
    'POINT_APPLICATION',
    'POINT_SYS_FLG',
    'POINT_APPLY_FLG',
    'POINT_RATE',
    'POINT',
    'POINT_ADJ',
    'NEW_POINT_SYS_FLG',
    'NEW_POINT_APPLY_FLG',
    'NEW_POINT_RATE',
    'NEW_POINT',
    'NEW_POINT_PLUS_FLG',
    'POINT_URL',
    'POINT_URL_EN',
    'ADMIN_ID',
    'ADMIN_PWD',
    'ADMIN_CONTACT',
    'BATH_TAX',
    'SVC_TAX',
    'HTL_TAX',
    'MAIL_CFM_TITLE',
    'MAIL_CFM',
    'MAIL_DEBIT_CFM',
    'MAIL_CCL_TITLE',
    'MAIL_CCL',
    'MAIL_ADCCL',
    'MAIL_BFR',
    'BFR_USE_FLG',
    'BFR_USE_DAY',
    'BFR_USE_TIME',
    'MAIL_THK',
    'THK_USE_FLG',
    'THK_USE_DAY',
    'THK_USE_TIME',
    'MAIL_REM',
    'MAIL_MAG',
    'MO_MAIL_CFM',
    'MO_MAIL_CCL',
    'MO_MAIL_BFR',
    'MO_MAIL_REM',
    'HOLIDAY_MODE',
    'UP_DATE',
    'MEMBER_CODE',
    'MOB_FOOTER',
    'MOB_INFO',
    'MOB_BG_COLOR',
    'MOB_TXT_COLOR',
    'SITE_CONTROLLER_FLG',
    'QUESTION',
    'INFO',
    'ART_LINK_FLG',
    'ART_ACCOUNT_KEY',
    'ART_ACCOUNT_SECRET',
	);

	protected static $_table_name = 'm_htls';
    protected static $_primary_key = 'HTL_ID';
	
	public function get_htl()
    {
        $query = DB::select()->from('m_htls');
        $result = $query->execute()->as_array();

        return $result;
    }


    public function get_Admin($l_id)
    {
        $query = DB::select()->from('m_htls');
        $query->where('ADMIN_ID', '=', $l_id);
        $result = $query->execute()->as_array();

        if (count($result) == 0) {
            return null;
        }
        return $result[0];
    }


    public function get_user($data)
    {
        $user = Model_M_Htl::find_one_by('ADMIN_ID', $data);

        if ($user == null) {
            return null;
        }else{
            return $user;
        }
    }

    public function update_htl($a_id, $param)
    {
        $query = DB::update('m_htls');
        foreach ($param as $key => $value) {
            $query->value($value['colname'], $value['value']);            
        }
        $query->where('ADMIN_ID', '=', $a_id);

        $result = $query->execute();
        return $result;
    }

}//Class
