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
class Controller_Neppan extends Controller_Rest
{
private $systemName = 'STAYMANAGER';
private $tax_rate = 1.08;
protected $_supported_formats = array(
   'xml'        => 'text/xml',
   'rawxml'     => 'application/xml',
   'json'       => 'application/json' ,
   'jsonp'      => 'text/javascript' ,
   'serialized' => 'application/vnd.php.serialized',
   'php'        => 'text/plain',
   'html'       => 'text/html',
   'csv'        => 'application/csv',
);



public function post_neppan001()
{
  $this->format = 'xml';
  // $this->xml_basenode = 'CommodityRoomTypeReply';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post, 'xml')->to_array();

  $res = $this->validation($post , '001');


  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><CommodityRoomTypeReply></CommodityRoomTypeReply>';
  $xml = simplexml_load_string($xml_root);

  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','GetRoomInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d'));
  $tr_node->addChild('SystemTime',date('H:i:s')); 

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
    $sts = '1';
    $reason = $htl_data;
  }
  
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts); 
  if ($sts == '99') {
    $ri_node->addChild("Detail",$reason); 
  }
   
  if (!isset($htl_data['HTL_ID'])) { 
    echo $xml->asXml();
    return ;
  }

  $rtype = Model_M_Rtype::forge();
  $rtype_data = $rtype->get_room_all(array('sort' => 'TYPE_ID', 'sort_option' => 'DESC', 'limit' => '99999'), $htl_data['HTL_ID']);

  $cri_node = $xml->addChild('CommodityRoomTypeInformation');

  foreach ($rtype_data as $key => $value) {
    if ($value['RM_USE_FLG'] == '0') {
      $use_flg = '1';
    }else{
      $use_flg = '0';
    }
    $rm_node = $cri_node->addChild('CommodityRoomTypeList');
    $rm_node->addChild('BlockRoomTypeCode' , $value['TYPE_ID']);
    $rm_node->addChild('BlockRoomTypeName' , $value['TYPE_NAME']);
    $rm_node->addChild('SetupStartDate'    , '');
    $rm_node->addChild('SetupEndDate'      , '');
    $rm_node->addChild('BlockRoomTypeStatus', $use_flg);
    $rm_node->addChild('RoomCount'         , $value['RM_NUM']);
    $rm_node->addChild('ClosingTradeDay '  , '');
    $rm_node->addChild('ClosingTradeTime'  , '');
    $rm_node->addChild('MaxMember'         , $value['CAP_MAX']);
    $rm_node->addChild('MinMember'         , $value['CAP_MIN']);
    $rm_node->addChild('BlockInformation'  , '');
    $rm_node->addChild('BlockCategory'     , '');
  }



  echo $xml->asXml();
  return ;
}


public function  post_neppan002()
{
  $this->format = 'xml';
  // $this->xml_basenode = 'CommodityRoomTypeReply';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post, 'xml')->to_array();

  $res = $this->validation($post , '002');


  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><CommodityPlanReply></CommodityPlanReply>';
  $xml = simplexml_load_string($xml_root);

  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','GetPlanInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s')); 

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts); 
  if ($sts == '99') {
    $ri_node->addChild("Detail",$reason); 
  }
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }


  $plan = Model_M_Plan_Rtype::forge();
  $plan_data = $plan->get_allplan_allrtype($htl_data['HTL_ID']);


  $cp_node = $xml->addChild('CommodityPlanInformation');
  foreach ($plan_data as $key => $value) {
    $cpl_node = $cp_node->addChild('CommodityPlanList');
    $cpl_node->addChild('BlockPlanCode', $value['PLN_ID'].'_'.$value['TYPE_ID']);
    $cpl_node->addChild('BlockPlanName', $value['PLN_NAME']);
    $cpl_node->addChild('SalesStartDate', $value['PLAN_START']);
    $cpl_node->addChild('SalesEndDate',   $value['PLAN_END']);
    if ($value['PLN_USE_FLG'] == '1' && $value['RM_USE_FLG'] == '1') {
      $flg = '0';
    }else{
      $flg = '1';
    }
    $cpl_node->addChild('BlockPlanStatus', $flg);
    $cpl_node->addChild('ChargeCategory','1');
    $cpl_node->addChild('TaxCategory', '0');
    $cpl_node->addChild('ServiceFeeCategory','1');
    $cpl_node->addChild('PlanCount',$value['RM_NUM']);
    if ($value['PLN_LIMIT_TIME'] >= 24) {
      $flg = '1';
      $date = date('H:i', strtotime( ($value['PLN_LIMIT_TIME'] - 24) .':00' ));
    }else{
      $flg = '0';
      $date = '22:00';
    }
    $cpl_node->addChild('ClosingTradeDay', $flg);
    $cpl_node->addChild('ClosingTradeTime', $date);
    $cpl_node->addChild('MaxMember', $value['PLN_MAX']);
    $cpl_node->addChild('MinMember', $value['PLN_MIN']);
    // $cpl_node->addChild('BlockInformation');
    // $cpl_node->addChild('PlanNotes');
    // $cpl_node->addChild('PlanMemo');
    $cpl_node->addChild('PublishingStartDate', $value['DISP_START']);
    $cpl_node->addChild('PublishingEndDate', $value['DISP_END']);
    // $cpl_node->addChild('AcceptStartDate');
    // $cpl_node->addChild('AcceptStartTime');
    $cpl_node->addChild('MinStayCategory','1');
    $cpl_node->addChild('MinStayNum', $value['PLN_STAY_LOWER']);
    $cpl_node->addChild('MaxStayCategory','1');
    $cpl_node->addChild('MaxStayNum', $value['PLN_STAY_UPPER']);
    $cpl_node->addChild('MinRoomCategory','0');
    // $cpl_node->addChild('MinRoomNum');
    $cpl_node->addChild('MaxRoomCategory','0');
    // $cpl_node->addChild('MaxRoomNum');
    $cpl_node->addChild('MinPersonCategory','1');
    $cpl_node->addChild('MinPersonNum',$value['PLN_MIN']);
    $cpl_node->addChild('MaxPersonCategory','1');
    $cpl_node->addChild('MaxPersonNum',$value['PLN_MAX']);
    $times = explode(',', $value['CHECK_IN']);
    $cpl_node->addChild('CheckInStartTime', reset($times));
    $cpl_node->addChild('CheckInEndTime', end($times));
    $cpl_node->addChild('CheckOutTime', '10:00');
    // // $cpl_node->addChild('MealConditionBreakfast');
    // $cpl_node->addChild('BreakfastRoomCategory');
    // $cpl_node->addChild('BreakfastPrivateCategory');
    // $cpl_node->addChild('MealConditionDinner');
    // $cpl_node->addChild('DinnerRoomCategory');
    // $cpl_node->addChild('DinnerPrivateCategory');
    // $cpl_node->addChild('MealConditionLunch');
    // $cpl_node->addChild('LunchRoomCategory');
    // $cpl_node->addChild('LunchPrivateCategory');
    // $cpl_node->addChild('ReserveQuestion');
    // $cpl_node->addChild('ReserveQuestionAnswer');
    // $cpl_node->addChild('YadRequest');
    $cpl_node->addChild('Payment', '1');
    // $cpl_node->addChild('PriceMemo');
    if ($value['GENDER_FLG'] == '1') {
        $flg = '2';
    }else if ($value['GENDER_FLG'] == '2') {
        $flg = '1';
    }else{
        $flg = '0';
    }
    $cpl_node->addChild('AdultReceive', $flg);
    // $cpl_node->addChild('PlanSalesChannelCategory');
    // $cpl_node->addChild('PlanLimitCategory');
    // $cpl_node->addChild('PlanLimitNum');

    $rti_node = $cpl_node->addChild('RoomTypeInformation');
    $rti_node->addChild('RoomTypeCode', $value['TYPE_ID']);
    $rti_node->addChild('RoomTypeName', $value['TYPE_NAME']);

    for ($i=$value['PLN_MIN']; $i <= $value['PLN_MAX'] ; $i++) { 
      $rate_node = $rti_node->addChild('RateInformation');
      $rate_node->addChild('RateTypeCode', '0'.$i);
      $rate_node->addChild('RateTypeName', $i.'名');
      // $rate_node->addChild('SalesRateWeekday');
      $rate_node->addChild('RegularRateWeekday', $value['PLN_CHG_PERSON'.$i]);
      // $rate_node->addChild('SalesRateBeforeHoliday');
      $rate_node->addChild('RegularRateBeforeHoliday', $value['PLN_CHG_PERSON'.$i]);
      // $rate_node->addChild('SalesRateHoliday');
      $rate_node->addChild('RegularRateHoliday', $value['PLN_CHG_PERSON'.$i]);
      // $rate_node->addChild('SalesRateFriday');
      $rate_node->addChild('RegularRateFriday', $value['PLN_CHG_PERSON'.$i]);
    }

    if ($value['PLN_FLG_CHILD1']+$value['PLN_FLG_CHILD2']+$value['PLN_FLG_CHILD3']+$value['PLN_FLG_CHILD4']+$value['PLN_FLG_CHILD5']+$value['PLN_FLG_CHILD6'] != 0) {
    
      $cbi_node = $rti_node->addChild('ChildBasicInformation');
      $cbi_node->addChild('ChildBasicReceive');

      for ($i=1; $i <=6 ; $i++) { 
        if ($value['PLN_FLG_CHILD'.$i] == '1') {
          $cri_node = $rti_node->addChild('ChildRateInformation');
          if ($i == 1) {
            $cri_node->addChild('ChildRateCode','1');
            $cri_node->addChild('ChildCategoryName','小学生');
          }else if ($i == 2) {
            $cri_node->addChild('ChildRateCode','3');
            $cri_node->addChild('ChildCategoryName','幼児（食・寝）');
          }else if ($i == 3) {
            $cri_node->addChild('ChildRateCode','5');
            $cri_node->addChild('ChildCategoryName', '幼児（寝）');
          }else if ($i == 4) {
            $cri_node->addChild('ChildRateCode','4');
            $cri_node->addChild('ChildCategoryName', '幼児（食）');
          }else if ($i == 5) {
            $cri_node->addChild('ChildRateCode','6');
            $cri_node->addChild('ChildCategoryName', '幼児（なし）');
          }else if ($i == 6) {
            $cri_node->addChild('ChildRateCode','99');
            $cri_node->addChild('ChildCategoryName', '乳児');
          }
          // $cri_node->addChild('ChildRateCode');
          // $cri_node->addChild('ChildCategoryName');
          $cri_node->addChild('ChildReceive','1');


          if ($value['PLN_CAL_CHILD'.$i] == '1') {
            $cri_node->addChild('ChildRateCategory','1');
          }else if ($value['PLN_CAL_CHILD'.$i] == '2') {
            $cri_node->addChild('ChildRateCategory','0');
            $cri_node->addChild('ChildRate', $value['PLN_VAL_CHILD'.$i]);
          }else if ($value['PLN_CAL_CHILD'.$i] == '3') {
            $cri_node->addChild('ChildRateCategory','2');
          }
          $cri_node->addChild('ChildPersonCalcCategory');
          // $cri_node->addChild('ChildMealConditionBreakfast');
          // $cri_node->addChild('ChildMealConditionDinner');
          // $cri_node->addChild('ChildMealConditionLunch');          
        }
      }
    }
  }

  echo $xml->asXml();
  return ;
}


