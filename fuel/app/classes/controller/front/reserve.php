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
class Controller_Front_Reserve extends Controller_Common
{
  /**
   * The basic welcome message
   *
   * @access  public
   * @return  Response
   */


  /**
  *
  *
  *
  *
  **/
  public function action_index($id)
  {

    $ids = explode(EXPLODE, $id);

    if (count($ids) != 7) {
      Response::redirect($this->htl_name.'/plan');
    }

    foreach ($ids as $key => $value) {
      if (!preg_match("/^[a-zA-Z0-9]+$/", $value)) {
        Response::redirect($this->htl_name.'/plan');
      }
    }

    if ($ids[0] != $this->htl_id) {
      Response::redirect($this->htl_name.'/plan');
    }
    if ($ids[3] < 1 || $ids[3] > 6) {
      Response::redirect($this->htl_name.'/plan');
    }
    if ($ids[4] < 1 || $ids[4] > 14) {
      Response::redirect($this->htl_name.'/plan');
    }
    if (date('Ymd', strtotime($ids[6])) < date('Ymd', strtotime('-1 day'))) {
      Session::set_flash('error',__('lbl_error2'));
      Response::redirect($this->htl_name.'/plan');
    }

    $param = array(
        'htl_id'      => $ids[0],
        'pln_id'      => $ids[1],
        'type_id'     => $ids[2],
        'person_num'  => $ids[3],
        'stay_count'  => $ids[4],
        'room_num'    => $ids[5],
        'stay_date'   => $ids[6],
      );
    $price_list = $this->price_list($param);
    if (array_search(0, $price_list)) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }

    $convert_price_list = array();
    $sum = 0;


    foreach ($price_list as $key => $value) {
      $format = 'Y-m-d';
      $datec = DateTime::createFromFormat($format, $key);
      $date_format = __('date_format');
      $date_format .= '('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')';
      $date =  $datec->format($date_format);
      $convert_price_list[$date]['one_person'] = $value;
      $convert_price_list[$date]['one_stay']   = $value * $param['person_num'];
      $sum += $convert_price_list[$date]['one_stay'];
    }


    $payment_info = array(
                            'price_list'         => $price_list,
                            'convert_price_list' => $convert_price_list,
                            'price_sum'          => $sum,
                            'price_total'        => $sum * $param['room_num'],
    );

    $rsv_info = array(
                        'ids'          => $param,
                        'payment_info' => $payment_info,
    );

    if ($old_data = Session::get('RSV_INFO')) {
      Session::delete('RSV_INFO');
    }

    Session::set('RSV_INFO', $rsv_info);

    // シークレットプランは個人情報を毎回入力する
    if (Session::get('secret_plan')) {
      Response::redirect($this->htl_name.'/rsvlogin');
    }

