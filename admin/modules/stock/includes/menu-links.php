<?php
/**
 * add menu links
 *
 */
global $os_admin_menu;
$stk = $os_admin_menu->add( trans('Stock Manager', 'stk'), get_page_url('statistics', __FILE__));
$stk->link->prepend('<span class="fa fa-archive"></span>');
$stk->add( trans('Statistics', 'stk'), get_page_url('statistics', __FILE__));

$invoices = $stk->add( trans('Invoices', 'stk'), get_page_url('invoices', __FILE__));
$invoices->add( trans('Invoices', 'stk'), get_page_url('invoices', __FILE__));
$invoices->add( trans('Create Invoice', 'stk'), get_page_url('invoices&action=add', __FILE__));

$quotes = $stk->add( trans('Quotes', 'stk'), get_page_url('quotes', __FILE__));
$quotes->add( trans('Quotes', 'stk'), get_page_url('quotes', __FILE__));
$quotes->add( trans('Create Quotes', 'stk'), get_page_url('quotes&action=add', __FILE__));

// $companies = $stk->add( trans('Companies', 'stk'), get_page_url('companies', __FILE__));
// $companies->add( trans('Companies', 'stk'), get_page_url('companies', __FILE__));
// $companies->add( trans('Create Company', 'stk'), get_page_url('companies&action=add', __FILE__));

$payments = $stk->add( trans('Payments', 'stk'), get_page_url('payments', __FILE__));
$payments->add( trans('Payments', 'stk'), get_page_url('payments', __FILE__));
$payments->add( trans('Add Payments', 'stk'), get_page_url('payments&action=add', __FILE__));
$payments->add( trans('Payment Methods', 'stk'), get_page_url('payments?action=methods', __FILE__));
$payments->add( trans('Add Method', 'stk'), get_page_url('payment?action=add_method', __FILE__));

$companies = $stk->add( trans('Customers', 'stk'), get_page_url('customers', __FILE__));
$companies->add( trans('Customers', 'stk'), get_page_url('customers', __FILE__));
$companies->add( trans('Add Customer', 'stk'), get_page_url('customers&action=add', __FILE__));

$products = $stk->add( trans('Products', 'stk'), get_page_url('products', __FILE__));
$products->add( trans('Products', 'stk'), get_page_url('products', __FILE__));
$products->add( trans('Add Product', 'stk'), get_page_url('products&action=add', __FILE__));
$products->add( trans('Vendors', 'stk'), get_page_url('vendors', __FILE__));
$products->add( trans('Add Vendor', 'stk'), get_page_url('vendors&action=add', __FILE__));

$companies = $stk->add( trans('Settings', 'stk'), get_page_url('settings', __FILE__));
$companies->add( trans('Settings', 'stk'), get_page_url('settings', __FILE__));
$companies->add( trans('Tax Rates', 'stk'), get_page_url('taxes', __FILE__));
$companies->add( trans('Add Tax Rate', 'stk'), get_page_url('taxes&action=add', __FILE__));

$templates = $stk->add( trans('Emails', 'stk'), get_page_url('templates', __FILE__));
$templates->add( trans('Templates', 'stk'), get_page_url('templates', __FILE__));
$templates->add( trans('Add Template', 'stk'), get_page_url('templates&action=add', __FILE__));