<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */
//session_start();

require_once "locale/i18n.php";
require_once "classes/install.class.php";
$os = new Okad_Install;

//get countries
$c_path = "json/countries.json";
$countries = $os->getJson($c_path);

//get activities
$a_path = "json/activities.json";
$activities = $os->getJson($a_path);

//get project directory
$server_dir = explode('/', $_SERVER['REQUEST_URI']); 
unset($server_dir[0]);
$shop_uri = implode("/", $server_dir);
$shop_uri = "/".str_replace("install/index.php", "", $shop_uri);
$domain = $_SERVER['HTTP_HOST'];

?>
<!DOCTYPE html>
<html dir="<?=$direction;?>" lang="<?=$locale;?>">
<head>
  <meta charset="UTF-8">
  <title><?=T_("OkadShop Installateur");?></title>
  <link rel="icon" href="favicon.ico">
  <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href="css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <link href="css/style.css" type="text/css" rel="stylesheet">
  <?php if($direction=="rtl") : ?>
    <link href="css/rtl.css" type="text/css" rel="stylesheet">
  <?php endif; ?>
</head>
<body>
<input type="hidden" id="shop_data" value="">
<input type="hidden" id="user_data" value="">
<input type="hidden" id="db_data" value="">

  <nav class="navbar navbar-default" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <img src="logo.png" class="logo">
      </div>
      <!--div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#"><?//=T_("Forums");?></a></li>
          <li><a href="#"><?//=T_("Blog");?></a></li>
          <li><a href="#"><?//=T_("Documentation");?></a></li>
          <li><a href="#"><?//=T_("Support");?></a></li>
        </ul>
      </div--><!--/.nav-collapse -->
    </div><!--/.container -->
  </nav>

  <section id="achieved">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <h1><?=T_("Assistant d'installation");?></h1>
        </div><!--/ .col-sm-3 -->
        <div class="col-sm-8">
          <ul class="pull-right" id="current_step">
            <li class="welcome active">1</li>
            <li class="licences">2</li>
            <li class="system">3</li>
            <li class="infos">4</li>
            <li class="database">5</li>
            <li class="complete">6</li>
          </ul>
        </div><!--/ .col-sm-9 -->
      </div><!--/ .row -->
    </div><!--/ .container -->
  </section>

  <section id="wizard-wrap">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <ul class="nav" id="steps">
            <li class="welcome active"><?=T_("Bienvenue");?></li>
            <li class="licences"><?=T_("Acceptation des licences");?></li>
            <li class="system"><?=T_("Compatibilité système");?></li>
            <li class="infos"><?=T_("Informations");?></li>
            <li class="database"><?=T_("Database Configuration");?></li>
            <li class="complete"><?=T_("Installation de la boutique");?></li>
          </ul>
        </div><!--/ .col-sm-3 -->

        <div class="col-sm-9">
          <div class="tab-content" id="content">
            <div class="alert alert-danger" id="alert" style="display:none;">
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong></strong>
            </div>

            <div class="tab-pane active" id="welcome">
              <h2><?=T_("Bienvenue sur l'installation de OkadShop 1.0.0");?></a></h2>
              <p><?=T_("L'installation de OkadShop est simple et rapide. Dans quelques minutes, vous ferez partie d'une communauté de plus actifs des marchands. Vous êtes sur le point de créer votre propre boutique en ligne, unique en son genre, que vous pourrez gérer très facilement au quotidien.");?></p>
              <!--p><?//=T_('Besoin d\'aide ? N\'hésitez pas à <a href="#" target="_blank">regarder cette courte vidéo</a>, ou à parcourir notre <a href="#" target="_blank">documentation</a>.');?></p-->
              <h3 style="margin-bottom: 10px;"><?=T_("Continuer l'installation en :");?></h3>
              <div class="col-sm-3" style="padding:0px;">
                <form action="" id="lang_form" method="post">
                  <select id="default_lang" name="default_lang" class="form-control">
                    <option value="en_US">English</option>
                    <option value="fr_FR" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="fr_FR") ? 'selected' : '';?>>Français</option>
                    <option value="ar_AR" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="ar_AR") ? 'selected' : '';?>>العربية</option>
                    <option value="es_ES" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="es_ES") ? 'selected' : '';?>>Español</option>
                    <option value="de_DE" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="de_DE") ? 'selected' : '';?>>Deutsch</option>
                    <option value="it_IT" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="it_IT") ? 'selected' : '';?>>Italiano</option>
                    <option value="pt_PT" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="pt_PT") ? 'selected' : '';?>>Portuguese</option>
                    <option value="pl_PL" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="pl_PL") ? 'selected' : '';?>>Polish</option>
                    <option value="nl_NL" <?=(isset($_SESSION['default_lang']) && $_SESSION['default_lang']=="nl_NL") ? 'selected' : '';?>>Dutch</option>
                  </select>
                </form>
              </div><br>
              <p style="margin-top: 15px;"><?=T_("Le choix de la langue ci-dessus s'applique à l'assistant d'installation. Une fois votre boutique installée, vous pourrez choisir la langue de votre boutique parmi plus de 60 traductions disponibles gratuitement !");?></p>
            </div><!--/ .tab-pane -->

            <div class="tab-pane" id="licences">
              <h2 id="licenses-agreement"><?=T_("Acceptation des licences");?></h2>
              <p><?=T_("Afin de profiter gratuitement des nombreuses fonctionnalités qu'offre OkadShop, merci de prendre connaissance des termes des licences ci-dessous. Le coeur de OkadShop est publié sous licence OSL 3.0 tandis que les modules et thèmes sont publiés sous licence AFL 3.0.");?></p>
              
              <div style="height:200px;direction: ltr; border:1px solid #ccc; margin-bottom:8px; padding:5px; background:#fff; overflow: auto; overflow-x:hidden; overflow-y:scroll;">
                <?php $licence_agrement = file_get_contents('licence_agrement.txt');
                  echo $licence_agrement; ?>
              </div>
            
              <div>
                <input id="set_license" name="licence_agrement" style="vertical-align: middle;float:left" type="checkbox" value="1">
                <div style="width:600px;margin-left:8px">
                  <label for="set_license"><strong><?=T_("J'accepte les termes et conditions du contrat ci-dessus.");?></strong></label>
                </div>
              </div>
            </div><!--/ .tab-pane -->

            <div class="tab-pane" id="system">
              <h3><?=T_("Nous vérifions en ce moment la compatibilité de OkadShop avec votre système");?></h3>
              <p><?=T_('Si vous avez la moindre question, n\'hésitez pas à visiter notre <a href="#" target="_blank">documentation</a> et notre <a href="#" target="_blank">forum communautaire</a>.');?></p>
              <div class="alert alert-success"><?=T_("La compatibilité de OkadShop avec votre système a été vérifiée");?></div>
            </div><!--/ .tab-pane -->

            <div class="tab-pane" id="infos">
              <h3><?=T_("Informations à propos de votre boutique");?></h3>
              <form class="form-horizontal">
                <input id="home_url" name="home_url" type="hidden" value="http://<?=$domain.$shop_uri;?>" class="form-control">
                <input id="uri" name="uri" type="hidden" value="<?=$shop_uri;?>" class="form-control">
                <input id="domain" name="domain" type="hidden" value="<?=$domain;?>" class="form-control">
                <input id="domain_ssl" name="domain_ssl" type="hidden" value="<?=$domain;?>" class="form-control">

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="shop_name"><?=T_("Nom de la boutique");?></label>  
                  <div class="col-sm-4">
                    <input id="shop_name" name="shop_name" type="text" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <!--div class="form-group">
                  <label class="col-sm-3 control-label" for="home_url"><?//=T_("Lien vers boutique");?></label>  
                  <div class="col-sm-4">
                    <input id="home_url" name="home_url" type="url" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                  <div class="col-md-5">
                    <p><?//=T_("C'est le lien de la page d'acceuil, inclure le sous domain.");?></p>
                  </div>
                </div><hr-->
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="shop_activity"><?=T_("Activité principale");?></label>  
                  <div class="col-sm-4">
                    <select name="shop_activity" class="form-control" id="shop_activity">
                      <option value="0" selected><?=T_("Merci de choisir une activité");?></option>
                      <?php 
                      if( !empty($activities) )
                      {
                        foreach ($activities as $key => $activity) {
                          echo '<option value="'.$activity['id'].'">'. T_( $activity['name'] ) .'</option>';
                        }
                      } 
                      ?>
                    </select>
                    <sup class="required">*</sup>
                  </div>
                  <div class="col-md-5">
                    <p><?=T_("Aidez-nous à mieux vous connaitre pour que nous puissions vous orienter et vous proposer les fonctionnalités les plus adaptées à votre activité !");?></p>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="shop_country"><?=T_("Pays");?></label>  
                  <div class="col-sm-4">
                    <select name="shop_country" class="form-control" id="shop_country">
                      <option value="0" style="font-weight: bold"><?=T_("Sélectionnez un pays");?></option>
                      <?php 
                      if( !empty($countries) )
                      {
                        foreach ($countries as $key => $country) {
                          echo '<option value="'.$country['iso_code'].'">'. T_( $country['name'] ) .'</option>';
                        }
                      } 
                      ?>
                    </select>
                    <sup class="required">*</sup>
                  </div>
                </div><hr>

                <h3><?=T_("Votre compte");?></h3>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="firstname"><?=T_("Prénom");?></label>  
                  <div class="col-sm-4">
                    <input id="firstname" name="firstname" type="text" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="lastname"><?=T_("Nom");?></label>  
                  <div class="col-sm-4">
                    <input id="lastname" name="lastname" type="text" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="email"><?=T_("Adresse e-mail");?></label>  
                  <div class="col-sm-4">
                    <input id="email" name="email" type="email" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                  <div class="col-sm-4">
                    <p><?=T_("Cette adresse e-mail vous servira d'identifiant pour accéder à l'interface de gestion de votre boutique.");?></p>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="password"><?=T_("Mot de passe");?></label>  
                  <div class="col-sm-4">
                    <input id="password" name="password" type="password" autocomplete="false" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                  <div class="col-sm-4">
                    <p><?=T_("Minimum 8 caractères");?></p>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="password_confirm"><?=T_("Confirmation du mot de passe");?></label>  
                  <div class="col-sm-4">
                    <input id="password_confirm" name="password_confirm" autocomplete="false" type="password" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <p><?=T_("Les informations recueillies font l'objet d’un traitement informatique et statistique, elles sont nécessaires aux membres de la société OkadShop afin de répondre au mieux à votre demande. Ces informations peuvent être communiquées à nos partenaires à des fins de prospection commerciale et être transmises dans le cadre de nos relations partenariales.");?></p>


              </form>
            </div><!--/ .tab-pane -->

            <div class="tab-pane" id="database">
              <h3><?=T_("Configurez la connexion à votre base de données en remplissant les champs suivants.");?></h3>
              <form class="form-horizontal">
                
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="database"><?=T_("Nom de la base");?></label>  
                  <div class="col-sm-4">
                    <input id="database" name="database" type="text" autocomplete="false" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="user"><?=T_("Identifiant de la base");?></label>  
                  <div class="col-sm-4">
                    <input id="user" name="user" type="text" autocomplete="false" value="root" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="password"><?=T_("Mot de passe de la base");?></label>  
                  <div class="col-sm-4">
                    <input id="password" name="password" autocomplete="false" type="password" value="" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="server"><?=T_("Adresse du serveur de la base");?></label>  
                  <div class="col-sm-4">
                    <input id="server" name="server" autocomplete="false" type="text" value="localhost" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="prefix"><?=T_("Préfixe des tables");?></label>  
                  <div class="col-sm-4">
                    <input id="prefix" name="prefix" autocomplete="false" type="text" value="os_" class="form-control">
                    <sup class="required">*</sup>
                  </div>
                </div><hr>
                <div class="form-group">
                  <div class="col-sm-4">
                    <a id="test_db" class="btn btn-success" type="button"><?=T_("Tester la connexion à la base de données");?></a>
                  </div>
                  <div class="col-sm-4">
                    <span class="db_message" style="margin-left: 25px;line-height: 35px;"></span>
                  </div>
                </div>
                
              </form>
            </div><!--/ .tab-pane -->

            <div class="tab-pane" id="complete">
              <center>
                <img src="img/loading.gif" width="85" class="loading">
                <div id="go_home" class="hidden">
                  <a href="#" class="btn btn-success home"><?=T_("Allez vers la page d'acceuil.");?></a>
                  <a href="#" class="btn btn-primary back"><?=T_("Allez au tableau de board.");?></a>
                  <br><br>
                  <div class="alert alert-warning"><?=T_("Pour des raisons de securité, n'oublie pas de supprimer le dossier install.");?></div>
                </div>
              </center>
            </div><!--/ .tab-pane -->
          </div>

          <div class="col-sm-12" id="step_button">
            <a class="btn btn-default prev"><?=T_("Précédent");?></a>
            <a class="btn btn-primary pull-right next"><?=T_("Suivant");?></a>
          </div>
          
        </div><!--/ .col-sm-9 -->

      </div><!--/ .row -->
    </div><!--/ .container -->
  </section><!--/ section -->