public function  post_neppan003()
{
  $this->format = 'xml';
  // $this->xml_basenode = 'CommodityRoomTypeReply';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post, 'xml')->to_array();

  $res = $this->validation($post , '003');


  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><BlockReportReply></BlockReportReply>';
  $xml = simplexml_load_string($xml_root);

  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','GetStockInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s')); 

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }


  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts);

  if ($sts == '99') {
    $ri_node->addChild("Detail",$reason); 
  }
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }


  $plan = Model_M_Plan_Rtype::forge();
  $params = $post['BlockReportInformation'];

  if (isset($params['BlockRoomTypeCode'])) {
    $params = array($params);
  }

    $brr_node = $xml->addChild('BlockReportInformation');


  foreach ($params as $p => $param) {
    if ( isset ( $param['BlockPlanTypeCode'])) {
      $plan_id = $param['BlockPlanTypeCode'];
    }else{
      $plan_id = null;
    }

    $start   = $param['TermFrom'];
    $end     = $param['TermTo'];
    $type_id = $param['BlockRoomTypeCode'];
    $diff = (strtotime($end) - strtotime($start)) / ( 60 * 60 * 24);

    if ($plan_id != null) { 
      $brr_node = $this->neppan003_exist_plan_id($htl_data['HTL_ID'] ,$plan_id, $type_id, $diff, $brr_node, $start, $plan);
    }else{
      $brr_node = $this->neppan003_no_plan_id($htl_data['HTL_ID'] ,$plan_id, $type_id, $diff, $brr_node, $start, $plan);
    }
  }


  echo $xml->asXml();
  return ;
}

private function neppan003_no_plan_id($htl_id ,$plan_id, $type_id, $diff, $xml, $start, $dao)
{
  $brl_node = $xml->addChild('BlockReportList');
  $brl_node->addChild('BlockRoomTypeCode', $type_id);


  for ($i=0; $i <=$diff ; $i++) { 
    $period = date('Y-m-d', strtotime($start . '+' . $i . 'days'));

    $stock_data = $dao->get_zaiko_one_day_noplanid($htl_id,  $type_id, $period);
    if ($stock_data == 0) {
      $stock_node = $brl_node->addChild('StockList');
      
      $err_node = $stock_node->addChild('ErrorInformation');
      $err_node->addChild('DateErrorCode','1');
      $err_node->addChild('DateErrorText', 'No Data');  
    }else{
      $stock_node = $brl_node->addChild('StockList');
      $stock_node->addChild('UseDate', $period);
      $stock_node->addChild('StockQuantity', $stock_data['RM_NUM'] + $stock_data['ZOUGEN_NUM']);
      $stock_node->addChild('ReserveQuantity', $stock_data['URIAGE']);
      $stock_node->addChild('SalesQuantity', $stock_data['RM_NUM'] + $stock_data['ZOUGEN_NUM'] - $stock_data['URIAGE']);
      if ($period < date('Y-m-d')) {
        $flg = '1';
      }else{
        $flg = '0';
      }
      $stock_node->addChild('SalesCategory', $flg);
      if ($stock_data['RM_USE_FLG'] == '1') {
          if ($stock_data['MRR_STOP_FLG'] == '1') {
            $flg = '1';
          }else{
            $flg = '0';
          }
      }else{
        $flg = '1';
      }
      $stock_node->addChild('CloseCategory', $flg);
    }
  }

  return $xml;
}



