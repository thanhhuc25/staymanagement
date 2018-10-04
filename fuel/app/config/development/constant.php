<?php

define('MD5_SALT', 'riripo');

define('TITLE_PLAN', '宿泊プラン');
define('TITLE_PRICE', '料金管理');
define('TITLE_ROOM', '部屋タイプ');
define('TITLE_STOCK', '在庫管理');

define('TITLE_RESERVATION', '予約管理');
define('TITLE_CSV', '予約CSV出力');
define('TITLE_SETTING', 'アカウント設定');
define('TITLE_MAIL_SETTING', 'メール通知設定');
define('TITLE_HOTEL_SETTING', '施設情報設定');

//define('CLIENT_IP', '2019000871');
define('CLIENT_IP', '2014002000');


define('TITLE_PLANEDIT', '宿泊プランの編集');

define('EXPLODE', '_');
define('LIMIT_NUM', 10);

define('LOG_DIR', APPPATH.'logs/');
ini_set("error_log", LOG_DIR."error_log.log");


define('GOOGLE_API_KEY', 'AIzaSyCgEgZB8IwYaGmvaPSu_TwG_efiiac2-xE');

/*develop 用*/
define('HTTP', 'http://stay-manager.kontown.jp');
//define('HTTP', 'http://stay-manager.com:81');
// define('HTTP', 'http://52.198.203.99:81');
define('ST0', 'mp.SORT_NUM');
define('ST1', 'mp.PLN_ID');
define('ST2', 'mp.PLN_NAME');
define('ST3', 'mp.PLAN_START');
define('ST4', '(chh_flg+ch_flg+ko_flg+en_flg)');

define('CHECK_SALE', '販売する');
define('CHECK_STOP', '停止する');
define('CHECK_DELETE', '削除する');

define('IMG_FILE_PATH', DOCROOT.'assets/img/');
define('DISCOUNT', '3000');
define('DISCOUNT_POINT', '5');

/*メール*/
define('MAIL_SENDER', 'test@gmail.com');
define('SIGNUP_RSV_SUBJECT', '[GRIDS]登録確認メール 登錄確認信 Registation Confirmation Mail');
define('SIGNUP_RSV_BODY', "お客様は現在仮会員です。下記のURLからパスワードを設定してください。"."\n"."心あたりがない場合はこのメールを削除してください。 "."\n"."您現在的狀態是暫時會員。請由下列的網址設定您的密碼，如果您對此封信沒有印象請直接刪除這封信。"."\n"."You are a temporary member. Define a new password, accessing the URL below. You can erase this mail if you are not familiar with the message");

define('PASS_REMINDER_SUBJECT', '[GRIDS]パスワードリセット 密碼重設 Password reset');
define('PASS_REMINDER_BODY', "下記のURLからパスワードを再設定してください。\n心あたりがない場合はこのメールを削除してください。"."\n". "請由下列的網址重新設定您的密碼，如果您對此封信沒有印象請直接刪除這封信。"."\n". "Reset your password accessing the URL below. Feel free to erase this mail if it does not apply to you.");


/*ROUTING--------------------------------------------------------------------------*/

/*plan----------------------------------------*/

define('ROUTE_PLNLIST', 'front/plan');
define('URL_PLNLIST', 'plan');

define('ROUTE_PLNSEARCH', 'front/plan/search');
define('URL_PLNSEARCH', 'plan/search');

define('ROUTE_PLNSORT', 'front/plan/sort');
define('URL_PLNSORT', 'plan/sort');

define('ROUTE_PLNDETAIL', 'front/plan/detail/$1');
define('URL_PLNDETAIL', 'plan/detail/(:any)');

define('ROUTE_PLNDATE', 'front/plan/date/$1');
define('URL_PLNDATE', 'plan/date/(:any)');

define('ROUTE_PLNRECALCULATION', 'front/plan/recalculation');
define('URL_PLNRECALCULATION', 'plan/recalculation');

define('ROUTE_PLNPAGE', 'front/plan/page/$1');
define('URL_PLNPAGE', 'plan/page/(:num)');


define('ROUTE_INDEX', 'front/plan/index');
define('URL_INDEX', '');

/*reserve----------------------------------------*/


define('ROUTE_RESERVE', 'front/reserve/$1');
define('URL_RESERVE', 'reserve/(:any)');

define('ROUTE_RESERVE_CM', 'front/reserve/m_confirm');
define('URL_RESERVE_CM', 'reserve/m_confirm');