<script src="js/jquery-2.1.4.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).on("ready", function(){

  $('#default_lang').change(function(){
   $("#lang_form").submit();
  });

  //alert message
  $('.prev').hide();
  $("#alert").hide();

  //next page
  $('.next').click(function(){
    var id = $('#content .active').next().attr("id");
    $('.prev').show();

    if( id == "licences"){
      $('.next').removeClass('btn-primary disabled').addClass('btn-default disabled');
    }else if( id == "database" ){
      os_validate_form();
    }else if( id == "complete" ){
      $('.next, .prev').hide();
      os_run_installation();
    }else{
      $('input#set_license').prop('checked', false);
    }

    //set next id
    if( id == "system" ){
      set_active('infos');
    } else if( id != "database" ){
      set_active(id);
    }

  });

  //previous page
  $('.prev').click(function(){
    var id = $('#content .active').prev().attr("id");
    if( id == "welcome" ){
      $('.prev').hide();
      $('.next').removeClass('btn-default disabled').addClass('btn-primary');
    }else if( id == "licences" )
    { 
      $('.next').removeClass('btn-primary').addClass('btn-default disabled');
    }else{
      $('input#set_license').prop('checked', false);
      $('.next').removeClass('btn-default disabled').addClass('btn-primary');
    }
    //set active
    if( id == "system" ){
      set_active('licences');
    } else {
      set_active(id);
    }
    $('.next').show();
  });

  //accept licences
  $("#set_license").change(function() {
    if(this.checked) {
      $('.next').removeClass('btn-default disabled').addClass('btn-primary');
    }else{
      $('.next').removeClass('btn-primary').addClass('btn-default disabled');
    }
  });

  //test database connexion
  $( "#test_db" ).on('click', function() {
    $('.form-group').removeClass("has-warning");
    var db_serialize = $('#database input').serialize();

    var empty = 0;
    $('#database input:not(#password)').each(function(){
      if( $(this).val() == "" ){
        empty += 1;
        $(this).closest('.form-group').addClass('has-warning');
      }
    });
    if( empty > 0 ){
      $("#alert").show();
      $("#alert strong").text("<?=T_('Prière de remplir tous les champs requis.');?>");
      $("#alert").fadeTo(2000, 500).slideUp(500);
      return false;
    }
    //send ajax request
    $.ajax({
      type: "POST",
      data: db_serialize,
      url: 'ajax/test-db.php',
      success: function(data){
        try
         {
          var inputs = $("#database input");
          var db_data = JSON.stringify( inputs.serializeArray() );
          $('#db_data').empty().val( db_data );

          //test response
          var response = $.parseJSON(data);
          $('.db_message').text( response );
          $('.next').removeClass('btn-default disabled').addClass('btn-primary');
         }
         catch(err)
         {
          $('.db_message').text( "Connexion error." );
          $('.next').removeClass('btn-primary disabled').addClass('btn-default disabled');
         }
         setTimeout(function () {
          $('.db_message').text("");
         }, 2500);
      }
    });
  });


  //change lang
  $('#id_lang').on('change', function(){
    var lang = $(this).find('option:selected').val();
    extend_search('lang', lang);
  });


});

