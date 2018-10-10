<?php
class Controller_Common extends Controller_Template
{
  public $template = 'front/template';
  //public $template = 'front/template_normal';


  public function before()
  {


/*  ボタンにより設定言語を切り替える */
    $language = Session::get('language');
    if (!$language) {
      $language = $this->set_language();
    }
    $this->language=$language;
    Config::set('language', $language);
    Lang::load('main');

    /*リクエストごとに切り替える場合*/
    // $this->set_language();
    // $this->language=Session::get('language');

    $segments = Uri::segments();
    if (isset($segments[0])) {
        $client_ip = '';
        if ($segments[0] === 'admin') {
          $this->template= 'admin/template';
        }elseif($segments[0] === HTL1){//test
          $client_ip = CLIENT_IP1;
          $test_clinet_ip = '2014002000';
          $this->htl_name = HTL1;//test
          $this->htl_id = '1';//test
          $this->template= 'front/template';
        }elseif($segments[0] === HTL2){//test
          $client_ip = CLIENT_IP2;
          $test_clinet_ip = '2014001999';
          $this->htl_name = HTL2;//test
          $this->htl_id = '2';//test
          $this->template= 'front/template_nihonbashi';
        }elseif($segments[0] === HTL3){//test
          $client_ip = CLIENT_IP3;
          $test_clinet_ip = '2014002046';
          $this->htl_name = HTL3;//test
          $this->htl_id = '3';//test
          $this->template= 'front/template_sapporo';
        }elseif($segments[0] === HTL4){//test
          $client_ip = CLIENT_IP4;
          $test_clinet_ip = '';
          $this->htl_name = HTL4;//test
          $this->htl_id = '4';//test
          $this->template= 'front/template_asakusabashi';
        }elseif($segments[0] === HTL5){//test
          $client_ip = CLIENT_IP5;
          $test_clinet_ip = '';
          $this->htl_name = HTL5;//test
          $this->htl_id = '5';//test
          $this->template= 'front/template_kyoto';
        }else{
          Response::redirect(HTL1);
          // $this->htl_id = '1';
          // $this->htl_name = '';
        }
        // 本番環境以外は、ZEUSテスト用クライアントIPへ強制
        if (Fuel::$env !== \Fuel::PRODUCTION) {
          if (isset($test_clinet_ip)) {
            $client_ip = $test_clinet_ip;
          }
        }
        define('CLIENT_IP', $client_ip);
    }else{
      Response::redirect(HTL1);
      // $this->htl_name = '';
      // $this->htl_id = '1';
    }

    if (isset($this->htl_name)) {
      $data = array(
        'login_url' => HTTP.'/'.$this->htl_name.'/login',
        'logout_url' => HTTP.'/'.$this->htl_name.'/logout',
        'mypage_url' => HTTP.'/'.$this->htl_name.'/mypage',
        'is_login' => Session::get('user_data') ? true : false,
        'name' => Session::get('user_data') ? Session::get('user_data.user_name') : __('lbl_guest'),
      );
      define('FRONT_INC_LOGIN_MENU_HTML', View::forge('front/inc_login_menu', $data)->render());
    }

    parent::before();
  }

  public function japan_holiday($year) {
      $holiday_list = array();
      try
      {
          $holiday_list = Cache::get($year);
      }
      catch (\CacheNotFoundException $e)
      {
          $holidays = array();

          $month = '1'; $month2 = '12';
          $first_day = mktime(0, 0, 0, intval($month), 1, intval($year));
          // 月末日
          // $last_day = strtotime('-1 day', mktime(0, 0, 0, intval($month) + 1, 1, intval($year)));
          $last_day = mktime(0, 0, 0, intval($month2), 31, intval($year));

          $api_key = GOOGLE_API_KEY;
          $holidays_id = 'outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com';  // mozilla.org版
          //$holidays_id = 'japanese__ja@holiday.calendar.google.com';  // Google 公式版日本語
          //$holidays_id = 'japanese@holiday.calendar.google.com';  // Google 公式版英語
          $holidays_url = sprintf(
            'https://www.googleapis.com/calendar/v3/calendars/%s/events?'.
            'key=%s&timeMin=%s&timeMax=%s&maxResults=%d&orderBy=startTime&singleEvents=true',
            $holidays_id,
            $api_key,
            date('Y-m-d', $first_day).'T00:00:00Z' ,  // 取得開始日
            date('Y-m-d', $last_day).'T00:00:00Z' ,   // 取得終了日
            31            // 最大取得数
            );
          if ( $results = file_get_contents($holidays_url) ) {
            $results = json_decode($results);
            $holidays = array();
            foreach ($results->items as $item ) {
              $date  = strtotime((string) $item->start->date);
              $title = (string) $item->summary;
              $holidays[date('Y-m-d', $date)] = $title;
            }
            ksort($holidays);
          }
          foreach ($holidays as $key => $value) {
                $dates = explode('-', $key);
                $holiday_list[intval($dates[1])][intval($dates[2])] =$value;
          }

          Cache::set($year, $holiday_list);
      }

      return $holiday_list;
  }


