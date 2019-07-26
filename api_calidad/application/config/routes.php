<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'obra';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['causales']['get'] = 'causales/index';
$route['causales/(:any)']['get'] = 'causales/find/$1';
$route['causales']['post'] = 'causales/index';
$route['causales/(:num)']['put'] = 'causales/index/$1';
$route['causales/(:num)']['delete'] = 'causales/index/$1';

$route['solicitudes']['get'] = 'solicitudes/index';
$route['solicitudes/(:any)']['get'] = 'solicitudes/find/$1';
$route['solicitudes']['post'] = 'solicitudes/index';
$route['solicitudes/(:num)']['put'] = 'solicitudes/index/$1';
$route['solicitudes/(:num)']['delete'] = 'solicitudes/index/$1';

$route['solicitudestados/(:any)']['get'] = 'solicitudestados/find/$1';
$route['solicitudestados/(:num)']['put'] = 'solicitudestados/index/$1';
$route['solicitudestados/(:num)']['delete'] = 'solicitudestados/index/$1';

$route['solicitudesrecurso/(:any)']['get'] = 'solicitudesrecurso/find/$1';
$route['solicitudeshistorial/(:any)']['get'] = 'solicitudeshistorial/find/$1';

$route['graficos/(:any)']['get'] = 'graficos/find/$1';

$route['viviendapiloto']['post'] = 'viviendapiloto/index';
$route['viviendapiloto/(:any)']['get'] = 'viviendapiloto/find/$1';
$route['viviendapiloto/(:num)']['delete'] = 'viviendapiloto/index/$1';
$route['viviendapiloto/(:num)']['put'] = 'viviendapiloto/index/$1';

$route['viviendapilotocantidad/(:num)']['get'] = 'viviendapilotocantidad/find/$1';
$route['viviendapilotograficos/(:any)']['get'] = 'viviendapilotograficos/find/$1';
$route['viviendapilotoestados/(:num)']['get'] = 'viviendapilotoestados/find/$1';




/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
/*$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; //
Example 8 */
