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
namespace Core\Controllers\Admin;

class CarrierController extends AdminController
{

	/**
     * Table int
     * @var Table $table
     */
    protected $table = "carrier";


	/**
     * GET CARRIER NAME
     * @param int $id
     * @return name string
     */
	public function getName($id){
		return $this->db->find($this->table, $id, array('name'));
	}




//END CLASS
}