private function neppan003_exist_plan_id($htl_id ,$plan_id, $type_id, $diff, $xml, $start, $dao)
{
  $brl_node = $xml->addChild('BlockReportList');
  $brl_node->addChild('BlockRoomTypeCode', $type_id);
  $brl_node->addChild('BlockPlanCode', $plan_id);


  for ($i=0; $i <=$diff ; $i++) { 
    $period = date('Y-m-d', strtotime($start . '+' . $i . 'days'));

    $stock_data = $dao->get_zaiko_one_day($htl_id, $plan_id, $type_id, $period);

    if ($stock_data == 0) {
      $stock_node = $brl_node->addChild('StockList');
      
      $err_node = $stock_node->addChild('ErrorInformation');
      $err_node->addChild('DateErrorCode','1');
      $err_node->addChild('DateErrorText', 'No Data');  
    }else{
      $stock_node = $brl_node->addChild('StockList');
      $stock_node->addChild('UseDate', $period);
      $stock_node->addChild('StockQuantity', $stock_data['RM_NUM'] + $stock_data['ZOUGEN_NUM']);
      $stock_node->addChild('ReserveQuantity', $stock_data['URIAGE']);
      $stock_node->addChild('SalesQuantity', $stock_data['RM_NUM'] + $stock_data['ZOUGEN_NUM'] - $stock_data['URIAGE']);
      if($period == date('Y-m-d', strtotime('-1 day'))){
        $plan_data = Model_M_Plan::find_one_by(array('HTL_ID' => $htl_id,'PLN_ID' => $plan_id));
        if ($plan_data->PLN_LIMIT_TIME != null ) {
          $ltime = $plan_data->PLN_LIMIT_TIME - 24;
          $ltime = date('H:i:s', strtotime('0'.$ltime.':00:00')); 
          if (date('H:i:s') <= $ltime) {
            $flg = '0';
          }else{
            $flg = '1';
          }
        }else{
          $flg = '1';
        }
      }else if ($period < date('Y-m-d')) {
        $flg = '1';
      }else{
        $flg = '0';
      }
      $stock_node->addChild('SalesCategory', $flg);
      if ($stock_data['RM_USE_FLG'] == '1' && $stock_data['PLN_USE_FLG'] == '1') {
        if ($stock_data['RPR_STOP_FLG'] == '0') {
            $flg = '0';
        }else if ($stock_data['RPR_STOP_FLG'] == '1') {
            $flg = '1';
        }else{
          if ($stock_data['MRR_STOP_FLG'] == '1') {
            $flg = '1';
          }else{
            $flg = '0';
          }
        }
      }else{
        $flg = '1';
      }
      $stock_node->addChild('CloseCategory', $flg);
    }
  }

  return $xml;
}


public function post_neppan004()
{
  $this->format = 'xml';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post,'xml')->to_array();

  $res = $this->validation($post , '004');

  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><InventorySettingReply></InventorySettingReply>';
  $xml = simplexml_load_string($xml_root);

  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','SetStockInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s'));


  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts); 
  if ($sts == '99') {
    $ri_node->addChild("Detail",$reason); 
  }
  
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }

  $params = $post['InventorySettingInformation']['InventorySettingList'];



  if (isset($params['BlockRoomTypeCode'])) {
    $params = array($params);
  }


  $isl_node = $xml->addChild('InventorySettingInformation');
  $rmamount = Model_M_Rtype_Roomamount::forge();
  $rp_rmnum = Model_R_Plan_Rmnum::forge();

  foreach ($params as $key => $param) {
    if (isset($param['StockList']['UseDate'])) {
      $params[$key]['StockList'] = array($param['StockList']);
    }

    $bl_node = $isl_node->addChild('InventorySettingList');
    $bl_node->addChild('BlockRoomTypeCode', $param['BlockRoomTypeCode']);
    if (isset($param['BlockPlanCode']) && $param['BlockPlanCode'] != null) {
      $bl_node->addChild('BlockPlanCode', $param['BlockPlanCode']);
    }

    foreach ($params[$key]['StockList'] as $k => $val) {
      $plan_id = null;
      if (isset($param['BlockPlanCode']) && $param['BlockPlanCode'] != null) {
        $plan_id = $param['BlockPlanCode'];
      }
      $rl_node = $bl_node->addChild('StockList');
      $rl_node->addChild('UseDate', $val['UseDate']);

      $result = $rmamount->get_one_rmamount_for_neppan($htl_data['HTL_ID'], $plan_id, $param['BlockRoomTypeCode'], $val['UseDate']);

      if (count($result) == 1) {
        $err_node = $rl_node->addChild('ErrorInformation');
        $err_node->addChild('DateErrorCode', '1');        
        $err_node->addChild('DateErrorText', $result);        
      }else{
        if ($val['CloseCategory'] == '1') {
          $flg = '1';
        }else{
          $flg = '0';
        }
        if ($plan_id != null){
          /*


              プラン在庫欲求の場合


          */
        }else if($result['URIAGE'] < ($val['StockQuantity'] - $val['SalesQuantity']) ) {
          $syusei_num = $val['SalesQuantity'] + $result['URIAGE'] - $result['RM_NUM'];

          if ($result['flg'] == 'insert') {
            $rmamount->insert_rmamount($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg, $syusei_num);
            $rp_rmnum->update_rmnum_all($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg);
          }else{
            $rmamount->update_rmamount($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg, null);
            $rmamount->update_rmamount($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], null, $syusei_num);
            $rp_rmnum->update_rmnum_all($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg);
          }
        }else{ /*フラグの更新のみ*/
          if ($result['flg'] == 'insert') {
            $rmamount->insert_rmamount($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg, 0);
            $rp_rmnum->update_rmnum_all($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg);
          }else{
            $rmamount->update_rmamount($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg, null);
            $rp_rmnum->update_rmnum_all($htl_data['HTL_ID'], $param['BlockRoomTypeCode'], $val['UseDate'], $flg);
          }
        }
      }
    }
  }


  echo $xml->asXml();
  return ;
}


