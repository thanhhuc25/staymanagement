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
class Controller_Admin_Stock extends Controller_Common
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
    $rtype = Model_M_Rtype::forge();
    $count = $rtype->get_count($user_data['HTL_ID']);
    $option = array(
      'limit' => $count,
      );
    /*全件取得*/
    $rtype_data = $rtype->get_room_all($option, $user_data['HTL_ID']);
    // $rtype_data = $plan->get_rtype_rtype($user_data['HTL_ID']);

    $year = date('Y');
    $month = date('n');

    if (count($rtype_data) == 0) {
        Session::set_flash('error','部屋タイプがありません。部屋タイプを追加してください。');
        Response::redirect('admin/room'); 
    }

    $this->show_stock($user_data, $rtype_data, $rtype_data[0],  $year, $month);
  }


  public function action_stock($data)
  {
    $login_id = Session::get('id');
    if ($login_id == null) {
      Response::redirect('admin/index');
    }

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($login_id);
    $htl = Model_M_htl::forge();
    $user_data = $htl->get_user($login_id);

    $ids = explode(EXPLODE, $data[0]);

    $htl_id = $ids[0];
    $type_id = $ids[1];

    $plan = Model_M_Rtype::forge();
    $count = $plan->get_count($user_data['HTL_ID']);
    $option = array(
      'limit' => $count,
      );
    /*全件取得*/
    $rtype_data = $plan->get_room_all($option, $user_data['HTL_ID']);

    $selected_rtype = array();
    foreach ($rtype_data as $key => $value) {
      if ($value['TYPE_ID'] == $type_id) {
        $selected_rtype = $value;
      }
    }


    $dates =explode(EXPLODE, $data[1]); 

    $year = $dates[0];
    $month = $dates[1];

    $this->show_stock($user_data, $rtype_data, $selected_rtype,  $year, $month);
  }



  private function show_stock($user_data, $rtype_data, $rtype_data_one,  $year, $month)
  {
    $year_list = array();
    $month_list = array();

    for($i=2000; $i < $year+5; $i++){
      $year_list[] = $i;
    }

    for ($i=1; $i <= 12; $i++) { 
      $month_list[] = $i;
    }

    /*
     * 必要なデータの取得
     */
    $plan_rtype = Model_M_Rtype::forge();
    $plan_data = $plan_rtype->get_allplan_rtype($user_data['HTL_ID'], $rtype_data_one['TYPE_ID']);

    $roomamount = Model_M_Rtype_Roomamount::forge();
    $rmaount_data = $roomamount->get_all_rmamount($user_data['HTL_ID'], $rtype_data_one['TYPE_ID']);

    $exday = Model_R_Plan_Rmnum::forge();
    $exday_data = $exday->get_all_rmnum($user_data['HTL_ID'], $rtype_data_one['TYPE_ID']);

    $t_rsv = Model_T_Rsv::forge();
    $rsv_data = $t_rsv->get_all_rsv($rtype_data_one['HTL_ID'],$rtype_data_one['TYPE_ID'],$year, $month );    


    /**

      日ごとの売り上げのリスト      
      プランと日ごとの売り上げのリスト 　

    */
    $day_saled = array();
    $saled_list = array();
    foreach ($rsv_data as $key => $value) {
      if ($value['STAYDATE'] != '') {
        $dates =explode('-', $value['STAYDATE']);
        $day = intval($dates[2]);

        if (isset($saled_list[$value['PLN_ID']][$day])) {
          $saled_list[$value['PLN_ID']][$day]  += 1;
        }else{
          $saled_list[$value['PLN_ID']][$day] = 1;
        }

        if (isset($day_saled[$day])) {
          $day_saled[$day] += 1;
        }else{
          $day_saled[$day] = 1;
        }
      }
    }

    /**

      日ごとの販売停止フラグリスト      
      日ごとの残室のリスト 　

    */
    $stop_list = array();
    $stock_list = array();
    foreach ($rmaount_data as $key => $value) {
      $dates =explode('-', $value['SETTING_DAY']);
      if ($dates[0] == $year && intval($dates[1]) == $month && $value['STOP_FLG'] == 1) {
        $stop_list[] = $dates[2];
      }
      $day = intval($dates[2]);
      if ($dates[0] == $year && intval($dates[1]) == $month && isset($stock_list[$day])) {
        $stock_list[$day] += $value['NUM'];
      }else if($dates[0] == $year && intval($dates[1] == $month)){
        $stock_list[$day] = $value['NUM'];
      }
    }


    /**
        プランと日ごとの停止フラグ
        プランと日ごとの販売フラグ     この二つのリストは日ごとの販売停止フラグよりも優先される       
        販売中プラン
        販売停止プラン

    */
    $stop_list_priority = array(); 
    $use_list_priority = array();
    $use_plan_data = array();
    $unuse_plan_data = array();
    foreach ($plan_data as $key => $value) {
      $stop_list_priority[$value['PLN_ID']][] = null ;
      $use_list_priority[$value['PLN_ID']][] = null;
      if ($value['PLN_USE_FLG'] == 0) {
        $unuse_plan_data[$key] = $value;
      }elseif ($value['PLN_USE_FLG'] == 1) {
        $use_plan_data[$key] = $value;
      }
    }
    foreach ($exday_data as $key => $value) {
      $dates =explode('-', $value['EXCEPTIONDAY']);
      if ($dates[0] == $year && intval($dates[1]) == $month && $value['STOP_FLG'] == '1') {
        $stop_list_priority[$value['PLN_ID']][] = $dates[2];
      }elseif ($dates[0] == $year && intval($dates[1]) == $month && $value['STOP_FLG'] == '0') {
         $use_list_priority[$value['PLN_ID']][] = $dates[2];
      }
    }


    $holiday = $this->japan_holiday($year);
    if (isset($holiday[$month])) {
      $holiday_list = $holiday[$month];
    }else{
      $holiday_list = array();
    }

    $days_in_month = Date::days_in_month($month, $year);
    $date = $year.'-'.$month.'-01';
    $datetime = new DateTime($date);
    $week = array("1", "7", "6", "5", "4", "3", "2");
    $w = (int)$datetime->format('w');
    $sun_start = $week[$w];

    $data = array(
      'title' => TITLE_STOCK,
      'un_use_plan' => $unuse_plan_data,
      'use_plan' => $use_plan_data,
      // 'plan' => $plan_data,
      'year_list' => $year_list,
      'month_list' => $month_list,
      'selected_rtype' => $rtype_data_one,
      'selected_year' => $year,
      'selected_month' => $month,
      'days_in_month' => $days_in_month,
      'sun_start' => $sun_start,
      'rtype' => $rtype_data,
      'stop_list' => $stop_list,
      'use_list_priority' => $use_list_priority,
      'stop_list_priority' => $stop_list_priority,
      'saled_list' => $saled_list,
      'day_saled_list' => $day_saled,
      'stock_list' => $stock_list,
      'holiday_list' => $holiday_list,
      );
    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = TITLE_STOCK;
    $this->template->jsfile = 'stock/stock.js';
    $this->template->content = View::forge('admin/stock', $data);

  }

  public function action_chgsale($data)
  {
    if (count($data) == 2) {
      $ids =explode(EXPLODE, $data[0]);
      $params = array(
        '0' => $ids,        //htl_id, pln_id
        );

      $flg = $data[1];

      $plan = Model_M_Plan::forge();
      $plan->change_sale_flg($flg, $params);
    }

    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url,'refresh');
  }

  
  public function action_chgdaysale($data)
  {
    if (count($data) == 4) {
        $ids = explode(EXPLODE, $data[0]);
        $htl_id = $ids[0];
        $type_id = $ids[1];

        $date = $data[1].'_'.$data[2];
        $date = str_replace("_", "-", $date);
        $date = date('Y-m-d', strtotime($date));
        
        $flg = $data[3];

        $roomamount = Model_M_Rtype_Roomamount::forge();
        $rmaount_data = $roomamount->get_one_rmamount($htl_id, $type_id, $date);
        if (count($rmaount_data) != 0 ) {
           $roomamount->update_rmamount($htl_id, $type_id, $date, $flg, null);
        }else{
           $roomamount->insert_rmamount($htl_id, $type_id, $date, $flg, 0);
        }

        $exday = Model_R_Plan_Rmnum::forge();
        $exday->update_rmnum_all($htl_id, $type_id, $date, $flg);
    }
    $url = $_SERVER['HTTP_REFERER'];
    Response::redirect($url,'refresh');
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
