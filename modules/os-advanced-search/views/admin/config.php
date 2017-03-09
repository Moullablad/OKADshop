<style type="text/css">
  .action-btn button{
    background: none;
    border: 0;
  }
  .action-btn button .fa-trash {
    color: red;
  }
</style>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-cogs"></i> <?= trans("Configure", "advanced_search");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
  <div class="panel-heading"><?= trans("Advanced Search Configuration", "advanced_search");?></div>
  <div class="panel-body">

    <h5><?= trans("Add product attribute to filter list", "advanced_search");?></h5>
    <form class="form-horizontal" action="" method="post">
      <div class="form-group">
        <label for="attribute" class="col-sm-2 control-label"><?= trans("Chose attribute", "advanced_search");?></label>
        <div class="col-sm-4">
          <?php if (isset($attributes) && !is_empty($attributes)): ?>
            <select class="form-control" id="attribute" name="attribute">
              <?php foreach ($attributes as $key => $value): ?>
                <option value="<?= $value->id; ?>"><?= $value->name; ?></option>
              <?php endforeach ?>
            </select>
          <?php endif ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" name="submit" class="btn btn-primary"><?= trans("Add", "advanced_search"); ?></button>
        </div>
      </div>
    </form>
    
    
    <table class="table">
      <tr>
        <th>#</th>
        <th><?= trans("Attribute name","advanced_search");?></th>
        <th><?= trans("Actions","advanced_search");?></th>
      </tr>
      <?php if (isset($attribute_list) && !is_empty($attribute_list)): ?>
        <?php foreach ($attribute_list as $key => $value): ?>
          <tr>
            <td><?= $value->id; ?></td>
            <td><?= $value->name; ?></td>
            <td class="action-btn">
              <form action="" method="post">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $value->id; ?>">
                <button type="submit" name="submit"  onclick="return confirm('confirmé');"><i class="fa fa-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
      
    </table>
 

  </div><!--/ .panel-body -->
</div>

 <script type="text/javascript">
  /* $(document).ready(function(){
      $('.submit-delte').click(function{
        return confirm('Confirmé');
      });
   });*/
 </script>