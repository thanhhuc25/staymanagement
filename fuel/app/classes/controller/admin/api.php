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
class Controller_Admin_Api extends Controller_Rest
{
  public function post_chgdayplnsale()
  {
    $data = Input::post();

    $ids = explode(EXPLODE, $data['htl_type_id']);
    $htl_id = $ids[0];
    $type_id = $ids[1];
    $pln_id = $data['pln_id'];
    $date = $data['date'].'_'.$data['day'];
    $date = str_replace("_", "-", $date);
    $date = date('Y-m-d', strtotime($date));
    $flg = $data['flg'];
        

    $rmnum = Model_R_Plan_Rmnum::forge();
    $rmnum_data = $rmnum->get_one_rmnum($htl_id, $pln_id, $type_id, $date);

    if (count($rmnum_data) == 0) {
      $rmnum->insert_rmnum($htl_id, $pln_id, $type_id, $date, $flg);
    }else{
      $rmnum->update_rmnum($htl_id, $pln_id, $type_id, $date, $flg);
    }

    return $this->response($flg);
  }

  public function post_numchange()
  {
    $data = Input::post();   

    $ids = explode(EXPLODE, $data['htl_type_id']);
    $htl_id = $ids[0];
    $type_id = $ids[1];
    $date = $data['date'].'_'.$data['day'];
    $date = str_replace("_", "-", $date);
    $date = date('Y-m-d', strtotime($date));
    $editval = $data['editval'];
    $saledval = $data['saledval'];
    $rmnum = $data['rmnum'];

    if (!preg_match("/^[0-9]+$/", $editval)) {
        return $this->response('0');
    }


    $ryrm = Model_M_Rtype_Roomamount::forge();
    $ryrm_data = $ryrm->get_one_rmamount($htl_id, $type_id, $date);
    $val = $editval - $rmnum + $saledval;
    if (count($ryrm_data) == 0) { 
      $ryrm->insert_rmamount($htl_id, $type_id, $date, 0, $val);
    }else{
      $ryrm->update_rmamount($htl_id, $type_id, $date, null, $val);
    }


    return $this->response();
  }


  public function post_newPlnRt()
  {
    $data = Input::post();
    $pln_rtye = Model_M_Plan_Rtype::forge();
    $rtype_data = Model_M_Rtype::find_one_by(array('HTL_ID' => $data['htl_id'], 'TYPE_ID' => $data['type_id']));

    if (!$rtype_data) {
      return $this->response('0');
    }
    $result = $pln_rtye->insert_pln_rtype($data['htl_id'], $data['pln_id'], $data['type_id'],$rtype_data['CAP_MIN'],$rtype_data['CAP_MAX']);

    return $this->response($rtype_data['CAP_MIN'].'_'.$rtype_data['CAP_MAX']);
  }


  public function post_chgvalPlnRt()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_id']);
    $htl_id = $ids[0];
    $pln_id = $ids[1];
    $ids = explode(EXPLODE, $data['name']);
    $name = $this->name_check($ids[0]);

    $type_id = $ids[1];

    $pln_rtye = Model_M_Plan_Rtype::forge();
    $result = $pln_rtye->update_pln_rtype($htl_id, $pln_id, $type_id, $name, $data['val']);

