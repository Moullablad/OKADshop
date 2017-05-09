<?php
use Core\Form;
function Add()
{
  ?>
    <style type="text/css">
      #seo-preview{
        border: 1px solid #d9d9d9;
        padding: 0 10px;

      }
      #seo-preview a.title{
        color: #1a0dab;
        font-size: 18px;
      }
      #seo-preview a:hover{
        text-decoration: underline;
      }
      #seo-preview h5.page-link{
        color: #006621;
        font-style: normal;
        font-size: 14px;
        line-height: 16px;
        font-family: arial,sans-serif;
      }
      #seo-preview p.page-desc{
        line-height: 1.4;
        word-wrap: break-word;
        color: #545454;
        font-family: arial,sans-serif;
        font-size: small;
        text-align: left;
        font-weight: normal;
      }
    </style>
  <?php
	$user=new Form();
	$form = array(   

  array('DIVSTART','','col-sm-12 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-user"></i> Ajouter une page'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('users'),
      array('HIDDEN','module','50','module','module','cms'),
      array('HIDDEN','redirect','50','redirect','redirect','cms'),
      array('HIDDEN','mdir','50','mdir','mdir','cms'),
      array('DIVSTART','','form-horizontal inline-custom'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title','form-control','form-control','title','title','','title'),
      array('DIVEND'),

      //array('DIVSTART','','form-group col-sm-6 left0'),
       // array('LABEL','Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
       // array('TEXT','description','form-control','form-control','description','description','','description'),
      //array('DIVEND'),

       

      array('DIVSTART','','form-group clearfloat cms_description'),
       array('LABEL','Page content :'/*Text*/,'control-label'/*class*/,''/*ID*/),
       array('TEXTAREA','content','8','content summernote form-control','content',''),
      array('DIVEND'),



      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','CMS Category :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_cmscat','form-control','id_cmscat',_DB_PREFIX_.'cms_categories','id','title'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Langage :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_lang','form-control','id_lang',_DB_PREFIX_.'langs','id','name'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-6 left0'),
        array('TITLE','','','','<br><i class="fa fa-line-chart"></i> SEO <hr>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Meta title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_title','form-control','form-control seo-preview-refrech','meta_title','meta_title','','meta_title'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Meta description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_description','form-control','form-control seo-preview-refrech','meta_description','meta_description','','meta_description'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Meta keywords :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_keywords','form-control','form-control','meta_keywords','meta_keywords','','meta_keywords'),
      array('DIVEND'),

       array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','Preview :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TITLE','','','','<div id="seo-preview"><h3><a href="#" class="title">Your Title here</a></h3><h5 class="page-link">'.generate_url('cms/').'</h5><p class="page-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p></div>'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','image de la page :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('HIDDEN','img_cms','form-control','form-control','img_cms','','','img_cms'),
        array('TITLE','','','','<form id="img_cms_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/cms/">
          <input type="file" name="image" id="filer_input" class="img_cms_file" accept="image/*">
        </form>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','cover de la page :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('HIDDEN','cover_cms','form-control','form-control','cover_cms','','','cover_cms'),
        array('TITLE','','','','<form id="cover_cms_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/cms/cover/">
          <input type="file" name="image" id="filer_input" class="cover_cms_file" accept="image/*">
        </form>'),
      array('DIVEND'),


    array('DIVEND'),
    array('DIVEND'),//END PANEL BODY

    array('DIVSTART','','panel-footer clearfix'),
      array('DIVSTART','','pull-right'),
        array('BUTTON','Ajouter','send','btn btn-primary','send'),
        array('CBUTTON','Fermer','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
      array('DIVEND'),
    array('DIVEND'),//PANEL FOOTER
      
  array('DIVEND'),//END PANEL

                   
  );
  $user->Draw($form);



  ?>
  <script>
    $(document).ready(function(){


      $('.img_cms_file').on('change', function (e) {
        $('#img_cms_form').submit();
      });
      $('#img_cms_form').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();
 
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
 
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', // selon le retour attendu
            data: data,
            success: function (response) {    

              if (response != "0")
                $('#img_cms').val(response);
              }
        });
      });


      $('.cover_cms_file').on('change', function (e) {
        $('#cover_cms_form').submit();
      });
      $('#cover_cms_form').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();
 
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
 
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', // selon le retour attendu
            data: data,
            success: function (response) {    

              if (response != "0")
                $('#cover_cms').val(response);
              }
        });
      });


      $(".seo-preview-refrech").keyup(function(){
        var meta_title = $('#meta_title').val();
        var meta_description = $('#meta_description').val();
        var page_link = "<?= generate_url('cms/'); ?>";
        if (meta_title == "") {
           meta_title = "Your Title here";
        }
        if (meta_description == "") {
           meta_description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
        }
        $("#seo-preview a.title").text(meta_title);
        $("#seo-preview .page-link").text(page_link);
        $("#seo-preview .page-desc").text(meta_description);

      });
    });
  </script>
  <?php
