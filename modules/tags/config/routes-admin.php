<?php
// route without prefix => controller/action without current (and parent) module(s) IDs
return [
/*
    // default routes:
    '<action:(view|update|delete)>/<id:\d+>'    => 'admin/<action>',
    '<action:(index)>/<page:\d+>'               => 'admin/<action>',
    '<action:(index|create)>'                   => 'admin/<action>',
*/
    'article/<action:(add|del)>/<id:\d+>'       => 'admin-article/<action>',

    // example of redefined routes:
    'see/<id:\d+>'                              => 'admin/view',
    'edit/<id:\d+>'                             => 'admin/update',
    'kill/<id:\d+>'                             => 'admin/delete',
    'list/<page:\d+>'                           => 'admin/index',
    'list'                                      => 'admin/index',
    'new'                                       => 'admin/create',
    ''                                          => 'admin/index',
];
