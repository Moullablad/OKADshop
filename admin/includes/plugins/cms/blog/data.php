<?php
use Core\Form;
use Core\i18n\Language;
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
      array('TITLE','','','','<i class="fa fa-user"></i> Ajouter une article'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('users'),
      array('HIDDEN','module','50','module','module','blog'),
      array('HIDDEN','redirect','50','redirect','redirect','blog'),
      array('HIDDEN','mdir','50','mdir','mdir','cms'),
      array('DIVSTART','','form-horizontal inline-custom'),

      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Saisissez votre titre ici :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title','form-control','form-control','title','title','','title'),
      array('DIVEND'),

      //array('DIVSTART','','form-group col-sm-6 left0'),
       // array('LABEL','Description :'/*Text*/,'control-label'/*class*/,''/*ID*/),
       // array('TEXT','description','form-control','form-control','description','description','','description'),
      //array('DIVEND'),

       

      array('DIVSTART','','form-group clearfloat cms_description'),
       array('LABEL','Page contenu :'/*Text*/,'control-label'/*class*/,''/*ID*/),
       array('TEXTAREA','content','8','content summernote form-control','content',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
       array('LABEL','Mots-clés (Tags)'/*Text*/,'control-label'/*class*/,''/*ID*/),
       array('TEXT','tags','','form-control','tags','','','tags'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Catégorie de l\'article:'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_category','form-control','id_category',_DB_PREFIX_.'blog_categories','id','title'),
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

      array('DIVSTART','','form-group col-sm-12 left0'),
        array('LABEL','Permalink :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','permalink','','form-control','permalink','','',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','Preview :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TITLE','','','','<div id="seo-preview"><h3><a href="#" class="title">Your Title here</a></h3><h5 class="page-link">'.generate_url('blog/').'</h5><p class="page-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p></div>'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','image de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('HIDDEN','img_blog','form-control','form-control','img_blog','','','img_blog'),
        array('TITLE','','','','<form id="img_blog_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="file" name="image" id="filer_input" class="img_blog_file" accept="image/*">
        </form>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','cover de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('HIDDEN','cover_blog','form-control','form-control','cover_blog','','','cover_blog'),
        array('TITLE','','','','<form id="cover_blog_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/blog/cover/">
          <input type="file" name="image" id="filer_input" class="cover_blog_file" accept="image/*">
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
                $('#img_blog').val(response);
              }
        });
      });

      $('.cover_blog_file').on('change', function (e) {
        $('#cover_blog_form').submit();
      });
      $('#cover_blog_form').on('submit', function (e) {
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
                $('#cover_blog').val(response);
              }
        });
      });


      $(".seo-preview-refrech").keyup(function(){
        var meta_title = $('#meta_title').val();
        var meta_description = $('#meta_description').val();
        var page_link = "<?= generate_url('blog/'); ?>";
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
    array(_DB_PREFIX_.'blog'),
    array('title','title','text','255','text'),
    array('content','content','text','','text'),
    array('meta_title','meta_title','text','','text'),
    array('meta_description','meta_description','text','','text'),
    array('meta_keywords','meta_keywords','text','','text'),
    array('id_category','id_category','number','45','number'),
    array('id_lang','id_lang','number','45','number'),
    array('tags','tags','text','','text'),
    array('img_blog','img_blog','text','','text'),
    array('cover_blog','cover_blog','text','','text'),
    array('permalink','permalink','text','255','text')
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
  
  
  $post_link = generate_url('blog-detail/'.$ID);
  global $common;
  $perma = $common->select("blog",array("permalink"),"where id = ".$ID);
  if (isset($perma[0]['permalink'])) {
    $post_link .= "-" . $perma[0]['permalink'];
  }

  $languages = get_languages();
  $id_lang = Language::getLanguage()->id;
  $lang_list = '<select class="form-control" id="blog_languages">';
  foreach ($languages as $key => $value) {
    if ($id_lang == $value->id) {
      $lang_list .= "<option id=".$value->id." selected>".$value->name."</option>";
    }else{
      $lang_list .= "<option id=".$value->id.">".$value->name."</option>";
    }
  }
  $lang_list .="</select>";
  $form=array(
  array(_DB_PREFIX_.'blog'/*table*/,'id'/*id table*/,$ID),
  array('HIDDEN','test','test',50,'module','module','blog'),
  array('HIDDEN','test','test',50,'mdir','mdir','cms'),
  array('DIVSTART'/*first div*/,''/*class*/,'form-horizontal'/*id*/),

    array('DIVSTART','','col-sm-6 col-md-12 padding0'),
    array('DIVSTART','','panel panel-default'),
    array('DIVSTART','','panel-heading'),
      array('TITLE','','','','<i class="fa fa-pencil"></i> Edit page'),
      array('TITLE','','','','<div><i class="fa fa-eye" aria-hidden="true"></i> Voir l’article => <a target="_blanc" href="'.$post_link.'" >'.$post_link.'</a></div>'),
    array('DIVEND'),
    array('DIVSTART','','panel-body'),

      array('TITLE','','','','<div class="pull-right">'. $lang_list .'</div>'),
      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Title :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','title'/*name field*/,'title'/*name post*/,'100'/*size post*/,'form-control'/*class*/,'title'/*id*/),
      array('DIVEND'),
    

      array('DIVSTART','','form-group clearfloat cms_description'),
       array('LABEL','Article contenu :'/*Text*/,'control-label'/*class*/,''/*ID*/),
       array('TEXTAREA','content','content','12','content summernote form-control','content'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-12 left0'),
       array('LABEL','Mots-clés (Tags)'/*Text*/,'control-label'/*class*/,''/*ID*/),
       array('TEXT','tags'/*name field*/,'tags'/*name post*/,''/*size post*/,'form-control'/*class*/,'tags'/*id*/),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-6 left0'),
        array('LABEL','Catégorie de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('COMBO','id_category','id_category','form-control','id_category',_DB_PREFIX_.'blog_categories','id','title'),
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
        array('LABEL','Permalink'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','permalink','permalink','form-control','form-control','permalink','permalink',''),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','Preview :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TITLE','','','','<div id="seo-preview"><h3><a href="#" class="title">Your Title here</a></h3><h5 class="page-link">'.$post_link.'</h5><p class="page-desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p></div>'),
      array('DIVEND'),


      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','image de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','img_blog','img_blog','','form-control hidden','img_blog','',''),
        array('TITLE','','','','<form id="img_blog_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/blog/cover/">
          <input type="file" name="image" id="filer_input" class="img_blog_file" accept="image/*">
          <img src="" id="blog_img_preview"  style="width: 300px;height: 200px;"/>
        </form>'),
      array('DIVEND'),

      array('DIVSTART','','form-group col-sm-10 left0'),
        array('LABEL','cover de l\'article :'/*Text*/,'control-label'/*class*/,''/*ID*/),
        array('TEXT','cover_blog','cover_blog','','form-control hidden','cover_blog','',''),
        array('TITLE','','','','<form id="cover_blog_form" method="post" action="ajax/upload/ajax_upload_image.php" enctype="multipart/form-data">
          <input type="hidden" name="dir" value="../../../files/blog/cover/">
          <input type="file" name="image" id="filer_input" class="cover_blog_file" accept="image/*">
          <img src="" id="blog_cover_preview"  style="width: 300px;height: 200px;"/>
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
                $('#img_blog').val(response);
            }
        });
      });

      $('.cover_blog_file').on('change', function (e) {
        $('#cover_blog_form').submit();
      });
      setCoverPreview();
      $('#cover_blog_form').on('submit', function (e) {
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
                $('#cover_blog').val(response);
            }
        });
      });

       seo_preview_refrech();
      $(".seo-preview-refrech").keyup(function(){
        seo_preview_refrech();
      });


      //blog_languages change event
      $("#blog_languages").on('change',function(){
        var id_lang = $(this).children(":selected").attr("id");

      })

      

    });

    function setImgPreview(){
      var img = $('#img_blog').val();
      if (img != "") {
        $('#blog_img_preview').attr('src','../files/blog/'+img);
      }
    }
    function setCoverPreview(){
      var img = $('#cover_blog').val();
      if (img != "") {
        $('#blog_cover_preview').attr('src','../files/blog/cover/'+img);
      }
    }
    function seo_preview_refrech(){
      var meta_title = $('#meta_title').val();
      var meta_description = $('#meta_description').val();
      var page_link = "<?= $post_link; ?>";
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
    array(_DB_PREFIX_.'blog'),
    array('W'/*where*/,'id'/*field id*/,'ID'/*property id*/),
    array('title'/*name field*/,'title'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('permalink'/*name field*/,'permalink'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('tags'/*name field*/,'tags'/*name post*/,'text'/*type verification*/,''/*size post*/),
    array('meta_title'/*name field*/,'meta_title'/*name post*/,'text'/*type verification*/,'255'/*size post*/),
    array('meta_description'/*name field*/,'meta_description'/*name post*/,'text'/*type verification*/,'255'/*size post*/),
    array('meta_keywords'/*name field*/,'meta_keywords'/*name post*/,'text'/*type verification*/,''/*size post*/),
    array('content'/*name field*/,'content'/*name post*/,'text'/*type verification*/,'4000'/*size post*/),
    array('id_category','id_category','number','45','number'),
    array('id_lang','id_lang','number','45','number'),
    array('img_blog'/*name field*/,'img_blog'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
    array('cover_blog'/*name field*/,'cover_blog'/*name post*/,'text'/*type verification*/,'100'/*size post*/),
  );
  return $Post;
}


function DELETE($ID) {
  global $common;
  $common->delete('blog', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=blog"</script>';

}



?>

