<section id="stringsFilter" class="bg-white">
  <form id="stringsForm" method="get" action="">
    <div class="form-group col-sm-3 left0">
      <select class="form-control" id="iso_code">
        <?php if( !empty($languages) ) : foreach ($languages as $key => $lang) : 
          $selected = (read_cookie('strings_trans_iso_code')==$lang->iso_code) ? 'selected' : '';
        ?>
            <option value="<?php echo $lang->iso_code; ?>" <?php echo $selected; ?>><?php echo $lang->name; ?></option>
        <?php endforeach; endif; ?>
      </select>
    </div>
    <div class="form-group col-sm-3 left0">
      <select class="form-control" id="groups">
        <option value=""><?php trans_e("Choose a group", "lang"); ?></option>
        <?php
        $groups = array(
          'core' => trans('Core', 'lang'),
          'themes' => trans('Themes', 'lang'),
          'modules' => trans('Modules', 'lang')
        );
        foreach ($groups as $group_id => $group_name) : 
        $selected = (read_cookie('strings_trans_groups')==$group_id) ? 'selected' : '';
        ?> 
          <option value="<?php echo $group_id; ?>" <?php echo $selected; ?>><?php echo $group_name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group col-sm-3 left0">
      <?php $location = read_cookie('strings_trans_locations'); ?>
      <select class="form-control" id="locations" <?php echo (!$location) ? 'disabled' : ''; ?>>
        <option value=""><?php trans_e("Choose a location", "lang"); ?></option>
        <?php if($group_id = read_cookie('strings_trans_groups')) : 
          foreach (get_locations($group_id) as $loc_id => $loc_name) : 
            $selected = ($location==$loc_id) ? 'selected' : '';
          ?>
          <option value="<?php echo $loc_id; ?>" <?php echo $selected; ?>><?php echo $loc_name; ?></option>
        <?php endforeach; endif; ?>
      </select>
    </div>
    <div class="form-group col-sm-3 left0 pr-0">
      <input autocomplete="off" class="form-control" id="keywords" placeholder="<?php trans_e("Keywords...", "lang"); ?>" type="text" value="<?php echo (read_cookie('strings_trans_groups')) ? read_cookie('strings_trans_keywords') : ''; ?>">
    </div>
  </form>
</section>

<table class="table table-striped table-bordered bg-white mt-10" id="stringsTable">
  <thead>
    <th><?php trans_e('Source Text', 'lang'); ?></th>
    <th><?php trans_e('Translation', 'lang'); ?></th>
  </thead>
  <tbody></tbody>
</table>