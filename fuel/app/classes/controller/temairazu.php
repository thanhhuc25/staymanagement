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
class Controller_Temairazu extends Controller_Rest
{  
  
  public function Action_tema000()
  {
    $this->format = 'html';
    $data = Input::post();
    // $data = Input::get();
    $msg = '';
    if (!isset($data['LoginID']) || $data['LoginID'] == '' ) {
      $msg = '"NG","LoginID is empty."';
    }
    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
      $msg = '"NG","LoginPass is empty."';
    }

    if ($msg != '' ) {
      $this->response->set_header('Content-Type', 'text/html; charset=UTF-8');
      return $this->response($msg);
    }

    $htl = Model_M_Htl::forge();
    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      $msg = '"NG","Invalid LoginID or loginPass"';
    }else{
      $msg = '"OK"';      
    }

    $this->response->set_header('Content-Type', 'text/html; charset=UTF-8');
    return $this->response($msg);
  }


  public function Action_tema130()
  {
    $this->format = 'html';
    $data = Input::post();
    // $data = Input::get();
    $data = $this->data_check($data);
    if (count($data) == 1) {
      return $this->response('"NG","'.$data.'"');
    }


    $rtype = Model_M_Rtype::forge();
    $rtype_data = $rtype->get_rtype_status($data);
    if ($rtype_data == 0) {
      // $result = array('NG' => 'no data', );
         $result = '"NG","no data"';
    }else{
      // $result = array('HeyaID' => $data['HeyaID'],
      //                 'DayStart' => date('Y-m-d', strtotime('first day of ' . $data['DayStart'])),//$data['DayStart'],
      //                 'DayEnd' => date('Y-m-d', strtotime('last day of ' . $data['DayEnd'])),//$data['DayEnd'],
      //                 );
      // $result += $rtype_data;
      $start = date('Y/m/d', strtotime('first day of ' . $data['DayStart']));
      $last = date('Y/m/d', strtotime('last day of ' . $data['DayEnd']));

      $result = '"'.$data['HeyaID'].'","'.$start.'","'.$last.'"';

      $first = key(array_slice($rtype_data, 0, 1, true));
      $last  = key(array_slice($rtype_data, -1, 1, true));
      foreach ($rtype_data as $key => $value) {
        if ($key == $first) {
          $q = ',"';  
        }else{
          $q = '","';  
        }
        $result .= $q.$value;
        if ($key == $last) {
          $result .= '"';  
        }
      }
    }

    $this->response->set_header('Content-Type', 'text/html; charset=UTF-8');
    // return $this->response(array_values($result));
    return $this->response($result);
  }



  public function Action_tema135()
  {
    $this->format = 'html';
    $data = Input::post();
    // $data = Input::get();
    $data = $this->data_check($data);
    if (count($data) == 1) {
      return $this->response('"NG","'.$data.'"');
    }
    if (!isset($data['PlanID'])  || $data['PlanID'] == '') {
      return $this->response('"NG","PlanID is empty."');
    }


    $plan_type = Model_M_Plan_Rtype::forge();
    $plan_type_data = $plan_type->get_plan_rtype_for_api($data);

    if ($plan_type_data == 0) {
      $result = '"NG","no data"';
    }else{
      // $result = array( $data['HeyaID'],
      //                  $data['PlanID'],
      //                  date('Y-m-d', strtotime('first day of ' . $data['DayStart'])),//$data['DayStart'],
      //                  date('Y-m-d', strtotime('last day of ' . $data['DayEnd'])),//$data['DayEnd'],
      //                 );

      $result = '"'.$data['HeyaID'].'","'.
                       $data['PlanID'].'","'.
                       date('Y/m/d', strtotime('first day of '.$data['DayStart'])).'","'.
                       date('Y/m/d', strtotime('last day of '.$data['DayEnd'])).'"';
      // $result += $plan_type_data;
      foreach ($plan_type_data as $key => $value) {
        $result .= ',"'.$value.'"';
      }
    }


    // $this->response->set_header('Content-Type', 'text/html; charset=UTF-8');
    return $this->response( $result);
  }



  public function Action_tema005()
  {
    $this->format = 'html';
    $data = Input::post();
    // $data = Input::get();
    
    if (!isset($data['LoginID']) || $data['LoginID'] == '') {
        return $this->response('"NG","LoginID is empty."');
    }

    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
        return $this->response('"NG","LoginPass is empty."');
    }



    $login = Model_M_Co_Login::forge();
    $htl = Model_M_Htl::forge();

    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      return $this->response('"NG","Invalid LoginID or loginPass."');
    }


    $rtype = Model_M_Rtype::forge();
    $rtype_data = $rtype->get_room_all(array('limit' => 99999, 'sort' => 'TYPE_ID', 'sort_option' => 'DESC'), $user_data['HTL_ID']);


    if (count($rtype_data) == 0) {
      return $this->response('Null');
    }


    // $result = array();
    $result = '';
    foreach ($rtype_data as $key => $value) {
      // $result[$key]['HeyaID'] = $value['TYPE_ID'];
      // $result[$key]['HeyaName'] = $value['TYPE_NAME'];    
      $res_flg = '1';
      if ($value['RM_USE_FLG'] == '0') {
        $res_flg = '0';
      }

      if ($res_flg == '1')  {
        $ru = Model_M_Plan_Rtype::find_one_by(array(
            'HTL_ID'  => $user_data['HTL_ID'],
            'TYPE_ID' => $value['TYPE_ID'],
        ));
        if (count($ru) == 0) {
          $res_flg = '0';
        }
      }

      if ($res_flg == '1')  {
        $result .= '"'.$value['TYPE_ID'].'","'.$value['TYPE_NAME'].'"'."\n";
      }
    }

    if ($result == '') {
      $result = 'Null';
    }

    // $this->response->set_header('Content-Type', 'application/csv');
    // $this->response->set_header('Content-Disposition', 'attachment; filename="'.date('Y-m-d').'.csv"');
    // return $this->response(Format::forge($result)->to_csv());
    return $this->response($result);
  }




  public function Action_tema010()
  {
    $this->format = 'html';
    $data = Input::post();
    // $data = Input::get();
    
    if (!isset($data['LoginID']) || $data['LoginID'] == '') {
        return $this->response('"NG","LoginID is empty."');
        // return $this->response(array('NG' => 'LoginID is empty.', ));
    }

    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
        return $this->response('"NG","LoginPass is empty."');
        // return $this->response(array('NG' => 'LoginPass is empty.', ));
    }

    if (!isset($data['HeyaID']) || $data['HeyaID'] == '') {
        return $this->response('"NG","HeyaID is empty."');
        // return $this->response(array('NG' => 'HeyaID is empty.', ));
    }


    $login = Model_M_Co_Login::forge();
    $htl = Model_M_Htl::forge();
    $secret = Model_M_Secret::forge();

    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      return $this->response('"NG","Invalid LoginID or loginPass."');
      // return $this->response(array('NG' => 'Invalid LoginID or loginPass.', ));
    }


    $plan_rtype = Model_M_Plan_Rtype::forge();
    $plan_data = $plan_rtype->get_allplan_rtype($user_data['HTL_ID'], $data['HeyaID']);
    if (count($plan_data) == 0) {
      // return $this->response(array('NG' => 'Null.', ));


      $rm = Model_M_Rtype::find_one_by(array('HTL_ID' => $user_data['HTL_ID'], 'TYPE_ID' => $data['HeyaID']));
      if ($rm) {
        return $this->response('"Null"');  
      }else{
        return $this->response('"NG","Invalid HeyaID"');
      }
      
    }

    $result = array();
    $result = '';
    foreach ($plan_data as $key => $value) {
      // $res_flg = '1';
      // $ru = Model_M_Plan_Rtype::find_one_by(array(
      //     'HTL_ID' => $user_data['HTL_ID'],
      //     'PLN_ID' => $value['PLN_ID'],
      // ));
      // if (count($ru) == 0) {
      //   $res_flg = '0';
      // }
      // $result[$key]['PlanID']         = $value['PLN_ID'];
      // $result[$key]['PlanName']       = $value['PLN_NAME'];
      $date = date('Y/m/d', strtotime($value['PLAN_START'])).'-'.date('Y/m/d', strtotime($value['PLAN_END']));
      // $result[$key]['OfferPeriod']    = $date;
      // $result[$key]['PlanActiveFlg']  = $value['PLN_USE_FLG'];
      // $result[$key]['ChargeType']     = '0';
      if ($value['PLN_MIN'] == $value['PLN_MAX']) {
          $num = '"'.$value['PLN_MIN'].'"';
      }else{
          $num = '';
          for($i = $value['PLN_MIN']; $i<=$value['PLN_MAX']; $i++){
              $num .= '"'.$i.'"';
              if ($i != $value['PLN_MAX']) {
                $num .= ',';
              }
          }
          // $num = $value['PLN_MIN'].'-'.$value['PLN_MAX'];
      }
      // $result[$key]['NumKbn']         = $num;
      // if ($res_flg == '1') {
        $result .= '"'.$value['PLN_ID'].'","'.$value['PLN_NAME'].'","'.$date.'","'.$value['PLN_USE_FLG'].'","0'.'",'.$num.''."\n";
      // }
      //

      $secret_data = $secret->get_plan_all(array(), $user_data['HTL_ID'], $value['PLN_ID']);
      if ($secret_data) {
        foreach ($secret_data as $data) {
          $result .= '"'.$value['PLN_ID'].'S'.$data['SECRET_ID'].'","'.$data['PLN_NAME'].'('.$data['PLN_TYPE'].')'.'","'.$date.'","'.$data['PLN_USE_FLG'].'","0'.'",'.$num.''."\n";
        }

      }
    }


    if ($result == '') {
        $result = '"Null"';
    }

    // $this->response->set_header('Content-Type', 'application/csv');
    // $this->response->set_header('Content-Disposition', 'attachment; filename="'.date('Y-m-d').'.csv"');
    return $this->response($result);
  }




  public function Action_tema201()
  {
    $this->format = 'html';
    $data = Input::post();
    // $data = Input::get();

    if (!isset($data['LoginID']) || $data['LoginID'] == '') {
      return $this->response('"NG","LoginID is empty."');
      // return $this->response(array('NG' => 'LoginID is empty.'));
    }
    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
      return $this->response('"NG","LoginPass is empty."');
      // return $this->response(array('NG' => 'LoginPass is empty.'));
    }
    if (!isset($data['Shubetsu']) || $data['Shubetsu'] == '') {
      return $this->response('"NG","Shubetsu is empty."');
      // return $this->response(array('NG' => 'Shubetsu is empty.'));
    }
    if (!isset($data['DayStart']) || $data['DayStart'] == '') {
      return $this->response('"NG","DayStart is empty."');
      // return $this->response(array('NG' => 'DayStart is empty.'));
    }
    if (!isset($data['DayEnd']) || $data['DayEnd'] == '') {
      return $this->response('"NG","DayEnd is empty."');
      // return $this->response(array('NG' => 'DayEnd is empty.'));
    }


    if (strlen($data['DayStart'])!=10) {
      return $this->response('"NG","Invalid DayStart."');      
    }
    if (strlen($data['DayEnd'])!=10) {
      return $this->response('"NG","Invalid DayEnd."');      
    }

    $data['DayStart'] = date('Y-m-d', strtotime($data['DayStart']));
    $data['DayEnd']   = date('Y-m-d', strtotime($data['DayEnd']));

    if ($data['DayStart'] > $data['DayEnd']) {
      return $this->response('"NG","Invalid DayStart or DayEnd."');      
    }

    $htl = Model_M_Htl::forge();
    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      return $this->response('"NG","Invalid LoginID or loginPass."');
      // return $this->response(array('NG' => 'Invalid LoginID or loginPass.', ));
    }else{
      $data['HTL_ID'] = $user_data['HTL_ID'];
    }

    $rsv = Model_T_Rsv::forge();
    if ($data['Shubetsu'] != '1' && $data['Shubetsu'] != '2' ) {
      return $this->response('"NG","Invalid Shubetsu."');
      // return $this->response(array('NG' => 'Invalid Shubetsu.'));
    }

    $rsv_data = $rsv->get_rsv_for_api($data);
    if ($rsv_data == 0) {
      return $this->response('"Null"');
      // return $this->response(array('NG'=>'Null'));
    }

    $result = '';
    // $result = array();
    foreach ($rsv_data as $key => $value) {
      $array = array();

      // $array['予約番号'] = $value['info']['RSV_NO'];
      $result .= '"stm'.$value['info']['RSV_NO'].'"';
      $flg = '';
      if ($value['info']['RSV_STS'] == 1) {
        if (date('Y-m-d H:i', strtotime($value['info']['RSV_DATE'])) == date('Y-m-d H:i', strtotime($value['info']['UP_DATE']))) {
          $flg = 'B';
        }else{
          $flg = 'M';          
        }
      }else if($value['info']['RSV_STS'] == 9){
        $flg = 'C';
      }
      // $array['予約種別'] = $flg;
      $result .= ',"'.$flg.'"';
      // $array['宿泊者'] = $value['info']['USR_NAME'];
      $result .= ',"'.$value['info']['USR_NAME'].'"';

      // $array['ふりがな'] = $value['info']['USR_KANA'];
      $result .= ',"'.$value['info']['USR_KANA'].'"';

      // $array['チェックイン日']  = date('Y/m/d', strtotime($value['info']['IN_DATE']));
      $result .= ',"'.date('Y/m/d', strtotime($value['info']['IN_DATE'])).'"';

      // $array['チェックアウト日'] = date('Y/m/d', strtotime($value['info']['OUT_DATE']));
      $result .= ',"'.date('Y/m/d', strtotime($value['info']['OUT_DATE'])).'"';

      // $array['部屋数'] = $value['info']['NUM_ROOM'];
      $result .= ',"'.$value['info']['NUM_ROOM'].'"';
      
      // $array['大人人数'] = $value['info']['PLN_NUM_MAN'] + $value['info']['PLN_NUM_WOMAN'];
      $result .= ',"'.($value['info']['PLN_NUM_MAN'] + $value['info']['PLN_NUM_WOMAN']).'"';

      // $array['子供人数'] = $value['info']['PLN_NUM_CHILD1'] + $value['info']['PLN_NUM_CHILD2'] + $value['info']['PLN_NUM_CHILD3'] + $value['info']['PLN_NUM_CHILD4'] + $value['info']['PLN_NUM_CHILD5'] + $value['info']['PLN_NUM_CHILD6'];
      $result .= ',"'.( $value['info']['PLN_NUM_CHILD1'] + $value['info']['PLN_NUM_CHILD2'] + $value['info']['PLN_NUM_CHILD3'] + $value['info']['PLN_NUM_CHILD4'] + $value['info']['PLN_NUM_CHILD5'] + $value['info']['PLN_NUM_CHILD6'] ).'"';

      // $array['宿泊料金'] = $value['info']['PLN_CHG_TOTAL'];
      $result .= ',"'.$value['info']['PLN_CHG_TOTAL'].'"';

      // $array['連絡先'] = ''; // 不要
      $result .= ',"'.'"';

      // $array['メールアドレス'] = $value['info']['HTL_MAIL'];
      $result .= ',"'.$value['info']['USR_MAIL'].'"';
      // $result .= ',"'.$value['info']['HTL_MAIL'].'"';

      // $array['部屋コード'] = $value['info']['TYPE_ID'];
      $result .= ',"'.$value['info']['TYPE_ID'].'"';
      
      // $array['プランコード'] = $value['info']['PLN_ID'];
      $result .= ',"'.$value['info']['PLN_ID'].'"';
      
      // $array['予約日時'] = date('Y/m/d', strtotime($value['info']['RSV_DATE']));
      $result .= ',"'.date('Y/m/d H:i:s', strtotime($value['info']['RSV_DATE'])).'"';
      
      if ($value['info']['CANCEL_DATE'] != '0000-00-00 00:00:00') {
          // $array['キャンセル日時'] = date('Y/m/d', strtotime($value['info']['CANCEL_DATE']));
          $result .= ',"'.date('Y/m/d H:i:s', strtotime($value['info']['CANCEL_DATE'])).'"';
      }else{
          // $array['キャンセル日時'] = '';
          $result .= ',"'.'"';
      }
      if ($value['info']['USR_TEL'] == null || $value['info']['USR_TEL'] == '') {
          // $array['TEL'] = '';
          $result .= ',"'.'"';
      }else{
          // $array['TEL'] = $value['info']['USR_TEL'];
          $result .= ',"'.$value['info']['USR_TEL'].'"';
          // $result .= ',"'.'"';
          // $result .= ',"'.$value['info']['USR_TEL'].'"';
      }
      if ($value['info']['HTL_ADR1'] == null || $value['info']['HTL_ADR1'] == '') {
          // $array['住所'] = '';        
          $result .= ',"'.'"';
      }else{
          // $array['住所'] = $value['info']['HTL_ADR1']." ".$value['info']['HTL_ADR2'];
          $result .= ',"'.$value['info']['USR_ADR1']." ".$value['info']['USR_ADR2'].'"';
          // $result .= ',"'.'"';
          // $result .= ',"'.$value['info']['HTL_ADR1']." ".$value['info']['HTL_ADR2'].'"';
      }
      // $array['チェックイン時刻'] = $value['info']['IN_DATE_TIME'];
      $result .= ',"'.$value['info']['IN_DATE_TIME'].'"';
      // $array['宿泊者 Fax']  = $value['info']['USR_FAX'];
      $result .= ',"'.$value['info']['USR_FAX'].'"';
      // $array['宿泊者連絡先'] = '';   // 不要
      $result .= ',"'.'"';
      // $array['男人数'] = $value['info']['PLN_NUM_MAN'];
      $result .= ',"'.$value['info']['PLN_NUM_MAN'].'"';
      // $array['女人数'] = $value['info']['PLN_NUM_WOMAN'];
      $result .= ',"'.$value['info']['PLN_NUM_WOMAN'].'"';

      $uchiwake = '';
      $uchiwake = '【料金内訳】,ZZ';

      $count = 0; $hold = 0; $price = 0; $person_num = 0; $day_chg = 0;
      foreach ($value['days'] as $day => $seqs) {
        $uchiwake.= $day.",ZZ";
        $count ++ ;
        $day_chg = 0;
        
        foreach ($seqs as $rmcount => $numchg) {
          $numchgs = explode('_', $numchg);
          // if ($rmcount == '0' && $value['info']['PT_USE'] == '5' && $count == 1) {
          //   $discount = DISCOUNT;
          // }else{
          //   $discount = 0;
          // }

          if ($count == 1 && $rmcount == '0' && $value['info']['PT_USE'] == '5') {
            $discount = DISCOUNT;
          }else if($hold != 0){
            $discount = $hold;
            $hold = 0;
          }else{
            $discount = 0;
          }

          $person_num = $numchgs[0] + $numchgs[1];
          if ($person_num == 0) {
            $price = 0;
          }else{
            $price = $numchgs[2] - ( $discount / $person_num );
            if ($price < 0) {
              $price = 0;
            } 
          } 


          $uchiwake.= ($rmcount+1)."室目,ZZ";
          $uchiwake.= "大人".($numchgs[0]+$numchgs[1])."名";
          $uchiwake.= "(男性 ".$numchgs[0]."名　女性 ".$numchgs[1]."名) × ".$price."円,ZZ";
          $uchiwake.= "子供 A 0名　×　0円,ZZ";
          // $uchiwake.= "子供 A".$value['']."名　×　".$value['']."円,ZZ";
          $uchiwake.= "子供 B ".$numchgs[4]."名　×　".$numchgs[10]."円,ZZ";
          $uchiwake.= "子供 C ".$numchgs[6]."名　×　".$numchgs[12]."円,ZZ";
          $uchiwake.= "子供 D ".$numchgs[7]."名　×　".$numchgs[13]."円,ZZ";

          if ($numchgs[3] > 0) {
              $num = $numchgs[3];
              $val = $numchgs[9];
          }else if($numchgs[5] > 0){
              $num = $numchgs[5];
              $val = $numchgs[11];
          }else if ($numchgs[8] > 0) {
              $num = $numchgs[8];
              $val = $numchgs[14];
          }else{
              $num = 0;
              $val = 0;
          }
          $uchiwake.= "子供 その他 ".$num."名　×　".$val."円,ZZ";
          // $sum = ($val * $num) +($numchgs[0] + $numchgs[1]) * $numchgs[2] +  ( $numchgs[4] * $numchgs[10] ) + ( $numchgs[6] * $numchgs[12] ) + ( $numchgs[7] * $numchgs[13] );
          $sum = ($val * $num) +($numchgs[0] + $numchgs[1]) * $numchgs[2] +  ( $numchgs[4] * $numchgs[10] ) + ( $numchgs[6] * $numchgs[12] ) + ( $numchgs[7] * $numchgs[13] ) - $discount;
          if ($sum < 0 ) {
            $hold = abs($sum);
            $sum = 0;
          }
          $uchiwake.= "小計 ".$sum."円,ZZ";
          $day_chg += $sum;
        }
       // if ($rmcount == '0' && $value['info']['PT_USE'] == '5') {
       //   $discount = DISCOUNT;
       // }else{
       //   $discount = 0;
       // }
       // $uchiwake.= "合計 ".( $sum * ($rmcount + 1) - $discount)."円,ZZ";
       // $uchiwake.= $count."泊目 合計 ".( $sum * ($rmcount + 1))."円,ZZ";
       // $uchiwake.= $count."泊目 合計 ".$day_chg."円,ZZ";
       $uchiwake.= "合計 ".$day_chg."円,ZZ";
      }
      $uchiwake.= "付与ポイント　".$value['info']['PT_ADD_BASIC']."ポイント,ZZ";
      if ($value['info']['PT_USE'] == '5') {
        $uchiwake.= "ポイントによる割引 ".DISCOUNT."円,ZZ";
      }else{ 
        $uchiwake.= "ポイントによる割引 なし,ZZ";
      }
      // $uchiwake.= "合計 ".$value['info']['PLN_CHG_TOTAL']."円,ZZ";
      $uchiwake.= "【部屋別代表者】,ZZ";
      for ($i=1; $i <= $value['info']['NUM_ROOM']; $i++) { 
        $uchiwake.= $i."室目　".$value['info']['USR_NAME']."(".$value['info']['USR_KANA'].'),ZZ';        
      }

      $n = strlen($uchiwake);
      $uchiwake = substr($uchiwake, 0, $n-3);

      // $array['予約詳細'] = $uchiwake;
      $result .= ',"'.$uchiwake.'"';

      $result .= ',""';
      // $array['会員氏名'] = $value['info']['USR_NAME'];
      $result .= ',"'.$value['info']['USR_NAME'].'"';
      
      // $array['会員かな'] = $value['info']['USR_KANA'];
      $result .= ',"'.$value['info']['USR_KANA'].'"';
      
      // $array['会員住所'] = $value['info']['USR_ADR1']." ".$value['info']['USR_ADR2'];
      $result .= ',"'.$value['info']['USR_ADR1']." ".$value['info']['USR_ADR2'].'"';
      
      // $array['会員 TEL'] = $value['info']['USR_TEL'];
      $result .= ',"'.$value['info']['USR_TEL'].'"';
      
      // $array['会員 FAX'] = $value['info']['USR_FAX'];
      $result .= ',"'.$value['info']['USR_FAX'].'"';
      
      // $array['会員メール'] = $value['info']['USR_MAIL'];
      $result .= ',"'.$value['info']['USR_MAIL'].'"';
      
      // $array['会員年齢'] = '';
      $result .= ',""';
      
      // $array['会員性別'] = $value['info']['USR_SEX'];
      $result .= ',"'.$value['info']['USR_SEX'].'"';
      
      // $array['会員会社'] = '';
      $result .= ',""';
      
      // $array['会員会社住所'] = '';
      $result .= ',""';
      
      // $array['会員会社 TEL'] = '';
      $result .= ',""';
      
      // $array['会員会社 FAX'] = '';
      $result .= ',""';
      
      // $array['付与ポイント'] = $value['info']['PT_ADD_BASIC'];
      $result .= ',""';
      // $result .= ',"'.$value['info']['PT_ADD_BASIC'].'"';
      
      // $array['使用ポイント'] = $value['info']['PT_USE'];
      $result .= ',""';
      // $result .= ',"'.$value['info']['PT_USE'].'"';
      if ($value['info']['ADJUST_TYPE'] == '1') {
        $flg = '0';
      }else if($value['info']['ADJUST_TYPE'] == '2'){
        $flg = '1';
      }
      
      // $array['決済区分'] = $flg;
      $result .= ',"'.$flg.'"'; $hold = 0;

      // $array['請求料金'] = $value['info']['PLN_CHG_TOTAL'];
      $result .= ',"'.$value['info']['PLN_CHG_TOTAL'].'"';
      $heyainfo = ""; $count = 1; $price  = '0';

      foreach ($value['rm_betsu'] as $day => $numchg) {
        for($i = 1; $i <= $value['info']['NUM_ROOM']; $i++){
          if ($count == 1 && $i == 1 && $value['info']['PT_USE'] == '5') {
            $discount = DISCOUNT;
          }else if($hold != 0){
            $discount = $hold;
            $hold = 0;
          }else{
            $discount = 0;
          }
          $numchgs = explode('_', $numchg);
          $heyainfo .= $day;
          $heyainfo .= ','.$i;
          $heyainfo .= ',0';
          $heyainfo .= ','.($numchgs[0] + $numchgs[1] + $numchgs[3] + $numchgs[4] + $numchgs[5] + $numchgs[6] + $numchgs[7]);
          $heyainfo .= ','.$numchgs[0];
          if ($numchgs[0] == '0') {
            $price = '0';
          }else{
            $price = $numchgs[2] - ( $discount / $numchgs[0] );
            if ($price < 0) {
              $price = 0;
            } 
          }
          $heyainfo .= ','.$price;
          $heyainfo .= ','.$numchgs[1];
          if ($numchgs[1] == '0') {
            $price = '0';
          }else{
            $price = $numchgs[2] - ( $discount / $numchgs[1] );
            if ($price < 0) {
              $price = 0;
            } 
          }
          $heyainfo .= ','.$price;
          $heyainfo .= ',0';
          $heyainfo .= ',0';
          $heyainfo .= ',0';
          $heyainfo .= ',0';
          $heyainfo .= ','.$numchgs[4];
          $heyainfo .= ','.$numchgs[10];
          $heyainfo .= ',0';
          $heyainfo .= ',0';
          $heyainfo .= ','.$numchgs[6];
          $heyainfo .= ','.$numchgs[12];
          $heyainfo .= ','.$numchgs[7];
          $heyainfo .= ','.$numchgs[13];
          if ($numchgs[3] > 0) {
              $num = $numchgs[3];
              $val = $numchgs[9];
          }else if($numchgs[5] > 0){
              $num = $numchgs[5];
              $val = $numchgs[11];
          }else if ($numchgs[8] > 0) {
              $num = $numchgs[8];
              $val = $numchgs[14];
          }else{
              $num = 0;
              $val = 0;
          }
          $heyainfo .= ','.$num;
          $heyainfo .= ','.$val;
          
          $total_chg = $numchgs[0] * $numchgs[2] + $numchgs[1] * $numchgs[2] + 0 * $numchgs[9] + 0 * $numchgs[10] + 0 * $numchgs[11] + 0 * $numchgs[12] + 0 * $numchgs[13] + 0 * $numchgs[14] - $discount;
          // $heyainfo .= ','.($numchgs[0] * $numchgs[2] + $numchgs[1] * $numchgs[2] + 0 * $numchgs[9] + 0 * $numchgs[10] + 0 * $numchgs[11] + 0 * $numchgs[12] + 0 * $numchgs[13] + 0 * $numchgs[14] );
          if ($total_chg < 0) {
            $hold = abs($total_chg);
            $total_chg = 0;
          }
          $heyainfo .= ','.$total_chg;
          $heyainfo .= ',ZZ';
          $count ++;
        }
      }


      $n = strlen($heyainfo);
      $heyainfo = substr($heyainfo, 0, $n-3);

      // $array['部屋毎情報'] = $heyainfo;
      $result .= ',"'.$heyainfo.'"';

      // $array['在庫連動フラグ'] = '1';
      $result .= ',"1"';
      $result .= " \n";

      // $result[] = $array;
    }


    return $this->response($result);

  }




  public function Action_tema030()
  {
    $this->format = 'html';

    $data = Input::post();
    // $data = Input::get();
    if (!isset($data['LoginID']) || $data['LoginID'] == '') {
        // return $this->response(array('NG' => 'LoginID is empty.'));
        return $this->response('"NG","LoginID is empty."');
    }
    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
        return $this->response('"NG","LoginPass is empty."');
        // return $this->response(array('NG' => 'LoginPass is empty.'));
    }
    if (!isset($data['Nengetsu']) || $data['Nengetsu'] == '') {
        return $this->response('"NG","Nengetsu is empty."');
        // return $this->response(array('NG' => 'Nengetsu is empty.'));
    }
    if (!isset($data['HeyaID']) || $data['HeyaID'] == '') {
        return $this->response('"NG","HeyaID is empty."');
        // return $this->response(array('NG' => 'HeyaID is empty.'));
    }

    $htl = Model_M_Htl::forge();
    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      return $this->response('"NG","Invalid LoginID or loginPass."');
      // return $this->response(array('NG' => 'Invalid LoginID or loginPass.', ));
    }else{
      $data['HTL_ID'] = $user_data['HTL_ID'];
    }

    $dates = explode('/', $data['Nengetsu']);
    $year = $dates[0]; 
    $month = $dates[1];
    $daycount = Date::days_in_month($month, $year);


    $month = sprintf("%02d", $month); 
    $rtype = Model_M_Rtype::forge();
    $mrrm = Model_M_Rtype_Roomamount::forge();
    $exday = Model_R_Plan_Rmnum::forge();
    $date_array = array();
    $error_array = '';
    // $error_array = array();
    for ($i=1; $i <= $daycount ; $i++) { 
      $d = sprintf("%02d", $i);
      if (isset($data['Zaiko'.$d])) {
        $date_array[$year.'-'.$month.'-'.$d] = $data['Zaiko'.$d]; 
        $date = $year.'-'.$month.'-'.$d;
        $val = $data['Zaiko'.$d];

        //その日の在庫確認
        $rtype_data = $rtype->get_stock_for_api($data['HTL_ID'], $data['HeyaID'], $date);
        if ($rtype_data == 0) {
          $error_array = 'no data';
          // $error[$date] = 'no data';
        }else{
          /* 手じまいにする場合  */
          if ($val == '-999') {
            if ($rtype_data['NUM'] == null) {
              $result = $mrrm->insert_rmamount($data['HTL_ID'], $data['HeyaID'], $date, '1', '0');
            }else{
              $result = $mrrm->update_rmamount($data['HTL_ID'], $data['HeyaID'], $date, '1', '0');
            }
            $exday->update_rmnum_all($data['HTL_ID'], $data['HeyaID'], $date, '1');
          }else{
            /* 在庫を変動する場合  */
            if (!ctype_digit(str_replace('-','', $val))) {
            // if ($rtype_data['RM_NUM'] - $rtype_data['SALED_NUM'] < $val) {
              $error_array .= $date.':Invalid Zaiko value '." ".$val." ";
            }else{
              if($val < 0){
                $val = 0;
              }

              $ins_flg = '1';

              if ($rtype_data['NUM'] == null) {
                $result = $mrrm->insert_rmamount($data['HTL_ID'], $data['HeyaID'], $date, '0', '0');
                $ins_flg = '0';
              }else{
                $result = $mrrm->update_rmamount($data['HTL_ID'], $data['HeyaID'], $date, '0', '0');
              }

              $exday->update_rmnum_all($data['HTL_ID'], $data['HeyaID'], $date, '0');

              $zougen_num = $val + $rtype_data['SALED_NUM'] - $rtype_data['RM_NUM'];
              if ($rtype_data['NUM'] == null && $ins_flg == '1') {
                $result = $mrrm->insert_rmamount($data['HTL_ID'], $data['HeyaID'], $date, '0', $zougen_num);
              }else{
                $result = $mrrm->update_rmamount($data['HTL_ID'], $data['HeyaID'], $date, null, $zougen_num);
              }
            }
          }
        }
      }
    }
    if ($error_array == '') {
      $response = '"OK"';
    }else{
      $response = '"NG","'.$error_array.'"';
    }

    return $this->response($response);
  }


  public function Action_tema036()
  {
    $this->format = 'html';

    $data = Input::post();
    // $data = Input::get();
    if (!isset($data['LoginID']) || $data['LoginID'] == '') {
        return $this->response('"NG","LoginID is empty."');
        // return $this->response(array('NG' => 'LoginID is empty.'));
    }
    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
        return $this->response('"NG","LoginPass is empty."');
        // return $this->response(array('NG' => 'LoginPass is empty.'));
    }
    if (!isset($data['Mon']) || $data['Mon'] == '') {
        return $this->response('"NG","Mon is empty."');
        // return $this->response(array('NG' => 'Mon is empty.'));
    }
    if (!isset($data['HeyaID']) || $data['HeyaID'] == '') {
        return $this->response('"NG","HeyaID is empty."');
        // return $this->response(array('NG' => 'HeyaID is empty.'));
    }
    if (!isset($data['PlanID']) || $data['PlanID'] == '') {
        return $this->response('"NG","PlanID is empty."');
        // return $this->response(array('NG' => 'PlanID is empty.'));
    }


    $htl = Model_M_Htl::forge();
    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      return $this->response('"NG","Invalid LoginID or loginPass."');
      // return $this->response(array('NG' => 'Invalid LoginID or loginPass.', ));
    }else{
      $data['HTL_ID'] = $user_data['HTL_ID'];
    }

    $dates = explode('/', $data['Mon']);
    $year = $dates[0]; 
    $month = $dates[1];
    $daycount = Date::days_in_month($month, $year);

    $mpe = Model_M_Plan_Exceptionday::forge();


    $month = sprintf("%02d", $month); 
    for($i=1; $i<=$daycount; $i++){
      $d = sprintf("%02d", $i);
      $date_array = array();
      $date = $year.'-'.$month.'-'.$d;

      for($kbn=1; $kbn<=6; $kbn++){
        if(isset($data['Kubun'.$kbn.'_'.$d]) && isset($data['Ryokin'.$kbn.'_'.$d])){
          $date_array[$kbn] = $data['Ryokin'.$kbn.'_'.$d];
        }
      }

      if (count($date_array) > 0) {
        $result = $mpe->get_ins_up_for_api($data['HTL_ID'], $data['PlanID'], $data['HeyaID'], $date, $date_array);
        if ($result == '9') {
          return $this->response('"NG","no data"');
          // return $this->response(array('NG' => 'no data'));
        }
      }


    }



    return $this->response('"OK"');

  }


  private function data_check($data)
  {
    if (!isset($data['LoginID']) || $data['LoginID'] == '' ) {
      return 'LoginID is empty.';
    }
    if (!isset($data['LoginPass']) || $data['LoginPass'] == '') {
      return 'LoginPass is empty.';
    }
    if (!isset($data['HeyaID']) || $data['HeyaID'] == '') {
      return 'HeyaID is empty.';
    }
    if (!isset($data['DayStart']) || $data['DayStart'] == '') {
      return 'DayStart is empty.';
    }
    if (!isset($data['DayEnd']) || $data['DayEnd'] == '') {
      return 'DayEnd is empty.';
    }
    if ($data['DayStart'] > $data['DayEnd']) {
      return 'invalid date.';
    }
    // $data['HTL_ID'] = 1;
    // $data['TYPE_ID'] = 1;

    // $login = Model_M_Co_Login::forge();
    // $user_data = $login->get_user($data['LoginID']);
    //  md5(MD5_SALT . $data['LoginPass']);
    // if ($user_data == nuLL || $user_data['LOGIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
    //   return 'Invalid LoginID or loginPass';
    // }


    $htl = Model_M_Htl::forge();

    $user_data = $htl->get_user($data['LoginID']);
    if ($user_data == nuLL || $user_data['ADMIN_PWD'] !=  md5(MD5_SALT . $data['LoginPass']) ) {
      return 'Invalid LoginID or loginPass';
    }

    $data['HTL_ID'] = $user_data['HTL_ID'];


    $date1 = explode('/', $data['DayStart']);
    $date2 = explode('/', $data['DayEnd']);
    $today = date('Y/m/d');
    $effective_day = date('Y/m/d', strtotime('+1 year'));

    if (count($date1) == 3 && count($date2) == 3 && $date1[1] == $date2[1] && $date1[0] == $date2[0]) {
      if ($data['DayStart'] > $effective_day || $data['DayEnd'] < $today) {
        return 'invalid date.';
      }else if ($data['DayStart'] < $today) {
        $data['DayStart'] = $today;
      }else if ($data['DayEnd'] > $effective_day) {
        $data['DayEnd'] = $effective_day;
      }
    }else{
      return 'invalid month';
    }
  return $data;
  }


}
