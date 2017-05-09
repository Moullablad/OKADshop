$(document).ready(function() {

	//var ajax_url = admin_dirname() + 'includes/ajax/tabs/';

  $('select#languages').change(function(){
    var id_lang = $(this).val();
    createCookie('tabs_selected_lang', id_lang);
  });



	 /**
     * Load Tab Contents
     *
     */
    $('.ajaxTab a').click(function(event){
      event.preventDefault();
      var tab = $(this).data('tab');
      if( tab != undefined ) {
        var tab_loc = $(this).closest('ul').data('location');
        if( $(this).data('lang') == 'yes' ){
          $('#languages').show();
        } else {
          $('#languages').hide();
        }
        ajax_get_tab_content(tab, tab_loc);
        set_active_tab(tab);
      }
    });

    // Set active tab
    $('#os-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if( $(e.target).data('ajax') == 'no' ){
          set_active_tab($(e.target).data('tab'));
        }
        if( $(e.target).data('lang') == 'yes' ){
          $('#languages').show();
        } else {
          $('#languages').hide();
        }
    });

    
    var data_ajax = $('#os-tabs a[data-toggle="tab"]').data('ajax');
    if( data_ajax == 'no' ){
      var tab_param = get_url_param('tab');
      if( tab_param != null && tab_param != undefined ){
        set_active_tab(tab_param);
      } else {
        var tab_loc = $('#os-tabs ul').data('tab_loc') + "_active_tab";
        var active_tab = readCookie(tab_loc);
        if( active_tab != null ){
          set_active_tab(active_tab);
        } else {
          set_active_tab();
        }
      }
    }

    //show or hide language selectbox
    if( $('#os-tabs li.active a[data-toggle="tab"]').data('lang') == 'yes' ){
      $('#languages').show();
    } else {
      $('#languages').hide();
    }

    //Initialize external plugins
    intialize_plugins();


//END DOCUMENT
});


//set active tab
function set_active_tab(active_tab=null){

    var nav_tabs = $('#os-tabs .nav-tabs');
    if( active_tab == null ){
      active_tab = $(nav_tabs).find('a').data('tab');
    }
    $(nav_tabs).find('li.active').removeClass('active');
    $(nav_tabs).find('a[data-tab="'+active_tab+'"]')
      .closest('li').addClass('active');

    change_url_param('tab', active_tab);

    var tab_loc = $('#os-tabs ul').data('location') + "_active_tab";
    createCookie(tab_loc, active_tab);

    $('#os-tab-contents .panel').removeClass('in active');
    $('#os-tab-contents div#'+active_tab).addClass('in active');
}



/**
 *
 * Get Tab content
 *
 * @return void
 **/
function ajax_get_tab_content(tab, location){
  var ajax_url = admin_dirname() + 'modules/tabs/includes/ajax/';
  var loading = $('<img src="'+ get_loading_gif_uri() +'" class="loader">');
  $('#os-tab-contents').empty().append(loading);
  $('.nav-tabs li').removeClass('active');
  $('.nav-tabs a[data-tab="'+tab+'"]').closest('li').addClass('active');
  request = $.ajax({
      url: ajax_url +'content.php',
      type: "post",
      data: {
          active_tab: tab, 
          location: location,
          group: $('.os-tab-container').data('group')
      }
  });
  request.done(function (content, textStatus, jqXHR){
      if( content != '' ){
          $('#os-tab-contents').empty().html(content);
      } else {
          var message = $('<div class="alert alert-warning alert-white rounded" id="message">\
              <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>\
              <div class="icon">\
                  <i class="fa fa-warning"></i>\
              </div>\
              <strong>'+ trans("No data found for this tab.", "core") +'</strong>\
          </div>');
          $('#os-tab-contents').empty().html(message);
      }
      change_url_param('tab', tab);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
      var message = $('<div class="alert alert-warning alert-white rounded" id="message">\
          <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>\
          <div class="icon">\
              <i class="fa fa-warning"></i>\
          </div>\
          <strong>'+ trans("The following error occurred:", "core") +' '+ textStatus, errorThrown +'</strong>\
      </div>');
      $('#os-tab-contents .panel-body').empty().html(message);
  });
  request.always(function () {
      intialize_plugins();
  });
  return false;
}