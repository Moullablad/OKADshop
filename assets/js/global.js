$(document).ready(function() {

    var ajax_url = '../includes/ajax/';

	//facebook
	$('.facebook_chare').on('click', function(event){
		event.preventDefault();
		window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&amp;t=' + encodeURIComponent(document.URL));
		return false;
	});
	//twitter
	$('.twitter_chare').on('click', function(event){
		event.preventDefault();
		window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20'  + encodeURIComponent(document.URL));
		return false;
	});
	//Google+
	$('.googleplus_chare').on('click', function(event){
		event.preventDefault();
		window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL));
		return false;
	});
	//Mailto
	$('.mailto').on('click', function(event){
		event.preventDefault();
		window.open('mailto:?subject=' + encodeURIComponent(document.title) + '&amp;body=' +  encodeURIComponent(document.URL));
		return false;
	});


	

    //Bootstrap Alert Auto Close
    $(".dismiss").fadeTo(2000, 500).slideUp(500, function(){
        $(".dismiss").slideUp(500);
    });

//END DOCUMENT
});





//===================
//===================
//
//
//
// Functions
//
//
//
//===================
//===================


/**
 * get declainaison data
 * @param json
 * json array WITH key AS id_attribute AND value AS id_value
 * @return object array
 **/
function ajax_get_combinations(json, handle_data){
	// Exit if empty json
	if( json == "" ) return false;

	// Fire off the request to /form.php
    request = $.ajax({
        url: site_url("includes/ajax/product/combination.php"),
        type: "post",
        data: {
        	attributes:json,
        	id_product: $('#idProduct').val()
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
    	try {
    		//console.log($.parseJSON(response))
    		//check if response is json
      		handle_data( $.parseJSON(response) );//$.parseJSON
	    }catch (e) {
	    	var message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><br> <i class='fa fa-terminal'></i> See the JavaScript console for technical details.<br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
            error_message(message);
            console.error(jqXHR.responseText);// Log the error to the console
	    }
    });
    // Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		var message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><br> <i class='fa fa-terminal'></i> See the JavaScript console for technical details.<br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
        error_message(message);
        console.error(jqXHR.responseText);// Log the error to the console
	});

    // Prevent default posting of form
    event.preventDefault();
}


/**
 * MESSAGE NOTIF
 * @param message string
 * @param type string
 * @param delay int
 * @param width int
 * @param align string
 **/
function message_notif(message, params={}){

  var default_params = {
    type : "success", 
    delay: 4000, 
    width: "100%", 
    align: "center"
  };

  //merging two objects into new object
  var args = $.extend({}, default_params, params);

  $.bootstrapGrowl(message, {
    ele: 'body', // which element to append to
    type: args.type, // (null, 'info', 'danger', 'success')
    offset: {from: 'top', amount: 20}, // 'top', or 'bottom'
    align: args.align, // ('left', 'right', or 'center')
    width: args.width, // (integer, or 'auto')
    delay: args.delay, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
    allow_dismiss: true, // If true then will display a cross to close the popup.
    stackup_spacing: 10 // spacing between consecutively stacked growls.
  });
}


/**
 * ERROR MESSAGE
 **/
function error_message(message=''){
    if( message == '' ) {
        message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
    }
    message_notif(message, {type : "danger", align : "right", width : "450", delay : 3600});
}



/**
 * get file name
 * @param file string
 * @return name string
 **/
function get_file_name(file, size=null){
  var index = file.lastIndexOf("/") + 1;
  return file.substr(index);
}

/**
 * get file extention
 * @param file_name string
 * @return extention string
 **/
function get_extention(file_name){
	return file_name.split('.').pop();
}


//get product cover
function get_cover(img_src, old_size='200x200',new_size = '76x76'){
  if( img_src != undefined ){
    var extention = get_extention( img_src );
    return img_src.replace('-'+ old_size + '.' +extention, '-'+new_size +'.'+extention);
  }
  return 'assets/img/defaults/76x76.png';
}




/**
 * GET LOADING GIF IMAGE
 * @return src string
 **/
function get_loading_gif_uri(){
  return '../assets/img/icons/loading.gif';//site_url('assets/img/icons/loading.gif');
}

/**
 * GET PRODUCT PRICE WITH CURRENCY
 * @param float price
 * @param string currency
 * @return string price
 **/
function with_currency(price, currency='$'){
  return price +' '+ currency ;
}


function get_currency(){
  return "$";
}


/**
 * GET HOME URL
 * @return url string
 **/
