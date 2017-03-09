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

namespace Core\UserController;

class OrderController extends AdminController
{


    /**
     * Table int
     * @var Table $table
     */
    protected $table = "orders";



    /**
     *=============================================================
     * get_adress_details
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function get_adress_details($id_adress)
    {
        return $this->db->prepare("SELECT a.*, c.name as country FROM {$this->prefix}addresses a, {$this->prefix}countries c WHERE c.id = a.id_country AND a.id= ? LIMIT 1", [$id_adress], true);
    }


    /**
     *=============================================================
     * get order states
     *=============================================================
     * @throws Exception
     * @return $order_states (array)
     */
    public function get_order_states($id_order)
    {
        return $this->db->prepare("SELECT os.id as id_line, s.id as id_state, os.cdate, s.name, u.first_name, u.last_name
            FROM {$this->prefix}order_state_line os, {$this->prefix}order_states s, {$this->prefix}orders o, {$this->prefix}users u
            WHERE s.id = os.id_state AND u.id = o.id_customer AND o.id= ? AND os.id_order= ?
            ORDER BY os.id DESC", [$id_order, $id_order]);
    }


    /**
    *=============================================================
    * get order addresses
    *=============================================================
    * @throws Exception
    * @return $addresses (array)
    */
    public function get_order_addresses($id_customer)
    {
        return $this->db->prepare("SELECT a.*, c.name as country FROM {$this->prefix}addresses a, {$this->prefix}countries c WHERE c.id = a.id_country AND id_user= ? ORDER BY a.id DESC", [$id_customer]);
    }


    /**
    *=============================================================
    * get customer infos
    *=============================================================
    * @throws Exception
    * @return $infos (array)
    */
    public function get_customer_infos($id_customer)
    {
        return $this->db->prepare("SELECT u.id, u.email, u.first_name, u.last_name, u.phone, u.mobile, u.city, u.cdate, g.name as gender, c.name as country FROM {$this->prefix}users u, {$this->prefix}gender g, {$this->prefix}countries c WHERE u.id= ? AND g.id = u.id_gender AND c.id = u.id_country", [$id_customer], true);
    }



    /**
     *=============================================================
     * send_order_email
     *=============================================================
     * @throws Exception
     * @return true || false (bootlean)
     */
    public function send_order_email($id_order, $id_state)
    {
        try {
            $order = $this->db->prepare("SELECT o.reference, os.name as state, u.first_name, u.last_name, u.email, g.name as gender
                FROM {$this->prefix}orders o
                INNER JOIN {$this->prefix}order_states os ON os.id = ?
                INNER JOIN {$this->prefix}users u ON u.id = o.id_customer
                INNER JOIN {$this->prefix}gender g ON g.id = u.id_gender
                WHERE o.id= ? LIMIT 1", [$id_state, $id_order], true);

            if( !is_empty($order) ){
              $Mails = new Mails();
              $Sender    = "no-reply@okadshop.com";
              $Receiver  = $order['email'];
              $Subject   = "OkadShop - Statut de la Commande changé !";
              $Content   = 'Bonjour '. $order['gender'] .' '. $order['first_name'] .' '. $order['last_name'] .',<br><br>';
              $Content  .= 'Le statut de votre Commande avec le réference '. $order['reference'] .' a été changé, le nouveau statut est : '. $order['state'] .'.<br><br>';
              $Content  .= 'Cordialement<br>';
              return $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
            }
            return false;
        } catch (Exception $e) {
            $this->getException($e);
        }
    }





//END CLASS
}