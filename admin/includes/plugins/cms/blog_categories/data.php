<?php
use Core\Form;

function Add()
{

	$user=new Form();
	$form = array(   

  array('DIVSTART','','col-sm-12 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-user"></i> '.l("Ajouter une categories pour les articles","core")),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('blog_categories'),
      array('HIDDEN','module','50','module','module','blog_categories'),
      array('HIDDEN','redirect','50','redirect','redirect','blog_categories'),
      array('HIDDEN','mdir','50','mdir','mdir','cms'),
      array('DIVSTART','','form-horizontal inline-custom'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title','form-control','form-control','title','title','','title'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','description','form-control','form-control','description','description','','description'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Langage :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_lang','form-control','id_lang',_DB_PREFIX_.'langs','id','name'),
      array('DIVEND'),
      
      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Permalink :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','permalink','form-control','form-control','permalink','permalink','','permalink'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','categorie parent :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','parent','form-control','parent',_DB_PREFIX_.'blog_categories','id','title'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','image de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('HIDDEN','img','form-control','form-control','img','','','img'),
        array('TITLE','','','','<form id="img_blog_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="file" name="image" id="filer_input" class="img_blog_file" accept="image/*">
        </form>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','meta Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_title','form-control','form-control','meta_title','meta_title','','description'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL',' meta Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXTAREA','meta_description','8','meta_description form-control','meta_description',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','meta Keyword :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_keywords','form-control','form-control','tags','meta_keywords','','meta_keywords'),
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
      $('.img_blog_file').on('change', function (e) {
        $('#img_blog_form').submit();
      });
      $('#img_blog_form').on('submit', function (e) {
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
                $('#img').val(response);
              }
        });
      });
    });
  </script>
  <?php

//END USER ADD FUNCTION
}
function PADD()
{
  $Post = array(
    array(_DB_PREFIX_.'blog_categories'),
    array('title','title','text','100','text'),
    array('permalink','permalink','text','100','text'),
    array('description','description','text','1000','text'),
    array('id_lang','id_lang','text','45','text'),
    array('img','img','text','','text'),
    array('parent','parent','text','45','text'),
    array('meta_title','meta_title','text','','text'),
    array('meta_description','meta_description','text','','text'),
    array('meta_keywords','tags','text','','text'),
  );
  return $Post;
}


function EDIT($ID)
{				

  $tags = new Form();
  $form=array(

  array(_DB_PREFIX_.'blog_categories'/*table*/,'id'/*id table*/,$ID),
  array('HIDDEN','test','test',50,'module','module','blog_categories'),
  array('HIDDEN','test','test',50,'mdir','mdir','cms'),
  array('DIVSTART'/*first div*/,''/*class*/,'form-horizontal'/*id*/),

    array('DIVSTART','','col-sm-6 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-pencil"></i> Edit categorie'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title'/*name field*/,'title'/*name post*/,'100'/*size post*/,'form-control'/*class*/,'title'/*id*/),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 right0'),
        array('LABEL','Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','description'/*name field*/,'description'/*name post*/,'1000'/*size post*/,'form-control'/*class*/,'description'/*id*/),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Langage :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_lang','id_lang','form-control','id_lang',_DB_PREFIX_.'langs','id','name'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Permalink :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','permalink'/*name field*/,'permalink'/*name post*/,'100'/*size post*/,'form-control'/*class*/,'permalink'/*id*/),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Categorie Parent :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','parent','parent','form-control','parent',_DB_PREFIX_.'blog_categories','id','title'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','image de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','img','img','','form-control hidden','img','',''),
        array('TITLE','','','','<form id="img_blog_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="file" name="image" id="filer_input" class="img_blog_file" accept="image/*">
          <img src="" id="blog_img_preview"  style="width: 300px;height: 200px;"/>
        </form>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','meta Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_title'/*name field*/,'meta_title'/*name post*/,'1000'/*size post*/,'form-control'/*class*/,'meta_title'/*id*/),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','meta Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXTAREA','meta_description','meta_description','8','meta_description form-control','meta_description'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','meta keywords :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','meta_keywords'/*name field*/,'meta_keywords'/*name post*/,'1000'/*size post*/,'form-control'/*class*/,'tags'/*id*/),
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

      $('.img_blog_file').on('change', function (e) {
        $('#img_blog_form').submit();
      });
      setImgPreview();
      $('#img_blog_form').on('submit', function (e) {
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
                $('#img').val(response);
                $('#blog_img_preview').attr('src','../files/blog/'+response);
            }
        });
      });
 
    });
    function setImgPreview(){
      var img = $('#img').val();
      if (img != "") {
        $('#blog_img_preview').attr('src','../files/blog/'+img);
      }
    }

  </script>
  <?php
//END EDIT USER
}


function PEDIT()
{
  $Post = array(
    array(_DB_PREFIX_.'blog_categories'),
    array('W'/*where*/,'id'/*field id*/,'ID'/*property id*/),
    array('title'/*name field*/,'title'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('permalink'/*name field*/,'permalink'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('description'/*name field*/,'description'/*name post*/,'text'/*type verification*/,'1000'/*size post*/),
    array('id_lang','id_lang','text','45','text'),
    array('parent','parent','text','45','text'),
    array('img'/*name field*/,'img'/*name post*/,'text'/*type verification*/,'255'/*size post*/),
     array('meta_title'/*name field*/,'meta_title'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('meta_description'/*name field*/,'meta_description'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('meta_keywords'/*name field*/,'tags'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
  );
  return $Post;
}


function DELETE($ID) {
  global $common;
  $common->delete('blog_categories', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=blog_categories"</script>';
}
?>