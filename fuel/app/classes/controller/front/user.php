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
class Controller_Front_User extends Controller_Common
{
  /**
   * The basic welcome message
   *
   * @access  public
   * @return  Response
   */



  public function action_index()
  {

    if (!$user_data = Session::get('user_data')) {
      // Response::redirect(URL_PLNLIST);
      $user_data = array('user_name' =>  __('lbl_guest'), );
    }


    $data = array(
      'error' => Session::get_flash('error'), 
      'name'  => $user_data['user_name'],
      'htl_id' => $this->htl_id,
      'login_url' => HTTP.'/'.$this->htl_name.'/login',
      'mypage_url'=> HTTP.'/'.$this->htl_name.'/mypage',
      'action' => HTTP.'/'.$this->htl_name.'/login_a',
      'nm_action' => HTTP.'/'.$this->htl_name.'/nm_signup',
      'passreminder' =>HTTP.'/'.$this->htl_name.'/password',
      );
    $this->template->mypage_flg = true;
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/login',$data);

    // $this->template->content = View::forge('front/login', $data);
  }


/*予約時にログインしていなかったときに遷移*/
  public function action_login()
  {
    $data = Input::post();
    
    $user = Model_M_Usr::forge();
    $user_data = $user->get_user_one($data['loginMail']);

    if ($user_data == 1) {
      Session::set_flash('error', __('lbl_error43'));
      Response::redirect($this->htl_name.'/login');
    }


    if ($user_data['USR_PWD'] == md5(MD5_SALT.$data['loginPass'])) {
      Session::set('user_data',array('user_id' => $user_data['USR_ID'], 'user_name' => $user_data['USR_NAME']));
      if ($rsv_get_value = Session::get('rsv_get_value')) {
        Session::delete('rsv_get_value');
        Response::redirect($this->htl_name.'/reserve/'.$rsv_get_value);
      }else{
        Response::redirect($this->htl_name.'/mypage');
      }
    }else{
      Session::set_flash('error', __('lbl_error44'));
      Response::redirect($this->htl_name.'/login');
    }
  }


  /*
    会員用ページ、非会員の場合またはSessionが切れた場合はlogin画面に遷移
  */
  public function action_mypage()
  {
    if (!$user_data = Session::get('user_data')) {
      Response::redirect($this->htl_name.'/login');
      // $user_data = array('user_name' =>  __('lbl_guest'), );
    }

    $user = Model_M_Usr::find_by_pk($user_data['user_id']);

    $rsv = Model_T_rsv::forge();
    $rsv_data = $rsv->get_user_rsv($this->htl_id, $user_data['user_id'],null);

    foreach ($rsv_data as $key => $value) {
      $rsv_data[$key]['num'] = $value['PLN_NUM_MAN'] + $value['PLN_NUM_WOMAN'] + $value['PLN_NUM_CHILD1'] + $value['PLN_NUM_CHILD2'] + $value['PLN_NUM_CHILD3'] + $value['PLN_NUM_CHILD4'] + $value['PLN_NUM_CHILD5'] + $value['PLN_NUM_CHILD6'];
      $rsv_data[$key]['URL'] = HTTP.'/'.$this->htl_name.'/reserve/edit/'.$value['RSV_NO'];
    }

    $data = array(
      'error'     => Session::get_flash('error'), 
      'name'      => $user_data['user_name'],
      'rsv'       => $rsv_data,
      'user'      => $user,
      'edit_url'  => HTTP.'/'.$this->htl_name.'/mypage/edit',
      'login_url' => HTTP.'/'.$this->htl_name.'/login',
      'mypage_url'=> HTTP.'/'.$this->htl_name.'/mypage',
      );
    $this->template->mypage_flg = true;
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/mypage',$data);
  }


