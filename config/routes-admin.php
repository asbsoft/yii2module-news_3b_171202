<?php
//!! routes do not inherit
// route without prefix => controller/action without current (and parent) module(s) IDs
return [
    // here in news_3b_171202:
    '<action:(test-ext)>'               => 'admin/<action>',

    //!! select only one version of parent's routes:
//*
    // routes from news_2b_161124:
    '<action:(view|update|delete|change-visible|export)>/<id:\d+>'
                                        => 'admin/<action>',
    '<action:(index)>/<page:\d+>'       => 'admin/<action>',
    '<action:(index|create|import)>'    => 'admin/<action>',
    'el-finder/connector/<id:\d+>'      => 'el-finder/connector',
    '?'                                 => 'admin/index',
/**/
/*
    // routes from news_1b_160430:
    '<action:(view|update|delete|change-visible)>/<id:\d+>' => 'admin/<action>',
    '<action:(index)>/<page:\d+>'                           => 'admin/<action>',
    '<action:(index|create)>'                               => 'admin/<action>',
    'el-finder/<action:(connect|manager)>/<id:\d+>'         => 'el-finder/<action>',
    '?'                                                     => 'admin/index', // without URL-normalizer: no '' - never routes from root
/**/
];
