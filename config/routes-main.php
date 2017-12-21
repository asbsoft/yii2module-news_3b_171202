<?php
//!! routes do not inherit
// route without prefix => controller/action without current (and parent) module(s) IDs
return [
    // here in news_3b_171202:
    'tag/<id:\d+>'                => 'main/list-for-tag',
    
    //!! select only one version of parent's routes:
//*
    // routes from news_2b_161124:
    'view/<id:\d+>'               => 'main/view',         // must be before
    'view/<slug:[a-z0-9\-]+>'     => 'main/view-by-slug', // must be after
    '<action:(list)>/<page:\d+>'  => 'main/<action>',
    '<action:(index|list)>'       => 'main/<action>',
    '?'                           => 'main/index',
/**/
/*
    // routes from news_1b_160430:
    '<action:(view)>/<id:\d+>'    => 'main/<action>',
    '<action:(list)>/<page:\d+>'  => 'main/<action>',
    '<action:(index|list)>'       => 'main/<action>',
    '?'                           => 'main/index', // without URL-normalizer
/**/
];