  public function action_rsvlogin()
  {


    Response::redirect($this->htl_name.'/reserve/signup');


    /*  
    *
    *     非会員で予約をすることができなくなったので以下の処理をコメントイン
    *     仕様が確定していないので一応残しておく
    *
    $data = Input::post();

    $rsv = Model_T_Rsv::forge();
    $rsv_data = $rsv->get_rsv_no_member($data['reserveNum'], $data['loginMail']);
    if (count($rsv_data) == 0) {
      Session::set_flash('error','該当する予約情報が見つかりませんでした。');
      Response::redirect($this->htl_name.'/login');
    }

    $chekin_times = explode(',', $rsv_data[0]['CHECK_IN']);
    $rsv_data[0]['chekin_times'] = explode(',', $rsv_data[0]['CHECK_IN']);

    $rsv_data[0]['action'] = HTTP.'/'.$this->htl_name.'/reserve/check';
    $rsv_data[0]['name'] = $rsv_data[0]['USR_NAME'];

    $rsv = array('rsv_no' => $rsv_data[0]['RSV_NO'], 'user_id'=>$rsv_data[0]['USR_ID'] );
    Session::set('RSV_NO', $rsv);
        
    $this->template->js = 'front/front.js';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/edit',$rsv_data[0]); 
    */

  }


  /* 新規登録　情報入力　画面呼び出し */
  public function action_nm_signup()
  {
    $data = array(
      'man_flg' => 'checked',
      'woman_flg' => '',
      'form' => Session::get_flash('form'),
      'error' => Session::get_flash('error'),
      'login_url'  => HTTP.'/'.$this->htl_name.'/login',
      'mypage_url' => HTTP.'/'.$this->htl_name.'/mypage',
      'action'  => $this->htl_name.'/nm_confirm',
      );
    $lang = Session::get('language');
    Session::destroy();
    if ($lang) {
      Session::set('language', $lang);
    }
    $this->template->mypage_flg = true;
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/no_member_su',$data);
  }



