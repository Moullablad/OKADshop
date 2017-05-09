<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image"><img alt="User Image" class="img-circle" src="<?=site_url('assets/img/icons/okadshop.png');?>"></div>
      <div class="pull-left info">
        <p><?php echo get_admin('first_name') . " ". get_admin('last_name'); ?></p>
        <p style="text-transform: uppercase;    margin-bottom: 0px;"><?php echo get_admin('user_type');?></p>
      </div>
    </div><!-- search form -->
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" id="os_admin_menu">
    <?php 
      global $os_admin_menu;
      echo print_menu_items($os_admin_menu);
    ?>
    </ul>

  </section><!-- /.sidebar -->
</aside>

<!-- Contents -->
<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="main-content">
    <!-- Main content -->
    <section class="content">