function set_active(id){
  //content active class
  $('#content .tab-pane').removeClass('active');
  $('#content .tab-pane#'+id).addClass('active');
  //current step active class
  $('#current_step li').removeClass('active');
  $('#current_step li.'+id).addClass('active');
  //steps active class
  $('#steps li').removeClass('active');
  $('#steps li.'+id).addClass('active');
}

function os_validate_form(){
  $('.form-group').removeClass("has-warning");

  //shop
  var shop_name     = $('input#shop_name').val();
  var home_url      = $('input#home_url').val();
  var domain        = $('input#domain').val();
  var domain_ssl    = $('input#domain_ssl').val();
  var uri           = $('input#uri').val();
  var shop_activity = $('select#shop_activity option:selected').val();
  var shop_country  = $('select#shop_country option:selected').val();

  //user
  var firstname     = $('input#firstname').val();
  var lastname      = $('input#lastname').val();
  var email         = $('input#email').val();
  var password      = $('input#password').val();
  var confirm       = $('input#password_confirm').val();
  var error = false;

  //form validation
  $('#infos input').each(function(){
    var empty = false;
    if( $(this).val() == "" ){
      empty = true;
    }
    if(empty || shop_activity === "0" || shop_country === "0"){
      $("#alert strong").text("<?=T_('Prière de remplir tous les champs requis.');?>");
      $("#alert").fadeTo(2000, 500).slideUp(500);
      error = true;
    }
  });
  //email validate
  var valid_email = isValidEmailAddress(email);
  if( !valid_email ){
    $("#email").closest('.form-group').addClass('has-warning');
    $("#alert strong").text("<?=T_('Format de e-mail n\'est pas valide.');?>");
    $("#alert").fadeTo(2000, 500).slideUp(500);
    error = true;
  }else if( password != confirm )
  {
    $("input[type='password']").closest('.form-group').addClass('has-warning');
    $("#alert strong").text("<?=T_('Le mot de passe ne correspond pas.');?>");
    $("#alert").fadeTo(2000, 500).slideUp(500);
    error = true;
  }else if( password.length < 8 )
  {
    $("input[type='password']").closest('.form-group').addClass('has-warning');
    $("#alert strong").text("<?=T_('Mot de passe est trop court (min 8 caractères requis).');?>");
    $("#alert").fadeTo(2000, 500).slideUp(500);
    error = true;
  }

  //shop array
  var shop = {};
  shop['name']     = shop_name;
  shop['activity'] = shop_activity;
  shop['country']  = shop_country;
  shop['home_url'] = home_url;
  shop['domain'] = domain;
  shop['domain_ssl'] = domain_ssl;
  shop['uri'] = uri;

  //shop array
  var user = {};
  user['firstname'] = firstname;
  user['lastname']  = lastname;
  user['email']     = email;
  user['password']  = password;
  user['confirm']   = confirm;
  
  //set active
  if( !error ){
    $('#go_home .home').attr('href', home_url);
    $('#go_home .back').attr('href', home_url+'admin/index.php');
    $('#shop_data').empty().val( JSON.stringify(shop) );
    $('#user_data').empty().val( JSON.stringify(user) );

    set_active('database');
    $('.next').show();
    $('.next').removeClass('btn-primary disabled').addClass('btn-default disabled');
  }else{
    $('#infos input').each(function(){
      if( $(this).val().length === 0 ){
        $(this).closest('.form-group').addClass('has-warning');
      }
    });
    if( $('#shop_activity').val() == "0" ){
      $('#shop_activity').closest('.form-group').addClass('has-warning');
    }
    if( $('#shop_country').val() == "0" ){
      $('#shop_country').closest('.form-group').addClass('has-warning');
    }
  }
  
}

