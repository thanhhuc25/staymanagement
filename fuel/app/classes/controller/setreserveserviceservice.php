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
class Controller_Setreserveserviceservice extends Controller_Rest
{


  public function Action_test(){
    // $wsdl = 'http://PATH/TO/WSDL';
    $opt = [
        'trace'=>1,
        'location'=> 'http://52.198.203.99:81/lincoln/sop',  // change end point
        // 'uri'=> '',   // change namespace
    ];

    // $c = new SoapClient($wsdl, $opt);
    $c = new SoapClient(APPPATH.'classes/controller/wsdl/LincolnCommonBtoBServiceService.wsdl', $opt);

    $authHeader = new SoapHeader('http://PATH/TO/NS', 'AuthElementName', [
        'UserName' => 'dd',
        // 'UserName' => $username,
        'Password' => 'dd',
        // 'Password' => $password,
    ]);
    // $c->__setSoapHeaders([$authHeader]);

    $parameters = array(
      'PlanDownloadRequest' => array(
        'LoginId'  => '0001',
        'LoginPwd' => '1234',
      ),
    );

    try {
        $result = $c->PlanDownload($parameters);
        // $result->__soapCall("PlanDownload", $sample_data);
    } catch(\Exception $e) {
        // エラー処理
        $result = null;
        var_dump(get_class($e), $e->getCode(), $e->getMessage());
    }
    var_dump($result);
// var_dump($c);die;
    // var_dump($c->__getFunctions());
    var_dump($c->__getLastRequestHeaders());
    var_dump($c->__getLastRequest());
    var_dump($c->__getLastResponseHeaders());
    var_dump($c->__getLastResponse());
  }

  public function Action_testByCurl()
  {


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://219.127.193.206/lincoln/soap');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
  $arg = $this->StockDataDownloadArg();
  // $arg = $this->TariffDataDownloadArg();
  $arg = $this->AgtRoomStatusUpdateArrayArg();
  // $arg = $this->PlanStatusUpdateArrayArg();
	curl_setopt($ch, CURLOPT_POSTFIELDS, $arg);

	curl_setopt($ch, CURLOPT_USERAGENT, 'staymanager');
	curl_setopt($ch, CURLOPT_VERBOSE, true);

	$result = curl_exec($ch);
	curl_close($ch);

  echo ($result);
	// var_dump($result);
	die();

  }

  private function PlanStatusUpdateArrayArg()
  {
      return '
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.commonb2b.lincoln.seanuts.co.jp/">
         <soapenv:Header/>
         <soapenv:Body>
            <ser:PlanStatusUpdateArray>
               <!--Optional:-->
               <arg0>
                  <!--Optional:-->
                  <LoginId>test002</LoginId>
                  <!--Optional:-->
                  <LoginPwd>9zdjvu</LoginPwd>
                  <!--Zero or more repetitions:-->
                  <PlanUpdateRequestInfos>
                     <!--Optional:-->
                     <ScAgtPlanCode>7</ScAgtPlanCode>
                     <!--Optional:-->
                     <ScAgtRoomCode>6</ScAgtRoomCode>
                     <!--Optional:-->
                     <AppointedDate>20170520</AppointedDate>
                     <!--Optional:-->
                     <StopStartDivision>0</StopStartDivision>
                     <!--Optional:-->
                     <PriceCode5>99999</PriceCode5>
                     <!--Optional:-->
                     <PriceCode6>99999</PriceCode6>
                  </PlanUpdateRequestInfos>
                  <PlanUpdateRequestInfos>
                     <!--Optional:-->
                     <ScAgtPlanCode>47</ScAgtPlanCode>
                     <!--Optional:-->
                     <ScAgtRoomCode>AA</ScAgtRoomCode>
                     <!--Optional:-->
                     <AppointedDate>20170520</AppointedDate>
                     <!--Optional:-->
                     <StopStartDivision>0</StopStartDivision>
                     <!--Optional:-->
                     <PriceCode4>99999</PriceCode4>
                     <!--Optional:-->
                     <PriceCode5>99999</PriceCode5>
                  </PlanUpdateRequestInfos>
               </arg0>
            </ser:PlanStatusUpdateArray>
         </soapenv:Body>
      </soapenv:Envelope>

      ';
  }