    public function price_list($data)
    {

      $format = 'Ymd';
      $datec = DateTime::createFromFormat($format, $data['stay_date']);
      $date =  $datec->format('Y-m-d');
      $start = $date;



      $start = date('Y-m-d', strtotime($start));
      $end = date('Y-m-d', strtotime($start." +".$data['stay_count']." day"));

      $plan_rtype = Model_M_Plan_Rtype::forge();
      $diff = (strtotime($end) - strtotime($start)) / ( 60 * 60 * 24);     

      // シークレットプランの料金補正
      if ($tmp = Session::get('secret_plan')) {
        $htl_id = $tmp['htl_id'];
        $plan_id = $tmp['plan_id'];
        $secret_id = $tmp['secret_id'];
        $secret = Model_M_Secret::forge();
        $secret_data = $secret->get_plan_one($htl_id, $plan_id, $secret_id);
      }

      $price_list = array();
      for ($i=0; $i < $diff ; $i++) { 
        $period = date('Y-m-d', strtotime($start . '+' . $i . 'days'));
        $plan_rtype_data = $plan_rtype->get_plan_rtype($data['htl_id'], $data['pln_id'], $data['type_id'], $period, $this->language);
        $price_list[$period] = $plan_rtype_data['PLN_CHG_PERSON'.$data['person_num']] + $plan_rtype_data['PLN_CHG_EXCEPTION'.$data['person_num']];
        if (isset($secret_data)) {
          $price_list[$period] -= round($price_list[$period] * $secret_data['PLN_RATE'] / 100, 0, PHP_ROUND_HALF_EVEN);
        }
      }

      return $price_list;
    }

    public function send_mail($data)
    {
      $email = Email::forge();
      $email->from($data['from']);
      $email->to($data['to']);

      $email->subject($data['subject']);
      $email->body($data['body']);

      $email->priority(\Email::P_HIGH);

      try {
        $email->send();

      } catch (\EmailValidationFailedException $e) {
        return __('lbl_error28');

      } catch(\EmailSendingFailedException $e){
        return __('lbl_error27');

      }


      return '0';
    }


    public function zeusu_api($post, $url)
    {

      $curl=curl_init($url);
      curl_setopt($curl,CURLOPT_POST, TRUE);
      
      // curl_setopt($curl,CURLOPT_POSTFIELDS, $POST_DATA);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);  // オレオレ証明書対策
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);  // 
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
      curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
      curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡
      //curl_setopt($curl,CURLOPT_REFERER,        "REFERER");
      //curl_setopt($curl,CURLOPT_USERAGENT,      "USER_AGENT"); 
      // $output= curl_exec($curl);
      try {
        $output= curl_exec($curl);
      
      } catch (Exception $e) {
        $output = $e;  
      }

      error_log(date('m/d h:i:s').__CLASS__."\n" . __LINE__ . '行:' .print_r($output, true) . "\n");

      if(strpos($output,'Success') !== false){
        $result[0] = '0';
        $result[1] = trim(str_replace("Success_order", '', $output)); 
      }else{
        $error_suffix = substr($output, -3);
        if (strpos($output, 'Invalid Cardnumber') !== false ) {
          $error_suffix = '026';
        }
        switch ($error_suffix) {
          case '002': // 通信エラー（ゼウス⇒カード会社）
          case '003': // データエラー（加盟店⇒ゼウス）
          case '004': // データエラー（加盟店⇒ゼウス）
            $error_msg = __('lbl_zeusu_error1');
          case '005': // カード理由（一時的に利用不可）
          case '006': // カード理由（無効・復活なし）
            $error_msg = __('lbl_zeusu_error2');
            break;
          case '007': // カード理由（有効期限）
            $error_msg = __('lbl_zeusu_error3');
            break;
          case '028': // 有効期限
            $error_msg = __('lbl_zeusu_error4');
            break;
          case '008': // カード理由（支払い方法）
            $error_msg = __('lbl_zeusu_error5');
            break;
          case '025': // DIV-ERR
            $error_msg = __('lbl_zeusu_error6');
            break;
          case '026': // カード番号ERR
          case '038': // カード番号ERR
            $error_msg = __('lbl_zeusu_error7');
            break;
          case '012': // 不正IP
          case '013': // 一時不正IP
          case '041': // Z-STOP
          case '052': // Z-STOP
          case '054': // 会員ERR
            $error_msg = __('lbl_zeusu_error8');
            break;
          case '015': // 金額ERR
          case '016': // 決済停止
          case '020': // 有効不正
          case '021': // 電話不正
          case '022': // 不正IPCD
          case '024': // 支払不正 分割回数
          case '029': // 設定不正CD
          case '033': // 番組停止
          case '037': // テストカード番号固有エラー？
          case '039': // LEN-ERR
          case '053': // 金額不正
          case '055': // SEC-ERR
          case '000': // 決済失敗
          default:
            $error_msg = __('lbl_zeusu_error9');
        }

        $result[0] = '1';
        $result[1] = $error_msg;
      }

