<?php

return [
    '' => [
        'controller' => 'task',
        'action' => 'index',
    ],
    'edit/{id:\d+}' => [
        'controller' => 'task',
        'action' => 'edit'
    ],
    'add' => [
        'controller' => 'task',
        'action' => 'add'
    ],
    'login' => [
        'controller' => 'auth',
        'action' => 'login'
    ],

    'logout' => [
        'controller' => 'auth',
        'action' => 'logout'
    ]
];