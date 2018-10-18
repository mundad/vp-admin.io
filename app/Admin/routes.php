<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/company','CompanyController');
    $router->resource('/city','ComCityController');
    $router->resource('/service_type','ServiceTypeController');
    $router->resource('/part','PartController');
    $router->resource('/com_dep','ComDepController');
    $router->resource('/com_service','ComServiceController');
    $router->resource('/product','ProductController');
    $router->resource('/sale','SaleController');
    $router->resource('/client','ClientController');
    $router->resource('/client_cart','SaleProductClientController');
});
