<?php
$Args = array(
	'Select' => array(
		'id'=> _DB_PREFIX_.'blog.id',
		'title'=> _DB_PREFIX_.'blog.title',
		'category'=> _DB_PREFIX_.'blog_categories.title',
		'lang'=> _DB_PREFIX_.'langs.name'
	),
	'From' => array( _DB_PREFIX_.'blog'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'blog.id_lang', _DB_PREFIX_.'langs.id'),
		array( _DB_PREFIX_.'blog_categories', _DB_PREFIX_.'blog.id_category', _DB_PREFIX_.'blog_categories.id','left')
	),
	'Module'=> array('blog','Gestion de blog'),
	'Operations' => array('edit','delete','frontview'),
	'THead' => array('ID','Title','Category','language','Operations'),
	'Butons' =>	array(
		array('Ajouter une page','?module=blog&action=add','add_nw','add button','Ajouter une page','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);


$db = Core\Database\Database::getInstance();

//update blog_style
if (isset($_POST['submit']) && isset($_POST['blog_style'])) {
	$db->query("UPDATE "._DB_PREFIX_."blog_settings SET value = '$_POST[blog_style]' WHERE name = 'blog_style'");
}

//get blog style
$res = $db->query("SELECT * FROM "._DB_PREFIX_."blog_settings WHERE name = 'blog_style'",true);
$blog_style = $res->value;

?>


<div class="panel panel-default">
  <div class="panel-body">
    <form class="form-horizontal" method="post" action="">
		<fieldset>

			<!-- Form Name -->
			<legend>Configuration de style du blog</legend>

			<!-- Multiple Radios -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="radios">Style du blog</label>
			  <div class="col-md-4">
			  	<div class="radio">
				    <label for="radios-list">
				      <input type="radio" name="blog_style" id="radios-list" value="list"
				       <?php if($blog_style == "list") echo 'checked="checked"'; ?>>
				      BLOG LIST
				    </label>
				</div>
			  	<div class="radio">
				    <label for="radios-2columns">
				      <input type="radio" name="blog_style" id="radios-2columns" 
				      <?php if($blog_style == "2columns") echo 'checked="checked"'; ?> value="2columns">
				      BLOG GRID 2 COLUMNS
				    </label>
				</div>
				<div class="radio">
				    <label for="radios-3columns">
				      <input type="radio" name="blog_style" id="radios-3columns" 
				      <?php if($blog_style == "3columns") echo 'checked="checked"'; ?> value="3columns">
				      BLOG GRID 3 COLUMNS
				    </label>
				</div>
				<div class="radio">
				    <label for="radios-mansonry">
				      <input type="radio" name="blog_style" id="radios-mansonry" 
				      <?php if($blog_style == "mansonry") echo 'checked="checked"'; ?> value="mansonry">
				      BLOG MASONRY
				    </label>
				</div>
			  </div>
			</div>

			<!-- Button -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="singlebutton">Enregistrer</label>
			  <div class="col-md-4">
			  	<input type="submit" name="submit" class="btn btn-primary" value="Enregistrer">
			  </div>
			</div>

		</fieldset>
	</form>
  </div>
</div>




