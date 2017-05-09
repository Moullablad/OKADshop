<?php if(isset($success) ) : ?>
    <div class="alert alert-success alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-check"></i>
        </div>
        <strong><?php echo $success; ?></strong> 
    </div>
<?php elseif( isset($info) ) : ?>
    <div class="alert alert-info alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-info-circle"></i>
        </div>
        <strong><?php echo $info; ?></strong> 
    </div>  
<?php elseif(isset($warning) ) : ?>
    <div class="alert alert-warning alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-warning"></i>
        </div>
        <strong><?php echo $warning; ?></strong> 
    </div>     
<?php elseif(isset($danger) ) : ?>
    <div class="alert alert-danger alert-white rounded" id="message">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
        <div class="icon">
            <i class="fa fa-times-circle"></i>
        </div>
        <strong><?php echo $danger; ?></strong> 
    </div>  
<?php endif; ?>