function generate_url(path=null){
  var bases = document.getElementsByTagName('base');
  var iso_code = document.documentElement.lang;

  if ( bases.length < 0 )
    return location.origin;

  if( path == null )
    return bases[0].href;

  var baseHref = null;
  if (bases.length > 0) {
      baseHref = bases[0].href + iso_code + '/' + path;
  }
  return baseHref;
}

/**
 * GET URL
 * @return url string
 **/
function site_url(path=''){
    var bases = document.getElementsByTagName('base');
    var baseHref = null;
    if (bases.length > 0) {
        baseHref = bases[0].href + path;
    } else if( $('[rel="website"]').length > 0 ) {
      baseHref = $('[rel="website"]').prop('href') + path;
    } else {
      baseHref = path;
    }
    return baseHref;
}

/**
 * Tell if current page is homepage
 *
 * @return bool
 **/
function is_home() {
  if( location.pathname == '/' ) {
    var home_url = location.href;
  } else {
    var iso_code = document.documentElement.lang;
    var url = location.href;
    url = url.replace(/\/$/, "");
    var home_url = url.replace(iso_code, '');
  }  
  return site_url() == home_url;
}






/**
 * Get admin directory
 * @return dir string
 **/
function admin_dirname(path=''){
  var url = location.pathname.replace('index.php','');
  return url + path;
  //return location.origin + location.pathname.replace('index.php','');
}





/**
 * SUBMIT FORM BY AJAX
 * @return url string
 **/
function ajax_form(form_id, handle_data){
  //check form id
  if($("form#" + form_id).length == 0) {
    alert("Form ID doesn't exist.");
  }

  // get the data in the form
  var $form = $('#'+form_id);
  var form_data = new FormData($form[0]);

  // Let's select and cache all the fields
  var $inputs = $form.find("input, select, button, textarea").not(":disabled");

  // Let's disable the inputs for the duration of the Ajax request.
  // Disabled form elements will not be serialized.
  $inputs.prop("disabled", true);

  // Fire off the request
  $.ajax({
    url: $form.attr('action'),
    type: $form.attr('method'),
    data: form_data,
    cache: false,
    contentType: false,
    processData: false
  })
  // Callback handler that will be called on success
  .done(function(response, textStatus, jqXHR, errorThrown) {
    try {
      //check if response is json
      handle_data( JSON.parse(response) );
    }catch (e) {
        var message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><br> <i class='fa fa-terminal'></i> See the JavaScript console for technical details.<br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
        error_message(message);
        console.error(jqXHR.responseText);
    }
  })
  // Callback handler that will be called on failure
  .fail(function (jqXHR, textStatus, errorThrown){
        var message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><br> <i class='fa fa-terminal'></i> See the JavaScript console for technical details.<br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
        error_message(message);
        console.error(jqXHR.responseText);
  })
  // Callback handler that will be called regardless if the request failed or succeeded
  .always(function () {
    // Reenable the inputs
    $inputs.prop("disabled", false);
  });

  return false;
}


/**
 * OKADshop AJAX
 *
 * @param request_url string
 * @param ajax_data json object
 * @param method post, get...
 * @param handle_data callback
 **/
function ajax_handler(ajax_url, ajax_data={}, ajax_type, handle_data){
    // Fire off the request to request_url
    request = $.ajax({
        url: ajax_url,
        type: ajax_type,
        data: ajax_data//JSON.stringify(ajax_data)
    });
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        try {
            //check if response is json
            handle_data( $.parseJSON(response) );
        }catch (e) {
            var message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><br> <i class='fa fa-terminal'></i> See the JavaScript console for technical details.<br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
            error_message(message);
            console.error(jqXHR.responseText);
        }
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        var message = trans("<b><i class='fa fa-meh-o'></i> Oops! Something went wrong.</b><br><br> <i class='fa fa-terminal'></i> See the JavaScript console for technical details.<br><i class='fa fa-refresh'></i> Please reload page and try again.", "core");
        error_message(message);
        console.error(jqXHR.responseText);// Log the error to the console
    });
}


/**
 * OKADshop AJAX
 *
 * @param string action Action name
 * @param object data
 * @param stirng ajax_type POST|GET
 * @param handle_data callback
 */
function okad_ajax(action, data={}, ajax_type, handle_data){
  var ajax_url = site_url('includes/ajax.php');
  data['action'] = action;
  ajax_handler(ajax_url, data, ajax_type, function(response){
    handle_data(response);
  });
}


/**
 * Update Multi Lang Fields
 * Change fields values after changing language
 *
 * @param object fields
 *
 * @return void
 */