public function post_neppan005()
{
  $this->format = 'xml';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post,'xml')->to_array();

  $res = $this->validation($post , '005');

  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><RateReply></RateReply>';
  $xml = simplexml_load_string($xml_root);

  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','GetPriceInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s'));

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts); 
  if ($sts != '0') {
    $ri_node->addChild("Detail",$reason); 
  }
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }

  $params = $post['RateInformation'];

  if (isset($params['BlockPlanCode'])) {
    $params = array($params);
  }



  $plan_rtype = Model_M_Plan_Rtype::forge();
  $rate_node = $xml->addChild('RateInformation');


  foreach ($params as $key => $param) {
    $ids = explode('_', $param['BlockPlanCode']);
    $plan_id = $ids['0'];
    $type_id = $ids['1'];

    $diff = (strtotime($param['TermTo']) - strtotime($param['TermFrom'])) / ( 60 * 60 * 24);

    $plan_data = $plan_rtype->get_plan_rtype_for_neppan($htl_data['HTL_ID'], $plan_id, $type_id, $param['TermFrom'], $param['TermTo']);


    if (count($plan_data) != 0) {    
      // $rate_node = $xml->addChild('RateInformation');
      $br_node = $rate_node->addChild('BlockReportList');
      $br_node->addChild('BlockPlanCode', $plan_id.'_'.$type_id);
      

      for ($i=0; $i <= $diff ; $i++) { 
        $period = date('Y-m-d', strtotime($param['TermFrom'] . '+' . $i . 'days'));
        $pl_node = $br_node->addChild('PriceList');
        $pl_node->addChild('UseDate', $period);


        $val = array(
            'e1' => 0,
            'e2' => 0,
            'e3' => 0,
            'e4' => 0,
            'e5' => 0,
            'e6' => 0,
          );
        foreach ($plan_data as $key => $value) {
          if (array_search($period, $value)) {
              $val['e1'] = $value['PLN_CHG_EXCEPTION1'];
              $val['e2'] = $value['PLN_CHG_EXCEPTION2'];
              $val['e3'] = $value['PLN_CHG_EXCEPTION3'];
              $val['e4'] = $value['PLN_CHG_EXCEPTION4'];
              $val['e5'] = $value['PLN_CHG_EXCEPTION5'];
              $val['e6'] = $value['PLN_CHG_EXCEPTION6'];
          }
        }



        if ($plan_data['0']['PLN_MIN'] <= 1 && $plan_data['0']['PLN_MAX'] >= 1) {
          $rtl_node = $pl_node->addChild('RateTypeList');
          $rtl_node->addChild('RateTypeCode','01');
          $rtl_node->addChild('RateTypeName','大人1名');
          $rtl_node->addChild('Price',$plan_data['0']['PLN_CHG_PERSON1'] + $val['e1']);
          $rtl_node->addChild('RegularPrice',$plan_data['0']['PLN_CHG_PERSON1']);    
        }


        if ($plan_data['0']['PLN_MIN'] <= 2 && $plan_data['0']['PLN_MAX'] >= 2) {
          $rtl_node = $pl_node->addChild('RateTypeList');
          $rtl_node->addChild('RateTypeCode','02');
          $rtl_node->addChild('RateTypeName','大人2名');
          $rtl_node->addChild('Price',$plan_data['0']['PLN_CHG_PERSON2'] + $val['e2']);
          $rtl_node->addChild('RegularPrice',$plan_data['0']['PLN_CHG_PERSON2']);
        }


        if ($plan_data['0']['PLN_MIN'] <= 3 && $plan_data['0']['PLN_MAX'] >= 3) {
          $rtl_node = $pl_node->addChild('RateTypeList');
          $rtl_node->addChild('RateTypeCode','03');
          $rtl_node->addChild('RateTypeName','大人3名');
          $rtl_node->addChild('Price',$plan_data['0']['PLN_CHG_PERSON3'] + $val['e3']);
          $rtl_node->addChild('RegularPrice',$plan_data['0']['PLN_CHG_PERSON3']);
        }

        if ($plan_data['0']['PLN_MIN'] <= 4 && $plan_data['0']['PLN_MAX'] >= 4) {
          $rtl_node = $pl_node->addChild('RateTypeList');
          $rtl_node->addChild('RateTypeCode','04');
          $rtl_node->addChild('RateTypeName','大人4名');
          $rtl_node->addChild('Price',$plan_data['0']['PLN_CHG_PERSON4'] + $val['e4']);
          $rtl_node->addChild('RegularPrice',$plan_data['0']['PLN_CHG_PERSON4']);
        }


        if ($plan_data['0']['PLN_MIN'] <= 5 && $plan_data['0']['PLN_MAX'] >= 5) {
          $rtl_node = $pl_node->addChild('RateTypeList');
          $rtl_node->addChild('RateTypeCode','05');
          $rtl_node->addChild('RateTypeName','大人5名');
          $rtl_node->addChild('Price',$plan_data['0']['PLN_CHG_PERSON5'] + $val['e5']);
          $rtl_node->addChild('RegularPrice',$plan_data['0']['PLN_CHG_PERSON5']);
        }

        if ($plan_data['0']['PLN_MIN'] <= 6 && $plan_data['0']['PLN_MAX'] >= 6) {
          $rtl_node = $pl_node->addChild('RateTypeList');
          $rtl_node->addChild('RateTypeCode','06');
          $rtl_node->addChild('RateTypeName','大人6名');
          $rtl_node->addChild('Price',$plan_data['0']['PLN_CHG_PERSON6'] + $val['e6']);
          $rtl_node->addChild('RegularPrice',$plan_data['0']['PLN_CHG_PERSON6']);
        }
        // $ei_node = $pl_node->addChild('ErrorInformation');
        // $ei_node->addChild('DateErrorCode', '');
        // $ei_node->addChild('DateErrorText', '');
      
      }
    }
  }

  echo $xml->asXml();
  return ;
}



public function post_neppan006()
{
  $this->format = 'xml';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post, 'xml')->to_array();

  $res = $this->validation($post , '006');

  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><RateSettingReply></RateSettingReply>';
  $xml = simplexml_load_string($xml_root);

  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName);
  $tr_node->addChild('DataClassification', 'SetPriceInformation');
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s')); 

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts); 
  if ($sts == '99') {
    $ri_node->addChild("Detail",$reason); 
  }
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }

  $plan_rtype = Model_M_Plan_Rtype::forge();

  $params = $post['RateSettingInformation']['RateSettingList'];
  if (isset($params['BlockPlanCode'])) {
    $params = array($params);
  }
  
  $rsl_node = $xml->addChild('RateSettingInformation');
  $plan_id = 0; $type_id = 0;
  foreach ($params as $key => $param) {
    if (isset($param['UseDateList']['UseDate'])) {
      $params[$key]['UseDateList'] = array($params[$key]['UseDateList']);
    }
    $ids = explode('_', $param['BlockPlanCode']);
    $plan_id = $ids['0'];
    $type_id = $ids['1'];

    $bt_node = $rsl_node->addChild('RateSettingList');
    $bt_node->addChild('BlockPlanCode', $param['BlockPlanCode']);

    foreach ($params[$key]['UseDateList'] as $k => $sdList) {
      if (isset($sdList['RateTypeList']['RateTypeCode'])) {
        $params[$key]['UseDateList'][$k]['RateTypeList'] = array($params[$key]['UseDateList'][$k]['RateTypeList']);
      }
      
      $date = $sdList['UseDate'];
      $day_node = $bt_node->addChild('UseDateList');
      $day_node->addChild('UseDate', $date);

      
      $result = $plan_rtype->update_price_neppan006($params[$key]['UseDateList'][$k]['RateTypeList'], $htl_data['HTL_ID'], $plan_id, $type_id, $date);

      if ($result !== 0) {
        $err_node = $day_node->addChild('ErrorInformation');
        $err_node->addChild('DateErrorCode','1');
        $err_node->addChild('DateErrorText',$result);
      }
    }
  }

  echo $xml->asXml();
  return ;
}





