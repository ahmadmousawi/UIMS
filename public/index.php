<?php
/**
 * Created by PhpStorm.
 * User: Fareed
 * Date: 11/30/2015
 * Time: 16:23
 */
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
try {
// Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();
// Create a DI
    $di = new FactoryDefault();
//Setup a DB connection
    $di->set('db', function () {
        return new DbAdapter(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "",
            "dbname" => "UIMS"
        ));
    });

// Setup the view component
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/views/');
        return $view;
    });
// Setup a base URI so that all generated URIs include the "test" folder
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/test/');
        return $url;
    });
// Handle the request
    $application = new Application($di);
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}
?>