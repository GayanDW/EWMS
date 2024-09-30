<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/generator', 'EwasteGenerator::index');
$routes->get('web/register_ewastecollector', 'Web::register_ewastecollector');
$routes->post('web/save_ewaste_collector', 'Web::save_ewaste_collector');
$routes->get('web/register_ewasterecycler', 'Web::register_ewasterecycler');
$routes->post('web/save_ewaste_recycler', 'Web::save_ewaste_recycler');
$routes->get('web/thank_you', 'Web::thank_you');
$routes->get('web/thank_you', 'Sys::thank_you');
$routes->post('sys/submitEwaste', 'Sys::submitEwaste');
$routes->get('e-waste-collector', 'Sys::displayEwasteListings');
$routes->get('/bidding-form', 'Sys::biddingForm');
$routes->post('/bidding_form', 'Sys::biddingForm');

$routes->get('/bidding-form/(:num)', 'Sys::displayBiddingForm/$1');

$routes->post('sys/saveBid/(:num)', 'Sys::saveBid/$1');
$routes->get('sys/withdrawBid/(:num)', 'Sys::withdrawBid/$1');
$routes->get('sys/viewBidsewc/(:num)', 'Sys::viewBidsewc/$1');

$routes->get('/collect-item/(:num)', 'Sys::collectItem/$1');
$routes->post('sys/submitInventoryUpdate', 'Sys::submitInventoryUpdate');
$routes->get('/sys/viewEwcInventory', 'Sys::viewEwcInventory');
$routes->post('/sys/publishInventoryItem/(:num)', 'Sys::publishInventoryItem/$1');
$routes->get('/sys/unpublishInventoryItem/(:num)', 'Sys::unpublishInventoryItem/$1');
$routes->post('sys/submitEwaste', 'Sys::submitEwaste');
$routes->post('sys/ewrSubmitBid/(:num)', 'Sys::ewrSubmitBid/$1');
$routes->get('dashboard-summary', 'DashboardController::dashboardSummary');
$routes->get('/sys/cancelDeal/(:num)', 'Sys::cancelDeal/$1');

$routes->get('sys/viewNotifications/(:num)', 'Sys::viewNotifications/$1');
$routes->get('sys/viewNotifications', 'Sys::viewNotifications');
$routes->post('sys/editListing/(:num)', 'Sys::editListing/$1');
$routes->get('sys/handleNotification/(:num)/(:num)', 'Sys::handleNotification/$1/$2');
$routes->get('sys/viewBidsOneItem/(:num)', 'Sys::viewBidsOneItem/$1');
$routes->post('sys/publish', 'Sys::publish');
$routes->post('sys/submitInventoryUpdate', 'Sys::submitInventoryUpdate');
$routes->get('sys/viewListingSetItems/(:num)', 'Sys::viewListingSetItems/$1');
$routes->post('sys/updateEwrInv/(:num)', 'Sys::updateEwrInv/$1');
$routes->post('sys/recycling-summary', 'RecyclingSummary::submitMonthlySummary');
$routes->get('sys/downloadFile/(:any)', 'FilesController::downloadFile/$1');
$routes->post('sys/graApproval/(:num)', 'Sys::graApproval/$1');

$routes->get('/sys/editCategory/(:num)', 'Sys::editCategory/$1');
$routes->post('/sys/updateCategory', 'Sys::updateCategory');
$routes->get('/sys/deleteCategory/(:num)', 'Sys::deleteCategory/$1');
$routes->get('/sys/listDeletedCategories', 'Sys::listDeletedCategories');
$routes->get('/sys/restoreCategory/(:num)', 'Sys::restoreCategory/$1');
$routes->get('/sys/permanentlyDeleteCategory/(:num)', 'Sys::permanentlyDeleteCategory/$1');

$routes->get('/sys/viewBidsewc/(:num)', 'Sys::viewBidsewc/$1');





$routes->get('prac/welcome', 'Prac::welcome');









/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