public function post_neppan007()
{
  $this->format = 'xml';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post, 'xml')->to_array();

  $res = $this->validation($post , '007');

  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><BookingListReply></BookingListReply>';
  $xml = simplexml_load_string($xml_root);


  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','GetRecordListInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s')); 

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts);
  if ($sts == '99') {
    $ri_node->addChild("Detail",$reason); 
  }
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }

  $rsv = Model_T_Rsv::forge();
  $rsv_data = $rsv->get_rsv_for_neppan007($post['BookingSearchListInformation']['TermFrom'], 
                                          $post['BookingSearchListInformation']['TermTo'], 
                                          $post['BookingSearchListInformation']['ReserveCategory'], 
                                          $post['BookingSearchListInformation']['SearchCategory']);

  
  $bsli_node = $xml->addChild('BookingSearchListInformation');  

  foreach ($rsv_data as $key => $value) {
    $booking_node = $bsli_node->addChild('BookingList');
    $booking_node->addChild('ReservedID', 'stm'.$value['RSV_NO']);
    if ($value['RSV_STS'] == '1' || $value['RSV_STS'] == '0') {
      if ($value['RSV_DATE'] == $value['UP_DATE']) {
        $flg = '1';
      }else{
        $flg = '2';
      }
    }else if ($value['RSV_STS'] == '9') {
      $flg = '3';
    }
    $booking_node->addChild('ReservedStatus', $flg);
    $booking_node->addChild('CheckInDate', date('Y-m-d', strtotime($value['IN_DATE'])));
    $booking_node->addChild('CheckOutDate', date('Y-m-d', strtotime($value['OUT_DATE'])));
    $booking_node->addChild('LastUpdateDate', date('Y-m-d', strtotime($value['UP_DATE'])));
    $booking_node->addChild('LastUpdateTime', date('H:i:s', strtotime($value['UP_DATE'])));
  }


  echo $xml->asXml();
  return ;

}