define('ROUTE_RESERVE_CNM', 'front/reserve/nm_confirm');
define('URL_RESERVE_CNM', 'reserve/nm_confirm');

define('ROUTE_RESERVE_ORDER', 'front/reserve/order');
define('URL_RESERVE_ORDER', 'reserve/order');

define('ROUTE_RESERVE_CANCEL', 'front/reserve/cancel');
define('URL_RESERVE_CANCEL', 'reserve/cancel');

define('ROUTE_RESERVE_EDIT', 'front/reserve/edit');
define('URL_RESERVE_EDIT', 'reserve/edit');

define('ROUTE_RESERVE_SAVE', 'front/reserve/save');
define('URL_RESERVE_SAVE', 'reserve/save');

define('ROUTE_RESERVE_CHECK', 'front/reserve/check');
define('URL_RESERVE_CHECK', 'reserve/check');


define('ROUTE_RESERVE_RA', 'front/reserve/registafter');
define('URL_RESERVE_RA', 'reserve/registafter');

define('ROUTE_RESERVE_SU', 'front/reserve/signup');
define('URL_RESERVE_SU', 'reserve/signup');

define('ROUTE_RESERVE_CREDIT_C', 'front/reserve/credit_confirm');
define('URL_RESERVE_CREDIT_C', 'reserve/credit_confirm');

define('ROUTE_RESERVE_CREDIT_S', 'front/reserve/credit_setting');
define('URL_RESERVE_CREDIT_S', 'reserve/credit_setting');
/*user----------------------------------------*/


define('ROUTE_MYPAGE', 'front/user/mypage');
define('URL_MYPAGE', 'mypage');

define('ROUTE_LOGIN', 'front/user');
define('URL_LOGIN', 'login');

define('ROUTE_LOGIN_A', 'front/user/login');
define('URL_LOGIN_A', 'login_a');

define('ROUTE_LOGOUT', 'front/user/logout');
define('URL_LOGOUT', 'logout');

define('ROUTE_RSVLOGIN', 'front/user/rsvlogin');
define('URL_RSVLOGIN', 'rsvlogin');

define('ROUTE_NMSIGNUP', 'front/user/nm_signup');
define('URL_NMSIGNUP', 'nm_signup');

define('ROUTE_NMCONF', 'front/user/nm_confirm');
define('URL_NMCONF', 'nm_confirm');


define('ROUTE_SIGNUP', 'front/user/signup');
define('URL_SIGNUP', 'signup');

define('ROUTE_REGIST', 'front/user/regist');
define('URL_REGIST', 'regist');

define('ROUTE_USER_EDIT', 'front/user/edit');
define('URL_USER_EDIT', 'mypage/edit');

define('ROUTE_USER_SAVE', 'front/user/save');
define('URL_USER_SAVE', 'mypage/save');

define('ROUTE_USER_PASSWORD', 'front/user/password');
define('URL_USER_PASSWORD', 'password');

define('ROUTE_USER_RESET', 'front/user/reset');
define('URL_USER_RESET', 'reset');

define('ROUTE_USER_RESET_C', 'front/user/reset_confirm');
define('URL_USER_RESET_C', 'reset_confirm');

define('ROUTE_USER_PASSWORD_RESET', 'front/user/password_reset');
define('URL_USER_PASSWORD_RESET', 'password_reset');

define('ROUTE_SETLANGUAGE', 'front/user/language/$1');
define('URL_SETLANGUAGE', 'language/(:any)');

/*secret----------------------------------------*/

define('ROUTE_SECRET', 'front/secret/$1');
define('URL_SECRET', 'secret/(:any)');

define('ROUTE_SECRET_LIST', 'front/secret/list');
define('URL_SECRET_LIST', 'secret/list');

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~別の施設を入れる場合はこの情報を設定していく~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


/*htl name----------------------------------------*/
define('HTL1', 'akihabara');

/*plan----------------------------------------*/

// define('ROUTE_PLNLIST_HTL1', 'front/plan');
define('URL_PLNLIST_HTL1', HTL1.'/'.URL_PLNLIST);

// define('ROUTE_PLNSEARCH_HTL1', 'front/plan/search');
define('URL_PLNSEARCH_HTL1', HTL1.'/'.URL_PLNSEARCH);

// define('ROUTE_PLNSORT_HTL1', 'front/plan/sort');
define('URL_PLNSORT_HTL1', HTL1.'/'.URL_PLNSORT);

