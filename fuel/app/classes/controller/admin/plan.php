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
class Controller_Admin_plan extends Controller_Common
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

    if (!$limit = Session::get('limit')) {
      $limit = LIMIT_NUM;
    }

    $option = array('offset' => '0', 'limit' => $limit, 'sort' => Session::get('sort'), 'sort_option' => Session::get('sort_option'), 'where' => Session::get('where'));
    // $option['sort'] == Session::get('sort');
    $this->show_plan($login_id, $option);

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

    if (!$limit = Session::get('limit')) {
      $limit = LIMIT_NUM;
    }

    $option = array('limit' => $limit, 'sort' => Session::get('sort'), 'sort_option' => Session::get('sort_option'), 'where' => Session::get('where'));
    $this->show_plan($login_id, $option);
  }


  /**
  *
  *どのカラムをソートするのかをSessionに保存
  *
  **/
  public function action_sort($option)
  {
    $url = $_SERVER['HTTP_REFERER'];

    if ($option[0] == 'st0') {
      $sort_type = ST0;
    }elseif ($option[0] == 'st1') {
      $sort_type = ST1;
    }elseif ($option[0] == 'st2') {
      $sort_type = ST2;
    }elseif ($option[0] == 'st3') {
      $sort_type = ST3;
    }elseif ($option[0] == 'st4') {
      $sort_type = ST4;
    }else{
      Response::redirect($url,'refresh');
    }
    Session::set('sort', $sort_type);

    if ($option[1] == 1) {
      $sort_option = 'ASC';
    }elseif ($option[1] == 2) {
      $sort_option = 'DESC';
    }else{
       Response::redirect($url,'refresh');  
    }
    Session::set('sort_option', $sort_option);
    Response::redirect($url,'refresh');
  }


  public function action_limit($num)
  {
    $limit_num = $num[0];
    Session::set('limit', $limit_num);
    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url,'refresh');
  }


  /**
  *
  *販売期間の指定
  *
  **/
  public function action_showChange($option)
  {
    $url = $_SERVER['HTTP_REFERER'];

    if ($option[0] == 1) {
      $sort_option = ' AND PLAN_START <= now() AND PLAN_END >= now() ';
    }elseif ($option[0] == 2) {
      $sort_option = ' AND PLAN_END < now() ';
    }else{
       Response::redirect($url,'refresh');  
    }


    Session::set('where', $sort_option);


    $where = Session::get('where');

    $this->action_index();

    // Response::redirect(HTTP.'/admin/plan', 'refresh');
  }


  /**
  *
  *プランの取得、プランページの呼び出し
  *
  **/
  private function show_plan($login_id, $option)
  {
    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $plan = Model_M_Plan::forge();

    $all_data_count = $plan->get_count(Session::get('where'), $user_data['HTL_ID']);

    $config = array(
        'pagination_url' => 'admin/plan/page',
        'uri_segment'    => 4,
        'num_links'      => 4,
        'per_page'       => $option['limit'],
        'total_items'    => $all_data_count,
        'show_first'     => true,
        'show_last'      => true,
      );

    $pagination = Pagination::forge('mypagenation' ,$config);
   
    if (!isset($option['offset'])) {
      $option['offset'] = $pagination->offset;
    }

    $plan_data = $plan->get_plan_all($option, $user_data['HTL_ID']);
    $plan_data_count = count($plan_data);

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


    $data = array(
      'title' => TITLE_PLAN,
      'plans' => $plan_data,
      'plan_data_count' => $plan_data_count + $option['offset'],
      'start_count'     => $option['offset'] + 1,
      'all_data_count'  => $all_data_count,
      'first_page'      => $first_page,
      'last_page'       => $last_page,
      'preview_page'    => $preview_page,
      'next_page'       => $next_page,
      'current_page'    => $current_page,
      'limit_num'       => $option['limit'],
      'error'           => Session::get_flash('error'),
      );
   
    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = 'plan/plan.js';
    $this->template->title = TITLE_PLAN;
    $this->template->content = View::forge('admin/plan/plan', $data);

  }
  


  /**
  *
  *プランを一件取得、プラン編集ページの呼び出し
  *
  **/
  public function action_new()
  {

    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);


    //
    $plan = Model_M_Plan::forge();
    $plan_id = $plan->plan_insert($user_data['HTL_ID']);
    $result = $user_data['HTL_ID'].EXPLODE.$plan_id;


    $en = Model_M_Plan_En::forge();
    $en_result = $en->insert_en($user_data['HTL_ID'], $plan_id);
 
    $ko = Model_M_Plan_Ko::forge();
    $ko_result = $ko->insert_ko($user_data['HTL_ID'], $plan_id);
 
    $ch = Model_M_Plan_Ch::forge();
    $ch_result = $ch->insert_ch($user_data['HTL_ID'], $plan_id);
 
    $chh = Model_M_Plan_Chh::forge();
    $chh_result = $chh->insert_chh($user_data['HTL_ID'], $plan_id);

    // $this->action_edit($result);

    Response::redirect('admin/plan/edit/'.$result);

    // $new_colms = array();
    // $columns = DB::list_columns('m_plans');
    // foreach ($columns as $key => $value) {
    //   $new_colms[$key] = null;

    // }
    // $columns = DB::list_columns('m_plan_ens');
    // foreach ($columns as $key => $value) {
    //   $new_colms[$key] = null;

    // }
    // $columns = DB::list_columns('m_plan_chs');
    // foreach ($columns as $key => $value) {
    //   $new_colms[$key] = null;

    // }
    // $columns = DB::list_columns('m_plan_chhs');
    // foreach ($columns as $key => $value) {
    //   $new_colms[$key] = null;

    // }
    // $columns = DB::list_columns('m_plan_kos');
    // foreach ($columns as $key => $value) {
    //   $new_colms[$key] = null;

    // }
    // $columns = DB::list_columns('m_categorys');
    // foreach ($columns as $key => $value) {
    //   $new_colms[$key] = null;

    // }

    // $category = Model_M_Category::forge();
    // $category_data = $category->get_category($user_data['HTL_ID']);


    // $new_colms['CATEGORY_NAME1'] = null;
    // $new_colms['CATEGORY_NAME2'] = null;
    // $new_colms['CATEGORY_NAME3'] = null;
    // $new_colms['CATEGORY_ID1'] = null;
    // $new_colms['JP_CAP_PC_LIGHT'] = null;
    // $new_colms['EN_CAP_PC_LIGHT'] = null;
    // $new_colms['CH_CAP_PC_LIGHT'] = null;
    // $new_colms['CHH_CAP_PC_LIGHT'] = null;
    // $new_colms['KO_CAP_PC_LIGHT'] = null;
    // $new_colms['HTL_ID'] = $user_data['HTL_ID'];

    // $plan = Model_M_Plan::forge();
    // // $plan_data = $plan->get_plan_one($htl_code, $plan_code);
    // $plan_data = $new_colms;
    // $plan_data['HtlPlnID'] = $new_colms['HTL_ID'].EXPLODE;


    // $stay_list = array();
    // for ($i=1; $i <= 14; $i++) { 
    //   $stay_list[$i] = $i;
    // }

    // $tejimai_time = array();
    // for ($i=24; $i < 30; $i++) { 
    //   $tejimai_time[$i] = $i;
    // }

    // $checkInTimes = array();
    // $checkInTimes = explode(',', $plan_data['CHECK_IN']);
    // if ($plan_data['CHECK_IN'] == null) {
    //   $checkInTimes = null;
    // }


    // if ($plan_data['PLN_USE_FLG'] == 0) {
    //     $stop_flg = 'checked';    $sale_flg = '';
    // }else{
    //     $stop_flg = '';           $sale_flg = 'checked';
    // }

    // if ($plan_data['PLN_LIMIT_TIME'] != null) {
    //     $tejimai_flg = 'checked';
    // }else{
    //     $tejimai_flg = '';
    // }

    // $mpr = Model_M_Plan_Rtype::forge();
    // $unuse_rtypes = $mpr->get_unuse_rtype($user_data['HTL_ID'], null);
    // $use_rtypes = array();

    // $data = array(
    //   'title' => TITLE_PLANEDIT,
    //   'stay_list' => $stay_list,
    //   'tejimai_time' => $tejimai_time,
    //   'stop_flg' => $stop_flg,
    //   'sale_flg' => $sale_flg,
    //   'tejimai_flg' => $tejimai_flg,
    //   'plan' => $plan_data,
    //   'htl_id' => $user_data['HTL_ID'],
    //   'category' => $category_data,
    //   'action' => 'insert',
    //   'plan_id' => '新規',
    //   'checkinTimes' => $checkInTimes,
    //   'unuse_rtype' => $unuse_rtypes,
    //   'use_rtypes' => $use_rtypes,
    //   );

    // $this->template->name = $user_data['CO_NAME'];
    // $this->template->title = TITLE_PLANEDIT;
    // $this->template->jsfile = 'plan/edit.js';
    // $this->template->content = View::forge('plan/edit', $data);


  }


  /**
  *
  *プランを一件取得、プラン編集ページの呼び出し
  *
  **/
  public function action_edit($code)
  {
    $codes = explode(EXPLODE, $code[0]);

    if (count($codes) != 2) {
      Response::redirect('plan');
    }else{
      $htl_id = $codes[0];
      $plan_id = $codes[1];
      
    }
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_one($htl_id, $plan_id);
    $plan_data['HtlPlnID'] = $code[0];

    $category = Model_M_Category::forge();
    $category_data = $category->get_category($htl_id);


    $stay_list = array();
    for ($i=1; $i <= 14; $i++) { 
      $stay_list[$i] = $i;
    }

    $tejimai_time = array();
    $time_start = $plan_data['PLN_LIMIT_DAY'] ? 0 : 24;
    $time_end = $plan_data['PLN_LIMIT_DAY'] ? 23 : 29;
    for ($i=$time_start; $i <= $time_end; $i++) { 
      $tejimai_time[$i] = $i;
    }

    $tejimai_day = array();
    for ($i=0; $i <= 120; $i++) { 
      $tejimai_day[$i] = $i==0 ? '当日未明' : $i.'日前';
    }

    $tejimai_type = array(
      '' => '制限しない',
      '1' => '制限する',
    );

    $checkInTimes = array();
    $checkInTimes = explode(',', $plan_data['CHECK_IN']);
    if ($plan_data['CHECK_IN'] == null) {
      $checkInTimes = null;
    }


    if ($plan_data['PLN_USE_FLG'] == 0) {
        $stop_flg = 'checked';    $sale_flg = '';
    }else{
        $stop_flg = '';           $sale_flg = 'checked';
    }

    if ($plan_data['PLN_LIMIT_TIME'] != null || $plan_data['PLN_LIMIT_DAY'] != null) {
        $tejimai_flg = '1';
    }else{
        $tejimai_flg = '';
    }


    if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_1.png')) {
        // $plan_data[$key]['IMGURL2'] = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_1.png';
        $img1 = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_1.png'; 
    }else{
        $img1 = 'front/noimage.png'; 
    }

    if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_2.png')) {
        $img2 = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_2.png'; 
    }else{
        $img2 = 'front/noimage.png'; 
    }

    if (file_exists(IMG_FILE_PATH.'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_3.png')) {
        $img3 = 'pln_image/plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id.'_3.png'; 
    }else{
        $img3 = 'front/noimage.png'; 
    }






    $mpr = Model_M_Plan_Rtype::forge();
    $unuse_rtypes = $mpr->get_unuse_rtype($htl_id, $plan_id);
    $use_rtypes = $mpr->get_use_rtype($htl_id, $plan_id);

    $data = array(
      'title' => TITLE_PLANEDIT,
      'stay_list' => $stay_list,
      'tejimai_type' => $tejimai_type,
      'tejimai_day' => $tejimai_day,
      'tejimai_time' => $tejimai_time,
      'stop_flg' => $stop_flg,
      'sale_flg' => $sale_flg,
      'tejimai_flg' => $tejimai_flg,
      'plan' => $plan_data,
      'htl_id' => $htl_id,
      'plan_id' => $plan_id,
      'category' => $category_data,
      'action' => 'save',
      'checkinTimes' => $checkInTimes,
      'unuse_rtype' => $unuse_rtypes,
      'use_rtypes' => $use_rtypes,
      'img1' => $img1,
      'img2' => $img2,
      'img3' => $img3,
      'error' => Session::get_flash('error'),
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = TITLE_PLANEDIT;
    $this->template->jsfile = 'plan/edit.js';
    $this->template->content = View::forge('admin/plan/edit', $data);


  }


  /**
  *
  *プランの保存（newからの遷移）
  *
  **/
  public function action_insert()
  {

    $post = Input::post();

    $codes = explode(EXPLODE, $post['HtlPlnID']);
    $htl_id = $codes[0];

    if ($_FILES['picFile1']['name'] != null) {
      $_FILES['picFile1']['name']= '_1.png';
    }
    if ($_FILES['picFile2']['name'] != null) {
      $_FILES['picFile2']['name']= '_2.png';
    }
    if ($_FILES['picFile3']['name'] != null) {
      $_FILES['picFile3']['name']= '_3.png';
    }

    $result = $this->check_post($post);
    if ($result == 1) {
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url,'refresh');
    }

    $m_plan = $this->m_plan($post);
    $m_plan_dao = Model_M_Plan::forge();
    $result = $m_plan_dao->plan_insert($m_plan,$htl_id);
    if ($result != null) {
      $config = array(
          'prefix' => 'plnImgHtlID_'.$htl_id.'PlnID_'.$result,
          'overwrite'     => true,
        );
      $this->uploadImg($config);
    }

    // $m_category = $this->m_category($post);
    // $m_category_dao = Model_M_Category::forge();
    // $result = $m_category_dao->update_flg($m_category, $htl_id,$plan_id);
  /*modelごとにデータを分ける*/

    Response::redirect('admin/plan');
  }  

  /**
  *
  *プランの保存（editからの遷移）
  *
  **/
  public function action_save()
  {

    $post = Input::post();
    $codes = explode(EXPLODE, $post['HtlPlnID']);
    $htl_id = $codes[0];
    $plan_id = $codes[1];


    $result = $this->check_post($post);
    if ($result == 1) {
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url,'refresh');
    }


    $m_plan = $this->m_plan($post);
    $m_plan_dao = Model_M_Plan::forge();
    $result = $m_plan_dao->plan_save($m_plan,$htl_id,$plan_id);

    if ($_FILES['picFile1']['name'] != null) {
      $_FILES['picFile1']['name']= '_1.png';
    }
    if ($_FILES['picFile2']['name'] != null) {
      $_FILES['picFile2']['name']= '_2.png';
    }
    if ($_FILES['picFile3']['name'] != null) {
      $_FILES['picFile3']['name']= '_3.png';
    }

    $config = array(
        'prefix' => 'plnImgHtlID_'.$htl_id.'PlnID_'.$plan_id,
    );
    $this->uploadImg($config);

  /*modelごとにデータを分ける*/

    Response::redirect('admin/plan');
  }



  /**
  *
  *プランの保存（editからの遷移）
  *
  **/
  private function m_category($post)
  {
    $category_data = array();
    if (isset($post['planType'])) {
      foreach ($post['planType'] as $key => $value) {
         $codes = explode(EXPLODE, $value);
         $category_data[$key] = array(
            'HTL_ID' => $codes[0],
            'CATEGORY_ID' => $codes[1],
            'FLG' => '1'
          );    
      }
    }

    return $category_data;
  }


  /**
  *
  *model:plan用の値の整理
  *
  **/  
  private function m_plan($post)
  {
    $plan_data = array(
        'PLN_NAME' => $post['planNameJP'],
        'PLN_NAME_CH' => $post['planNameCH'],
        'PLN_NAME_CHH' => $post['planNameCHH'],
        'PLN_NAME_EN' => $post['planNameEN'],
        'PLN_NAME_KO' => $post['planNameKO'],
        'PLAN_START' => $post['saleTermStart'],
        'PLAN_END' => $post['saleTermEnd'] ,
        'DISP_START' => $post['showTermStart'],
        'DISP_END' => $post['showTermEnd'],
        'PLN_STAY_LOWER' => $post['staysNumLower'],
        'PLN_STAY_UPPER' => $post['staysNumUpper'],
        'PLN_CAP_PC_LIGHT' => $post['explainJp'],
        'PLN_CAP_PC_LIGHT_EN' => $post['explainEn'],
        'PLN_CAP_PC_LIGHT_CH' => $post['explainCh'],
        'PLN_CAP_PC_LIGHT_CHH' => $post['explainTw'],
        'PLN_CAP_PC_LIGHT_KO' => $post['explainKr'],
        'PLN_USE_FLG' => $post['saleStatus'],
      );

    if (!empty($post['closingOutCB'])) {
      $plan_data['PLN_LIMIT_TIME'] = $post['closingOut'];
      $plan_data['PLN_LIMIT_DAY'] = $post['closingOut2'];
    }else{
      $plan_data['PLN_LIMIT_TIME'] = NULL;
      $plan_data['PLN_LIMIT_DAY'] = NULL;
    }

    if (isset($post['c_times'])) {
      $times='';
      foreach ($post['c_times'] as $key => $value) {
        if ($key == 0) {
          $times .= $value; 
        }else{
          $times .= ','.$value;
        }
      }
      $plan_data['CHECK_IN'] = $times;

    }else{
      $plan_data['CHECK_IN'] = null;
    }


    if (isset($post['planType'][0])) {
      $codes = explode(EXPLODE, $post['planType'][0]);
      $plan_data['CATEGORY_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY_ID'] = '0';
    }
    if (isset($post['planType'][1])) {
      $codes = explode(EXPLODE, $post['planType'][1]);
      $plan_data['CATEGORY2_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY2_ID'] = '0';
    }
    if (isset($post['planType'][2])) {
      $codes = explode(EXPLODE, $post['planType'][2]);
      $plan_data['CATEGORY3_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY3_ID'] = '0';
    }
    if (isset($post['planType'][3])) {
      $codes = explode(EXPLODE, $post['planType'][3]);
      $plan_data['CATEGORY4_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY4_ID'] = '0';
    }
    if (isset($post['planType'][4])) {
      $codes = explode(EXPLODE, $post['planType'][4]);
      $plan_data['CATEGORY5_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY5_ID'] = '0';
    }    
    if (isset($post['planType'][5])) {
      $codes = explode(EXPLODE, $post['planType'][5]);
      $plan_data['CATEGORY6_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY6_ID'] = '0';
    }           
    if (isset($post['planType'][6])) {
      $codes = explode(EXPLODE, $post['planType'][6]);
      $plan_data['CATEGORY7_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY7_ID'] = '0';
    }
    if (isset($post['planType'][7])) {
      $codes = explode(EXPLODE, $post['planType'][7]);
      $plan_data['CATEGORY8_ID'] = $codes[1];
    }else{
      $plan_data['CATEGORY8_ID'] = '0';
    }

    return $plan_data;
  }






  /**
  *
  *postに空がないか確認
  *
  **/
  private function check_post($post)
  {
    if (!isset($post['planNameJP']) || $post['planNameJP'] == '') {
      Session::set_flash('error', 'プラン名称が未入力です。');
      return 1;
   }
    if (!isset($post['saleTermStart']) || $post['saleTermStart'] == '') {
      Session::set_flash('error', '販売期間が未入力です。');
      return 1;
    }
    if (!isset($post['saleTermEnd']) || $post['saleTermEnd'] == '') {
      Session::set_flash('error', '販売期間が未入力です。');
      return 1;
    }
    if (!isset($post['showTermStart']) || $post['showTermStart'] == '') {
      Session::set_flash('error', '表示期間が未入力です。');
      return 1;
    }
    if (!isset($post['showTermEnd']) || $post['showTermEnd'] == '') {
      Session::set_flash('error', '表示期間が未入力です。');
      return 1;
    }
    if (!isset($post['staysNumLower']) || $post['staysNumLower'] == '') {
      Session::set_flash('error', '宿泊数が未入力です。');
      return 1;
    }
    if (!isset($post['staysNumUpper']) || $post['staysNumUpper'] == '') {
      Session::set_flash('error', '宿泊数が未入力です。');
      return 1;
    }
    if (!isset($post['explainJp'])) {
      Session::set_flash('error', 'プランの説明文が未入力です。');
      return 1;
    }
    if (isset($post['planType']) && count($post['planType']) > 8) {
      Session::set_flash('error', 'カテゴリーは８まで選択できます。');
      return 1;
    }

    return 0;
  }


  /**
  *
  *プランの削除
  *
  **/
  public function action_delete($code)
  {
    $data=array();
    $ids = explode(EXPLODE, $code[0]);
    $data[0][0] = $ids[0];//htl_id
    $data[0][1] = $ids[1];//pln_id
    $plan = Model_M_Plan::forge();
    $plan_data = $plan->delete_plan($data);

    $en = Model_M_Plan_En::forge();
    $en_result = $en->delete_en_one($ids[0], $ids[1]);
 
    $ko = Model_M_Plan_Ko::forge();
    $ko_result = $ko->delete_ko_one($ids[0], $ids[1]);
 
    $ch = Model_M_Plan_Ch::forge();
    $ch_result = $ch->delete_ch_one($ids[0], $ids[1]);
 
    $chh = Model_M_Plan_Chh::forge();
    $chh_result = $chh->delete_chh_one($ids[0], $ids[1]);

    $mpr = Model_M_Plan_Rtype::forge();
    $mpr_result = $mpr->delete_pln_rtype($ids[0], $ids[1], null);

    $mpe = Model_M_Plan_Exceptionday::forge();
    $mpe_result = $mpe->delete_exceptionday($ids[0], $ids[1], null);

    $rpr = Model_R_Plan_Rmnum::forge();
    $rpr_result = $rpr->delete_pln_rm($ids[0], $ids[1], null);

    if (!isset($code['9'])) {
        Response::redirect('admin/plan');
    }
    // $url = $_SERVER['HTTP_REFERER'];
    // Response::redirect($url,'refresh');
  }


  /**
  *
  *プランの表示順の変更
  *
  **/
  public function action_sortchange()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_id']);
    $data['htl_id'] = $ids[0];
    $data['pln_id'] = $ids[1];

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->change_sort($data);
 // Response::redirect('plan');  
  }

  /**
  *
  *プランの販売、停止の変更
  *
  **/  
  public function action_salechange()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_id']);
    $param = array();
    $param[0] = $ids;
       

    $plan = Model_M_Plan::forge();
    $plan->change_sale_flg($data['flg'],$param);
    $plan_data = $plan->change_sale($data);
 // Response::redirect('plan');  
  }


  /**
  *
  *プランページからチェックしたプランを操作
  *
  **/
  private function check_edit($data)
  {

    $param = array();

    foreach ($data['check'] as $key => $value) {
      $param[$key] = explode(EXPLODE, $value);
    }

    $plan = Model_M_Plan::forge();


    if ($data['action'] == CHECK_SALE) {
      $plan->change_sale_flg('1',$param);
    }elseif ($data['action'] == CHECK_STOP) {
      $plan->change_sale_flg('0',$param);
    }elseif ($data['action'] == CHECK_DELETE) {
      foreach ($param as $key => $value) {
        $this->action_delete(array(
            '0' => $value['0'].EXPLODE.$value['1'],
            '9' => 1,
          ));
      }
      // $plan->delete_plan($param);
    }

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url,'refresh');

  }


  public function uploadImg($config)
  {      
    if(Input::method() === 'POST') {
        Upload::process($config);
        // 検証
        if (Upload::is_valid())
        {
          Upload::save();
        }

        // エラー有り
        foreach (Upload::get_errors() as $file)
        {
            // $file['errors']の中にエラーが入っているのでそれを処理
        }
    }
  }



  public function action_category($data)
  {
    $plan_id = $data[0];

    if (!$login_id = Session::get('id')) {
      Response::redirect('admin/index');
    }

    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $category = Model_M_Category::forge();
    $category_data = $category->get_all_category_data($user_data['HTL_ID']);


      $data = array(
      'title' => 'カテゴリ編集',
      'htl_id' => $user_data['HTL_ID'],
      'category_data' => $category_data,
      'plan_id' => $plan_id,
      'error' => Session::get_flash('error'),
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = 'カテゴリ編集';
    $this->template->jsfile = 'plan/category.js';
    $this->template->content = View::forge('admin/plan/category', $data);
  }



  public function action_category_delete($id)
  {
    $ids = explode(EXPLODE, $id[0]);

    $htl_id = $ids[0];
    $category_id = $ids[1];

    $category = Model_M_Category::forge();
    $result = $category->all_delete_category($htl_id, $category_id);

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url,'refresh');
  }


  /**
  *
  * シークレットプラン一覧
  *
  **/
  private function action_secret_plan($id, $page=1)
  {
    $ids = explode(EXPLODE, $id[0]);

    $htl_id = $ids[0];
    $plan_id = $ids[1];

    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    if (!$limit = Session::get('limit')) {
      $limit = LIMIT_NUM;
    }

    $option = array('limit' => $limit, 'sort' => Session::get('sort'), 'sort_option' => Session::get('sort_option'), 'where' => Session::get('where'));

    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_one($user_data['HTL_ID'], $plan_id);

    $secret = Model_M_Secret::forge();
    $all_data_count = $secret->get_count(Session::get('where'), $user_data['HTL_ID'], $plan_id);

    $config = array(
        'pagination_url' => 'admin/plan/page',
        'uri_segment'    => 4,
        'num_links'      => 4,
        'per_page'       => $option['limit'],
        'total_items'    => $all_data_count,
        'show_first'     => true,
        'show_last'      => true,
      );

    $pagination = Pagination::forge('mypagenation', $config);
   
    if (!isset($option['offset'])) {
      $option['offset'] = $pagination->offset;
    }

    $plans = $secret->get_plan_all($option, $user_data['HTL_ID'], $plan_id);
    $plan_data_count = count($plans);

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


    $data = array(
      'title' => 'シークレットプラン',
      'plan_id' => $plan_id,
      'plan_data' => $plan_data,
      'plans' => $plans,
      'plan_data_count' => $plan_data_count + $option['offset'],
      'start_count'     => $option['offset'] + 1,
      'all_data_count'  => $all_data_count,
      'first_page'      => $first_page,
      'last_page'       => $last_page,
      'preview_page'    => $preview_page,
      'next_page'       => $next_page,
      'current_page'    => $current_page,
      'limit_num'       => $option['limit'],
      'error'           => Session::get_flash('error'),
      );
   
    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->jsfile = 'plan/secret_plan.js';
    $this->template->title = 'シークレットプラン';
    $this->template->content = View::forge('admin/plan/secret_plan', $data);

  }

  /**
  *
  * シークレットプランを新規作成して編集ページ
  *
  **/
  public function action_secret_new($id)
  {
    $plan_id = $id[0];

    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_one($user_data['HTL_ID'], $plan_id);

    $secret = Model_M_Secret::forge();
    $secret_id = $secret->plan_insert($user_data['HTL_ID'], $plan_id);

    $result = $user_data['HTL_ID'].EXPLODE.$plan_id.EXPLODE.$secret_id;

    Response::redirect('admin/plan/secret_edit/'.$result);
  }

  /**
  *
  * シークレットプランを編集ページ
  *
  **/
  public function action_secret_edit($code)
  {
    $codes = explode(EXPLODE, $code[0]);

    if (count($codes) != 3) {
      Response::redirect('plan');
    }else{
      $htl_id = $codes[0];
      $plan_id = $codes[1];
      $secret_id = $codes[2];
    }
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_one($htl_id, $plan_id);

    $secret = Model_M_Secret::forge();
    $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);
    $secret_data['HtlPlnID'] = $code[0];

    $data = array(
      'title' => TITLE_PLANEDIT,
      'plan_data' => $plan_data,
      'secret' => $secret_data,
      'htl_id' => $htl_id,
      'plan_id' => $plan_id,
      'secret_id' => $secret_id,
      'action' => 'secret_save',
      'error' => Session::get_flash('error'),
      );

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = TITLE_PLANEDIT;
    $this->template->jsfile = 'plan/edit.js';
    $this->template->content = View::forge('admin/plan/secret_edit', $data);

  }

  /**
  *
  * シークレットプランの保存（editからの遷移）
  *
  **/
  public function action_secret_save()
  {
    $login_id = Session::get('id');
    if ($login_id == null) {
      Response::redirect('admin/index');
    }
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $post = Input::post();
    $codes = explode(EXPLODE, $post['HtlPlnID']); // 名前のわりにsecretIDを含んでいる
    $htl_id = $codes[0];
    $plan_id = $codes[1];
    $secret_id = $codes[2];

    $plan = Model_M_Plan::forge();
    $plan_data = $plan->get_plan_one($htl_id, $plan_id);

    $secret_data = $post;
    $secret_data['HtlPlnID'] = $codes;

    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = 'シークレットプラン編集';
    $this->template->jsfile = 'plan/edit.js';

    $data = array(
      'title' => TITLE_PLANEDIT,
      'plan_data' => $plan_data,
      'secret' => $secret_data,
      'htl_id' => $user_data['HTL_ID'],
      'plan_id' => $plan_id,
      'secret_id' => $secret_id,
      'action' => 'secret_save',
    );

    if (!isset($post['PLN_TYPE']) || $post['PLN_TYPE'] == '') {
      Session::set_flash('error', 'カテゴリ名が未入力です。');
      $this->template->content = View::forge('admin/plan/secret_edit', $data);
      return;
    }
    if (!isset($post['PLN_NAME']) || $post['PLN_NAME'] == '') {
      Session::set_flash('error', 'タイトルが未入力です。');
      $this->template->content = View::forge('admin/plan/secret_edit', $data);
      return;
    }

    $secret = Model_M_Secret::forge();
    $result = $secret->plan_save($post, $htl_id, $plan_id, $secret_id);

    Response::redirect('admin/plan/secret_plan/'.$htl_id.'_'.$plan_id);
  }


  /**
  *
  * シークレットプランの削除
  *
  **/
  public function action_secret_delete($code)
  {
    $data=array();
    $ids = explode(EXPLODE, $code[0]);
    $data[0][0] = $ids[0];//htl_id
    $data[0][1] = $ids[1];//pln_id
    $data[0][2] = $ids[2];//secret_id
    $secret = Model_M_Secret::forge();
    $secret_data = $secret->delete_plan($data);
    Response::redirect('admin/plan/secret/'.$ids[1]);
  }


  /**
  *
  * シークレットプランの表示順の変更
  *
  **/
  public function action_secret_sortchange()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_id']);
    $data['htl_id'] = $ids[0];
    $data['pln_id'] = $ids[1];
    $data['secret_id'] = $ids[2];

    $secret = Model_M_Secret::forge();
    $secret_data = $secret->change_sort($data);
  }

  /**
  *
  * シークレットプランの販売、停止の変更
  *
  **/
  public function action_secret_salechange()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_id']);
    $param = array();
    $param[0] = $ids;

    $secret = Model_M_Secret::forge();
    $secret->change_sale_flg($data['flg'],$param);
    $secret_data = $secret->change_sale($data);
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