//END  ADD FUNCTION
}
function PADD()
{
  $Post = array(
    array(_DB_PREFIX_.'cms'),
    array('title','title','text','255','text'),
    array('content','content','text','','text'),
    array('meta_title','meta_title','text','','text'),
    array('meta_description','meta_description','text','','text'),
    array('meta_keywords','meta_keywords','text','','text'),
    array('id_cmscat','id_cmscat','number','45','number'),
    array('id_lang','id_lang','number','45','number'),
    array('img_cms','img_cms','text','','text'),
    array('cover_cms','cover_cms','text','','text'),
  );
  return $Post;
}


function EDIT($ID)
{				

  ?>
    <style type="text/css">
      #seo-preview{
        border: 1px solid #d9d9d9;
        padding: 0 10px;

      }
      #seo-preview a.title{
        color: #1a0dab;
        font-size: 18px;
      }
      #seo-preview a:hover{
        text-decoration: underline;
      }
      #seo-preview h5.page-link{
        color: #006621;
        font-style: normal;
        font-size: 14px;
        line-height: 16px;
        font-family: arial,sans-serif;
      }
      #seo-preview p.page-desc{
        line-height: 1.4;
        word-wrap: break-word;
        color: #545454;
        font-family: arial,sans-serif;
        font-size: small;
        text-align: left;
        font-weight: normal;
      }
    </style>
  <?php

  $tags = new Form();
  $post_link = generate_url('cms/'.$ID);
  global $common;
  $perma = $common->select("cms",array("permalink"),"where id = ".$ID);
  if (isset($perma[0]['permalink'])) {
    $post_link .= "-" . $perma[0]['permalink'];
  }

  $form=array(
  array(_DB_PREFIX_.'cms'/*table*/,'id'/*id table*/,$ID),
  array('HIDDEN','test','test',50,'module','module','cms'),
  array('HIDDEN','test','test',50,'mdir','mdir','cms'),
  array('DIVSTART'/*first div*/,''/*class*/,'form-horizontal'/*id*/),

    array('DIVSTART','','col-sm-6 col-md-12 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-pencil"></i> Edit page'),
      array('TITLE','','','','<div><i class="fa fa-eye" aria-hidden="true"></i> Voir l’article => <a target="_blanc" href="'.$post_link.'" >'.$post_link.'</a></div>'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title'/*name field*/,'title'/*name post*/,'100'/*size post*/,'form-control'/*class*/,'title'/*id*/),
      array('DIVEND'),
    

      array('DIVSTART','','form-group clearfloat cms_description'),
       array('LABEL','CMS content :'/*Text*/,'control-label'/*class*/,''/*ID*/),
       array('TEXTAREA','content','content','12','content summernote form-control','content'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','CMS Category :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_cmscat','id_cmscat','form-control','id_cmscat',_DB_PREFIX_.'cms_categories','id','title'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Langage :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_lang','id_lang','form-control','id_lang',_DB_PREFIX_.'langs','id','name'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('TITLE','','','','<br><i class="fa fa-line-chart"></i> SEO <hr>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Meta title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_title','meta_title','','seo-preview-refrech form-control','meta_title','meta_title',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Meta description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_description','meta_description','','form-control seo-preview-refrech','meta_description','meta_description',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Meta keywords :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_keywords','meta_keywords','form-control','form-control','meta_keywords','meta_keywords',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Permalink :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','permalink','permalink','form-control','form-control','permalink','permalink',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','Preview :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TITLE','','','','<div id="seo-preview"><h3><a href="#" class="title">Your Title here</a></h3><h5 class="page-link">'.generate_url('cms/'.$_GET['id']).'</h5><p class="page-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p></div>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','image de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','img_cms','img_cms','','form-control hidden','img_cms','',''),
        array('TITLE','','','','<form id="img_cms_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/cms/">
          <input type="file" name="image" id="filer_input" class="img_cms_file" accept="image/*">
          <img src="" id="cms_img_preview"  style="width: 300px;height: 200px;"/>
        </form>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','cover de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','cover_cms','cover_cms','','form-control hidden','cover_cms','',''),
        array('TITLE','','','','<form id="cover_cms_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/cms/cover/">
          <input type="file" name="image" id="filer_input" class="cover_cms_file" accept="image/*">
          <img src="" id="cover_img_preview"  style="width: 300px;height: 200px;"/>
        </form>'),
      array('DIVEND'),


    array('DIVEND'),
    array('DIVEND'),//END PANEL BODY

    array('DIVSTART','','panel-footer clearfix'),
      array('DIVSTART','','pull-right'),
        array('BUTTON','Modifier','send','btn btn-primary','send'),
        array('CBUTTON','Fermer','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
      array('DIVEND'),
    array('DIVEND'),//PANEL FOOTER
      
  array('DIVEND'),//END PANEL



		);
	$tags->EDraw($form);

  ?>
  <script>
    $(document).ready(function(){

      $('.img_cms_file').on('change', function (e) {
          $('#img_cms_form').submit();
      });

      $('.cover_cms_file').on('change', function (e) {
          $('#cover_cms_form').submit();
      });

      setImgPreview();
      $('#img_cms_form').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();
 
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
 
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', // selon le retour attendu
            data: data,
            success: function (response) {    

              if (response != "0")
                $('#img_cms').val(response);
            }
        });
      });

      setCoverPreview();
      $('#cover_cms_form').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();
 
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
 
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', // selon le retour attendu
            data: data,
            success: function (response) {    

              if (response != "0")
                $('#cover_cms').val(response);
            }
        });
      });



       seo_preview_refrech();
      $(".seo-preview-refrech").keyup(function(){
        seo_preview_refrech();
      });
      $("#send").click(function(){
 
      });
    });

    function setImgPreview(){
      var img = $('#img_cms').val();
      if (img != "") {
        $('#cms_img_preview').attr('src','../files/cms/'+img);
      }
    }

    function setCoverPreview(){
      var img = $('#cover_cms').val();
      if (img != "") {
        $('#cover_img_preview').attr('src','../files/cms/cover/'+img);
      }
    }

    function seo_preview_refrech(){
      var meta_title = $('#meta_title').val();
      var meta_description = $('#meta_description').val();
      var page_link = "<?= generate_url('cms/'.$_GET['id']); ?>";
      var permalink = $("#permalink").val();
      if (permalink != "") {
        page_link += "-"+permalink;
      }
      if (meta_title == "") {
         meta_title = "Your Title here";
      }
      if (meta_description == "") {
         meta_description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
      }
      $("#seo-preview a.title").text(meta_title);
      $("#seo-preview .page-link").text(page_link);
      $("#seo-preview .page-desc").text(meta_description);
    }
  </script>
  <?php
