<!DOCTYPE html>
<html dir="<?=get_lang('direction');?>" lang="<?=get_lang('iso_code');?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?= os_head(); ?>
</head>
<body>

    <section id="top-banner">
        <?php get_section('top_banner'); ?>
    </section>

    <section id="top-nav">
      <div class="container">
        <div class="row">
              <div class="col-xs-12 col-sm-6 mb-xs-10">
                  <?php get_section('top_left'); ?>
              </div><!-- /.col-sm-6 -->
              <div class="col-xs-12 col-sm-6">
                  <div class="pull-right">
                    <?php get_section('top_right'); ?>
                  </div>
              </div><!-- /.col-sm-6 -->
          </div>
      </div>
    </section>
    
    <section id="header_top">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-4 mb-xs-20">
            <div id="logo">
              <a href="<?=get_home_url();?>"><img src="<?=get_logo();?>"  alt="logo" height="46" /></a>
            </div>
          </div>
          <div class="col-md-5 col-sm-8">
            <div class="search-form">
              <form class="form-horizontal" id="searchbox" action="<?=get_home_url();?>search" method="post">
                <div class="input-group pull-right-lg">
                 <input type="text" name="search_query" class="form-control" placeholder="<?php trans_e('Search your query here...', 'mirzam'); ?>" value="<?=(isset($_POST['search_query'])) ? htmlentities($_POST['search_query']) : '';?>">
                 <span class="input-group-btn">
                      <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i>
                      </button>
                 </span>
                </div>
              </form>
            </div>
          </div>
            <div class="col-md-4 col-sm-12">
                <div class="pull-right">
                  <?php get_section('header'); ?>
                </div>
            </div>
        </div>
      </div>
    </section>
    

    <section id="main-nav">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <nav class="navbar main-menu" id="main_nav">
                        <div class="container">
                          <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only"><?php trans_e('Toggle navigation', 'mirzam'); ?></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                          </div>
                          <div class="collapse navbar-collapse" id="navbar-collapse-1">
                            <?php get_section('top_nav'); ?>
                          </div><!-- /.navbar-collapse -->
                        </div><!-- /.container -->
                    </nav>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <?php get_section('contact_info'); ?>
                    <ul class="nav pull-right" id="client-info">
                        <li><a href="<?= generate_url('contact') ?>"><i class="fa fa-envelope"></i> <?= get_shop("email"); ?></a></li>
                        <li><a href="<?= generate_url('contact') ?>"><i class="fa fa-phone"></i> <?= get_shop("phone"); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>        
    </section>

    <div id="site-wrapper">