// define('ROUTE_PLNDETAIL_HTL1', 'front/plan/detail/$1');
define('URL_PLNDETAIL_HTL1', HTL1.'/'.URL_PLNDETAIL);

// define('ROUTE_PLNDATE_HTL1', 'front/plan/date/$1');
define('URL_PLNDATE_HTL1', HTL1.'/'.URL_PLNDATE);

// define('ROUTE_PLNRECALCULATION_HTL1', 'front/plan/recalculation');
define('URL_PLNRECALCULATION_HTL1', HTL1.'/'.URL_PLNRECALCULATION);

// define('ROUTE_PLNPAGE_HTL1', 'front/plan/page/$1');
define('URL_PLNPAGE_HTL1', HTL1.'/'.URL_PLNPAGE);


// define('ROUTE_INDEX_HTL1', 'front/plan/index');
define('URL_INDEX_HTL1', HTL1);

/*reserve----------------------------------------*/


// define('ROUTE_RESERVE_HTL1', 'front/reserve/$1');
define('URL_RESERVE_HTL1', HTL1.'/'.URL_RESERVE);

// define('ROUTE_RESERVE_CM_HTL1', 'front/reserve/m_confirm');
define('URL_RESERVE_CM_HTL1', HTL1.'/'.URL_RESERVE_CM);

// define('ROUTE_RESERVE_CNM_HTL1', 'front/reserve/nm_confirm');
define('URL_RESERVE_CNM_HTL1', HTL1.'/'.URL_RESERVE_CNM);

// define('ROUTE_RESERVE_ORDER_HTL1', 'front/reserve/order');
define('URL_RESERVE_ORDER_HTL1', HTL1.'/'.URL_RESERVE_ORDER);

// define('ROUTE_RESERVE_CANCEL_HTL1', 'front/reserve/cancel');
define('URL_RESERVE_CANCEL_HTL1', HTL1.'/'.URL_RESERVE_CANCEL);

// define('ROUTE_RESERVE_EDIT_HTL1', 'front/reserve/edit');
define('URL_RESERVE_EDIT_HTL1', HTL1.'/'.URL_RESERVE_EDIT);

// define('ROUTE_RESERVE_SAVE_HTL1', 'front/reserve/save');
define('URL_RESERVE_SAVE_HTL1', HTL1.'/'.URL_RESERVE_SAVE);

// define('ROUTE_RESERVE_CHECK_HTL1', 'front/reserve/check');
define('URL_RESERVE_CHECK_HTL1', HTL1.'/'.URL_RESERVE_CHECK);


// define('ROUTE_RESERVE_RA_HTL1', 'front/reserve/registafter');
define('URL_RESERVE_RA_HTL1', HTL1.'/'.URL_RESERVE_RA);

// define('ROUTE_RESERVE_SU_HTL1', 'front/reserve/signup');
define('URL_RESERVE_SU_HTL1', HTL1.'/'.URL_RESERVE_SU);

// define('ROUTE_RESERVE_CREDIT_C_HTL1', 'front/reserve/credit_confirm');
define('URL_RESERVE_CREDIT_C_HTL1', HTL1.'/'.URL_RESERVE_CREDIT_C);

// define('ROUTE_RESERVE_CREDIT_S_HTL1', 'front/reserve/credit_setting');
define('URL_RESERVE_CREDIT_S_HTL1', HTL1.'/'.URL_RESERVE_CREDIT_S);
/*user----------------------------------------*/


// define('ROUTE_MYPAGE_HTL1', 'front/user/mypage');
define('URL_MYPAGE_HTL1', HTL1.'/'.URL_MYPAGE);

// define('ROUTE_LOGIN_HTL1', 'front/user');
define('URL_LOGIN_HTL1', HTL1.'/'.URL_LOGIN);

// define('ROUTE_LOGIN_A', 'front/user/login');
define('URL_LOGIN_A_HTL1', HTL1.'/'.URL_LOGIN_A);

// define('ROUTE_LOGOUT_HTL1', 'front/user/logout');
define('URL_LOGOUT_HTL1', HTL1.'/'.URL_LOGOUT);

// define('ROUTE_RSVLOGIN_HTL1', 'front/user/rsvlogin');
define('URL_RSVLOGIN_HTL1', HTL1.'/'.URL_RSVLOGIN);

// define('ROUTE_NMSIGNUP_HTL1', 'front/user/nm_signup');
define('URL_NMSIGNUP_HTL1', HTL1.'/'.URL_NMSIGNUP);