  private function AgtRoomStatusUpdateArrayArg()
  {
    return '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.commonb2b.lincoln.seanuts.co.jp/">
       <soapenv:Header/>
       <soapenv:Body>
          <ser:AgtRoomStatusUpdateArray>
             <!--Optional:-->
             <arg0>
                <!--Optional:-->
                <LoginId>test002</LoginId>
                <!--Optional:-->
                <LoginPwd>9zdjvu</LoginPwd>
                <!--Zero or more repetitions:-->
                <RoomUpdateRequestInfos>
                   <!--Optional:-->
                   <ScAgtRoomCode>S6</ScAgtRoomCode>
                   <!--Optional:-->
                   <AppointedDate>20170418</AppointedDate>
                   <!--Optional:-->
                   <StopStartDivision>1</StopStartDivision>
                   <!--Optional:-->
                   <AgtStockQuantity>10</AgtStockQuantity>
                </RoomUpdateRequestInfos>
                <RoomUpdateRequestInfos>
                   <!--Optional:-->
                   <ScAgtRoomCode>8</ScAgtRoomCode>
                   <!--Optional:-->
                   <AppointedDate>20170510</AppointedDate>
                   <!--Optional:-->
                   <StopStartDivision>1</StopStartDivision>
                   <!--Optional:-->
                   <AgtStockQuantity>10</AgtStockQuantity>
                </RoomUpdateRequestInfos>
             </arg0>
          </ser:AgtRoomStatusUpdateArray>
       </soapenv:Body>
    </soapenv:Envelope>
    ';
  }

  private function TariffDataDownloadArg()
  {
    return '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.commonb2b.lincoln.seanuts.co.jp/">
       <soapenv:Header/>
       <soapenv:Body>
          <ser:TariffDataDownload>
             <!--Optional:-->
             <arg0>
                <!--Optional:-->
                <LoginId>test002</LoginId>
                <!--Optional:-->
                <LoginPwd>9zdjvu</LoginPwd>
                <!--Optional:-->
                <ScAgtPlanCode>12</ScAgtPlanCode>
                <!--Optional:-->
                <ScAgtRoomCode>8</ScAgtRoomCode>
                <!--Optional:-->
                <AppointedDate>20170706</AppointedDate>
                <!--Optional:-->
                <AcquireDayNums>1</AcquireDayNums>
             </arg0>
          </ser:TariffDataDownload>
       </soapenv:Body>
    </soapenv:Envelope>
    ';
  }

  private function StockDataDownloadArg()
  {
    return '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.commonb2b.lincoln.seanuts.co.jp/">
       <soapenv:Header/>
       <soapenv:Body>
          <ser:StockDataDownload>
             <!--Optional:-->
             <arg0>
                <!--Optional:-->
                <LoginId>test002</LoginId>
                <!--Optional:-->
                <LoginPwd>9zdjvu</LoginPwd>
                <!--Optional:-->
                <ScAgtPlanCode>6</ScAgtPlanCode>
                <!--Optional:-->
                <ScAgtRoomCode>14</ScAgtRoomCode>
                <!--Optional:-->
                <AppointedDate>20170531</AppointedDate>
                <!--Optional:-->
                <AcquireDayNums>18</AcquireDayNums>
             </arg0>
          </ser:StockDataDownload>
       </soapenv:Body>
    </soapenv:Envelope>
    ';
  }