public function post_neppan008()
{
  $this->format = 'xml';
  $this->response->set_header('Content-Type', 'text/xml');

  $post = file_get_contents('php://input');
  $post = Format::forge($post, 'xml')->to_array();

  $res = $this->validation($post , '008');

  $xml_root = '<?xml version="1.0" encoding="UTF-8"?><BookingDetailReply></BookingDetailReply>';
  $xml = simplexml_load_string($xml_root);


  $tr_node = $xml->addChild('TransactionType');
  $tr_node->addChild('DataFrom', 'from'.$this->systemName); 
  $tr_node->addChild('DataClassification','GetRecordDetailInformation'); 
  $tr_node->addChild('SystemDate',date('Y-m-d')); 
  $tr_node->addChild('SystemTime',date('H:i:s')); 

  if ($res != '0'){
    $ri_node = $xml->addChild('ResultInformation');
    $ri_node->addChild('ResultCode','99');
    $ri_node->addChild("Detail",$res);
    echo $xml->asXml();
    return ;
  }

  $htl_data = $this->login($post['AttestationInformation']['LoginID'], $post['AttestationInformation']['LoginPassword']);
  $sts = '0'; $reason = '';
  if (!isset($htl_data['HTL_ID'])) {
     $sts = '1';
     $reason = $htl_data;
  }
  $ri_node = $xml->addChild('ResultInformation');
  $ri_node->addChild('ResultCode',$sts); 
  $ri_node->addChild("Detail",$reason); 
  
  if (!isset($htl_data['HTL_ID'])) {
    echo $xml->asXml();
    return ;
  }

  $rsv_no = $post['BookingDetailListInformation']['ReservedID'];


  $d_rsv = Model_T_Rsv_Detail::forge();
  // $rsv_data = $d_rsv->get_rsv_detail_neppan($htl_data['HTL_ID'], '1'); 
  // $rsv_data = $d_rsv->get_rsv_detail_neppan($htl_data['HTL_ID'], $post['BookingDetailListInformation']['ReservedID']); 

  if (count($rsv_no) == 1) {
    $rsv_no = array($rsv_no);
  }


  $bdli_node = $xml->addChild('BookingDetailListInformation');


  foreach ($rsv_no as $key => $value) {
    $rsv_data = $d_rsv->get_rsv_detail_neppan($htl_data['HTL_ID'], str_ireplace('stm', '', $value));

    if ($rsv_data != 0) {
      $b_info = $rsv_data['0'];

      $bdi_node = $bdli_node->addChild('BookingDetailInformation');
  
      $adi_node = $bdi_node->addChild('AccommodationInformation');
      $adi_node->addChild('AccommodationName', $b_info['HTL_ID']);
      $adi_node->addChild('AccommodationCode', $b_info['HTL_NAME']);
    
    
      $soi_node = $bdi_node->addChild('SalesOfficeInformation');
      $soi_node->addChild('SalesOfficeCompanyName', $this->systemName);
      // $soi_node->addChild('SalesOfficeName', '');
      // $soi_node->addChild('RetailerCompanyName', '');
    
    
      $bi_node = $bdi_node->addChild('BasicInformation');
      $bi_node->addChild('ReservedID', 'stm'.$b_info['RSV_NO']);
      $bi_node->addChild('TravelAgencyBookingDate', date('Y-m-d', strtotime($b_info['RSV_DATE'])));
      $bi_node->addChild('TravelAgencyBookingTime', date('H:i:s', strtotime($b_info['RSV_DATE'])));
      // $bi_node->addChild('TravelAgencyReportNumber', '');
      $bi_node->addChild('GuestOrGroupNameSingleByte', mb_convert_kana($b_info['USR_KANA'], "k"));
      $bi_node->addChild('GuestOrGroupNameDoubleByte', mb_convert_kana($b_info['USR_KANA'], "K"));
      $bi_node->addChild('GuestOrGroupKanjiName', '');
      $bi_node->addChild('CheckInDate', date('Y-m-d', strtotime($b_info['rsvsIN_DATE'])));
      $bi_node->addChild('CheckInTime', $b_info['rsv_detailsIN_DATE']);
      $bi_node->addChild('CheckOutDate', date('Y-m-d', strtotime($b_info['OUT_DATE'])));
      $bi_node->addChild('CheckOutTime', '10:00');
      $bi_node->addChild('Nights', $b_info['NUM_STAY']);
      // $bi_node->addChild('Transportaｔion', '');
      $bi_node->addChild('TotalRoomCount', $b_info['NUM_ROOM']);
  
      $sum = 0;
      $man = 0;
      $woman  = 0;
      $child1 = 0;
      $child2 = 0;
      $child3 = 0;
      $child4 = 0;
      $child5 = 0;
      $child6 = 0;
  
      $man    = $b_info['PLN_NUM_MAN'];
      $woman  = $b_info['PLN_NUM_WOMAN'];
      $child1 = $b_info['PLN_NUM_CHILD1'];
      $child2 = $b_info['PLN_NUM_CHILD2'];
      $child3 = $b_info['PLN_NUM_CHILD3'];
      $child4 = $b_info['PLN_NUM_CHILD4'];
      $child5 = $b_info['PLN_NUM_CHILD5'];
      $child6 = $b_info['PLN_NUM_CHILD6'];
  
      $sum = $man + $woman + $child1 + $child2 + $child3 + $child4 + $child5 + $child6;
  
      $bi_node->addChild('GrandTotalPaxCount', $sum);
      $bi_node->addChild('TotalPaxMaleCount', $man);
      $bi_node->addChild('TotalPaxFemaleCount', $woman);
      $bi_node->addChild('TotalChildA70Count', $child1);
      $bi_node->addChild('TotalChildB50Count', $child2);
      $bi_node->addChild('TotalChildC30Count', $child3);
      $bi_node->addChild('TotalChildDNoneCount', $child4);
      $bi_node->addChild('TotalChildECount', $child5);
      $bi_node->addChild('TotalChildFCount', $child6);
      $bi_node->addChild('TotalChildOtherCount', '0');
      $bi_node->addChild('TotalChildA70Name', '小学生');
      $bi_node->addChild('TotalChildB50Name', '幼児（食事あり、寝具あり）');
      $bi_node->addChild('TotalChildC30Name', '幼児（食事あり、寝具なし）');
      $bi_node->addChild('TotalChildDNoneName', '幼児（食事なし、寝具あり）');
      $bi_node->addChild('TotalChildEName', '幼児（食事なし、寝具なし）');
      $bi_node->addChild('TotalChildFName', '乳児');
      $bi_node->addChild('TotalChildOtherName', 'その他');
  
      $st = '';
      if ($b_info['RSV_STS'] == '1' || $b_info['RSV_STS'] == '0') {
        if ($b_info['RSV_DATE'] == $b_info['UP_DATE']) {
          $st = 'Reserved';
        }else{
          $st = 'Changed';
        }
      }else if ($b_info['RSV_STS'] == '9') {
        $st = 'Cancel';
      }
  
      $bi_node->addChild('Status', $st);
      $bi_node->addChild('BlockPlanName', $b_info['PLN_NAME']);
      $bi_node->addChild('BlockPlanCode', $b_info['PLN_ID'].'_'.$b_info['TYPE_ID']);
      // $bi_node->addChild('PackagePlanContent', '');
      $bi_node->addChild('MealCondition', 'WithoutMeal');
      // $bi_node->addChild('SpecificMealCondition', '');
      // $bi_node->addChild('SpecialServiceRequest', '');
      // $bi_node->addChild('OtherServiceInformation', '');
      $bi_node->addChild('MemberNumber', $b_info['USR_ID']);
      $bi_node->addChild('ReservedPersonNameSingleByte', mb_convert_kana($b_info['USR_KANA'], "k"));
      $bi_node->addChild('ReservedPersonNameDoubleByte', mb_convert_kana($b_info['USR_KANA'], "K"));
      $bi_node->addChild('ReservedPersonKanjiName', $b_info['USR_NAME']);
      // $bi_node->addChild('ReservedPersonOfficeName', '');
      $bi_node->addChild('ReservedPersonDateOfBirth', $b_info['USR_BIRTH']);
      $bi_node->addChild('ReservedPersonPhoneNumber', $b_info['USR_TEL']);
      // $bi_node->addChild('ReservedPersonEmergencyPhoneNumber', '');
      $bi_node->addChild('ReservedPersonEmail', $b_info['USR_MAIL']);
      // $bi_node->addChild('ReservedPersonCountry', '');
      // $bi_node->addChild('ReservedPersonStateProvidence', '');
      // $bi_node->addChild('ReservedPersonCityNamed', '');
      // $bi_node->addChild('ReservedPersonAddressLined', '');
      // $bi_node->addChild('ReservedPersonStreetNumber', '');
      $bi_node->addChild('ReservedPersonPostalCoded', $b_info['ZIP_CD']);
      // $bi_node->addChild('ReservedPersonBuildingName', '');
      $bi_node->addChild('ReservedPersonFax', $b_info['USR_FAX']);
      // $bi_node->addChild('ReservedPersonMobilePhoneNumber', '');
    
      $bri_node = $bdi_node->addChild('BasicRateInformation');
      $bri_node->addChild('RoomRateOrPersonalRate', 'PersonalRate');
      $bri_node->addChild('TaxServiceFee', 'IncludingServiceAndTax');
      if ($b_info['ADJUST_TYPE'] == '1') {
        $flg = 'Cash';
      }else if ($b_info['ADJUST_TYPE'] == '2') {
        $flg = 'CreditCard';
      }
      $bri_node->addChild('Payment', $flg);
      if ($b_info['ADJUST_TYPE'] == '2') {
        $bri_node->addChild('BareNetRate', $b_info['PLN_CHG_TOTAL']);
      }
      $bri_node->addChild('DiscountPoint', $b_info['PT_USE']);
      $bri_node->addChild('DiscountPointName', '会員ポイント');
      if ($b_info['ADJUST_TYPE'] == '1') {
        if ($b_info['PT_USE'] == '0') {
          $pay = $b_info['PLN_CHG_TOTAL'];
        }else{
          $pay = $b_info['PLN_CHG_TOTAL'] + DISCOUNT;
        }
      }else{
        $pay = '0';
      }
      $bri_node->addChild('DiscountTotalAccommodationCharge', $pay);
      $bri_node->addChild('TotalAccommodationCharge', $b_info['PLN_CHG_TOTAL']);
      $tax = intval($b_info['PLN_CHG_TOTAL']) - intval($b_info['PLN_CHG_TOTAL']) / $this->tax_rate;
      $bri_node->addChild('TotalAccommodationConsumptionTax', round($tax));
      // $bri_node->addChild('TotalAccommodationHotSpringTax', '');
      // $bri_node->addChild('TotalAccommodationHotelTax', '');
      // $bri_node->addChild('TotalAccommodationServiceFee', '');
      // $bri_node->addChild('TotalAccommodationBreakfastFee', '');
      // $bri_node->addChild('TotalAccommodationOtherFee', '');
    
      // $cl_node = $bri_node->addChild('CouponList');
      // $cl_node->addChild('CouponAmount', '');
      // $cl_node->addChild('CouponType', '');
      // $cl_node->addChild('CouponNumber', '');
      // $cl_node->addChild('CouponIssueDate', '');
    
      $ragi_node = $bdi_node->addChild('RoomAndGuestInformation');
      foreach ($rsv_data['1'] as $k => $val) {
        $basic_rtype = reset($val);

        $ragl_node = $ragi_node->addChild('RoomAndGuestList');
        $rmi_node = $ragl_node->addChild('RoomInformation');
        $rmi_node->addChild('BlockRoomTypeCode', $basic_rtype['TYPE_ID']);
        $rmi_node->addChild('BlockRoomTypeName', $basic_rtype['TYPE_NAME']);
        $flg = 'Smoking';
        if ($basic_rtype['RM_OPTION'] == '001000') {
          $flg  = 'NoSmoking';
        }
  
  
        $rmi_node->addChild('SmokingOrNonSmoking', $flg);
        $sum = $basic_rtype['PLN_NUM_CHILD1'] + $basic_rtype['PLN_NUM_CHILD2'] + $basic_rtype['PLN_NUM_CHILD3'] + $basic_rtype['PLN_NUM_CHILD4'] + $basic_rtype['PLN_NUM_CHILD5'] + $basic_rtype['PLN_NUM_CHILD6'] + $basic_rtype['PLN_NUM_MAN'] + $basic_rtype['PLN_NUM_WOMAN'];
        $rmi_node->addChild('PerRoomPaxCount', $sum);
        $rmi_node->addChild('RoomPaxMaleCount', $basic_rtype['PLN_NUM_MAN']);
        $rmi_node->addChild('RoomPaxFemaleCount', $basic_rtype['PLN_NUM_WOMAN']);
        $rmi_node->addChild('RoomChildA70Count', $basic_rtype['PLN_NUM_CHILD1']);
        $rmi_node->addChild('RoomChildB50Count', $basic_rtype['PLN_NUM_CHILD2']);
        $rmi_node->addChild('RoomChildC30Count', $basic_rtype['PLN_NUM_CHILD3']);
        $rmi_node->addChild('RoomChildDNoneCount', $basic_rtype['PLN_NUM_CHILD4']);
        $rmi_node->addChild('RoomChildECount', $basic_rtype['PLN_NUM_CHILD5']);
        $rmi_node->addChild('RoomChildFCount', $basic_rtype['PLN_NUM_CHILD6']);
        $rmi_node->addChild('RoomChildOtherCount', '0');
        // $rmi_node->addChild('RoomByRoomStatus', '');
        // $rmi_node->addChild('Facilities', '');
        // $rmi_node->addChild('RoomSpecialRequest', '');
    
        // $ol_node = $rmi_node->addChild('OptionList');
        // $ol_node->addChild('OptionDate', '');
        // $ol_node->addChild('OptionName', '');
        // $ol_node->addChild('OptionCount', '');
        // $ol_node->addChild('OptionRate', '');
        // $ol_node->addChild('TotalOptionRate', '');
        
        foreach ($val as $day => $v) {
          $rmri_node = $ragl_node->addChild('RoomRateInformation');
          $rmri_node->addChild('RoomDate', $day);
          // $rmri_node->addChild('PerPaxRate', '');
          $rmri_node->addChild('PerPaxMaleRate', $v['PLN_CHG_MAN']);
          $rmri_node->addChild('PerPaxFemaleRate', $v['PLN_CHG_WOMAN']);
          $rmri_node->addChild('PerChildA70Rate', $v['PLN_CHG_CHILD1']);
          $rmri_node->addChild('PerChildB50Rate', $v['PLN_CHG_CHILD2']);
          $rmri_node->addChild('PerChildC30Rate', $v['PLN_CHG_CHILD3']);
          $rmri_node->addChild('PerChildDRate', $v['PLN_CHG_CHILD4']);
          $rmri_node->addChild('PerChildERate', $v['PLN_CHG_CHILD5']);
          $rmri_node->addChild('PerChildFRate', $v['PLN_CHG_CHILD6']);
          $rmri_node->addChild('PerChildOtherRate', '0');
          $sum = $v['PLN_CHG_MAN'] + $v['PLN_CHG_WOMAN'] + $v['PLN_CHG_CHILD1'] + $v['PLN_CHG_CHILD2'] + $v['PLN_CHG_CHILD3'] + $v['PLN_CHG_CHILD4'] + $v['PLN_CHG_CHILD5'] + $v['PLN_CHG_CHILD6'];
          $rmri_node->addChild('TotalPerRoomRate', $sum);
          // $rmri_node->addChild('TotalPerRoomConsumptionTax', '');
          // $rmri_node->addChild('TotalPerRoomHotSpringTax', '');
          // $rmri_node->addChild('TotalPerRoomHotelTax', '');
          // $rmri_node->addChild('TotalPerRoomServiceFee', '');
          // $rmri_node->addChild('TotalPerRoomBreakfastFee', '');
          // $rmri_node->addChild('TotalPerRoomOtherFee', '');

          $man    = $v['PLN_NUM_MAN'];
          $woman  = $v['PLN_NUM_WOMAN'];
          $child1 = $v['PLN_NUM_CHILD1'];
          $child2 = $v['PLN_NUM_CHILD2'];
          $child3 = $v['PLN_NUM_CHILD3'];
          $child4 = $v['PLN_NUM_CHILD4'];
          $child5 = $v['PLN_NUM_CHILD5'];
          $child6 = $v['PLN_NUM_CHILD6'];

          $rmri_node->addChild('RoomDatePaxCount', $man + $woman);
          $rmri_node->addChild('RoomDatePaxMaleCount', $man);
          $rmri_node->addChild('RoomDatePaxFemaleCount', $woman);
          $rmri_node->addChild('RoomDateChildA70Count', $child1);
          $rmri_node->addChild('RoomDateChildB50Count', $child2);
          $rmri_node->addChild('RoomDateChildC30Count', $child3);
          $rmri_node->addChild('RoomDateChildDCount', $child4);
          $rmri_node->addChild('RoomDateChildECount', $child5);
          $rmri_node->addChild('RoomDateChildFCount', $child6);
          $rmri_node->addChild('RoomDateChildOtherCount', '0');
          $sum = $man + $woman + $child1 + $child2 + $child3 + $child4 + $child5 + $child6;
          $rmri_node->addChild('TotalRoomDateCount', $sum);
        }
    
    
        $gi_node = $ragl_node->addChild('GuestInformation');
        $gil_node = $gi_node->addChild('GuestInformationList');
        $gil_node->addChild('GuestNameSingleByte', mb_convert_kana($b_info['USR_KANA'], "k"));
        $gil_node->addChild('GuestSurName', mb_convert_kana($b_info['USR_SEI'], "Hc"));
        $gil_node->addChild('GuestGivenName', mb_convert_kana($b_info['USR_MEI'], "Hc"));
        // $gil_node->addChild('GuestMiddleName', '');
        // $gil_node->addChild('GuestNamePrefix', '');
        $gil_node->addChild('GuestKanjiName', $b_info['USR_NAME']);
        if ($b_info['USR_SEX'] == '1') {
          $flg = 'Male';
        }else if ($b_info['USR_SEX'] == '2') {
          $flg = 'Female';
        }else{
          $flg = 'Unknown';
        }
        $gil_node->addChild('GuestGender', $flg);
        // $gil_node->addChild('GuestAge', '');
        $gil_node->addChild('GuestDateOfBirth', $b_info['USR_BIRTH']);
        // $gil_node->addChild('GuestShubetsu', '');
        $gil_node->addChild('GuestPhoneNumber', $b_info['USR_TEL']);
        // $gil_node->addChild('GuestEmergencyPhoneNumber', '');
        $gil_node->addChild('GuestEmail', $b_info['USR_MAIL']);
        // $gil_node->addChild('GuestCountry', '');
        $gil_node->addChild('GuestStateProvidence', '');
        $gil_node->addChild('GuestCityName', '');
        $gil_node->addChild('GuestAddressLine', '');
        $gil_node->addChild('GuestStreetNumber', '');
        $gil_node->addChild('GuestPostalCode', '');
        $gil_node->addChild('GuestBuildingName', '');
        // $gil_node->addChild('SpecialInformation', '');
        $gil_node->addChild('GuestFax', $b_info['USR_FAX']);
        // $gil_node->addChild('GuestMobilePhoneNumber', '');
      }
    }
  }

  echo $xml->asXml();
  return ;

}

