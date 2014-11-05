<?php

return array(

    'multi' => array(
        'account' => array(
            'driver' => 'eloquent',
            'model' => 'Account'
        ),
        'user' => array(
            'driver' => 'database',
            'table' => 'users'
        ),
        'admin' => array(
            'driver' => 'database',
            'table' => 'admin'
        ),
    ),

    'reminder' => array(

        'email' => 'emails.auth.reminder',

        'table' => 'password_reminders',

        'expire' => 60,

    ),

);