  public function Action_testByFuel()
  {

  /*
    $c = Request::forge(APPPATH.'classes/controller/wsdl/LincolnCommonBtoBServiceService.wsdl', 'soap');
    $parameters = array(
      //'PlanDownloadRequest' => array(
        //'LoginId'  => '0001',
        //'LoginPwd' => '1234',
      //),
		//'<LoginId>0001</LoginId><LoginPwd>1234</LoginPwd>'
	);


    // var_dump($c);
    $c->set_params($parameters);
    $c->set_function('PlanDownload');

    $opt = [
		'trace'=>true,
		'cache_wsdl' => WSDL_CACHE_NONE,
        //'location'=> 'http://219.127.193.206/lincoln/soap',  // change end point
        // 'uri'=> '',   // change namespace
    ];
    $c->set_options($opt);

    // var_dump($c);

    try {
        $result = $c->execute();
        // $result->__soapCall("PlanDownload", $sample_data);
    } catch(\Exception $e) {
        // エラー処理
        $result = null;
        var_dump(get_class($e), $e->getCode(), $e->getMessage());
    }

	$result = $c->response();
    var_dump($result->body);
*/





  $price1 = new SoapVar(array (
    new SoapVar('1',        XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('1',        XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170421', XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('1',        XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('500',      XSD_STRING, null, null, 'PriceCode1'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode2'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode3'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode4'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode5'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode6'),
  ),SOAP_ENC_OBJECT, null, null, 'PlanUpdateRequestInfos');

  $price2 = new SoapVar(array (
    new SoapVar('1',        XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('133',        XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170420', XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('0',        XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('499',      XSD_STRING, null, null, 'PriceCode1'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode2'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode3'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode4'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode5'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode6'),
  ),SOAP_ENC_OBJECT, null, null, 'PlanUpdateRequestInfos');

  $price3 = new SoapVar(array (
    new SoapVar('2',        XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('2',        XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170410', XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('0',        XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('300',      XSD_STRING, null, null, 'PriceCode1'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode2'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode3'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode4'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode5'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode6'),
  ),SOAP_ENC_OBJECT, null, null, 'PlanUpdateRequestInfos');

  $price4 = new SoapVar(array (
    new SoapVar('3',        XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('3',        XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170418', XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('0',        XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('1000',     XSD_STRING, null, null, 'PriceCode1'),
    new SoapVar('1500',     XSD_STRING, null, null, 'PriceCode2'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode3'),
    new SoapVar('2000',     XSD_STRING, null, null, 'PriceCode4'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode5'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode6'),
  ),SOAP_ENC_OBJECT, null, null, 'PlanUpdateRequestInfos');

  $price5 = new SoapVar(array (
    new SoapVar('8',        XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('9',        XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170418', XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('1',        XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('600',      XSD_STRING, null, null, 'PriceCode1'),
    // new SoapVar('1500',     XSD_STRING, null, null, 'PriceCode2'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode3'),
    // new SoapVar('2000',     XSD_STRING, null, null, 'PriceCode4'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode5'),
    // new SoapVar('2017',     XSD_STRING, null, null, 'PriceCode6'),
  ),SOAP_ENC_OBJECT, null, null, 'PlanUpdateRequestInfos');

  $heya1 = new SoapVar(array (
    // new SoapVar('akihabara',  XSD_STRING, null, null, 'LoginId'),
    // new SoapVar('n3WvJGVx',   XSD_STRING, null, null, 'LoginPwd'),
    // new SoapVar('12',         XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('5',         XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170326',   XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('1',          XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('3',          XSD_STRING, null, null, 'AgtStockQuantity'),
  ),SOAP_ENC_OBJECT, null, null, 'RoomUpdateRequestInfos');
  $heya2 = new SoapVar(array (
    // new SoapVar('akihabara',  XSD_STRING, null, null, 'LoginId'),
    // new SoapVar('n3WvJGVx',   XSD_STRING, null, null, 'LoginPwd'),
    // new SoapVar('12',         XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('6',         XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170326',   XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('1',          XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('3',          XSD_STRING, null, null, 'AgtStockQuantity'),
  ),SOAP_ENC_OBJECT, null, null, 'RoomUpdateRequestInfos');
  $heya3 = new SoapVar(array (
    // new SoapVar('akihabara',  XSD_STRING, null, null, 'LoginId'),
    // new SoapVar('n3WvJGVx',   XSD_STRING, null, null, 'LoginPwd'),
    // new SoapVar('12',         XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('6',         XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170325',   XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('0',          XSD_STRING, null, null, 'StopStartDivision'),
    new SoapVar('3',          XSD_STRING, null, null, 'AgtStockQuantity'),
  ),SOAP_ENC_OBJECT, null, null, 'RoomUpdateRequestInfos');

	$parameters = new SoapVar(array (
		new SoapVar('test_hotel',  XSD_STRING, null, null, 'LoginId'),
    new SoapVar('1234',   XSD_STRING, null, null, 'LoginPwd'),
    new SoapVar('3',         XSD_STRING, null, null, 'ScAgtPlanCode'),
    new SoapVar('3',         XSD_STRING, null, null, 'ScAgtRoomCode'),
    new SoapVar('20170410',   XSD_STRING, null, null, 'AppointedDate'),
    new SoapVar('7',          XSD_STRING, null, null, 'AcquireDayNums'),
    $heya1,
    $heya2,
	$heya3,
    $price1,
    $price2,
    $price3,
    $price4,
    $price5,
	),SOAP_ENC_OBJECT, null, null, 'LoginConfirmRequest');


	$cli = new SoapClient(APPPATH.'classes/controller/wsdl/LincolnCommonBtoBServiceService.wsdl', array('trace'=>true, 'cache_wsdl' => WSDL_CACHE_NONE));
   //$res1 = $cli->AgtRoomTypeDownload($parameters); // AgtRoomTypeDownloadRequest
  //  $res1 = $cli->PlanDownload($parameters);        // PlanDownloadRequest
  //  $res1 = $cli->StockDataDownload($parameters);   // StockDataDownloadRequest
   //$res1 = $cli->TariffDataDownload($parameters);  // TariffDataDownloadRequest
   $res1 = $cli->AgtRoomStatusUpdateArray($parameters); // AgtRoomStatusUpdateArrayRequest
  //  $res1 = $cli->PlanStatusUpdateArray($parameters);    // PlanStatusUpdateArrayRequest
   //$res1 = $cli->LoginConfirm($parameters);        // LoginConfirmRequest

    // var_dump($cli->__getLastRequestHeaders());
    // var_dump($cli->__getLastRequest());
    // var_dump($cli->__getLastResponseHeaders());
    // var_dump($cli->__getLastResponse());
	// var_dump($res1);

echo $cli->__getLastResponse();


die;

    // var_dump($c->get_functions());




  }



}