function updateMultiLangFields(fields) {
  $.each(fields, function(id_field, value){
    var field = $('#'+id_field);
    var id_lang = $('select#languages option:selected').val();
    if( field.hasClass('active') ) {
      field.bootstrapSwitch('state', value);
    } else if( field.hasClass('tags') ) {
      field.tagsinput('destroy')
      field.val(value);
      field.tagsinput()
    } else if( field.is('select') ) {
      field.find('option[value="'+value+'"]').prop('selected', 'true')
    } else {
      field.val(value);
    }
    $('.current_id_lang').val(id_lang);
  });
}



/**
 *
 * Translate string
 *
 * @param msgid string
 * @param domain string
 **/
function trans(msgid, domain){
  return msgid;
}


/**
 * Get url parameter
 *
 * @param $name string
 * @return $params string
 **/
function get_url_param(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
        return null;
    }else{
        return results[1] || 0;
    }
}

/**
 * Change url parameter
 *
 * @param param string
 * @param value string
 * @return void
 */
function change_url_param(param, value) {
  var url = window.location.href;
  var reExp = new RegExp("[\?|\&]"+param + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");
  if(reExp.test(url)) { // update
    var reExp = new RegExp("[\?&]" + param + "=([^&#]*)");
    var delimiter = reExp.exec(url)[0].charAt(0);
    url = url.replace(reExp, delimiter + param + "=" + value);
  } else { // add
    var newParam = param + "=" + value;
    if(!url.indexOf('?')){
      url += '?';
    }
    if(url.indexOf('#') > -1){
      var urlparts = url.split('#');
      url = urlparts[0] +  "&" + newParam +  (urlparts[1] ?  "#" +urlparts[1] : '');
    } else {
      url += "&" + newParam;
    }
  }
  window.history.pushState(null, document.title, url);
}



/**
 * Generate random string
 *
 * @param length int
 * @return string
 */
function get_random_string(length)
{
  var string = "";
  var possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  for( var i=0; i < length; i++ ){
    string += possible.charAt(Math.floor(Math.random() * possible.length));
  }
  return string;
}


/**
 * Initialize plugins
 *
 * @return void
 */
function intialize_plugins(){
    //summernote editor
    if ( $('.summernote').length > 0 ){
        $('.summernote').summernote({
            height: 100,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
    } 
    //input date time
    if ( $('.datetime').length > 0 ) $('.datetime').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    if ( $('.date').length > 0 ) $('.date').datetimepicker({format: 'YYYY-MM-DD'});
    //jQuery Filer
    if ( $('.attachments').length > 0 ){
        $('.attachments').filer({
          showThumbs: false,
          addMore: false,
          maxSize: 8,
          extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt']
        });
    }
    //Bootstrap Switch
    if( $('input.switch').length > 0 ){
        $("input.switch").bootstrapSwitch({onColor:'success','offColor':'danger'});
    }
    if( $('input.active').length > 0 ){
        $("input.active").bootstrapSwitch({onColor:'success','offColor':'danger'});
    }

    


    //jQuery Sortable
    if( $('.sortable').length > 0 ) $(".sortable").sortable();
    //Bootstrap chosen
    if( $('.chosen').length > 0 ) $(".chosen").chosen({no_results_text: trans("Oops, noting found!", "core")});

    //Check if tab require languages
    /*if( $('.id_lang').length < 1 ){
      $('#languages').hide();//.prop("disabled", true);
    } else {
      $('#languages').show();//.prop("disabled", false);
    }*/

    //Bootstrap datatable
    if( $('.datatable').length > 0 ){
      $('.datatable').DataTable();
        /*$('.datatable').DataTable({
            "order": [],
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Arabic.json"
            }
        });*/
    }


  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', '.file-upload input[type="file"]', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
    $('.file-upload input[type="file"]').on('fileselect', function(event, numFiles, label) {
      var input = $(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;
      if( input.length ) {
          input.val(log);
      } else {
          if( log ) alert(log);
      }
    });
  });


  //Bootstrap Colorpicker
  if( $('.colorpicker').length > 0 ){
    $('.colorpicker').colorpicker();
  }


  if( $('#meta_keywords').length > 0 ){
    $("#meta_keywords").tagsinput();
  }


}

var popup_target = '';
function confirmMessage() {
  if( event.which ) {
    event.preventDefault();
    popup_target = event.target;
    $.magnificPopup.close();
    jQuery.magnificPopup.open({
        tLoading: 'Loading...',
        type: 'ajax',
        items:{
          src: site_url('includes/ajax/popup/confirm-message.php')
        }
    });
  } 
}


function createCookie(name,value,days=365,path='') {
  if( path == '' ){
    var url  = site_url();
    var path = url.replace(location.origin, '');
  }
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path="+path;
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name,"",-1);
}