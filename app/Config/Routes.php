<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Projects');
$routes->setDefaultMethod('listPage');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Web pages
$routes->get('/', 'Projects::listPage');
$routes->get('/projects', 'Projects::listPage');
$routes->get('/projects/(:num)', 'Projects::objectPage/$1');

$routes->get('/reports/trial-balance','Reports::trialBalance');
$routes->get('/reports/pnl','Reports::profitLoss');
$routes->get('/reports/balance-sheet','Reports::balanceSheet');
$routes->get('/reports/gstr1','Reports::gstr1');
$routes->get('/reports/gstr3b','Reports::gstr3b');

// API group
$routes->group('api', static function($routes){
    $routes->get('clients', 'Api\Clients::index');
    $routes->post('clients', 'Api\Clients::create');

    $routes->get('projects', 'Api\Projects::index');
    $routes->post('projects', 'Api\Projects::create');
    $routes->get('projects/(:num)', 'Api\Projects::show/$1');
    $routes->post('projects/(:num)/milestones', 'Api\Projects::addMilestone/$1');

    $routes->get('materials', 'Api\Materials::index');
    $routes->post('materials', 'Api\Materials::create');

    $routes->post('po', 'Api\Procurement::createPO');
    $routes->post('grn', 'Api\Inventory::grn');

    $routes->post('invoices', 'Api\Finance::createInvoice');
    $routes->post('receipts', 'Api\Finance::createReceipt');

    $routes->post('invoice/(:num)/post-ledger','Api\FinanceExt::postInvoiceToLedger/$1');
    $routes->post('receipt/(:num)/post-ledger','Api\FinanceExt::postReceiptToLedger/$1');

    $routes->post('design-assets/presign', 'Api\Design::presign');
});