    return $this->response();   
  }


  public function post_chgvalPlnExday()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_type_id']);
    $htl_id = $ids[0];
    $pln_id = $ids[1];
    $type_id = $ids[2];

    $date = date('Y-m-d', strtotime($data['date']));
    $num = $data['num'];
    $price = $data['val'];
    $pln_exday = Model_M_Plan_Exceptionday::forge();
    $pln_exday_data = $pln_exday->get_one_exday($htl_id, $pln_id, $type_id, $date);


    if (count($pln_exday_data) == 0) {
      $result = $pln_exday->insert_exceptionday($htl_id, $pln_id, $type_id, $date, $num, $price);
    }else{
      $result = $pln_exday->update_exceptionday($htl_id, $pln_id, $type_id, $date, $num, $price);
    }

    return $this->response();
  }


  public function post_newCategory()
  {
    $data = Input::post();

    $category = Model_M_Category::forge();
    $last_category_id = $category->get_count_id($data['htl_id']);


    $new_category = Model_M_Category::forge()->set(array(
          'HTL_ID'           => $data['htl_id'],
          'CATEGORY_ID'      => $last_category_id,
          'CATEGORY_NAME'    => $data['ja'],
          'CATEGORY_USE_FLG' => '0',
          )
      );
    $new_category->save(); 


    $new_category = Model_M_Category_En::forge()->set(array(
          'HTL_ID'           => $data['htl_id'],
          'CATEGORY_ID'      => $last_category_id,
          'CATEGORY_NAME'    => $data['en'],
          'CATEGORY_USE_FLG' => '0',
          )
      );
    $new_category->save();

    $new_category = Model_M_Category_Ch::forge()->set(array(
          'HTL_ID'           => $data['htl_id'],
          'CATEGORY_ID'      => $last_category_id,
          'CATEGORY_NAME'    => $data['ch'],
          'CATEGORY_USE_FLG' => '0',
          )
      );
    $new_category->save();

    $new_category = Model_M_Category_Chh::forge()->set(array(
          'HTL_ID'           => $data['htl_id'],
          'CATEGORY_ID'      => $last_category_id,
          'CATEGORY_NAME'    => $data['tw'],
          'CATEGORY_USE_FLG' => '0',
          )
      );
    $new_category->save();

    $new_category = Model_M_Category_Ko::forge()->set(array(
          'HTL_ID'           => $data['htl_id'],
          'CATEGORY_ID'      => $last_category_id,
          'CATEGORY_NAME'    => $data['ko'],
          'CATEGORY_USE_FLG' => '0',
          )
      );
    $new_category->save();


    return $this->response($last_category_id);    
  }

  public function post_chgvalCategory()
  {
    $data = Input::post();

    $category = Model_M_Category::forge();
    $result = $category->update_category($data['htl_id'], $data['category_id'], $data['kbn'], $data['val']);


    return $this->response($data['val']);
  }



  /*予約管理詳細画面で使用*/
  public function post_resendMail()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_rsv']);
    $h_id = $ids[0];
    $r_no = $ids[1];

    $rsv = Model_T_Rsv::forge();
    $rsv_data = $rsv->get_list(array('t_rsvs.HTL_ID' => $h_id, 't_rsvs.RSV_NO' => $r_no), array(), null, null,null);
    $user = Model_M_Usr::find_by_pk($rsv_data[0]['USR_ID']);
    $htl_data = Model_M_Htl::find_by_pk($h_id);


    $body = $this->make_mail_body($r_no, $htl_data['MAIL_CFM'], $h_id);

    $mail = array(
      'from' => $htl_data['HTL_MAIL'],
      'to' => $user['USR_MAIL'],
      'subject' => '予約完了メール',
      'body' => $body,
      );


      $email = Email::forge();
      $email->from($mail['from']);
      $email->to($mail['to']);

      $email->subject($mail['subject']);
      $email->body($mail['body']);

      $email->priority(\Email::P_HIGH);

      try {
        $email->send();

      } catch (\EmailValidationFailedException $e) {
        return $this->response('1');   

      } catch(\EmailSendingFailedException $e){
        return $thiws->response('2');      
      }

      return $this->response('0');


    // $from = MAIL_SENDER;
    // $to = $user['USR_MAIL'];
    // $subject = '予約完了';
    // $body = '予約完了';

    // $email = Email::forge();
    // $email->from($from);
    // $email->to($to);

    // $email->subject($subject);
    // $email->body($body);

    // $email->priority(\Email::P_HIGH);

    // try {
    //   $email->send();

    // } catch (\EmailValidationFailedException $e) {
    //   return 'メールの検証に失敗しました。';       

    // } catch(\EmailSendingFailedException $e){
    //   return 'メールの送信に失敗しました。';
    
    // }

    // return $this->response();   
  }



  public function get_csv() {
    $data = Input::get();
    $this->format = "csv";
    
    $start = date('Y-m-d', strtotime($data['start']));
    $end  = date('Y-m-d', strtotime($data['end']));

    $end2 = date('Y-m-d', strtotime($start." +1 month"));

    if ($start > $end || $end > $end2) {
      Session::set_flash('error','日付の入力が不正です');
      $url = $_SERVER['HTTP_REFERER'];
      Response::redirect($url,'refresh');  
    }


    $htl_id = $data['htl_id'];
    $type = $data['type'];

    $where = array(
      't_rsvs.HTL_ID' => $htl_id,
      );

    $between = array();
    if ($type == 1) {
      $between['t_rsvs.RSV_DATE'] = array('0' => $start, '1' => $end);
    }else{
      $between['t_rsvs.IN_DATE'] = array('0' => $start, '1' => $end);
    }


    $rsv = Model_T_Rsv::forge();
    $rsv_data = $rsv->get_list($where, $between, null, null, null);

    if (count($rsv_data) == 0) {
        
      $result = array(
        '0' => array(
          '施設ID'   => '',
          '施設名称'  => '',
          '予約番号'  => '',
          '予約日時'  => '',
          '更新日時'  => '',
          '予約者名'  => '',
          'ゲスト名'   => '',
          'チェックイン'  => '',
          'チェックアウト' => '',
          '泊数'      => '',
          'ステータス'   => '',
          'プラン名'    => '',
          'タイプ名'    => '',
          '支払方法'   => '',
          '料金'      => '',
          '室数'      => '',
          '会員NO'    => '',
          '決済コード'  => '',
          ));
    }

    foreach ($rsv_data as $key => $value) {
      $result[$key]['施設ID']   = $value['HTL_ID'];
      $result[$key]['施設名称']  = $value['HTL_NAME'];
      $result[$key]['予約番号']  = 'stm'.$value['RSV_NO'];
      $result[$key]['予約日時']  = $value['RSV_DATE'];
      $result[$key]['更新日時']  = $value['UP_DATE'];
      $result[$key]['予約者名']  = $value['USR_NAME'];
      $result[$key]['ゲスト名']   = $value['USR_NAME'];
      $result[$key]['チェックイン']  = date('Y-m-d', strtotime($value['IN_DATE']));
      $result[$key]['チェックアウト'] = date('Y-m-d', strtotime($value['OUT_DATE']));
      $result[$key]['泊数']      = $value['NUM_STAY'];
      $result[$key]['ステータス']   = $value['STATUS'];
      $result[$key]['プラン名']    = $value['PLN_NAME'];
      $result[$key]['タイプ名']    = $value['TYPE_NAME'];
      $result[$key]['支払方法']   = $value['ADJUST_TYPE_NAME'];
      $result[$key]['料金']      = $value['PLN_CHG_TOTAL'];
      $result[$key]['室数']      = $value['NUM_ROOM'];
      $result[$key]['会員NO']    = $value['USR_ID'];
      $result[$key]['決済コード']  = $value['ORDER_CD'];
    }


    $filename = date('Y-m-d');

    $this->response->set_header('Content-Type', 'application/csv');
    $this->response->set_header('Content-Disposition', 'attachment; filename="'.$filename.'.csv"');

    return $this->response($result);

  }


  public function post_deletePlnRt()
  {
    $data = Input::post();
    $ids = explode(EXPLODE, $data['htl_pln_type_id']);
    $htl_id = $ids[0];
    $pln_id = $ids[1];
    $type_id = $ids[2];

    $pln_rtye = Model_M_Plan_Rtype::forge();
    $result = $pln_rtye->delete_pln_rtype($htl_id, $pln_id, $type_id);

    return $this->response();   
  }


  private function make_mail_body($r_no, $body, $htl_id)
  {

    $rsv_data = Model_T_Rsv::find_one_by(array('HTL_ID' => $htl_id, 'RSV_NO' => $r_no));
    $rsv_detail_data = Model_T_Rsv_detail::find_one_by(array('HTL_ID' => $htl_id, 'RSV_NO' => $r_no));
    $plan_data = Model_M_Plan::find_one_by(array('HTL_ID' => $htl_id, 'PLN_ID' => $rsv_data['PLN_ID']));
    $htl_data = Model_M_Htl::find_by_pk($htl_id);
    $user = Model_M_Usr::find_by_pk($rsv_data['USR_ID']);


    $adjust_type_name = '';
    if ($rsv_data['ADJUST_TYPE'] == '1') {
      $adjust_type_name = 'フロント決済';
    }else if ($rsv_data['ADJUST_TYPE'] == '2') {
      $adjust_type_name = 'カード決済';
    }

    $week = array(
                  "日",  //日
                  "月",  //月
                  "火",  //火
                  "水",  //水
                  "木",  //木
                  "金",  //金
                  "土"   //土
                  );

    $datetime = new DateTime(date('Y-m-d', strtotime($rsv_data['UP_DATE'])));
    $w = (int)$datetime->format('w');
    $u_d = $week[$w];

    $datetime = new DateTime(date('Y-m-d', strtotime($rsv_data['CANCEL_DATE'])));
    $w = (int)$datetime->format('w');
    $c_d = $week[$w];

    $datetime = new DateTime(date('Y-m-d', strtotime($rsv_data['IN_DATE'])));
    $w = (int)$datetime->format('w');
    $ci_d = $week[$w];

    $datetime = new DateTime(date('Y-m-d', strtotime($rsv_data['OUT_DATE'])));
    $w = (int)$datetime->format('w');
    $co_d = $week[$w];

    $before_word = array(
      "[受付日]", 
      "[キャンセル日]", 
      "[ホテル名]", 
      "[予約番号]", 
      "[チェックイン予定日]", 
      "[チェックイン時刻]", 
      "[チェックアウト予定日]", 
      "[プラン名]", 
      "[部屋タイプ名]", 
      "[プラン内容]", 
      "[人数]", 
      "[子供人数]", 
      "[室数]", 
      "[泊数]", 
      "[チェックイン]", 
      "[宿泊者名]",
      "[料金]", 
      "[支払い方法]",
      "[キャンセルポリシー]",
      "[施設メールアドレス]"
      );


    $after_word   = array(
      date('Y年n月j日', strtotime($rsv_data['UP_DATE'])) . '('. $u_d .')',
      date('Y年n月j日', strtotime($rsv_data['CANCEL_DATE'])) . '('. $c_d .')',
      $htl_data['HTL_NAME'], 
      'stm'.$rsv_data['RSV_NO'], 
      date('Y年n月j日', strtotime($rsv_data['IN_DATE'])) . '('. $ci_d .')',
      $rsv_data['IN_DATE_TIME'],
      date('Y年n月j日', strtotime($rsv_data['OUT_DATE'])). '('. $co_d .')',
      $rsv_data['PLN_NAME'], 
      $rsv_detail_data['TYPE_NAME'], 
      $plan_data['PLN_CAP_PC_LIGHT'], 
      $rsv_detail_data['PLN_NUM_MAN'] + $rsv_detail_data['PLN_NUM_WOMAN'], 
      $rsv_detail_data['PLN_NUM_CHILD1'] + $rsv_detail_data['PLN_NUM_CHILD2'] + $rsv_detail_data['PLN_NUM_CHILD3'] + $rsv_detail_data['PLN_NUM_CHILD4'] + $rsv_detail_data['PLN_NUM_CHILD5'] + $rsv_detail_data['PLN_NUM_CHILD6'], 
      $rsv_data['NUM_ROOM'], 
      $rsv_data['NUM_STAY'], 
      $rsv_data['IN_DATE_TIME'], 
      $user['USR_NAME'], 
      number_format($rsv_data['PLN_CHG_TOTAL']), 
      $adjust_type_name,
      $htl_data['CCL_RULE'],
      $htl_data['HTL_MAIL']
      );

    $after_txt = str_replace($before_word, $after_word, $body);


    return $after_txt;
  }


  private function name_check($name)
  {
    if ($name == 'capacityNumMin') {
      $result = 'PLN_MIN';
    }elseif ($name == 'capacityNumMax') {
      $result = 'PLN_MAX';
    }elseif ($name == 'price1' ) {
      $result = 'PLN_CHG_PERSON1';
    }elseif ($name == 'price2' ) {
      $result = 'PLN_CHG_PERSON2';
    }elseif ($name == 'price3' ) {
      $result = 'PLN_CHG_PERSON3';
    }elseif ($name == 'price4' ) {
      $result = 'PLN_CHG_PERSON4';
    }elseif ($name == 'price5' ) {
      $result = 'PLN_CHG_PERSON5';
    }elseif ($name == 'price6' ) {
      $result = 'PLN_CHG_PERSON6';
    }elseif ($name == 'child1' ) {
      $result = 'PLN_FLG_CHILD1';
    }elseif ($name == 'child2' ) {
      $result = 'PLN_FLG_CHILD2';
    }elseif ($name == 'child3' ) {
      $result = 'PLN_FLG_CHILD3';
    }elseif ($name == 'child4' ) {
      $result = 'PLN_FLG_CHILD4';
    }elseif ($name == 'child5' ) {
      $result = 'PLN_FLG_CHILD5';
    }elseif ($name == 'child6' ) {
      $result = 'PLN_FLG_CHILD6';
    }elseif ($name == 'childprice1' ) {
      $result = 'PLN_VAL_CHILD1';
    }elseif ($name == 'childprice2' ) {
      $result = 'PLN_VAL_CHILD2';
    }elseif ($name == 'childprice3' ) {
      $result = 'PLN_VAL_CHILD3';
    }elseif ($name == 'childprice4' ) {
      $result = 'PLN_VAL_CHILD4';
    }elseif ($name == 'childprice5' ) {
      $result = 'PLN_VAL_CHILD5';
    }elseif ($name == 'childprice6' ) {
      $result = 'PLN_VAL_CHILD6';
    }elseif ($name == 'cal1' ) {
      $result = 'PLN_CAL_CHILD1';
    }elseif ($name == 'cal2' ) {
      $result = 'PLN_CAL_CHILD2';
    }elseif ($name == 'cal3' ) {
      $result = 'PLN_CAL_CHILD3';
    }elseif ($name == 'cal4' ) {
      $result = 'PLN_CAL_CHILD4';
    }elseif ($name == 'cal5' ) {
      $result = 'PLN_CAL_CHILD5';
    }elseif ($name == 'cal6' ) {
      $result = 'PLN_CAL_CHILD6';
    }elseif ($name == 'asadult1' ) {
      $result = 'PLN_CNT_CHILD1';
    }elseif ($name == 'asadult2' ) {
      $result = 'PLN_CNT_CHILD2';
    }elseif ($name == 'asadult3' ) {
      $result = 'PLN_CNT_CHILD3';
    }elseif ($name == 'asadult4' ) {
      $result = 'PLN_CNT_CHILD4';
    }elseif ($name == 'asadult5' ) {
      $result = 'PLN_CNT_CHILD5';
    }elseif ($name == 'asadult6' ) {
      $result = 'PLN_CNT_CHILD6';
    }else{
      $result = '';
    }
    
    return $result;
  }


}
