?<?php

// app/Http/Kernel.php

class Kernel
{
    protected $routeMiddleware = [
        // ...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];

}