private function login($login, $pass)
{
  $htl = Model_M_Htl::forge();
  $htl_data = $htl->get_user($login);
  if ($htl_data == null || $htl_data['ADMIN_PWD'] !=  md5(MD5_SALT . $pass) ) {
    return 'Invalid LoginID or LoginPassword';
  }else{
    return $htl_data;
  }
}

private function validation($post, $api_no)
{
  if (!isset($post['AttestationInformation'])) {
    return 'AttestationInformation is empty.';
  }

  if (!isset($post['AttestationInformation']['LoginID']) || $post['AttestationInformation']['LoginID'] == null) {
    return 'LoginID is empty.';
  }

  if (!isset($post['AttestationInformation']['LoginPassword']) || $post['AttestationInformation']['LoginPassword'] == null) {
    return 'LoginPassword is empty.';
  }



  /*case 003*/
  if ($api_no == '003') {
    if (!isset($post['BlockReportInformation'])) {
      return 'BlockReportInformation is empty.';
    }

    if (isset($post['BlockReportInformation']['0']) && count($post['BlockReportInformation']['0']) > 0 ) {
      $array = $post['BlockReportInformation'];
    }else{
      $array = array($post['BlockReportInformation']);
    }
    foreach ($array as $key => $value) {
      if ( !isset($value['BlockRoomTypeCode']) || $value['BlockRoomTypeCode'] == null) {
        return 'BlockRoomTypeCode is empty.';
      }

      // if ( !isset($value['BlockPlanTypeCode']) || $value['BlockPlanTypeCode'] == null) {
      //   return 'BlockPlanTypeCode is empty.';
      // }

      if ( !isset($value['TermFrom']) || $value['TermFrom'] == null) {
        return 'TermFrom is empty.';
      }
      
      if ( !isset($value['TermTo']) || $value['TermTo'] == null) {
        return 'TermTo is empty.';
      }
    }
  }else if ($api_no == '004') {
    if (!isset($post['InventorySettingInformation'])) {
      return 'InventorySettingInformation is empty.';
    }
    $post = $post['InventorySettingInformation'];

    if (isset($post['InventorySettingList']['0']) && count($post['InventorySettingList']['0']) > 0 ) {
      $array = $post['InventorySettingList'];
    }else{
      $array = array($post['InventorySettingList']);
    }
    foreach ($array as $key => $value) {
      if ( !isset($value['BlockRoomTypeCode']) || $value['BlockRoomTypeCode'] == null) {
        return 'BlockRoomTypeCode is empty.';
      }

      if (!isset($value['StockList'])) {
        return 'StockList is empty.';
      }

      if (isset($value['StockList']['0']) && count($value['StockList']['0']) > 0 ) {
        $array2 = $value['StockList'];
      }else{
        $array2 = array($value['StockList']);
      }
      foreach ($array2 as $k => $val) {
        if ( !isset($val['UseDate']) || $val['UseDate'] == null) {
          return 'UseDate is empty.';
        }

        if ( !isset($val['StockQuantity']) || $val['StockQuantity'] == null) {
          return 'StockQuantity is empty.';
        }

        if ( !isset($val['SalesQuantity']) || $val['SalesQuantity'] == null) {
          return 'SalesQuantity is empty.';
        }

        if ( !isset($val['CloseCategory']) || $val['CloseCategory'] == null) {
          return 'CloseCategory is empty.';
        }
      }
    }    
  }else if ($api_no == '005') {
    if (!isset($post['RateInformation'])) {
      return 'RateInformation is empty.';
    }

    if (isset($post['RateInformation']['0']) && count($post['RateInformation']['0']) > 0 ) {
      $array = $post['RateInformation'];
    }else{
      $array = array($post['RateInformation']);
    }
    foreach ($array as $key => $value) {
      if ( !isset($value['BlockPlanCode']) || $value['BlockPlanCode'] == null) {
        return 'BlockPlanCode is empty.';
      }

      if ( !isset($value['TermFrom']) || $value['TermFrom'] == null) {
        return 'TermFrom is empty.';
      }
      
      if ( !isset($value['TermTo']) || $value['TermTo'] == null) {
        return 'TermTo is empty.';
      }
    }
  }else if ($api_no == '006') {
    if (!isset($post['RateSettingInformation'])) {
      return 'RateSettingInformation is empty.';
    }
    $post = $post['RateSettingInformation'];

    if (isset($post['RateSettingList']['0']) && count($post['RateSettingList']['0']) > 0 ) {
      $array = $post['RateSettingList'];
    }else{
      $array = array($post['RateSettingList']);
    }
    foreach ($array as $key => $value) {
      if ( !isset($value['BlockPlanCode']) || $value['BlockPlanCode'] == null) {
        return 'BlockPlanCode is empty.';
      }

      if (!isset($value['UseDateList'])) {
        return 'UseDateList is empty.';
      }

      if (isset($value['UseDateList']['0']) && count($value['UseDateList']['0']) > 0 ) {
        $array2 = $value['UseDateList'];
      }else{
        $array2 = array($value['UseDateList']);
      }
      foreach ($array2 as $k => $val) {
        if ( !isset($val['UseDate']) || $val['UseDate'] == null) {
          return 'UseDate is empty.';
        }


        if (!isset($val['RateTypeList'])) {
          return 'RateTypeList is empty.';
        }
  
        if (isset($val['RateTypeList']['0']) && count($val['RateTypeList']['0']) > 0 ) {
          $array3 = $val['RateTypeList'];
        }else{
          $array3 = array($val['RateTypeList']);
        }
        foreach ($array3 as $s => $t) {
          if ( !isset($t['RateTypeCode']) || $t['RateTypeCode'] == null) {
            return 'RateTypeCode is empty.';
          }
  
          if ( !isset($t['Price']) || $t['Price'] == null) {
            return 'Price is empty.';
          }
  
          // if ( !isset($t['RegularPrice']) || $t['RegularPrice'] == null) {
          //   return 'RegularPrice is empty.';
          // }
        }
      }
    }  
  }else if ($api_no == '007') {
   if (!isset($post['BookingSearchListInformation'])) {
     return 'BookingSearchListInformation is empty.';
   }
    
   if (!isset($post['BookingSearchListInformation']['TermFrom']) || $post['BookingSearchListInformation']['TermFrom'] == null) {
     return 'TermFrom is empty.';
   }
 
   if (!isset($post['BookingSearchListInformation']['TermTo']) || $post['BookingSearchListInformation']['TermTo'] == null) {
     return 'TermTo is empty.';
   }

   if (!isset($post['BookingSearchListInformation']['ReserveCategory']) || $post['BookingSearchListInformation']['ReserveCategory'] == null) {
     return 'ReserveCategory is empty.';
   }
 
   if (!isset($post['BookingSearchListInformation']['SearchCategory']) || $post['BookingSearchListInformation']['SearchCategory'] == null) {
     return 'SearchCategory is empty.';
   }
  }else if ($api_no == '008') {
    if (!isset($post['BookingDetailListInformation'])) {
      return 'BookingDetailListInformation is empty.';
    }
    $post = $post['BookingDetailListInformation'];

    if (!isset($post['ReservedID'])) {
      return 'ReservedID is empty.';
    }

    if (isset($post['ReservedID']['0']) && count($post['ReservedID']['0']) > 1 ) {
      $array = $post['ReservedID'];
    }else{
      $array = array($post['ReservedID']);
    }
    foreach ($array as $key => $value) {
      if ( !isset($value) || $value == null) {
        return 'ReservedID is empty.';
      }
    }
  }

return '0';
}// validation

}//class end 