// define('ROUTE_NMCONF_HTL1', 'front/user/nm_confirm');
define('URL_NMCONF_HTL1', HTL1.'/'.URL_NMCONF);


// define('ROUTE_SIGNUP_HTL1', 'front/user/signup');
define('URL_SIGNUP_HTL1', HTL1.'/'.URL_SIGNUP);

// define('ROUTE_REGIST_HTL1', 'front/user/regist');
define('URL_REGIST_HTL1', HTL1.'/'.URL_REGIST);

// define('ROUTE_USER_EDIT_HTL1', 'front/user/edit');
define('URL_USER_EDIT_HTL1', HTL1.'/'.URL_USER_EDIT);

// define('ROUTE_USER_SAVE_HTL1', 'front/user/save');
define('URL_USER_SAVE_HTL1', HTL1.'/'.URL_USER_SAVE);

// define('ROUTE_PASSWORD', 'front/user/password');
define('URL_USER_PASSWORD_HTL1', HTL1.'/'.URL_USER_PASSWORD);

// define('ROUTE_RESET', 'front/user/reset');
define('URL_USER_RESET_HTL1', HTL1.'/'.URL_USER_RESET);

define('URL_USER_RESET_C_HTL1', HTL1.'/'.URL_USER_RESET_C);

define('URL_USER_PASSWORD_RESET_HTL1', HTL1.'/'.URL_USER_PASSWORD_RESET);

define('URL_SETLANGUAGE_HTL1', HTL1.'/'.URL_SETLANGUAGE);

define('URL_SECRET_HTL1' , HTL1.'/'.URL_SECRET);

define('URL_SECRET_LIST_HTL1' , HTL1.'/'.URL_SECRET_LIST);












/*htl name----------------------------------------*/
define('HTL2', 'nihonbashi');

/*plan----------------------------------------*/

// define('ROUTE_PLNLIST_HTL2', 'front/plan');
define('URL_PLNLIST_HTL2', HTL2.'/'.URL_PLNLIST);

// define('ROUTE_PLNSEARCH_HTL2', 'front/plan/search');
define('URL_PLNSEARCH_HTL2', HTL2.'/'.URL_PLNSEARCH);

// define('ROUTE_PLNSORT_HTL2', 'front/plan/sort');
define('URL_PLNSORT_HTL2', HTL2.'/'.URL_PLNSORT);

// define('ROUTE_PLNDETAIL_HTL2', 'front/plan/detail/$1');
define('URL_PLNDETAIL_HTL2', HTL2.'/'.URL_PLNDETAIL);

// define('ROUTE_PLNDATE_HTL2', 'front/plan/date/$1');
define('URL_PLNDATE_HTL2', HTL2.'/'.URL_PLNDATE);

// define('ROUTE_PLNRECALCULATION_HTL2', 'front/plan/recalculation');
define('URL_PLNRECALCULATION_HTL2', HTL2.'/'.URL_PLNRECALCULATION);

// define('ROUTE_PLNPAGE_HTL2', 'front/plan/page/$1');
define('URL_PLNPAGE_HTL2', HTL2.'/'.URL_PLNPAGE);


// define('ROUTE_INDEX_HTL2', 'front/plan/index');
define('URL_INDEX_HTL2', HTL2);

/*reserve----------------------------------------*/


// define('ROUTE_RESERVE_HTL2', 'front/reserve/$1');
define('URL_RESERVE_HTL2', HTL2.'/'.URL_RESERVE);

// define('ROUTE_RESERVE_CM_HTL2', 'front/reserve/m_confirm');
define('URL_RESERVE_CM_HTL2', HTL2.'/'.URL_RESERVE_CM);

// define('ROUTE_RESERVE_CNM_HTL2', 'front/reserve/nm_confirm');
define('URL_RESERVE_CNM_HTL2', HTL2.'/'.URL_RESERVE_CNM);

// define('ROUTE_RESERVE_ORDER_HTL2', 'front/reserve/order');
define('URL_RESERVE_ORDER_HTL2', HTL2.'/'.URL_RESERVE_ORDER);

// define('ROUTE_RESERVE_CANCEL_HTL2', 'front/reserve/cancel');
define('URL_RESERVE_CANCEL_HTL2', HTL2.'/'.URL_RESERVE_CANCEL);

// define('ROUTE_RESERVE_EDIT_HTL2', 'front/reserve/edit');
define('URL_RESERVE_EDIT_HTL2', HTL2.'/'.URL_RESERVE_EDIT);

