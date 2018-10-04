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
class Controller_Admin_Room extends Controller_Common
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

    $option = array('offset' => '0', 'limit' => $limit, 'sort' => Session::get('sort_room'), 'sort_option' => Session::get('sort_option_room'));
    // $option['sort'] == Session::get('sort');
    $this->show_room($login_id, $option);

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

    $option = array('limit' => $limit, 'sort' => Session::get('sort_room'), 'sort_option' => Session::get('sort_option_room'));
    $this->show_room($login_id, $option);
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
      $sort_type = 'DISP_ORDER';
    }elseif ($option[0] == 'st1') {
      $sort_type = 'TYPE_ID';
    }elseif ($option[0] == 'st2') {
      $sort_type ='TYPE_NAME';
    }elseif ($option[0] == 'st3') {
      if ($option[1] == 1) {
        $sort_type ='CAP_MIN ASC, CAP_MAX';
      }else{
        $sort_type ='CAP_MAX DESC, CAP_MIN';
      }
    }elseif ($option[0] == 'st4') {
      $sort_type = 'RM_NUM';
    }else{
      Response::redirect($url,'refresh');
    }
    Session::set('sort_room', $sort_type);

    if ($option[1] == 1) {
      $sort_option = 'ASC';
    }elseif ($option[1] == 2) {
      $sort_option = 'DESC';
    }else{
       Response::redirect($url,'refresh');  
    }
    Session::set('sort_option_room', $sort_option);
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
  *プランの取得、プランページの呼び出し
  *
  **/
  private function show_room($login_id, $option)
  {
    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $room = Model_M_Rtype::forge();

    $all_data_count = $room->get_count($user_data['HTL_ID']);


    $config = array(
        'pagination_url' => 'admin/room/page',
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


    $room_data = $room->get_room_all($option, $user_data['HTL_ID']);
    $room_data_count = count($room_data);

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
      'title' => TITLE_ROOM,
      'rooms' => $room_data,
      'room_data_count' => $room_data_count + $option['offset'],
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
    $this->template->title = TITLE_ROOM;
    $this->template->jsfile = 'room/room.js';
    $this->template->content = View::forge('admin/room/room', $data);

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
      Response::redirect('index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);
    $htl_id = $user_data['HTL_ID'];


    $rtype = Model_M_rtype::forge();
    $type_id = $rtype->insert_rtype(null,$htl_id);
    $result = $htl_id.EXPLODE.$type_id;


    $en = Model_M_rtype_En::forge();
    $en_result = $en->insert_en($htl_id, $type_id);

    $ch = Model_M_rtype_Ch::forge();
    $ch_result = $ch->insert_ch($htl_id, $type_id);

    $chh = Model_M_rtype_Chh::forge();
    $chh_result = $chh->insert_chh($htl_id, $type_id);

    $ko = Model_M_rtype_Ko::forge();
    $ko_result = $ko->insert_ko($htl_id, $type_id);

    Response::redirect('admin/room/edit/'.$result);


  }


  /**
  *
  *部屋タイプ編集ページの呼び出し
  *
  **/
  public function action_edit($code)
  {

    $codes = explode(EXPLODE, $code[0]);

    if (count($codes) != 2) {
      Response::redirect('admin/room');
    }else{
      $htl_id = $codes[0];
      $type_id = $codes[1];
      
    }
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);
    $htl_id = $user_data['HTL_ID'];


    $room = Model_M_Rtype::forge();
    $room_data = $room->get_room_one($htl_id, $type_id);
    $room_data['HtlTypeID'] = $code[0];

    if ($room_data['RM_USE_FLG'] == '1') {
      $use_flg = 'checked';   $unuse_flg = '';
    }else{
      $use_flg = '';          $unuse_flg = 'checked';
    }

    if ($room_data['RM_OPTION'] == '001000') {
      $smoke_flg = '';          $unsmoke_flg = 'checked';
    }else{
      $smoke_flg = 'checked';   $unsmoke_flg = '';
    }

    if ($room_data['GENDER_FLG'] == 1) {
      $man_flg = 'checked'; $woman_flg=""; $both_flg="";
    }else if ($room_data['GENDER_FLG'] == 2) {
      $man_flg=""; $woman_flg="checked"; $both_flg="";
    }else{
      $man_flg="";$woman_flg=""; $both_flg="checked";
    }



    if (file_exists(IMG_FILE_PATH.'rtype_image/rtypeImgHtlID_'.$htl_id.'TypeID_'.$type_id.'_1.png')) {
        $img1 = 'rtype_image/rtypeImgHtlID_'.$htl_id.'TypeID_'.$type_id.'_1.png'; 
    }else{
        $img1 = 'front/noimage.png'; 
    }





    $data = array(
      'title' 	    => TITLE_PLANEDIT,
      'use_flg'     => $use_flg,
      'unuse_flg'   => $unuse_flg,
      'smoke_flg'   => $smoke_flg,
      'unsmoke_flg' => $unsmoke_flg,
      'man_flg'     => $man_flg,
      'woman_flg'   => $woman_flg,
      'both_flg'    => $both_flg,
      'room' 	    => $room_data,
      'htl_id' 	    => $htl_id,
      'type_id'     => $type_id,
      'img1'        => $img1,
      'action' 	    => 'save',
      'error' 	    => Session::get_flash('error'),
      );
    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = TITLE_PLANEDIT;
    $this->template->jsfile = 'room/edit.js';
    $this->template->content = View::forge('admin/room/edit', $data);


  }


  /**
  *
  *プランの保存（newからの遷移）
  *
  **/
  public function action_insert()
  {

    $m_rtypes = $this->preparation_param();
    $m_rtype = Model_M_Rtype::forge();
    $result = $m_rtype->insert_rtype($m_rtypes, $m_rtypes['HTL_ID']);

    Response::redirect('admin/room');
  }  

  /**
  *
  *プランの保存（editからの遷移）
  *
  **/
  public function action_save()
  {

    $m_rtypes = $this->preparation_param();
    $m_rtype = Model_M_Rtype::forge();
    $result = $m_rtype->update_rtype($m_rtypes, $m_rtypes['HTL_ID'], $m_rtypes['TYPE_ID']);

    if ($_FILES['picFile1']['name'] != null) {
      $_FILES['picFile1']['name']= '_1.png';
    }
    $config = array(
        'prefix' => 'rtypeImgHtlID_'.$m_rtypes['HTL_ID'].'TypeID_'.$m_rtypes['TYPE_ID'],
        'path'        => DOCROOT.'assets/img/rtype_image/',
    );
    $this->uploadImg($config);

    Response::redirect('admin/room');
  }

  private function get_htlID()
  {
    $login_id = Session::get('id');

    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    return $user_data['HTL_ID'];
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

  private function preparation_param()
  {
    $post = Input::post();

    $codes = explode(EXPLODE, $post['HtlTypeID']);
    $htl_id = $codes[0];
    $type_id = $codes[1];

    $result = $this->check_post($post);
    if ($result == 1) {
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url,'refresh');
    }

    $m_rtypes=array(
        'HTL_ID'      => $htl_id,
        'TYPE_ID'     => $type_id,
        'TYPE_NAME'   => $post['roomNameJP'],
        'TYPE_NAME_EN'   => $post['roomNameEN'],
        'TYPE_NAME_CH'   => $post['roomNameCH'],
        'TYPE_NAME_CHH'   => $post['roomNameCHH'],
        'TYPE_NAME_KO'   => $post['roomNameKO'],
        'RM_NUM'      => $post['roomNumber'],
        'CAP_MIN'     => $post['capacityNumLower'],
        'CAP_MAX'     => $post['capacityNumUpper'],          
      );

    if ($post['use'] == 0) {
      $m_rtypes['RM_USE_FLG'] = '0';
    }else{
      $m_rtypes['RM_USE_FLG'] = '1';
    }
    if ($post['smoke'] == 1) {
      $m_rtypes['RM_OPTION'] = '001000';
    }else{
      $m_rtypes['RM_OPTION'] = '0';
    }
    if ($post['gender'] == 0) {
      $m_rtypes['GENDER_FLG'] = '0';
    }else if ($post['gender'] == 1) {
      $m_rtypes['GENDER_FLG'] = '1';
    }else if ($post['gender'] == 2) {
      $m_rtypes['GENDER_FLG'] = '2';
    }

    return $m_rtypes;
  }

  /**
  *
  *postに空がないか確認
  *
  **/
  private function check_post($post)
  {
    if (!isset($post['roomNameJP']) || $post['roomNameJP'] == '') {
      Session::set_flash('error','部屋タイプ名が未入力です。');
      return 1;
    }
    if (!isset($post['roomNameCH'])) {
      Session::set_flash('error','簡体字表記が未入力です。');
      return 1;
    }
    if (!isset($post['roomNameCHH'])) {
      Session::set_flash('error','繁体字表記が未入力です。');
      return 1;
    }
    if (!isset($post['roomNameKO'])) {
      Session::set_flash('error','韓国語表記が未入力です。');
      return 1;
    }
    if (!isset($post['roomNameEN'])) {
      Session::set_flash('error','英語表記が未入力です。');
      return 1;
    }
    if (!isset($post['roomNumber']) || $post['roomNumber'] == '') {
      Session::set_flash('error','総提供数が未入力です。');
      return 1;
    }
    if (!isset($post['capacityNumLower']) || $post['capacityNumLower'] == '') {
      Session::set_flash('error','収容人数が未入力です。');
      return 1;
    }
    if (!isset($post['capacityNumUpper']) || $post['capacityNumUpper'] == '') {
      Session::set_flash('error','収容人数が未入力です。');
      return 1;
    }

    return 0;
  }


  /**
  *
  *部屋タイプの削除
  *
  **/
  public function action_delete($code)
  {
    $codes=explode(EXPLODE, $code[0]);
    $htl_id = $codes[0];//htl_id
    $type_id = $codes[1];//type_id

    $room = Model_M_Rtype::forge();
    $room_data = $room->delete_room($htl_id,$type_id);


    $en = Model_M_rtype_En::forge();
    $en_result = $en->delete_en_one($htl_id, $type_id);

    $ch = Model_M_rtype_Ch::forge();
    $ch_result = $ch->delete_ch_one($htl_id, $type_id);

    $chh = Model_M_rtype_Chh::forge();
    $chh_result = $chh->delete_chh_one($htl_id, $type_id);

    $ko = Model_M_rtype_Ko::forge();
    $ko_result = $ko->delete_ko_one($htl_id, $type_id);


    $mpr = Model_M_Plan_Rtype::forge();
    $mpr_result = $mpr->delete_pln_rtype($htl_id, null, $type_id);

    $mpe = Model_M_Plan_Exceptionday::forge();
    $mpe_result = $mpe->delete_exceptionday($htl_id, null, $type_id);

    $rpr = Model_R_Plan_Rmnum::forge();
    $rpr_result = $rpr->delete_pln_rm($htl_id, null, $type_id);

    $mrr = Model_M_Rtype_Roomamount::forge();
    $mrr_resutl = $mrr->delete_roomamount($htl_id, $type_id);

    Response::redirect('admin/room');
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

  public function action_disporderchange()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_type_id']);

    $room = Model_M_Rtype::forge();
    $room->change_disp_order($data['sort_val'],$ids[0],$ids[1]);

  }

  /**
  *
  *利用可否の変更
  *
  **/  
  public function action_salechange()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_type_id']);

    $room = Model_M_Rtype::forge();
    $room->change_sale_flg($data['flg'],$ids[0],$ids[1]);

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
      $plan->delete_plan($param);
    }

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url,'refresh');

  }


  public function action_uploadImg()
    {
      $post = Input::post();
      if(Input::method() === 'POST') {
          Upload::process();
          // 検証
          if (Upload::is_valid())
          {
            // $file['htl_pln_id'] = $htl_pln_id;
            define('IMG_NAME', $post['htl_pln_id']);
            Upload::register('before', function(&$file)
            {
                $file['filename'] =   IMG_NAME.'.png';
                 // $file['path'] .=  $file['filename'][0]. '/'. $file['filename'][1]. '/';
            });
              // 設定を元に保存
            Upload::save();
          }

          // エラー有り
          foreach (Upload::get_errors() as $file)
          {
              // $file['errors']の中にエラーが入っているのでそれを処理
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
