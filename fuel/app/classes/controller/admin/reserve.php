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
class Controller_Admin_Reserve extends Controller_Common
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

    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    $this->reserve_list($login_id);
  }



  /**
  *
  *ページング機能
  *
  **/
  public function action_page($page)
  {
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    $this->reserve_list($login_id);
  }



  public function action_limit($num)
  {
    $limit_num = $num[0];
    Session::set('limit', $limit_num);
    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url);
  }

  /**
  *
  *
  *
  **/
  private function reserve_list($login_id)
  {
    // $user = Model_M_Co_Login::forge();
    $htl = Model_M_htl::forge();

    $user_data = $htl->get_user($login_id);
    $rsv = Model_T_Rsv::forge();

    $htl = Model_M_htl::forge();
    $htl_data = $htl->get_htl();


    if (!$order = Session::get('reserve_order_by')) {
      $order = array(
        'colname' => 't_rsvs.RSV_NO',
        'value'   => 'DESC',
        );
    }

    $where = array(); $between = array();    
    if ($sql = Session::get('reserve_sql')) {
      $where = $sql['where'];
      $between = $sql['between'];
    }
    $where['m_htls.HTL_ID'] = $user_data['HTL_ID'];

    if (!$limit = Session::get('limit')) {
        $limit = LIMIT_NUM;
    }


    $all_data_count = $rsv->get_count($where, $between);
    $all_data_count = count($all_data_count);


    $config = array(
        'pagination_url' => 'admin/reserve/page',
        'uri_segment'    => 4,
        'num_links'      => 4,
        'per_page'       => $limit,
        'total_items'    => $all_data_count,
        'show_first'     => true,
        'show_last'      => true,
      );

    $pagination = Pagination::forge('mypagenation' ,$config);
    $rsv_data = $rsv->get_list($where, $between, $order, $limit, $pagination->offset);


    $rsv_data_count = count($rsv_data);


    $total_pages = $pagination->total_pages;//総ページ数
    $first_page = 1;//最初のページ
    $last_page = $total_pages;//最後のページ
    $current_page = $pagination->current_page;//現在のページ
    $preview_page = $current_page -1;
    $next_page = $current_page + 1;
    if ($first_page != $last_page) {//複数ページある場合
      if ($current_page > $first_page && $current_page < $last_page) { //最初でも最後のページでもない場合
        $preview_page = $current_page - 1;// 前のページを設定
        $next_page = $current_page + 1;   // 後ろのページを設定
      }elseif ($current_page == $first_page) { //最初のページの場合
        $preview_page = '1';
        $next_page = $current_page + 1;
      }elseif ($current_page == $last_page) {//最後のページの場合
        $preview_page = $current_page - 1;
        $next_page = $current_page;
      }
    }else {
      $preview_page = '1';
      $next_page = '1';
    }

    /* フラグの初期化*/
    $HTL_CB_FLG = '';
    $RSV_NO_CB_FLG  = '';
    $USR_NAME_CB_FLG  = '';
    $PLN_NAME_CB_FLG  = '';
    $ROOM_NAME_CB_FLG  = '';
    $CI_CB_FLG  = '';
    $CO_CB_FLG  = '';
    $RSV_STS_CB_FLG = '';
    $RSV_STS_FLG1 = '';
    $RSV_STS_FLG2 = '';
    $RSV_STS_FLG3 = '';
    $RSV_COME_STS_CB_FLG = '';
    $RSV_COME_STS_FLG1 = '';
    $RSV_COME_STS_FLG2 = '';
    $RSV_COME_STS_FLG3 = '';
    $AD_TYPE_CB_FLG = '';
    $AD_TYPE_RB_FLG1  = '';
    $AD_TYPE_RB_FLG2  = '';
    $AD_TYPE_RB_FLG3  = '';
    $MAIL_CB_FLG  = '';

    $form = Session::get('reserve_form');
    if (isset($form['facilityCB']) && $form['facilityCB'] == 'on') {
        $HTL_CB_FLG = 'checked';
    }

    if(isset($form['reserveNumCB']) && $form['reserveNumCB'] == 'on'){
        $RSV_NO_CB_FLG  = 'checked';
    }

    if(isset($form['reserveNameCB']) && $form['reserveNameCB'] == 'on'){
        $USR_NAME_CB_FLG = 'checked';
    }

    if(isset($form['reservePlanCB']) && $form['reservePlanCB'] == 'on'){
        $PLN_NAME_CB_FLG = 'checked';
    }

    if(isset($form['reserveRoomCB']) && $form['reserveRoomCB'] == 'on'){
        $ROOM_NAME_CB_FLG = 'checked';
    }

    if(isset($form['checkinTimeCB']) && $form['checkinTimeCB'] == 'on'){
        $CI_CB_FLG = 'checked';
    }

    if(isset($form['checkoutTimeCB']) && $form['checkoutTimeCB'] == 'on'){
        $CO_CB_FLG = 'checked';
    }

    if(isset($form['reserveStatusRB']) && isset($form['reserveStatusCB']) && $form['reserveStatusCB'] == 'on'){
        $RSV_STS_CB_FLG = 'checked';
        if ($form['reserveStatusRB'] == 0) {
          $RSV_STS_FLG1 = 'checked';
        }else if ($form['reserveStatusRB'] == 1) {
          $RSV_STS_FLG2 = 'checked';
        }else if ($form['reserveStatusRB'] == 9) {
          $RSV_STS_FLG3 = 'checked';
        }
    }

    if(isset($form['reserveComeStatusRB']) && isset($form['reserveComeStatusCB']) && $form['reserveComeStatusCB'] == 'on'){
        $RSV_COME_STS_CB_FLG = 'checked';
        if ($form['reserveComeStatusRB'] == 0) {
          $RSV_COME_STS_FLG1 = 'checked';
        }else if ($form['reserveComeStatusRB'] == 1) {
          $RSV_COME_STS_FLG2 = 'checked';
        }else if ($form['reserveComeStatusRB'] == 9) {
          $RSV_COME_STS_FLG3 = 'checked';
        }
    }

    if(isset($form['reservePaymentRB']) && isset($form['reservePaymentCB']) && $form['reservePaymentCB'] == 'on'){
        $AD_TYPE_CB_FLG = 'checked';
        if ($form['reservePaymentRB'] == 1) {
          $AD_TYPE_RB_FLG1 = 'checked';
        }else if ($form['reservePaymentRB'] == 2) {
          $AD_TYPE_RB_FLG2 = 'checked';
        }else if ($form['reservePaymentRB'] == 0) {
          $AD_TYPE_RB_FLG3 = 'checked';
        }
    }

    if(isset($form['reserveMailCB']) && $form['reserveMailCB'] == 'on'){
        $MAIL_CB_FLG = 'checked';
    }

    $data = array(
      'title'               => TITLE_RESERVATION,
      'reserve'             => $rsv_data,
      'rsv_data_count'      => $rsv_data_count + $pagination->offset,
      'start_count'         => $pagination->offset + 1,
      'all_data_count'      => $all_data_count,
      'first_page'          => $first_page,
      'last_page'           => $last_page,
      'preview_page'        => $preview_page,
      'next_page'           => $next_page,
      'current_page'        => $current_page,
      'htls'                => $htl_data, 
      'form'                => Session::get('reserve_form'),
      'HTL_CB_FLG'          => $HTL_CB_FLG,
      'RSV_NO_CB_FLG'       => $RSV_NO_CB_FLG,
      'USR_NAME_CB_FLG'     => $USR_NAME_CB_FLG,
      'PLN_NAME_CB_FLG'     => $PLN_NAME_CB_FLG,
      'ROOM_NAME_CB_FLG'    => $ROOM_NAME_CB_FLG,
      'CI_CB_FLG'           => $CI_CB_FLG,
      'CO_CB_FLG'           => $CO_CB_FLG,
      'RSV_STS_CB_FLG'      => $RSV_STS_CB_FLG,
      'RSV_STS_FLG1'        => $RSV_STS_FLG1,
      'RSV_STS_FLG2'        => $RSV_STS_FLG2,
      'RSV_STS_FLG3'        => $RSV_STS_FLG3,
      'RSV_COME_STS_CB_FLG' => $RSV_COME_STS_CB_FLG,
      'RSV_COME_STS_FLG1'   => $RSV_COME_STS_FLG1,
      'RSV_COME_STS_FLG2'   => $RSV_COME_STS_FLG2,
      'RSV_COME_STS_FLG3'   => $RSV_COME_STS_FLG3,
      'AD_TYPE_CB_FLG'      => $AD_TYPE_CB_FLG,
      'AD_TYPE_RB_FLG1'     => $AD_TYPE_RB_FLG1,
      'AD_TYPE_RB_FLG2'     => $AD_TYPE_RB_FLG2,
      'AD_TYPE_RB_FLG3'     => $AD_TYPE_RB_FLG3,
      'MAIL_CB_FLG'         => $MAIL_CB_FLG,
      'limit_num'           => $limit,
      'error'               => Session::get_flash('error'),
      );
   
    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = 'plan/plan.js';
    $this->template->title = TITLE_RESERVATION;
    $this->template->content = View_Smarty::forge('admin/reserve/list', $data);
  }


  /**
  *
  *チェックした予約情報を操作
  *
  **/
  public function action_change_sts()
  {
    $data = Input::post();

    $param = array();
    $rsv = Model_T_Rsv::forge();

    if (!isset($data['check'])) {
      Session::set_flash('error', 'チェックがされていません。');
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);
    }

    if ($data['action'] == '来店済') {
      $flg = '1';
    }else if ($data['action'] == 'NS') {
      $flg = '9';
    }else{
      Session::set_flash('error', 'エラー');
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url);      
    }

    foreach ($data['check'] as $key => $value) {
      $ids = explode(EXPLODE, $value);
      $rsv_data = Model_T_Rsv::find_one_by(array('HTL_ID' => $ids[0], 'RSV_NO' => $ids[1]));
      if ($flg == '1') {
        $user_data = Model_M_Usr::find_by_pk($rsv_data['USR_ID']);

        if (intval($user_data['USR_POINTS']) < 5) {
          $point = $user_data['USR_POINTS'] + $rsv_data['PT_ADD_BASIC'];
          $user_data->USR_POINTS = $point;
          $user_data->save();
        }
      }

      $rsv->update_rsv('COME_FLG', $flg, $ids[0], $ids[1]);
    }


    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url);

  }



  public function action_detail($id)
  {
    $login_id = Session::get('id');
    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    // $user = Model_M_Co_Login::forge();
    $htl = Model_M_htl::forge();

    $user_data = $htl->get_user($login_id);
    // $user_data = $user->get_user($login_id);

    $ids = explode(EXPLODE, $id[0]);
    $htl_id = $ids[0];
    $rsv_no = $ids[1];

    $rsv = Model_T_Rsv::forge();
    $rsv_data = $rsv->get_rsv_one($htl_id, $rsv_no);

    $format = 'Y-m-d H:i:s';
    $date = DateTime::createFromFormat($format, $rsv_data[0]['RSV_DATE']);
    $rsv_data[0]['rsv_date'] = $date->format('Y年m月d日 H時i分s秒');

    $date = DateTime::createFromFormat($format, $rsv_data[0]['IN_DATE']);
    $rsv_data[0]['in_date'] = $date->format('Y年m月d日');
    
    $date = DateTime::createFromFormat($format, $rsv_data[0]['OUT_DATE']);
    $rsv_data[0]['out_date'] = $date->format('Y年m月d日');

    $rsv_detail = Model_T_Rsv_Detail::forge();
    $rsv_detail_data = $rsv_detail->get_rsv_detail($htl_id, $rsv_no);

    $payment = array();
    $seq_data = array();

    foreach ($rsv_detail_data as $key => $value) {
      if (isset($payment[$value['STAYDATE']])) {
        $payment[$value['STAYDATE']]['RM_NUM'] += 1;
        $payment[$value['STAYDATE']]['PLN_NUM_MAN'] += $value['PLN_NUM_MAN'];
        $payment[$value['STAYDATE']]['PLN_NUM_WOMAN'] += $value['PLN_NUM_WOMAN'];
      }else{
        $payment[$value['STAYDATE']]['RM_NUM'] = 1;
        $payment[$value['STAYDATE']]['PLN_NUM_MAN'] = $value['PLN_NUM_MAN'];
        $payment[$value['STAYDATE']]['PLN_NUM_WOMAN'] = $value['PLN_NUM_WOMAN'];
        $payment[$value['STAYDATE']]['TYPE_NAME'] = $value['TYPE_NAME'];
        $payment[$value['STAYDATE']]['PAYMENT'] = $value['PLN_CHG'];
      }


      if (!isset($seq_data[$value['SEQ_ROOM']])) {
        $seq_data[] = $value;
      }
    }

    if (date('Y-m-d', strtotime($rsv_data[0]['IN_DATE'])) <= date('Y-m-d') && $rsv_data[0]['RSV_STS'] == '1') {
      $changeable = true;
    }else{
      $changeable = false;
    }


    $data = array(
        'rsv' => $rsv_data[0],
        'rsv_detail' => $seq_data,
        'payment' => $payment,
        'changeable' => $changeable,
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = 'reserve/reserve.js';
    $this->template->title = TITLE_RESERVATION;
    $this->template->content = View_Smarty::forge('admin/reserve/detail', $data);
  }

  public function action_search()
  {
    $data = Input::post();
    $where = array();
    $between = array();
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    

    // if (isset($data['facilityCB']) && $data['facilityCB'] == 'on') {
    //   if (isset($data['facility']) && $data['facility'] != '') {
    //     $where['m_htls.HTL_NAME'] = $data['facility'];
    //   }else{
    //     Session::set('reserve_form', $data);
    //     Session::set_flash('error','error');
    //     Response::redirect('admin/reserve');
    //   }
    // }

    if(isset($data['reserveNumCB']) && $data['reserveNumCB'] == 'on'){
      if (isset($data['reserveNum']) && $data['reserveNum'] != '') {
        $where['t_rsvs.RSV_NO'] = $data['reserveNum'];        
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','予約番号が空です');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reserveNameCB']) && $data['reserveNameCB'] == 'on'){
      if (isset($data['reserveName']) && $data['reserveName'] != '') {
        $where['m_usrs.USR_NAME'] = $data['reserveName'];
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','顧客名が空です。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reservePlanCB']) && $data['reservePlanCB'] == 'on'){
      if (isset($data['reservePlan']) && $data['reservePlan'] != '') {
        $where['m_plans.PLN_NAME'] = $data['reservePlan'];
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','プラン名が空です。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reserveRoomCB']) && $data['reserveRoomCB'] == 'on'){
      if (isset($data['reserveRoom']) && $data['reserveRoom'] != '') {
        $where['t_rsv_details.TYPE_NAME'] = $data['reserveRoom'];
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','部屋タイプが空です。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['checkinTimeCB']) && $data['checkinTimeCB'] == 'on'){
      if (isset($data['checkinTime1']) && $data['checkinTime1'] != '' && isset($data['checkinTime2']) && $data['checkinTime2'] != '') {
        $between['t_rsvs.IN_DATE'][0] = date('Y-m-d', strtotime($data['checkinTime1']));
        $between['t_rsvs.IN_DATE'][1] = date('Y-m-d', strtotime($data['checkinTime2']));
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','チェックインが空です。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['checkoutTimeCB']) && $data['checkoutTimeCB'] == 'on'){
      if (isset($data['checkoutTime1']) && $data['checkoutTime1'] != '' && isset($data['checkoutTime2']) && $data['checkoutTime2'] != '') {
        $between['t_rsvs.OUT_DATE'][0] = date('Y-m-d', strtotime($data['checkoutTime1']));
        $between['t_rsvs.OUT_DATE'][1] = date('Y-m-d', strtotime($data['checkoutTime2']));
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','チェックアウトが空です。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reserveStatusCB']) && $data['reserveStatusCB'] == 'on'){
      if (isset($data['reserveStatusRB']) && $data['reserveStatusRB'] != '') {
        $where['t_rsvs.RSV_STS'] = $data['reserveStatusRB'];
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','状況を選択してください。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reserveComeStatusCB']) && $data['reserveComeStatusCB'] == 'on'){
      if (isset($data['reserveComeStatusRB']) && $data['reserveComeStatusRB'] != '') {
        $where['t_rsvs.COME_FLG'] = $data['reserveComeStatusRB'];
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','来店状況を選択してください。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reservePaymentCB']) && $data['reservePaymentCB'] == 'on'){
      if (isset($data['reservePaymentRB']) && $data['reservePaymentRB'] != '') {
        if ($data['reservePaymentRB'] == '0') {

        }else{
          $where['t_rsvs.ADJUST_TYPE'] = $data['reservePaymentRB'];
        }
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','支払方法を選択してください。');
        Response::redirect('admin/reserve');
      }
    }

    if(isset($data['reserveMailCB']) && $data['reserveMailCB'] == 'on'){
      if (isset($data['reserveMail']) && $data['reserveMail'] != '') {
        $where['m_usrs.USR_MAIL'] = $data['reserveMail'];
      }else{
        Session::set('reserve_form', $data);
        Session::set_flash('error','メールアドレスが空です。');
        Response::redirect('admin/reserve');
      }
    }

    Session::set('reserve_form', $data);
    Session::set('reserve_sql', array('where' => $where, 'between' => $between));
    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url);

  }


  /**
  *
  *どのカラムをソートするのかをSessionに保存
  *
  **/
  public function action_sort($option)
  {
    $url = $_SERVER['HTTP_REFERER'];

    if ($option[0] == '0') {
      $sort_type = 't_rsvs.COME_FLG';
    }elseif ($option[0] == '1') {
      $sort_type = 'm_htls.HTL_NAME';
    }elseif ($option[0] == '2') {
      $sort_type = 't_rsvs.RSV_NO';
    }elseif ($option[0] == '3') {
      $sort_type = 'm_usrs.USR_NAME';
    }elseif ($option[0] == '4') {
      $sort_type = 't_rsvs.IN_DATE';
    }elseif ($option[0] == '5') {
      $sort_type = 't_rsvs.OUT_DATE';
    }elseif ($option[0] == '6') {
      $sort_type = 't_rsvs.NUM_STAY';
    }elseif ($option[0] == '7') {
      $sort_type = 't_rsvs.RSV_STS';
    }elseif ($option[0] == '8') {
      $sort_type = 'm_plans.PLN_NAME';
    }elseif ($option[0] == '9') {
      $sort_type = 't_rsvs.ADJUST_TYPE';
    }elseif ($option[0] == '10') {
      $sort_type = 't_rsvs.PLN_CHG_TOTAL';
    }elseif ($option[0] == '11') {
      $sort_type = 't_rsvs.NUM_ROOM';
    }elseif ($option[0] == '12') {
      $sort_type = 't_rsv_details.TYPE_NAME';
    }elseif ($option[0] == '13') {
      $sort_type = 't_rsvs.UP_DATE';
    }else{
      Response::redirect($url);
    }
    

    if ($option[1] == 1) {
      $sort_option = 'ASC';
    }elseif ($option[1] == 2) {
      $sort_option = 'DESC';
    }else{
       Response::redirect($url);  
    }
    Session::set('reserve_order_by', array('colname' => $sort_type, 'value' => $sort_option));
    Response::redirect($url);
  }





  public function action_cancel($id)
  {
    $ids = explode(EXPLODE, $id[0]);
    $htl_id = $ids[0];
    $rsv_no = $ids[1];

    $rsv_data = Model_T_Rsv::find_one_by(array('HTL_ID' => $htl_id, 'RSV_NO' => $rsv_no));
    $user = Model_M_Usr::find_by_pk($rsv_data['USR_ID']);
    $htl_data = Model_M_htl::find_by_pk($htl_id);

    $adjust_type_name = 'フロント決済';
    if ($rsv_data['ADJUST_TYPE'] == '1') {
      // $user_point = $user['USR_POINTS'] + $rsv_data['PT_USE'] - $rsv_data['PT_ADD_BASIC'];

      // $user['USR_POINTS'] = $user_point;
      // $user->save();
    }else if($rsv_data['ADJUST_TYPE'] == '2' ){
      $adjust_type_name = 'クレジットカード決済';
      $POST_DATA = array(
          'clientip' => CLIENT_IP,
          'return'   => 'yes',
          'ordd'     => $rsv_data['ORDER_CD'],
        );
      $API_URL = 'https://linkpt.cardservice.co.jp/cgi-bin/secure.cgi';
      $result = $this->zeusu_api($POST_DATA, $API_URL);

      if ($result[0] != '0') {
        Session::set_flash('error',__('lbl_error99')."\n".$result[1]);
        Response::redirect('admin/reserve');
      }
      // $user_point = $user['USR_POINTS'] + $rsv_data['PT_USE'] - $rsv_data['PT_ADD_BASIC'];

      // $user['USR_POINTS'] = $user_point;
      // $user->save();
    }else{
      //error
    }

    if ($rsv_data['PT_USE'] > 0) {
      $user->USR_POINTS += $rsv_data['PT_USE'];
      $user->save();
    }

    $rsv = Model_T_Rsv::forge();
    $rsv->update_rsv('RSV_STS', '9', $htl_id, $rsv_no);
    $rsv->update_rsv('CANCEL_DATE', date('Y-m-d H:i:s'), $htl_id, $rsv_no);
    $rsv->update_rsv('CANCEL_TYPE', '9', $htl_id, $rsv_no);
    $rsv->update_rsv('CANCEL_REASON', '管理画面によるキャンセル', $htl_id, $rsv_no);


    // $before_word = array(
    //   "[顧客氏名]", 
    //   "[ホテル名]", 
    //   "[予約番号]", 
    //   "[チェックイン予定日]", 
    //   "[チェックアウト予定日]", 
    //   "[プラン名]", 
    //   "[室数]", 
    //   "[泊数]", 
    //   "[チェックイン]", 
    //   "[宿泊者名]",
    //   "[料金]", 
    //   "[支払い方法]"
    //   );
    // $after_word   = array(
    //   $user['USR_NAME'], 
    //   $htl_data['HTL_NAME'], 
    //   $rsv_data['RSV_NO'], 
    //   date('Y年n月j日', strtotime($rsv_data['IN_DATE'])),
    //   date('Y年n月j日', strtotime($rsv_data['OUT_DATE'])),
    //   $rsv_data['PLN_NAME'], 
    //   $rsv_data['NUM_ROOM'], 
    //   $rsv_data['NUM_STAY'], 
    //   $rsv_data['IN_DATE_TIME'], 
    //   $user['USR_NAME'], 
    //   number_format($rsv_data['PLN_CHG_TOTAL']), 
    //   $adjust_type_name
    //   );


    // $after_txt = str_replace($before_word, $after_word, $htl_data['MAIL_CCL']);

    $body = $this->make_mail_body($rsv_data['RSV_NO'], $htl_data['MAIL_ADCCL'] ,$htl_id);


    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $user['USR_MAIL'],
      'subject' => '予約キャンセルメール',
      'body' => $body,
      );

    $result = $this->send_mail($mail);


    $mail['to'] = $htl_data['HTL_MAIL'];
    $mail['subject'] = $htl_data['MAIL_ADCCL_TITLE'];
    
    $result = $this->send_mail($mail);

    $mail['to'] = 't-miura@creaf-inc.com';
    $result = $this->send_mail($mail);

    Session::set_flash('error','予約をキャンセルしました。');
    Response::redirect('admin/reserve');
  }


  public function action_chgcome($data)
  {
    $ids = explode(EXPLODE, $data[0]);
    $htl_id = $ids[0];
    $rsv_no = $ids[1];

    if ($ids[2] === '1') {
      $come_flg = '0';
    }else if ($ids[2] === '2') {
      $come_flg = '1';
    }else if ($ids[2] === '3') {
      $come_flg = '9';
    }else{
      Session::set_flash('error', 'エラーが発生しました。');
      Response::redirect('admin/reserve');
    }

    $rsv_data = Model_T_Rsv::find_one_by(array('HTL_ID' => $htl_id, 'RSV_NO' => $rsv_no));
    $user_data = Model_M_Usr::find_by_pk($rsv_data['USR_ID']);
    if (!$rsv_data) {
      Session::set_flash('error', 'エラーが発生しました。');
      Response::redirect('admin/reserve');
    }

    if ($rsv_data['COME_FLG'] == '0') {
      if ($come_flg == '0') {
        $flg = 'error';
      }else if ($come_flg == '1') {
        $flg = 'add';
      }else if ($come_flg == '9') {
        $flg = '';
      }
    }else if ($rsv_data['COME_FLG'] == '1') {
      if ($come_flg == '0') {
        $flg = 'reduce';
      }else if ($come_flg == '1') {
        $flg = 'error';
      }else if ($come_flg == '9') {
        $flg = 'reduce';
      }
    }else if ($rsv_data['COME_FLG'] == '9') {
      if ($come_flg == '0') {
        $flg = '';
      }else if ($come_flg == '1') {
        $flg = 'add';
      }else if ($come_flg == '9') {
        $flg = 'error';
      }
    }else{
      Session::set_flash('error', 'エラーが発生しました。');
      Response::redirect('admin/reserve');
    }

    if ($flg == 'error') {
      Session::set_flash('error', 'エラーが発生しました。');
      Response::redirect('admin/reserve');
    }

    if ($flg == 'add' && intval($user_data['USR_POINTS']) < 5) {
      $point = $user_data['USR_POINTS'] + $rsv_data['PT_ADD_BASIC'];
      $user_data->USR_POINTS = $point;
      $user_data->save();
    }

    if ($flg == 'reduce' && intval($user_data['USR_POINTS']) >= 1) {
      $point = $user_data['USR_POINTS'] - $rsv_data['PT_ADD_BASIC'];
      $user_data->USR_POINTS = $point;
      $user_data->save();
    }

    $rsv = Model_T_Rsv::forge();
    $rsv->update_rsv('COME_FLG', $come_flg, $ids[0], $ids[1]);

    Session::set_flash('error', '更新しました。');
    Response::redirect('admin/reserve');
  }



  public function action_csv()
  {
    $login_id = Session::get('id');
    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();

    $user_data = $htl->get_user($login_id);
    $data = array(
      'error' => Session::get_flash('error'),
      'htl_id' => $user_data['HTL_ID'],
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = 'reserve/reserve.js';
    $this->template->title = TITLE_CSV;
    $this->template->content = View_Smarty::forge('admin/reserve/csv', $data);
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