//END EDIT 
}


function PEDIT()
{
  $Post = array(
    array(_DB_PREFIX_.'cms'),
    array('W'/*where*/,'id'/*field id*/,'ID'/*property id*/),
    array('title'/*name field*/,'title'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('permalink'/*name field*/,'permalink'/*name post*/,'text'/*type verification*/,'150'/*size post*/),
    array('meta_title'/*name field*/,'meta_title'/*name post*/,'text'/*type verification*/,'255'/*size post*/),
    array('meta_description'/*name field*/,'meta_description'/*name post*/,'text'/*type verification*/,'255'/*size post*/),
    array('meta_keywords'/*name field*/,'meta_keywords'/*name post*/,'text'/*type verification*/,''/*size post*/),
    array('content'/*name field*/,'content'/*name post*/,'text'/*type verification*/,'4000'/*size post*/),
    array('id_cmscat','id_cmscat','number','45','number'),
    array('id_lang','id_lang','number','45','number'),
    array('img_cms'/*name field*/,'img_cms'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('cover_cms'/*name field*/,'cover_cms'/*name post*/,'text'/*type verification*/,'100'/*size post*/),



  );
  return $Post;
}


function DELETE($ID) {
  global $common;
  $common->delete('cms', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=cms"</script>';

}



?>

