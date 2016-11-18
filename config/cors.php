<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |

     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['http://innovaservineg.com/'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['POST','GET'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
];