      return $result;
    }

    private function set_language()
    {

      $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
      $languages = array_reverse($languages);
      
      $result = '';
      foreach ($languages as $language) {
        if (preg_match('/^ja/i', $language)) {
          $result = 'ja';
          // $this->language = 'ja';
          // Config::set('language', 'ja');
          // Session::set('language', 'ja');
        } elseif (preg_match('/^en/i', $language)) {
          $result = 'en';
          // $this->language = 'en';
          // Config::set('language', 'en');
          // Session::set('language', 'en');
        } elseif (preg_match('/^zh-cn/i', $language)) {
          $result = 'ch';
          // $this->language = 'cn';
          // Config::set('language', 'en');
          // Session::set('language', 'en');
        } elseif (preg_match('/^zh-tw/i', $language)) {
          $result = 'tw';
          // $this->language = 'tw';
          // Config::set('language', 'en');
          // Session::set('language', 'en');
        } elseif (preg_match('/^ko/i', $language)) {
          $result = 'ko';
          // $this->language = 'ko';
          // Config::set('language', 'en');
          // Session::set('language', 'en');
        }else{
          $result = 'en';
          // $this->language = 'ja';
          // Config::set('language', 'ja');
          // Session::set('language', 'ja');
        }
      }
      // $this->language = 'ja';
      // Config::set('language', 'ja'); 海外対応したときにこの2行を削除する。 
      // Lang::load('main');


      Session::set('language', $result);
      return $result;
    }


    /*  重複を防ぐために実装したが、よく不具合が発生するのでコメントイン  */
    public function delete_sessions() 
    {
      // Session::delete('RSV_INFO');
      // Session::delete('RSV_NO');
      // Session::delete('rsv_get_value');
      // Session::delete('edit_rsvno');
    }


    public function make_mail_body($r_no, $body, $htl_id)
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
              $htl_data['HTL_MAIL'],
        );

      $after_txt = str_replace($before_word, $after_word, $body);


      return $after_txt;
    }


    /*
     * ART API
     */
    public function art_api($post, $method)
    {
      $api_url = "https://amb-r-t.jp/api/";
      switch ($method) {
        case "customer_upsert":
          $api_url .= "customer/upsert.json";
          if (!$art_code = $this->_upsertArt($post, $api_url)) {
            error_log("<STAY MANAGER ERROR>Failed in link Ambassador Relations Tool.");
          }
          Session::set("art_code", $art_code);
          break;
      }

      return;
    }

    private function _upsertArt($params=null, $api_url="")
    {
      if (!$params || !$api_url) {
        return false;
      }

      $params['csv_import_flg'] = 1;

      $curl = curl_init($api_url);
      curl_setopt($curl, CURLOPT_POST, TRUE);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
      // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      // curl_setopt($curl, CURLOPT_COOKIEJAR, tempnam(sys_get_temp_dir(), "KAIROS_COOKIE"));
      // curl_setopt($curl, CURLOPT_COOKIEFILE, tempnam(sys_get_temp_dir(), "KAIROS_COOKIE"));
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

      $output = curl_exec($curl);
      $errno = curl_errno($curl);
      $error = curl_error($curl);
      curl_close($curl);
      if (CURLE_OK !== $errno) {
        return false;
      }

      $output = json_decode($output);

       //print_r(array(
         //'output'=>$output,
         //'errno'=>$errno,
         //'error'=>$error,
       //));
       //var_dump($output);
       //exit;

      return $output->code;
    }


    public function after($response)
    {
        $response = parent::after($response); // あなた自身のレスポンスオブジェクトを作成する場合は必要ありません。
        return $response; // after() は確実に Response オブジェクトを返すように
    }
}