    if ($user = Session::get('user_data')) {
      Session::delete('user_data');
      Session::set('user_data',$user); //     セッションの更新
      $this->member($user, $rsv_info);
    }else{
      Session::set('rsv_get_value', $id);
      $data = array(
        'error'        => Session::get_flash('error'),
        'name'         =>  __('lbl_guest'),
        'login_url'    => HTTP.'/'.$this->htl_name.'/login',
        'mypage_url'   => HTTP.'/'.$this->htl_name.'/mypage',
        'nm_action'    => HTTP.'/'.$this->htl_name.'/nm_signup',
        'passreminder' => HTTP.'/'.$this->htl_name.'/password',
        'action'       => $this->htl_name.'/login_a',
        'action2'      => $this->htl_name.'/rsvlogin',
        'action3'      => $this->htl_name.'/reserve/signup',
        'is_from_rsv'  => true
      );

      // delete session login
      Session::delete('no_register_member');
      Session::delete('no_member_user');

      $this->template->mypage_flg = true;
      $this->template->js = '';
      $this->template->title = __('lbl_front_title');
      $this->template->content = View::forge('front/login', $data);
    }
  }


  public function action_signup()
  {
    if ($rsv_info = Session::get('RSV_INFO')) {
      // Session::delete('rsv_info');
        $data = Input::post();
        if(isset($data["no_register_member"])){
            Session::set('no_register_member', true);
        }
        $this->no_member($rsv_info);
    }else{
      Session::set_flash(__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }
  }


  /*
   プラン情報が存在するか、部屋数や宿泊数が制限範囲内かのチェック
   予約画面を表示
  */
  private function member($user_data, $rsv_info)
  {
    $array = $this->m_nm_common($rsv_info);

    $user = Model_M_Usr::find_by_pk($user_data['user_id']);
    if ($user['USR_POINTS'] >= 5) {
      $discount_flg = '1';
    }else{
      $discount_flg = '0';
    }


    $data = array(
      'htl_name'     => $array['HTL_NAME'],
      'htl_type'     => $array['HTL_TYPE'],
      'name'         => $user_data['user_name'],
      'plan'         => $array['plan_data'],
      'user'         => $user,
      'discount_flg' => $discount_flg,
      'error'        => Session::get_flash('error'),
      // 'ids'  => $ids,
      'price_total'  => $rsv_info['payment_info']['price_total'],
      );


    $data['login_url'] = HTTP.'/'.$this->htl_name;
    $data['mypage_url'] = HTTP.'/'.$this->htl_name.'/mypage';
    $data['mypage_edit_url'] = HTTP.'/'.$this->htl_name.'/mypage/edit?t=1';
    $data['action'] = $this->htl_name.'/reserve/m_confirm';
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/member_reserve',$data);
  }


  private function no_member($rsv_info)
  {
    $array = $this->m_nm_common($rsv_info);

    $data = array(
      'htl_name'  => $array['HTL_NAME'],
      'htl_type'  => $array['HTL_TYPE'],
      'plan'      => $array['plan_data'],
      'man_flg'   => 'checked',
      'woman_flg' => '',
      'form'      => Session::get_flash('form'),
      'error'     => Session::get_flash('error'),
      // 'ids'       => $ids,
      'price_total'  => $rsv_info['payment_info']['price_total'],
      'is_register_member'  => Session::get('no_register_member') ? false : true,
      );


    $data['login_url'] = HTTP.'/'.$this->htl_name.'/login';
    $data['mypage_url'] = HTTP.'/'.$this->htl_name.'/mypage';
    $data['action']  = $this->htl_name.'/reserve/nm_confirm';
    $this->template->mypage_flg = true;
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/no_member_reserve',$data);
  }


  /*会員、非会員の共通処理*/
  private function m_nm_common($rsv_info)
  {
    $htl_id     = $rsv_info['ids']['htl_id'];
    $pln_id     = $rsv_info['ids']['pln_id'];
    $type_id    = $rsv_info['ids']['type_id'];
    $person_num = $rsv_info['ids']['person_num'];
    $stay_count = $rsv_info['ids']['stay_count'];
    $room_num   = $rsv_info['ids']['room_num'];
    $stay_date  = $rsv_info['ids']['stay_date'];



    $format = 'Ymd';
    $datec = DateTime::createFromFormat($format, $stay_date);
    $date =  $datec->format('Y-m-d');
    $stay_date = $date;

    $plan_rtype = Model_M_Plan_Rtype::forge();
    $plan_rtype_data = $plan_rtype->get_plan_rtype($htl_id, $pln_id, $type_id, $stay_date, $this->language);
    /*そもそもプランなどのデータが存在しない場合*/
    if ($plan_rtype_data == 0) {
        Session::set_flash('error',__('lbl_error3').' ec2');
        Response::redirect($this->htl_name.'/plan');
    }

    /*手仕舞いの時間を超えた場合*/
    // if (date('Ymd', strtotime($stay_date)) == date('Ymd', strtotime('-1 day'))) {
    //   if ($plan_rtype_data['PLN_LIMIT_TIME'] == null || date('H:i', strtotime( ($plan_rtype_data['PLN_LIMIT_TIME'] - 24).':00')) < date('H:i')) {
    if ( ( $plan_rtype_data['PLN_LIMIT_DAY'] == null && $plan_rtype_data['PLN_LIMIT_TIME'] == null && date('Ymd', strtotime($stay_date)) == date('Ymd', strtotime('-1 day')) )
      || ( date('Y-m-d', strtotime($stay_date.' '.(!$plan_rtype_data['PLN_LIMIT_DAY'] ? 1 : ($plan_rtype_data['PLN_LIMIT_DAY'] * -1)).' day')).' '.date('H:i', strtotime($plan_rtype_data['PLN_LIMIT_TIME'] - ($plan_rtype_data['PLN_LIMIT_DAY'] ? 0 : 24).':00')) < date('Y-m-d H:i') )
      ) {
        Session::set_flash('error',__('lbl_error2'));
        Response::redirect($this->htl_name.'/plan');
      }
    // }

    /*許容人数を超えた場合*/
    if ($plan_rtype_data['PLN_MIN'] > $person_num || $plan_rtype_data['PLN_MAX'] < $person_num) {
        Session::set_flash('error',__('lbl_error3').'_ec3');
        Response::redirect($this->htl_name.'/plan');
    }
    /*泊数制限を超えた場合*/
    if ($plan_rtype_data['PLN_STAY_LOWER'] > $stay_count || $plan_rtype_data['PLN_STAY_UPPER'] < $stay_count) {
        Session::set_flash('error',__('lbl_error3').' ec4');
        Response::redirect($this->htl_name.'/plan');
    }


    $htl = Model_M_Htl::find_by_pk($htl_id);
    $checkin_times = explode(',', $plan_rtype_data['CHECK_IN']);
    if ($stay_date == date('Y-m-d')) {
      $now_time = date('H:i');
      foreach ($checkin_times as $key => $value) {
        if ($value < $now_time) {
          unset($checkin_times[$key]);
        }
      }
    }

    $plan_data = array(
        'PLN_NAME'    => $plan_rtype_data['PLN_NAME'],
        'TYPE_NAME'   => $plan_rtype_data['TYPE_NAME'],
        'TYPE_ID'     => $type_id,
        'DATE'        => $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')'),
        'STAYROOMNUM' => $room_num,
        'STAYDATENUM' => $stay_count,
        'CHECK_IN'    => $checkin_times,
      );

    return array( 'plan_data' => $plan_data, 'HTL_NAME' => $htl['HTL_NAME'], 'HTL_TYPE' => $htl['HTL_TYPE']);
  }


  public function action_m_confirm()
  {
    $data = Input::post();

    /*postに関する不備のチェック*/
    if (!isset($data['policy']) || $data['policy'] != 'on') {
      Session::set_flash('error',__('lbl_error4'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }
    if (!isset($data['paymentFlg'])) {
      Session::set_flash('error',__('lbl_error5'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }
    if (!$rsv_info = Session::get('RSV_INFO')) {
    // if (!$rsv_data = Session::get('RSV_INFO')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }

    $rsv_info['post'] = $data;
    $param = $rsv_info['ids'];
    $format = 'Ymd';
    $datec = DateTime::createFromFormat($format, $rsv_info['ids']['stay_date']);
    $date =  $datec->format('Y-m-d');
    $start = $date;



    // $add_pt = 1;
    if (isset($data['privilege']) && $data['privilege'] == '2') {
      $rsv_info['payment_info']['final_price'] = $rsv_info['payment_info']['price_total'] - DISCOUNT;
      $rsv_info['discount_flg'] = '1';
      $pt = DISCOUNT_POINT;
      $add_pt = 0;
    }else{
      $rsv_info['payment_info']['final_price'] = $rsv_info['payment_info']['price_total'];
      $rsv_info['post']['privilege'] = '1';//        ポイントが５未満の場合は割引が選択肢にないため、一応、再度定義する。
      $rsv_info['discount_flg'] = '0';
      $pt = 0;
    }

    /* 割引後の価格が０円以下になった場合。
      　フロント決済とカード決済で処理が変わる
     */
    if ($data['paymentFlg'] == 1) {
      if ($rsv_info['payment_info']['final_price'] < 0) {
          $rsv_info['payment_info']['final_price'] = 0;
      }
    }else if ($data['paymentFlg'] == 2) {
      if ($rsv_info['payment_info']['final_price'] <= 0) {
        Session::set_flash('error',__('lbl_error6'));
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);
      }
    }


    $flg =  $this->stock_list($param);

    if ($flg != '0') {
      Session::set_flash('error',__('lbl_error7'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }else{
      $rsv_manage = Model_T_Rsv_Manage::forge();
      $result = $rsv_manage->rsvno_check($this->htl_id);

      if ($result['0'] == '0') {
        $rsv_info['RSV_NO'] = $result['1'];
      }else{
        Session::set_flash('error',__('lbl_error1'));
        Response::redirect($this->htl_name.'/plan');
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($result['1'],true) . "\n");
      }
    }


    Session::set('RSV_INFO', $rsv_info);
    if ($data['paymentFlg'] == 1) {
      $this->member_confirm();
    }else{
      Response::redirect($this->htl_name.'/reserve/credit_setting');
    }
  }


  public function action_nm_confirm()
  {
    $url = $this->htl_name.'/reserve/signup';

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
    // }elseif ($data['ciDate'] == null || $data['ciDate'] == '') {
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

    if (!isset($data['paymentFlg'])) {
      Session::set_flash('error',__('lbl_error5'));
      Session::set_flash('form', $data);
      // $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }
    //@todo no check box register
//    if (!isset($data['register']) || $data['register'] != '1') {
//      Session::set_flash('error',__('lbl_error17'));
//      Session::set_flash('form', $data);
//      // $url = $_SERVER['HTTP_REFERER'];
//      Response::redirect($url);
//    }

    if (!$rsv_info = Session::get('RSV_INFO')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }

    $user = Model_M_Usr::forge();
    $result = $user->get_user_one($data['email']);

    // シークレットプランの補正
    if ($tmp = Session::get('secret_plan')) {
      $htl_id = $tmp['htl_id'];
      $plan_id = $tmp['plan_id'];
      $secret_id = $tmp['secret_id'];
      $secret = Model_M_Secret::forge();
      $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);
    }

    if ($result != 1 && ! isset($secret_data)) {
      if ($result['RANK_ID'] == 1) {
        Session::set_flash('error',__('lbl_error18'));
        Session::set_flash('form', $data);
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);
      }
    }


    $rsv_info['payment_info']['final_price'] = $rsv_info['payment_info']['price_total'];
    $rsv_info['post'] = array(
                                 'ciTime'     => $data['ciTime'],
                                 'paymentFlg' => $data['paymentFlg'],
                                 'policy'     => $data['policy'],
                                 'privilege'  => '1',
    );
    $rsv_info['discount_flg'] = '0';

    $flg =  $this->stock_list($rsv_info['ids']);

    if ($flg != '0') {
      Session::set_flash('error',__('lbl_error7'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }else{
      $rsv_manage = Model_T_Rsv_Manage::forge();
      $result = $rsv_manage->rsvno_check($this->htl_id);

      if ($result['0'] == '0') {
        $rsv_info['RSV_NO'] = $result['1'];
      }else{
        Session::set_flash('error',__('lbl_error1'));
        Response::redirect($this->htl_name.'/plan');
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($result['1'],true) . "\n");
      }
    }

    Session::set('RSV_INFO', $rsv_info);
    if(!isset($data["register"])){
        Session::set("no_member_user", $data);
        $this->no_member_no_register_confirm($data, $rsv_info);
    }
    else{
        $this->no_member_confirm($data, $rsv_info);
    }

  }

  private function no_member_no_register_confirm($data, $rsv_info){
      $rsv_info['post'] = $data;
      $param = $rsv_info['ids'];
      $format = 'Ymd';
      $datec = DateTime::createFromFormat($format, $rsv_info['ids']['stay_date']);
      $date =  $datec->format('Y-m-d');
      $start = $date;
      // $add_pt = 1;
      if (isset($data['privilege']) && $data['privilege'] == '2') {
          $rsv_info['payment_info']['final_price'] = $rsv_info['payment_info']['price_total'] - DISCOUNT;
          $rsv_info['discount_flg'] = '1';
          $pt = DISCOUNT_POINT;
          $add_pt = 0;
      }else{
          $rsv_info['payment_info']['final_price'] = $rsv_info['payment_info']['price_total'];
          $rsv_info['post']['privilege'] = '1';//        ポイントが５未満の場合は割引が選択肢にないため、一応、再度定義する。
          $rsv_info['discount_flg'] = '0';
          $pt = 0;
      }
      if ($data['paymentFlg'] == 1) {
          if ($rsv_info['payment_info']['final_price'] < 0) {
              $rsv_info['payment_info']['final_price'] = 0;
          }
      }else if ($data['paymentFlg'] == 2) {
          if ($rsv_info['payment_info']['final_price'] <= 0) {
              Session::set_flash('error',__('lbl_error6'));
              $url = $_SERVER['HTTP_REFERER'];
              Response::redirect($url);
          }
      }
      $flg =  $this->stock_list($param);
      if ($flg != '0') {
          Session::set_flash('error',__('lbl_error7'));
          $url = $_SERVER['HTTP_REFERER'];
          Response::redirect($url);
      }else{
          $rsv_manage = Model_T_Rsv_Manage::forge();
          $result = $rsv_manage->rsvno_check($this->htl_id);

          if ($result['0'] == '0') {
              $rsv_info['RSV_NO'] = $result['1'];
          }else{
              Session::set_flash('error',__('lbl_error1'));
              Response::redirect($this->htl_name.'/plan');
              error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($result['1'],true) . "\n");
          }
      }


      Session::set('RSV_INFO', $rsv_info);
      if ($data['paymentFlg'] == 1) {
          $this->no_member_no_register_rsv_confirm($data);
      }else{
          Response::redirect($this->htl_name.'/reserve/credit_setting');
      }

  }

  private function no_member_no_register_rsv_confirm($data){
      if (!$rsv_info = Session::get('RSV_INFO')) {
          Session::set_flash('error',__('lbl_error1'));
          Response::redirect($this->htl_name.'/plan');
      }
      $user_data = [
          "USR_MAIL"=>$data["email"],
          "USR_NAME"=>$data["name"].$data["name2"],
          "USR_KANA"=>$data["kana"].$data["kana2"],
      ];

      $plan_data  = Model_M_Plan::find_one_by(array('HTL_ID' => $this->htl_id, 'PLN_ID' => $rsv_info['ids']['pln_id']));
      $rtype_data = Model_M_Rtype::find_one_by(array('HTL_ID' => $this->htl_id, 'TYPE_ID' => $rsv_info['ids']['type_id']));
      $htl_data   = Model_M_Htl::find_by_pk($this->htl_id);
      //$user_data  = Model_M_Usr::find_by_pk($user['user_id']);
      if (!$plan_data || !$rtype_data || !$htl_data) {
          Session::set_flash('error',__('lbl_error1'));
          Response::redirect($this->htl_name.'/plan');
      }
      $data = array();

      $data['price']            = $rsv_info['payment_info']['convert_price_list'];
      $data['price_total']      = $rsv_info['payment_info']['final_price'];
      $data['price_sum']        = $rsv_info['payment_info']['price_sum'];
      $data['person_total_num'] = $rsv_info['ids']['room_num'] * $rsv_info['ids']['person_num'];
      $data['param']            = $rsv_info['ids'];
      $data['plan']             = $plan_data;
      $data['user']             = $user_data;
      $data['rtype']            = $rtype_data;
      $data['plan']['CHECK_IN'] = $rsv_info['post']['ciTime'];

      $arrive_date = $rsv_info['ids']['stay_date'];
      $leave_date = date('Ymd', strtotime($arrive_date.' + '.$rsv_info['ids']['stay_count'].' day'));
      $cancel_pay_date = date('Ymd', strtotime($arrive_date.' - 4 day'));
      $format = 'Ymd';

      $datec = DateTime::createFromFormat($format, $arrive_date);
      $data['plan']['DATE']     = $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')');

      $datec = DateTime::createFromFormat($format, $leave_date);
      $data['plan']['DATE2']    = $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')');

      $datec = DateTime::createFromFormat($format, $cancel_pay_date);
      $data['plan']['DATE3']    = $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')');

      $data['login_url']        = HTTP.'/'.$this->htl_name;
      $data['mypage_url']       = HTTP.'/'.$this->htl_name.'/mypage';
      $data['action']           = $this->htl_name.'/reserve/order';
      $data['ccl_policy']       = $htl_data['CCL_RULE'];
      $data['name']             = $user_data['USR_NAME'];
      $data['discount_flg']     = $rsv_info['discount_flg'];

      // 多言語対応
      $array = $this->m_nm_common($rsv_info);
      $data['plan']['PLN_NAME'] = $array['plan_data']['PLN_NAME'];
      $data['rtype']['TYPE_NAME'] = $array['plan_data']['TYPE_NAME'];

      $this->template->js = '';
      $this->template->title = __('lbl_front_title');

      // send to view
      $data["no_member"] = true;


      $this->template->content = View_Smarty::forge('front/reserve/member_confirm',$data);

  }

  public function action_credit_setting()
  {
    if (!$rsv_info = Session::get('RSV_INFO')) {
      if (!$rsv_data = Session::get('edit_rsvno')) {
        Session::set_flash('error',__('lbl_error1'));
        Response::redirect($this->htl_name.'/plan');
      }
      $rsv_info = $this->convert_rsv_info($rsv_data['rsv_no']);
    }
    if ( !$user = Session::get('user_data')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }

    /*カード一覧取得*/
    $card_data = Model_M_Credit::find_by(array('HTL_ID' => $this->htl_id, 'USR_ID' => $user['user_id']));
    $card_list = array();
    if (count($card_data) > 0) {
      foreach ($card_data as $key => $value) {
        $card_list[$value['CRE_ID']] = array(
              'comp_name'  => $value['CRE_COMPANY_NAME'],
              'card_no'    => $value['CRE_CARD_CD'],
              'owner_name' => $value['CRE_NAME'],
              'year'       => '20'.$value['CRE_YEAR'],
              'month'      => $value['CRE_MONTH'],
          );
        $list_flg = '1';
      }
    }else{
      $list_flg = '0';
    }


    $data = array();

    $user_data = Model_M_Usr::find_by_pk($user['user_id']);

    if ($nc = Session::get_flash('new_card')) {
      $data['new_card'] = $nc;
    }

    $data['list_flg']    = $list_flg;
    $data['claim_name']  = $user_data['USR_KANA'];
    $data['card_list']   = $card_list;
    $data['action']      = $this->htl_name.'/reserve/credit_confirm';
    $data['stop_url']    = '/'.$this->htl_name.'/plan';
    $data['error']       = Session::get_flash('error');
    $data['price_total'] = $rsv_info['payment_info']['final_price'];
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/card_setting',$data);
  }





  public function action_creditsave()
  {



    $this->member_confirm();
  }


  public function action_credit_confirm()
  {
    $post = Input::post();
    $flg = '0';
    if (!$rsv_info = Session::get('RSV_INFO')) {
      if (!$rsv_data = Session::get('edit_rsvno')) {
        Session::set_flash('error',__('lbl_error1'));
        Response::redirect($this->htl_name.'/plan');
      }else{
        $rsv_info = $this->convert_rsv_info($rsv_data['rsv_no']);
        $flg = '1';
      }
    }

    if (!$user = Session::get('user_data')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }
    $user_data = Model_M_Usr::find_by_pk($user['user_id']);


    /*既存カードを選択した場合*/
    if (isset($post['cardType']) && $post['cardType'] == '1') {
      if ( ! isset($post['cardCom'])) {
        Session::set_flash('error',__('lbl_error21'));
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);
      }
      $card_info= Model_M_Credit::find_one_by(array(
                    'CRE_ID' => @$post['cardCom'],
                    'HTL_ID' => $this->htl_id,
                    'USR_ID' => @$user_data['USR_ID'],
                    ), null, null, null);
      if (count($card_info) == 0) {
        Session::set_flash('error',__('lbl_error19'));
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);
      }else{
        $sendid = $card_info['CRE_ID'];
        $POST_DATA = array(
          'clientip'   => CLIENT_IP,
          'cardnumber' => '8888888888888882',
          'expyy'      => '00',
          'expmm'      => '00',
          'money'      => $rsv_info['payment_info']['final_price'],
          'send'       => 'mall',
          // 'username'   => $new_card['name'],
          'telno'      => '0000000000',
          'email'      => $user_data['USR_MAIL'],
          'sendid'     => $user_data['USR_ID'].$sendid,
          'sendpoint'  => $this->htl_id.$rsv_info['RSV_NO'],
          // 'pubsec' => '',
          'printord'   => 'yes',
          // 'telnocheck' => '',
          'div'        => '01',
          // 'seccode'    => $new_card['sc'],
        );
        $API_URL='https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      }



    /*新規カードの場合*/
    }else if (isset($post['cardType']) && $post['cardType'] == '2') {
      $e_flg = '0';  $e_msg = '';
      if (isset($post['cardName']) && $post['cardName'] != '') {
        $new_card['name'] = $post['cardName'];
      }else{
        $e_flg = '1';
        $e_msg = __('lbl_error20');
      }

      if (isset($post['cardNum']) && $post['cardNum'] != '') {
        $new_card['no'] = $post['cardNum'];
      }else{
        $e_flg = '1';
        $e_msg = __('lbl_error21');
      }

      if (isset($post['cardCord']) && $post['cardCord'] != '') {
        $new_card['sc'] = $post['cardCord'];
      }else{
        $e_flg = '1';
        $e_msg = __('lbl_error22');
      }

      if (isset($post['cardDate_y']) && $post['cardDate_y'] != '') {
        $new_card['year'] = $post['cardDate_y'];
      }else{
        $e_flg = '1';
        $e_msg = __('lbl_error23');
      }

      if (isset($post['cardDate_m']) && $post['cardDate_m'] != '') {
        $new_card['month'] = $post['cardDate_m'];
      }else{
        $e_flg = '1';
        $e_msg = __('lbl_error24');
      }


      if ($e_flg == '1') {
        Session::set_flash('new_card', $new_card);
        Session::set_flash('error',$e_msg);
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);
      }

      $card_info= Model_M_Credit::find_one_by(array(
                    'HTL_ID'      => $this->htl_id,
                    'USR_ID'      => $user_data['USR_ID'],
                    'CRE_NAME'    => $new_card['name'],
                    'CRE_CARD_CD' => substr($new_card['no'], -4),
                    'CRE_MONTH'   => $new_card['month'],
                    'CRE_YEAR'    => $new_card['year'],
                    ), null, null, null);

      if (count($card_info) == 0) {
        $credit = Model_M_Credit::forge()->set(array(
                    'HTL_ID'           => $this->htl_id,
                    'USR_ID'           => $user_data['USR_ID'],
                    'CRE_NAME'         => $new_card['name'],
                    'CRE_CARD_CD'      => substr($new_card['no'], -4),
                    'CRE_MONTH'        => $new_card['month'],
                    'CRE_YEAR'         => $new_card['year'],
                    'CRE_COMPANY_NAME' => $this->card_type($new_card['no']),
                  ));
        $result = $credit->save();
        $sendid = $result[0];


        $POST_DATA = array(
          'clientip'   => CLIENT_IP,
          'cardnumber' => $new_card['no'],
          'expyy'      => $new_card['year'],
          'expmm'      => $new_card['month'],
          'money'      => $rsv_info['payment_info']['final_price'],
          'send'       => 'mall',
          'username'   => $new_card['name'],
          'telno'      => $user_data['USR_TEL'],
          'email'      => $user_data['USR_MAIL'],
          'sendid'     => $user_data['USR_ID'].$sendid,
          'sendpoint'  => $this->htl_id.$rsv_info['RSV_NO'],
          // 'pubsec' => '',
          'printord'   => 'yes',
          // 'telnocheck' => '',
          'div'        => '01',
          'seccode'    => $new_card['sc'],
        );
      }else{
        $sendid = $card_info['CRE_ID'];
        $POST_DATA = array(
          'clientip'   => CLIENT_IP,
          'cardnumber' => '8888888888888882',
          'expyy'      => '00',
          'expmm'      => '00',
          'money'      => $rsv_info['payment_info']['final_price'],
          'send'       => 'mall',
          // 'username'   => $new_card['name'],
          'telno'      => '0000000000',
          'email'      => $user_data['USR_MAIL'],
          'sendid'     => $user_data['USR_ID'].$sendid,
          'sendpoint'  => $this->htl_id.$rsv_info['RSV_NO'],
          // 'pubsec' => '',
          'printord'   => 'yes',
          // 'telnocheck' => '',
          'div'        => '01',
          // 'seccode'    => $new_card['sc'],
        );
      }


      $API_URL='https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';

    }else{
      Session::set_flash('error',__('lbl_error25'));
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }

    $rsv_info['api_post_data'] = $POST_DATA;

    if ($flg == '1') {
      $rsv_data['api_post_data'] = $POST_DATA;
      Session::set('EDIT_RSV_INFO', $rsv_data);
      $this->action_edit(array('0' => $rsv_info['RSV_NO'], '1' => '1'));
    }else{
      Session::set('RSV_INFO', $rsv_info);
      $this->member_confirm();
    }
  }


  private function convert_rsv_info($rsv_no)
  {
    $rsv_data = Model_T_Rsv::find_one_by(array('HTL_ID' => $this->htl_id, 'RSV_NO' => $rsv_no));

    $array = array(
      'payment_info' => array(
        'final_price' => $rsv_data['PLN_CHG_TOTAL'],
      ),
      'RSV_NO' => $rsv_no,
    );

    return $array;
  }

  private function member_confirm()
  {
    if (!$rsv_info = Session::get('RSV_INFO')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }
    if (!$user = Session::get('user_data')) {
      // シークレットプランはログイン不要
      if ($tmp = Session::get('secret_plan')) {
        $user['user_id'] = $tmp['user_id'];
      } else {
        Session::set_flash('error',__('lbl_error1'));
        Response::redirect($this->htl_name.'/plan');
      }
    }


    $plan_data  = Model_M_Plan::find_one_by(array('HTL_ID' => $this->htl_id, 'PLN_ID' => $rsv_info['ids']['pln_id']));
    $rtype_data = Model_M_Rtype::find_one_by(array('HTL_ID' => $this->htl_id, 'TYPE_ID' => $rsv_info['ids']['type_id']));
    $htl_data   = Model_M_Htl::find_by_pk($this->htl_id);
    $user_data  = Model_M_Usr::find_by_pk($user['user_id']);


    if (!$plan_data || !$rtype_data || !$htl_data || !$user_data) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/plan');
    }

    $data = array();

    $data['price']            = $rsv_info['payment_info']['convert_price_list'];
    $data['price_total']      = $rsv_info['payment_info']['final_price'];
    $data['price_sum']        = $rsv_info['payment_info']['price_sum'];
    $data['person_total_num'] = $rsv_info['ids']['room_num'] * $rsv_info['ids']['person_num'];
    $data['param']            = $rsv_info['ids'];
    $data['plan']             = $plan_data;
    $data['user']             = $user_data;
    $data['rtype']            = $rtype_data;
    $data['plan']['CHECK_IN'] = $rsv_info['post']['ciTime'];

    $arrive_date = $rsv_info['ids']['stay_date'];
    $leave_date = date('Ymd', strtotime($arrive_date.' + '.$rsv_info['ids']['stay_count'].' day'));
    $cancel_pay_date = date('Ymd', strtotime($arrive_date.' - 4 day'));
    $format = 'Ymd';

    $datec = DateTime::createFromFormat($format, $arrive_date);
    $data['plan']['DATE']     = $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')');

    $datec = DateTime::createFromFormat($format, $leave_date);
    $data['plan']['DATE2']    = $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')');

    $datec = DateTime::createFromFormat($format, $cancel_pay_date);
    $data['plan']['DATE3']    = $datec->format(__('date_format').'('.Config::get('staym.weeks.'.__('use_lang').'.'.$datec->format('w')).')');

    $data['login_url']        = HTTP.'/'.$this->htl_name;
    $data['mypage_url']       = HTTP.'/'.$this->htl_name.'/mypage';
    $data['action']           = $this->htl_name.'/reserve/order';
    $data['ccl_policy']       = $htl_data['CCL_RULE'];
    $data['name']             = $user_data['USR_NAME'];
    $data['discount_flg']     = $rsv_info['discount_flg'];

    // 多言語対応
    $array = $this->m_nm_common($rsv_info);
    $data['plan']['PLN_NAME'] = $array['plan_data']['PLN_NAME'];
    $data['rtype']['TYPE_NAME'] = $array['plan_data']['TYPE_NAME'];

    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/member_confirm',$data);
  }


  public function action_registafter()
  {
    if (!$rsv_info = Session::get('RSV_INFO')) {
      Response::redirect(HTTP.'/'.$this->htl_name.'/');
    }

    if ($rsv_info['post']['paymentFlg'] != '2') {
      $this->member_confirm();
    }else{
      Response::redirect($this->htl_name.'/reserve/credit_setting');
    }
  }


  private function no_member_confirm($data, $rsv_info)
  {

    if ($data['register'] == 1) {
      $param = array(
         'USR_NAME'  => $data['name'].$data['name2'],
         'USR_KANA'  => $data['kana'].$data['kana2'],
         'USR_SEI'   => $data['name'],
         'USR_MEI'   => $data['name2'],
         'KANA_SEI'  => $data['kana'],
         'KANA_MEI'  => $data['kana2'],
         'ZIP_CD'    => $data['zipcode'],
         'USR_ADR1'  => $data['address1'],
         'USR_ADR2'  => $data['address2'],
         'USR_TEL'   => $data['tel'],
         'USR_FAX'   => $data['fax'],
         'USR_SEX'   => $data['gender'],
         'USR_BIRTH' => $data['ciDate'],

         'RANK_ID'   =>'2',
         'USR_MAIL'  => $data['email'],
        );

      $user = Model_M_Usr::forge();
      $user_id = $user->insert_user($param);

      // シークレットプランの補正
      if ($tmp = Session::get('secret_plan')) {
        $htl_id = $tmp['htl_id'];
        $plan_id = $tmp['plan_id'];
        $secret_id = $tmp['secret_id'];
        $secret = Model_M_Secret::forge();
        $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);

        $tmp['user_id'] = $user_id[0];
        Session::set('secret_plan', $tmp);

        Response::redirect($this->htl_name.'/reserve/registafter');
      }


      $htl_data = Model_M_Htl::find_by_pk($this->htl_id);
      $url = HTTP.'/'.$this->htl_name.'/signup/?id='.$user_id[0].'&token='.md5(MD5_SALT.$data['email']);
      $mail = array(
        'from' => $htl_data['HTL_MAIL'],
        'to' => $data['email'],
        'subject' => SIGNUP_RSV_SUBJECT,
        'body' => SIGNUP_RSV_BODY."\n\n".$url,
        );

      $result = $this->send_mail($mail);
      if ($result == '0') {
        Session::set_flash('error',__('lbl_error26'));
      }else{
        Session::set_flash('error',$result);
        Session::set_flash('form', $data);
        $url = $_SERVER['HTTP_REFERER'];
        Response::redirect($url);
      }
    }

    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/send_mail');
  }



  public function action_order()
  {
    if (!$rsv_info = Session::get('RSV_INFO')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/plan');
    }

    // no member

      $post_data = Input::post();
    if(isset($post_data["no_member"]) && $post_data["no_member"]==1){
        $data = Session::get("no_member_user");
        $param_user = array(
          'USR_NAME'  => $data['name'].$data['name2'],
          'USR_KANA'  => $data['kana'].$data['kana2'],
          'USR_SEI'   => $data['name'],
          'USR_MEI'   => $data['name2'],
          'KANA_SEI'  => $data['kana'],
          'KANA_MEI'  => $data['kana2'],
          'ZIP_CD'    => $data['zipcode'],
          'USR_ADR1'  => $data['address1'],
          'USR_ADR2'  => $data['address2'],
          'USR_TEL'   => $data['tel'],
          'USR_FAX'   => $data['fax'],
          'USR_SEX'   => $data['gender'],
          'USR_BIRTH' => $data['ciDate'],

          'RANK_ID'   =>'2',
          'USR_MAIL'  => $data['email'],
      );

      $user_new = Model_M_Usr::forge();
      $user_id = $user_new->insert_user($param_user);
      $user = ["user_id"=>$user_id[0], "user_name"=>$param_user["USR_NAME"]];
    } else{
        if (!$user = Session::get('user_data')) {
            // シークレットプランはログイン不要
            if ($tmp = Session::get('secret_plan')) {
                $user['user_id'] = $tmp['user_id'];
            } else {
                Session::set_flash('error',__('lbl_error1'));
                Response::redirect($this->htl_name.'/plan');
            }
        }
    }



    $user_data = Model_M_Usr::find_by_pk($user['user_id']);
    $plan_data  = Model_M_Plan::find_one_by(array('HTL_ID' => $this->htl_id, 'PLN_ID' => $rsv_info['ids']['pln_id']));
    $rtype_data = Model_M_Rtype::find_one_by(array('HTL_ID' => $this->htl_id, 'TYPE_ID' => $rsv_info['ids']['type_id']));
    if (!$user_data || !$plan_data || !$rtype_data ) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/plan');
    }

    $param = array(
      'HTL_ID'          => $rsv_info['ids']['htl_id'],
      'RSV_NO'          => $rsv_info['RSV_NO'],
      'SERIAL_NO'       => '0',
      'PLN_ID'          => $rsv_info['ids']['pln_id'],
      'PLN_NAME'        => $plan_data['PLN_NAME'],
      'USR_ID'          => $user_data['USR_ID'],
      'ADJUST_TYPE'     => $rsv_info['post']['paymentFlg'],
      'PLN_CHG_TOTAL'   => $rsv_info['payment_info']['final_price'],
      'NUM_STAY'        => $rsv_info['ids']['stay_count'],
      'NUM_ROOM'        => $rsv_info['ids']['room_num'],
      'IN_DATE_TIME'    => $rsv_info['post']['ciTime'],
      // 'RSV_DATE'        => ,
      'RSV_STS'         => '1',
      'ORDER_CD'        => '',
      'CARD_BRAND_NAME' => '',
      'PT_OWN'          => '0',
      'TYPE_ID'         => $rsv_info['ids']['type_id'],
      'TYPE_NAME'       => $rtype_data['TYPE_NAME'],
      'RSVS'            => $rsv_info['payment_info']['price_list'],
      'PERSON_NUM1'     => $rsv_info['ids']['person_num'],
      'PERSON_NUM2'     => $rsv_info['ids']['person_num'],
      );

    // シークレットプランのプラン補正
    if ($tmp = Session::get('secret_plan')) {
      $htl_id = $tmp['htl_id'];
      $plan_id = $tmp['plan_id'];
      $secret_id = $tmp['secret_id'];
      $secret = Model_M_Secret::forge();
      $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);

      $param['PLN_ID'] = $tmp['plan_id'].'S'.$secret_data['SECRET_ID'];
      $param['PLN_NAME'] = $secret_data['PLN_NAME'];
    }


    $arrive_date = $rsv_info['ids']['stay_date'];
    $leave_date = date('Ymd', strtotime($arrive_date.' + '.$rsv_info['ids']['stay_count'].' day'));
    $format = 'Ymd';

    $datec = DateTime::createFromFormat($format, $arrive_date);
    $param['IN_DATE'] = $datec->format('Y-m-d');

    $datec = DateTime::createFromFormat($format, $leave_date);
    $param['OUT_DATE'] = $datec->format('Y-m-d');


    if ($user_data['USR_SEX'] == '1') {
      $param['PERSON_NUM2'] = '0';
    }else if ($user_data['USR_SEX'] == '2') {
      $param['PERSON_NUM1'] = '0';
    }

    // if (isset($rsv_info['ORDER_CD']) && $rsv_info['ORDER_CD'] != '') {
    //   $param['ORDER_CD'] = $rsv_info['ORDER_CD'];
    // }


    if ($rsv_info['discount_flg'] == '1') {
      if ($user_data['USR_POINTS'] < DISCOUNT_POINT) {
          Session::set_flash('error',__('lbl_error50'));
          Response::redirect(HTTP.'/'.$this->htl_name.'/plan');
      }
      $param['PT_USE']       = DISCOUNT_POINT;
      $param['PT_ADD_BASIC'] = '0';
    }else{
      $param['PT_USE']       = '0';
      $param['PT_ADD_BASIC'] = '1';
    }

    $rsv = Model_T_Rsv::forge();
    $flg =  $this->stock_list($rsv_info['ids']);
    if ($flg != '0') {
      Session::set_flash('error',__('lbl_error7'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/plan');
    }else{
      $result = $rsv->insert_rsv($param);
      $rsv_no = $result;
    }

    if ($rsv_no != $rsv_info['RSV_NO']) {
      error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r('インサート失敗',true) . "\n");
      error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($param,true) . "\n");
      error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($rsv_info,true) . "\n");
      Session::set_flash('error',__('lbl_error49'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/plan');
    }



    if ($rsv_info['post']['paymentFlg'] == '2' && isset($rsv_info['api_post_data'])) {
      $API_URL   = 'https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      $POST_DATA = $rsv_info['api_post_data'];

      $result = $this->zeusu_api($POST_DATA, $API_URL);
      if ($result[0] == '0') { //決済成功
        $order_code = $result[1];
      }else{
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r('決済に失敗しました。',true) . "\n");
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($POST_DATA,true) . "\n");
        $id = str_replace($user_data['USR_ID'], '', $POST_DATA['sendid']);

        $cre_info = Model_M_Credit::find_by_pk($id);
        if ($cre_info) {
          $cre_info->delete();
        }
        $rsv->delete_rsv($param['HTL_ID'], $param['RSV_NO']);
        Session::set_flash('error',$result[1]);
        // $rsv_info = unset($rsv_info['api_post_data']);
        Session::set('RSV_INFO', $rsv_info);

        // シークレットプランの補正
        if ( ! Session::get('secret_plan')) {
          Session::set('user_data', $user);
        }
        // $url = $_SERVER['HTTP_REFERER'];
        Response::redirect(HTTP.'/'.$this->htl_name.'/reserve/credit_setting');
      }

      // 一度で終わるようになったので不要
      /*
      $POST_DATA = array(
        'clientip' => CLIENT_IP,
        'king'     => $rsv_info['payment_info']['final_price'],
        'date'     => date('Ymd'),
        'ordd'     => $order_code,
        'autype'   => 'sale',
        );
      $API_URL='https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      $result = $this->zeusu_api($POST_DATA, $API_URL);
      if ($result[0] != '0') {
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r('決済確定に失敗しました。',true) . "\n");
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($POST_DATA,true) . "\n");
        Session::set_flash('error',__('lbl_error99')."\n".$result[1]);
        Response::redirect($this->htl_name.'/plan');
      }
      */
      $result = $rsv->update_rsv('ORDER_CD', $order_code, $this->htl_id, $rsv_no);
    }else if ($rsv_info['post']['paymentFlg'] == '2') {  //  決済フラグがあるが、カード情報がない場合
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/plan');
    }

    // 登録日と更新日時がずれないようにするため
    $rsv->update_rsv('RSV_DATE', date('Y-m-d H:i:s'), $this->htl_id, $rsv_no);


    if ($rsv_info['discount_flg'] == '1') {
      $user_data->set(array('USR_POINTS' => $user_data['USR_POINTS'] - $param['PT_USE'] ));
      $user_data->save();
    }



    $htl_data = Model_M_Htl::find_by_pk($this->htl_id);
    $body = $this->make_mail_body( $rsv_no, $htl_data['MAIL_CFM'], $this->htl_id);

    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $user_data['USR_MAIL'],
      'subject' => '予約完了メール/預約完成信/Completed Booking Mail',
      'body' => $body,
      );

    $result = $this->send_mail($mail);

    if ($result == 0) {
      if (Session::get('secret_plan')) {
        Session::destroy();
      } else {
        Session::destroy();
        Session::set('user_data', $user);
      }
    }

    $mail['to'] = $htl_data['HTL_MAIL'];
    $mail['subject'] = $htl_data['MAIL_CFM_TITLE'];

    $result = $this->send_mail($mail);

    if ($htl_data['ART_LINK_FLG'] == '1') {
      $POST_DATA = array(
        'customer_id' => $user_data['USR_ID'],
        'fullname' => $user_data['USR_NAME'],
        'fullname_kana' => $user_data['USR_KANA'],
        'gender' => $user_data['USR_SEX'],
        'zip_code' => $user_data['ZIP_CD'],
        'address' => $user_data['USR_ADR1'].$user_data['USR_ADR2'],
        'birth_date' => date('Y-m-d', strtotime(rtrim(str_replace(array('年','月','日'), '-', $user_data['USR_BIRTH']), '-'))),
        'tel' => $user_data['USR_TEL'],
        'email' => $user_data['USR_MAIL'],
        'email2' => $user_data['USR_MAIL2'],
        'email3' => $user_data['USR_MAIL3'],
        'mail_sender' => $user_data['MAG_ALLOW'],
        'reserve_count' => 1,
        'price_total' => $rsv_info['payment_info']['final_price'],
        'last_used' => date('Y-m-d H:i:s'),
        'branch' => $htl_data['HTL_NAME'],
        'point' => $user_data['USR_POINTS'],
        'account_key' => $htl_data['ART_ACCOUNT_KEY'],
        'account_secret' => $htl_data['ART_ACCOUNT_SECRET'],
      );
      $this->art_api($POST_DATA, 'customer_upsert');
    }

    $data = array(
      'login_url'   => HTTP.'/'.$this->htl_name,
      'mypage_url'  => HTTP.'/'.$this->htl_name.'/mypage',
      'name'        => $user_data['USR_NAME'],
      'RSV_NO'      => $rsv_no,
      'htl_name'    => $htl_data['HTL_NAME'],
      'htl_tel'     => $htl_data['HTL_TEL'],
      'htl_address' => $htl_data['HTL_ADR1'],
      );

    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/complete',$data);
  }




  public function action_edit($rsv_no)
  {

    if (!$user_data = Session::get('user_data')) {
      Response::redirect($this->htl_name.'/login');
    }

    $rsv = Model_T_Rsv::forge();
    $rsv_data = $rsv->get_user_rsv($this->htl_id, $user_data['user_id'], $rsv_no[0]);
    if (count($rsv_data) == 0) {
      Response::redirect($this->htl_name.'/login');
    }

    $chekin_times = explode(',', $rsv_data[0]['CHECK_IN']);




    $rsv_data[0]['chekin_times'] = explode(',', $rsv_data[0]['CHECK_IN']);

    $rsv_data[0]['action'] = HTTP.'/'.$this->htl_name.'/reserve/check';
    $rsv_data[0]['name'] = $user_data['user_name'];

    $rsv_data[0]['num'] = $rsv_data[0]['PLN_NUM_MAN'] + $rsv_data[0]['PLN_NUM_WOMAN'] + $rsv_data[0]['PLN_NUM_CHILD1'] + $rsv_data[0]['PLN_NUM_CHILD2'] + $rsv_data[0]['PLN_NUM_CHILD3'] + $rsv_data[0]['PLN_NUM_CHILD4'] + $rsv_data[0]['PLN_NUM_CHILD5'] + $rsv_data[0]['PLN_NUM_CHILD6'];

    $rsv = array('rsv_no' => $rsv_no[0], 'user_id'=>$user_data['user_id'] );



    $in_date = date('Y-m-d', strtotime($rsv_data[0]['IN_DATE']));
    $cannot_day = date('Y-m-d', strtotime($in_date." - 3day"));
    $today = date('Y-m-d');

    $cancel_flg = '0';
    if ($cannot_day <= $today) {
      $cancel_flg = '1';
    }

    $no_change_flg = '0';
    if ($today == $in_date) {
      foreach ($rsv_data[0]['chekin_times'] as $key => $time) {
        if ($time < date('H:i') ) {
          unset($rsv_data[0]['chekin_times'][$key]);
        }
      }
    }else if ($today > $in_date) {
      $no_change_flg = '1';
    }

    $rsv_data[0]['cancel_flg']    = $cancel_flg;
    $rsv_data[0]['no_change_flg'] = $no_change_flg;
    $rsv_data[0]['login_url']     = HTTP.'/'.$this->htl_name.'/login';
    $rsv_data[0]['mypage_url']    = HTTP.'/'.$this->htl_name.'/mypage';
    $rsv_data[0]['action_adjust'] = HTTP.'/'.$this->htl_name.'/reserve/credit_setting';

    $user = Model_M_Usr::find_by_pk($rsv_data[0]['USR_ID']);
    $rsv_data[0]['price_total']   = $rsv_data[0]['PLN_CHG_TOTAL'];
    $rsv_data[0]['claim_name']    = $user_data['user_name'];
    $rsv_data[0]['reserved_flg']  = '1';
    $rsv_data[0]['user']          = $user;
    $rsv_data[0]['htl']           = $this->htl_name;
    $rsv_data[0]['rsv_no']        = $rsv_no[0];
    // $rsv_data[0]['user']['USR_TEL'] = $user['USR_TEL'];
    // $rsv_data[0]['user']['USR_MAIL'] = $user['USR_MAIL'];
    $this->delete_sessions();
    Session::set('edit_rsvno', $rsv_data[0]);

    if (isset($rsv_no[1])) {
      $rsv_data[0]['ADTYPE'] = '2';
      $rsv['change_adjust_flg'] = '1';
    }


    Session::set('RSV_NO', $rsv);
    $this->template->mypage_flg = true;
    $this->template->js = 'front/front.js';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/edit',$rsv_data[0]);
  }



  public function action_check()
  {
    if (!$user_data = Session::get('user_data')) {
      Session::set_flash('error', __('lbl_error1'));
      Response::redirect($this->htl_name.'/login');
      // $user_data = array('user_name' =>  __('lbl_guest'), );
    }
    if (!$rsv_no = Session::get('RSV_NO')) {
      Session::set_flash('error', __('lbl_error1'));
      Response::redirect($this->htl_name.'/mypage');
    }

    $data = Input::post();
    if ($rsv_no['rsv_no'] != $data['RSV_NO']) {
      Session::set_flash('error', __('lbl_error1'));
      Response::redirect($this->htl_name.'/mypage');
    }

    $rsv = Model_T_Rsv::forge();
    $rsv_data = $rsv->get_user_rsv($this->htl_id, $rsv_no['user_id'], $rsv_no['rsv_no']);
    if (count($rsv_data) == 0) {
      Response::redirect($this->htl_name.'/login');
    }

    $data = Input::post();

    $rsv_data[0]['name'] = $user_data['user_name'];

    $rsv_data[0]['action'] = HTTP.'/'.$this->htl_name.'/reserve/save';
    $rsv_data[0]['ciTime'] =  $data['ciTime'];
    $rsv_data[0]['login_url'] = HTTP.'/'.$this->htl_name.'/login';
    $rsv_data[0]['mypage_url'] = HTTP.'/'.$this->htl_name.'/mypage';
    $rsv_data[0]['num'] = $rsv_data[0]['PLN_NUM_MAN'] + $rsv_data[0]['PLN_NUM_WOMAN'] + $rsv_data[0]['PLN_NUM_CHILD1'] + $rsv_data[0]['PLN_NUM_CHILD2'] + $rsv_data[0]['PLN_NUM_CHILD3'] + $rsv_data[0]['PLN_NUM_CHILD4'] + $rsv_data[0]['PLN_NUM_CHILD5'] + $rsv_data[0]['PLN_NUM_CHILD6'];

    $flg = '0';
    if ($rsv_data[0]['ADJUST_TYPE'] == '1') {
      $rsv_data[0]['ADJUST_TYPE'] = __('lbl_front');
      if (isset($rsv_no['change_adjust_flg']) && $rsv_no['change_adjust_flg'] == '1') {
        $post_data = Session::get('EDIT_RSV_INFO');
        if($post_data){
          $rsv_data[0]['ADJUST_TYPE'] = __('lbl_credit_card');
          $flg = '1';
        }else{
          Session::set_flash('error', __('lbl_error1'));
          Response::redirect($this->htl_name.'/mypage');
        }
      // if ($rsv_data[0]['ORDER_CD'] != '' && isset($rsv_no['change_adjust_flg']) && $rsv_no['change_adjust_flg'] == '1') {
      }
    }else if ($rsv_data[0]['ADJUST_TYPE'] == '2') {
      $rsv_data[0]['ADJUST_TYPE'] = __('lbl_credit_card');
    }

    $rsv = array('rsv_no' => $rsv_no['rsv_no'], 'user_id'=>$rsv_no['user_id'], 'ciTime' => $data['ciTime'], 'change_adjust_flg' => $flg);
    Session::set('RSV_NO', $rsv);

    $this->template->mypage_flg = true;
    $this->template->js = '';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/reserve/edit_confirm',$rsv_data[0]);
  }


  public function action_save()
  {

    if (!$rsv_no = Session::get('RSV_NO')) {
      Session::set_flash('error', __('lbl_error1'));
      Response::redirect($this->htl_name.'/login');
    }



    $data = Input::post();
    $rsv = Model_T_Rsv::forge();


    $user = Model_M_Usr::find_by_pk($rsv_no['user_id']);
    $htl_data = Model_M_Htl::find_by_pk($this->htl_id);
    $r_data = $rsv->get_list(array('t_rsvs.HTL_ID' => $this->htl_id, 't_rsvs.RSV_NO' => $rsv_no['rsv_no']), array(), null, null,null);

    /*クレジットカード決済*/
    if (isset($rsv_no['change_adjust_flg']) && $rsv_no['change_adjust_flg'] == '1') {

      if(!$edit_rsv_info = Session::get('EDIT_RSV_INFO')){
        Session::set_flash('error', __('lbl_error1'));
        Response::redirect($this->htl_name.'/mypage');
      }


      $API_URL   = 'https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      $POST_DATA = $edit_rsv_info['api_post_data'];

      $result = $this->zeusu_api($POST_DATA, $API_URL);
      if ($result[0] == '0') { //決済成功
        $order_code = $result[1];
      }else{
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r('決済に失敗しました。',true) . "\n");
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($POST_DATA,true) . "\n");
        $id = str_replace($user['USR_ID'], '', $POST_DATA['sendid']);

        $cre_info = Model_M_Credit::find_by_pk($id);
        if ($cre_info) {
          $cre_info->delete();
        }
        Session::set_flash('error',$result[1]);
        Session::set('user_data', array('user_id' => $user['USR_ID'], 'user_name' => $user['USR_NAME']));
        Response::redirect(HTTP.'/'.$this->htl_name.'/reserve/credit_setting');
      }

      // 一度で確定するので不要
      /*
      $POST_DATA = array(
        'clientip' => CLIENT_IP,
        'king'     => $r_data[0]['PLN_CHG_TOTAL'],
        'date'     => date('Ymd'),
        'ordd'     => $order_code,
        'autype'   => 'sale',
        );
      $API_URL='https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      $result = $this->zeusu_api($POST_DATA, $API_URL);
      if ($result[0] != '0') {
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r('決済確定に失敗しました。',true) . "\n");
        error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($POST_DATA,true) . "\n");
        Session::set_flash('error',__('lbl_error99')."\n".$result[1]);
        Response::redirect($this->htl_name.'/plan');
      }
      */
      $result = $rsv->update_rsv('ADJUST_TYPE', '2', $this->htl_id, $rsv_no['rsv_no']);
      $result = $rsv->update_rsv('ORDER_CD', $order_code, $this->htl_id, $rsv_no['rsv_no']);

    }


    $rsv_data = $rsv->update_rsv('IN_DATE_TIME', $rsv_no['ciTime'], $this->htl_id, $rsv_no['rsv_no']);
    $rsv_data = $rsv->update_rsv('UP_DATE', date('Y-m-d H:i:s'), $this->htl_id, $rsv_no['rsv_no']);

    $body = $this->make_mail_body($rsv_no['rsv_no'], $htl_data['MAIL_CHG'], $this->htl_id);

    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $user['USR_MAIL'],
      'subject' => '予約変更メール/預約變更信/Booking Modification Mail',
      'body' => $body,
      );

    $result = $this->send_mail($mail);


    $mail['to'] = $htl_data['HTL_MAIL'];
    $mail['subject'] = $htl_data['MAIL_CHG_TITLE'];

    $result = $this->send_mail($mail);



    if ($user['RANK_ID'] == 1) {
      Session::set_flash('error',__('lbl_error29'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/mypage');
    }else{
      Session::set_flash('error',__('lbl_error29'));
      Response::redirect(HTTP.'/'.$this->htl_name);
    }

  }


  public function action_cancel()
  {
    if (!$rsv_no = Session::get('RSV_NO')) {
      Session::set_flash('error',__('lbl_error1'));
      Response::redirect($this->htl_name.'/login');
    }

    $data = Input::post();
    $rsv = Model_T_Rsv::forge();


    $user = Model_M_Usr::find_by_pk($rsv_no['user_id']);


    $htl_data = Model_M_Htl::find_by_pk($this->htl_id);
    $r_data = $rsv->get_list(array('t_rsvs.HTL_ID' => $this->htl_id, 't_rsvs.RSV_NO' => $rsv_no['rsv_no']), array(), null, null,null);

    // if ( ($user['USR_POINTS'] + $r_data[0]['PT_USE'] - $r_data[0]['PT_ADD_BASIC']) >= 0  && $r_data[0]['ADJUST_TYPE'] == '1') {
    //   $user_point = $user['USR_POINTS'] + $r_data[0]['PT_USE'] - $r_data[0]['PT_ADD_BASIC'];
    //   // $add_point = $r_data[0]['PT_USE'];
    //   // $subtract_point = $r_data[0]['PT_ADD_BASIC'];
    //   $user['USR_POINTS'] = $user_point;
    //   $user->save();
    // }else if( ($user['USR_POINTS'] + $r_data[0]['PT_USE'] - $r_data[0]['PT_ADD_BASIC']) >= 0  && $r_data[0]['ADJUST_TYPE'] == '2' ){
    //   $POST_DATA = array(
    //       'clientip' => CLIENT_IP,
    //       'return'   => 'yes',
    //       'ordd'     => $r_data[0]['ORDER_CD'],
    //     );
    //   $API_URL = 'https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
    //   $result = $this->zeusu_api($POST_DATA, $API_URL);

    //   if ($result[0] != '0') {
    //     Session::set_flash('error',__('lbl_error99')."\n".$result[1]);
    //     Response::redirect($this->htl_name.'/mypage');
    //   }
    //   $user_point = $user['USR_POINTS'] + $r_data[0]['PT_USE'] - $r_data[0]['PT_ADD_BASIC'];
    //   // $add_point = $r_data[0]['PT_USE'];
    //   // $subtract_point = $r_data[0]['PT_ADD_BASIC'];
    //   $user['USR_POINTS'] = $user_point;
    //   $user->save();
    // }else{
    //   Session::set_flash('error',__('lbl_error30'));
    //   Response::redirect(HTTP.'/'.$this->htl_name.'/mypage');
    // }

    if ($r_data[0]['ADJUST_TYPE'] == '2') {
      $POST_DATA = array(
          'clientip' => CLIENT_IP,
          'return'   => 'yes',
          'ordd'     => $r_data[0]['ORDER_CD'],
        );
      $API_URL = 'https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      $result = $this->zeusu_api($POST_DATA, $API_URL);

      if ($result[0] != '0') {
        Session::set_flash('error',__('lbl_error99')."\n".$result[1]);
        Response::redirect($this->htl_name.'/mypage');
      }
    }

    if ($r_data[0]['PT_USE'] > 0) {
      $user->USR_POINTS += $r_data[0]['PT_USE'];
      $user->save();
    }



    $rsv_data = $rsv->update_rsv('RSV_STS', '9', $this->htl_id, $rsv_no['rsv_no']);
    $rsv_data = $rsv->update_rsv('CANCEL_DATE', date('Y-m-d H:i:s'), $this->htl_id, $rsv_no['rsv_no']);
    $rsv_data = $rsv->update_rsv('CANCEL_TYPE', '9', $this->htl_id, $rsv_no['rsv_no']);


    $before_word = array(
      "[顧客氏名]",
      "[ホテル名]",
      "[予約番号]",
      "[チェックイン予定日]",
      "[チェックアウト予定日]",
      "[プラン名]",
      "[室数]",
      "[泊数]",
      "[チェックイン]",
      "[宿泊者名]",
      "[料金]",
      "[支払い方法]"
      );
    $after_word   = array(
      $r_data[0]['USR_NAME'],
      $r_data[0]['HTL_NAME'],
      'stm'.$r_data[0]['RSV_NO'],
      date('Y年n月j日', strtotime($r_data[0]['IN_DATE'])),
      date('Y年n月j日', strtotime($r_data[0]['OUT_DATE'])),
      $r_data[0]['PLN_NAME'],
      $r_data[0]['NUM_ROOM'],
      $r_data[0]['NUM_STAY'],
      $r_data[0]['IN_DATE_TIME'],
      $r_data[0]['USR_NAME'],
      number_format($r_data[0]['PLN_CHG_TOTAL']),
      $r_data[0]['ADJUST_TYPE_NAME']
      );


    $body = $this->make_mail_body($rsv_no['rsv_no'], $htl_data['MAIL_CCL'], $this->htl_id);

    if ($r_data[0]['ADJUST_TYPE'] == '2') {
      $body .= __('lbl_zeusu_mail');
    }

    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $user['USR_MAIL'],
      'subject' => '予約キャンセルメール/預約取消信/Booking Cancellation Mail',
      'body' => $body,
      );

    $result = $this->send_mail($mail);


    $mail['to'] = $htl_data['HTL_MAIL'];
    $mail['subject'] = $htl_data['MAIL_CCL_TITLE'];

    $result = $this->send_mail($mail);

    $mail['to'] = 't-miura@creaf-inc.com';
    $result = $this->send_mail($mail);

    if ($htl_data['ART_LINK_FLG'] == '1') {
      $POST_DATA = array(
        'email' => $user['USR_MAIL'],
        'price_total' => (int)$r_data[0]['PLN_CHG_TOTAL'] * -1,
        'cancel_count' => 1,
        'account_key' => $htl_data['ART_ACCOUNT_KEY'],
        'account_secret' => $htl_data['ART_ACCOUNT_SECRET'],
      );
      $this->art_api($POST_DATA, 'customer_upsert');
    }

    if ($user['RANK_ID'] == 1) {
      Session::set_flash('error',__('lbl_error32'));
      Response::redirect(HTTP.'/'.$this->htl_name.'/mypage');
    }else{
      Session::set_flash('error',__('lbl_error32'));
      Response::redirect(HTTP.'/'.$this->htl_name);
    }

  }

  public function stock_list($data)
  {
    $rm = $data['room_num'];


    $format = 'Ymd';
    $datec = DateTime::createFromFormat($format, $data['stay_date']);
    $date =  $datec->format('Y-m-d');
    $start = $date;

    $start = date('Y-m-d', strtotime($start));
    $end = date('Y-m-d', strtotime($start." +".$data['stay_count']." day"));


    $plan_rtype = Model_M_Plan_Rtype::forge();
    $diff = (strtotime($end) - strtotime($start)) / ( 60 * 60 * 24);

    $stock_list = array();
    $flg = '0';
    for ($i=0; $i < $diff ; $i++) {
      $period = date('Y-m-d', strtotime($start . '+' . $i . 'days'));
      $plan_rtype_data = $plan_rtype->get_zaiko_one_day($data['htl_id'], $data['pln_id'], $data['type_id'], $period);
      if ($plan_rtype_data == 0) { return '1'; }
      if ($plan_rtype_data['PLN_USE_FLG'] == '1' && $plan_rtype_data['RM_USE_FLG'] == '1') {
        if ($plan_rtype_data['RPR_STOP_FLG'] == '0' || $plan_rtype_data['RPR_STOP_FLG'] == null) {
          if ($plan_rtype_data['MRR_STOP_FLG'] != '1' || $plan_rtype_data['RPR_STOP_FLG'] == '0') {
            if ($plan_rtype_data['RM_NUM'] + $plan_rtype_data['ZOUGEN_NUM'] - $plan_rtype_data['URIAGE'] >= $rm && $rm >= 1) {
              $flg = '0';
            }else{$flg = '1';}
          }else{$flg = '1';}
        }else{$flg = '1';}
      }else{$flg = '1';}

      if ($flg != '0') {
        return '1';
      }
    }

    if ($flg == '0') {
      return '0';
    }else{
      return '1';
    }
  }

  private function  card_type($card_no)
  {
    // クレジットカード種別
    // キー: カード番号プレフィックス
    // 値: カード種別名称
    $card_type = array(
        '1' => 'UATP',
        '4' => 'VISA',
        '5' => 'MasterCard',
        '34' => 'AMERICAN EXPRESS',
        '37' => 'AMERICAN EXPRESS',
        '35' => 'JCB', // 3528-3589
        '30' => 'Diners Club', // 300-305, 3095
        '36' => 'Diners Club',
        '38' => 'Diners Club',
        '39' => 'Diners Club',
        '62' => '中国銀聯', // 622126-622925, 624-626, 6282-6288
        '6011' => 'Discover Card', // 60110, 60112-60114, 601180-60199,
        '64' => 'Discover Card', // 644-649
        '65' => 'Discover Card', // 65
    );

    $initial = substr($card_no, 0,1);
    if ($initial == '3' || $initial == '6') {
      $initial = substr($card_no, 0,2);
    }

    if (substr($card_no, 0, 4) == '6011') {
      $initial = '6011';
    }

    if (isset($card_type[$initial])) {
      return $card_type[$initial];
    }else{
      return 'その他';
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
      $this->action_index($action);
    }

  }

}