//os_run_installation
function os_run_installation(){
  var shop_data = $('input#shop_data').val();
  var user_data = $('input#user_data').val();
  var db_data   = $('input#db_data').val();

  //run installation
  $.ajax({
    type: "POST",
    data: {shop:shop_data, user:user_data, db:db_data},
    url: 'ajax/install.php',
    success: function(data){

      try {
      //check if response is json
      var json = JSON.parse(data);
      $('.loading').hide();
      $('#alert')
      .removeClass('alert-danger')
      .addClass('alert-success')
      .empty()
      .show()
      .text("<?=T_('l\'installation est complète !');?>");
      $('#go_home').removeClass('hidden');

      os_send_email(shop_data, user_data);

      }catch (e) {
        $('.loading').hide();
        $('#alert').empty().show().text("<?=T_('Une erreur est survenue !');?>");
      }
      
    }
  });
}


function os_send_email(shop_data, user_data){
  //send statistiques email
  $.ajax({
    type: "POST",
    data: {shop:shop_data, user:user_data},
    url: 'ajax/email.php',
    success: function(data){ 
      console.log("email was send.");      
    }
  });
}


function isValidEmailAddress(email) {
  var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
  return pattern.test(email);
}

//extend search function
function extend_search(paramName, paramValue)
{
  var url = window.location.href;
  var hash = location.hash;
  url = url.replace(hash, '');
  if (url.indexOf(paramName + "=") >= 0)
  {
    var prefix = url.substring(0, url.indexOf(paramName));
    var suffix = url.substring(url.indexOf(paramName));
    suffix = suffix.substring(suffix.indexOf("=") + 1);
    suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
    url = prefix + paramName + "=" + paramValue + suffix;
  }
  else
  {
  if (url.indexOf("?") < 0)
    url += "?" + paramName + "=" + paramValue;
  else
    url += "&" + paramName + "=" + paramValue;
  }
  window.location.href = url + hash;
}
</script>
</body>



