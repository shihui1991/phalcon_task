<?php

$router = $di->getRouter();

// Define your routes here
$router->addGet(
    '/',
    [
        'ControllerInit' => 'index',
        'action' => 'index',
    ]
);

$router->handle();
