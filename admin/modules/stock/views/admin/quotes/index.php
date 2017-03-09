<?php
/**
 * 2016 - 2017 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 - 2017 OKADshop
 */
?>
<div class="table-responsive">
<table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
    <thead>
        <tr>
            <td><?php trans_e("ID", "stk"); ?></th>
            <td><?php trans_e("Reference", "stk"); ?></th>
            <td><?php trans_e("Customer", "stk"); ?></th>
            <td><?php trans_e("Created", "stk"); ?></th>
            <td width="80"><?php trans_e("Actions", "stk"); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php if( !is_empty($quotes) ) : foreach ($quotes as $key => $quote) : ?>
        <tr>
            <td width="10"><?= $quote->id; ?></td>
            <td><?= $quote->customer; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <div class="btn-group-action">
                    <div class="btn-group pull-right">
                        <a class="edit btn btn-default" href="<?=get_page_url('quotes&action=edit&id='. $quote->id, __FILE__); ?>" title="<?php trans_e("Edit", "stk"); ?>"><i class="fa fa-pencil"></i> <?php trans_e("Edit", "stk"); ?></a>
                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i>&nbsp;</button>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                            <li>
                                <a class="deleteAction" href="<?=get_page_url('quotes&action=delete&id='. $quote->id, __FILE__); ?>" title="<?php trans_e("Delete", "stk"); ?>"><i class="fa fa-trash"></i> <?php trans_e("Delete", "stk"); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
</div>