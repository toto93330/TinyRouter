<?php

use Anthony\Router\Router;
use Anthony\Router\Controller\Controller;


include_once('../src/Router.php');
include_once('../vendor/autoload.php');

$route = new Router();


/////
// Pour un truc plus propre je pourrais inclure mes routes dans un fichier route.php dans un dossier racine de mon site (exemple config) mais osef c'est à vous de voir ^^
/////
$route->addRoute('GET', 'home', '/', function () {
    $controller = new Controller;
    return $controller->Home();
});

$route->addRoute('GET', 'articles', '/articles/[i:date]/[*:slug]', function ($date, $slug) {
    $controller = new Controller;
    return $controller->Article($date, $slug);
});

$route->addRoute('GET', 'delectarticle', '/article/[i:id]/delect', function ($id) {
    $controller = new Controller;
    return $controller->Delect($id);
});

$route->addRoute('GET', '404', '/erreur-404', function () {
    $controller = new Controller;
    return $controller->Error();
});

//

if ($route->verifRoute() === null || $route->verifRoute() === false) {
    header('location: /404', 404);
}

$route->render();
