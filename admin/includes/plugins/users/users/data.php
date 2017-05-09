<?php
function Add(){}
function EDIT($ID){}
function DELETE($ID){
  $common = new OS_Common();
  $common->delete('users', "WHERE id=".$ID );
  echo '<script>window.location.href="?module=users"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;


use Core\i18n\Language;

  $user = new OS_User();
  $common = new OS_Common();
  $errors = $success = array();
  $sentmail = false;
  $required = array(
    'Nom'         => isset($_POST['customer']['first_name']) ? $_POST['customer']['first_name'] : '',
    'Prénom'      => isset($_POST['customer']['last_name']) ? $_POST['customer']['last_name'] : '',
    'Email'      => isset($_POST['customer']['email']) ? $_POST['customer']['email'] : '',
    // 'Société'     => $_POST['company']['company'],
    // 'Activité'    => $_POST['company']['activite'],
    // 'N° de siret' => $_POST['company']['siret_tva'],
  );



  // if( isset($_GET['lang']) ){
  //   Language::setLanguage($_GET['lang']);
  // }


  /**
   *=============================================================
   * UPDATE MODE
   * This part well apply when you go to edit a customer from list
   * EX: [WewSite]index.php?module=users&action=edit&id=[1]
   *=============================================================
   */
  if( 
    isset($_GET['action']) && $_GET['action'] == 'edit'
    && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0
  ){
    $exist = $common->select('users', array('id'), "WHERE id=". intval($_GET['id']) );
    if( $exist ){
      $id_customer = intval($_GET['id']);
    }
  /*============================================================*/
  } //END UPDATE MODE
  /*============================================================*/


  /**
   *=============================================================
   * INSERT POST DATA
   *=============================================================
   */
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$user->check_required_fields($required) ){

    


    //customer informations
    $customer_infos = array(
      'first_name' => isset($_POST['customer']['first_name']) ? addslashes($_POST['customer']['first_name']) : '',
      'last_name'  => isset($_POST['customer']['last_name']) ? addslashes($_POST['customer']['last_name']) : '',
      'email'      => isset($_POST['customer']['email']) ? addslashes($_POST['customer']['email']) : '',
      'note_content' => isset($_POST['customer']['note_content']) ? addslashes($_POST['customer']['note_content']) : '',
      'info_sup' => isset($_POST['customer']['info_sup']) ? addslashes($_POST['customer']['info_sup']) : '',
      'mobile' => isset($_POST['customer']['mobile']) ? $_POST['customer']['mobile'] : '',
      'user_type'   => "user",
      'id_gender'  => isset($_POST['customer']['id_gender']) ? intval($_POST['customer']['id_gender']) : '', 
      'id_country'   => isset($_POST['customer']['id_country']) ? intval($_POST['customer']['id_country']) : '',
      'id_group'   => isset($_POST['customer']['id_group']) ? intval($_POST['customer']['id_group']) : '',
      'active'     => isset($_POST['customer']['user_state']) ? $_POST['customer']['user_state'] : ''
    );
    if( $_POST['customer']['password'] != "" ) $customer_infos['password'] = md5($_POST['customer']['password']);
    if( isset($_POST['customer']['clt_number']) && $_POST['customer']['clt_number'] == "" ) $customer_infos['clt_number'] = $user->get_customer_number();
    if( isset($_POST['customer']['user_type']) ) $customer_infos['user_type'] = "admin";

    /*echo "<pre>";
    print_r($customer_infos);
    echo "</pre>";*/

    //company informations
    $company_infos = array(
      'company'       => isset($_POST['company']['company']) ? addslashes($_POST['company']['company']) : '',
      'activite'      => isset($_POST['company']['activite']) ? addslashes($_POST['company']['activite']) : '',
      'siret_tva'     => isset($_POST['company']['siret_tva']) ? addslashes($_POST['company']['siret_tva']) : '',
      'website'       => isset($_POST['company']['website']) ? addslashes($_POST['company']['website']) : '',
      'date_activite' => isset($_POST['company']['date_activite']) ? addslashes($_POST['company']['date_activite']) :'',
      'info'          => isset($_POST['company']['info']) ? addslashes($_POST['company']['info']) : '',
    );

    //addresse informations
    $address_infos = array(
      'firstname'  => isset($_POST['address']['firstname']) ? addslashes($_POST['address']['firstname']) : '',
      'lastname'   => isset($_POST['address']['lastname']) ? addslashes($_POST['address']['lastname']) : '',
      'company'    => isset($_POST['address']['company']) ? addslashes($_POST['address']['company']) : '',
      'addresse'   => isset($_POST['address']['addresse']) ? addslashes($_POST['address']['addresse']) : '',
      //'addresse2'  => addslashes($_POST['address']['addresse2']),
      'codepostal' => isset($_POST['address']['codepostal']) ? addslashes($_POST['address']['codepostal']) : '',
      'city'       => isset($_POST['address']['city']) ? addslashes($_POST['address']['city']) :'',
      'id_country' => isset($_POST['address']['id_country']) ? intval($_POST['address']['id_country']) : '',
      'phone'      => isset($_POST['address']['phone']) ? $_POST['address']['phone'] : '',
      'mobile'     => isset($_POST['address']['mobile']) ? $_POST['address']['mobile'] :'',
      'info'       => isset($_POST['address']['info']) ? addslashes($_POST['address']['info']) : ''
    );
    if( isset($_POST['address']['adress_name']) && $_POST['address']['adress_name'] != "" ) $address_infos['name'] = $_POST['address']['adress_name'];
    

    //insert proccess
    if( isset($_POST['save_customer']) ){

      //insert customer
      $id_customer = $common->save('users', $customer_infos);
      if($id_customer){

        //insert company
        if( !empty($_POST['company']['company']) ){
          // upload attachement
          if( isset($_FILES['attachement']) && $_FILES['attachement']['size'][0] > 0 ){
            $file_name   = time() . '_' . $_FILES['attachement']['name'][0];
            $file_name   = md5($file_name);
            $uploadDir   = '../files/users/'. $id_customer .'/';
            $extensions  = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt');
            $file_target = $common->uploadDocument($_FILES['attachement'], $file_name, $uploadDir, $extensions);
            $attachement = str_replace( $uploadDir , '', $file_target[0] );
            if( $attachement != "" ) $company_infos['attachement'] = $attachement;
          }
          //insert or update company
          $company_infos['id_user'] = $id_customer;
          $exist = $common->select('user_company', array('id'), "WHERE id_user=".$id_customer );
          if( ! $exist ){
            $id_company  = $common->save('user_company', $company_infos);
          }else{
            $common->update('user_company', $company_infos, "WHERE id_user=".$id_customer );
            $id_company = $exist[0]['id'];
          }
        }

        //insert addresse
        if( !empty($_POST['address']['adress_name']) ){
          $address_infos['id_user'] = $id_customer;
          $id_address = intval($_POST['address']['id']);
          if( $id_address < 1 ){
            $common->save('addresses', $address_infos);
          }else{
            $common->update('addresses', $address_infos, "WHERE id=".$id_address );
          }
        }

      }
      
       array_push($success, '<?=l("Le Client a été ajouter avec success.", "core");?>');
      
    }elseif( isset($_POST['update_customer']) ) {
      $id_customer = intval($_POST['customer']['id']);
      if(!isset($id_customer) && $id_customer <= 0) return;

      //update customer
      $common->update('users', $customer_infos, "WHERE id=".$id_customer );

      //update company
      if( !empty($_POST['company']['company']) ){
        // upload attachement
        if( isset($_FILES['attachement']) && $_FILES['attachement']['size'][0] > 0 ){
          $file_name   = time() . '_' . $_FILES['attachement']['name'][0];
          $file_name   = md5($file_name);
          $uploadDir   = '../files/users/'. $id_customer .'/';
          $extensions  = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt');
          $file_target = $common->uploadDocument($_FILES['attachement'], $file_name, $uploadDir, $extensions);
          $attachement = str_replace( $uploadDir , '', $file_target[0] );
          if( $attachement != "" ) $company_infos['attachement'] = $attachement;
        }
        //insert or update company
        $company_infos['id_user'] = $id_customer;
        $exist = $common->select('user_company', array('id'), "WHERE id_user=".$id_customer );
        if( ! $exist ){
          $id_company  = $common->save('user_company', $company_infos);
        }else{
          $common->update('user_company', $company_infos, "WHERE id_user=".$id_customer );
          $id_company = $exist[0]['id'];
        }
      }

      //update addresses
      if( !empty($_POST['address']['adress_name']) ){
        //insert or update addresse
        $address_infos['id_user'] = $id_customer;
        $id_address = intval($_POST['address']['id']);
        if( $id_address < 1 ){
          $common->save('addresses', $address_infos);
        }else{
          $common->update('addresses', $address_infos, "WHERE id=".$id_address );
        }
      }

      array_push($success, '<?=l("Les informations de Client ont été mise à jour.", "core");?>');
    }// END UPDATE CUSTOMER



    if( 
      isset($_POST['customer']['user_state']) && $_POST['customer']['user_state'] === "actived" 
      && isset($_POST['customer']['send_email']) && $_POST['customer']['send_email'] === "1" 
    ){
      $Mails    = new Mails();
      if( $_POST['customer']['id_gender'] == "1"){
        $gender = "MR";
      }else{
        $gender = "MME";
      }
      $Sender   = "no-reply@okadshop.com";
      $Receiver = $_POST['customer']['email'];
      $Subject  = "OkadShop - Message confirmation";
      $Content  = 'Bonjour '. $gender .' '. $_POST['customer']['last_name'] .',<br><br>';
      if( $_POST['customer']['email_content'] != "" ){
        $Content .= $_POST['customer']['email_content'];
      }else{
        $Content .= l("Félicitation votre compte a été bien crée. <br>Nous vous remercions de vous être inscrit(e) chez OkaSshop.<br><br>");
      }
      $Content .= "Cordialement.";
      $sentmail = $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
      if( $sentmail ){
        array_push($success, '<b>'. l("Une email a été envoyé au Client.") .'</b>');
      }
    }


    //send_email
    if( isset($_POST['email']['send_email']) && $_POST['email']['message'] != "" ){

      $Mails    = new Mails();
      if( $_POST['customer']['id_gender'] == "1"){
        $gender = "MR";
      }else{
        $gender = "MME";
      }
      $Sender   = "no-reply@okadshop.com";
      $Receiver = $_POST['customer']['email'];
      $Subject  = "OkadShop - Message";
      $Content  = 'Bonjour '. $gender .' '. $_POST['customer']['last_name'] .',<br>';
      $Content .= addslashes($_POST['email']['message']);
      $sentmail = $Mails->SendFastMail($Sender,$Receiver,$Subject,$Content);
      if( $sentmail ){
        array_push($success, '<b>'. l("Une email a été envoyé au Client.") .'</b>');
      }
    }



    if( isset($_POST['default_lang']) && !empty($_POST['default_lang']))
    {
      Language::setLanguage($_POST['default_lang']);
      $redirect = $_SERVER['HTTP_REFERER'];// . '&lang=' . $_POST['default_lang'];
      echo '<script>window.location.href="'.$redirect.'"</script>';
    }

  /*============================================================*/
  } //END INSERT POST DATA
  /*============================================================*/




  /**
   *=============================================================
   * PREPARE DATA AFTER SAVE
   * This part well apply after the first save of new customer
   *=============================================================
   */
  if(isset($id_customer) && $id_customer > 0){
    $customer      = $user->get_customer_infos($id_customer);
    $company       = $user->get_company_infos($id_customer);
    $addresses     = $user->get_addresses_list($id_customer); 
    //$address       = $user->get_addess_infos($id_addess, $id_customer);

    //$messages = $common->select('contact_messages', array('*'), "WHERE id_sender=". $id_customer ." OR id_receiver=". $id_customer);
    //$customer_quotes = $common->select('quotations', array('id', 'name', 'reference', 'company', 'expiration_date', 'carrier_type'), "WHERE id_customer=". $id_customer);
    $customer_orders = $common->select('orders', array('id', 'name', 'reference', 'company', 'carrier_type'), "WHERE id_customer=". $id_customer);

    $order_count = $common->select('orders', array('COUNT(id) as count'), "WHERE id_customer=".$id_customer );

    //messagerie
    if( !empty($_GET['id_dir']) ){
      $id_dir = intval($_GET['id_dir']);
    }else{
      $id_dir = 1;
    }
    if( isset($contact_active) )
    {
      $messages = $common->select('contact_messages', array('*'), "WHERE `from`=$id_customer AND id_directory=$id_dir ORDER BY id DESC");
    }
    //$messages = $contact->get_message_by_directory($id_customer, $id_dir);
    //(select COUNT(*) from contact_directories) AS total')
  /*============================================================*/
  } //END DATA PREPARATION
  /*============================================================*/


  //other data
  $countries = $user->get_countries_list();
  //$countries = $common->select('countries', array('id', 'iso_code', 'name') );
  $genders   = $user->get_genders_list();
  $groupes   = $user->get_users_groups_list();

  global $hooks;
  $directories = array();
  $contact_active = $hooks->check_module_active("os-contact");
  if( $contact_active )
  {
    $directories = $common->select('contact_directories', array('id', 'name'));
  }

  //langs list
  $os_langs = $common->select('langs', array('id', 'code', 'name'), "WHERE active=1");
  $id_lang = Language::getLanguage()->id;

