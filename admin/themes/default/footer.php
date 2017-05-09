  </section><!--/ .content  -->
  </aside><!-- /.main-content -->
  <footer class="footer hidden">
    <div class="slide">
      <p class="text-muted">Copyright &copy; Soft Hight Tech, 2016</p>
    </div>
  </footer>
  <?=os_footer();?>
  <script>
  $(document).ready(function(){
    var url = window.location.href;
    var page = url.split("?").pop();
    if(url.indexOf("?") > -1) {
      var $current = $('#os_admin_menu a[href$="'+page+'"]');
      $current.addClass('active');
      if ( url.indexOf("&slug=") >= 0 ){
        var module_name = url.split("&slug=").pop().split("&").shift();
        $('#os_admin_menu a[href*="slug='+module_name+'"]')
          .closest('#os_admin_menu>.dropdown-submenu')
          .addClass('active');
      }else{
        var current_m = url.split("?").pop().split("&").shift();
        $current.closest('#os_admin_menu>.dropdown-submenu').addClass('active');
      }
    }else{
      $('#os_admin_menu a[href*="./index.php"]').addClass('active');
    }

    //datatable lang
    $('#datatable').DataTable({
      "order": [],
      "iDisplayLength": 15,
      "aLengthMenu": [[15, 50, 100, 200, 300, -1], [15, 50, 100, 200, 300, "All"]],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/<?=(!empty($_SESSION['dt_lang']) ? $_SESSION['dt_lang'] : 'French');?>.json"
      }
    });


    
  });
  </script>

  
</body>
</html>