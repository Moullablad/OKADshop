<form method="POST" action="" id="metaForm">
    <input type="hidden" name="meta_id" id="meta_id" value="">
    <div class="form-group col-lg-3 col-lg-offset-1 left0">
        <input type="text" name="type" id="meta_type" class="form-control" value="" placeholder="<?php trans_e("Type (name, property, http-equiv, charset...)", "seo"); ?>" required>
    </div>
    <div class="form-group col-lg-3 left0">
        <input type="text" name="property" id="meta_property" class="form-control" autofocus value="" placeholder="<?php trans_e("Property", "seo"); ?>" required>
    </div>
    <div class="form-group col-lg-3 left0">
        <input type="text" name="content" id="meta_content" class="form-control" value="" placeholder="<?php trans_e("Content", "seo"); ?>">
    </div>
    <div class="form-group col-lg-1 left0">
        <button type="submit" name="save" class="btn btn-primary btn-block"><?php trans_e("Save", "seo"); ?></button>
    </div>
</form>

<div class="col-lg-10 col-lg-offset-1 left0 meta_preview">
    <pre>&lt;<b>meta</b> <b id="view_type">name</b>="<span id="view_property">property</span>"<span id="show_content"><b> content</b>="<span id="view_content"></span>"</span>&gt;</pre><br>
</div>

<div class="col-lg-10 col-lg-offset-1 left0">
    <?php //get_view(__FILE__, 'alerts', array('info' => trans('No meta tags found', 'seo'))); ?>
    <?php if( !empty($metas) ) : ?>
    <form method="POST" action="">
    <table class="table table-bordered datatable" id="metas">
        <thead>
            <tr>
                <th align="left">Type</th>
                <th align="left">Property</th>
                <th align="left">Content</th>
                <th width="128">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metas as $property => $meta) : ?>
                <tr data-id="<?=$meta['id'];?>">
                    <td class="mtype"><?=$meta['type'];?></td>
                    <td class="mproperty"><?=$property;?></td>
                    <td class="mcontent"><?=$meta['content'];?></td>
                    <td>
                        <?php if( !isset($defaultMetas[$property]) ) : ?>
                            <button type="button" class="btn btn-primary edit_meta"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "seo"); ?></button>
                            <button type="submit" name="delete" value="<?=$meta['id'];?>" class="btn btn-default" onclick="return confirm('<?php trans_e("Are you sure?", "seo"); ?>')"><i class="fa fa-trash"></i> <?php trans_e("Delete", "seo"); ?></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </form>
    <?php else : ?>
        <?php get_view(__FILE__, 'alerts', array('info' => trans('No meta tags found', 'seo'))); ?>
    <?php endif; ?>
</div>