// define('ROUTE_RESERVE_SAVE_HTL2', 'front/reserve/save');
define('URL_RESERVE_SAVE_HTL2', HTL2.'/'.URL_RESERVE_SAVE);

// define('ROUTE_RESERVE_CHECK_HTL2', 'front/reserve/check');
define('URL_RESERVE_CHECK_HTL2', HTL2.'/'.URL_RESERVE_CHECK);


// define('ROUTE_RESERVE_RA_HTL2', 'front/reserve/registafter');
define('URL_RESERVE_RA_HTL2', HTL2.'/'.URL_RESERVE_RA);

// define('ROUTE_RESERVE_SU_HTL2', 'front/reserve/signup');
define('URL_RESERVE_SU_HTL2', HTL2.'/'.URL_RESERVE_SU);

// define('ROUTE_RESERVE_CREDIT_C_HTL2', 'front/reserve/credit_confirm');
define('URL_RESERVE_CREDIT_C_HTL2', HTL2.'/'.URL_RESERVE_CREDIT_C);

// define('ROUTE_RESERVE_CREDIT_S_HTL2', 'front/reserve/credit_setting');
define('URL_RESERVE_CREDIT_S_HTL2', HTL2.'/'.URL_RESERVE_CREDIT_S);
/*user----------------------------------------*/


// define('ROUTE_MYPAGE_HTL2', 'front/user/mypage');
define('URL_MYPAGE_HTL2', HTL2.'/'.URL_MYPAGE);

// define('ROUTE_LOGIN_HTL2', 'front/user');
define('URL_LOGIN_HTL2', HTL2.'/'.URL_LOGIN);

// define('ROUTE_LOGIN_A', 'front/user/login');
define('URL_LOGIN_A_HTL2', HTL2.'/'.URL_LOGIN_A);

// define('ROUTE_LOGOUT_HTL2', 'front/user/logout');
define('URL_LOGOUT_HTL2', HTL2.'/'.URL_LOGOUT);

// define('ROUTE_RSVLOGIN_HTL2', 'front/user/rsvlogin');
define('URL_RSVLOGIN_HTL2', HTL2.'/'.URL_RSVLOGIN);

// define('ROUTE_NMSIGNUP_HTL2', 'front/user/nm_signup');
define('URL_NMSIGNUP_HTL2', HTL2.'/'.URL_NMSIGNUP);

// define('ROUTE_NMCONF_HTL2', 'front/user/nm_confirm');
define('URL_NMCONF_HTL2', HTL2.'/'.URL_NMCONF);


// define('ROUTE_SIGNUP_HTL2', 'front/user/signup');
define('URL_SIGNUP_HTL2', HTL2.'/'.URL_SIGNUP);

// define('ROUTE_REGIST_HTL2', 'front/user/regist');
define('URL_REGIST_HTL2', HTL2.'/'.URL_REGIST);

// define('ROUTE_USER_EDIT_HTL2', 'front/user/edit');
define('URL_USER_EDIT_HTL2', HTL2.'/'.URL_USER_EDIT);

// define('ROUTE_USER_SAVE_HTL2', 'front/user/save');
define('URL_USER_SAVE_HTL2', HTL2.'/'.URL_USER_SAVE);

// define('ROUTE_PASSWORD', 'front/user/password');
define('URL_USER_PASSWORD_HTL2', HTL2.'/'.URL_USER_PASSWORD);

// define('ROUTE_RESET', 'front/user/reset');
define('URL_USER_RESET_HTL2', HTL2.'/'.URL_USER_RESET);

define('URL_USER_RESET_C_HTL2', HTL2.'/'.URL_USER_RESET_C);

define('URL_USER_PASSWORD_RESET_HTL2', HTL2.'/'.URL_USER_PASSWORD_RESET);

define('URL_SETLANGUAGE_HTL2', HTL2.'/'.URL_SETLANGUAGE);

define('URL_SECRET_HTL2', HTL2.'/'.URL_SECRET);

define('URL_SECRET_LIST_HTL2' , HTL2.'/'.URL_SECRET_LIST);




/*htl name----------------------------------------*/
define('HTL3', 'sapporo');

/*plan----------------------------------------*/

// define('ROUTE_PLNLIST_HTL3', 'front/plan');
define('URL_PLNLIST_HTL3', HTL3.'/'.URL_PLNLIST);

