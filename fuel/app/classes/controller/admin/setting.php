<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Admin_Setting extends Controller_Common
{
  /**
   * The basic welcome message
   *
   * @access  public
   * @return  Response
   */


  /**
  *
  *SessionからログインIDを取得する。なければログイン画面にリダイレクト。
  *プランを取得する
  *
  **/
  public function action_index()
  {

    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }
    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $data=array(
      'error' => Session::get_flash('error'), 
      'ID' => $user_data['ADMIN_ID'],
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = '';
    $this->template->title = TITLE_SETTING;
    $this->template->content = View_Smarty::forge('admin/setting/acount', $data);

  }


  public function action_hotel()
  {
     $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }
    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);   
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);
    $data=array(
      'error' => Session::get_flash('error'), 
      'ID' => $user_data['ADMIN_ID'],
      'HTL_NAME' => $user_data['HTL_NAME'],
      'HTL_MAIL'=> $user_data['HTL_MAIL'], 
      'HTL_ADR1'=> $user_data['HTL_ADR1'],
      'HTL_TEL'=> $user_data['HTL_TEL'],
      'ART_LINK_FLG'=> $user_data['ART_LINK_FLG'],
      'ART_ACCOUNT_KEY'=> $user_data['ART_ACCOUNT_KEY'],
      'ART_ACCOUNT_SECRET'=> $user_data['ART_ACCOUNT_SECRET'],
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = 'setting/hotel.js';
    $this->template->title = TITLE_HOTEL_SETTING;
    $this->template->content = View_Smarty::forge('admin/setting/hotel', $data);
  }


  public function action_updatemailad()
  {
    $data = Input::post();
    // if (!preg_match("/^[a-zA-Z0-9]+$/", $data['email'])) {
    //   Session::set_flash('error', '半角英数を入力してください。');
    //   return $this->action_hotel();
    // }
    $errs = null;
    if (empty($data['hotel_name'])) {
      $errs[] = 'ホテル名を入力してください。';
    };
    if (empty($data['email'])) {
      $errs[] = 'メールアドレスを入力してください。';
    };
    if (empty($data['address'])) {
      $errs[] = '住所を入力してください。';
    };
    if (empty($data['tel'])) {
      $errs[] = '電話番号を入力してください。';
    };
    if ($data['art_link_flg'] == 1) {
      if (empty($data['art_account_key'])) {
        $errs[] = 'アカウントキーを入力してください。';
      };
      if (empty($data['art_account_secret'])) {
        $errs[] = 'シークレットキーを入力してください。';
      };
    }
    if ($errs) {
      Session::set_flash('error', implode("\n", $errs));
      return $this->action_hotel();
    }
    
    $param = array(
      '0' => array( 'colname' => 'HTL_MAIL', 'value' => $data['email'] ),
      '1' => array( 'colname' => 'HTL_NAME', 'value' => $data['hotel_name'] ),
      '2' => array( 'colname' => 'HTL_ADR1', 'value' => $data['address'] ),
      '3' => array( 'colname' => 'HTL_TEL', 'value' => $data['tel'] ),
      '4' => array( 'colname' => 'ART_LINK_FLG', 'value' => $data['art_link_flg'] ),
      '5' => array( 'colname' => 'ART_ACCOUNT_KEY', 'value' => $data['art_account_key'] ),
      '6' => array( 'colname' => 'ART_ACCOUNT_SECRET', 'value' => $data['art_account_secret'] ),
      );
    $admin_id = Session::get('id');
    $htl = Model_M_htl::forge();
    $result = $htl->update_htl($admin_id, $param);


    Session::set_flash('error', '保存しました。');
    return $this->action_hotel();
  }


  

  public function action_updatemailtemp()
  {
    $data = Input::post();

    $param = array(
      '0' => array('colname' => 'MAIL_CFM_TITLE',   'value'=> $data['address_cfm']),
      '1' => array('colname' => 'MAIL_CHG_TITLE',   'value'=> $data['address_chg']),
      '2' => array('colname' => 'MAIL_BFR_TITLE',   'value'=> $data['address_bfr']),
      '3' => array('colname' => 'MAIL_THK_TITLE',   'value'=> $data['address_thk']),
      '4' => array('colname' => 'MAIL_CCL_TITLE',   'value'=> $data['address_ccl']),
      '5' => array('colname' => 'MAIL_ADCCL_TITLE', 'value'=> $data['address_adccl']),

      '6'  => array('colname' => 'MAIL_CFM',   'value'=> $data['mailTxt_cfm']),
      '7'  => array('colname' => 'MAIL_CHG',   'value'=> $data['mailTxt_chg']),
      '8'  => array('colname' => 'MAIL_BFR',   'value'=> $data['mailTxt_bfr']),
      '9'  => array('colname' => 'MAIL_THK',   'value'=> $data['mailTxt_thk']),
      '10' => array('colname' => 'MAIL_CCL',   'value'=> $data['mailTxt_ccl']),
      '11' => array('colname' => 'MAIL_ADCCL', 'value'=> $data['mailTxt_adccl']),
      );


    $admin_id = Session::get('id');
    $htl = Model_M_htl::forge();
    $result = $htl->update_htl($admin_id, $param);

    Session::set_flash('error', 'メール情報を変更しました。');
    return $this->action_mail();
  }








  public function action_password()
  {
    $data = Input::post();
    if (!preg_match("/^[a-zA-Z0-9]+$/", $data['loginPass'])) {
      Session::set_flash('error', '半角英数を入力してください。');
      return $this->action_index();
    }
    
    $admin_id = Session::get('id');
    $htl = Model_M_htl::forge();


    $param = array(
      '0' => array('colname' => 'ADMIN_PWD', 'value' =>  md5(MD5_SALT.$data['loginPass']) ),
      );
    $result = $htl->update_htl($admin_id, $param);

    Session::set_flash('error', 'パスワードを変更しました。');
    return $this->action_index();
  }








  public function action_mail()
  {
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }


    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);
    $data=array(
      'error' => Session::get_flash('error'), 
      'ID' => $user_data['ADMIN_ID'],
      'CO_NAME' => $user_data['HTL_NAME'],
      'HTL' => $user_data,
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = '';
    $this->template->title = TITLE_MAIL_SETTING;
    $this->template->content = View_Smarty::forge('admin/setting/mail', $data);    
  }



  public function router($action, $code)
  {

      $data = Input::post();
    if (isset($data['action']) && isset($data['check'])) {
      if ($data['action'] == CHECK_SALE || $data['action'] == CHECK_STOP || $data['action'] == CHECK_DELETE) {
           $this->check_edit($data);
      }

    }
    if (method_exists($this, 'action_'.$action)) {
      $method = 'action_'.$action;
      $this->$method($code);
    }else{
      $this->action_index();
    }
      
  }

}