  public function action_nm_confirm()
  {

    $url = $this->htl_name.'/nm_signup';

    $data = Input::post();
    // かな→カナ変換。
    if ($data['kana']) {
      $data['kana'] = mb_convert_kana($data['kana'],'KVCa');
    }
    if ($data['kana2']) {
      $data['kana2'] = mb_convert_kana($data['kana2'],'KVCa');
    }
    if (!isset($data['policy']) || $data['policy'] != 'on') {
      Session::set_flash('error',__('lbl_error4'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }elseif (__('use_lang')=='ja' && ($data['name'] == null || $data['name'] == '')) {
      Session::set_flash('error',__('lbl_error8'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }elseif (__('use_lang')=='ja' && ($data['name2'] == null || $data['name2'] == '')) {
      Session::set_flash('error',__('lbl_error9'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }elseif ($data['kana'] == null || $data['kana'] == '') {
      Session::set_flash('error',__('lbl_error10'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }elseif ($data['kana2'] == null || $data['kana2'] == '') {
      Session::set_flash('error',__('lbl_error11'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }elseif ($data['gender'] == null || $data['gender'] == '') {
      Session::set_flash('error',__('lbl_error12'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    // }
    // elseif ($data['ciDate'] == null || $data['ciDate'] == '') {
      // Session::set_flash('error','生年月日を入力してください。');
      // Session::set_flash('form', $data);
      // // $url = $_SERVER['HTTP_REFERER'];
      // Response::redirect($url);      
    }elseif ($data['email'] == null || $data['email'] == '') {
      Session::set_flash('error',__('lbl_error13'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }elseif ($data['email_re'] == null || $data['email_re'] == '') {
      Session::set_flash('error',__('lbl_error14'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }elseif ($data['email'] != $data['email_re']) {
      Session::set_flash('error',__('lbl_error15'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }elseif ($data['tel'] == null || $data['tel'] == '' || !preg_match("/^(\+)?(\d{2,4})(\-)?\d{1,4}\-?\d{2,4}\-?\d{2,4}$/", $data['tel'])) {
      Session::set_flash('error',__('lbl_error16'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }

    $user = Model_M_Usr::forge();
    $result = $user->get_user_one($data['email']);

    if ($result != 1) {
      if ($result['RANK_ID'] == 1) {
        Session::set_flash('error',__('lbl_error33'));
        Session::set_flash('form', $data);
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);  
      }
    }

    // if (!$rsv_data = Session::get('RSV_INFO')) {
    //   Session::set_flash('error','セッションが切れました。お手数ですがやり直してください');
    //   // $url = $_SERVER['HTTP_REFERER'];
    //   // Response::redirect($url);  
    //   Response::redirect($this->htl_name.'/plan');
    // }


    $param = array(
       'USR_NAME' => $data['name'].$data['name2'],
       'USR_KANA' => $data['kana'].$data['kana2'],
       'USR_SEI' => $data['name'],
       'USR_MEI' => $data['name2'],
       'KANA_SEI' => $data['kana'],
       'KANA_MEI' => $data['kana2'],         
       'ZIP_CD' => $data['zipcode'],
       'USR_ADR1' => $data['address1'],
       'USR_ADR2' => $data['address2'],
       'USR_TEL' => $data['tel'],
       'USR_FAX' => $data['fax'],
       'USR_SEX' => $data['gender'],
       'USR_BIRTH' => $data['ciDate'],

       'RANK_ID' =>'2',
       'USR_MAIL' => $data['email'],

      );
    $user = Model_M_Usr::forge();
    $user_id = $user->insert_user($param);


    $htl_data = Model_M_Htl::find_by_pk($this->htl_id);
    $url = HTTP.'/'.$this->htl_name.'/signup/?id='.$user_id[0].'&token='.md5(MD5_SALT.$data['email']);
    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $data['email'],
      'subject' => SIGNUP_RSV_SUBJECT,
      'body' => SIGNUP_RSV_BODY."\n\n".$url,
      );

    $result = $this->send_mail($mail);
    if ($result != '0') {
      Session::set_flash('error', $result);
      Session::set_flash('form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url); 
    }
   
 


    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/send_mail',$data);

  }



  public function action_signup()
  {
    $user_id = Input::get('id');
    $token = Input::get('token');
    // $type  = Input::get('type');

    if ($user_id == '' || $user_id == null || $token == '' || $token == null) {
      Session::set_flash('error', __('lbl_error34'));
      Response::redirect($this->htl_name.'/');
    }

    $user = Model_M_Usr::find_by_pk($user_id);
    if (count($user) == 0) {
      Session::set_flash('error', __('lbl_error34'));
      Response::redirect($this->htl_name.'/');
    }

    if (md5(MD5_SALT.$user['USR_MAIL']) != $token ) {
      Session::set_flash('error', __('lbl_error34'));
      Response::redirect($this->htl_name.'/');
    }

    if ($user['RANK_ID'] == 1) {
      Session::set_flash('error', __('lbl_error45'));
      Response::redirect($this->htl_name.'/');
    }



    $data = array(
      'error'  => Session::get_flash('error'), 
      'name'   => $user['USR_NAME'],
      'user_id'=> $user_id,
      'token'  => md5(MD5_SALT.$user_id),
      'type'   => '0',
      'action' => HTTP.'/'.$this->htl_name.'/regist',
      'login_url'  => HTTP.'/'.$this->htl_name.'/login',
      'mypage_url' => HTTP.'/'.$this->htl_name.'/mypage',
      );
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/regist',$data);

  }


  public function action_regist()
  {
    $data = Input::post();
    $user_id = $data['id'];
    $hashed_user_id = $data['token'];

    if (!Security::check_token()) {
      Response::redirect($this->htl_name.'/');
    }

    if ($hashed_user_id != md5(MD5_SALT.$user_id)) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/');
    }

    if (!isset($data['loginPass']) || $data['loginPass'] == '') {
      Session::set_flash('error',__('lbl_error35'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url); 
    }
    if (!isset($data['loginPass2']) || $data['loginPass2'] == '') {
      Session::set_flash('error',__('lbl_error36'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url); 
    }
    if ($data['loginPass'] != $data['loginPass2']) {
      Session::set_flash('error',__('lbl_error37'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url); 
    }

    if (!isset($data['mail'])) {
      Session::set_flash('error',__('lbl_error38'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url); 
    }

    $user = Model_M_Usr::find_by_pk($user_id);
    $password = md5(MD5_SALT.$data['loginPass']);
    if ($data['mail'] == 1) {
      $mail = 1;
    }else{
      $mail = 0;
    }

    $usr = Model_M_Usr::forge();
    $usr->update_user(array(
      'USR_PWD'   => $password,
      'MAG_ALLOW' => $mail,
      'RANK_ID'   => '1',
      'USR_ID'    => $user['USR_ID'],
      ));

    // $user->set(array(
    //   'USR_PWD'   => $password,
    //   'MAG_ALLOW' => $mail,
    //   'RANK_ID'   => '1',
    //   ))->save();

    if (!$rsv_data = Session::get('RSV_INFO')) {
      Session::set_flash('error',__('lbl_error39'));
      Response::redirect($this->htl_name.'/login'); 
    }else{
      // $array = array(
      //   'user_id' =>  $user_id,
      //   'password'=> $data['loginPass'],
      //   'mailmagazin' => $mail,
      //   );
      // $rsv_data['sign_data'] = $array;
      Session::set('user_data',array('user_id' => $user['USR_ID'], 'user_name' => $user['USR_NAME']));
      // Session::set('RSV_INFO', $rsv_data);
      Response::redirect($this->htl_name.'/reserve/registafter'); 
    }
  }



  public function action_edit()
  {
    if (!$user_data = Session::get('user_data')) {
      Response::redirect($this->htl_name.'/');
    }

    $user = Model_M_Usr::find_by_pk($user_data['user_id']);

    $back_url = '0';
    $type = Input::get('t');

    if ($type == '1'){
      if (isset($_SERVER['HTTP_REFERER'])) {
        $back_url = $_SERVER['HTTP_REFERER'];
      }
    }

    $user_array = array(
        'USR_ID'    => $user['USR_ID'] ,
        'USR_KANA'  => $user['USR_KANA'] ,
        'USR_SEI'   => $user['USR_SEI'] ,
        'USR_MEI'   => $user['USR_MEI'] ,
        'KANA_SEI'  => $user['KANA_SEI'] ,
        'KANA_MEI'  => $user['KANA_MEI'] ,
        'ZIP_CD'    => $user['ZIP_CD'] ,
        'USR_ADR1'  => $user['USR_ADR1'] ,
        'USR_ADR2'  => $user['USR_ADR2'] ,
        'USR_TEL'   => $user['USR_TEL'] ,
        'USR_FAX'   => $user['USR_FAX'] ,
        'USR_SEX'   => $user['USR_SEX'] ,
        'USR_BIRTH' => $user['USR_BIRTH'] ,
        'MAG_ALLOW' => $user['MAG_ALLOW'] ,
        'USR_MAIL'  => $user['USR_MAIL'] ,
      );


    if ($user_array['USR_SEX'] == 1) {
      $user_array['gender_flg1'] = 'checked'; 
      $user_array['gender_flg2'] = '';
    }else{
      $user_array['gender_flg1'] = '';
      $user_array['gender_flg2'] = 'checked';
    }

    if ($user_array['MAG_ALLOW'] == 0) {
      $user_array['magazine_flg1'] = '';
      $user_array['magazine_flg2'] = 'checked';
    }else{
      $user_array['magazine_flg1'] = 'checked';
      $user_array['magazine_flg2'] = '';
    }

    $user_array['name'] = $user_data['user_name'];
    $user_array['action'] = $this->htl_name.'/mypage/save';
    $user_array['form'] = Session::get_flash('user_form');
    $user_array['error'] = Session::get_flash('error');

    $user_array['login_url']  = HTTP.'/'.$this->htl_name.'/login';
    $user_array['mypage_url'] = HTTP.'/'.$this->htl_name.'/mypage';

    $user_array['back_url'] = $back_url;

    $this->template->mypage_flg = true;
    $this->template->js = 'front/front.js';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/user_edit', $user_array);
  }


  public function action_save()
  {
    if (!$user_data = Session::get('user_data')) {
      Session::set_flash('error',__('lbl_error1'));  
      Response::redirect($this->htl_name.'/');
    }
    $data = Input::post();

    // かな→カナ変換。
    if ($data['KANA_SEI']) {
      $data['KANA_SEI'] = mb_convert_kana($data['KANA_SEI'],'KVCa');
    }
    if ($data['KANA_MEI']) {
      $data['KANA_MEI'] = mb_convert_kana($data['KANA_MEI'],'KVCa');
    }
    if (!isset($data['USR_SEI']) || $data['USR_SEI'] == '') {
      Session::set_flash('error', __('lbl_error8'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }else if (!isset($data['USR_MEI']) || $data['USR_MEI'] == '') {
      Session::set_flash('error', __('lbl_error9'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }else if (!isset($data['KANA_SEI']) || $data['KANA_SEI'] == '') {
      Session::set_flash('error', __('lbl_error10'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }else if (!isset($data['KANA_MEI']) || $data['KANA_MEI'] == '') {
      Session::set_flash('error', __('lbl_error11'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    // }else if (!isset($data['USR_BIRTH']) || $data['USR_BIRTH'] == '') {
      // Session::set_flash('error', '生年月日を入力してください。');
      // Session::set_flash('user_form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      //Response::redirect($url);  
    }else if (!isset($data['USR_MAIL']) || $data['USR_MAIL'] == '') {
      Session::set_flash('error', __('lbl_error13'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }else if (!isset($data['USR_TEL']) || $data['USR_TEL'] == '' || !preg_match("/^(\+)?(\d{2,4})(\-)?\d{1,4}\-?\d{2,4}\-?\d{2,4}$/", $data['USR_TEL'])) {
      Session::set_flash('error', __('lbl_error40'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }else if (!isset($data['gender']) || $data['gender'] == '') {
      Session::set_flash('error', __('lbl_error12'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }else if (!isset($data['magazine']) || $data['magazine'] == '') {
      Session::set_flash('error', __('lbl_error41'));
      Session::set_flash('user_form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);  
    }

    if (isset($data['changepasswd']) && $data['changepasswd'] == '1') {
      if ($data['password'] == $data['password_re'] && $data['password'] != '') {
        $data['USR_PWD'] = md5(MD5_SALT.$data['password']);
      }else{
        Session::set_flash('error', __('lbl_error37'));
        Session::set_flash('user_form', $data);
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);  
      }
    }

    if (isset($data['magazine']) && $data['magazine'] == '1') {
      $data['MAG_ALLOW'] = '1';
    }else{
      $data['MAG_ALLOW'] = '0';
    }

    if (isset($data['gender']) && $data['gender'] == '1') {
      $data['USR_SEX'] = '1';
    }else{
      $data['USR_SEX'] = '2';
    }


    $data['USR_NAME'] = $data['USR_SEI'].$data['USR_MEI'];
    $data['USR_KANA'] = $data['KANA_SEI'].$data['KANA_MEI'];
    $data['USR_ID'] = $user_data['user_id'];

    $usr = Model_M_Usr::find_by_pk($data['USR_ID']);
    if (!$usr) {
      Session::set_flash('error',__('lbl_error1'));  
      Response::redirect($this->htl_name.'/');
    }elseif ($usr['USR_MAIL'] != $data['USR_MAIL']) {
      $al_user = Model_M_Usr::find_one_by(array('USR_MAIL' => $data['USR_MAIL'], 'RANK_ID' => '1'));
      if ($al_user) {
        Session::set_flash('error', __('lbl_error33'));
        Session::set_flash('user_form', $data);
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);  
      }
    }

    $user = Model_M_Usr::forge();
    $result = $user->update_user($data);


    Session::set_flash('error',__('lbl_error42'));
    if ($data['action'] == '0') {
      Response::redirect($this->htl_name.'/mypage');
    }else{
      Response::redirect($data['action']);
    }
  
  }


  public function action_password()
  {
    $data = array(
      'error'  => Session::get_flash('error'), 
      // 'name'   => $user['USR_NAME'],
      'user_id'=> 'passwordreminder',
      // 'token'  => md5(MD5_SALT.$user_id),
      // 'type'   => '0',
      'action' => HTTP.'/'.$this->htl_name.'/password_reset',
      'login_url'  => HTTP.'/'.$this->htl_name.'/login',
      'mypage_url' => HTTP.'/'.$this->htl_name.'/mypage',
      );
    $this->template->mypage_flg = true;
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/regist',$data);

  }



  public function action_password_reset()
  {
    $data = Input::post();

    if (!isset($data['mailAddress']) || $data['mailAddress'] == '') {
      Session::set_flash('error', __('lbl_error46'));
      $url = $_SERVER['HTTP_REFERER'];     
      Response::redirect($url);
    }


    $user = Model_M_Usr::find_one_by(array('USR_MAIL' => $data['mailAddress'] , 'RANK_ID' => '1'));
    if (!$user) {
      Session::set_flash('error', __('lbl_error47'));
      $url = $_SERVER['HTTP_REFERER']; 
      Response::redirect($url);
    }

    $htl_data = Model_M_Htl::find_by_pk($this->htl_id);
    $rand = rand(100,999);
    $url = HTTP.'/'.$this->htl_name.'/reset/?id='.$user->USR_ID.'&token='.md5(MD5_SALT.$user->USR_MAIL).'&token2='.$rand;
    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $user->USR_MAIL,
      'subject' => PASS_REMINDER_SUBJECT,
      'body' => PASS_REMINDER_BODY."\n\n".$url,
      );

    $result = $this->send_mail($mail);
    if ($result != '0') {
      Session::set_flash('error', $result);
      Session::set_flash('form', $data);
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url); 
    }
    
    $usr = Model_M_Usr::find_by_pk($user->USR_ID);
    $usr->MEMO = $rand;
    $usr->save();

    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/send_mail',$data);

  }


  public function action_reset()
  {
    $user_id = Input::get('id');
    $token = Input::get('token');
    $token2 = Input::get('token2');
    // $type  = Input::get('type');

    if ($user_id == '' || $user_id == null || $token == '' || $token == null) {
      Session::set_flash('error', __('lbl_error34'));
      Response::redirect($this->htl_name.'/login');
    }

    $user = Model_M_Usr::find_by_pk($user_id);
    if (count($user) == 0) {
      Session::set_flash('error', __('lbl_error34'));
      Response::redirect($this->htl_name.'/login');
    }

    if (md5(MD5_SALT.$user['USR_MAIL']) != $token || $user->MEMO != $token2) {
      Session::set_flash('error', __('lbl_error34'));
      Response::redirect($this->htl_name.'/login');
    }




    $data = array(
      'error'  => Session::get_flash('error'), 
      'name'   => $user['USR_NAME'],
      'user_id'=> $user_id,
      'token'  => md5(MD5_SALT.$user_id),
      'type'   => '0',
      'flg'    => '1',
      'action' => HTTP.'/'.$this->htl_name.'/reset_confirm',
      'login_url'  => HTTP.'/'.$this->htl_name.'/login',
      'mypage_url' => HTTP.'/'.$this->htl_name.'/mypage',
      );
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/regist',$data);

  }


  public function action_reset_confirm()
  {
    $data = Input::post();
    $user_id = $data['id'];
    $hashed_user_id = $data['token'];

    if (!Security::check_token()) {
      Response::redirect($this->htl_name.'/');
    }

    if ($hashed_user_id != md5(MD5_SALT.$user_id)) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/');
    }

    if (!isset($data['loginPass']) || $data['loginPass'] == '') {
      Session::set_flash('error', __('lbl_error35'));
      $url = $_SERVER['HTTP_REFERER'];    
      Response::redirect($url);
    }
    if (!isset($data['loginPass2']) || $data['loginPass2'] == '') {
      Session::set_flash('error', __('lbl_error36'));
      $url = $_SERVER['HTTP_REFERER'];     
      Response::redirect($url);
    }
    if ($data['loginPass'] != $data['loginPass2']) {
      Session::set_flash('error', __('lbl_error37'));
      $url = $_SERVER['HTTP_REFERER'];    
      Response::redirect($url);
    }

    $user = Model_M_Usr::find_by_pk($user_id);
    $password = md5(MD5_SALT.$data['loginPass']);

    $user->USR_PWD = $password;
    $user->MEMO = '';
    $user->save();
    Session::set_flash('error', __('lbl_error42'));
    Response::redirect($this->htl_name.'/'.'login');
  }


  public function action_logout()
  {
    $lang = Session::get('language');
    Session::destroy();
    if ($lang) {
      Session::set('language', $lang);
    }
    Response::redirect(HTTP.'/'.$this->htl_name);
  }

  public function action_language($la)
  {
    if (is_array($la)) {
      $la = array_shift($la);
    }
    if ($la != 'ja' &&  
        $la != 'en' && 
        $la != 'ko' && 
        $la != 'ch' && 
        $la != 'tw') {
      $la = 'en';
    }

    // if ($la == 'ko' || 
    //     $la == 'ch' || 
    //     $la == 'tw') {
    //   $la = 'en';
    // }
    Session::set('language', $la);

    if (Input::post()) {
      Session::set('plan_search_option', Input::post());
    }

    $url = Input::server('HTTP_REFERER');
    if ($url && strpos($url, Input::server('HTTP_HOST')) !== false) {
      Response::redirect($url);
    } else {
      if (Input::get('login', '')) {
        Response::redirect(HTTP.'/'.$this->htl_name.'/login');
      } else {
        Response::redirect(HTTP.'/'.$this->htl_name.'/plan/search');
      }
    }
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
