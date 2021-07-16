<?php

return [
    'skip-route-function' => true,
    'groups' => [
        'admin' => ['admin.*', 'frontend.*'],
        'frontend' => ['frontend.*']
    ]
];
