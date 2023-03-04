<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/all-leihgabe', 'Leihgabe::alleLeihgaben');
$routes->get('/add-leihgabe', 'Leihgabe::leihgabeErstellen');
$routes->get('/add-gegenstand-to-leihgabe/(:any)', 'Leihgabe::gegenstandHinzufuegen/$1/$2');
$routes->get('/show-leihgabe/(:segment)', 'Leihgabe::LeihgabeAnzeigen/$1');

$routes->get('/all-gegenstande', 'Gegenstand::registrierteGegenstande');
$routes->get('/add-gegenstand', 'Gegenstand::gegenstandRegistrieren');
$routes->get('/add-gegenstand/(:any)', 'Gegenstand::gegenstandRegistrieren/$1/$2');
$routes->match(['get', 'post'], '/show-gegenstand/(:segment)', 'Gegenstand::gegenstandAnzeigen/$1');
$routes->get('/edit-gegenstand/(:any)', 'Gegenstand::barcodeBearbeiten/$1/$2');
$routes->get('/gegenstand-zurueckgeben', 'Gegenstand::gegenstandZurueckgeben');
$routes->get('/gegenstand-zurueckgeben/(:any)', 'Gegenstand::gegenstandZurueckgeben/$1');

$routes->get('/all-schueler', 'Schueler::registrierteSchueler');
$routes->match(['get', 'post'], '/add-schueler/(:segment)', 'Schueler::schuelerHinzufuegen/$1');
$routes->match(['get', 'post'], '/add-temp-schueler', 'Schueler::tempSchuelerHinzufuegen');
$routes->match(['get', 'post'], '/add-temp-schueler/(:any)', 'Schueler::tempSchuelerHinzufuegen/$1');
$routes->match(['get', 'post'], '/show-schueler/(:segment)', 'Schueler::schuelerAnzeigen/$1');
$routes->get('/edit-schueler/(:any)', 'Schueler::schuelerausweisBearbeiten/$1/$2');
$routes->get('/schuelerdaten-anzeigen', 'Schueler::schuelerScannen');
$routes->get('/schuelerdaten-anzeigen/(:any)', 'Schueler::schuelerScannen/$1');


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