// define('ROUTE_PLNSEARCH_HTL3', 'front/plan/search');
define('URL_PLNSEARCH_HTL3', HTL3.'/'.URL_PLNSEARCH);

// define('ROUTE_PLNSORT_HTL3', 'front/plan/sort');
define('URL_PLNSORT_HTL3', HTL3.'/'.URL_PLNSORT);

// define('ROUTE_PLNDETAIL_HTL3', 'front/plan/detail/$1');
define('URL_PLNDETAIL_HTL3', HTL3.'/'.URL_PLNDETAIL);

// define('ROUTE_PLNDATE_HTL3', 'front/plan/date/$1');
define('URL_PLNDATE_HTL3', HTL3.'/'.URL_PLNDATE);

// define('ROUTE_PLNRECALCULATION_HTL3', 'front/plan/recalculation');
define('URL_PLNRECALCULATION_HTL3', HTL3.'/'.URL_PLNRECALCULATION);

// define('ROUTE_PLNPAGE_HTL3', 'front/plan/page/$1');
define('URL_PLNPAGE_HTL3', HTL3.'/'.URL_PLNPAGE);


// define('ROUTE_INDEX_HTL3', 'front/plan/index');
define('URL_INDEX_HTL3', HTL3);

/*reserve----------------------------------------*/


// define('ROUTE_RESERVE_HTL3', 'front/reserve/$1');
define('URL_RESERVE_HTL3', HTL3.'/'.URL_RESERVE);

// define('ROUTE_RESERVE_CM_HTL3', 'front/reserve/m_confirm');
define('URL_RESERVE_CM_HTL3', HTL3.'/'.URL_RESERVE_CM);

// define('ROUTE_RESERVE_CNM_HTL3', 'front/reserve/nm_confirm');
define('URL_RESERVE_CNM_HTL3', HTL3.'/'.URL_RESERVE_CNM);

// define('ROUTE_RESERVE_ORDER_HTL3', 'front/reserve/order');
define('URL_RESERVE_ORDER_HTL3', HTL3.'/'.URL_RESERVE_ORDER);

// define('ROUTE_RESERVE_CANCEL_HTL3', 'front/reserve/cancel');
define('URL_RESERVE_CANCEL_HTL3', HTL3.'/'.URL_RESERVE_CANCEL);

// define('ROUTE_RESERVE_EDIT_HTL3', 'front/reserve/edit');
define('URL_RESERVE_EDIT_HTL3', HTL3.'/'.URL_RESERVE_EDIT);

// define('ROUTE_RESERVE_SAVE_HTL3', 'front/reserve/save');
define('URL_RESERVE_SAVE_HTL3', HTL3.'/'.URL_RESERVE_SAVE);

// define('ROUTE_RESERVE_CHECK_HTL3', 'front/reserve/check');
define('URL_RESERVE_CHECK_HTL3', HTL3.'/'.URL_RESERVE_CHECK);


// define('ROUTE_RESERVE_RA_HTL3', 'front/reserve/registafter');
define('URL_RESERVE_RA_HTL3', HTL3.'/'.URL_RESERVE_RA);

// define('ROUTE_RESERVE_SU_HTL3', 'front/reserve/signup');
define('URL_RESERVE_SU_HTL3', HTL3.'/'.URL_RESERVE_SU);

// define('ROUTE_RESERVE_CREDIT_C_HTL3', 'front/reserve/credit_confirm');
define('URL_RESERVE_CREDIT_C_HTL3', HTL3.'/'.URL_RESERVE_CREDIT_C);

// define('ROUTE_RESERVE_CREDIT_S_HTL3', 'front/reserve/credit_setting');
define('URL_RESERVE_CREDIT_S_HTL3', HTL3.'/'.URL_RESERVE_CREDIT_S);
/*user----------------------------------------*/


// define('ROUTE_MYPAGE_HTL3', 'front/user/mypage');
define('URL_MYPAGE_HTL3', HTL3.'/'.URL_MYPAGE);

// define('ROUTE_LOGIN_HTL3', 'front/user');
define('URL_LOGIN_HTL3', HTL3.'/'.URL_LOGIN);

// define('ROUTE_LOGIN_A', 'front/user/login');
define('URL_LOGIN_A_HTL3', HTL3.'/'.URL_LOGIN_A);

// define('ROUTE_LOGOUT_HTL3', 'front/user/logout');
define('URL_LOGOUT_HTL3', HTL3.'/'.URL_LOGOUT);

