<?php
require_once __DIR__ . '/../app/bootstrap.php.cache';
require_once __DIR__ . '/../app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';


use Symfony\Component\HttpFoundation\Request;

if (@$_SERVER['HTTP_HOST'] == 'symfony-madrid.local') {
    $kernel = new AppKernel('dev', true);
    $kernel->loadClassCache();
}
else {
    $kernel = new AppKernel('prod', false);
    $kernel->loadClassCache();
//$kernel = new AppCache($kernel);
}

$kernel->handle(Request::createFromGlobals())->send();