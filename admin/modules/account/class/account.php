<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */

use Core\Session;
use Core\Theme;
use Core\Controllers\Controller;
use Core\Controllers\Front\UserController;
use Core\Controllers\Front\CountryController;
use Core\Controllers\Front\AddressController;
use Core\Controllers\Front\OrderController;




class Account {
	

	private $allowed_fields = [
		'id_gender', 
		'id_group', 
		'id_country', 
		'id_lang', 
		'ip', 
		'clt_number', 
		'first_name', 
		'last_name', 
		'email', 
		'password', 
		'phone', 
		'mobile', 
		'city', 
		'birthday', 
		'day', 
		'month', 
		'year',
		'redirect_to'
	];


	/**
     * Login page
     *
     * @return void
     */
	public function dashboard() {
		get_view(__FILE__, 'front/dashboard');
	}

	

	/**
     * Login page
     *
     * @return void
     */
	public function login() {
		Session::destroy('user');
		$data = [];
		$data['redirect_to'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['message'] = [];
		if( isset($_POST['email']) && isset($_POST['password']) ){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$redirect_to = $_POST['redirect_to'];
			$login_success = UserController::login($email, $password);
			if( $login_success ){
				if( isset($redirect_to) && $redirect_to != '' ){
					header("Location: ". $redirect_to);
				} else {
					header("Location: ". get_url('account'));
				}
			} else {
				$data['redirect_to'] = (0 !== strpos($redirect_to, 'account/login')) ? $redirect_to : '';
				$data['message']['danger'] = trans("The email address or password you entered is not valid.", "account");
			}
			$data['user'] = new \stdClass();
			$data['user']->email = $_POST['email'];
		}
		get_view(__FILE__, 'front/login', $data);
	}


	/**
     * Logout
     *
     * @return void
     */
	public function logout() {
		UserController::logout();
	}


	/**
     * Register new User
     *
     * @return void
     */
	public function register() {
		if ( logged() ) {
			header("Location: ". get_url('account'));
		}
		$data = array();
		$data['user'] = new \stdClass();
		$data['user']->email = (isset($_POST['email'])) ? $_POST['email'] : '';

		//proccess posted data
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register']) ){
			//validate posted data
			$this->allowed_fields[] = 'register';
			if( Controller::validateData($_POST, $this->allowed_fields) ){
				$data = $_POST;
				$format_date = $_POST['year'] .'-'. $_POST['month'] .'-'. $_POST['day'];
				$date = new DateTime($format_date);
				$data['birthday'] = $date->format('Y-m-d');
				$data['password'] = md5($_POST['password']);
				unset($data[day], $data[month], $data[year], $data[register], $data[redirect_to]);
				if( UserController::userExist($data['email']) ){
					$data['message']['danger'] = trans("Email already in use, please try another.", "account");
				} else if( UserController::register($data) ){
					if( isset($_POST['redirect_to']) && $_POST['redirect_to'] != '' ){
						header("Location: ". $_POST['redirect_to']);
					} else {
						header("Location: ". get_url('account'));
					}
				} else {
					$data['message']['danger'] = trans("Unable to save informations, please try again.", "account");
				}
				$data['user'] = (object) $_POST;
			} else {
				$data['user'] = (object) $_POST;
				$data['message']['danger'] = trans("Fields not match database columns.", "account");
			}
		}	
		$data['date'] = os_get_date_liste();
		$data['countries'] = CountryController::getCountries();
		get_view(__FILE__, 'front/register', $data);
	}