// define('ROUTE_RSVLOGIN_HTL3', 'front/user/rsvlogin');
define('URL_RSVLOGIN_HTL3', HTL3.'/'.URL_RSVLOGIN);

// define('ROUTE_NMSIGNUP_HTL3', 'front/user/nm_signup');
define('URL_NMSIGNUP_HTL3', HTL3.'/'.URL_NMSIGNUP);

// define('ROUTE_NMCONF_HTL3', 'front/user/nm_confirm');
define('URL_NMCONF_HTL3', HTL3.'/'.URL_NMCONF);


// define('ROUTE_SIGNUP_HTL3', 'front/user/signup');
define('URL_SIGNUP_HTL3', HTL3.'/'.URL_SIGNUP);

// define('ROUTE_REGIST_HTL3', 'front/user/regist');
define('URL_REGIST_HTL3', HTL3.'/'.URL_REGIST);

// define('ROUTE_USER_EDIT_HTL3', 'front/user/edit');
define('URL_USER_EDIT_HTL3', HTL3.'/'.URL_USER_EDIT);

// define('ROUTE_USER_SAVE_HTL3', 'front/user/save');
define('URL_USER_SAVE_HTL3', HTL3.'/'.URL_USER_SAVE);

// define('ROUTE_PASSWORD', 'front/user/password');
define('URL_USER_PASSWORD_HTL3', HTL3.'/'.URL_USER_PASSWORD);

// define('ROUTE_RESET', 'front/user/reset');
define('URL_USER_RESET_HTL3', HTL3.'/'.URL_USER_RESET);

define('URL_USER_RESET_C_HTL3', HTL3.'/'.URL_USER_RESET_C);

define('URL_USER_PASSWORD_RESET_HTL3', HTL3.'/'.URL_USER_PASSWORD_RESET);

define('URL_SETLANGUAGE_HTL3', HTL3.'/'.URL_SETLANGUAGE);

define('URL_SECRET_HTL3', HTL3.'/'.URL_SECRET);

define('URL_SECRET_LIST_HTL3' , HTL3.'/'.URL_SECRET_LIST);




/*htl name----------------------------------------*/
define('HTL4', 'asakusabashi');

/*plan----------------------------------------*/

// define('ROUTE_PLNLIST_HTL4', 'front/plan');
define('URL_PLNLIST_HTL4', HTL4.'/'.URL_PLNLIST);

// define('ROUTE_PLNSEARCH_HTL4', 'front/plan/search');
define('URL_PLNSEARCH_HTL4', HTL4.'/'.URL_PLNSEARCH);

// define('ROUTE_PLNSORT_HTL4', 'front/plan/sort');
define('URL_PLNSORT_HTL4', HTL4.'/'.URL_PLNSORT);

// define('ROUTE_PLNDETAIL_HTL4', 'front/plan/detail/$1');
define('URL_PLNDETAIL_HTL4', HTL4.'/'.URL_PLNDETAIL);

// define('ROUTE_PLNDATE_HTL4', 'front/plan/date/$1');
define('URL_PLNDATE_HTL4', HTL4.'/'.URL_PLNDATE);

// define('ROUTE_PLNRECALCULATION_HTL4', 'front/plan/recalculation');
define('URL_PLNRECALCULATION_HTL4', HTL4.'/'.URL_PLNRECALCULATION);

// define('ROUTE_PLNPAGE_HTL4', 'front/plan/page/$1');
define('URL_PLNPAGE_HTL4', HTL4.'/'.URL_PLNPAGE);


// define('ROUTE_INDEX_HTL4', 'front/plan/index');
define('URL_INDEX_HTL4', HTL4);

/*reserve----------------------------------------*/


// define('ROUTE_RESERVE_HTL4', 'front/reserve/$1');
define('URL_RESERVE_HTL4', HTL4.'/'.URL_RESERVE);

// define('ROUTE_RESERVE_CM_HTL4', 'front/reserve/m_confirm');
define('URL_RESERVE_CM_HTL4', HTL4.'/'.URL_RESERVE_CM);

// define('ROUTE_RESERVE_CNM_HTL4', 'front/reserve/nm_confirm');
define('URL_RESERVE_CNM_HTL4', HTL4.'/'.URL_RESERVE_CNM);

// define('ROUTE_RESERVE_ORDER_HTL4', 'front/reserve/order');
define('URL_RESERVE_ORDER_HTL4', HTL4.'/'.URL_RESERVE_ORDER);

