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
class Controller_Front_Secret extends Controller_Common
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
  public function action_index($id)
  {

    $ids = explode(EXPLODE, $id);
    if (count($ids) != 2) {
      throw new HttpNotFoundException;
    }

    list($plan_id, $secret_id) = $ids;

    $htl_id = $this->htl_id;

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_one($htl_id, $plan_id);

    $secret = Model_M_Secret::forge();
    $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);

    if (Input::post('password')) {
      if ( ! $secret_data['PLN_USE_FLG']) {
        $message = 'こちらのプランは、現在ご利用になれません。';
      } else {
        if (Input::post('password') == $secret_data['PLN_PASS']) {
          Session::set('secret_plan', array(
            'htl_id' => $htl_id,
            'plan_id' => $plan_id,
            'secret_id' => $secret_id,
          ));
          Response::redirect($this->htl_name.'/secret/list/'.$id);
        } else {
          $message = 'パスワードが間違っています。URLとパスワードをご確認ください。';
        }
      }
    } else {
      $message = '';
    }

    $data = array(
      'plan' => $plan_data,
      'secret' => $secret_data,
      'message' => $message,
    );
    $this->template->js = '';
    $this->template->title = 'シークレットプラン　ログイン';
    $this->template->content = View::forge('front/plan/secret_login', $data);
  }


  /**
  *
  *ページング機能
  *
  **/
  public function action_page($page)
  {
    if (! $option = Session::get('plan_search_option')) {
      $option = array(
        'room' => '1',
        'otona' => '1',
        'stayCount' => '1',
        'price_lower' => '1',
        'price_upper' => '100000000',
        'ciDate' => 'on',
        'gender' => '1',
        'page' => '1',
        // 'sort' => '2',
        // 'sort_option' => 'ORDER BY mp.DISP_START DESC',
        );
    }else{
      $option['page'] = $page[0];
    }

    $this->plan_list($option);
  }

  public function action_sort()
  {
    $sort = Input::get('sort');
    if ($sort == '1') {
      $sort_option = " ORDER BY PAYMENT ASC";
    }else if ($sort == '2') {
      $sort_option = " ORDER BY PAYMENT DESC";
    }else if ($sort == '3') {
      $sort_option = " ORDER BY mp.SORT_NUM ASC";
    }else{
      $sort = '1';
      $sort_option = " ORDER BY PAYMENT ASC";
    }

    Session::set('sort_front_plan', array(
        'id' => $sort,
        'sql' => $sort_option,
      ));

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url);
  }


  public function action_list($id='')
  {
    $this->delete_sessions(); // いまはなにもしてない
    Session::delete('detail_date');

    // secret用
    if ( ! $ids = Session::get('secret_plan')) {
      if ($id) {
        Response::redirect($this->htl_name.'/secret/'.$id);
      } else {
        throw new HttpNotFoundException;
      }
    }

    $data = Input::post();
    if (count($data) >0) {
      Session::set('plan_search_option',$data);
    }else{
      $data = Session::get('plan_search_option');
    }

    if (!isset($data['room'])) {
        $data['room'] = '1';
    }
    if (!isset($data['otona'])) {
        $data['otona'] = '1';
    }
    if (!isset($data['stayCount'])) {
        $data['stayCount'] = '1';
    }
    if (!isset($data['price_lower'])) {
        $data['price_lower'] = '1';
    }
    if (!isset($data['price_upper'])) {
        $data['price_upper'] = '100000000';
    }
    if (!isset($data['ciDate'])) {
        $data['ciDate'] = 'on';
    }
    if (!isset($data['gender'])) {
        $data['gender'] = '1';
    }
    $data['page'] = 1;

    $get  = Input::get('category_id');
    if ($get) {
      $data['category_id'] = $get;
    }
    $this->plan_list($data);
  }




  public function plan_list($data)
  {

    $date = date('Y-m-d');
    $date2 = date("Y-m-d", strtotime($date." +1 month"));

    $flg_list = array(
        'man' => '',
        'woman' => '',
        'date' => '',
        'stayCount' => '',
        'otona' => '',
        'dateVal' => '',
        'room' => '',
        'price_lower' => '',
        'price_upper' => '',
      );

    // $data = Input::post();
    if (!isset($data['gender'])) {
      $data['gender'] = 0;
    }else{
      if ($data['gender'] == 1) {
        $flg_list['man'] = 'checked'; 
      }else if ($data['gender'] == 2) {
        $flg_list['woman'] = 'checked';
      }
    }

    $flg_list['stayCount']   = $data['stayCount'];
    $flg_list['room']        = $data['room'];
    $flg_list['otona']       = $data['otona'];
    $flg_list['price_lower'] = $data['price_lower'];
    $flg_list['price_upper'] = $data['price_upper'];

    if ($data['ciDate'] == 'on') {
        $date = date('Y-m-d');
        $date2 = date("Y-m-d", strtotime("+1 month"));
        $flg_list['date'] = 'checked';
        $flg = 0;
        $flg_list['staydate'] ='';
    }else{
      if ($data['ciDate'] == '') {
        $data['ciDate'] = date(__('date_format'));
      }
      $flg = 1;
      $flg_list['dateVal'] = $data['ciDate'];
      if (__('use_lang') == 'ja') {
        $format = 'Y年m月d日';    
      }else{
        $format = 'Y/m/d';    
      }
      $datec = DateTime::createFromFormat($format, $data['ciDate']);
      $date =  $datec->format('Y-m-d');
      $date2 = $date;

      $flg_list['staydate'] = $datec->format('Ymd');
    } 

    $category_id = null;
    if (isset($data['category_id']) && $data['category_id'] != '' ) {
      $category_id = $data['category_id'];
    }

    $htl_id = $this->htl_id;

    // secret用
    $tmp = Session::get('secret_plan');
    $plan_id = $tmp['plan_id'];
    $secret_id = $tmp['secret_id'];
    $secret = Model_M_Secret::forge();
    $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);


    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_frontlist($htl_id,$data['otona'],$date,$date2, $data['gender'], $data['stayCount'], $data['room'], $flg, null, $this->language, $data['page'], $category_id);

    foreach ($plan_data as $plan) {
      if ($plan['PLN_ID'] == $plan_id) {
        $plan_data = array($plan);
        break;
      }
    }

    if (count($plan_data) != 1) {
      $plan_data = array();
    }


    $plan_data_count = count($plan_data);

    $category = Model_M_Category::forge();
    $category_data = $category->get_using_category($this->htl_id, $this->language);


    // secret用
    foreach ($plan_data as $key => $value) {
      foreach ($value['RTYPES'] as $k => $val) {
        $plan_data[$key]['RTYPES'][$k]['GENERAL_PAYMENT'] = $val['PAYMENT'];
        $plan_data[$key]['RTYPES'][$k]['PAYMENT'] -= round($val['PAYMENT'] * $secret_data['PLN_RATE'] / 100, 0, PHP_ROUND_HALF_EVEN);
      }
    }

    foreach ($plan_data as $key => $value) {
      foreach ($value['RTYPES'] as $k => $val) {
        if ($data['price_lower'] > $val['PAYMENT'] || $data['price_upper'] < $val['PAYMENT'] ) {
          
          unset($plan_data[$key]['RTYPES'][$k]);
        }else{
          if (isset($val['TOTAL_PAY'])) {
            $plan_data[$key]['RTYPES'][$k]['SUM'] = $val['TOTAL_PAY'] * $data['otona'] * $data['room'];
          }else{
            $plan_data[$key]['RTYPES'][$k]['SUM'] = $val['PAYMENT'] * $data['otona'] * $data['stayCount']; //  日付未定の場合は料金をおおよそで出力する。
          }
          
        }
      }
      if (count($plan_data[$key]['RTYPES']) == 0) {
          unset($plan_data[$key]);
      }
    }



  
    foreach ($plan_data as $key => $value) {
      foreach ($value['RTYPES'] as $k => $val) {
        if (file_exists(IMG_FILE_PATH.'rtype_image/rtypeImgHtlID_'.$value['HTL_ID'].'TypeID_'.$val['TYPE_ID'].'_1.png')) {
          $plan_data[$key]['RTYPES'][$k]['IMG'] = 'rtype_image/rtypeImgHtlID_'.$value['HTL_ID'].'TypeID_'.$val['TYPE_ID'].'_1.png';
        }else{
          $plan_data[$key]['RTYPES'][$k]['IMG'] = 'front/noimage.png';
        }
      }
      if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$value['HTL_ID'].'PlnID_'.$value['PLN_ID'].'_1.png')) {
        $plan_data[$key]['IMGURL1'] = 'pln_image/plnImgHtlID_'.$value['HTL_ID'].'PlnID_'.$value['PLN_ID'].'_1.png';
      }else{
        $plan_data[$key]['IMGURL1'] = 'front/noimage.png';
      }

      if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$value['HTL_ID'].'PlnID_'.$value['PLN_ID'].'_2.png')) {
        $plan_data[$key]['IMGURL2'] = 'pln_image/plnImgHtlID_'.$value['HTL_ID'].'PlnID_'.$value['PLN_ID'].'_2.png';
      }else{
        $plan_data[$key]['IMGURL2'] = 'front/noimage.png';
      }

      if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$value['HTL_ID'].'PlnID_'.$value['PLN_ID'].'_3.png')) {
        $plan_data[$key]['IMGURL3'] = 'pln_image/plnImgHtlID_'.$value['HTL_ID'].'PlnID_'.$value['PLN_ID'].'_3.png';
      }else{
        $plan_data[$key]['IMGURL3'] = 'front/noimage.png';
      }



      $plan_data[$key]['CATEGORYS'] = array();
      foreach ($category_data as $k => $val) {
        if ($value['CATEGORY_ID']  == $val['CATEGORY_ID'] ||
            $value['CATEGORY2_ID'] == $val['CATEGORY_ID'] ||
            $value['CATEGORY3_ID'] == $val['CATEGORY_ID'] || 
            $value['CATEGORY4_ID'] == $val['CATEGORY_ID'] ||
            $value['CATEGORY5_ID'] == $val['CATEGORY_ID'] ||
            $value['CATEGORY6_ID'] == $val['CATEGORY_ID'] ||
            $value['CATEGORY7_ID'] == $val['CATEGORY_ID'] ||
            $value['CATEGORY8_ID'] == $val['CATEGORY_ID']) {
          $plan_data[$key]['CATEGORYS'][] = $val['CATEGORY_NAME'];
        }
      }

    }

    if (!$user_data = Session::get('user_data')) {
      // Response::redirect(URL_LOGIN);
      $user_data = array('user_name' => __('lbl_guest'), );
    }

    
    if (!$sort = Session::get('sort_front_plan')) {
      $sort['id'] = '1';
    }

    if ($sort['id'] != '3' ) {
      foreach ($plan_data as $key => $plan) {
        $pay_sort = array();
        foreach ($plan['RTYPES'] as $k => $rtype) {
          $pay_sort[] = $rtype['PAYMENT']; 
        }
        if ($sort['id'] == '1' ) {
          $plan_data[$key]['PAYMENT'] = min($pay_sort);
        }else{
          $plan_data[$key]['PAYMENT'] = max($pay_sort);
        }
        $sort_array[$key] = $plan_data[$key]['PAYMENT'];
      }
      if (count($plan_data) > 0) {    
        if ($sort['id'] == '1') {
          array_multisort($sort_array, SORT_ASC, $plan_data);
        }elseif ($sort['id'] == '2') {
          array_multisort($sort_array, SORT_DESC, $plan_data);
        }
      }
    }

    $plan_data_c = array_chunk($plan_data, 10);


    $current_page = $data['page'] - 1;
    if ($current_page == 0) {
      $preview_page = 0;
    }else{
      $preview_page  = $current_page -1;
    }

    if (count($plan_data_c) == 1) {
      $next_page = 0;
    }else if(count($plan_data_c) == $current_page + 1){
      $next_page = $current_page ;
    }else{
      $next_page = $current_page +1;
    }


    if (!isset($plan_data_c[$current_page])) {
      $plan_data_c[$current_page] = null;
      // Response::redirect(URL_PLNLIST);
    }



    if ($this->htl_name == '') {
      $url = '';
    }else{
      $url = $this->htl_name.'/';
    }

    $data = array(
      'name' => $user_data['user_name'],
      'plans' => $plan_data_c[$current_page],
      'secret' => $secret_data,
      'first_page'      => '1',
      'last_page'       => count($plan_data_c),
      'preview_page'    => $preview_page +1,
      'next_page'       => $next_page +1,
      'current_page'    => $current_page +1,
      'num'             => count($plan_data),
      'checkflg'        => $flg_list,
      'stay_flg'        => array($flg_list['stayCount']   => '1'),
      'otona_flg'       => array($flg_list['otona']       => '1'),
      'room_flg'        => array($flg_list['room']        => '1'),
      'lower_flg'       => array($flg_list['price_lower'] => '1'),
      'upper_flg'       => array($flg_list['price_upper'] => '1'),
      'photourl'        => 'front/img_room_dummy01.jpg',
      'flg'             => $sort['id'],
      'login_url'       => HTTP.'/'.$url.'login',
      'mypage_url'      => HTTP.'/'.$url.'mypage',
      'error'           => Session::get_flash('error'),
      'url'             => $url,
      );
    // $this->template->name = $user_data['USR_NAME'];
    $this->template->js = 'front/list.js';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge('front/plan/secret_list', $data);
  }





  /**
  *
  *
  *
  **/
  public function action_detail($id)
  {
    if (!$user_data = Session::get('user_data')) {
      // Response::redirect(URL_LOGIN);
      $user_data = array('user_name' => __('lbl_guest'), );
    }


    $ids = explode(EXPLODE, $id[0]);
    if (count($ids) != 4 && count($ids) != 6 && count($ids) != 7) {
      Response::redirect($this->htl_name.'/plan');
    }


    /*　現時点でプラン詳細から明細を出す機能がいらなくなったので、万が一のため引数が７つ送られてきた場合、プラン一覧画面までリダイレクトをかける　*/
    if (count($ids) == 7) {
      Response::redirect($this->htl_name.'/plan');    
    }

    $htl_id = $ids[0];
    $pln_id = $ids[1];
    $type_id = $ids[2];
    
    if (isset($ids[6])) {
      $search_date = $ids[6];
    }else{
      if (Session::get('plan_search_option.ciDate') && Session::get('plan_search_option.ciDate') != 'on') {
        $search_date = date('Y-m-d', strtotime(str_replace(array('年','月','日'), array('-','-',''), Session::get('plan_search_option.ciDate'))));
      } else {
        $search_date = date('Y-m-d');
      }
    }
    $plan_rtype = Model_M_Plan_Rtype::forge();
    $plan_rtype_data = $plan_rtype->get_plan_rtype($htl_id, $pln_id, $type_id, $search_date, $this->language);

    if ($plan_rtype_data == 0) {
      Session::set_flash('error',__('lbl_error48'));
      Response::redirect($this->htl_name.'/plan');
    }


    if ($plan_rtype_data['PLN_MIN'] > $ids[3] || $plan_rtype_data['PLN_MAX'] < $ids[3]) {
        Session::set_flash('error', __('lbl_error3').' ec6');
        Response::redirect($this->htl_name.'/plan');    
    }


    $param = array(
      'HTL_ID'  => $htl_id,
      'PLN_ID'  => $pln_id,
      'TYPE_ID' => $type_id,
      'NUM'     => $ids[3],
      );

  

    if (!$date = Session::get('detail_date')) {
      $date['Yn'] = date('Y-n', strtotime($search_date));
      $date['Y'] = date('Y', strtotime($search_date));
      $date['m'] = date('m', strtotime($search_date));
      $date['rm_num'] = isset($ids[5]) ? $ids[5] : '1';
      $date['stay_num'] = isset($ids[4]) ? $ids[4] : '1';
      $date['Y-m-d'] = $search_date;
      Session::set('detail_date', $date);
    }
    if($date['Y'] < 2000){
      Session::delete('detail_date');
      Response::redirect($this->htl_name.'/plan');
    }

    $year = $date['Y'];
    $month = date('n',strtotime($date['Y-m-d']));

    $holiday = $this->japan_holiday($year);
    if (isset($holiday[$month])) {
      $holiday_list = $holiday[$month];
    }else{
      $holiday_list = array();
    }

    $preview_month = date('Y-n', strtotime($year . '-' . $month . '-01'. "-1 month")) ;
    $next_month = date('Y-n', strtotime($year . '-' . $month . '-01'. "+1 month")) ;


    $preview_page['url'] = $year . '-' . $month;
    $preview_page['url'] = HTTP.'/'.$this->htl_name.'/plan/date/'.$preview_month;
    $preview_page['month'] = date('n', strtotime($preview_month.'-01'));

    $next_page['url'] = $year . '-' . $month;
    $next_page['url'] = HTTP.'/'.$this->htl_name.'/plan/date/'.$next_month;
    $next_page['month'] = date('n' ,strtotime($next_month.'-01'));

    for ($i='1'; $i <= '31' ; $i++) { 
      $param['DATE'] = $date['Yn']. '-' . $i;
      $param['DATE'] = date('Y-m-d', strtotime($param['DATE']));
      $datetime = date('Ymd', strtotime($param['DATE']));
      $result = $plan_rtype->get_plan_rtype_one_price_stock($param);
      $result['url'] = HTTP.'/'.$this->htl_name.'/reserve/'.$htl_id.EXPLODE.$pln_id.EXPLODE.$type_id.EXPLODE.$ids['3'].EXPLODE.$date['stay_num'].EXPLODE.$date['rm_num'].EXPLODE.$datetime;

      if ($param['DATE'] == date('Y-m-d', strtotime('-1 day')) && isset($result['closing_time']) && ( date('H:i', strtotime($result['closing_time'].':00')) > date('H:i') ) ) {
        if (isset($holiday_list[$i])) {
          $result['class'] = 'red';
        }else{
          $result['class'] = '';
        }
      }elseif ($param['DATE'] < date('Y-m-d')) {
        $result['stopflg'] = '1';
        $result['mark'] = '';
        $result['class'] = 'bg01';
      }elseif ($param['DATE'] == date('Y-m-d')) {
        // $result['class'] = 'red';
        $result['flg'] = '1';
        if (isset($holiday_list[$i])) {
          $result['class'] = 'red';
        }else{
          $result['class'] = '';
        }
      }else{
        if (isset($holiday_list[$i])) {
          $result['class'] = 'red';
        }else{
          $result['class'] = '';
        } 
      }
      if (Session::get('plan_search_option.ciDate') && Session::get('plan_search_option.ciDate') != 'on' && $result['class'] != 'bg01') {
        $search_date = date('Y-m-d', strtotime(str_replace(array('年','月','日'), array('-','-',''), Session::get('plan_search_option.ciDate'))));
        if ($param['DATE'] == $search_date) {
          $result['class'] = 'bg02';
        }
        for ($j = 1; $j < $date['stay_num']; $j++) {
          $search_date = date('Y-m-d', strtotime(str_replace(array('年','月','日'), array('-','-',''), Session::get('plan_search_option.ciDate'))) + (60*60*24*$j));
          if ($param['DATE'] == $search_date) {
            $result['class'] = 'bg02';
          }
        }

      }
      $plan_calendar[$i] = $result;
    }



    /*月初めは何曜日か判定*/
    $days_in_month = Date::days_in_month($date['m'], $date['Y']);
    $ymd = $date['Y'].'-'.$date['m'].'-01';
    $datetime = new DateTime($ymd);
    $week = array("0", "1", "2", "3", "4", "5", "6");
    $w = (int)$datetime->format('w');
    $empty = $week[$w];



    $checkinTimes=explode(',', $plan_rtype_data['CHECK_IN']);
    $checkin = $checkinTimes[0];

    if ($plan_rtype_data['RM_OPTION'] == '001000') {
      $smoke = '1';
    }else{
      $smoke = '0';
    }

    if (count($ids) == 7) {
      
      $price_list_param = array(
          'stay_date'  => $ids[6],
          'stay_count' => $ids[4],
          'person_num' => $ids[3],
          'htl_id'     => $ids[0],
          'pln_id'     => $ids[1],
          'type_id'    => $ids[2],
        );
      $price_list = $this->price_list($price_list_param);


      $convert_price_list = array();

      $sum = 0;
      foreach ($price_list as $key => $value) {      
        $format = 'Y-m-d';
        $datec = DateTime::createFromFormat($format, $key);
        $date1 =  $datec->format(__('date_format'));
        $convert_price_list[$date1]['one_person'] = $value;
        $convert_price_list[$date1]['one_stay'] = $value * $price_list_param['person_num'];
        $sum += $convert_price_list[$date1]['one_stay'];
      }

    }


    if (file_exists(IMG_FILE_PATH.'rtype_image/rtypeImgHtlID_'.$htl_id.'TypeID_'.$type_id.'_1.png')) {
      $imgurl1 = 'rtype_image/rtypeImgHtlID_'.$htl_id.'TypeID_'.$type_id.'_1.png';
    }else{
      $imgurl1 = 'front/noimage.png';
    }
  
    if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$pln_id.'_1.png')) {
      $imgurl2 = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$pln_id.'_1.png';
    }else{
      $imgurl2 = 'front/noimage.png';
    }

    if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$pln_id.'_2.png')) {
      $imgurl3 = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$pln_id.'_2.png';
    }else{
      $imgurl3 = 'front/noimage.png';
    }

    if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$pln_id.'_3.png')) {
      $imgurl4 = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$pln_id.'_3.png';
    }else{
      $imgurl4 = 'front/noimage.png';
    }



    /*同じ部屋タイプのほかのプランを取得*/
    $rtype_param = array(
      'PLN_ID' =>$pln_id,
      'TYPE_ID'=>$type_id,
      );
    $start = date('Y-m-d');
    $end = date('Y-m-d', strtotime("+1 month"));

    $plan = Model_M_Plan::forge();
    $other_plan = $plan->get_plan_frontlist($this->htl_id, $ids[3], $start, $end, 0, $date['stay_num'], $date['rm_num'] , 0, $rtype_param, $this->language, '1', null);

    foreach ($other_plan as $key => $value) {
      foreach ($value['RTYPES'] as $k => $val) {
          $other_plan[$key]['PAYMENT'] = $val['PAYMENT'];
          $other_plan[$key]['SUM'] = $val['PAYMENT'] * $ids[3] * $date['stay_num']; //  日付未定の場合は料金をおおよそで出力する。
          $other_plan[$key]['URL'] = HTTP.'/'.$this->htl_name.'/plan/detail/'.$value['HTL_ID'].EXPLODE.$value['PLN_ID'].EXPLODE.$val['TYPE_ID'].EXPLODE.$ids[3];
      }
      if (count($other_plan[$key]['RTYPES']) == 0) {
          unset($other_plan[$key]);
      }
    }




    $plan = array(
        'PLN_NAME' => $plan_rtype_data['PLN_NAME'],
        'TYPE_NAME' => $plan_rtype_data['TYPE_NAME'],
        'PLN_MIN' => $plan_rtype_data['PLN_MIN'],
        'PLN_MAX' => $plan_rtype_data['PLN_MAX'],
        'PLN_STAY_LOWER' => $plan_rtype_data['PLN_STAY_LOWER'],
        'PLN_STAY_UPPER' => $plan_rtype_data['PLN_STAY_UPPER'],
        'CHECK_IN' => $checkin,
        'CAP' => $ids[3],
        'SMOKE' => $smoke,
        'DESCRIPTION' => $plan_rtype_data['PLN_CAP_PC'],
        'DESCRIPTION_LIGHT' => $plan_rtype_data['PLN_CAP_PC_LIGHT'],
        'IMGURL1' => $imgurl1,
        'IMGURL2' => $imgurl2,
        'IMGURL3' => $imgurl3,
        'IMGURL4' => $imgurl4,
      );

    if (count($ids) == 7) {
      $reserve = array(
          'STAYDATE' => $ids[6],
          'STAYNUM' => $ids[3],
          'STAYRMNUM' => $ids[5],
          'STAYMDATENUM' => $ids[4],
          'PRICE' => $convert_price_list,
          'PRICE_SUM' => $sum,
          'PRICE_TOTAL' => $sum * $ids[5],
          'BASIC_PAY' =>  $plan_rtype_data['PLN_CHG_PERSON'.$ids[3]] + $plan_rtype_data['PLN_CHG_EXCEPTION'.$ids[3]],
          'PAYMENT' => ($plan_rtype_data['PLN_CHG_PERSON'.$ids[3]] + $plan_rtype_data['PLN_CHG_EXCEPTION'.$ids[3]]) * $ids[3] * $ids[4] * $ids[5],
          'URL'=> $ids[0].EXPLODE.$ids[1].EXPLODE.$ids[2].EXPLODE.$ids[3].EXPLODE.$ids[4].EXPLODE.$ids[5].EXPLODE.$ids[6],
        );
      $tpl = 'front/plan/detail_reserve';
    }else{
      $reserve['STAYNUM'] = $ids[3];
      $reserve['STAYMDATENUM'] = $date['stay_num'];
      $reserve['STAYRMNUM'] = $date['rm_num'];

      $tpl = 'front/plan/detail';
    }


    $data = array(
      'action' => $this->htl_name.'/plan/recalculation',
      'name' => $user_data['user_name'],
      'plan' => $plan,
      'reserve' => $reserve,
      'calendar' => $plan_calendar,
      'empty' => $empty,
      'days_in_month' => $days_in_month,
      'year' => $year,
      'month' => $month,
      'preview_page' => $preview_page,
      'next_page' => $next_page,
      'member_num' => $ids[3],
      'rm_num' => $reserve['STAYRMNUM'],
      'staydate_num' => $reserve['STAYMDATENUM'],
      'other_plan' => $other_plan,
      'type_id' => $type_id,
      'login_url' => HTTP.'/'.$this->htl_name.'/login',
      'logout_url' => HTTP.'/'.$this->htl_name.'/logout',
      'holiday_list' => $holiday_list,
      );


    $this->template->js = '';
    // $this->template->js = 'plan/plan.js';
    $this->template->title = __('lbl_front_title');
    $this->template->content = View_Smarty::forge($tpl,$data);
  }  



  /**
  *
  *再計算ボタンを押すと呼ばれる
  *
  **/
  public function action_recalculation()
  {
    $data = Input::post();
    $rm_num = $data['room'];
    $stay_num = $data['stayCount'];


    if (!$date = Session::get('detail_date')) {
      $date['Yn'] = date('Y-n');
      $date['Y'] = date('Y');
      $date['m'] = date('m');
      $date['rm_num'] = $rm_num;
      $date['stay_num'] =  $stay_num;
      $date['Y-m-d'] = date('Y-m-d');
      Session::set('detail_date', $date);
    }else{
      $date['rm_num'] = $rm_num;
      $date['stay_num'] =  $stay_num;
      Session::set('detail_date', $date);
    }

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url);  

  }


  public function action_date($data)
  {
    $datas = explode('-', $data[0]);

    $year  = date('Y', strtotime($datas[0].'-01-01'));

    $ymd = date('Y-m-d', strtotime($data[0]));

    $month = date('n', strtotime($ymd));

    $yn = date('Y-n', strtotime($data[0]));


    if (!$date = Session::get('detail_date')) {
      $date['Yn'] = $yn;
      $date['Y'] = $year;
      $date['m'] = $month;
      $date['rm_num'] = '1';
      $date['stay_num'] =  '1';
      $date['Y-m-d'] = $ymd;
      Session::set('detail_date', $date);
    }else{
      $date['Yn'] = $yn;
      $date['Y'] = $year;
      $date['m'] = $month;
      $date['Y-m-d'] = $ymd;
      Session::set('detail_date', $date);
    }

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url);  


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
