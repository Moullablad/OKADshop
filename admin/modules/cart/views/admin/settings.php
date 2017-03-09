<style>
    .cart_label{
        border: 0px;
        width: 100%;
        height: 1.5em;
    }
</style>
<form method="POST" action="" id="labelForm">
    <div class="form-group col-lg-3 col-lg-offset-3 left0">
        <input type="hidden" name="slug" id="slug" value="">
        <input type="text" name="name" id="name" class="form-control" autofocus value="" placeholder="<?php trans_e("Label name.", "cart"); ?>" required>
    </div>
    <div class="form-group col-lg-2 left0">
        <select name="iso_code" class="form-control" id="langs">
            <?php foreach (get_languages() as $key => $lang) : 
                $selected = ($iso_code==$lang->iso_code) ? 'selected' : '';
            ?>
                <option value="<?=$lang->iso_code;?>" data-id="<?=$lang->id;?>" <?=$selected;?>><?=$lang->name;?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-lg-1 left0">
        <button type="submit" name="save" class="btn btn-primary btn-block"><?php trans_e("Save", "cart"); ?></button>
    </div>
</form>

<div class="col-lg-6 col-lg-offset-3 left0">
    <br>
    <?php if( !empty($labels) ) : ?>
    <form method="POST" action="">
    <table class="table" id="labels">
        <thead>
            <tr>
                <th align="left">Name</th>
                <th align="left">Languages</th>
                <th class="text-center">Default</th>
                <th width="170">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($labels as $slug => $label) : ?>
                <tr data-slug="<?=$slug;?>">
                    <td class="name">
                    <?php 
                    if( isset($label[$iso_code]) ){
                        $name = $label[$iso_code];
                    } else {
                        reset($label);
                        $iso_code = key($label);
                        $name = $label[$iso_code];
                    }
                    echo $name;?></td>
                    <td>
                        <?php $langs = array_keys($label); foreach ($langs as $key => $lang) : ?>
                            <span class="label label-default"><?=strtoupper ($lang);?></span>
                        <?php endforeach;?>
                    </td>
                    <td align="center">
                        <input class="cart_label" name="default" type="radio" value="" <?=($default==$slug) ? 'checked' : '';?>>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary edit_label"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "cart"); ?></button>
                        <button type="submit" name="delete" value="<?=$slug;?>" class="btn btn-default" onclick="return confirm('<?php trans_e("Are you sure?", "cart"); ?>')"><i class="fa fa-trash"></i> <?php trans_e("Delete", "cart"); ?></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </form>
    <?php else : ?>
        <strong>No label found</strong>
    <?php endif; ?>
</div>