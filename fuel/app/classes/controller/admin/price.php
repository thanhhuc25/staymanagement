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
class Controller_Admin_Price extends Controller_Common
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

    $plan = Model_M_Plan::forge();
    $count = $plan->get_count(null, $user_data['HTL_ID']);
    $option = array(
      'limit' => $count,
      );
    /*全件取得*/
    $plan_data = $plan->get_plan_all($option, $user_data['HTL_ID']);
    // $plan_data = $plan->get_plan_rtype($user_data['HTL_ID']);

    $year = date('Y');
    $month = date('n');

    if (count($plan_data) == 0) {
        Session::set_flash('error','プランがありません。プランを追加してください。');
        Response::redirect('admin/plan'); 
    }


    $this->show_price($user_data, $plan_data, $plan_data[0],  $year, $month);
  }


  public function action_price($data)
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
    $pln_id = $ids[1];

    $plan = Model_M_Plan::forge();
    $count = $plan->get_count(null, $user_data['HTL_ID']);
    $option = array(
      'limit' => $count,
      );
    /*全件取得*/
    $plan_data = $plan->get_plan_all($option, $user_data['HTL_ID']);

    $selected_plan = array();
    foreach ($plan_data as $key => $value) {
      if ($value['PLN_ID'] == $pln_id) {
        $selected_plan = $value;
      }
    }


    $dates =explode(EXPLODE, $data[1]); 

    $year = $dates[0];
    $month = $dates[1];

    // $plan_rtype_exceptionday_data



    $this->show_price($user_data, $plan_data, $selected_plan,  $year, $month);
  }



  private function show_price($user_data, $plan_data, $plan_data_one,  $year, $month)
  {

    $year_list = array();
    $month_list = array();

    for($i=2000; $i < $year+5; $i++){
      $year_list[] = $i;
    }

    for ($i=1; $i <= 12; $i++) { 
      $month_list[] = $i;
    }

    // $plan_rtype = Model_M_Plan_Rtype::forge();
    // $plan_rtype_exceptionday_data = $plan_rtype->get_plan_rtype_exceptionday($plan_data_one['HTL_ID'], $plan_data_one['PLN_ID']);

    $plan_rtype = Model_M_Plan_Rtype::forge();
    $plan_rtype_data = $plan_rtype->get_plan_allrtype($plan_data_one['HTL_ID'],$plan_data_one['PLN_ID']);

    $s = date('Y-m-d', strtotime($year.'-'.$month.'-1'));
    $e = date('Y-m-d', strtotime($year.'-'.$month.'-31'));

    $plan_rtype_list = array();
    $plan_exceptionday = Model_M_Plan_Exceptionday::forge();
    $plnexday_data = $plan_exceptionday->get_exceptionday($plan_data_one['HTL_ID'], $plan_data_one['PLN_ID'], $s, $e);
    foreach ($plan_rtype_data as $key => $value) {
        $plan_rtype_list[$key] = array(
            'HTL_ID' => $value['HTL_ID'],
            'PLN_ID' => $value['PLN_ID'],
            'TYPE_ID' => $value['TYPE_ID'],
            'TYPE_NAME' => $value['TYPE_NAME'],
            'PLN_CHG_PERSON1' => $value['PLN_CHG_PERSON1'],
            'PLN_CHG_PERSON2' => $value['PLN_CHG_PERSON2'],
            'PLN_CHG_PERSON3' => $value['PLN_CHG_PERSON3'],
            'PLN_CHG_PERSON4' => $value['PLN_CHG_PERSON4'],
            'PLN_CHG_PERSON5' => $value['PLN_CHG_PERSON5'],
            'PLN_CHG_PERSON6' => $value['PLN_CHG_PERSON6'],
            'EXCEPTIONDAYS' => array(),
          );

        if ($value['PLN_MIN'] == '' || $value['PLN_MIN'] == null) {
          $plan_rtype_list[$key]['CAP_MIN'] = $value['CAP_MIN'];
        }else{
          $plan_rtype_list[$key]['CAP_MIN'] = $value['PLN_MIN'];
        }


        if ($value['PLN_MAX'] == '' || $value['PLN_MAX'] == null) {
          $plan_rtype_list[$key]['CAP_MAX'] = $value['CAP_MAX'];
        }else{
          $plan_rtype_list[$key]['CAP_MAX'] = $value['PLN_MAX'];
        }


//isset( $plan_rtype_list[$key]['EXCEPTIONDAYS'][$value['EXCEPTIONDAY']] )
        foreach ($plnexday_data as $k => $val) {
            if ( $val['HTL_ID']== $value['HTL_ID'] && $val['PLN_ID']==$value['PLN_ID'] && $val['TYPE_ID']==$value['TYPE_ID']) {
              $dates =explode('-', $val['EXCEPTIONDAY'] ); 

              $plan_rtype_list[$key]['EXCEPTIONDAYS'][intval($dates[2])] = array(
                'PLN_CHG_EXCEPTION1' => $val['PLN_CHG_EXCEPTION1'],
                'PLN_CHG_EXCEPTION2' => $val['PLN_CHG_EXCEPTION2'],
                'PLN_CHG_EXCEPTION3' => $val['PLN_CHG_EXCEPTION3'],
                'PLN_CHG_EXCEPTION4' => $val['PLN_CHG_EXCEPTION4'],
                'PLN_CHG_EXCEPTION5' => $val['PLN_CHG_EXCEPTION5'],
                'PLN_CHG_EXCEPTION6' => $val['PLN_CHG_EXCEPTION6'],
                'NUM' => $val['NUM'],

                );
            }
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
    $week = array("0", "1", "2", "3", "4", "5", "6");
    $w = (int)$datetime->format('w');
    $empty = $week[$w];

    $data = array(
      'title' => TITLE_PRICE,
      'plan' => $plan_data,
      'year_list' => $year_list,
      'month_list' => $month_list,
      'selected_plan' => $plan_data_one,
      'selected_year' => $year,
      'selected_month' => $month,
      'days_in_month' => $days_in_month,
      'empty' => $empty,
      'rtype' => $plan_rtype_list,
      'holiday_list' => $holiday_list,
      );
    $this->template->name = $user_data['ADMIN_ID'];
    $this->template->title = TITLE_PRICE;
    $this->template->jsfile = 'price/price.js';
    $this->template->content = View::forge('admin/price', $data);

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