// define('ROUTE_RESERVE_CANCEL_HTL4', 'front/reserve/cancel');
define('URL_RESERVE_CANCEL_HTL4', HTL4.'/'.URL_RESERVE_CANCEL);

// define('ROUTE_RESERVE_EDIT_HTL4', 'front/reserve/edit');
define('URL_RESERVE_EDIT_HTL4', HTL4.'/'.URL_RESERVE_EDIT);

// define('ROUTE_RESERVE_SAVE_HTL4', 'front/reserve/save');
define('URL_RESERVE_SAVE_HTL4', HTL4.'/'.URL_RESERVE_SAVE);

// define('ROUTE_RESERVE_CHECK_HTL4', 'front/reserve/check');
define('URL_RESERVE_CHECK_HTL4', HTL4.'/'.URL_RESERVE_CHECK);


// define('ROUTE_RESERVE_RA_HTL4', 'front/reserve/registafter');
define('URL_RESERVE_RA_HTL4', HTL4.'/'.URL_RESERVE_RA);

// define('ROUTE_RESERVE_SU_HTL4', 'front/reserve/signup');
define('URL_RESERVE_SU_HTL4', HTL4.'/'.URL_RESERVE_SU);

// define('ROUTE_RESERVE_CREDIT_C_HTL4', 'front/reserve/credit_confirm');
define('URL_RESERVE_CREDIT_C_HTL4', HTL4.'/'.URL_RESERVE_CREDIT_C);

// define('ROUTE_RESERVE_CREDIT_S_HTL4', 'front/reserve/credit_setting');
define('URL_RESERVE_CREDIT_S_HTL4', HTL4.'/'.URL_RESERVE_CREDIT_S);
/*user----------------------------------------*/


// define('ROUTE_MYPAGE_HTL4', 'front/user/mypage');
define('URL_MYPAGE_HTL4', HTL4.'/'.URL_MYPAGE);

// define('ROUTE_LOGIN_HTL4', 'front/user');
define('URL_LOGIN_HTL4', HTL4.'/'.URL_LOGIN);

// define('ROUTE_LOGIN_A', 'front/user/login');
define('URL_LOGIN_A_HTL4', HTL4.'/'.URL_LOGIN_A);

// define('ROUTE_LOGOUT_HTL4', 'front/user/logout');
define('URL_LOGOUT_HTL4', HTL4.'/'.URL_LOGOUT);

// define('ROUTE_RSVLOGIN_HTL4', 'front/user/rsvlogin');
define('URL_RSVLOGIN_HTL4', HTL4.'/'.URL_RSVLOGIN);

// define('ROUTE_NMSIGNUP_HTL4', 'front/user/nm_signup');
define('URL_NMSIGNUP_HTL4', HTL4.'/'.URL_NMSIGNUP);

// define('ROUTE_NMCONF_HTL4', 'front/user/nm_confirm');
define('URL_NMCONF_HTL4', HTL4.'/'.URL_NMCONF);


// define('ROUTE_SIGNUP_HTL4', 'front/user/signup');
define('URL_SIGNUP_HTL4', HTL4.'/'.URL_SIGNUP);

// define('ROUTE_REGIST_HTL4', 'front/user/regist');
define('URL_REGIST_HTL4', HTL4.'/'.URL_REGIST);

// define('ROUTE_USER_EDIT_HTL4', 'front/user/edit');
define('URL_USER_EDIT_HTL4', HTL4.'/'.URL_USER_EDIT);

// define('ROUTE_USER_SAVE_HTL4', 'front/user/save');
define('URL_USER_SAVE_HTL4', HTL4.'/'.URL_USER_SAVE);

// define('ROUTE_PASSWORD', 'front/user/password');
define('URL_USER_PASSWORD_HTL4', HTL4.'/'.URL_USER_PASSWORD);

// define('ROUTE_RESET', 'front/user/reset');
define('URL_USER_RESET_HTL4', HTL4.'/'.URL_USER_RESET);

define('URL_USER_RESET_C_HTL4', HTL4.'/'.URL_USER_RESET_C);

define('URL_USER_PASSWORD_RESET_HTL4', HTL4.'/'.URL_USER_PASSWORD_RESET);

define('URL_SETLANGUAGE_HTL4', HTL4.'/'.URL_SETLANGUAGE);

define('URL_SECRET_HTL4', HTL4.'/'.URL_SECRET);

define('URL_SECRET_LIST_HTL4' , HTL4.'/'.URL_SECRET_LIST);