	/**
     * Update user information
     *
     * @return void
     */
	public function update() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']) ){
			//validate posted data
			$this->allowed_fields[] = 'update';
			if( Controller::validateData($_POST, $this->allowed_fields) ){
				$data = $_POST;
				if( $data['password'] != '' ){
					$data['password'] = md5($_POST['password']);
				} else {
					unset($data[password]);
				}
				$format_date = $_POST['year'] .'-'. $_POST['month'] .'-'. $_POST['day'];
				$date = new DateTime($format_date);
				$data['birthday'] = $date->format('Y-m-d');
				unset($data[day], $data[month], $data[year], $data[update]);

				$id_user = get_user('id');
				if( UserController::update($data, $id_user) ){
					header("Location: " . get_url('account'));
				} else {
					$data['message']['danger'] = trans("Unable to update informations, please try again.", "account");
				}

			} else {
				$data['message']['danger'] = trans("Fields not match database columns.", "account");
			}
		}	
		$data['user'] = (object) get_user_data();
		$strtotime = strtotime($data['user']->birthday);
		$data['user']->year = date('Y', $strtotime);
		$data['user']->month = date('m', $strtotime);
		$data['user']->day = date('d', $strtotime);

		$data['date'] = os_get_date_liste();
		$data['countries'] = CountryController::getCountries();
		get_view(__FILE__, 'front/update', $data);
	}


	/**
     * Reset password
     *
     * @return void
     */
	public function password() {
		$data = array();
		//proccess posted data
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset']) ){
			$email = $_POST['email'];
			if( UserController::userExist($email) ){
				$new_password = UserController::resetPassword($email);
				if( $new_password ){
					$data['message']['success'] = trans("An email was sent to your inbox with new password.", "account");
				} else {
					$data['message']['danger'] = trans("Unable to send email, please try again later.", "account");
				}
			} else {
				$data['message']['danger'] = trans("There is no account registered for this email address.", "account");
			}
			$data['email'] = $_POST['email'];
		}
		get_view(__FILE__, 'front/password', $data);
	}

	
	/**
     * Add or Edit Address
     *
     * @return void
     */
	public function address() {
		$data = array();
		$data['countries'] = CountryController::getCountries();


		//get address id
		$id_address = ( isset($_GET['ID2']) && is_numeric($_GET['ID2']) && intval($_GET['ID2']) > 0 ) ? intval($_GET['ID2']) : 0;

		//proccess posted data
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

			//available fields
			$fields = array('id_user', 'id_country', 'name', 'addresse', 'addresse2', 'firstname', 'company', 'lastname', 'city', 'codepostal', 'phone', 'mobile', 'ip', 'info');

			//validate posted data
			if( Controller::validateData($_POST, $fields) ){
				if( $id_address ){
					$address_data = $_POST;

					//append id_user
					$address_data['id_user'] = get_user('id');
					//update address
					$update_success = AddressController::update($id_address, $address_data);
					if( $update_success ){
						header("Location: " . get_url('account/?tab=addresses'));
					} else {
						$data['address'] = (object) $_POST;
						$data['message']['danger'] = trans("Unable to update address, please try again.", "account");
					}
				} else {
					
					$address_data = $_POST;
					$address_data['id_user'] = get_user('id');
					$save_success = AddressController::save($address_data);
					
					if( $save_success ){
						if( read_session('order_step') == 'address' ){
							header("Location: " . get_url( 'order/address' ));
						} else {
							$url = get_url( 'account/?tab=addresses' );
							header("Location: " . $url);
						}
						
					} else {
						$data['address'] = (object) $_POST;
						$data['message']['danger'] = trans("Unable to insert address, please try again.", "account");
					}
				}
			} else {
				$data['address'] = (object) $_POST;
				$data['message']['danger'] = trans("Fields not match database columns.", "account");
			}
		}

		//edit address mode
		if( $id_address ){
			$data['address'] = AddressController::getAddressByID($_GET['ID2']);
		} else {
			$udata = (object) get_user_data();//UserController::getData();
			$user_data = (object) array(
				'name' => '',
				'company' => '',
				'addresse' => '',
				'addresse2' => '',
				'codepostal' => '',
				'info' => '',
				'lastname' => $udata->last_name,
				'firstname' => $udata->first_name,
				'city' => $udata->city,
				'id_country' => $udata->id_country,
				'phone' => $udata->phone,
				'mobile' => $udata->mobile,
			);
			if( !isset($data['address']) || is_empty($data['address']) ) $data['address'] = $user_data;
		}
		get_view(__FILE__, 'front/address', $data);
	}


	/**
     * Get uset addresses
     *
     * @return void
     */
	public function addresses() {
		//delete address
		if ( isset($_POST['delete_address']) && $_POST['id_address'] > 0 ){
			$delete = AddressController::delete($_POST['id_address']);
			if( $delete ){
				$data['message']['success'] = trans("Address was deleted successfully.", "account");
			} else {
				$data['message']['danger'] = trans("Unable to remove the address.", "account");
			}
		}
		$id_user = get_user('id');
		$data['addresses'] = AddressController::getAddresses($id_user);
		get_view(__FILE__, 'front/addresses', $data);
	}


	/**
     * Order history
     *
     * @return void
     */
	public function order_history() {
		$id_user = get_user('id');
		$data['orders'] = OrderController::getOrders($id_user);
		get_view(__FILE__, 'front/order-history', $data);
	}


	/**
     * Order details
     *
     * @return void
     */
	public function order_details() {
		$data = array();
		if( $id_order = get_url_param('ID2') ){
			$db = getDB();
			$id_user = get_user('id');
			/*$details = OrderController::getByID($id_order, $id_user);
			if( $details ){
				$data['order'] = $details;
				$data['items'] = getOrderItems($id_order, $id_user);
			}*/

			$data['items'] = $db->prepare("SELECT `id`, `product_name`, `product_reference`, `product_price`, `product_quantity` FROM `os_order_detail` WHERE `id_order`=?", [$id_order]);


			get_view(__FILE__, 'front/order-details', $data);
		} else {
			header("Location: " . get_url('account'));
		}
	}

	





//END CLASS
}