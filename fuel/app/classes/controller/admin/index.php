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
class Controller_Admin_Index extends Controller
{
  /**
   * The basic welcome message
   *
   * @access  public
   * @return  Response
   */
  public function action_index()
  {
    return Response::forge(View::forge('admin/index'));
  }

    public function action_login()
  {
    $data = Input::post();

    // $user = Model_M_Co_Login::forge();
    // $user_data = $user->get_user($data['loginId']);
    // $data['loginPass'] = md5(MD5_SALT . $data['loginPass']);


    $user = Model_M_Htl::forge();
    $user_data = $user->get_Admin($data['loginId']);
    $data['loginPass'] = md5(MD5_SALT . $data['loginPass']);

    if ($user_data == nuLL || $user_data['ADMIN_PWD'] != $data['loginPass']) {
      Response::redirect('admin/index');
    }

    Session::set('id', $user_data['ADMIN_ID']);
    Response::redirect('admin/plan');
  }


  public function action_logout()
  {
    Session::destroy();
    Response::redirect('admin/index');
  }

}