//check if user is admin
$is_admin = (!empty($customer) && $customer['user_type'] == "admin" ) ? true : false;
$user_label = ($is_admin) ? "Employés" : "Client";
?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="customer[id]" id="id_customer" value="<?= (isset($id_customer) && $id_customer > 0) ? $id_customer : '';?>">
  <div class="top-menu padding0">
    <?php if( isset($id_customer) && $id_customer > 0 ) : ?>
      <div class="top-menu-title">
        <h3><i class="fa fa-user"></i> <?=l( $user_label . " > Modifier", "core");?></h3>
      </div>
      <div class="top-menu-button">
        <button type="submit" name="update_customer" class="btn btn-primary"><?=l("Sauvegarder et rester", "core");?></button>
        <button type="button" class="btn btn-default" onclick="window.location='?module=users';"><?=l("Terminer", "core");?></button>
      </div>
    <?php else : ?>
      <div class="top-menu-title">
        <h3><i class="fa fa-user"></i> <?=l("Ajouter un ".$user_label, "core");?></h3>
      </div>
      <div class="top-menu-button">
        <button type="submit" name="save_customer" class="btn btn-primary"><?=l("Sauvegarder et rester", "core");?></button>
        <button type="button" class="btn btn-default" onclick="window.location='?module=users';"><?=l("Terminer", "core");?></button>
      </div>
    <?php endif; ?>
  </div><br>


  <?php if(!empty($errors)) : ?>
    <div class="alert alert-warning">
      <h4><?=l("Une erreur est survenue !", "core");?></h4>
      <ul>
      <?php foreach ($errors as $key => $error) : ?>
        <li><?=$error;?></li>
      <?php endforeach; ?>
      </ul>
    </div>
  <?php elseif(!empty($success)) : ?>
    <div class="alert alert-success">
      <h4><?=l("Opération Effectué !", "core");?></h4>
      <ul>
      <?php foreach ($success as $key => $value) : ?>
        <li><?=$value;?></li>
      <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <?php if( $_POST && $user->check_required_fields($required) ) : ?>
    <div class="alert alert-warning">
      <h4><?=l("Champs requis", "core");?></h4>
      <?=l("Les Champs suivants sont obligatoire :", "core");?> <?php echo implode(', ', $user->check_required_fields($required) ); ?>
    </div>
  <?php endif; ?>

  <div class="col-sm-6 left0">
    <div class="panel panel-default">
      <div class="panel-heading">
      <?php if(!$is_admin) : ?>
        <?=l("Information ".$user_label, "core");?>
        <span class="badge"><?=(isset($order_count[0]['count'])) ? $order_count[0]['count'] : ''; ?> <?=l("Commandes", "core");?></span>
      <?php else : ?>
        Employés
      <?php endif; ?>
        <a data-toggle="collapse" href="#customer_collapse" class="btn btn-primary pull-right"><i class="fa fa-minus"></i></a>
      </div>
      <div id="customer_collapse" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="email"><?=l("N° ".$user_label, "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input type="text" class="form-control" value="<?=( isset($customer['clt_number']) ) ? $customer['clt_number'] : '';?>" disabled>
              <input type="hidden" name="clt_number" class="form-control" value="<?=( isset($customer['clt_number']) ) ? $customer['clt_number'] : '';?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="id_gender"><?=l("Civilité", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <select name="customer[id_gender]" class="form-control">
                <?php foreach ($genders as $key => $gender) : ?>
                  <option value="<?php echo $gender['id'];?>" <?=( isset($customer['id_gender']) && $customer['id_gender'] == $gender['id'] ) ? 'selected' : '';?>><?php echo $gender['name'];?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="last_name"><?=l("Prénom *", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input name="customer[last_name]" type="text" class="form-control" id="last_name" value="<?=( isset($customer['last_name']) ) ? $customer['last_name'] : '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="first_name"><?=l("Nom *", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input name="customer[first_name]" type="text" class="form-control" id="first_name" value="<?=( isset($customer['first_name']) ) ? $customer['first_name'] : '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="email"><?=l("Adresse E-mail *", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input name="customer[email]" type="text" class="form-control" id="email" value="<?=( isset($customer['email']) ) ? $customer['email'] : '';?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="mobile"><?=l("Téléphone portable", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input name="customer[mobile]" type="number" class="form-control" id="customer_mobile" value="<?=( isset($customer['mobile']) ) ? $customer['mobile'] : '';?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="password"><?=l("Mot de passe", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input name="customer[password]" type="password" class="form-control" id="password" value="">
              <small><?=l("5 caractères min (Remplir ce champs pour changer le mot de passe).", "core");?></small>
            </div>
          </div>
          <!--div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="birthday">Date de naissance</label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input name="customer[birthday]" type="text" class="form-control datepicker" id="birthday" value="<?//=( isset($customer['birthday']) ) ? $customer['birthday'] : '';?>">
            </div>
          </div-->
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="email"><?=l("Date d’inscription", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <input type="text" class="form-control" value="<?=( isset($customer['cdate']) ) ? $customer['cdate'] : '';?>" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="id_country"><?=l("Pays", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <select name="customer[id_country]" class="form-control">
                <?php foreach ($countries as $key => $country) : ?>
                  <option value="<?php echo $country['id'];?>" <?=( isset($customer['id_country']) && $customer['id_country'] === $country['id'] ) ? 'selected' : '';?>><?php echo $country['name'];?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="id_country"><?=l("Langue", "core");?></label>  
            <div class="col-md-6 col-lg-4 col-sm-8">
              <select id="default_lang" name="default_lang" class="form-control">
              <?php
              if( !empty($os_langs) )
              {
                foreach ($os_langs as $key => $lang) {
                  $selected = ($id_lang == $lang['id']) ? 'selected' : '';
                  echo '<option value="'.$lang['id'].'" '. $selected .'>'.$lang['name'].'</option>';
                }
              }
              ?>
            </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" style="padding-top:0px;"><?=l("Statut", "core");?></label>  
            <div class="col-sm-3">
              <select name="customer[user_state]" class="form-control">
                <option value="actived" <?=(isset($customer['active']) && $customer['active'] == "actived") ? 'selected' : '';?>><?=l("Activer", "core");?></option>
                <option value="waiting" <?=(isset($customer['active']) && $customer['active'] == "waiting") ? 'selected' : '';?>><?=l("En attente", "core");?></option>
                <option value="suspended" <?=(isset($customer['active']) && $customer['active'] == "suspended") ? 'selected' : '';?>><?=l("Suspendu", "core");?></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3 col-sm-offset-3">
              <label for="user_type">
                <input type="checkbox" name="customer[user_type]" value="admin" <?=(isset($customer['user_type']) && $customer['user_type'] == "admin") ? 'checked' : '';?> id="user_type" style="vertical-align: middle;margin-top: -3px;"> <?=l("Cette utilisateur est admin", "core");?>
              </label>
            </div>
          </div>
          <!--div class="form-group">
            <div class="col-sm-3 col-sm-offset-3">
              <label for="send_email">
                <input type="checkbox" name="customer[send_email]" value="1" id="send_email" style="vertical-align: middle;margin-top: -3px;"> <?=l("Envoyer un email", "core");?>
              </label>
            </div>
          </div-->
          <div class="form-group" id="email_content" style="display:none;">
            <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="content"><?=l("Contenu de l'email", "core");?></label>  
            <div class="col-md-8">
              <textarea id="content" rows="4" name="customer[email_content]" type="text" class="form-control"><?=l("Félicitation votre compte a été bien crée. Nous vous remercions de vous être inscrit(e) chez OkadShop.", "core");?></textarea>
            </div>
          </div>
        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
          <button type="submit" name="<?= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
        </div><!--/ .panel-footer -->
      </div><!--/ .customer_collapse -->
    </div><!--/ .panel -->

    <?php if(!$is_admin) : ?>
      <div class="panel panel-default">
        <div class="panel-heading"> <?=l("Informations de la société", "core");?>
          <a data-toggle="collapse" href="#company_collapse" class="btn btn-primary pull-right"><i class="fa fa-minus"></i></a>
        </div>
        <div id="company_collapse" class="panel-collapse collapse in">
          <div class="panel-body">
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="company"><?=l("Société *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="company[company]" type="text" class="form-control" id="company" value="<?=(isset($company['company'])) ? $company['company'] : '';?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="company"><?=l("Activité *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="company[activite]" type="text" class="form-control" id="activite" value="<?=(isset($company['activite'])) ? $company['activite'] : '';?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="siret_tva"><?=l("N° d’entreprise *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="company[siret_tva]" type="text" class="form-control" id="siret_tva" value="<?=(isset($company['siret_tva'])) ? $company['siret_tva'] : '';?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="website"><?=l("Registre du commerce", "core");?></label>  
              <div class="col-md-8">
                <input type="file" name="attachement" id="attachement"><br>
                <?php if( isset($company['attachement']) && $company['attachement'] != "" ) : ?>
                  <a download="<?=$company['attachement'];?>" target="_blank" title="<?=l("Télécharger le fichier", "core");?>" href="<?php echo '../files/users/'. $id_customer .'/'. $company['attachement'];?>" style="margin-top:-12px;position:absolute;"><i class="fa fa-download"></i> <?php echo $company['attachement'];?></a>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-sm-9 col-sm-offset-3">
              <strong><?=l("Si vous êtes en création d’entreprise", "core");?></strong>
              <p><?=l("Indiquez « en cours » dans les champs société, activité etsiret", "core");?></p>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="website"><?=l("Site web", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="company[website]" type="text" class="form-control" id="website" value="<?=(isset($company['website'])) ? $company['website'] : '';?>">
              </div>
            </div>
            <div class="col-sm-9 col-sm-offset-3">
              <p><strong><?=l("Pour les pays hors U.E, veuillez joindre votre registre du commerce (obligatoire)", "core");?></strong></p>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="date_activite"><?=l("Date début d’activité", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="company[date_activite]" type="text" class="form-control datepicker" id="date_activite" value="<?=(isset($company['date_activite'])) ? $company['date_activite'] : '';?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="informations"><?=l("Détail du projet", "core");?></label>  
              <div class="col-md-8">
                <textarea id="info" rows="4" name="company[info]" type="text" class="form-control"><?=(isset($company['info'])) ? $company['info'] : '';?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="id_gender"><?=l("Statut", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <select name="customer[id_group]" class="form-control">
                  <option value="0"><?=l("Sélectionnez une Statut", "core");?></option>
                  <?php foreach ($groupes as $key => $groupe) : ?>
                    <option value="<?php echo $groupe['id'];?>" <?=( isset($customer['id_group']) && $customer['id_group'] == $groupe['id'] ) ? 'selected' : '';?>><?php echo $groupe['name'];?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
          </div><!--/ .panel-body -->
          <div class="panel-footer">
            <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
            <button type="submit" name="<?= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
          </div><!--/ .panel-footer -->
        </div><!--/ .customer_collapse -->
      </div><!--/ .panel -->
    <?php endif; ?>

    <!--div class="panel panel-default">
      <div class="panel-heading"> Informations complémentaires</div>
      <div class="panel-body">
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="date_activite">Date début d’activité</label>  
          <div class="col-md-6 col-lg-4 col-sm-8">
            <input name="company[date_activite]" type="text" class="form-control datepicker" id="date_activite" value="<?php //echo $company['date_activite'];?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="informations">Détail du projet</label>  
          <div class="col-md-8">
            <textarea id="info" rows="4" name="company[info]" type="text" class="form-control"><?//=(isset($company['info'])) ? $company['info'] : '';?></textarea>
          </div>
        </div>
      </div></ .panel-body -->
      <!--div class="panel-footer">
        <button type="button" class="btn btn-default" onclick="window.location='?module=products';">Fermer</button>
        <button type="submit" name="<?//= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right">Valider</button>
      </div--><!--/ .panel-footer -->
    <!--/div></ .panel -->

  </div><!--/ .col-sm-6 -->

  <?php if(!$is_admin) : ?>
    <div class="col-sm-6 left0" id="adress_panel">
      <div class="panel panel-default">
        <div class="panel-heading"> <?=l("Les adresses de Client", "core");?>
          <span class="pull-right">
            <a class="btn new_adress"><i class="fa fa-plus"></i> <?=l("Ajouter une nouvelle adresse", "core");?></a>
            <a data-toggle="collapse" href="#adress_collapse" class="btn btn-primary"><i class="fa fa-minus"></i></a>
          </span>
        </div>
        <div id="adress_collapse" class="panel-collapse collapse in">
          <div class="panel-body" id="address_inputs">
            <input type="hidden" name="address[id]" id="id_address" value="">
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="customer_addresses"><?=l("Nom de l’adresse", "core");?></label>  
              <div class="col-md-5">
                <select id="customer_addresses" class="form-control">
                  <option value="" selected><?=l("Sélectionnez une adresse", "core");?></option>
                  <?php if( isset($addresses) ) : ?>
                    <?php foreach ($addresses as $key => $address) : ?>
                      <option value="<?php echo $address['id'];?>"><?php echo $address['name'];?></option>
                    <?php endforeach;?>
                  <?php endif;?>
                </select>
                <small><?=l("Sélectionnez une adresse dessus", "core");?> <u><?=l("OU", "core");?></u> <?=l("remplir les champs suivant pour ajouter un nouvelle addresse", "core");?></small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="adress_name"><?=l("Nom de l'adresse *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="address[adress_name]" class="form-control" id="adress_name" value="" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="firstname"><?=l("Nom *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="address[firstname]" type="text" class="form-control" id="firstname" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="lastname"><?=l("Prénom *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="address[lastname]" type="text" class="form-control" id="lastname" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="lastname"><?=l("Société *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="address[company]" type="text" class="form-control" id="address_company" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="addresse"><?=l("Adresse *", "core");?></label>  
              <div class="col-md-8">
                <input name="address[addresse]" type="text" class="form-control" id="addresse" value="">
                <!--small>Numéro dans la rue, boîte postale, nom de la société</small-->
              </div>
            </div>
            <!--div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="addresse2">Adresse (Ligne 2)</label>  
              <div class="col-md-8">
                <input name="address[addresse2]" type="text" class="form-control" id="addresse2" value="">
                <small>Appartement, suite, bloc, bâtiment, étage, etc.</small>
              </div>
            </div-->
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="codepostal"><?=l("Code postal *", "core");?></label>  
              <div class="col-md-4 col-lg-3 col-sm-4">
                <input name="address[codepostal]" type="text" class="form-control" id="codepostal" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="city"><?=l("Ville *", "core");?></label>  
              <div class="col-md-4 col-lg-3 col-sm-4">
                <input name="address[city]" type="text" class="form-control" id="city" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="id_country"><?=l("Pays *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <select name="address[id_country]" class="form-control" id="country">
                  <?php foreach ($countries as $key => $country) : ?>
                    <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="ip"><?=l("Adresse IP", "core");?></label>  
              <div class="col-md-6">
                <input type="text" class="form-control" id="ip" value="" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="phone"><?=l("Téléphone fixe", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="address[phone]" type="text" class="form-control" id="phone" value="">
                <small><?=l("Téléphone fixe (pas obligatoire)", "core");?></small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="mobile"><?=l("Téléphone portable *", "core");?></label>  
              <div class="col-md-6 col-lg-4 col-sm-8">
                <input name="address[mobile]" type="text" class="form-control" id="mobile" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 col-lg-3 col-sm-4 control-label" for="info"><?=l("Informations complémentaires", "core");?></label>  
              <div class="col-md-8">
                <textarea id="info" rows="4" name="address[info]" type="text" class="form-control"></textarea>
                <br>
                <a target="_blank" href="../pdf/adress.php?id_adress=0" id="0" class="btn btn-success print_adress"><?=l("Imprimer une étiquette", "core");?></a>
              </div>
            </div>
          </div><!--/ .panel-body -->
          <div class="panel-footer">
            <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
            <button type="submit" name="<?= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
          </div><!--/ .panel-footer -->
        </div><!--/ .customer_collapse -->
      </div><!--/ .panel -->

      <div class="panel panel-default">
        <div class="panel-heading"> <?=l("Information complémentaires", "core");?> 
          <a data-toggle="collapse" href="#info_sup_collapse" class="btn btn-primary pull-right"><i class="fa fa-minus"></i></a>
        </div>
        <div id="info_sup_collapse" class="panel-collapse collapse in">
        <div class="panel-body">
          <div class="form-group">
            <div class="col-md-12 left0">
              <textarea id="info_sup" rows="4" name="customer[info_sup]" type="text" class="form-control"><?=(isset($customer['info_sup'])) ? $customer['info_sup'] : '';?></textarea>
            </div>
          </div>
        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
          <button type="submit" name="<?= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
        </div><!--/ .panel-footer -->
        </div>
      </div><!--/ .panel -->

      <div class="panel panel-default">
        <div class="panel-heading"> <?=l("Commentaire (en interne uniquement)", "core");?>
          <a data-toggle="collapse" href="#note_collapse" class="btn btn-primary pull-right collapsed"><i class="fa fa-minus"></i></a>
        </div>
        <div id="note_collapse" class="panel-collapse collapse">
        <div class="panel-body">
          <div class="alert alert-info"><?=l("Cette note sera affichée pour tous les employés, mais pas au client.", "core");?></div>
          <div class="form-group">
            <div class="col-md-12 left0">
              <textarea id="note_content" rows="4" name="customer[note_content]" type="text" class="form-control"><?=(isset($customer['note_content'])) ? $customer['note_content'] : '';?></textarea>
            </div>
          </div>
        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
          <button type="submit" name="<?= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
        </div><!--/ .panel-footer -->
        </div>
      </div><!--/ .panel -->

      <div class="panel panel-default">
        <div class="panel-heading"> <?=l("Historique des messsages", "core");?>  
          <a data-toggle="collapse" href="#msg_collapse" class="btn btn-primary pull-right collapsed"><i class="fa fa-minus"></i></a>
        </div>
        <div id="msg_collapse" class="panel-collapse collapse">
          <div class="panel-body">

            <!--div class="form-group">
              <div class="col-md-9 left0">
                <textarea name="email[message]" class="form-control" placeholder="<?=l("Envoyer un email au client", "core");?>"></textarea>
              </div>
              <div class="col-sm-3 left0">
                <input type="submit" name="email[send_email]" class="btn btn-primary btn-block" value="<?=l("Envoyez cette email", "core");?>">
              </div>
            </div-->

            <div class="panel-subheading">
              <i class="fa fa-envelope"></i>
              <strong><?=l("Historique des messages", "core");?></strong>
            </div>

            <?php if( !empty($directories)  || isset($id_customer) && $id_customer > 0) : ?>
              <ul class="nav nav-tabs">
              <?php 
              $dirs = ""; 
              $dir_count = count($directories);
              ?>
              <?php foreach ($directories as $key => $directory) : ?>
                <li <?=($directory['id'] == $id_dir ) ? 'class="active"' : ''; ?>>
                  <a href="?module=users&action=edit&id=<?=$id_customer; ?>&id_dir=<?=$directory['id']; ?>#dir<?=$directory['id']; ?>" href="#dir<?=$directory['id']; ?>"><?=$directory['name']; ?></a>
                </li>
                <?php if( $key == 4 ) : ?>
                <li role="presentation" class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Dossiers <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                <?php endif; ?>
                <?php  if( ($key+1) === $dir_count) : ?>
                </ul></li>
                <?php endif; ?>
                <!-- prepar directories -->
                <?php $dirs .= '<li><a class="move_to" data-dir="'. $directory['id'] .'">'. $directory['name'] .'</a></li>';?>
              <?php endforeach; ?>
              </ul>


              <div class="tab-content">
                <div id="dir<?php echo $id_directory; ?>" class="tab-pane fade in active">
                  <table class="table bg-white" id="messages">
                    <?php if( !empty($messages) ) : ?>
                      <?php foreach ($messages as $key => $message) : ?>
                      <tr class="message_row">
                        <td align="center" width="150">
                          <strong><?php echo ( $message['id_sender'] == $from ) ? l("Client") : l("core"); ?></strong>
                          <hr style="margin: 5px 0px;"> 
                          <p><?php echo date('d/m/Y H:m', strtotime($message['cdate']) ); ?></p>
                        </td>
                        <td style="vertical-align: top;">
                          <strong>Sujet :</strong> <span class="message_object"><?=($message['object'] != "" ) ? $message['object'] : "sans sujet";?></span> - <strong>N°</strong><?php echo $message['id'];?>
                          <?php if( $message['id_sender'] != $from ) : ?>
                           <?php echo ( $message['viewed'] == "1" ) ? '<span class="label label-success"><i class="fa fa-eye"></i> Vue le : '. date('m/d/y H:m:s A', $message['vdate']) ."</span>" : '<span class="label label-primary"><i class="fa fa-eye-slash"></i></span>';?>
                          <?php endif; ?>
                          <br>
                          <span class="message_body"><?php echo $message['message'];?></span>
                          </ul>
                        </td>
                        <td width="20">
                          <?php if( !empty($message['attachement']) ) : ?>
                            <a download="<?=$message['attachement'];?>" title="<?=$message['file_name'];?>" href="<?php echo '../../files/attachments/contact/'. $message['id'] .'/'. $message['attachement'];?>" class="btn btn-primary"><i class="fa fa-file-o"></i></a>
                          <?php endif; ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                    <div class="alert alert-info"><?=l("Aucune messages dans ce dossier !", "core");?></div>
                    <?php endif; ?>
                  </table>
                  <?php 
                  $non_allowed = array(1,2,3,4,5);
                  if( !in_array($id_dir, $non_allowed) ) : ?>
                    <a class="btn btn-danger" id="delete_directory" data-dir="<?php echo $id_dir; ?>"><i class="fa fa-trash"></i> <?=l("Supprimer ce Dossier", "core");?></a>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
          </div><!--/ .panel-body -->
          <div class="panel-footer">
            <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
            <button type="submit" name="<?= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
          </div><!--/ .panel-footer -->
        </div>
      </div><!--/ .panel -->

      <!--div class="panel panel-default">
        <div class="panel-heading"> <?//=l("Historique devis / commande", "core");?> 
          <a data-toggle="collapse" href="#quote_collapse" class="btn btn-primary pull-right collapsed"><i class="fa fa-minus"></i></a>
        </div>
        <div id="quote_collapse" class="panel-collapse collapse">
          <div class="panel-body">

            <div class="panel-subheading">
              <i class="fa fa-pencil-square-o"></i>
              <strong><?//=l("Historique devis", "core");?></strong>
            </div>
            <table class="table datatable" style="width: 100%;">
              <thead>
                <tr>
                  <th><?//=l("ID", "core");?></th>
                  <th><?//=l("Nom de Devis", "core");?></th>
                  <th><?//=l("Réference", "core");?></th>
                  <th><?//=l("Socièté", "core");?></th>
                  <th><?//=l("Valable jusqu’au", "core");?></th>
                  <th><?//=l("Formule", "core");?></th>
                </tr>
              </thead>
              <?php //if( !empty($customer_quotes) ) : ?>
                <tbody>
                  <?php //foreach ($customer_quotes as $key => $quote) : ?>
                  <tr>
                    <td><?//=$quote['id']; ?></td>
                    <td><?//=$quote['name']; ?></td>
                    <td><?//=$quote['reference']; ?></td>
                    <td><?//=$quote['company']; ?></td>
                    <td><?//=$quote['expiration_date']; ?></td>
                    <td><?//=$quote['carrier_type']; ?></td>
                  </tr>
                  <?php //endforeach; ?>
                </tbody>
              <?php //endif; ?>
            </table>

            <div class="panel-subheading">
              <i class="fa fa-credit-card"></i>
              <strong><?//=l("Historique Commandes", "core");?></strong>
            </div>
            <table class="table datatable" style="width: 100%;">
              <thead>
                <tr>
                  <th><?//=l("ID", "core");?></th>
                  <th><?//=l("Nom de Devis", "core");?></th>
                  <th><?//=l("Réference", "core");?></th>
                  <th><?//=l("Socièté", "core");?></th>
                  <th><?//=l("Formule", "core");?></th>
                </tr>
              </thead>
              <?php //if( !empty($customer_orders) ) : ?>
                <tbody>
                  <?php //foreach ($customer_quotes as $key => $order) : ?>
                  <tr>
                    <td><?//=$order['id']; ?></td>
                    <td><?//=$order['name']; ?></td>
                    <td><?//=$order['reference']; ?></td>
                    <td><?//=$order['company']; ?></td>
                    <td><?//=$order['carrier_type']; ?></td>
                  </tr>
                  <?php //endforeach; ?>
                </tbody>
              <?php //endif; ?>
            </table>

          </div>
          <div class="panel-footer">
            <button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?//=l("Fermer", "core");?></button>
            <button type="submit" name="<?//= (isset($id_customer) && $id_customer > 0) ? 'update_customer' : 'save_customer';?>" class="btn btn-primary pull-right"><?=l("Valider", "core");?></button>
          </div>
        </div-->

      </div><!--/ .panel -->
    </div><!--/ .col-sm-6 -->
  <?php endif; ?>


</form><!--/ .form -->

<script>
$(document).ready(function(){


  if(window.location.hash) {
    // Fragment exists
    $('a[data-toggle=collapse]').each(function(){
      $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
    });
    $('.panel-collapse:not("#msg_collapse")').collapse('hide');
    $('#msg_collapse').collapse('show');
    $('a[href=#msg_collapse]').find('i').removeClass('fa-plus').addClass('fa-minus');
  }


  //#dir1

  //on load get adress
  var id_adress = $('select#customer_addresses option:eq(1)').val();
  load_customer_adress(id_adress);


  //collapse_panel
  $('a[data-toggle=collapse]').each(function(){
    if ( $( this ).hasClass( "collapsed" ) ) {
      $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
    }else{
      $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
    }
  });
  $('a[data-toggle=collapse]').on('click', function(){
    if ( $( this ).hasClass( "collapsed" ) ) {
      $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
    }else{
      $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
    }
  });



  //Ajouter une nouvelle adresse
  $('.new_adress').on('click', function(){
    $('#adress_panel input').val('');
    $('#adress_panel select option:selected').prop("selected", false);
    $('.print_adress').attr('href','#');

    //$(".print_adress").attr("id", "");
  });

  //print-adress
  /*$('.print_adress').on('click', function(){
    var id_adress = $(this).attr('id');
    $.ajax({
      type: "POST",
      data: {id_adress:id_adress},
      url: 'ajax/users/print-adress.php',
      success: function(data){
      }
    });

  });*/

  
  

  $('#customer_addresses').on('change', function(){
    //$(".print_adress").attr("id", "");
    $('.print_adress').attr('href','#');

    var id_adress = $(this).find('option:selected').val();
    load_customer_adress(id_adress);
  });
  // jquery filer
  $('#attachement').filer({
    maxSize: 8,
    extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt']
  });
  //send email
  $("#send_email").change(function() {
    if(this.checked) {
      $('#email_content').show();
    }else{
      $('#email_content').hide();
    }
  });

});


function load_customer_adress(id_adress){
  //reset inputs
  $('#address_inputs').find('input').val('');
  $('#address_inputs').find('select#country option:selected').prop("selected", false);
  if(id_adress == "" ) return false;
  $.ajax({
    type: "POST",
    data: {id_adress:id_adress},
    url: 'ajax/users/load-address-infos.php',
    success: function(data){
      //fill inputs with data
      var data = $.parseJSON(data);
      $('select#customer_addresses option[value="'+data['id']+'"]').prop("selected", true);
      $('#id_address').val(data['id']);
      //$(".print_adress").attr("id", data['id']);
      $('.print_adress').attr('href','../pdf/adress.php?id_adress='+data['id']);
      $('#firstname').val(data['firstname']);
      $('#lastname').val(data['lastname']);
      $('#address_company').val(data['company']);
      $('#adress_name').val(data['name']);
      $('#addresse').val(data['addresse']);
      //$('#addresse2').val(data['addresse2']);
      $('#codepostal').val(data['codepostal']);
      $('#city').val(data['city']);
      $('#phone').val(data['phone']);
      $('#mobile').val(data['mobile']);
      $("textarea#info").val(data['info']);
      $("#country option[value='"+data['id_country']+"']").prop("selected", true);
      $('#ip').val(data['ip']);
    }
  });
}

/*function collapse_panel(this){
  if ( $( this ).hasClass( "collapsed" ) ) {
    $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
  }else{
    $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
  }
}
*/</script>