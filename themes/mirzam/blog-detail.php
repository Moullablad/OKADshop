<section class="banner bg-parallax" style=" ">
    <div class="overlay"></div>
    <div class="container">
        <div class="banner-content text-center">
            <h2 class="page-title"><?= $blog->title; ?></h2>
            <div class="breadcrumbs">
                <a href="<?= get_home_url(); ?>"><?php trans_e("Home", "mirzam"); ?></a>
                <a href="<?= get_home_url(); ?>blog"><?php trans_e("Blog", "mirzam"); ?></a>
                <span><?= $blog->title; ?></span>
            </div>
        </div>
    </div>
</section>

<div class="left-sidebar" id="main-container">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-md-9 main-content">
        <article class="blog-item">
           <h3><a href="#"><?= $blog->title; ?></a></h3>
           <div class="post-cat"><a href="#"><?= $blog_category->title; ?></a></div>
           <div class="meta-post">
              <div class="date-post"><span><?= $blog->cdate; ?></span>
           </div>
           <div class="content-post">
              <p><?= $blog->content; ?></p>
           </div>
           <div class="bottom-post product-share">
              <div class="groupshare product-share">
                <strong><?php trans_e("SHARE TO FRIENDS", "mirzam"); ?></strong>
                <?= get_chare_buttons(); ?>
              </div>
           </div>
        </article>

        </div><!-- /.col-md-9 -->
      <!-- Sliderbar -->
      <div class="col-sm-4 col-md-3 sidebar">
        <?php get_section('right_sidebar');?>
      </div><!-- ./Sidebar -->
    </div>
  </div>
</div>